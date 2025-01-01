<?php
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\core\Controller.php');
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\models\UserModel.php');
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\models\Products.php');
// require_once('C:\xampp\htdocs\GleamCraft_MVC\app\models\PaymentModel.php');

class DetailController extends Controller
{
    protected $userModel;
    protected $productModel;

    // Hàm khởi tạo
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->productModel = new Products();
    }

    // Hàm hiển thị trang admin index
    public function index()
    {
        $users = $this->userModel->getUserList();
        $products = $this->productModel->getAllProduct();

        $this->view("detail/index", [
            "users" => $users,
            "products" => $products
        ]);
    }
 // Hàm hiển thị chi tiết sản phẩm
 public function viewProduct($product_id = null)
{
    // Kiểm tra nếu product_id không tồn tại hoặc không hợp lệ
    if ($product_id === null) {
        die("Product ID is missing!");
    }

    // Lấy chi tiết sản phẩm từ model
    $product = $this->productModel->getProductById($product_id);

    // Kiểm tra nếu sản phẩm tồn tại
    if ($product) {
        // Truyền dữ liệu vào view
        $this->view("detail/index", [
            "product" => $product
        ]);
    } else {
        // Nếu sản phẩm không tồn tại, chuyển hướng về trang admin
        header("Location: /detail/index");
        exit;
    }
}
}
?>


