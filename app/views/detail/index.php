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
                    <li class="nav-item"><a href="/Gleamcraft_MVC/app/controllers/ProductController.php" class="nav-link text-dark">Products</a></li>
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
        <div class="row">
            <div class="col-md-5">
                <img src="<?= htmlspecialchars($product['image']); ?>" 
                    alt="<?= htmlspecialchars($product['name']); ?>" 
                    class="img-fluid product-image" 
                    style="width: 500px; height: 400px;">
            </div>
            <div class="col-md-6 product-info">
                <h1><strong><?= htmlspecialchars($product['name']); ?></strong></h1>
                <h4><strong>Description:</strong> <?= htmlspecialchars($product['description']); ?></h4>
                <h2><strong>Color:</strong> <?= htmlspecialchars($product['color']); ?></h2>
                <h3><?= number_format($product['price'], 0, ',', '.'); ?> VND</h3>
                <div class="quantity-and-cart">
                    <div class="mb-3">
                        <input type="number" id="quantity" class="form-control" value="1" min="1" style="width: 70px;">
                    </div>
                    <a href="../../../app/models/CartManager.php?add_to_cart=true&product_id=<?= $product['product_id']; ?>&quantity=1">
                        <button class="add-to-cart-btn">Add to Cart</button>
                    </a>
                </div>
            </div>
        </div>


        <div class="mt-4">
            <h3>Reviews</h3>
            <?php if (!empty($reviews)): ?>
                <?php foreach ($reviews as $review): ?>
                    <div class="border p-2 mb-2">
                        <strong><?= htmlspecialchars($review['user_name']); ?>:</strong>
                        <p><?= htmlspecialchars($review['comment']); ?></p>
                        <small><?= htmlspecialchars($review['created_at']); ?></small>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No reviews yet. Be the first to leave a review!</p>
            <?php endif; ?>
        </div>

        <form action="/Gleamcraft_MVC/public/product/detail/<?= htmlspecialchars($product['product_id']); ?>" method="POST">
            <div class="mb-3">
                <label for="comment" class="form-label">Your Review:</label>
                <textarea name="comment" id="comment" class="form-control" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit Review</button>
        </form>


        <div class="related-products my-5">
            <h3 class="text-center">Related Products</h3>
            <div class="row">
                <?php if (!empty($relatedProducts)): ?>
                    <?php foreach ($relatedProducts as $relatedProduct): ?>
                    <div class="col-md-3">
                        <div class="card mb-3" style="height: 450px;">
                        <a href="/Gleamcraft_MVC/public/product/detail/<?= $relatedProduct['product_id']; ?>"><img src="<?= $relatedProduct['image']; ?>" class="card-img-top" alt="<?= $relatedProduct['name']; ?>"></a>

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