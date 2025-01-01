<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../../assets/images/brands/logo.jpg" type="image/x-icon">
    <title>GleamCraft</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../assets/css/header.css">
    <link rel="stylesheet" href="../../../assets/css/detail.css">
</head>

<body>
    <header class="bg-light border-bottom d-flex align-items-center">
        <div class="container-fluid d-flex justify-content-between align-items-center px-4">
            <a href="/" class="navbar-brand d-flex align-items-center">
                <img src="../../../assets/images/brands/logo.jpg" alt="Logo">
            </a>

            <nav>
                <ul class="nav">
                    <li class="nav-item"><a href="/Gleamcraft_MVC/public" class="nav-link text-dark">Home</a></li>
                    <li class="nav-item"><a href="/about" class="nav-link text-dark">About us</a></li>
                    <li class="nav-item"><a href="/collections" class="nav-link text-dark">Collection</a></li>
                    <li class="nav-item"><a href="/Gleamcraft_MVC/app/controllers/ProductController.php"
                            class="nav-link text-dark">Products</a></li>
                    <li class="nav-item"><a href="/brands" class="nav-link text-dark">Brands</a></li>
                </ul>
            </nav>

            <div class="user-icon position-relative">
                <i class="bi bi-person"></i>
                <div class="tooltip-box">
                    <a href="../../../app/views/user/login.php" class="d-block text-dark">Login</a>
                    <a href="../../../app/views/user/register.php" class="d-block text-dark">Register</a>
                </div>
            </div>
        </div>
    </header><br>
    <div class="container product-detail">
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-5">
                    <!-- Hiển thị hình ảnh sản phẩm -->
                    <img src="<?= htmlspecialchars($data['product']['image']); ?>"
                        alt="<?= htmlspecialchars($data['product']['name']); ?>" class="img-fluid product-image"
                        style="width: 500px; height: 400px;">
                </div>
                <div class="col-md-6 product-info">
                    <!-- Hiển thị thông tin sản phẩm -->
                    <h1><strong><?= htmlspecialchars($data['product']['name']); ?></strong></h1>
                    <h4><strong>Description:</strong> <?= htmlspecialchars($data['product']['description']); ?></h4>
                    <h2><strong>Color:</strong> <?= htmlspecialchars($data['product']['color']); ?></h2>
                    <h3><?= number_format($data['product']['price'], 0, ',', '.'); ?> VND</h3>

                    <!-- Thêm sản phẩm vào giỏ hàng -->
                    <div class="quantity-and-cart">
                        <div class="mb-3">
                            <label for="quantity"><strong>Quantity:</strong></label>
                            <input type="number" id="quantity" class="form-control" value="1" min="1"
                                style="width: 70px;">
                        </div>
                        <a
                            href="/GleamCraft_MVC/public/cart/add/<?= htmlspecialchars($data['product']['product_id']); ?>?quantity=1">
                            <button class="btn btn-primary">Add to Cart</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <form method="POST" action="/Reviews/addReview">
    <input type="hidden" name="review_id" value="<?= htmlspecialchars($product['review_id']); ?>">
    <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['product_id']); ?>">

    <div class="mb-3">
        <label for="comment" class="form-label">Your Review:</label>
        <textarea name="comment" id="comment" class="form-control" rows="3" required></textarea>
    </div>
    <a href="/Reviews/addReview?user_id=<?= $_SESSION['user_id']; ?>&product_id=<?= $product['product_id']; ?>" 
       class="btn btn-sm btn-danger">
       Submit Review
    </a>
    <!-- <button type="submit" class="btn btn-sm btn-danger">Submit Review</button> -->
</form>



        <div class="related-products my-5">
            <h3 class="text-center">Related Products</h3>
            <div class="row">
                <?php if (!empty($relatedProducts)): ?>
                    <?php foreach ($relatedProducts as $relatedProduct): ?>
                        <div class="col-md-3">
                            <div class="card mb-3" style="height: 450px;">
                                <a href="/Gleamcraft_MVC/public/product/detail/<?= $relatedProduct['product_id']; ?>"><img
                                        src="<?= $relatedProduct['image']; ?>" class="card-img-top"
                                        alt="<?= $relatedProduct['name']; ?>"></a>

                                <div class="card-body">
                                    <h5 class="card-title"><?= $relatedProduct['name']; ?></h5>
                                    <p><?= number_format($relatedProduct['price'], 0, ',', '.'); ?> VND</p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No related products found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>