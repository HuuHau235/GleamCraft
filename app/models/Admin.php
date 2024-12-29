<?php
// // require_once(__DIR__ . '/../core/Db.php');
// require_once(__DIR__ . '/../../config/db.php');
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\core\Db.php');

class AdminModel extends Database {
    // protected $conn;
    public function __construct() {
        // $this->conn = $conn;
    }
    // Kiểm tra kết nối cơ sở dữ liệu
    private function checkConnection() {
        if (!$this->conn || $this->conn->connect_errno) {
            return "Database connection failed: " . $this->conn->connect_error;
        }
        return null;
    }
    // Xóa người dùng
    public function deleteUser($user_id) {
        $error = $this->checkConnection();
        if ($error) return $error;

        // $this->conn->query("SET FOREIGN_KEY_CHECKS = 0");
        $this->deleteRelatedData($user_id);
        $sql = "DELETE FROM users WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) {
            $stmt->close();
            // $this->conn->query("SET FOREIGN_KEY_CHECKS = 1");
            return "User deleted successfully!";
        } else {
            $stmt->close();
            // $this->conn->query("SET FOREIGN_KEY_CHECKS = 1");
            return "Error deleting user: " . $stmt->error;
        }
    }

    // Cập nhật thông tin người dùng
    public function updateUser($user_id, $name, $email, $password, $phone, $role) {
        $stmt = $this->conn->prepare("UPDATE users SET name = ?, email = ?, password = ?, phone = ?, role = ? WHERE user_id = ?");
        $stmt->bind_param("sssssi", $name, $email, $password, $phone, $role, $user_id);
        return $stmt->execute() ? "Product updated successfully" : "Failed to update product";
    }
   

    // Xóa sản phẩm
    public function deleteProduct($product_id) {
        $error = $this->checkConnection();
        if ($error) return $error;

        $sql = "DELETE FROM products WHERE product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $product_id);
        if ($stmt->execute()) {
            $stmt->close();
            return "Product deleted successfully!";
        } else {
            $stmt->close();
            return "Error deleting product: " . $stmt->error;
        }
    }

    // Cập nhật thông tin sản phẩm
    public function updateProduct($product_id, $name, $description, $color, $gender, $type_name, $price, $image) {
        $stmt = $this->conn->prepare("UPDATE products SET name = ?, description = ?, color = ?, gender = ?, type_name = ?, price = ?, image = ? WHERE product_id = ?");
        $stmt->bind_param("sssssssi", $name, $description, $color, $gender, $type_name, $price, $image, $product_id);
        return $stmt->execute() ? "Product updated successfully" : "Failed to update product";
    }

    // Xóa review
    public function deleteReview($review_id) {
        $error = $this->checkConnection();
        if ($error) return $error;

        $sql = "DELETE FROM reviews WHERE review_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $review_id);
        if ($stmt->execute()) {
            $stmt->close();
            return "Review deleted successfully!";
        } else {
            $stmt->close();
            return "Error deleting review: " . $stmt->error;
        }
    }

    // Xóa thanh toán
    public function deletePayment($payment_id) {
        $error = $this->checkConnection();
        if ($error) return $error;

        $sql = "DELETE FROM payments WHERE payment_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $payment_id);
        if ($stmt->execute()) {
            $stmt->close();
            return "Payment deleted successfully!";
        } else {
            $stmt->close();
            return "Error deleting payment: " . $stmt->error;
        }
    }

    // Các phương thức xóa dữ liệu liên quan đến người dùng
    public function deleteRelatedData($user_id) {
        $this->deleteReviews($user_id);
        $this->deleteOrders($user_id);
        $this->deletePayments($user_id);
    }

    public function deleteReviews($user_id) {
        $sql = "DELETE FROM reviews WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
    }

    public function deleteOrders($user_id) {
        $sql = "DELETE FROM orders WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
    }
    public function deletePayments($user_id) {
        $sql = "DELETE FROM payments WHERE order_id IN (SELECT order_id FROM orders WHERE user_id = ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
    }
    
}
?>
