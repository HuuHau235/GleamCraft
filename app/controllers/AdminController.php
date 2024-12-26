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
<?php
require_once('../../../config/db.php');
require_once('../../models/Admin.php');
if (isset($_GET['delete_user']) && isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    if (!empty($user_id)) {
        $sqlCheckAdmin = "SELECT role FROM users WHERE user_id = ?";
        $stmtCheck = $conn->prepare($sqlCheckAdmin);
        if (!$stmtCheck) {
            die("Error preparing the statement: " . $conn->error);
        }
        $stmtCheck->bind_param("i", $user_id);
        $stmtCheck->execute();
        $result = $stmtCheck->get_result();
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if ($user['role'] === 'admin') {
                echo "<script>alert('Không thể xóa tài khoản admin.');</script>";
                echo "<script>window.location.href = '../admin/index.php';</script>";
                exit;
            }
        } else {
            echo "<script>alert('Người dùng không tồn tại.');</script>";
            exit;
        }
        $sqlDeleteUser = "DELETE FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($sqlDeleteUser);
        if (!$stmt) {
            die("Error preparing the statement: " . $conn->error);
        }
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) {
            $stmt->close();
            echo "<script>alert('Đã xóa thành công');</script>";
        } else {
            echo "<script>alert('Xóa không thành công: " . $stmt->error . "');</script>";
        }

        echo "<script>window.location.href = '../admin/index.php';</script>";
        exit;
    } else {
        echo "<script>alert('ID người dùng không hợp lệ.');</script>";
    }
}
?>

<!-- Xử lý cập nhật lại product -->
<?php
require_once('../../../config/db.php');
require_once('../../models/Admin.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $product_id = $_POST['product_id'] ?? null;
    $name = $_POST['name'] ?? null;
    $description = $_POST['description'] ?? null;
    $color = $_POST['color'] ?? null;
    $gender = $_POST['gender'] ?? null;
    $type_name = $_POST['type_name'] ?? null;
    $price = $_POST['price'] ?? null;
    $image = $_POST['image'] ?? null;

    if (!$product_id || !$name || !$description || !$color || !$gender || !$type_name || !$price || !$image ) {
        echo "All fields are required.";
        exit;
    }

    // Tạo đối tượng AdminUser và gọi phương thức EditUser để cập nhật
    $adminUser = new AdminUser($conn);
    $message = $adminUser->EditProduct(!$product_id || !$name || !$description || !$color || !$gender || !$type_name || !$price || !$image );
    echo $message;
    exit;
}
?>