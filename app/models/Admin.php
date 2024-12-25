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
require_once "../../../config/db.php";
class AdminUsers {
    private $conn;
    public function __construct($conn) {
        $this->conn = $conn;
    }
    public function deleteUser($user_id) {
        $sqlDeleteUser = "DELETE FROM users WHERE user_id = ?";
        $stmtDeleteUser = $this->conn->prepare($sqlDeleteUser);
        $stmtDeleteUser->bind_param("i", $user_id);
        if ($stmtDeleteUser->execute()) {
            if ($stmtDeleteUser->affected_rows > 0) {
                return "User deleted successfully!";
            } else {
                return "User not found or already deleted.";
            }
        } else {
            return "Error deleting user: " . $stmtDeleteUser->error;
        }
    }
}
?>
