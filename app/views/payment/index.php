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
    <link rel="stylesheet" href="../../../assets/css/header.css">

    <title>Payment</title>
</head>
<body>
<header class="bg-light border-bottom d-flex align-items-center">
    <div class="container-fluid d-flex justify-content-between align-items-center px-4">
        <a href="/" class="navbar-brand d-flex align-items-center">
            <img src="../../../assets/images/brands/logo.jpg" alt="Logo">
        </a>

        <nav>
            <ul class="nav">
                <li class="nav-item"><a href="/" class="nav-link text-dark">Home</a></li>
                <li class="nav-item"><a href="/about" class="nav-link text-dark">About us</a></li>
                <li class="nav-item"><a href="/collections" class="nav-link text-dark">Collection</a></li>
                <li class="nav-item"><a href="http://localhost/GleamCraft/app/controllers/ProductController.php" class="nav-link text-dark">Products</a></li>
                <li class="nav-item"><a href="/brands" class="nav-link text-dark">Brands</a></li>
            </ul>
        </nav>

        <div class="user-icon position-relative">
            <i class="bi bi-person"></i>
            <div class="tooltip-box">
                <a href="../app/views/user/login.php" class="d-block text-dark">Login</a>
                <a href="../app/views/user/register.php" class="d-block text-dark">Register</a>
            </div>
        </div>
    </div>
</header>

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

            <form method="POST" action="../../controllers/PaymentController.php?action=process">
                <div class="infor">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" placeholder="Enter your name" required>

                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" placeholder="Enter your address" required>

                    <label for="phone">Phone:</label>
                    <input type="text" id="phone" name="phone" placeholder="Enter your phone" required>

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

                <div class="total-payment">Total payment: <span class="total"><?php echo number_format($total_price, 2); ?> VND</span></div>
                <button type="submit" class="order-button" onclick="window.location.href='http://localhost/Gleamcraft_MVC/public/'" >Order</button>
            </form>
        </div>
    </div>
    <?php
    require_once "../shared/footer.php";
    ?>
</body>
</html>
