<?php

class Cart {

    /**
     * Array of cart items
     *
     * @var array
     */
    protected $items = array();

    private $db;

    /**
     * Initiates database connection
     *
     * @param $db
     */
    public function __construct($db)
    {
        $this->db = $db;

        if (! isset($_SESSION['cart'])) $_SESSION['cart'] = array();

        $this->update();

    }

    /**
     * Add product to cart
     *
     * @param $id
     * @param $quantity
     * @param $toppings
     */
    public function addProduct($id, $quantity, $toppings) {

        $Products = new Products($this->db);

        // If the user clicked the add to cart button on the product page we can check for the form data
        if (isset($id, $quantity, $toppings) && is_numeric($id) && is_numeric($quantity) && is_array($toppings)) {

            //checking if the product exists in our database
            $product = $Products->getItem($id);

            // Check if the product exists (array is not empty)
            if ($product && $quantity > 0) {
                // Product exists in database, now we can create/update the session variable for the cart
                $newItem = [
                    'id' => $id,
                    'chosen_toppings' => $toppings,
                    'quantity' => $quantity
                ];

                // check if item is same as items in cart
                if ( ! $this->isSame($newItem) || count($this->items) == 0 ) {
                    array_push($_SESSION['cart'], $newItem);
                }

            }
            else
                die('error');

            $this->update();

            // Prevent form resubmission...
            die($this->formatForJS($this->items));
        }

     }

    public function removeProduct($id) {

        // Remove the product from the shopping cart
        unset($_SESSION['cart'][$id]);
        $this->update();
        die($this->formatForJS($this->items));

    }

    private function updateProduct($cart_id, $quantity) {
        $_SESSION['cart'][$cart_id]['quantity'] = $quantity;
    }

    /**
     * Fetch all Cart items
     *
     * @return array $items
     */
    public function getAll() {
        return $this->items;
    }

    /**
     * @param $id
     * @return array
     */
    public function getItem($id) {
        return $this->items[$id];
    }

    /**
     * Empty Cart
     *
     */
    public function removeAll() {
        unset($_SESSION['cart']);
        $this->update();
    }

    /**
     * Count all products in cart
     *
     * @return int
     */
    public function count() {
        $items_in_cart = 0;

        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $key => $value) {
                $items_in_cart += $value['quantity'];
            }
        }

        return $items_in_cart;
    }

    public function update() {
        $this->items = $_SESSION['cart'];
    }

    /**
     * Check if toppings are same
     *
     * @param $item
     * @return array|bool
     */
    public function isSame($item) {
        $ids = array_column($this->items, 'id');
        $item_exist = array_search( $item['id'], $ids);

        // there are no items with same id
        if ( ! is_int($item_exist) ) {
            return false;
        }

        //checking if toppings are same
        foreach ($this->items as $cart_id => $cartItem) {
            if ($cartItem['id'] == $item['id']) {

                //items are same
                if (array_diff_assoc($cartItem['chosen_toppings'], $item['chosen_toppings']) == array() && array_diff_assoc($item['chosen_toppings'], $cartItem['chosen_toppings']) == array()) {
                    //check if quantity is same
                    if ($cartItem['quantity'] != $item['quantity']) $this->updateProduct($cart_id, $item['quantity']);
                        return true;
                }
            }
        }

        // new item is different, so we can add it to cart
        return false;

    }

    public function formatForJS($items) {
        $array = [];

        foreach ($items as $cart_item => $item) {
            $array[$cart_item] = $item['quantity'];
        }

        return json_encode($array);
    }

}
