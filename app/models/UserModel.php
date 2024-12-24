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
        
        if ($stmt) {
            $stmt->bind_param("s", $email); // Liên kết tham số (s = string)
            $stmt->execute();
            $result = $stmt->get_result(); // Lấy kết quả sau khi thực thi
            return $result->fetch_all(MYSQLI_ASSOC); // Trả về mảng kết quả
        }
        
        return [];
    }

    // Thêm người dùng vào cơ sở dữ liệu
    public function registerUser($username, $email, $password, $phone, $role) {
        $stmt = $this->conn->prepare("INSERT INTO users (name, email, password, phone, role) VALUES (?, ?, ?, ?, ?)");
        
        if ($stmt) {
            $stmt->bind_param("sssss", $username, $email, $password, $phone, $role); // Liên kết tham số
            return $stmt->execute(); // Thực thi truy vấn
        }
        
        return false;
    }

    // Kiểm tra và xác định vai trò của người dùng
    public function getRole() {
        $role_check = $this->conn->query("SELECT * FROM users WHERE role = 'admin'");
        
        if ($role_check) {
            $result = $role_check->fetch_all(MYSQLI_ASSOC);
            return (count($result) > 0) ? "user" : "admin";
        }
        
        return "user";
    }
}
?>
<?php
session_start();
class Login_Data
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function login($email, $password)
    {
        try {
            $query = "SELECT * FROM Users WHERE email = ?";
            $stmt = $this->conn->prepare($query);

            if ($stmt === false) {
                return ['success' => false, 'error' => 'prepare_failed'];
            }


            $stmt->bind_param("s", $email);


            $stmt->execute();

            // Lấy kết quả
            $result = $stmt->get_result();
            $user = $result->fetch_assoc(); 

            if ($user) {
                if ($password === $user['password']) { 
                    return ['success' => true, 'user' => $user];
                } else {
                    return ['success' => false, 'error' => 'wrong_password'];
                }
            }
            return ['success' => false, 'error' => 'email_not_found'];
        } catch (Exception $e) {
            return ['success' => false, 'error' => 'query_error', 'message' => $e->getMessage()];
        }
    }

    public function setUserSession($user)
    {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['password'] = $user['password'];
    }
}
