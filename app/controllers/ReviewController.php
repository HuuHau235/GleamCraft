<?php
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\core\Controller.php');
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\models\Products.php');

class ReviewsController extends Controller
{
    protected $reviews;

    public function __construct()
    {
        $this->reviews = new Reviews();
    }

    public function addReviews()
    {
        $review_id = $_POST['review_id'] ?? null;
        $product_id = $_POST['product_id'] ?? null;
        $user_id = $_SESSION['user_id'] ?? null; // Lấy từ phiên đăng nhập
        $comment = $_POST['comment'] ?? null;

        if ($review_id && $product_id && $user_id && $comment) {
            $result = $this->reviews->insertReview($review_id, $product_id, $user_id, $comment);

            if ($result) {
                header("Location: /GleamCraft_MVC/public/detail");
                exit;
            } else {
                echo "Không thể thêm review.";
            }
        } else {
            echo "Dữ liệu không hợp lệ.";
        }
    }

    public function listReviews()
    {
        $user_id = $_SESSION['user_id'] ?? null; // Lấy ID người dùng từ session
        if ($user_id) {
            $data['reviews'] = $this->reviews->getAllReviewsByUser($user_id);
            $this->view('reviews/list', $data); // Render view hiển thị review
        } else {
            echo "Bạn cần đăng nhập.";
        }
    }
}

?>
