<!-- Xử lý cập nhật lại user -->
<?php
require_once('../../../config/db.php');  
require_once('../../models/Admin.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_POST['user_id'] ?? null;
    $name = $_POST['name'] ?? null;
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;
    $phone = $_POST['phone'] ?? null;
    $role = $_POST['role'] ?? null;

    if (!$user_id || !$name || !$email || !$password || !$phone || !$role) {
        echo "All fields are required.";
        exit;
    }

    // Tạo đối tượng AdminUser và gọi phương thức EditUser để cập nhật
    $adminUser = new AdminUser($conn);
    $message = $adminUser->EditUser($user_id, $name, $email, $password, $phone, $role);
    echo $message;
    exit;
}
?>
