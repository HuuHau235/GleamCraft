<?php
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\core\Db.php');

class CartModel extends Database
{
    public function getProductById($product_id)
    {
        $sql = "SELECT * FROM products WHERE product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function addProductToCart($product_id, $quantity)
    {
        session_start();

        $product = $this->getProductById($product_id);
        if ($product) {
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }
            if (isset($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id]['quantity'] += $quantity;
                $_SESSION['cart'][$product_id]['total_price'] = $_SESSION['cart'][$product_id]['quantity'] * $product['price'];
            } else {
                $_SESSION['cart'][$product_id] = [
                    'product_id' => $product['product_id'],
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'quantity' => $quantity,
                    'image' => $product['image'],
                    'description' => $product['description'],
                    'total_price' => $quantity * $product['price']
                ];
            }
            $_SESSION['cart_total_price'] = array_sum(array_column($_SESSION['cart'], 'total_price'));
            return true; 
        }
        return false; 
    }

    public function removeProductFromCart($product_id)
    {
        session_start();

        if (isset($_SESSION['cart'][$product_id])) {
            unset($_SESSION['cart'][$product_id]);
            $_SESSION['cart_total_price'] = array_sum(array_column($_SESSION['cart'], 'total_price'));
            return true; // Xóa thành công
        }

        return false; // Sản phẩm không tồn tại
    }

    public function updateProductQuantity($product_id, $quantity)
    {
        session_start();

        if (isset($_SESSION['cart'][$product_id])) {
            // Đảm bảo số lượng không giảm xuống dưới 0
            $_SESSION['cart'][$product_id]['quantity'] += $quantity;
            if ($_SESSION['cart'][$product_id]['quantity'] <= 0) {
                unset($_SESSION['cart'][$product_id]); // Xóa sản phẩm nếu số lượng <= 0
            } else {
                $_SESSION['cart'][$product_id]['total_price'] = $_SESSION['cart'][$product_id]['quantity'] * $_SESSION['cart'][$product_id]['price'];
            }
            $_SESSION['cart_total_price'] = array_sum(array_column($_SESSION['cart'], 'total_price'));
            return true; // Cập nhật thành công
        }

        return false; // Sản phẩm không tồn tại
    }

    public function decreaseProductQuantity($product_id, $quantity)
    {
        session_start();
    
        if (isset($_SESSION['cart'][$product_id])) {
            // Kiểm tra số lượng hiện tại để đảm bảo không giảm xuống dưới 1
            if ($_SESSION['cart'][$product_id]['quantity'] > 1) {
                $_SESSION['cart'][$product_id]['quantity'] -= $quantity;
    
                // Cập nhật tổng giá cho sản phẩm này
                $_SESSION['cart'][$product_id]['total_price'] = $_SESSION['cart'][$product_id]['quantity'] * $_SESSION['cart'][$product_id]['price'];
            } else {
                // Nếu số lượng <= 1, không giảm nữa
                echo "<script>alert('Số lượng sản phẩm không thể nhỏ hơn 1.');</script>";
            }
    
            // Cập nhật tổng giá toàn bộ giỏ hàng
            $_SESSION['cart_total_price'] = array_sum(array_column($_SESSION['cart'], 'total_price'));
            return true; // Cập nhật thành công
        }
    
        return false; // Sản phẩm không tồn tại
    }
    
}
?>
