<?php

class Products {

    private $db;

    /**
     * Initiates database connection
     *
     * @param $db
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Get stuff about products from db
     *
     * @param $id
     * @return mixed
     */
    public function getItem($id) {

        return $this->db->query("
            SELECT f.*, GROUP_CONCAT(ft.topping_id SEPARATOR ',') as toppings_id, GROUP_CONCAT(t.topping SEPARATOR ', ') as toppings FROM food f
            JOIN food_toppings ft ON (f.id = ft.food_id)
            JOIN toppings t ON (t.id = ft.topping_id)
            WHERE f.id = $id
        ")->fetchAll(PDO::FETCH_ASSOC)[0];

//        return $this->db->select("food", [
//            "[>]food_toppings" => ["id" => "food_id"],
//            "[>]toppings" => ["id" => "toppings_id"],
//        ], "*", [
//            "id" => $id
//        ])[0];

    }

    /**
     * Get all toppings from db
     * @return mixed
     */
    public function getToppings($category) {
        return $this->db->select("toppings", [ "id", "topping" ], [
            "category" => $category
        ]);
    }

    /**
     * Get toppings for item with $id
     *
     * @param $id
     * @return mixed
     */
    public function getToppingsByItem($id) {
        return $this->db->select("food_toppings", "topping_id", [
            "food_id" => $id
        ]);
    }

    private function getToppingByIds($ids) {
        $toppings = [];

        foreach ($ids as $id) {
            $toppings[] = $this->db->get("toppings", ["topping"], [
                "id" => $id
            ])['topping'];
        }

        return implode(', ', $toppings);
    }

    public function getTopping($id) {
        return $this->db->get("toppings", "*", [
            "id" => $id
        ]);
    }

    /**
     * Get only base stuff from db
     *
     * @param $category
     * @return mixed
     */
    public function getAllBase($category) {
        return $this->db->select("food", [ "id", "name", "price", "image", "category" ], [
            "category" => $category
        ]);
    }

    public function getItemBase($id) {
        return $this->db->get("food", [ "id", "name", "price", "image", "category" ], [
            "id" => $id
        ]);
    }

    /**
     * @param $id
     * @return mixed
     */
//    public function getItem($id)
//    {
//        return $this->db->get("food", "*", [
//            "id" => $id
//        ]);
//    }

    /**
     * @param $item
     * @return mixed
     */
    public function format($item) {

        $item['image_link'] = BASE_URL . 'assets/img/products/' . $item['category'] . '/' . $item['image'];

        if (isset($_SESSION['saved'])) {
            foreach ($_SESSION['saved'] as $id => $quantity) {
                if ($id == $item['id']) {
                    $item['saved'] = true;
                }
            }
        }

        if ( isset($item['toppings_id']) && is_string($item['toppings_id']) ) $item['toppings_id'] = explode(",", $item['toppings_id']);

        $item['saved_link'] = (isset($item['saved'])) ? BASE_URL . '_backend/saved.php?remove=' . $item['id'] : BASE_URL . '_backend/saved.php?add=' . $item['id'];

        return json_decode(json_encode($item));
    }

    public function formatOrder($item, $id) {

        $item += $this->getItem($id);

//        $item['cho']
//        $item['toppings'] = $this->getToppingByIds(explode(',', $item['toppings_id']));
//
//        $bonus_toppings = array_diff($item['chosen_toppings'], $item['toppings_id']);
//        $item['toppings_price'] = $this->moneyFormat($this->toppingsPrice($bonus_toppings));
//
//        $item['final_price'] = $item['price'] * $item['quantity'];
//
//        $item['image_link'] = BASE_URL . 'assets/img/products/' . $item['category'] . '/' . $item['image'];

        return json_decode(json_encode($item));
    }

    public function formatCart($item, $cart_id) {
        (! isset($item['id'])) ? $item['id'] = $item['product_id'] : '';
        $item += $this->getItem($item['id']);
        
        $item['cart_id'] = $cart_id;

        if (! is_array($item['chosen_toppings']))
            $item['chosen_toppings'] = explode(',', $item['chosen_toppings']);

        $item['toppings'] = $this->getToppingByIds($item['chosen_toppings']);
        $item['toppings_id'] = explode(',', $item['toppings_id']);

        $bonus_toppings = array_diff($item['chosen_toppings'], $item['toppings_id']);
        $item['toppings_price'] = $this->moneyFormat($this->toppingsPrice($bonus_toppings));

        $item['final_price'] = ( (float)$item['price'] + (float)$item['toppings_price'] ) * (float)$item['quantity'];
        $item['final_price'] = $this->moneyFormat($item['final_price']);
        $item['image_link'] = BASE_URL . 'assets/img/products/' . $item['category'] . '/' . $item['image'];

        return json_decode(json_encode($item));

    }

    private function toppingsPrice($toppings) {
        $price = 0;
        foreach ($toppings as $topping) {
            $price += $this->getTopping($topping)['price'];
        }
        return $price;
    }

    /**
     * Format money to slovak format
     *
     * @param $price
     * @return string
     */
    public function moneyFormat($price) {
        return number_format($price, 2, '.', ' ');
    }

    public function sortToppings($arr1, $arr2) {
        $sorted_arr = [];
        $in_arr = [];
        $not_in_arr = [];

        foreach ($arr1 as $topping) {
            if (in_array($topping['id'], $arr2) ) {
                array_push($in_arr, $topping);
            }
            else {
                array_push($not_in_arr, $topping);
            }
        }

        array_push($sorted_arr, array_merge($in_arr, $not_in_arr));
        
        return $sorted_arr[0];
    }


}
