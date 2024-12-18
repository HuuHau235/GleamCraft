<?php
class ProductModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getFilteredProducts($filters) {
        $query = "SELECT * FROM Products WHERE 1=1";
        $params = [];

        // Áp dụng bộ lọc
        if (!empty($filters['gender'])) {
            $query .= " AND gender = :gender";
            $params[':gender'] = $filters['gender'];
        }

        if (!empty($filters['type_name'])) {
            $query .= " AND type_name = :type_name";
            $params[':type_name'] = $filters['type_name'];
        }

        if (!empty($filters['color'])) {
            $query .= " AND color = :color";
            $params[':color'] = $filters['color'];
        }

        if (!empty($filters['price_range'])) {
            [$minPrice, $maxPrice] = explode('-', $filters['price_range']);
            $query .= " AND price BETWEEN :minPrice AND :maxPrice";
            $params[':minPrice'] = $minPrice;
            $params[':maxPrice'] = $maxPrice;
        }

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
