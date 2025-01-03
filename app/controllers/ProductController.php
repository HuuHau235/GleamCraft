<?php
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\core\Controller.php');
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\models\ProductsModel.php');

class ProductController extends Controller
{
    protected $productModel;

    public function __construct()
    {
        $this->productModel = new ProductsModel();
    }

    public function index()
    {
        // Lấy tất cả sản phẩm từ model
        $products = $this->productModel->getAllProduct();

        // Gửi dữ liệu sản phẩm đến view
        $this->view("product/index", [
            "products" => $products,
        ]);
    }
}
?>
