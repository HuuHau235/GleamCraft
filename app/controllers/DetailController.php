<?php 

namespace App\Controllers;

use App\Models\Product;
use App\Models\Review;

class DetailController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function show($id) {
        // Tạo đối tượng Model
        $productModel = new Product($this->db);
        $reviewModel = new Review($this->db);

        // Lấy sản phẩm theo ID
        $product = $productModel->getProductById($id);

        // Kiểm tra nếu sản phẩm không tồn tại
        if (!$product) {
            echo "Product not found.";
            return;
        }

        // Lấy các sản phẩm liên quan (ngẫu nhiên)
        $relatedProducts = $productModel->getRelatedProducts();

        // Lấy danh sách đánh giá cho sản phẩm
        $reviews = $reviewModel->getReviewsByProductId($id);

        // Truyền dữ liệu sang view
        require_once '../app/views/detail/index.php';

        // Tải footer
        require_once '../app/views/shared/footer.php';
    }

    public function addReview($id) {
        // Kiểm tra nếu yêu cầu là POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user_id'] ?? null; // Lấy user_id từ session
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
            $reviewModel = new Review($this->db);
            if ($reviewModel->addReview($id, $user_id, $comment)) {
                // Chuyển hướng về trang chi tiết sản phẩm
                header("Location: /Gleamcraft_MVC/public/product/detail/$id");
                exit;
            } else {
                echo "Error adding review.";
            }
        }
    }
}
