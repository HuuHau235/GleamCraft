<?php
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\core\Db.php');

class PaymentModel extends Database
{
    public function processPayment($user_id, $customer_info)
    {
    

        if (!isset($_SESSION['cart'][$user_id]) || empty($_SESSION['cart'][$user_id])) {
            throw new Exception("Cart is empty. Cannot process payment.");
        }

        // Kiểm tra thông tin khách hàng
        if (empty($customer_info['name']) || empty($customer_info['address']) || empty($customer_info['phone'])) {
            throw new Exception("Customer information is incomplete.");
        }

        // Tính tổng tiền từ session
        $total_amount = 0;
        $products = [];

        foreach ($_SESSION['cart'][$user_id] as $item) {
            $total_amount += $item['total_price'];
            $products[] = $item; // Thêm sản phẩm vào mảng
        }

        // Thêm đơn hàng vào bảng Orders
        $sql = "INSERT INTO Orders (user_id, total_price, customer_name, customer_address, customer_phone, customer_note)
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "idssss",
            $user_id,
            $total_amount,
            $customer_info['name'],
            $customer_info['address'],
            $customer_info['phone'],
            $customer_info['note']
        );

        if (!$stmt->execute()) {
            throw new Exception("Failed to create order: " . $stmt->error);
        }

        $order_id = $this->conn->insert_id; // Lấy ID của đơn hàng mới

        // Lưu thông tin thanh toán vào bảng Payments
        $payment_sql = "INSERT INTO Payments (order_id, total_amount, payment_date) VALUES (?, ?, NOW())";

        $payment_stmt = $this->conn->prepare($payment_sql);
        $payment_stmt->bind_param("id", $order_id, $total_amount);

        if (!$payment_stmt->execute()) {
            throw new Exception("Failed to record payment: " . $payment_stmt->error);
        }

        // Xóa giỏ hàng sau khi thanh toán
        unset($_SESSION['cart'][$user_id]);

        return ['order_id' => $order_id, 'products' => $products]; // Trả về ID đơn hàng và sản phẩm
    }

    public function getAllPayments()
    {
        $sql = "SELECT * FROM Payments"; // Lấy tất cả dữ liệu thanh toán
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC) ?: []; // Trả về mảng dữ liệu hoặc mảng rỗng nếu không có kết quả
    }

    public function deletePayment($payment_id)
    {
        // Kiểm tra tính hợp lệ của payment_id
        if (!is_numeric($payment_id) || $payment_id <= 0) {
            throw new Exception("Invalid payment_id.");
        }

        $sql = "DELETE FROM Payments WHERE payment_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $payment_id);

        if ($stmt->execute() && $stmt->affected_rows === 1) {
            return true; // Xóa thành công
        } elseif ($stmt->affected_rows === 0) {
            return false; // Không tìm thấy payment_id
        } else {
            throw new Exception("Failed to delete payment: " . $stmt->error);
        }
    }

    // Phương thức để lấy sản phẩm liên quan đến đơn hàng
    public function getProductsByOrderId($order_id)
    {
        $sql = "SELECT * FROM OrderItems WHERE order_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC) ?: []; // Trả về mảng sản phẩm hoặc mảng rỗng
    }
}
?>