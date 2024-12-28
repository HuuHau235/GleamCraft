<?php
require_once 'C:\xampp\htdocs\GleamCraft_MVC\app\core\Db.php';  // Bao gồm lớp Db

class Products extends Database {
    // Hậu
    public function getProductHomepage() {
        $sql = "
            SELECT * 
            FROM products
            ORDER BY product_id DESC
            LIMIT 8;    
        ";
        $result = mysqli_query($this->conn, $sql);

        if (!$result) {
            die('Query failed: ' . mysqli_error($this->conn));  // Kiểm tra lỗi truy vấn
        }

        return mysqli_fetch_all($result, MYSQLI_ASSOC);  // Lấy tất cả sản phẩm dưới dạng mảng
    }
    public function getProductById($id) {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE product_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Thiện
}
?>
