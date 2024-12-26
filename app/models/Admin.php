 <!-- Quản lí review -->

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
<?php
class AdminReviews {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAllReviews() {
        $sql = "SELECT r.review_id, r.product_id, r.user_id, r.comment, r.created_at, 
               u.name AS reviewer_name, 
               p.name AS product_name
        FROM Reviews r
        JOIN Users u ON r.user_id = u.user_id
        JOIN Products p ON r.product_id = p.product_id
        ORDER BY r.created_at DESC";

    
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $reviews = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $reviews[] = $row;
            }
        }
    
        return $reviews;
    }
    
    public function reviewExists($review_id) {
        $sql = "SELECT 1 FROM reviews WHERE review_id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Error preparing the statement: " . $this->conn->error);
        }
        $stmt->bind_param("i", $review_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $exists = $result->num_rows > 0;
        $stmt->close();
        return $exists;
    }

    public function deleteReviewById($review_id) {
        $sql = "DELETE FROM Reviews WHERE review_id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Error preparing the statement: " . $this->conn->error);
        }
        $stmt->bind_param("i", $review_id);
        $result = $stmt->execute();
        if (!$result) {
            die("Error executing query: " . $stmt->error);
        }
        $stmt->close();
        return $result;
    }
}

