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

    public function filter(){
        // Lấy dữ liệu từ request
        $filters = [
            'gender' => $_POST['gender'] ?? null,
            'type_name' => $_POST['type_name'] ?? null,
            'color' => $_POST['color'] ?? null,
            'price_range' => $_POST['price_range'] ?? null,
        ];

        try {
            // Lọc sản phẩm dựa trên bộ lọc từ model
            $filteredProducts = $this->productModel->getFilteredProducts($filters);

            // Gửi dữ liệu sản phẩm đã lọc đến view
            $this->view("product/index", [
                "products" => $filteredProducts,
                "message" => empty($filteredProducts) ? "There are no products that match the filter." : null,
            ]);
        } catch (Exception $e) {
            // Xử lý lỗi và thông báo cho người dùng
            $this->view("product/index", [
                "error" => $e->getMessage(),
            ]);
        }
    }
}
