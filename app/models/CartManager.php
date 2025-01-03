<?php
// Khởi động session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gleamcraft";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['user_id'])) {
    echo "Vui lòng đăng nhập!";
    exit();
}

// Lấy user_id từ session
$user_id = (int)$_SESSION['user_id'];

// Lớp xử lý giỏ hàng
class Cart
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function addToCart($product_id, $quantity, $user_id)
    {
        $query = "SELECT name, image, description, price FROM products WHERE product_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            $totalPrice = $quantity * $product['price'];

            $checkQuery = "SELECT * FROM cart WHERE product_id = ? AND user_id = ?";
            $stmtCheck = $this->conn->prepare($checkQuery);
            $stmtCheck->bind_param("ii", $product_id, $user_id);
            $stmtCheck->execute();
            $checkResult = $stmtCheck->get_result();

            if ($checkResult->num_rows > 0) {
                // Nếu đã có sản phẩm, cập nhật số lượng
                $cartItem = $checkResult->fetch_assoc();
                $newQuantity = $cartItem['quantity'] + $quantity;
                $updateQuery = "UPDATE cart SET quantity = ?, product_price = ? WHERE product_id = ? AND user_id = ?";
                $updateStmt = $this->conn->prepare($updateQuery);
                $updateStmt->bind_param("idii", $newQuantity, $totalPrice, $product_id, $user_id);
                $updateStmt->execute();
            } else {
                // Nếu chưa có sản phẩm, thêm mới
                $insertQuery = "INSERT INTO cart (product_id, quantity, product_name, product_image, product_description, product_price, user_id) 
                                VALUES (?, ?, ?, ?, ?, ?, ?)";
                $insertStmt = $this->conn->prepare($insertQuery);
                $insertStmt->bind_param(
                    "iisssdi",
                    $product_id,
                    $quantity,
                    $product['name'],
                    $product['image'],
                    $product['description'],
                    $totalPrice,
                    $user_id
                );
                $insertStmt->execute();
            }
        } else {
            echo "Sản phẩm không tồn tại!";
        }
    }

    // Lấy tất cả sản phẩm trong giỏ hàng
    public function getAllCartItems($user_id)
    {
        $query = "SELECT * FROM cart WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $cartItems = [];
        while ($row = $result->fetch_assoc()) {
            $cartItems[] = $row;
        }
        return $cartItems;
    }

    // Cập nhật giỏ hàng
    public function updateCart($product_id, $quantity)
    {
        if ($quantity <= 0) {
            $query = "DELETE FROM cart WHERE product_id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
        } else {
            $priceQuery = "SELECT price FROM products WHERE product_id = ?";
            $stmtPrice = $this->conn->prepare($priceQuery);
            $stmtPrice->bind_param("i", $product_id);
            $stmtPrice->execute();
            $priceResult = $stmtPrice->get_result();

            if ($priceResult->num_rows > 0) {
                $productPrice = $priceResult->fetch_assoc()['price'];
                $totalPrice = $productPrice * $quantity;

                $updateQuery = "UPDATE cart SET quantity = ?, product_price = ? WHERE product_id = ?";
                $updateStmt = $this->conn->prepare($updateQuery);
                $updateStmt->bind_param("idi", $quantity, $totalPrice, $product_id);
                $updateStmt->execute();
            }
        }
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function deleteFromCart($product_id, $user_id)
    {
        $query = "DELETE FROM cart WHERE product_id = ? AND user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $product_id, $user_id);
        $stmt->execute();
    }
}

// Xử lý các hành động
$cart = new Cart($conn);

if (isset($_GET['add_to_cart'], $_GET['product_id'], $_GET['quantity'])) {
    $product_id = (int)$_GET['product_id'];
    $quantity = (int)$_GET['quantity'];
    $cart->addToCart($product_id, $quantity, $user_id);
    header("Location: ../views/cart/shoping_cart.php");
    exit();
}

if (isset($_GET['update_add_to_cart'], $_GET['product_id'], $_GET['quantity'])) {
    $product_id = (int)$_GET['product_id'];
    $quantity = (int)$_GET['quantity'];
    $cart->updateCart($product_id, $quantity);
    header("Location: ../views/cart/shoping_cart.php");
    exit();
}

if (isset($_GET['delete_add_to_cart'], $_GET['product_id'])) {
    $product_id = (int)$_GET['product_id'];
    $cart->deleteFromCart($product_id, $user_id);

    // Thêm thông báo xác nhận xóa thành công
    echo "<script>
        alert('Xóa sản phẩm thành công!');
        window.location.href = '../views/cart/shoping_cart.php';
    </script>";
    exit();
}
?>
