<?php
class ProductModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getFilteredProducts($filters) {
        $query = "SELECT * FROM Products";
        $conditions = [];
        $params = [];

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
            $params[] = $min;
            $params[] = $max;
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

        
        $stmt->execute();
        $result = $stmt->get_result();

        
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}