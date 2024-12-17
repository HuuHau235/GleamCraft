<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../../assets/css/product.css">
    <title>Products</title>
</head>
<body>

<div class="container">
    <form class="filter" id="filterForm" method="POST">
        <!-- Lọc theo giới tính -->
        <div class="gender">
            <h2>Gender</h2>
            <label><input type="radio" name="gender" value="male"> Male </label> <br>
            <label><input type="radio" name="gender" value="female"> Female </label> <br>
        </div>
        <div class="underline"></div>

        <!-- Lọc theo loại trang sức -->
        <div class="type">
            <h2>Type of Jewelry</h2>
            <label><input type="radio" name="type" value="ring"> Ring </label> <br>
            <label><input type="radio" name="type" value="necklace"> Necklace </label> <br>
            <label><input type="radio" name="type" value="bracelet"> Bracelet </label> <br>
            <label><input type="radio" name="type" value="earing"> Earring </label> <br>
        </div>
        <div class="underline"></div>

        <!-- Lọc theo màu đá quý -->
        <div class="gem-colors">
            <h2>Gem Colors</h2>
            <label><input type="radio" name="color" value="Red"> <div class="red"></div> Red</label><br>
            <label><input type="radio" name="color" value="Pink"> <div class="pink"></div> Pink</label><br>
            <label><input type="radio" name="color" value="Green"> <div class="green"></div> Green</label><br>
            <label><input type="radio" name="color" value="Blue"> <div class="blue"></div> Blue</label><br>
        </div>
        <div class="underline"></div>

        <!-- Lọc theo giá -->
        <div class="price">
            <details>
                <summary>Price Range</summary>
                <label><input type="radio" name="price" value="400-500"> 400.000vnd - 500.000vnd </label><br>
                <label><input type="radio" name="price" value="500-600"> 500.000vnd - 600.000vnd </label><br>
                <label><input type="radio" name="price" value="600-700"> 600.000vnd - 700.000vnd </label><br>
                <label><input type="radio" name="price" value="700-800"> 700.000vnd - 800.000vnd </label><br>
                <label><input type="radio" name="price" value="800-900"> 800.000vnd - 900.000vnd </label><br>
                <label><input type="radio" name="price" value="900-1000"> 900.000vnd - 1.000.000vnd </label><br>
                <label><input type="radio" name="price" value="1000-2000"> 1.000.000vnd - 2.000.000vnd </label><br>
                <label><input type="radio" name="price" value="2000-5000"> 2.000.000vnd - 5.000.000vnd </label><br>
                <label><input type="radio" name="price" value="5000-10000"> 5.000.000vnd - 10.000.000vnd </label><br>
            </details>
        </div>
        <button type="submit" id="filterBtn">Select</button>
    </form>
</div>

<div class="products" id="productList">
    
</div>
</body>
</html>
