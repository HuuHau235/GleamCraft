<?php
// Kết nối cơ sở dữ liệu
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\core\Db.php');

class UserModel extends Database
{
    // Lấy danh sách tất cả người dùng
    public function getUserList()
    {
        $sql = "SELECT * FROM users";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : null;
    }

    // Xóa người dùng theo ID
    public function deleteUser($user_id)
    {
        if (!is_numeric($user_id) || $user_id <= 0) {
            throw new InvalidArgumentException("Invalid user ID.");
        }

        $sql = "DELETE FROM users WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            return $stmt->affected_rows === 1;
        }

        throw new Exception("Failed to prepare delete query.");
    }

    // Lấy thông tin người dùng theo ID
    public function getUserById($id)
    {
        $sql = "SELECT * FROM users WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Cập nhật thông tin người dùng
    public function updateUser($id, $name, $email, $password, $phone, $role)
    {
        $sql = "UPDATE users SET name = ?, email = ?, password = ?, phone = ?, role = ? WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssssi", $name, $email, $password, $phone, $role, $id);
        return $stmt->execute();
    }

    // Đăng nhập
    public function login($email, $password)
    {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Lưu thông tin vào session
            session_start();
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role'];

            return $user;
        } else {
            return null;
        }
    }

    // Lấy vai trò người dùng theo email
    public function getUserRoleByEmail($email)
    {
        $sql = "SELECT role FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($role);
        return $stmt->fetch() ? $role : null;
    }

    // Lấy thông tin người dùng theo email
    public function getUserByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0 ? $result->fetch_assoc() : null;
    }

    // Đếm số lượng admin
    public function getAdminCount()
    {
        $sql = "SELECT COUNT(*) FROM users WHERE role = 'admin'";
        $result = $this->conn->query($sql);
        return $result ? $result->fetch_row()[0] : 0;
    }

    // Đăng ký người dùng
    public function registerUser($name, $password, $email, $phone, $role = "User")
    {
        $checkSql = "SELECT COUNT(*) as user_count FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($checkSql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        if ($row['user_count'] > 0) {
            return ['success' => false, 'message' => 'Email đã tồn tại!'];
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO users (name, password, email, phone, role) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssss", $name, $hashedPassword, $email, $phone, $role);

        if ($stmt->execute()) {
            $user_id = $this->conn->insert_id;

            // Lưu thông tin vào session
            session_start();
            $_SESSION['user_name'] = $name;
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_role'] = $role;

            $stmt->close();
            return ['success' => true];
        }

        return ['success' => false, 'message' => 'Đăng ký thất bại.'];
    }
}
?>
