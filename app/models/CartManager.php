<?php

session_start(); 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gleamcraft";

// Kết nối đến cơ sở dữ liệu
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Kiểm tra xem người dùng đã đăng nhập chưa
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Lấy user_id từ bảng users bằng cách so sánh với thông tin đăng nhập
    $query = "SELECT user_id FROM users WHERE username = ? AND password = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
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
            // Kiểm tra xem sản phẩm đã có trong giỏ hàng của người dùng hay chưa
            $checkQuery = "SELECT * FROM cart WHERE product_id = ? AND user_id = ?";
            $stmt = mysqli_prepare($this->conn, $checkQuery);
            mysqli_stmt_bind_param($stmt, "ii", $product_id, $user_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                // Nếu sản phẩm đã có, cập nhật số lượng
                $updateQuery = "UPDATE cart SET quantity = quantity + ? WHERE product_id = ? AND user_id = ?";
                $updateStmt = mysqli_prepare($this->conn, $updateQuery);
                mysqli_stmt_bind_param($updateStmt, "iii", $quantity, $product_id, $user_id);
                mysqli_stmt_execute($updateStmt);
            } else {
                // Nếu sản phẩm chưa có, thêm mới vào giỏ hàng
                $insertQuery = "INSERT INTO cart (product_id, quantity, product_name, product_image, product_description, product_price, user_id) 
                                VALUES (?, ?, ?, ?, ?, ?, ?)";
                $insertStmt = mysqli_prepare($this->conn, $insertQuery);
                mysqli_stmt_bind_param($insertStmt, "iisssdi", $product_id, $quantity, $product_name, $product_image, $product_description, $product_price, $user_id);
                mysqli_stmt_execute($insertStmt);
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // Lấy tất cả sản phẩm trong giỏ hàng của người dùng
    public function getAllCartItems($user_id)
    {
        try {
            // Lấy các sản phẩm chỉ của người dùng hiện tại
            $query = "SELECT * FROM cart WHERE user_id = ?";
            $stmt = mysqli_prepare($this->conn, $query);
            mysqli_stmt_bind_param($stmt, "i", $user_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            $cartItems = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $cartItems[] = $row;
            }
            return $cartItems;
        } catch (Exception $e) {
            return [];
        }
    }
}

// Nếu có sản phẩm muốn thêm vào giỏ hàng
if (isset($_GET['add_to_cart']) && isset($_GET['product_id']) && isset($_GET['quantity'])) {
    $productId = $_GET['product_id'];
    $quantity = $_GET['quantity'];

    if ($conn) {
        $query = "SELECT p.name, p.image, p.description, p.price FROM products p WHERE p.product_id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $productId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $product = mysqli_fetch_assoc($result);

            $cart = new Cart($conn);
            // Thêm sản phẩm vào giỏ hàng của người dùng
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
