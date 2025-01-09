<?php
$products = $data['products'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <link rel="icon" href="../../assets/images/brands/logo.jpg" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="../../../assets/css/header.css"> -->
    <link rel="stylesheet" href="../../../assets/css/product.css">
    <title>GleamCraft</title>
</head>
<body>
<!-- <header class="bg-light border-bottom d-flex align-items-center">
        <div class="container-fluid d-flex justify-content-between align-items-center px-4">
            <a href="/" class="navbar-brand d-flex align-items-center">
                <img src="../../assets/images/brands/logo.jpg" alt="Logo">
            </a>

            <nav>
                <ul class="nav">
                    <li class="nav-item"><a href="/homepage/" class="nav-link text-dark">Home</a></li>
                    <li class="nav-item"><a href="/about" class="nav-link text-dark">About us</a></li>
                    <li class="nav-item"><a href="/collections" class="nav-link text-dark">Collection</a></li>
                    <li class="nav-item"><a href="/Product/" class="nav-link text-dark">Products</a></li>
                    <li class="nav-item"><a href="/brands" class="nav-link text-dark">Brands</a></li>
                </ul>
            </nav>

            <div class="user-icon position-relative">
                <i class="bi bi-person"></i>
                <div class="tooltip-box">
                <a href="/User/login" class="d-block text-dark">Login</a>
                <a href="/User/register" class="d-block text-dark">Register</a>
                </div>
            </div>
        </div>
    </header><br> -->
    <?php require_once(__DIR__ . '/../shared/header.php'); ?>
<div class="containerr">
    <form class="filter" action="/Product/filter" method="POST">
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
                <label><input type="radio" name="price_range" value="400000-500000"> 400.000 VND - 500.000 VND </label><br>
                <label><input type="radio" name="price_range" value="500000-600000"> 500.000 VND - 600.000 VND </label><br>
                <label><input type="radio" name="price_range" value="600000-700000"> 600.000 VND - 700.000 VND </label><br>
                <label><input type="radio" name="price_range" value="700000-800000"> 700.000 VND - 800.000 VND </label><br>
                <label><input type="radio" name="price_range" value="800000-900000"> 800.000 VND - 900.000 VND </label><br>
                <label><input type="radio" name="price_range" value="900000-1000000"> 900.000 VND - 1.000.000 VND </label><br>
                <label><input type="radio" name="price_range" value="1000000-2000000"> 1.000.000 VND - 2.000.000 VND </label><br>
                <label><input type="radio" name="price_range" value="2000000-5000000"> 2.000.000 VND - 5.000.000 VND </label><br>
                <label><input type="radio" name="price_range" value="5000000-10000000"> 5.000.000 VND - 10.000.000 VND </label><br>
            </details>
        </div>
        <button type="submit" id="filterBtn">Select</button>
        <div class="underline"></div>

    </form>

    <div class="products">
    <?php if (!empty($products)): ?>
        <ul>
            <?php foreach ($products as $product): ?>
                <li>
                    <a href="/detail/viewProduct?product_id=<?= $product['product_id']; ?>">
                        <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="Product Image"><br>
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
<?php
    require_once(__DIR__ . '/../shared/footer.php');
    ?>

</body>
</html>
