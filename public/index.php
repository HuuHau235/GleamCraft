<?php

// Load autoload để tự động tải class
require_once '../app/init.php';

// Bắt đầu session
session_start();

// Kết nối cơ sở dữ liệu
$db = new mysqli('localhost', 'root', '', 'gleamcraft');

// Kiểm tra kết nối
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Lấy URL từ request
$requestUri = $_SERVER['REQUEST_URI'];
$basePath = '/public'; // Thư mục chứa ứng dụng của bạn

// Xử lý URI
$processedUri = str_replace($basePath, '', $requestUri);

// Route trang chủ
if ($processedUri === '' || $processedUri === '/') {
    $controller = new \App\Controllers\HomepageController($db);
    $controller->index();
    exit;
}

// Route chi tiết sản phẩm
if (preg_match('/^\/product\/detail\/(\d+)$/', $processedUri, $matches)) {
    $productId = $matches[1];
    $controller = new \App\Controllers\DetailController($db);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Xử lý thêm đánh giá
        $controller->addReview($productId);
    } else {
        // Hiển thị chi tiết sản phẩm
        $controller->show($productId);
    }
    exit;
}

// Route lọc sản phẩm
if (preg_match('/^\/product\/filter$/', $processedUri)) {
    require_once '../controllers/ProductController.php';

    // Khởi tạo kết nối Database
    $productController = new ProductController($db);

    // Kiểm tra phương thức POST để lọc sản phẩm
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Lọc sản phẩm
        $productController->filterProducts();
    } 
    exit;
}




// Nếu không tìm thấy trang
http_response_code(404);
echo "Page not found.";
