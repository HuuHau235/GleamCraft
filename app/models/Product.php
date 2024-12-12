<?php

namespace App\Models;

use PDO;

class Product {
    private $db;

    public function __construct() {
        // Kết nối cơ sở dữ liệu
        $this->db = new PDO('mysql:host=localhost;dbname=gleamcraft', 'root', '');
    }

    public function getAllProducts() {
        $stmt = $this->db->prepare("SELECT * FROM products");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
