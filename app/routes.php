<?php
// Bao gồm tất cả các controller cần thiết.
require_once './controllers/UserController.php';
require_once './controllers/LoginController.php';

// Lấy tên controller và action từ URL
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'User'; // Mặc định là UserController
$action = isset($_GET['action']) ? $_GET['action'] : 'index'; // Mặc định là action 'index'

// Kiểm tra tên controller hợp lệ
$controllerName = ucfirst(strtolower($controller)) . 'Controller'; // Chuyển tên controller thành đúng định dạng ví dụ: 'UserController'

// Kiểm tra xem controller có tồn tại không
if (class_exists($controllerName)) {
    // Tạo đối tượng controller
    $controllerObj = new $controllerName();

    // Kiểm tra action có tồn tại trong controller không
    if (method_exists($controllerObj, $action)) {
        // Gọi phương thức action
        $controllerObj->$action();
    } else {
        // Nếu action không tồn tại, gọi một phương thức xử lý lỗi
        echo "Action '$action' không hợp lệ!";
    }
} else {
    // Nếu controller không tồn tại, thông báo lỗi
    echo "Controller '$controllerName' không tồn tại!";
}
?>
