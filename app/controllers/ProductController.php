<?php
require_once '../models/ProductModel.php';

class ProductController {
    private $productModel;

    public function __construct($db) {
        $this->productModel = new ProductModel($db->connect());
    }

    public function filterProducts() {
        // Check if there's POST data
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $gender = $_POST['gender'] ?? null;
            $type_name = $_POST['type_name'] ?? null;
            $price_range = $_POST['price_range'] ?? null;
            $color = $_POST['color'] ?? null;

            $filters = [
                'gender' => $gender,
                'type_name' => $type_name,
                'price_range' => $price_range,
                'color' => $color,
            ];
        } else {
            $filters = []; // No filters
        }

        // Call model to get the product list
        global $products;  
        $products = $this->productModel->getFilteredProducts($filters);

        // Return data to the view
        require_once '../views/product/index.php';
    }
}

// Instantiate the controller with a database connection
require_once '../../config/db.php'; // Assuming a Database class exists
$db = new Database();
$controller = new ProductController($db);

// Call the filterProducts method
$controller->filterProducts();
?>
