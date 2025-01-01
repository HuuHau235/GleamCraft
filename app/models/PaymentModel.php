<?php
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\core\Db.php');
class PaymentMethod extends Database {
    public function getAllPayment() {
        $sql = "SELECT * FROM payments";  // Đảm bảo lấy tất cả dữ liệu phương thức thanh toán
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);  // Trả về mảng dữ liệu nếu có kết quả
        } else {
            return [];  // Trả về mảng rỗng nếu không có kết quả
        }
    }


    public function deletePayment($payment_id) {
        // Kiểm tra tính hợp lệ của payment_id
        if (!is_numeric($payment_id) || $payment_id <= 0) {
            throw new Exception("Invalid payment_id.");
        }
    
        // Câu lệnh SQL
        $sql = "DELETE FROM payments WHERE payment_id = ?";
    
        // Chuẩn bị câu lệnh
        if ($stmt = $this->conn->prepare($sql)) {
            // Bind tham số
            $stmt->bind_param("i", $payment_id); 
    
            // Thực thi câu lệnh
            if ($stmt->execute()) {
                // Kiểm tra số lượng dòng bị ảnh hưởng
                if ($stmt->affected_rows == 1) {
                    return true; // Xóa thành công
                } else {
                    return false; // Không có bản ghi nào bị xóa (ID không tồn tại)
                }
            } else {
                // Lỗi khi thực thi câu lệnh SQL
                throw new Exception("Failed to execute delete query: " . $stmt->error);
            }
        } else {
            // Lỗi khi chuẩn bị câu lệnh SQL
            throw new Exception("Failed to prepare query: " . $this->conn->error);
        }
    }
    
}
?>
