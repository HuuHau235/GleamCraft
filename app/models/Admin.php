 <!-- Quản lí review -->
 <?php
$reviews = "SELECT * FROM reviews";
$resultUser = $conn->query($reviews);
$reviews = $resultUser->fetch_all(MYSQLI_ASSOC);
?>
<?php
// Truy vấn dữ liệu từ bảng Payments
$sql = "SELECT * FROM Payments";
$resultPayments = $conn->query($sql);
$payments = $resultPayments->fetch_all(MYSQLI_ASSOC);
?>

<?php
$sqlUser = "SELECT * FROM users";
$resultUser = $conn->query($sqlUser);
?>
<!-- Quản lí Products -->
<?php
$sqlProducts ="SELECT * FROM Products";
$resultProduct = $conn ->query(($sqlProducts));
?>
<?php
class AdminUser {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function EditUser($user_id, $name, $email, $password, $phone, $role) {
        // Kiểm tra nếu có admin rồi thì không được phép cập nhập 
        if ($role === 'admin') {
            $sqlCheckAdmin = "SELECT * FROM users WHERE role = 'admin'";
            $resultCheckAdmin = $this->conn->query($sqlCheckAdmin);

            if ($resultCheckAdmin->num_rows > 0) {
                return "There is already an admin. You cannot set this user as admin.";
            }
        }

        $sqlUser = "UPDATE users SET name = ?, email = ?, password = ?, phone = ?, role = ? WHERE user_id = ?";
        if (!$this->conn || $this->conn->connect_errno) {
            return "Database connection failed: " . $this->conn->connect_error;
        }
        $stmt = $this->conn->prepare($sqlUser);
        if (!$stmt) {
            return "Prepare failed: " . $this->conn->error;
        }
        
        $stmt->bind_param("sssssi", $name, $email, $password, $phone, $role, $user_id);
        if ($stmt->execute()) {
            return "User updated successfully!";
        } else {
            return "Error updating user: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>
<!-- Xóa user -->
<?php
class AdminUsers {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Xóa dữ liệu trong bảng reviews
    public function deleteReviews($user_id) {
        $sql = "DELETE FROM reviews WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
    }

    // Xóa dữ liệu trong bảng order_items
    public function deleteOrderItems($user_id) {
        $sql = "DELETE FROM order_items WHERE order_id IN (SELECT order_id FROM orders WHERE user_id = ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
    }

    // Xóa dữ liệu trong bảng payments
    public function deletePayments($user_id) {
        $sql = "DELETE FROM payments WHERE order_id IN (SELECT order_id FROM orders WHERE user_id = ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
    }

    // Xóa dữ liệu trong bảng cart
    public function deleteCart($user_id) {
        $sql = "DELETE FROM cart WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
    }

    // Xóa dữ liệu trong bảng orders
    public function deleteOrders($user_id) {
        $sql = "DELETE FROM orders WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
    }

    // Xóa người dùng
    public function deleteUser($user_id) {
        // Tạm thời vô hiệu hóa kiểm tra khóa ngoại
        $this->conn->query("SET FOREIGN_KEY_CHECKS = 0");

        // Xóa dữ liệu liên quan từ các bảng khác trước khi xóa người dùng
        $this->deleteReviews($user_id);
        $this->deleteCart($user_id);
        $this->deleteOrderItems($user_id);
        $this->deletePayments($user_id);
        $this->deleteOrders($user_id); // Đảm bảo xóa orders sau khi đã xóa các item liên quan

        // Xóa người dùng
        $sql = "DELETE FROM users WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);

        // Kiểm tra việc xóa người dùng
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $message = "User deleted successfully!";
            } else {
                $message = "User not found or already deleted.";
            }
        } else {
            $message = "Error deleting user: " . $stmt->error;
        }

        // Bật lại kiểm tra khóa ngoại
        $this->conn->query("SET FOREIGN_KEY_CHECKS = 1");

        return $message;
    }
}


?>

