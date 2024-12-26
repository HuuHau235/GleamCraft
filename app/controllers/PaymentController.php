<?php
require_once __DIR__ . '/../models/PaymentModel.php';


class PaymentController {
    public function index() {


        $paymentModel = new PaymentModel();
        $products = $paymentModel->getCartItems($_SESSION['user_id']);
        $total = $paymentModel->getTotal($_SESSION['user_id']);
        return $products;
    }

    public function getTotal() {

        $paymentModel = new PaymentModel();
        $products = $paymentModel->getCartItems($_SESSION['user_id']);
        $total = $paymentModel->getTotal($_SESSION['user_id']);
        return $total;
    }

    

    public function processPayment() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ../views/user/login.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = trim($_POST['name'] ?? '');
            $address = trim($_POST['address'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $note = trim($_POST['note'] ?? '');

            if (empty($name) || empty($address) || empty($phone)) {
                $_SESSION['error'] = "Vui lòng điền đầy đủ thông tin!";
                header('Location: ./views/payment/index.php');
                exit;
            }

            $paymentModel = new PaymentModel();
            try {
                $order_id = $paymentModel->createOrder($_SESSION['user_id'], $name, $address, $phone, $note);
                $total_amount = $paymentModel->getTotal($_SESSION['user_id']);
                $paymentModel->processPayment($order_id, $total_amount);
                $paymentModel->clearCart($_SESSION['user_id']);
                
                $_SESSION['success'] = "Thanh toán thành công!";
                header('Location: ../views/payment/index.php');
                exit;
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                header('Location: ../views/payment/index.php');
                exit;
            }
        }
    }
}
?>
