<?php
require_once 'C:\xampp\htdocs\GleamCraft_MVC\app\models\Reviews.php';  // Kết nối đến Model
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\core\Controller.php');
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\models\ProductsModel.php');

class ReviewsController extends Controller
{
    protected $productRelatedModel;

    public function __construct()
    {
        // Khởi tạo model ReviewsModel
        $this->productRelatedModel = new ReviewsModel();
    }

    // Phương thức hiển thị trang chi tiết sản phẩm và các đánh giá
    public function detail()
    {
        // Kiểm tra xem product_id có tồn tại hay không
        if (empty($product_id)) {
            $_SESSION['error'] = "Không tìm thấy sản phẩm!";
            header("Location: /");
            exit;
        }
    
        // Lấy thông tin sản phẩm và các đánh giá
        $product = $this->productRelatedModel->getProductDetails($product_id);
        $reviews = $this->productRelatedModel->getReviewsByProductId($product_id);
    
        if (!$product) {
            $_SESSION['error'] = "Sản phẩm không tồn tại!";
            header("Location: /");
            exit;
        }
    
        // Kiểm tra nếu không có đánh giá
        if (empty($reviews)) {
            $_SESSION['error'] = "Chưa có đánh giá cho sản phẩm này.";
        }
    
        // Hiển thị view chi tiết sản phẩm và đánh giá
        $this->view('detail/index', [
            'product' => $product,
            'reviews' => $reviews,
        ]);
    }
    

    // Phương thức hiển thị trang thêm review
    public function showAddReviewForm($product_id)
    {
        // Kiểm tra xem có tồn tại product_id không
        if (!$product_id) {
            $_SESSION['error'] = "Không tìm thấy sản phẩm!";
            header("Location: detail/index");
            exit;
        }

        // Truyền dữ liệu sản phẩm vào view
        $this->view('detail/index', [
            'product_id' => $product_id
        ]);
    }

    // Phương thức xử lý việc thêm review
    public function addReview()
{
    // Kiểm tra xem có dữ liệu POST từ form không
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Lấy dữ liệu từ form
        $product_id = $_POST['product_id'] ?? null;
        $comment = $_POST['comment'] ?? '';

        // Kiểm tra dữ liệu hợp lệ
        if (empty($comment) || empty($product_id)) {
            $_SESSION['error'] = "Vui lòng điền đầy đủ thông tin.";
            // Reload lại trang chi tiết sản phẩm hiện tại
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit;
        }

        // Gọi model để thêm review
        $result = $this->productRelatedModel->insertReview($product_id, $comment);

        if ($result) {
            // Nếu thêm review thành công, reload lại trang chi tiết sản phẩm
            $_SESSION['message'] = "Review đã được thêm thành công!";
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit;
        } else {
            // Nếu thất bại, hiển thị thông báo lỗi
            $_SESSION['error'] = "Không thể thêm review. Vui lòng thử lại.";
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit;
        }
    } else {
        // Nếu không có dữ liệu POST, chuyển hướng về trang sản phẩm
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit;
    }
}


    // Phương thức hiển thị view
    public function view($viewName, $data = [])
    {
        // Ensure that the path is correctly constructed based on your structure
        $viewPath = "C:\xampp\htdocs\GleamCraft_MVC\app\views\\" . $viewName . ".php";
        
        if (file_exists($viewPath)) {
            // If the view file exists, include it and pass data to it
            extract($data); // Make data available to the view
            require_once $viewPath;
        } else {
            // Handle missing view file (optional)
            echo "View file not found: " . $viewName;
        }
    }
}
?>
