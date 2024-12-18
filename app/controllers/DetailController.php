<?php

namespace App\Controllers;

use App\Models\Product;

class DetailController {
    public function show($id) {
        // Tạo đối tượng Model
        $productModel = new Product();

        // Lấy sản phẩm theo ID
        $product = $productModel->getProductById($id);

        // Kiểm tra nếu sản phẩm không tồn tại
        if (!$product) {
            echo "Product not found.";
            return;
        }

        // Lấy các sản phẩm liên quan (ngẫu nhiên)
        $relatedProducts = $productModel->getRelatedProducts();

        // Truyền dữ liệu sang view
        require_once '../app/views/detail/index.php';

        // Tải footer
        require_once '../app/views/shared/footer.php';
    }
  
}
