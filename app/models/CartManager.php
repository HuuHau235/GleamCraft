<?php

session_start(); 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gleamcraft";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Kiểm tra xem người dùng đã đăng nhập chưa
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT user_id FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['user_id']; // Lưu user_id vào session
    } else {
        echo "Tên đăng nhập hoặc mật khẩu không đúng!";
        exit();
    }
} elseif (!isset($_SESSION['user_id'])) {
    echo "Vui lòng đăng nhập!";
    exit();
}

// Sử dụng user_id từ session
$user_id = $_SESSION['user_id'];

class Cart
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Hàm thêm sản phẩm vào giỏ hàng
    public function addToCart($product_id, $quantity, $product_name, $product_image, $product_description, $product_price, $user_id)
    {
        try {
            $checkQuery = "SELECT * FROM cart WHERE product_id = ? AND user_id = ?";
            $stmt = $this->conn->prepare($checkQuery);
            $stmt->bind_param("ii", $product_id, $user_id);
            $stmt->execute();
            $result = $stmt->get_result();// LẤY KẾT QUẢ 

            if ($result->num_rows > 0) {
                $cartItem = $result->fetch_assoc(); // Lấy dòng đầu tiên
                $newQuantity = $cartItem['quantity'] + $quantity;
                $newTotalPrice = $newQuantity * $product_price;

                $updateQuery = "UPDATE cart SET quantity = ?, product_price = ? WHERE product_id = ? AND user_id = ?";
                $updateStmt = $this->conn->prepare($updateQuery);
                $updateStmt->bind_param("idii", $newQuantity, $newTotalPrice, $product_id, $user_id);
                $updateStmt->execute();
            } else {// khi trong cart chưa có cột trong giỏ hàng thì thêm vago hàng moiws
                $totalPrice = $quantity * $product_price;
                $insertQuery = "INSERT INTO cart (product_id, quantity, product_name, product_image, product_description, product_price, user_id) 
                                VALUES (?, ?, ?, ?, ?, ?, ?)";
                $insertStmt = $this->conn->prepare($insertQuery);
                $insertStmt->bind_param("iisssdi", $product_id, $quantity, $product_name, $product_image, $product_description, $totalPrice, $user_id);
                $insertStmt->execute();
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // Lấy tất cả sản phẩm trong giỏ hàng của người dùng
    public function getAllCartItems($user_id)
    {
        try {
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
        } catch (Exception $e) {
            return [];
        }
    }
}

// Nếu có sản phẩm muốn thêm vào giỏ hàng và trả về một mảng để dễ gọi
if (isset($_GET['add_to_cart']) && isset($_GET['product_id']) && isset($_GET['quantity'])) {
    $productId = $_GET['product_id'];
    $quantity = $_GET['quantity'];

    if ($conn) {
        $query = "SELECT name, image, description, price FROM products WHERE product_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {// kiểm tra hàng trong db
            $product = $result->fetch_assoc();

            $cart = new Cart($conn);
            $cart->addToCart($productId, $quantity, $product['name'], $product['image'], $product['description'], $product['price'], $user_id);

            // Chuyển hướng đến trang giỏ hàng
            header("Location: ../views/cart/shoping_cart.php");
            exit();
        } else {
            echo "Sản phẩm không tồn tại!";
        }
    } else {
        echo "Không thể kết nối cơ sở dữ liệu!";
    }
}
?>
