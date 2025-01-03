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
        $cartItems = $this->getCartItems();
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

    private function getCartItems()
    {
        return isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
    }

    // Tính tổng tiền giỏ hàng
    private function calculateCartTotal($cartItems)
    {
        return array_reduce($cartItems, function ($total, $item) {
            return $total + ($item['price'] * $item['quantity']);
        }, 0);
    }

    public function addToCart($product_id, $quantity)
    {
        $this->startSession();

        if ($product_id && $quantity > 0) {
            $cartModel = $this->model('CartModel');
            $result = $cartModel->addProductToCart($product_id, $quantity);
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

    public function removeFromCart($product_id)
    {
        $this->startSession();
        if ($product_id) {
            $cartModel = $this->model('CartModel');
            $cartModel->removeProductFromCart($product_id);
            header('Location: /Cart/index');
            exit;
        } else {
            $this->showErrorMessage("Dữ liệu không hợp lệ.");
        }
    }

    public function increaseQuantity($product_id, $quantity)
    {
        $this->startSession();

        $product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : null;

        if ($product_id) {
            $cartModel = $this->model('CartModel');
            $success = $cartModel->updateProductQuantity($product_id, 1);

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


    public function decreaseQuantity($product_id, $quantity)
    {
        $this->startSession();

        $product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : null;

        if ($product_id) {
            $cartModel = $this->model('CartModel');
            $success = $cartModel->decreaseProductQuantity($product_id, 1);

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
    private function showErrorMessage($message)
    {
        echo "<script>alert('$message');</script>";
        echo "<script>window.location.href='/Cart/index';</script>";
        exit;
    }
}
?>
