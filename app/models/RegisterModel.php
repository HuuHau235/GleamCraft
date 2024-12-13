<?php
require_once "../../config/db.php";

class RegisterModel {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Kiểm tra email đã tồn tại
    public function checkEmailExists($email) {
        $check_email_sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($check_email_sql);
        $stmt->execute([$email]);
        return $stmt->fetchAll();
    }

    // Thêm người dùng vào cơ sở dữ liệu
    public function registerUser($username, $email, $password, $phone, $role) {
        $stmt = $this->conn->prepare("INSERT INTO users (name, email, password, phone, role) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$username, $email, $password, $phone, $role]);
    }

    // Kiểm tra và xác định vai trò của người dùng
    public function getRole() {
        $role_check = $this->conn->query("SELECT * FROM users WHERE role = 'admin'")->fetchAll();
        return (count($role_check) > 0) ? "user" : "admin";
    }
}
?>
