<?php
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\core\Controller.php');
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\models\ProductsModel.php');
require_once('C:\xampp\htdocs\Gleamcraft_MVC\app\models\CartModel.php');

class CartController extends Controller
{
    // Trang hiển thị giỏ hàng
    public function index()
    {
        $this->startSession();
        $user_id = $_SESSION['user_id']; // Lấy user_id từ session

        // Lấy các sản phẩm trong giỏ hàng của người dùng
        $cartItems = $this->getCartItems($user_id);
        $total = $this->calculateCartTotal($cartItems);

        $this->view("cart/index", [
            "cartItems" => $cartItems,
            "total" => $total
        ]);
    }

    private function startSession()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    private function getCartItems($user_id)
    {
        return isset($_SESSION['cart'][$user_id]) ? $_SESSION['cart'][$user_id] : [];
    }

    // Tính tổng tiền giỏ hàng
    private function calculateCartTotal($cartItems)
    {
        return array_reduce($cartItems, function ($total, $item) {
            return $total + ($item['price'] * $item['quantity']);
        }, 0);
    }

    // Thêm sản phẩm vào giỏ hàng
    public function addToCart($product_id, $quantity)
    {
        $this->startSession();
        $user_id = $_SESSION['user_id']; // Lấy user_id từ session

        if ($product_id && $quantity > 0) {
            $cartModel = $this->model('CartModel');
            $result = $cartModel->addProductToCart($user_id, $product_id, $quantity);
            if ($result) {
                header('Location: /Cart/index');
                exit;
            } else {
                $this->showErrorMessage("Sản phẩm không tồn tại.");
            }
        } else {
            $this->showErrorMessage("Dữ liệu không hợp lệ.");
        }
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function removeFromCart($product_id)
    {
        $this->startSession();
        $user_id = $_SESSION['user_id'];

        if ($product_id) {
            $cartModel = $this->model('CartModel');
            $cartModel->removeProductFromCart($user_id, $product_id);
            header('Location: /Cart/index');
            exit;
        } else {
            $this->showErrorMessage("Dữ liệu không hợp lệ.");
        }
    }

    // Tăng số lượng sản phẩm trong giỏ hàng
    public function increaseQuantity($product_id,$quantity)
    {
        $this->startSession();
        $user_id = $_SESSION['user_id'];

        if ($product_id) {
            $cartModel = $this->model('CartModel');
            $success = $cartModel->updateProductQuantity($user_id, $product_id, 1); // Tăng 1 số lượng

            if ($success) {
                $_SESSION['message'] = "Tăng số lượng sản phẩm thành công.";
            } else {
                $_SESSION['error'] = "Không thể tăng số lượng sản phẩm.";
            }

            header('Location: /Cart/index');
            exit;
        } else {
            $_SESSION['error'] = "Dữ liệu không hợp lệ.";
            header('Location: /Cart/index');
            exit;
        }
    }

    // Giảm số lượng sản phẩm trong giỏ hàng
    public function decreaseQuantity($product_id, $quantity)
    {
        $this->startSession();
        $user_id = $_SESSION['user_id'];

        if ($product_id) {
            $cartModel = $this->model('CartModel');
            $success = $cartModel->decreaseProductQuantity($user_id, $product_id, 1); // Giảm 1 số lượng

            if ($success) {
                $_SESSION['message'] = "Giảm số lượng sản phẩm thành công.";
            } else {
                $_SESSION['error'] = "Không thể giảm số lượng sản phẩm.";
            }

            header('Location: /Cart/index');
            exit;
        } else {
            $_SESSION['error'] = "Dữ liệu không hợp lệ.";
            header('Location: /Cart/index');
            exit;
        }
    }

    private function showErrorMessage($message)
    {
        echo "<script>alert('$message');</script>";
        echo "<script>window.location.href='/Cart/index';</script>";
        exit;
    }
}
?>
