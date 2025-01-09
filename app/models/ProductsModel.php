<?php
require_once 'C:\xampp\htdocs\GleamCraft_MVC\app\core\Db.php';  // Bao gồm lớp Db
class ProductsModel extends Database
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
        $sql = "SELECT * FROM products ORDER BY RAND() LIMIT 8";
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
    public function searchProductsByName($query)
    {
        global $conn;
        $sql = "SELECT * FROM products WHERE name LIKE ?";
        $stmt = $conn->prepare($sql);
        $searchTerm = "%" . $query . "%";  // Thêm dấu phần trăm để tìm kiếm theo tên sản phẩm
        $stmt->bind_param("s", $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getRelatedProduct()
    {
        $sql = "SELECT * FROM products ORDER BY RAND() LIMIT 4";
        $result = $this->executeQuery($sql);
        return $result->fetch_all(MYSQLI_ASSOC);  
    }
    
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
    // Bộ lọc sản phẩm
    public function getFilteredProducts($filters) {
        $query = "SELECT * FROM Products";
        $conditions = [];
        $params = [];
        $types = "";
    
        if (!empty($filters['gender'])) {
            $conditions[] = "gender = ?";
            $params[] = $filters['gender'];
            $types .= "s";
        }
    
        if (!empty($filters['type_name'])) {
            $conditions[] = "type_name = ?";
            $params[] = $filters['type_name'];
            $types .= "s";
        }
    
        if (!empty($filters['color'])) {
            $conditions[] = "color = ?";
            $params[] = $filters['color'];
            $types .= "s";
        }
    
        if (!empty($filters['price_range'])) {
            $price_parts = explode('-', $filters['price_range']);
            if (count($price_parts) === 2 && is_numeric($price_parts[0]) && is_numeric($price_parts[1])) {
                $conditions[] = "price BETWEEN ? AND ?";
                $params[] = (float) $price_parts[0];
                $params[] = (float) $price_parts[1];
                $types .= "dd";
            } else {
                throw new Exception("Giá trị khoảng giá không hợp lệ.");
            }
        }
    
        if ($conditions) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }
    
        $stmt = $this->conn->prepare($query);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
    
        $stmt->execute();
        $result = $stmt->get_result();
    
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Research theo tên product 
    public function searchProductByALL($query)
{
    $stmt = $this->conn->prepare("SELECT * FROM products WHERE name LIKE ? OR color LIKE ? OR description LIKE ? OR gender LIKE ? OR type_name LIKE ? OR price LIKE ?");
    $searchTerm = "%" . $query . "%";
    $stmt->bind_param("ssssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm); // Liên kết tất cả các trường với cùng một biến
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC); 
}

}