<?php
require_once '../models/ProductModel.php';
require_once "../../config/db.php";

class ProductController {
    private $productModel;

    public function __construct() {
        $database = new Database();
        $conn = $database->connect();
        $this->productModel = new ProductModel($conn);
    }

    public function filterProducts() {
        $gender = isset($_POST['gender']) ? $_POST['gender'] : null;
        $type_name = isset($_POST['type_name']) ? $_POST['type_name'] : null;
        $color = isset($_POST['color']) ? $_POST['color'] : null;
        $price_range = isset($_POST['price_range']) ? $_POST['price_range'] : null;

        $filters = [
            'gender' => $gender,
            'type_name' => $type_name,
            'color' => $color,
            'price_range' => $price_range,
        ];

        $products = $this->productModel->getFilteredProducts($filters);

        include '../views/product/index.php';
    }
}
