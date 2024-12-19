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
    public function addReview($id) {
        // Kiểm tra nếu yêu cầu là POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user_id'] ?? null; // Giả sử user đã đăng nhập
            $comment = trim($_POST['comment']);      // Nội dung đánh giá
    
            if (!$user_id) {
                echo "You need to log in to leave a review.";
                return;
            }
    
            if (empty($comment)) {
                echo "Comment cannot be empty.";
                return;
            }
    
            // Thêm đánh giá vào cơ sở dữ liệu
            $productModel = new \App\Models\Product();
            if ($productModel->addReview($product_id, $user_id, $comment)) {
                // Chuyển hướng về trang chi tiết sản phẩm
                header("Location: /Gleamcraft_MVC/public/product/detail/$product_id");
                exit;
            } else {
                echo "Error adding review.";
            }
        }
    }
    
}
