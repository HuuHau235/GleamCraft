<?php
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\core\Controller.php');
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\models\Products.php');

class ProductController extends Controller {
    public function index() {
        $product = $this->model('Products');  // Kiểm tra nếu cần thay đổi tên class
        $products = $product->getAllProduct();  

        if (!$products) {
            die("No products found.");
        }

        $this->view("homepage", ["products" => $products]);  // Hiển thị trang chủ với các sản phẩm
    }

    public function detail($id) {
        $product = $this->model('Products');  // Lấy model Products
        $productDetail = $product->getProductById($id);  // Lấy sản phẩm theo ID

        if ($productDetail) {
            $this->view('detail/index', ['product' => $productDetail]);  // Trả về view chi tiết sản phẩm
        } else {
            echo "Product not found.";
        }
    }
    
}


?>