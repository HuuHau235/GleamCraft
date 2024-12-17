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
        <form class="filter" action="../../controllers/Product.php" method="POST">
            <div class="gender">
                <h2>Gender</h2>
                <label><input type="checkbox" name="male"> Male </label> <br>
                <label><input type="checkbox" name="female"> Female </label> <br>
            </div>

            <div class="type">
                <h2>Type of jewelry</h2>
                <label><input type="checkbox" name="ring"> Ring </label> <br>
                <label><input type="checkbox" name="necklace"> Necklace </label> <br>
                <label><input type="checkbox" name="bracelet"> Braclet </label> <br>
                <label><input type="checkbox" name="earing"> Earing </label> <br>
            </div>

            <div class="gem-colors">
                <h2>Gem Colors</h2>
                <label><input type="checkbox" value="Red"><div class="red"></div> Red</label><br>
                <label><input type="checkbox" value="Pink"><div class="pink"></div> Pink</label><br>
                <label><input type="checkbox" value="Green"><div class="green"></div> Green</label><br>
                <label><input type="checkbox" value="Blue"><div class="blue"></div> Blue</label><br>
            </div>

            <div class="price">
                <h2>Price</h2>
                <label><input type="checkbox" name="price[]" value="400-500"> 400.000vnd - 500.000vnd </label><br>
                <label><input type="checkbox" name="price[]" value="500-600"> 500.000vnd - 600.000vnd </label><br>
                <label><input type="checkbox" name="price[]" value="600-700"> 600.000vnd - 700.000vnd </label><br>
                <label><input type="checkbox" name="price[]" value="700-800"> 700.000vnd - 800.000vnd </label><br>
                <label><input type="checkbox" name="price[]" value="800-900"> 800.000vnd - 900.000vnd </label><br>
                <label><input type="checkbox" name="price[]" value="900-1000"> 900.000vnd - 1.000.000vnd </label><br>
                <label><input type="checkbox" name="price[]" value="1000-2000"> 1.000.000vnd - 2.000.000vnd </label><br>
                <label><input type="checkbox" name="price[]" value="2000-5000"> 2.000.000vnd - 5.000.000vnd </label><br>
                <label><input type="checkbox" name="price[]" value="5000-10000"> 5.000.000vnd  - 10.000.000vnd </label><br>
            </div>
            <button type="submit" id="filterBtn">Select</button>
        </form>
    </div>

    <div class="products" id="productList">

    </div>
</body>
</html>