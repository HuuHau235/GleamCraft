<?php
$productsRelate = $data['productsRelate'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../../assets/images/brands/logo.jpg" type="image/x-icon">
    <title>GleamCraft</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    
</head>

<body>
    <?php
    require_once(__DIR__ . '/../shared/header.php');  // Đảm bảo đường dẫn đúng
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
                            href="/Cart/addToCart?product_id=<?= htmlspecialchars($data['product']['product_id']); ?>&quantity=1">
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
        </form>



        <div class="related-products my-5">
            <h3 class="text-center">Related Products</h3>
            <div class="row">
                <?php if (!empty($productsRelate)): ?> <!-- Kiểm tra xem mảng có dữ liệu không -->
                    <?php foreach ($productsRelate as $relatedProduct): ?> <!-- Lặp qua các sản phẩm liên quan -->
                        <div class="col-md-3">
                            <div class="card mb-3" style="height: 450px;">
                                <a
                                    href="/detail/viewProduct?product_id=<?= htmlspecialchars($relatedProduct['product_id']); ?>">
                                    <img src="<?= htmlspecialchars($relatedProduct['image']); ?>" class="card-img-top"
                                        alt="<?= htmlspecialchars($relatedProduct['name']); ?>">
                                </a>
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($relatedProduct['name']); ?></h5>
                                    <p><?= number_format($relatedProduct['price'], 0, ',', '.'); ?> VND</p>
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

    <?php
require_once(__DIR__ . '/../shared/footer.php');  
?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>