<?php

namespace App\Models;

class Product {
    private $db;

    public function __construct() {
        // Kết nối cơ sở dữ liệu bằng MySQLi
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
        
        // Kiểm tra nếu có dữ liệu
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
        $stmt->bind_param("i", $id);  // Bind ID vào câu truy vấn
        $stmt->execute();
        
        $result = $stmt->get_result();
        // Kiểm tra nếu có dữ liệu
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null; // Trả về null nếu không tìm thấy sản phẩm
        }
    }
    // Lấy các sản phẩm liên quan từ cùng bảng (ví dụ: lấy 4 sản phẩm ngẫu nhiên)
    public function getRelatedProducts() {
        $query = "SELECT * FROM products ORDER BY RAND() LIMIT 4";  // Lấy 4 sản phẩm ngẫu nhiên
        $result = $this->db->query($query);
        
        // Kiểm tra nếu có dữ liệu
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return []; // Trả về mảng rỗng nếu không có sản phẩm liên quan
        }
    }
}
