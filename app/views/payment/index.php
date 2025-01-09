<?php
$user_id = $_SESSION['user_id']; 
$products = isset($_SESSION['cart'][$user_id]) ? $_SESSION['cart'][$user_id] : [];
$total_price = 0; 
if (!empty($products)) {
    foreach ($products as $item) {
        $total_price += $item['total_price']; 
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../../assets/images/brands/logo.jpg" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../../../assets/css/payment.css">
    <link rel="stylesheet" href="../../../assets/css/header.css">

    <title>Payment</title>
</head>
<body class="body">
<?php require_once(__DIR__ . '/../shared/header.php'); ?>

<div class="underline1"></div>
<div class="g-grid">
    <div class="g-grid-col1">
        <h3>Order</h3>
        <div class="underline2"></div>

        <?php if (empty($products)): ?>
            <p>Your cart is empty. Please add items to your cart.</p>
        <?php else: ?>
            <?php foreach ($products as $item): ?>
                <div class="order-item">
                    <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="Product Image">
                    <div class="order-details">
                        <p class="pname"><?php echo htmlspecialchars($item['name']); ?></p>
                        <p class="price">Price: <span class="total"><?php echo number_format($item['price'], 0); ?> VND</span></p>
                        <p class="qty">Quantity: <span><?php echo htmlspecialchars($item['quantity']); ?></span></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <div class="underline4"></div>
    </div>

    <div class="g-grid-col2">
        <h3>Payment Details</h3>
        <p>Complete your purchase by providing your payment details:</p>
        <div class="underline3"></div>

        <?php if (isset($payment_error)): ?>
            <p class="error-message"><?php echo htmlspecialchars($payment_error); ?></p>
        <?php endif; ?>

        <form id="payment-form" method="POST" action="/Payment/process">
            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">
            <div class="infor">
                <label for="name">Name:</label>
                <input type="text" id="name" name="customer_name" placeholder="Enter your name" required>
                <label for="address">Address:</label>
                <input type="text" id="address" name="customer_address" placeholder="Enter your address" required>
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="customer_phone" placeholder="Enter your phone" required>
                <label for="note">Note:</label>
                <input type="text" id="note" name="customer_note" placeholder="Enter any message">
            </div>

            <div class="payment-method">
                <strong>Payment method: </strong>
                <label>
                    <input type="radio" name="payment" value="cod" required>
                    Cash on Delivery
                </label>
            </div>

            <div class="total-payment">
                Total payment: <span class="total"><?php echo number_format($total_price, 0); ?> VND</span>
            </div>
            <button type="submit" class="order-button">Order</button>
        </form>
    <script>
    document.querySelector('#payment-form').addEventListener('submit', function(event) {
        event.preventDefault(); // Ngăn form gửi ngay lập tức

        const formData = new FormData(this);
        
        fetch('/Payment/process', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: 'Order Successful!',
                    text: 'Thank you for your purchase. Redirecting to the homepage...',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Chuyển hướng đến homepage sau khi nhấn OK
                    window.location.href = '/homepage'; // Thay '/homepage' bằng đường dẫn thực tế của trang chủ
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: data.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error!',
                text: 'There was a problem with your request.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    });
    </script>
    </div>
</div>
<?php require_once(__DIR__ . '/../shared/footer.php'); ?>
</body>
</html>