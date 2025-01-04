<?php
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\core\Controller.php');
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\models\UserModel.php');
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\models\ProductsModel.php');

class PaymentMethodController extends Controller
{
    protected $userModel;
    protected $productModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->productModel = new ProductsModel();
    }

    // Phương thức hiển thị trang payment
    public function index()
    {
        // Lấy danh sách người dùng và sản phẩm
        $users = $this->userModel->getUserList();
        $products = $this->productModel->getAllProduct();

        // Gọi view và truyền dữ liệu tới nó
        $this->view("payment/index", [
            "users" => $users,
            "products" => $products
        ]);
    }
}
?>
