<?php
require_once 'C:\xampp\htdocs\GleamCraft_MVC\config\db.php';

class Cart {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Add product to cart
    public function addToCart($product_id, $quantity, $product_name, $product_image, $product_description, $product_price) {
        try {
            // Check if product already exists in the cart
            $checkQuery = "SELECT * FROM cart WHERE product_id = :product_id";
            $stmt = $this->conn->prepare($checkQuery);
            $stmt->bindParam(':product_id', $product_id);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                // If product exists, update quantity
                $updateQuery = "UPDATE cart SET quantity = quantity + :quantity WHERE product_id = :product_id";
                $updateStmt = $this->conn->prepare($updateQuery);
                $updateStmt->bindParam(':quantity', $quantity);
                $updateStmt->bindParam(':product_id', $product_id);
                $updateStmt->execute();
            } else {
                // If product does not exist, insert it into the cart
                $insertQuery = "INSERT INTO cart (product_id, quantity, product_name, product_image, product_description, product_price) 
                                VALUES (:product_id, :quantity, :product_name, :product_image, :product_description, :product_price)";
                $stmt = $this->conn->prepare($insertQuery);
                $stmt->execute([
                    ':product_id' => $product_id,
                    ':quantity' => $quantity,
                    ':product_name' => $product_name,
                    ':product_image' => $product_image,
                    ':product_description' => $product_description,
                    ':product_price' => $product_price
                ]);
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // Get all products in the cart
    public function getAllCartItems() {
        try {
            $query = "SELECT * FROM cart";  
            $stmt = $this->conn->prepare($query);                                 
            $stmt->execute();               
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }
}

// Handle adding product to cart when user clicks "Add to Cart"
if (isset($_GET['add_to_cart']) && isset($_GET['product_id']) && isset($_GET['quantity'])) {
    $productId = $_GET['product_id']; // Product ID
    $quantity = $_GET['quantity']; // Quantity of the product

    if ($conn) {
        // Get product details from the products table
        $query = "SELECT p.name, p.image, p.description, p.price FROM products p WHERE p.product_id = :product_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':product_id', $productId);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            // Add or update product in the cart
            $cart = new Cart($conn);
            $cart->addToCart($productId, $quantity, $product['name'], $product['image'], $product['description'], $product['price']);
            
            // Redirect to shopping_cart page
            header("Location:../views/cart/shoping_cart.php");
            exit(); // Ensure the script stops here after redirection
        } else {
            echo "Sản phẩm không tồn tại!";
        }
    } else {
        echo "Không thể kết nối cơ sở dữ liệu!";
    }
}

// Display cart
$cart = new Cart($conn);
$cartItems = $cart->getAllCartItems();
?>
