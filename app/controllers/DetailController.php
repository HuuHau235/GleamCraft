<?php
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\core\Controller.php');
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\models\UserModel.php');
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\models\ProductsModel.php');
// require_once('C:\xampp\htdocs\GleamCraft_MVC\app\models\PaymentModel.php');

class DetailController extends Controller
{
    protected $userModel;
    protected $productModel;
    protected $productRelatedModel;

    // Hàm khởi tạo
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->productModel = new ProductsModel();
    }
    public function index()
    {
        // Lấy thông tin người dùng
        $users = $this->userModel->getUserList();
        
        $products = $this->productModel->getAllProduct();
        
        $productId = $_GET['product_id'];
    
        // Truyền dữ liệu vào view
        $this->view("detail/index", [
            "users" => $users,
            "products" => $products,
           
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
    $productsRelate = $this->productModel->getRelatedProduct();


    if ($product) {
        $this->view("detail/index", [
            "product" => $product,
            "productsRelate" => $productsRelate  
        ]);
    } else {
        header("Location: /detail/index");
        exit;
    }
}
}
?>


