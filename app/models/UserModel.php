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
    public function searchUsersByAll($query)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE name LIKE ? OR email LIKE ? OR phone LIKE ? OR role LIKE ?");
        $searchTerm = "%" . $query . "%";
        $stmt->bind_param("ssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm); // Liên kết 'name', 'email', 'phone', và 'role' với cùng một biến
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC); 
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
    
            // So sánh trực tiếp mật khẩu
            if ($password === $user['password']) {
                return $user; // Trả về thông tin người dùng nếu mật khẩu đúng
            }
        }
    
        return null; // Trả về null nếu email không tồn tại hoặc mật khẩu không đúng
    }
    

    public function getUserRoleByEmail($email)
    {
        $sql = "SELECT role FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['role'];
        } else {
            return null;
        }
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
    public function registerUser($name, $password, $email, $phone, $role = "user")
{
    // Kiểm tra email đã tồn tại trong cơ sở dữ liệu chưa
    $checkSql = "SELECT COUNT(*) as user_count FROM users WHERE email = ?";
    $stmt = $this->conn->prepare($checkSql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    // Nếu email đã tồn tại, trả về thông báo
    if ($row['user_count'] > 0) {
        return ['success' => false, 'message' => 'Email đã tồn tại!'];
    }

    // Chuyển role thành chữ thường
    $role = strtolower($role);


    // Thực hiện câu lệnh SQL để chèn thông tin người dùng vào cơ sở dữ liệu
    $sql = "INSERT INTO users (name, password, email, phone, role) VALUES (?, ?, ?, ?, ?)";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $password, $email, $phone, $role);

    // Kiểm tra nếu câu lệnh SQL thực thi thành công
    if ($stmt->execute()) {
        $user_id = $this->conn->insert_id;

        // Lưu thông tin người dùng vào session
        session_start();
        $_SESSION['user_name'] = $name;
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_role'] = $role;

        $stmt->close();
        return ['success' => true];
    }

    return ['success' => false, 'message' => 'Đăng ký thất bại.'];
}

    public function getFirstUser()
    {
        // Thực hiện truy vấn SQL để lấy người dùng đầu tiên
        $query = "SELECT * FROM users LIMIT 1";
        
        // Sử dụng kết nối MySQLi để thực thi truy vấn
        $result = $this->conn->query($query);
        
        // Kiểm tra nếu có kết quả trả về
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            // Chuyển tên người dùng thành chữ thường
            // $user['username'] = strtolower($user['username']);
            
            return $user; // Trả về dữ liệu của người dùng đầu tiên đã chuyển thành chữ thường
        } else {
            return null; // Nếu không có người dùng nào, trả về null
        }
    }
    
    
}
?>
