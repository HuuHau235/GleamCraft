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

        // Lấy thông tin sản phẩm
        $product = $this->getProductById($product_id);

        // Kiểm tra nếu sản phẩm tồn tại
        if ($product) {
            // Kiểm tra nếu giỏ hàng chưa tồn tại, khởi tạo giỏ hàng mới
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
            if (isset($_SESSION['cart'][$product_id])) {
                // Nếu có, tăng số lượng và cập nhật tổng giá
                $_SESSION['cart'][$product_id]['quantity'] += $quantity;
                $_SESSION['cart'][$product_id]['total_price'] = $_SESSION['cart'][$product_id]['quantity'] * $product['price'];
            } else {
                // Nếu chưa có, thêm sản phẩm mới vào giỏ và tính giá
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

            // Cập nhật tổng giá của giỏ hàng
            if (!isset($_SESSION['cart_total_price'])) {
                $_SESSION['cart_total_price'] = 0;
            }

            // Cộng thêm giá trị mới vào tổng giá giỏ hàng
            $_SESSION['cart_total_price'] = array_sum(array_column($_SESSION['cart'], 'total_price'));

            return true; // Trả về true nếu thành công
        }

        return false; // Trả về false nếu sản phẩm không tồn tại
    }
    

    public function removeProductFromCart($product_id)
    {
        session_start();

        if (isset($_SESSION['cart'][$product_id])) {
            unset($_SESSION['cart'][$product_id]);
        }
    }

    public function clearCart()
    {
        session_start();
        $_SESSION['cart'] = [];
    }

    public function getCartItems()
    {
        session_start();
        return isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
    }
}
