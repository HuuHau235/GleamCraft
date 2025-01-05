<?php
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\core\Db.php');

class CartModel extends Database
{
    // Lấy sản phẩm theo ID
    public function getProductById($product_id)
    {
        $sql = "SELECT * FROM products WHERE product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Thêm sản phẩm vào giỏ hàng của người dùng
    public function addProductToCart($user_id, $product_id, $quantity)
    {
        session_start();

        $product = $this->getProductById($product_id);
        if ($product) {
            // Kiểm tra và khởi tạo giỏ hàng nếu chưa có
            if (!isset($_SESSION['cart'][$user_id])) {
                $_SESSION['cart'][$user_id] = [];
            }
            // Kiểm tra nếu sản phẩm đã có trong giỏ hàng, tăng số lượng
            if (isset($_SESSION['cart'][$user_id][$product_id])) {
                $_SESSION['cart'][$user_id][$product_id]['quantity'] += $quantity;
                $_SESSION['cart'][$user_id][$product_id]['total_price'] = $_SESSION['cart'][$user_id][$product_id]['quantity'] * $product['price'];
            } else {
                // Nếu sản phẩm chưa có trong giỏ, thêm mới vào giỏ
                $_SESSION['cart'][$user_id][$product_id] = [
                    'product_id' => $product['product_id'],
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'quantity' => $quantity,
                    'image' => $product['image'],
                    'description' => $product['description'],
                    'total_price' => $quantity * $product['price']
                ];
            }
            // Cập nhật tổng tiền của giỏ hàng
            // $_SESSION['cart_total_price'][$user_id] = array_sum(array_column($_SESSION['cart'][$user_id], 'total_price'));
            return true;
        }
        return false; // Sản phẩm không tồn tại
    }

    // Xóa sản phẩm khỏi giỏ hàng của người dùng
    public function removeProductFromCart($user_id, $product_id)
    {
        // session_start();

        if (isset($_SESSION['cart'][$user_id][$product_id])) {
            unset($_SESSION['cart'][$user_id][$product_id]);
            // $_SESSION['cart_total_price'][$user_id] = array_sum(array_column($_SESSION['cart'][$user_id], 'total_price'));
            return true; // Xóa thành công
        }

        return false; // Sản phẩm không tồn tại trong giỏ hàng
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng của người dùng
    public function updateProductQuantity($user_id, $product_id, $quantity)
    {
        // session_start();

        if (isset($_SESSION['cart'][$user_id][$product_id])) {
            // Cập nhật số lượng sản phẩm
            $_SESSION['cart'][$user_id][$product_id]['quantity'] += $quantity;
            if ($_SESSION['cart'][$user_id][$product_id]['quantity'] <= 0) {
                unset($_SESSION['cart'][$user_id][$product_id]); // Nếu số lượng <= 0, xóa sản phẩm
            } else {
                $_SESSION['cart'][$user_id][$product_id]['total_price'] = $_SESSION['cart'][$user_id][$product_id]['quantity'] * $_SESSION['cart'][$user_id][$product_id]['price'];
            }
            // Cập nhật lại tổng tiền giỏ hàng
            // $_SESSION['cart_total_price'][$user_id] = array_sum(array_column($_SESSION['cart'][$user_id], 'total_price'));
            return true; // Cập nhật thành công
        }

        return false; // Sản phẩm không tồn tại
    }

    // Giảm số lượng sản phẩm trong giỏ hàng của người dùng
    public function decreaseProductQuantity($user_id, $product_id, $quantity)
    {
        // session_start();

        if (isset($_SESSION['cart'][$user_id][$product_id])) {
            if ($_SESSION['cart'][$user_id][$product_id]['quantity'] > 1) {
                $_SESSION['cart'][$user_id][$product_id]['quantity'] -= $quantity;
                $_SESSION['cart'][$user_id][$product_id]['total_price'] = $_SESSION['cart'][$user_id][$product_id]['quantity'] * $_SESSION['cart'][$user_id][$product_id]['price'];
            } else {
                echo "<script>alert('Số lượng sản phẩm không thể nhỏ hơn 1.');</script>";
            }
            // $_SESSION['cart_total_price'][$user_id] = array_sum(array_column($_SESSION['cart'][$user_id], 'total_price'));
            return true; // Cập nhật thành công
        }

        return false; // Sản phẩm không tồn tại
    }
}
?>
