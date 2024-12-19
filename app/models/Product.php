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
        $query = "SELECT * FROM products ORDER BY RAND() LIMIT 8";
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
    
}
