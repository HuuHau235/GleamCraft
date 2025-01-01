<?php
    require_once('C:\xampp\htdocs\GleamCraft_MVC\app\controllers\ProductController.php');
    $products = $data['productHomepage']; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/images/brands/logo.jpg" type="image/x-icon">
    <title>GleamCraft</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/index.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/banner.css">
</head>
<body class="body">
    <header class="bg-light border-bottom d-flex align-items-center">
        <div class="container-fluid d-flex justify-content-between align-items-center px-4">
            <a href="/" class="navbar-brand d-flex align-items-center">
                <img src="/assets/images/brands/logo.jpg" alt="Logo">
            </a>

            <nav>
                <ul class="nav">
                    <li class="nav-item"><a href="" class="nav-link text-dark">Home</a></li>
                    <li class="nav-item"><a href="/about" class="nav-link text-dark">About us</a></li>
                    <li class="nav-item"><a href="/collections" class="nav-link text-dark">Collection</a></li>
                    <li class="nav-item"><a href="/Gleamcraft_MVC/app/controllers/ProductController.php" class="nav-link text-dark">Products</a></li>
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
    </header>
    <div class="banner">
        <img src="/assets/images/brands/Day-chuyen-1.jpg" alt="Banner Image">
        <div class="banner-text">Welcome to GleamCraft </div>
    </div> <br> 

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
                <img src="/assets/images/brands/body_img1.jpg" alt="" style="width: 600px; height: 500px;">
            </div>
        </div>
    </div>
    
    <div class="container content-section">
        <div class="row align-items-center">
            <div class="col-md-6 text-center">
                <img src="/assets/images/brands/body_img5.jpg" alt="" style="width: 600px; height: 500px;">
            </div>
            <div class="col-md-6">
                <h2 class="h2 highlight-text">Benefits of wearing jewelry</h2>
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
                <h2 class="h2 highlight-text">Adorn yourself with timeless elegance</h2>
                <p>               
                    Celebrate your style with exquisitely crafted jewelry necklaces that reflect your beauty and personality. 
                    Each design is a blend of artistry and sophistication, giving you a lasting impression.
                </p>
            </div>
            <div class="col-md-6 text-center">
                <img src="/assets/images/brands/body_img6.jpg" alt="" style="width: 600px; height: 500px;">
            </div>
        </div>
    </div>

    <div class="container content-section">
        <div class="row align-items-center">
            <div class="col-md-6 text-center">
                <img src="/assets/images/brands/body_img7.jpg" alt="" style="width: 600px; height: 500px;">
            </div>
            <div class="col-md-6">
                <h2 class="h2 highlight-text">Shine bright in just three simple steps</h2>
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
        <h2 class="mb-4">Diamond Products</h2>
        <div class="row">
            <?php if (isset($data['productHomepage']) && is_array($data['productHomepage'])): ?>
                <?php foreach ($data['productHomepage'] as $product): ?>
                    <div class="col-md-3 mb-4">
                        <div class="card" style="height: 450px;">
                        <a href="/Gleamcraft_MVC/public/product/detail/<?= $product['product_id']; ?>">
                           <img src="<?= $product['image'] ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']) ?>" style="height: 300px; object-fit: cover;">
                            </a>
                            <div class="card-body text-center">
                                <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                                <p class="card-text"><?= number_format($product['price'], 0, ',', '.') ?> VNĐ</p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No diamond products available.</p>
            <?php endif; ?>
        </div>
    </div>
    <footer class="bg-dark text-light py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h5>GleamCraft</h5>
                    <p>GleamCraft is a supplier of high-end and luxury diamond jewelry.</p>
                </div>
                <div class="col-md-3">
                <h5>GleamCraft</h5>
                <ul class="list-unstyled">
                    <li><a href="/about" class="text-light text-decoration-none">About us</a></li>
                    <li><a href="/products/" class="text-light text-decoration-none">Products</a></li>
                    <li><a href="/privacy-policy" class="text-light text-decoration-none">Privacy Policy</a></li>
                </ul>
                </div>
                <div class="col-md-3">
                    <h5>GleamCraft</h5>
                    <ul class="list-unstyled">
                        <li><a href="/brands" class="text-light text-decoration-none">Brands</a></li>
                        <li><a href="/careers" class="text-light text-decoration-none">Careers</a></li>
                        <li><a href="/reviews" class="text-light text-decoration-none">Reviews</a></li>
                        <li><a href="/faq" class="text-light text-decoration-none">Q&A</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Contact</h5>
                    <p class="mb-1">+84 334 224 702</p>
                    <p class="mb-2">hhai989402@gmail.com</p>
                    <div class="d-flex gap-2">
                        <a href="#" class="text-light"><i class="bi bi-facebook fs-4"></i></a>
                        <a href="#" class="text-light"><i class="bi bi-twitter fs-4"></i></a>
                        <a href="#" class="text-light"><i class="bi bi-instagram fs-4"></i></a>
                        <a href="#" class="text-light"><i class="bi bi-linkedin fs-4"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script src="/assets/js/homepage.js"></script>
</body>
</html>