<?php
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\core\Db.php');

class UserModel extends Database
{

    public function getUserList()
    {
        $sql = "SELECT * FROM users";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return null;
        }
    }

    public function deleteUser($user_id)
    {
        // Kiểm tra nếu user_id hợp lệ (chẳng hạn là một số dương)
        if (!is_numeric($user_id) || $user_id <= 0) {
            throw new InvalidArgumentException("Invalid user ID.");
        }

        // Câu lệnh SQL
        $sql = "DELETE FROM users WHERE user_id = ?";

        // Chuẩn bị câu lệnh
        if ($stmt = $this->conn->prepare($sql)) {
            // Bind tham số
            $stmt->bind_param("i", $user_id);

            // Thực thi câu lệnh
            if ($stmt->execute()) {
                // Kiểm tra số lượng dòng bị ảnh hưởng
                if ($stmt->affected_rows == 1) {
                    return true; // Xóa thành công
                } else {
                    return false; // Không có người dùng nào bị xóa (ID không tồn tại)
                }
            } else {
                throw new Exception("Failed to execute delete query.");
            }
        } else {
            throw new Exception("Failed to prepare query.");
        }
    }

    public function getUserById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function updateUser($id, $name, $email, $password, $phone, $role)
    {
        $sql = "UPDATE users SET name = ?, email = ?, password = ?, phone = ?, role = ? WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssssi", $name, $email, $password, $phone, $role, $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }


    public function login($email, $password)
    {
        // Chuẩn bị câu lệnh SQL để lấy người dùng với email và mật khẩu
        $sql = "SELECT * FROM users WHERE email = ? AND password = ?";
        $stmt = $this->conn->prepare($sql);

        // Liên kết tham số với câu lệnh SQL (sử dụng 'ss' cho email và mật khẩu)
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        // Kiểm tra nếu có người dùng và mật khẩu đúng
        if ($result->num_rows > 0) {
            return $result->fetch_assoc(); // Trả về thông tin người dùng
        } else {
            return null; // Trả về null nếu không tìm thấy người dùng hoặc mật khẩu sai
        }
    }

    public function getUserRoleByEmail($email)
    {
        // Truy vấn cơ sở dữ liệu để lấy vai trò người dùng
        $query = "SELECT role FROM users WHERE email = ?";

        // Sử dụng MySQLi để thực thi truy vấn
        if ($stmt = $this->conn->prepare($query)) {
            // Gắn giá trị email vào tham số truy vấn
            $stmt->bind_param('s', $email);

            // Thực thi truy vấn
            $stmt->execute();

            // Lấy kết quả
            $stmt->bind_result($role);

            if ($stmt->fetch()) {
                return $role;
            } else {
                return null;
            }

            // Đóng kết nối
            // $stmt->close();
        } else {

            return null;
        }
    }

    public function getAdminCount()
    {
        $query = "SELECT COUNT(*) FROM users WHERE role = 'admin'";
        $result = $this->conn->query($query);
        $count = $result->fetch_row();
        return $count[0]; // Trả về số lượng admin
    }

// Đăng ký 
public function registerUser($name, $password, $email, $phone, $role = "User") {
    // Kiểm tra email đã tồn tại
    $checkAccount = "SELECT COUNT(*) as user_count FROM Users WHERE email=?";
    $stmt = $this->conn->prepare($checkAccount);
    if (!$stmt) {
        return ['success' => false, 'message' => 'Lỗi khi chuẩn bị truy vấn kiểm tra email.'];
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close(); // Đóng statement

    if ($row['user_count'] > 0) {
        return ['success' => false, 'message' => 'Email đã tồn tại!'];
    }

    // Thêm người dùng mới
    $sql = "INSERT INTO Users (name, password, email, phone, role) VALUES (?, ?, ?, ?, ?)";
    $stmt = $this->conn->prepare($sql);
    if (!$stmt) {
        return ['success' => false, 'message' => 'Lỗi khi chuẩn bị truy vấn thêm người dùng.'];
    }

    $stmt->bind_param("sssss", $name, $password, $email, $phone, $role);

    if ($stmt->execute()) {
        $stmt->close(); // Đóng statement
        return ['success' => true];
    } else {
        $error = $stmt->error; // Ghi log lỗi chi tiết
        $stmt->close(); // Đóng statement
        return ['success' => false, 'message' => 'Lỗi khi thực hiện truy vấn thêm người dùng: ' . $error];
    }
}

}
?>