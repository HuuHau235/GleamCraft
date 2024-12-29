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

    // Lấy sản phẩm trang chủ
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

    public function updateProduct($product_id, $name, $description, $color, $gender, $type_name, $price, $image)
{
    // Ensure the connection is established
    if (!$this->conn) {
        throw new Exception("Database connection not established.");
    }

    // Prepare the SQL statement to update the product
    $sql = "UPDATE products SET name = ?, description = ?, color = ?, gender = ?, type_name = ?, price = ?, image = ? WHERE product_id = ?";
    $stmt = $this->conn->prepare($sql);

    if (!$stmt) {
        throw new Exception("Failed to prepare the query.");
    }

    // Bind the parameters and execute the query
    $stmt->bind_param("sssssisi", $name, $description, $color, $gender, $type_name, $price, $image, $product_id);
    
    if (!$stmt->execute()) {
        throw new Exception("Failed to execute the update query.");
    }

    // Check if any row was updated
    if ($stmt->affected_rows === 1) {
        return true; // Update successful
    }

    return false; // No rows updated (product not found)
}

}
?>
