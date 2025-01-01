<?php
// class PaymentModel {
//     private $conn;

//     public function __construct() {
//         $this->conn = new mysqli('localhost', 'root', '', 'gleamcraft');
//         if ($this->conn->connect_error) {
//             die("Connection failed: " . $this->conn->connect_error);
//         }
//     }

//     public function getCartItems($user_id) {
//         $sql = "SELECT * FROM cart WHERE user_id = ?";
//         $stmt = $this->conn->prepare($sql);
//         $stmt->bind_param('i', $user_id);
//         $stmt->execute();
//         return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
//     }

//     public function getTotal($user_id) {
//         $sql = "SELECT SUM(product_price * quantity) AS total FROM cart WHERE user_id = ?";
//         $stmt = $this->conn->prepare($sql);
//         $stmt->bind_param('i', $user_id);
//         $stmt->execute();
//         $result = $stmt->get_result()->fetch_assoc();
//         return $result['total'] ?? 0; // Trả về 0 nếu giỏ hàng rỗng
//     }

//     public function createOrder($user_id, $name, $address, $phone, $note) {
//         $total = $this->getTotal($user_id);
//         if ($total <= 0) {
//             throw new Exception("Cart is empty, order cannot be created.");
//         }

//         $sql = "INSERT INTO Orders (user_id, total_price, customer_name, customer_address, customer_phone, customer_note) 
//                 VALUES (?, ?, ?, ?, ?, ?)";
//         $stmt = $this->conn->prepare($sql);
//         $stmt->bind_param('idssss', $user_id, $total, $name, $address, $phone, $note);
//         $stmt->execute();
//         return $this->conn->insert_id; // Trả về ID của đơn hàng mới
//     }

//     public function processPayment($order_id, $total_amount) {
//         $sql = "INSERT INTO Payments (order_id, total_amount, payment_date) 
//                 VALUES (?, ?, NOW())";
//         $stmt = $this->conn->prepare($sql);
//         $stmt->bind_param('id', $order_id, $total_amount);
//         $stmt->execute();
//     }

//     public function clearCart($user_id) {
//         $sql = "DELETE FROM cart WHERE user_id = ?";
//         $stmt = $this->conn->prepare($sql);
//         $stmt->bind_param('i', $user_id);
//         $stmt->execute();
//     }
// }

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
