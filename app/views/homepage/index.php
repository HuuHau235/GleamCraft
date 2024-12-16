<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/index.css">
</head>
<body class="body">
<div class="container content-section">
        <div class="row align-items-center">
            <div class="col-md-6">
            <h2 class="h2 highlight-text">Gemstone Rings - Luxurious and Classy</h2>
                <p>                 
                    Gemstone Rings - Luxury and ClassBearing the power and natural beauty of gemstones,
                    gemstone rings are symbols of longevity and class, enhancing the beauty and style of the wearer.
                </p>
            </div>
            <div class="col-md-6 text-center">
                <img src="../assets/images/brands/body_img1.jpg" alt="" style="width: 600px; height: 500px;">
            </div>
        </div>
    </div>
    
    <div class="container content-section">
        <div class="row align-items-center">
            <div class="col-md-6 text-center">
                <img src="../assets/images/brands/body_img5.jpg" alt="" style="width: 600px; height: 500px;">
            </div>
            <div class="col-md-6">
                <p>Build your confidence and enhance your beauty</p>
                <p>Bring health and luck</p>
                <p>Symbol of love and connection</p>
                <p>Increase concentration</p>
                <p>Symbol of success and power</p>
            </div>
        </div>
    </div>

    <div class="container content-section">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h2 class="h2">Adorn yourself with timeless elegance</h2>
                <p>               
                    Celebrate your style with exquisitely crafted jewelry necklaces that reflect your beauty and personality. 
                    Each design is a blend of artistry and sophistication, giving you a lasting impression.
                </p>
            </div>
            <div class="col-md-6 text-center">
                <img src="../assets/images/brands/body_img6.jpg" alt="" style="width: 600px; height: 500px;">
            </div>
        </div>
    </div>

    <div class="container content-section">
        <div class="row align-items-center">
            <div class="col-md-6 text-center">
                <img src="../assets/images/brands/body_img7.jpg" alt="" style="width: 600px; height: 500px;">
            </div>
            <div class="col-md-6">
                <h2 class="h2">Shine bright in just three simple steps</h2>
                <h4>Choose your style</h4>
                <p>            
                    Explore our diverse collection of earrings to find the style that suits your style. Choose a design that reflects your personality and elegance.
                </p>
                <h4>Customize your diamond</h4>
                <p>
                    Highlight your own beauty by customizing your diamond: choose the size, cut, and material. Each choice creates a unique piece just for you.
                </p>
                <h4>Wear with confidence</h4>
                <p>
                    Complete your look with these exquisitely crafted earrings. Shine confidently at any event.
                </p>
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <h2 class="mb-4">Diamond products</h2>
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-md-3 mb-4">
                    <div class="card">
                    <a href="/Gleamcraft_MVC/public/product/detail/<?= $product['product_id'] ?>">
                            <img src="../assets/images/brands/<?= $product['image'] ?>" class="card-img-top" alt="<?= $product['name'] ?>" style="height: 300px;">
                        </a>
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= $product['name'] ?></h5>
                            <p class="card-text"><?= number_format($product['price'], 0, ',', '.') ?> VNĐ</p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="../assets/js/homepage.js"></script>
</body>
</html>