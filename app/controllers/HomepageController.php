<?php

namespace App\Controllers;

use App\Models\Product;

class HomepageController {
    public function index() {
        // Tạo đối tượng Model
        $productModel = new Product();

        // Lấy danh sách sản phẩm từ Model
        $products = $productModel->getAllProducts();

        // Tải header
        require_once '../app/views/shared/header.php';
        
        // Tải banner
        require_once '../app/views/shared/banner.php';
        
        // Truyền biến $products sang view
        require_once '../app/views/homepage/index.php';

        // Tải footer
        require_once '../app/views/shared/footer.php';
    }
}
