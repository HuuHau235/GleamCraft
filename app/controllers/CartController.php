<?php
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\core\Controller.php');
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\models\Products.php');
require_once('C:\xampp\htdocs\Gleamcraft_MVC\app\models\CartModel.php');

class CartController extends Controller
{
    // Trang hiển thị giỏ hàng
    public function index()
    {
        $this->startSession(); // Bắt đầu session

        // Lấy giỏ hàng từ session
        $cartItems = $this->getCartItems();

        // Tính tổng tiền giỏ hàng
        $total = $this->calculateCartTotal($cartItems);

        // Hiển thị view giỏ hàng
        $this->view("cart/index", [
            "cartItems" => $cartItems,
            "total" => $total
        ]);
    }

    // Thêm sản phẩm vào giỏ hàng
    public function addToCart($product_id, $quantity)
    {
        $this->startSession(); // Bắt đầu session

        // Kiểm tra dữ liệu đầu vào
        if ($product_id && $quantity > 0) {
            $cartModel = $this->model('CartModel');
            $result = $cartModel->addProductToCart($product_id, $quantity);

            if ($result) {
                header('Location: /Cart/index');
                exit;
            } else {
                echo "Sản phẩm không tồn tại.";
            }
        } else {
            echo "Dữ liệu không hợp lệ.";
        }
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function removeFromCart()
    {
        $this->startSession(); // Bắt đầu session

        $product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : null;

        if ($product_id) {
            $cartModel = $this->model('CartModel');
            $cartModel->removeProductFromCart($product_id);

            header('Location: /Cart/index');
            exit;
        } else {
            echo "Dữ liệu không hợp lệ.";
        }
    }

    // Xóa toàn bộ giỏ hàng
    public function clearCart()
    {
        $this->startSession(); // Bắt đầu session

        $cartModel = $this->model('CartModel');
        $cartModel->clearCart();

        header('Location: /Cart/index');
        exit;
    }

    // Khởi tạo session
    private function startSession()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Lấy giỏ hàng từ session
    private function getCartItems()
    {
        return isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
    }

    // Tính tổng tiền giỏ hàng
    private function calculateCartTotal($cartItems)
    {
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

    
}