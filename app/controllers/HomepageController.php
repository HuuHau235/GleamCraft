<?php

namespace App\Controllers;

use App\Models\Product;

class HomepageController {
    public function index() {
        // Tạo đối tượng Model
        $productModel = new Product();

        // Lấy danh sách sản phẩm từ Model
        $products = $productModel->getAllProducts();
        require_once '../app/views/homepage/index.php';

    }
}
