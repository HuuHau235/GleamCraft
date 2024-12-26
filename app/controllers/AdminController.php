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
<?php
require_once('../../../config/db.php');
require_once('../../models/Admin.php');
$adminReviews = new AdminReviews($conn);

// Lấy tất cả các reviews
$reviews = $adminReviews->getAllReviews();

if (isset($_GET['deleteReview']) && isset($_GET['review_id'])) {
    $review_id = (int) $_GET['review_id']; // Chuyển đổi sang số nguyên

    if ($adminReviews->reviewExists($review_id)) { // Đổi $reviewModel thành $adminReviews
        $deleted = $adminReviews->deleteReviewById($review_id); // Đổi $reviewModel thành $adminReviews
        if ($deleted) {
            echo "<script>alert('Review deleted successfully');</script>";
        } else {
            echo "<script>alert('Failed to delete review');</script>";
        }
    } else {
        echo "<script>alert('Review does not exist');</script>";
    }

    // Điều hướng lại trang
    echo "<script>window.location.href = 'index.php';</script>";
    exit;
}
?>

<!-- Xóa product -->
<?php
require_once('../../../config/db.php');
require_once('../../models/Admin.php');

if (isset($_GET['delete_product']) && isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    if (!empty($product_id)) {
        $sqlCheckReview = "SELECT * FROM products WHERE product_id = ?";
        $stmtCheck = $conn->prepare($sqlCheckReview);
        if (!$stmtCheck) {
            die("Error preparing the statement: " . $conn->error);
        }
        $stmtCheck->bind_param("i", $product_id);
        $stmtCheck->execute();
        $result = $stmtCheck->get_result();

        if ($result->num_rows > 0) {
            $sqlDeleteReview = "DELETE FROM products WHERE product_id = ?";
            $stmtDelete = $conn->prepare($sqlDeleteReview);
            if (!$stmtDelete) {
                die("Error preparing the statement: " . $conn->error);
            }
            $stmtDelete->bind_param("i", $product_id);
            if ($stmtDelete->execute()) {
                $stmtDelete->close();
                echo "<script>alert('Đã xóa đánh giá thành công');</script>";
            } else {
                echo "<script>alert('Xóa không thành công: " . $stmtDelete->error . "');</script>";
            }
        } else {
            echo "<script>alert('Đánh giá không tồn tại.');</script>";
        }

        echo "<script>window.location.href = '../admin/index.php';</script>";
        exit;
    } else {
        echo "<script>alert('ID đánh giá không hợp lệ.');</script>";
    }
}
?>
