<?php
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\core\Controller.php');
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\models\Reviews.php');

class ReviewsController extends Controller
{
    protected $reviews;

    public function __construct()
    {
        $this->reviews = new ReviewsModel();
    }
    public function index()
    {
        // Gọi model để lấy tất cả review ID
        $review_ids = $this->reviews->getAllReviewsID();

        // Render view với danh sách review ID
        $this->view("detail/index", [
            "review_ids" => $review_ids,
        ]);
    }
    public function addReview()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ form
            $review_id = $_POST['review_id'];
            $product_id = $_POST['product_id'];
            $comment = $_POST['comment'];

            // Kiểm tra dữ liệu đầu vào
            if (empty($review_id) || empty($product_id) || empty($comment)) {
                echo "Dữ liệu không hợp lệ.";
                return;
            }

            // Gọi model để thêm review
            $isInserted = $this->reviews->insertReview($review_id, $product_id, $comment);

            // Kiểm tra và phản hồi
            if ($isInserted) {
                // Hiển thị review_id sau khi thêm thành công
                $this->view("detail/index", [
                    "review_id" => $review_id,
                ]);
                echo "Thêm review thất bại. Kiểm tra lại dữ liệu.";
            }
        }
    }
    
}
?>

