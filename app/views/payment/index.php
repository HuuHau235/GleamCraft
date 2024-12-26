<?php
require_once('../../controllers/PaymentController.php');
$obj = new PaymentController();
$products = $obj -> index();
$total_price = $obj -> getTotal();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../assets/css/payment.css">
    <title>Payment</title>
</head>
<body>
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
                        <img src="<?php echo htmlspecialchars($item['product_image']); ?>" alt="Product Image">
                        <div class="order-details">
                            <p class="pname"><?php echo htmlspecialchars($item['product_name']); ?></p>
                            <p class="price">Price: <span><?php echo number_format($item['product_price'], 2); ?> VND</span></p>
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

            <form method="POST" action="../../controllers/UserController.php">
                <div class="infor">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" placeholder="Enter your name">

                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" placeholder="Enter your address">

                    <label for="phone">Phone:</label>
                    <input type="text" id="phone" name="phone" placeholder="Enter your phone">

                    <label for="note">Note:</label>
                    <input type="text" id="note" name="note" placeholder="Enter any message">
                </div>
                
                <div class="payment-method">
                    <strong>Payment method: </strong>
                    <label>
                        <input type="radio" name="payment" value="cod" required>
                        Cash on Delivery
                    </label>
                </div>

                <div class="total-payment">Total payment: <span class="total" ><?php echo number_format($total_price, 2); ?> VND</span></div>
                <button type="submit" class="order-button">Order</button>
            </form>
        </div>
    </div>
    <!-- <div class="success-page">
        <div class="content">
        <div class="icon">
            <img src="../../../assets/images/image_prev_ui.png" alt="Success Icon">
        </div>
        <h1>PAYMENT SUCCESSFUL</h1>
        <p>You have placed your order successfully!</p>
        <button class="home-btn" onclick="window.location.href='#'">GO TO HOMEPAGE</button>
        </div>
    </div> -->
</body>
</html>
