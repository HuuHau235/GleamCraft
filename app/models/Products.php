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

    // Lấy sản phẩm theo ID
    public function getProductById($id)
    {
        $sql = "SELECT * FROM products WHERE product_id = ?";
        $result = $this->executeQuery($sql, [$id], "i");
        return $result->fetch_assoc();
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
    

    // Bộ lọc 
    public function getFilteredProducts($filters) {
        $query = "SELECT * FROM Products";
        $conditions = [];
        $params = [];
        $params_price = [];

        // Thêm điều kiện nếu có bộ lọc
        if (!empty($filters['gender'])) {
            $conditions[] = "gender = ?";
            $params[] = $filters['gender'];
        }

        if (!empty($filters['type_name'])) {
            $conditions[] = "type_name = ?";
            $params[] = $filters['type_name'];
        }

        if (!empty($filters['color'])) {
            $conditions[] = "color = ?";
            $params[] = $filters['color'];
        }
        
        if (!empty($filters['price_range'])) {
            [$min, $max] = explode('-', $filters['price_range']);
            $conditions[] = "price BETWEEN ? AND ?";
            $params_price[] = $min;
            $params_price[] = $max;
        }

        // Thêm điều kiện vào query
        if ($conditions) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }

        
        $stmt = $this->conn->prepare($query);

        // Gán giá trị tham số vào câu lệnh
        if (!empty($params)) {
            $stmt->bind_param(str_repeat('s', count($params)), ...$params); 
        }
        
        // Gán tham số price với kiểu dữ liệu dd cho 2 giá trị min và max
        if (!empty($params_price)) {
            $stmt->bind_param('dd', $params_price[0], $params_price[1]);
        }

        
        $stmt->execute();
        $result = $stmt->get_result();

        
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>