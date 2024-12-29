<?php  
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\core\Db.php');
class User1Model extends Database{
    public function getUserList() {
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
    
    public function deleteUser($user_id) {
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

    $stmt->bind_param("sssssi", $name, $email,$password, $phone, $role, $id);

    if ($stmt->execute()) {
        return true; 
    } else {
        return false; 
    }
}




}

?>