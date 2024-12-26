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
<?php
require_once('../../../config/db.php');
require_once('../../models/Admin.php');

$adminPayments = new AdminPayments($conn);

// Lấy tất cả các payments
$payments = $adminPayments->getAllPayments();

if (isset($_GET['deletePayment']) && isset($_GET['payment_id'])) {
    $payment_id = (int) $_GET['payment_id'];

    if ($adminPayments->paymentExists($payment_id)) {
        $deleted = $adminPayments->deletePaymentById($payment_id);
        if ($deleted) {
            echo "<script>alert('Payment deleted successfully');</script>";
        } else {
            echo "<script>alert('Failed to delete payment');</script>";
        }
    } else {
        echo "<script>alert('Payment does not exist');</script>";
    }

    // Điều hướng lại trang
    echo "<script>window.location.href = 'index.php';</script>";
    exit;
}

?>












<?php
// db.php - Tệp cấu hình kết nối cơ sở dữ liệu
require_once('../../../config/db.php');

// Kiểm tra kết nối cơ sở dữ liệu
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Xử lý cập nhật sản phẩm khi nhận dữ liệu từ form
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Nhận dữ liệu từ form, có thể là null nếu không có giá trị
    $product_id = $_POST['product_id'] ?? null;
    $name = $_POST['name'] ?? null;
    $description = $_POST['description'] ?? null;
    $color = $_POST['color'] ?? null;
    $gender = $_POST['gender'] ?? null;
    $type_name = $_POST['type_name'] ?? null;
    $price = $_POST['price'] ?? null;
    $image = $_POST['image'] ?? null;

    // Cập nhật các trường đã điền
    $sqlUpdate = "UPDATE products SET 
        name = ?, 
        description = ?, 
        color = ?, 
        gender = ?, 
        type_name = ?, 
        price = ?, 
        image = ? 
        WHERE product_id = ?";

    if ($stmt = $conn->prepare($sqlUpdate)) {
        $stmt->bind_param("sssssssi", $name, $description, $color, $gender, $type_name, $price, $image, $product_id);

        if ($stmt->execute()) {
            header("Location: " . $_SERVER['PHP_SELF']); // Redirect back to the current page
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
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

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST['action'] ?? null;

    // Xử lý cập nhật user
    if ($action === "update_user") {
        $user_id = $_POST['user_id'] ?? null;
        $name = $_POST['name'] ?? null;
        $email = $_POST['email'] ?? null;
        $password = $_POST['password'] ?? null;
        $phone = $_POST['phone'] ?? null;
        $role = $_POST['role'] ?? null;

        if (!$user_id || !$name || !$email || !$password || !$phone || !$role) {
            echo "All fields are required for user update.";
        } else {
            // Logic cập nhật user
            echo "User updated successfully!";
        }
    }

    // Xử lý cập nhật sản phẩm
    elseif ($action === "update_product") {
        $product_id = $_POST['product_id'] ?? null;
        $name = $_POST['name'] ?? null;
        $description = $_POST['description'] ?? null;
        $color = $_POST['color'] ?? null;
        $gender = $_POST['gender'] ?? null;
        $type_name = $_POST['type_name'] ?? null;
        $price = $_POST['price'] ?? null;
        $image = $_POST['image'] ?? null;

        if (!$product_id || !$name || !$description || !$color || !$gender || !$type_name || !$price || !$image) {
            echo "All fields are required for product update.";
        } else {
            // Logic cập nhật sản phẩm
            echo "Product updated successfully!";
        }
    }

    // Nếu không khớp action
    else {
        echo "Invalid action.";
    }
}
?>


<!-- Thực hiện xóa product -->
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