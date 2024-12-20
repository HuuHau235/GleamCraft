<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;600&display=swap" rel="stylesheet">
    <base href="http://localhost/GleamCraft/">
    <link rel="stylesheet" href="assets/css/product.css">
    <title>Products</title>
</head>
<body>
<?php include('../shared/header.php'); ?>
<div class="container">
    <form class="filter" action="http://localhost/GleamCraft/app/controllers/ProductController.php" method="POST">
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
                        <a href="http://localhost:8080/Gleamcraft_MVC/public/product/detail/<?php echo htmlspecialchars($product['product_id']); ?>">
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
