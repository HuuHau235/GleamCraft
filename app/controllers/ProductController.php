<?php
require_once '../models/ProductModel.php';

class ProductController {
    private $productModel;

    public function __construct($db) {
        $this->productModel = new ProductModel($db->connect());
    }

    public function filterProducts() {
        // Khởi tạo bộ lọc mặc định nếu không có POST
        $filters = [];

        // Kiểm tra dữ liệu POST và gán vào bộ lọc
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $filters['gender'] = $_POST['gender'] ?? null;
            $filters['type_name'] = $_POST['type_name'] ?? null;
            $filters['price_range'] = $_POST['price_range'] ?? null;
            $filters['color'] = $_POST['color'] ?? null;
        }

        // Lọc sản phẩm từ Model
        global $products; 
        $products = $this->productModel->getFilteredProducts($filters);

        // Gửi dữ liệu đến View
        require_once '../views/product/index.php';
    }
}

// Khởi tạo controller với kết nối database
require_once '../../config/db.php'; // Giả sử lớp Database đã được khai báo
$db = new Database();
$controller = new ProductController($db);

// Gọi phương thức filterProducts
$controller->filterProducts();
?>
