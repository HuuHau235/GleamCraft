<?php
require_once 'C:\xampp\htdocs\GleamCraft_MVC\app\core\Db.php';  // Bao gồm lớp Db
class Products extends Database
{
    // Phương thức thực thi truy vấn chung
    private function executeQuery($sql, $params = null, $types = null)
    {
        try {
            $stmt = $this->conn->prepare($sql);
            if ($params && $types) {
                $stmt->bind_param($types, ...$params);
            }
            $stmt->execute();
            return $stmt->get_result();
        } catch (Exception $e) {
            throw new Exception("Query execution failed: " . $e->getMessage());
        }
    }

    public function getProductHomepage()
    {
        $sql = "SELECT * FROM products ORDER BY product_id DESC LIMIT 8";
        $result = $this->executeQuery($sql);
        return $result->fetch_all(MYSQLI_ASSOC);  // Lấy tất cả sản phẩm dưới dạng mảng
    }

    public function getProductById($id)
    {
        // Chuẩn bị câu lệnh SQL
        $sql = "SELECT * FROM products WHERE product_id = ?";
        
        // Thực thi truy vấn với tham số id
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);  // "i" là kiểu dữ liệu của id (integer)
        $stmt->execute();
        
        // Lấy kết quả
        $result = $stmt->get_result();
        
        // Kiểm tra nếu có kết quả
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc(); // Trả về sản phẩm
        }
        
        // Nếu không có sản phẩm, trả về null
        return null;
    }
    // Lấy tất cả sản phẩm
    public function getAllProduct()
    {
        $sql = "SELECT * FROM products";
        $result = $this->executeQuery($sql);
        return $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : null;
    }

    // Lấy tất cả reviews
    public function getAllReview()
    {
        $sql = "SELECT * FROM reviews";
        $result = $this->executeQuery($sql);
        return $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : null;
    }

    // Phương thức chung để xóa bản ghi
    private function deleteRecord($table, $column, $id)
    {
        try {
            $sql = "DELETE FROM $table WHERE $column = ?";
            $this->executeQuery($sql, [$id], "i");

            return true; // Xóa thành công
        } catch (Exception $e) {
            return false; // Xóa thất bại
        }
    }

    // Xóa sản phẩm
    public function deleteProducts($product_id)
    {
        return $this->deleteRecord('products', 'product_id', $product_id);
    }

    // Xóa review
    public function deleteReview($review_id)
    {
        return $this->deleteRecord('reviews', 'review_id', $review_id);
    }
    public function updateProducts($product_id, $name, $description, $color, $type_name, $gender, $price, $image)
    {
        $conn = $this->getConnection();

        $sql = "UPDATE products SET name = ?, description = ?, color = ?, type_name = ?, gender = ?, price = ?, image = ? WHERE product_id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssssdss', $name, $description, $color, $type_name, $gender, $price, $image, $product_id);

        $result = $stmt->execute();
        $stmt->close();
        $conn->close();

        return $result;
    }

    // Lấy tất cả review của một user
    public function addReview($data)
    {
        $conn = $this->getConnection();
        $sql = "INSERT INTO reviews (user_id, review_text, created_at) VALUES (?, ?, ?)";
    
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iss', $data['user_id'], $data['review_text'], $data['created_at']);
    
        $result = $stmt->execute();
        $stmt->close();
        $conn->close();
    
        return $result;
    }
}
?>