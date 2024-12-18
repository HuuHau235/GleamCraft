<?php

// Load autoload để tự động tải class
require_once '../app/init.php';

// Lấy URL từ request
$requestUri = $_SERVER['REQUEST_URI'];
$basePath = '/Gleamcraft_MVC/public'; // Thư mục chứa ứng dụng của bạn

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
// Xử lý đánh giá sản phẩm
if (preg_match('/^\/Gleamcraft_MVC\/public\/product\/detail\/(\d+)$/', $_SERVER['REQUEST_URI'], $matches)) {
    $productId = $matches[1];
    $controller = new \App\Controllers\DetailController();
    $controller->show($productId);
    exit;
}
// Nếu không tìm thấy trang
else {
    echo "Page not found.";
}
