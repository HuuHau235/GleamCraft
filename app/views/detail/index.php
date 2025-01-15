<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../../assets/images/brands/logo.jpg" type="image/x-icon">
    <title>GleamCraft</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../assets/css/detail.css">
    <link rel="stylesheet" href="../../../assets/css/header.css">

</head>

<body>
    <?php
    require_once(__DIR__ . '/../shared/header.php');
    ?>
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
                    <h1><strong><?= htmlspecialchars($data['product']['name']); ?></strong></h1>
                    <h4><strong>Description:</strong> <?= htmlspecialchars($data['product']['description']); ?></h4>
                    <h2><strong>Color:</strong> <?= htmlspecialchars($data['product']['color']); ?></h2>
                    <h3><?= number_format($data['product']['price'], 0, ',', '.'); ?> VND</h3>
                    <div class="quantity-and-cart">
                        <div class="mb-3">
                            <label for="quantity"><strong>Quantity:</strong></label>
                            <input type="number" id="quantity" class="form-control" value="1" min="1"
                                style="width: 70px;">
                        </div>
                        <a
                            href="/Cart/addToCart?product_id=<?= htmlspecialchars($data['product']['product_id']); ?>&quantity=1">
                            <button class="btn btn-danger">Add to Cart</button>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Display reviews -->
            <?php $reviews = $data['reviews']; ?>
            <?php if (isset($reviews) && count($reviews) > 0): ?>

                <div class="reviews-container">
                <h4>All Reviews</h4>

                    <?php foreach ($reviews as $review): ?>
                        <div class="review-box">
                            <div class="profile">
                                <div class="avatar">
                                    <img src="https://www.nicepng.com/png/detail/12-120709_png-file-human-icon-png.png"
                                        alt="avatar">
                                </div>
                                <div class="review-header">
                                    <?php echo htmlspecialchars($review['user_name']); ?></>
                                </div>
                            </div>
                            <div class="review-body">
                                <p><?php echo htmlspecialchars($review['comment']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No reviews available for this product.</p>
            <?php endif; ?>
            <!-- Reviews -->
            <form action="/detail/submitReview" method="POST">
                <input type="hidden" name="product_id"
                    value="<?= htmlspecialchars($data['product']['product_id']); ?>" />
                <div class="mb-3">
                    <label for="comment" class="form-label">Your Review:</label>
                    <textarea name="comment" id="comment" class="form-control" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit Review</button>
            </form>
            <div class="related-products my-5">
                <h3 class="text-center">Related Products</h3>
                <div class="row">
                    <?php
                    $productsRelate = $data['productsRelate'];
                    ?>
                    <?php if (!empty($productsRelate)): ?> <!-- Kiểm tra xem mảng có dữ liệu không -->
                        <?php foreach ($productsRelate as $relatedProduct): ?> <!-- Lặp qua các sản phẩm liên quan -->
                            <div class="col-md-3">
                                <div class="card mb-3" style="height: 450px;">
                                    <a class="image-wrap"
                                        href="/detail/viewProduct?product_id=<?= htmlspecialchars($relatedProduct['product_id']); ?>">
                                        <div class="image-inner">
                                        <img src="<?= htmlspecialchars($relatedProduct['image']); ?>" class="card-img-top"
                                            alt="<?= htmlspecialchars($relatedProduct['name']); ?>">
                                            </div>
                                    </a>
                                    
                                    <div class="card-body">
                                    <a 
                                    href="/detail/viewProduct?product_id=<?= htmlspecialchars($relatedProduct['product_id']); ?>">
                                        <h5 class="card-title"><?= htmlspecialchars($relatedProduct['name']); ?></h5>
                                        <p><?= number_format($relatedProduct['price'], 0, ',', '.'); ?> VND</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No related products found.</p> <!-- Thông báo nếu không có sản phẩm -->
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    require_once(__DIR__ . '/../shared/footer.php');
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>