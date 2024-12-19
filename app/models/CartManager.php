<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gleamcraft";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
class Cart
{
    private $conn;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function addToCart($product_id, $quantity, $product_name, $product_image, $product_description, $product_price)
    {
        try {
            $checkQuery = "SELECT * FROM cart WHERE product_id = ?";
            $stmt = mysqli_prepare($this->conn, $checkQuery);
            mysqli_stmt_bind_param($stmt, "i", $product_id); // i for integer
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                $updateQuery = "UPDATE cart SET quantity = quantity + ? WHERE product_id = ?";
                $updateStmt = mysqli_prepare($this->conn, $updateQuery);
                mysqli_stmt_bind_param($updateStmt, "ii", $quantity, $product_id); // ii for two integers
                mysqli_stmt_execute($updateStmt);
            } else {

                $insertQuery = "INSERT INTO cart (product_id, quantity, product_name, product_image, product_description, product_price) 
                                VALUES (?, ?, ?, ?, ?, ?)";
                $insertStmt = mysqli_prepare($this->conn, $insertQuery);
                mysqli_stmt_bind_param($insertStmt, "iisssd", $product_id, $quantity, $product_name, $product_image, $product_description, $product_price);
                // i for integer, s for string, d for double (float)
                mysqli_stmt_execute($insertStmt);
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // Get all products in the cart
    public function getAllCartItems()
    {
        try {
            $query = "SELECT * FROM cart";
            $result = mysqli_query($this->conn, $query);
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


if (isset($_GET['add_to_cart']) && isset($_GET['product_id']) && isset($_GET['quantity'])) {
    $productId = $_GET['product_id'];
    $quantity = $_GET['quantity']; 

    if ($conn) {
        $query = "SELECT p.name, p.image, p.description, p.price FROM products p WHERE p.product_id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $productId); // i for integer
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $product = mysqli_fetch_assoc($result);

            $cart = new Cart($conn);
            $cart->addToCart($productId, $quantity, $product['name'], $product['image'], $product['description'], $product['price']);

            header("Location:../views/cart/shoping_cart.php");
            exit(); 
        } else {
            echo "Sản phẩm không tồn tại!";
        }
    } else {
        echo "Không thể kết nối cơ sở dữ liệu!";
    }
}

$cart = new Cart($conn);
$cartItems = $cart->getAllCartItems();
?>