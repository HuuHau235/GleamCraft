<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <link rel="icon" href="../assets/images/brands/logo.jpg" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/header.css">
    <!-- <base href="http://localhost/GleamCraft/"> -->
    <!-- <link rel="stylesheet" href="/GleamCraft/assets/css/product.css"> -->
    <title>Products</title>
    <style>
    body {
        font-family: 'Source Sans Pro', sans-serif;
        background-color: #FFFFE9;

    }

    .container {
        display: flex;
        width: 100%;
        margin: 60px 0px 0px 30px;
    }
    .filter {
        width: 28%;
        height: 100%;
        padding: 15px;
    }
    h2 {
        margin-top: 5px;
    }
    label {
        padding-left: 20px;
        cursor: pointer;
        font-size: 20px;
    }
    .underline {
        width: 100%;
        height: 2px;
        background-color: black;
        margin: 15px;
    }
    details summary {
        font-size: 24px;
        font-weight: bold;
        cursor: pointer;
        margin-bottom: 10px;
    }

    .gem-colors label div {
        display: inline-block;
        width: 16px; 
        height: 16px; 
        margin-right: 5px; 
    }
    .gem-colors div.red { background-color: #f00; }
    .gem-colors div.white { background-color: white;}
    .gem-colors div.blue { background-color: #00f; }

    #filterBtn {
        height: 45px;
        width: 100%;
        background-color: black;
        border-radius: 10px;
        border: none;
        color: aliceblue;
        font-size: 25px;
        margin-top: 30px;
        cursor: pointer;
        transition: transform 0.3s ease;
    }
    #filterBtn:hover {
        transition: all 0.3s ease;
        transform: scale(1.1);
        color: aliceblue;
        background-color: rgb(255, 0, 0);
    }

    .products {
        display: flex;
        flex-wrap: wrap;
        gap: 20px; 
        justify-content: space-between; 
        padding: 20px 0 20px 0px;
        list-style: none;
        width: 80%;
        border-left: 2px solid black;
    }

    .products ul {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
        list-style: none;
    }

    .products li {
        width: 205px; 
        border: 1px solid #ddd; 
        border-radius: 5px; 
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
        overflow: hidden;
        text-align: center; 
        background-color: #fff; 
        transition: transform 0.3s ease, box-shadow 0.3s ease; 
    }

    .products li:hover {
        transform: scale(1.05); 
        box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15); 
    }
    .products img {
        width: 100%; 
        height: auto;
        border-bottom: 1px solid #ddd; 
    }

    .products a {
        text-decoration: none; 
        color: #333; 
    }

    .products strong {
        font-weight: 600; 
        display: block;
        margin: 10px 0 5px;
    }

    .products p, .products span {
        font-size: 14px;
        color: #555; 
        margin: 5px 0;
    }

    </style>
</head>
<body>
<header class="bg-light border-bottom d-flex align-items-center">
        <div class="container-fluid d-flex justify-content-between align-items-center px-4">
            <a href="/" class="navbar-brand d-flex align-items-center">
                <img src="../../assets/images/brands/logo.jpg" alt="Logo">
            </a>

            <nav>
                <ul class="nav">
                    <li class="nav-item"><a href="/Gleamcraft_MVC/public" class="nav-link text-dark">Home</a></li>
                    <li class="nav-item"><a href="/about" class="nav-link text-dark">About us</a></li>
                    <li class="nav-item"><a href="/collections" class="nav-link text-dark">Collection</a></li>
                    <li class="nav-item"><a href="/Gleamcraft_MVC/app/controllers/ProductController.php" class="nav-link text-dark">Products</a></li>
                    <li class="nav-item"><a href="/brands" class="nav-link text-dark">Brands</a></li>
                </ul>
            </nav>

            <div class="user-icon position-relative">
                <i class="bi bi-person"></i>
                <div class="tooltip-box">
                    <a href="../../app/views/user/login.php" class="d-block text-dark">Login</a>
                    <a href="../../app/views/user/register.php" class="d-block text-dark">Register</a>
                </div>
            </div>
        </div>
    </header><br>
<div class="container">
    <form class="filter" action="/GleamCraft_MVC/app/controllers/ProductController.php" method="POST">
        <!-- Lọc theo giới tính -->
        <div class="gender">
            <h2>Gender</h2>
            <label><input type="radio" name="gender" value="1"> Male </label><br>
            <label><input type="radio" name="gender" value="0"> Female </label><br>
            <label><input type="radio" name="gender" value="2"> Both </label><br>
        </div>
        <div class="underline"></div>

        <!-- Lọc theo loại trang sức -->
        <div class="category">
            <h2>Type of Jewelry</h2>
            <label><input type="radio" name="type_name" value="ring"> Ring </label><br>
            <label><input type="radio" name="type_name" value="necklace"> Necklace </label><br>
            <label><input type="radio" name="type_name" value="bracelet"> Bracelet </label><br>
            <label><input type="radio" name="type_name" value="earring"> Earring </label><br>
        </div>
        <div class="underline"></div>

        <!-- Lọc theo màu đá quý -->
        <div class="gem-colors">
            <h2>Gem Colors</h2>
            <label><input type="radio" name="color" value="Red"> <div class="red"></div> Red</label><br>
            <label><input type="radio" name="color" value="white"> <div class="white"></div> White</label><br>
            <label><input type="radio" name="color" value="Blue"> <div class="blue"></div> Blue</label><br>
        </div>
        <div class="underline"></div>

        <!-- Lọc theo giá -->
        <div class="price_range">
            <details>
                <summary>Price Range</summary>
                <label><input type="radio" name="price_range" value="400-500"> 400.000vnd - 500.000vnd </label><br>
                <label><input type="radio" name="price_range" value="500-600"> 500.000vnd - 600.000vnd </label><br>
                <label><input type="radio" name="price_range" value="600-700"> 600.000vnd - 700.000vnd </label><br>
                <label><input type="radio" name="price_range" value="700-800"> 700.000vnd - 800.000vnd </label><br>
                <label><input type="radio" name="price_range" value="800-900"> 800.000vnd - 900.000vnd </label><br>
                <label><input type="radio" name="price_range" value="900-1000"> 900.000vnd - 1.000.000vnd </label><br>
                <label><input type="radio" name="price_range" value="1000-2000"> 1.000.000vnd - 2.000.000vnd </label><br>
                <label><input type="radio" name="price_range" value="2000-5000"> 2.000.000vnd - 5.000.000vnd </label><br>
                <label><input type="radio" name="price_range" value="5000-10000"> 5.000.000vnd - 10.000.000vnd </label><br>
            </details>
        </div>
        <button type="submit" id="filterBtn">Select</button>
        <div class="underline"></div>

    </form>

    <div class="products">
        <?php 
        global $products;   
        ?>
        <?php if (!empty($products)): ?>
            <ul>
                <?php foreach ($products as $product): ?>
                    <li>
                        <a href="http://localhost/Gleamcraft_MVC/public/product/detail/<?php echo htmlspecialchars($product['product_id']); ?>">
                            <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="Product Image" ><br>
                            <strong><?php echo htmlspecialchars($product['name']); ?></strong><br>
                            Price: <?php echo number_format($product['price'], 0, ',', '.'); ?> VND<br>
                            Type: <?php echo htmlspecialchars($product['type_name']); ?><br>
                            Color: <?php echo htmlspecialchars($product['color']); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No products found.</p>
        <?php endif; ?>
    </div>
</div>
<!-- <?php include('../shared/footer.php'); ?> -->

</body>
</html>
