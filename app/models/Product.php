<?php

namespace App\Models;

class Product {
    private $db;

    public function __construct() {
        // Kết nối cơ sở dữ liệu
        $this->db = new \mysqli('localhost', 'root', '', 'gleamcraft');
        
        // Kiểm tra kết nối
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }

    // Lấy tất cả sản phẩm (dùng cho trang chủ)
    public function getAllProducts() {
        $query = "SELECT * FROM products";
        $result = $this->db->query($query);
        
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }

    // Lấy sản phẩm theo ID (dùng cho trang chi tiết)
    public function getProductById($id) {
        $query = "SELECT * FROM products WHERE product_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    // Lấy các sản phẩm liên quan
    public function getRelatedProducts() {
        $query = "SELECT * FROM products ORDER BY RAND() LIMIT 4";
        $result = $this->db->query($query);
        
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }

    public function addReview($product_id, $user_id, $comment) {
        $query = "INSERT INTO Reviews (product_id, user_id, comment, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("iis", $product_id, $user_id, $comment);
        return $stmt->execute();
    }
    public function getReviewsByProductId($product_id) {
        $query = "SELECT r.comment, r.created_at, u.name AS user_name
          FROM Reviews r
          JOIN Users u ON r.user_id = u.user_id
          WHERE r.product_id = ?
          ORDER BY r.created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $reviews = [];
        while ($row = $result->fetch_assoc()) {
            $reviews[] = $row;
        }
        return $reviews;
    }    
    
}
