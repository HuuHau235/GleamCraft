<?php

// Load autoload để tự động tải class
require_once '../app/init.php';

// Lấy URL từ request
$requestUri = $_SERVER['REQUEST_URI'];
$basePath = '/public'; // Thư mục chứa ứng dụng của bạn
// Xử lý URI
$processedUri = str_replace($basePath, '', $requestUri);  // Loại bỏ base path
if ($processedUri === '' || $processedUri === '/') {
    $controller = new \App\Controllers\HomepageController();
    $controller->index();
}
// Kiểm tra nếu là trang chi tiết sản phẩm
elseif (preg_match('/^\/product\/detail\/(\d+)$/', $processedUri, $matches)) {
    $productId = $matches[1];  // Lấy ID sản phẩm từ URL
    $controller = new \App\Controllers\DetailController();
    $controller->show($productId);
}
// Nếu không tìm thấy trang
else {
    echo "Page not found.";
}
