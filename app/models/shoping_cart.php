<?php
require_once '../../config/db.php';

class ShoppingCart {
    private $conn;
    public function __construct($conn) {
        $this->conn = $conn;
    }
    public function getProduct($name, $price, $image, $description) {
        try {
            $query = "SELECT name, image, price, description FROM products WHERE name = :name";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->execute();
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            return $product ?: null; 
        } catch (PDOException $e) {
            // Log lỗi thay vì in ra màn hình
            error_log("Database error: " . $e->getMessage());
            return null;
        }
    }
}
?>
