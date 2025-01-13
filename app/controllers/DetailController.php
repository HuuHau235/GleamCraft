<?php
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\core\Controller.php');
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\models\UserModel.php');
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\models\ProductsModel.php');
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\models\Reviews.php');

class DetailController extends Controller
{
    protected $userModel;
    protected $productModel;
    protected $reviewModel;

    // Hàm khởi tạo
    public function __construct()
    {
        // Khởi tạo session
        session_start();

        // Khởi tạo các model
        $this->userModel = new UserModel();
        $this->productModel = new ProductsModel();
        $this->reviewModel = new ReviewsModel();
    }

    // Hàm hiển thị danh sách sản phẩm và các review tổng quát
    public function index()
    {
        // Lấy danh sách người dùng
        $users = $this->userModel->getUserList();

        // Lấy tất cả sản phẩm
        $products = $this->productModel->getAllProduct();

        // Lấy tất cả các review (không có lọc theo sản phẩm ở đây)
        $reviews = $this->reviewModel->getAllReview();

        // Truyền dữ liệu vào view
        $this->view("detail/index", [
            "users" => $users,
            "products" => $products,
            "reviews" => $reviews,
        ]);
    }

    // Hàm hiển thị chi tiết sản phẩm
    public function viewProduct($product_id = null)
    {
        // Kiểm tra nếu product_id không được truyền vào phương thức, lấy từ $_GET
        if ($product_id === null && isset($_GET['product_id'])) {
            $product_id = $_GET['product_id'];
        }
    
        // Kiểm tra xem có product_id hay không
        if ($product_id === null) {
            echo "Product ID is missing!";
            exit;
        }
    
        // Lấy thông tin sản phẩm từ cơ sở dữ liệu
        $product = $this->productModel->getProductById($product_id);
    
        // Lấy các sản phẩm liên quan và các đánh giá của sản phẩm này
        $productsRelate = $this->productModel->getRelatedProduct();
        $reviews = $this->reviewModel->getReviewsByProductId($product_id);
        if ($product) {
            $this->view("detail/index", [
                "product" => $product,
                "productsRelate" => $productsRelate,
                "reviews" => $reviews,  // Truyền các đánh giá vào view
            ]);
        } else {
            // Nếu không tìm thấy sản phẩm, thông báo lỗi
            echo "Product not found!";
            exit;
        }
    }
    

    // Hàm xử lý gửi đánh giá cho sản phẩm
    public function submitReview()
{
    // Khởi động session nếu chưa được khởi động
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Kiểm tra product_id
    if (isset($_POST['product_id'])) {
        $product_id = $_POST['product_id'];
    } else {
        echo "Product ID is missing!";
        exit;
    }

    // Kiểm tra phương thức POST và comment không rỗng
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';

        if (!empty($comment)) {
            // Kiểm tra xem người dùng đã đăng nhập chưa
            if (!isset($_SESSION['user_id'])) {
                echo "You must be logged in to submit a review.";
                exit;
            }

            $user_id = $_SESSION['user_id']; // Lấy user_id từ session

            $result = $this->reviewModel->addReview($product_id, $user_id, $comment);

            // Kiểm tra nếu thêm đánh giá thành công
            if ($result) {
                // Chuyển hướng về trang chi tiết sản phẩm
                header("Location: /detail/viewProduct?product_id=$product_id");
                exit;
            } else {
                echo "There was an error adding your review.";
            }
        } else {
            echo "Please enter a review comment.";
        }
    }
}


}
?>