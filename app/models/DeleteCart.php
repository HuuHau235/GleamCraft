<?php
session_start();
$host = 'localhost'; 
$db_name = 'gleamcraft'; 
$username = 'root';
$password = ''; 

$conn = new mysqli($host, $username, $password, $db_name);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

if (isset($_GET['product_id'])) {
    $product_id = (int) $_GET['product_id'];  
} else {
    die("Không có sản phẩm để xóa.");
}

$stmtCheck = $conn->prepare("SELECT * FROM cart WHERE product_id = ?");
$stmtCheck->bind_param('i', $product_id); 
$stmtCheck->execute();
$stmtCheck->store_result(); 

if ($stmtCheck->num_rows === 0) {
    die("Sản phẩm không tồn tại trong giỏ hàng.");
}

// Xóa sản phẩm khỏi giỏ hàng
$stmtDelete = $conn->prepare("DELETE FROM cart WHERE product_id = ?");
$stmtDelete->bind_param('i', $product_id); 
$stmtDelete->execute();

if ($stmtDelete->affected_rows > 0) {
    echo "<script>
        alert('Xóa sản phẩm thành công!');
        window.location.href = '../views/cart/shoping_cart.php';
    </script>";
} else {
    echo "<script>
        alert('Không có sản phẩm nào bị xóa.');
        window.location.href = '../views/cart/shoping_cart.php';  
    </script>";
}

$stmtCheck->close();
$stmtDelete->close();
$conn->close();
?>
