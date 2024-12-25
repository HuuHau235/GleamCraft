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
        // $stmt->close();
    }
}
?>
<!-- Xóa user -->
<?php
require_once "../../../config/db.php";
class AdminUsers {
    private $conn;
    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Kiểm tra sự tồn tại của người dùng
    public function checkUser($user_id) {
        $sqlCheckUser = "SELECT * FROM users WHERE user_id = ?";
        $stmtCheck = $this->conn->prepare($sqlCheckUser);
        $stmtCheck->bind_param("i", $user_id);
        $stmtCheck->execute();
        return $stmtCheck->get_result();
    }
    // Kiểm tra có phải là người dùng admin khhoong
    public function isAdmin($user) {
        return $user['role'] == 'admin';
    }

    // Xóa các thanh toán liên quan đến đơn hàng của người dùng
    public function deletePayments($user_id) {
        $sqlDeletePayments = "DELETE FROM payments WHERE order_id IN (SELECT order_id FROM orders WHERE user_id = ?)";
        $stmtDeletePayments = $this->conn->prepare($sqlDeletePayments);
        $stmtDeletePayments->bind_param("i", $user_id);
        $stmtDeletePayments->execute();
    }

    public function deleteOrders($user_id) {
        $sqlDeleteOrders = "DELETE FROM orders WHERE user_id = ?";
        $stmtDeleteOrders = $this->conn->prepare($sqlDeleteOrders);
        $stmtDeleteOrders->bind_param("i", $user_id);
        $stmtDeleteOrders->execute();
    }

    // Xóa người dùng
    public function deleteUser($user_id) {
        $sqlDeleteUser = "DELETE FROM users WHERE user_id = ?";
        $stmtDeleteUser = $this->conn->prepare($sqlDeleteUser);
        $stmtDeleteUser->bind_param("i", $user_id);
        $stmtDeleteUser->execute();
    }
}
?>
