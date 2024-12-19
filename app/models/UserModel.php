<?php
require_once "../../config/db.php";

class UserModel {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Kiểm tra email đã tồn tại
    public function checkEmailExists($email) {
        $check_email_sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($check_email_sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Thêm người dùng vào cơ sở dữ liệu
    public function registerUser($username, $email, $password, $phone, $role) {
        $stmt = $this->conn->prepare("INSERT INTO users (name, email, password, phone, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $email, $password, $phone, $role);
        return $stmt->execute();
    }

    // Kiểm tra và xác định vai trò của người dùng
    public function getRole() {
        $role_check_sql = "SELECT * FROM users WHERE role = 'admin'";
        $result = $this->conn->query($role_check_sql);
        $role_check = $result->fetch_all(MYSQLI_ASSOC);
        return (count($role_check) > 0) ? "user" : "admin";
    }
}
?>
