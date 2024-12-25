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
    <!-- Order and Payment Details -->
    <div class="g-grid">
        <div class="g-grid-col1">
            <h3>Order</h3>
            <div class="underline2"></div>
            <div class="order-item">
                <img src="../../../assets/images/brands/logo.jpg" alt="...">
                <div class="order-details">
                    <p class="pname">Product name</p>
                    <p class="color">Product color</p>
                    <p class="price">Price: <span>product price</span></p>
                    <p class="qty">Quantity: <span>2</span></p>
                </div>
            </div>
            
            <div class="order-item">
                <img src="../../../assets/images/brands/logo.jpg" alt="...">
                <div class="order-details">
                    <p class="pname">Product name</p>
                    <p class="color">Color: <span>Product color</span></p>
                    <p class="price">Price: <span>product price</span></p>
                    <p class="qty">Quantity: <span>2</span></p>
                </div>
            </div>

            <div class="order-item">
                <img src="../../../assets/images/brands/logo.jpg" alt="...">
                <div class="order-details">
                    <p class="pname">Product name</p>
                    <p class="color">Color: <span>Product color</span></p>
                    <p class="price">Price: <span>product price</span></p>
                    <p class="qty">Quantity: <span>2</span></p>
                </div>
            </div>
            <div class="underline4"></div>
        </div>

        <div class="g-grid-col2">
            <h3>Payment Details</h3>
            <p>Complete your purchase by providing your payment details:</p>
            <div class="underline3"></div>

            <div class="infor">
                <label for="name">Name:</label>
                <input type="text" id="name" placeholder="Enter your name">

                <label for="address">Address:</label>
                <input type="text" id="address" placeholder="Enter your address">

                <label for="phone">Phone:</label>
                <input type="text" id="phone" placeholder="Enter your phone">

                <label for="note">Note:</label>
                <input type="text" id="note" placeholder="Enter any message">

                <div class="total-payment">Total payment: <span class="total" >product total VND</span></div>
                <button class="order-button">Order</button>
            </div>
        </div>
    </div>
</body>
</html>