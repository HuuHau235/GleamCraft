<?php
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\core\Controller.php');
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\models\PaymentModel.php');

class PaymentController extends Controller
{
    protected $paymentModel;

    public function __construct()
    {
        $this->paymentModel = new PaymentModel();
    }
    public function index()
    {
        session_start();
        $user_id = $_SESSION['user_id']; // Lấy user_id từ session
        $products = isset($_SESSION['cart'][$user_id]) ? $_SESSION['cart'][$user_id] : [];
        // Tính tổng giá
        $total_price = 0;
        if (!empty($products)) {
            foreach ($products as $item) {
                $total_price += $item['total_price'];
            }
        }
        // Gọi view và truyền dữ liệu tới nó
        $this->view("payment/index", [
            "products" => $products,
            "total_price" => $total_price
        ]);
    }

    // Phương thức xử lý thanh toán
    public function process()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            $user_id = $_POST['user_id'] ?? null;

            if (!is_numeric($user_id) || $user_id <= 0) {
                echo json_encode([
                    "success" => false,
                    "message" => "Invalid user ID."
                ]);
                return;
            }

            $customer_info = [
                'name' => $_POST['customer_name'] ?? '',
                'address' => $_POST['customer_address'] ?? '',
                'phone' => $_POST['customer_phone'] ?? '',
                'note' => $_POST['customer_note'] ?? ''
            ];

            try {
                $result = $this->paymentModel->processPayment($user_id, $customer_info);
                $order_id = $result['order_id'];

                // Xóa sản phẩm khỏi giỏ hàng
                unset($_SESSION['cart'][$user_id]);

                // Trả về thông tin đơn hàng
                echo json_encode([
                    "success" => true,
                    "order_id" => $order_id,
                    "products" => $result['products'] // Nếu cần thiết
                ]);
                return;
            } catch (Exception $e) {
                echo json_encode([
                    "success" => false,
                    "message" => $e->getMessage()
                ]);
            }
        }
    }

    // Phương thức xóa thanh toán
    public function delete($payment_id)
    {
        try {
            $isDeleted = $this->paymentModel->deletePayment($payment_id);
            if ($isDeleted) {
                echo json_encode([
                    "success" => true,
                    "message" => "Payment deleted successfully."
                ]);
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => "Payment not found."
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
    }
}
?>