<?php
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\core\Controller.php');
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\models\Products.php');

class ProductController extends Controller {
    public function index() {
        $product = $this->model('Products');
        $products = $product->getAllProduct();

        if (!$products) {
            die("No products found.");
        }

        $this->view("homepage", ["products" => $products]);
    }

    public function detail($id) {
        $product = $this->model('Products');
        $productDetail = $product->getProductById($id);

        if ($productDetail) {
            $this->view('detail/index', ['product' => $productDetail]);
        } else {
            echo "Product not found.";
        }
    }


}
?>
