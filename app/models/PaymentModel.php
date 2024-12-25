<?php
class PaymentModel {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli('localhost', 'root', '', 'gleamcraft');
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getCartItems($user_id) {
        $sql = "SELECT * FROM cart WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getTotal($user_id) {
        $sql = "SELECT SUM(product_price * quantity) as total FROM cart WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'];
    }

    public function createOrder($user_id, $name, $address, $phone, $note, $payment_method) {
        $sql = "INSERT INTO Orders (user_id, total_price, customer_name, customer_address, customer_phone, customer_note) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $total = $this->getTotal($user_id);
        $stmt->bind_param('idssss', $user_id, $total, $name, $address, $phone, $note);
        $stmt->execute();
        return $this->conn->insert_id; // Trả về ID của đơn hàng mới
    }

    public function processPayment($order_id, $payment_method) {
        $sql = "INSERT INTO Payments (order_id, payment_method, payment_status, payment_date) 
                VALUES (?, ?, 'completed', NOW())";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('is', $order_id, $payment_method);
        $stmt->execute();
    }

    public function clearCart($user_id) {
        $sql = "DELETE FROM cart WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
    }
}
?>
