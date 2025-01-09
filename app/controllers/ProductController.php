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
    // Hiển thị tất cả sản phẩm
    public function index()
    {
        $products = $this->productModel->getAllProduct();
        $this->renderProductView($products);
    }
    // Lọc sản phẩm
    public function filter()
    {
        // Lấy dữ liệu bộ lọc từ form
        $filters = $this->getFilterDataFromRequest();
        try {
            $filteredProducts = $this->productModel->getFilteredProducts($filters);
            // Nếu không có sản phẩm nào phù hợp với bộ lọc, thông báo cho người dùng
            if (empty($filteredProducts)) {
                $this->renderProductView([], "There are no products that match the filter.");
            } else {
                $this->renderProductView($filteredProducts);
            }
        } catch (Exception $e) {
            // Xử lý lỗi và thông báo cho người dùng
            $this->renderProductView([], null, $e->getMessage());
        }
    }
    // Hàm hiển thị chi tiết sản phẩm
    public function viewProduct($product_id)
    {
        // Lấy thông tin chi tiết sản phẩm
        $productDetails = $this->productModel->getProductById($product_id);
        
        // Kiểm tra nếu không tìm thấy sản phẩm
        if (!$productDetails) {
            $this->renderProductView([], "Product not found.");
            return;
        }
        // Hiển thị thông tin chi tiết sản phẩm
        $this->view("product/index", [
            'productDetails' => $productDetails,
            'product_id' => $product_id
        ]);
    }
    // Hàm chung để hiển thị danh sách sản phẩm và thông báo (nếu có)
    private function renderProductView($products, $message = null, $error = null)
    {
        $this->view("product/index", [
            "products" => $products,
            "message" => $message,
            "error" => $error
        ]);
    }
    // Hàm lấy dữ liệu bộ lọc từ request
    private function getFilterDataFromRequest()
    {
        return [
            'gender' => $_POST['gender'] ?? null,
            'type_name' => $_POST['type_name'] ?? null,
            'color' => $_POST['color'] ?? null,
            'price_range' => $_POST['price_range'] ?? null,
        ];
    }
}
?>
