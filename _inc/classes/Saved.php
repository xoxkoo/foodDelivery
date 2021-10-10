<?php


class Saved
{

    private $db;

    public $items;
    private $user;
    private $user_id;

    /**
     * Initiates database connection
     *
     * @param $db
     */
    public function __construct($db)
    {
        $this->db = $db;
        $this->user = new User($db);
        $this->user_id = ($this->user->is_logged()) ? $this->user->getUserId() : 0;

        if (! isset($_SESSION['saved'])) $_SESSION['saved'] = array();

        $this->items = $_SESSION['saved'];

        $this->getFromDB();

    }

    public function addProduct($id, $quantity = 1) {

        $Products = new Products($this->db);

        if (isset($id, $quantity) && is_numeric($id) && is_numeric($quantity)) {

            //checking if the product exists in our database
            $product = $Products->getItem($id);

            // Check if the product exists (array is not empty)
            if ($product && $quantity > 0) {
                // Product exists in database, now we can create/update the session variable
                if (isset($_SESSION['saved']) && is_array($_SESSION['saved'])) {
                    // Add it
                    $_SESSION['saved'][$id] = $quantity;
                } else {
                    $_SESSION['saved'][$id] = $quantity;
                }
            }

            $this->update();

            // Prevent form resubmission...
            die (json_encode($_SESSION['saved']));
        }

    }

    public function removeProduct($id) {

        // Remove the product from saved items
        unset($_SESSION['saved'][$id]);
        $this->update();

        die( json_encode($_SESSION['saved']) );
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
     * @return bool|mixed
     */
    public function getItem($id) {

        if (isset($this->items[$id]))
            return $this->items[$id];
        else
            return false;
    }

    /**
     * Empty Cart
     *
     */
    public function removeAll() {
        $_SESSION['saved'] = array();
        $this->update();
    }

    /**
     * Count all products in cart
     *
     * @return int
     */
    public function count() {
        $items_in_cart = 0;
        if (isset($_SESSION['saved'])) {
            foreach ($_SESSION['saved'] as $quantity) {
                $items_in_cart += $quantity;
            }

        }

        return $items_in_cart;
    }

    private function update() {
        $this->items = $_SESSION['saved'];

        if ($this->user_id !== 0)
            $this->updateDB();
    }

    private function getFromDB() {

        $user = $this->db->get('user_saved', 'user_id', ['user_id' => $this->user_id]);
        $items = (array) json_decode($this->db->get('user_saved', 'items', ['user_id' => $this->user_id]));

        if ($this->user_id !== 0 && $user) {

            if ( $_SESSION['saved'] === array()) {
                $_SESSION['saved'] = $items;
                $this->items = $_SESSION['saved'];
            }

            if (count(array_diff_assoc($items, $this->items)) || count(array_diff_assoc($this->items, $items))) {
                $this->items = $items;
                $_SESSION['saved'] = $items;
            }
        }

    }

    private function updateDB() {

        if (! $this->db->get('user_saved', 'user_id', ['user_id' => $this->user_id])) {
            $this->db->insert('user_saved', [
                'user_id' => $this->user_id,
                'items' => json_encode($this->items)
            ]);
        }
        else {
            $this->db->update('user_saved', [
                'user_id' => $this->user_id,
                'items' => json_encode($this->items)
            ]);
        }

    }


}