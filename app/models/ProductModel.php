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
            $conditions[] = "gender = :gender";
            $params[':gender'] = $filters['gender'];
        }

        if (!empty($filters['type_name'])) {
            $conditions[] = "type_name = :type_name";
            $params[':type_name'] = $filters['type_name'];
        }

        if (!empty($filters['color'])) {
            $conditions[] = "color = :color";
            $params[':color'] = $filters['color'];
        }
        
        if (!empty($filters['price_range'])) {
            [$min, $max] = explode('-', $filters['price_range']);
            $conditions[] = "price BETWEEN :min_price AND :max_price";
            $params[':min_price'] = $min;
            $params[':max_price'] = $max;
        }

        // Thêm điều kiện vào query
        if ($conditions) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
