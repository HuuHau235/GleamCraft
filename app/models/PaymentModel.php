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
        $sql = "SELECT SUM(product_price * quantity) AS total FROM cart WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'] ?? 0; // Trả về 0 nếu giỏ hàng rỗng
    }

    public function createOrder($user_id, $name, $address, $phone, $note) {
        $total = $this->getTotal($user_id);
        if ($total <= 0) {
            throw new Exception("Cart is empty, order cannot be created.");
        }

        $sql = "INSERT INTO Orders (user_id, total_price, customer_name, customer_address, customer_phone, customer_note) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('idssss', $user_id, $total, $name, $address, $phone, $note);
        $stmt->execute();
        return $this->conn->insert_id; // Trả về ID của đơn hàng mới
    }

    public function processPayment($order_id, $total_amount) {
        $sql = "INSERT INTO Payments (order_id, total_amount, payment_date) 
                VALUES (?, ?, NOW())";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('id', $order_id, $total_amount);
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
