<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gleamcraft";

// Kết nối cơ sở dữ liệu
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

class Cart1 {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Hàm cập nhật số lượng và tính lại giá trong giỏ hàng
    public function updateCart($product_id, $quantity) {
        try {
            if ($quantity <= 0) {
                // Xóa sản phẩm nếu số lượng <= 0
                $deleteQuery = "DELETE FROM cart WHERE product_id = ?";
                $deleteStmt = $this->conn->prepare($deleteQuery);
                $deleteStmt->bind_param("i", $product_id);
                $deleteStmt->execute();
            } else {
                // Lấy giá sản phẩm từ bảng products
                $priceQuery = "SELECT price FROM products WHERE product_id = ?";
                $priceStmt = $this->conn->prepare($priceQuery);
                $priceStmt->bind_param("i", $product_id);
                $priceStmt->execute();
                $priceResult = $priceStmt->get_result();

                if ($priceResult->num_rows > 0) {
                    $productPrice = $priceResult->fetch_assoc()['price'];
                    $totalPrice = $productPrice * $quantity;

                    // Cập nhật số lượng và giá trong giỏ hàng
                    $updateQuery = "UPDATE cart SET quantity = ?, product_price = ? WHERE product_id = ?";
                    $updateStmt = $this->conn->prepare($updateQuery);
                    $updateStmt->bind_param("idi", $quantity, $totalPrice, $product_id);
                    $updateStmt->execute();
                }
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // Hàm lấy tất cả sản phẩm trong giỏ hàng
    public function getAllCartItems() {
        $query = "SELECT c.product_id, c.quantity, c.product_price, p.name AS product_name, p.image AS product_image 
                  FROM cart c 
                  INNER JOIN products p ON c.product_id = p.product_id";
        $result = $this->conn->query($query);
        $cartItems = [];
        while ($row = $result->fetch_assoc()) {
            $cartItems[] = $row;
        }
        return $cartItems;
    }
}

// Xử lý cập nhật số lượng sản phẩm trong giỏ hàng
if (isset($_GET['add_to_cart']) && isset($_GET['product_id']) && isset($_GET['quantity'])) {
    $productId = (int)$_GET['product_id'];
    $quantity = (int)$_GET['quantity'];

    if ($conn) {
        // Kiểm tra sản phẩm có tồn tại trong bảng products
        $query = "SELECT product_id FROM products WHERE product_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Cập nhật giỏ hàng
            $cart = new Cart1($conn);
            $cart->updateCart($productId, $quantity);
            header("Location: ../views/cart/shoping_cart.php");
            exit();
        } else {
            echo "Sản phẩm không tồn tại!";
        }
    } else {
        echo "Không thể kết nối cơ sở dữ liệu!";
    }
}

$cart = new Cart1($conn);
$cartItems = $cart->getAllCartItems();
?>
