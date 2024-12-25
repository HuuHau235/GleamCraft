<?php
require_once '../models/PaymentModel.php';

class PaymentController {
    public function index() {
        // Kiểm tra session người dùng
        if (!isset($_SESSION['user_id'])) {
            header('Location: login.php');
            exit;
        }

        // Lấy thông tin sản phẩm từ giỏ hàng
        $paymentModel = new PaymentModel();
        $products = $paymentModel->getCartItems($_SESSION['user_id']);
        
        // Lấy thông tin tổng thanh toán
        $total = $paymentModel->getTotal($_SESSION['user_id']);

        // Hiển thị view
        require_once '../views/payment/index.php';
    }

    public function processPayment() {
        // Kiểm tra session người dùng
        if (!isset($_SESSION['user_id'])) {
            header('Location: login.php'); // Không cần thiết lắm
            exit;
        }

        // Kiểm tra dữ liệu từ form
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $address = $_POST['address'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $note = $_POST['note'] ?? '';
            $payment_method = $_POST['payment'] ?? '';

            // Kiểm tra các trường bắt buộc
            if (empty($name) || empty($address) || empty($phone)) {
                $_SESSION['error'] = "Vui lòng điền đầy đủ thông tin!";
                header('Location: index.php?controller=payment&action=index'); //chỉnh thành thông báo nè
                exit;
            }

            // Thêm đơn hàng và thanh toán vào cơ sở dữ liệu
            $paymentModel = new PaymentModel();
            $order_id = $paymentModel->createOrder($_SESSION['user_id'], $name, $address, $phone, $note, $payment_method);
            $paymentModel->processPayment($order_id, $payment_method);

            // Xóa sản phẩm đã đặt từ giỏ hàng
            $paymentModel->clearCart($_SESSION['user_id']);

            // Lưu thông báo thành công
            $_SESSION['success'] = "Đặt hàng thành công!";
            header('Location: index.php?controller=payment&action=index'); //chỉnh thành thông báo nè
            exit;
        }
    }
}
?>
