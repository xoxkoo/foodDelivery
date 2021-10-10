<?php


class Order
{

    private $db;

    private $order = array();

    public function __construct($db) {
        $this->db = $db;
        $this->order;
    }

    public function validate($data, $cart) {
        $Cart = new Cart($this->db);

        if (!$Cart->count()) {
            flash()->warning('Košík je prázdny!');
            return false;
        }

        $this->order = $data;
        $this->order['items'] = $cart;
        $this->order['town'] = (int)$this->order['town'];

        if (! is_int( $this->order['town'] ) || $this->order['town'] === 0 )
            flash()->warning('Zvoľte miesto doručenia!');

        // check number
        if (preg_match('#^[0-9][+]{10}$#', $this->order['phone']) === 1) {
            flash()->warning('Zadajte správne telefónne číslo!');
        }

        if (! filter_var($this->order['email'], FILTER_VALIDATE_EMAIL)) {
            flash()->warning('Zadaný email nie je správny!');
        }

        if (flash()->hasMessages()) return false;
        else return true;

    }

    public function create() {

        if (count($this->order)) {
            
    //            $customer = $this->checkCustomer();
            $user = $this->checkUser();

            // create customer
//            $db_id = $this->createCustomer($customer, $user);

            $town = $this->getTown($this->order['town']);

            $this->db->insert('orders', [
                "user_id" => $user,
                "status_code" => 1,
                "email" => $this->order['email'],
                "phone" => $this->order['phone'],
                "address" => $town . ' ' . $this->order['address'],
                "note" => $this->order['note']
            ]);

            $order_id = $this->db->id();

            if ($order_id)
                $err = $this->addItems($order_id);
            else
                return false;

            if ($err) {
                $this->removeOrder($order_id);
                return false;
            }

            $_SESSION['cart'] = array();

            return true;

        }
        else
            return false;
    }

    private function checkCustomer() {
        // check if customer exists with email
        $customer = $this->db->get('customers', ["customer_id", "address", "email", "phone"], [
            "email" => $this->order['email']
        ]);

        return $customer;
    }

    private function checkUser() {
        // check if customer has account
        return $this->db->get('users', "id", [
            "email" => $this->order['email']
        ]);
    }

    private function createCustomer($customer, $user) {
        $town = $this->getTown($this->order['town']);

        if (! $customer) {
            $this->db->insert('customers', [
                "user_id" => $user,
                "email" => $this->order['email'],
                "phone" => $this->order['phone'],
                "address" => $town . ' ' . $this->order['address'],
//                    "zip" => $this->order['zipCode']
            ]);
        } else {
            $this->db->update('customers', [
                "user_id" => $user,
                "email" => $this->order['email'],
                "phone" => $this->order['phone'],
                "address" => $town['name'] . ' ' . $this->order['address'],
//                    "zip" => $this->order['zipCode']
            ], [
                "customer_id" => $customer
            ]);
        }

        return $this->db->id();

    }

    private function addItems($order_id) {
        $err = false;

        foreach ($this->order['items'] as $product) {

            $this->db->insert('order_items', [
                "order_id" => $order_id,
                "product_id" => $product['id'],
                "quantity" => $product['quantity'],
                "chosen_toppings" => implode($product['chosen_toppings'], ",")
            ]);

            if (! $this->db->id()) {
                $err = true;
                break;
            }

        }

        return $err;
    }

    public function getOrders($status, $row = 0, $limit = 2) {
        if (! $status) {
            return $this->db->select("orders", [
                "[>]order_status" => ["status_code" => "status_code"]
            ], "*", [
                "LIMIT" => ["$row", "$limit"],
                "ORDER" => ['created_at' => 'DESC']
            ]);
        }
        else {
            return $this->db->select("orders", [
                "[>]order_status" => ["status_code" => "status_code"]
            ], "*", [
                "orders.status_code" => $status,
                "LIMIT" => ["$row", "$limit"],
                "ORDER" => ['created_at' => 'ASC']

            ]);
        }

    }

    private function getTown($town) {
        return $this->db->get('towns', "name", [
            "id" => $town
        ]);
    }

    public function getItems($id) {
        return $this->db->select("order_items", "*", [
            "order_id" => $id
        ]);
    }

    public function formatOrder($order) {
        $order['created_at'] = date( 'd. m. Y, G:i', strtotime($order['created_at']) );

        if ( !isset($order['updated_at']))
            $order['updated_at'] = '-';
        else
            $order['updated_at'] = date( 'd. m. Y,  G:i', strtotime($order['updated_at']) );

        $order['link'] = BASE_URL . 'order_page.php?order=' . $order['id'];

        return json_decode(json_encode( $order ));
    }

    public function getOrder($id) {
        $order = $this->db->select("orders", [
            "[>]order_status" => ["status_code" => "status_code"]
        ], "*", [
            "orders.id" => $id
        ]);

        if ($order)
            return $order[0];
        else
            return array();
    }

    public function count($status) {
        if ($status) {
            return $this->db->count("orders", [
                "status_code" => $status
            ]);
        }
        else {
            return $this->db->count("orders");
        }
    }

    public function count_by_User($id) {
        return $this->db->count("orders", [
            "user_id" => $id
        ]);
    }

    public function removeOrder($id) {
        $this->db->delete('orders', [
            'id' => $id
        ]);

        $this->db->delete('order_items', [
            'order_id' => $id
        ]);
    }

    public function seen($order) {
        if ($order->status_code == (int)1) {
            $id = $this->db->update("orders", [
                "status_code" => 2
            ], [
                "id" => $order->id
            ]);
        }
    }

    public function finish($id) {
        $this->db->update("orders", [
            "status_code" => 3
        ], [
            "id" => $id
        ]);
    }

    public function getTowns() {
        return $this->db->select('towns', '*');
    }

    public function getOrders_by_User($user, $row, $limit) {
        return $this->db->select("orders", [
            "[>]order_status" => ["status_code" => "status_code"]
        ], "*", [
                "LIMIT" => ["$row", "$limit"],
                "user_id" => $user,
                "ORDER" => ['created_at' => 'DESC']
        ]);
    }

}