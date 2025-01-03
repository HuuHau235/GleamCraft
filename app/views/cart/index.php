<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../../assets/images/brands/logo.jpg" type="image/x-icon">
    <title>GleamCraft</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../assets/css/shoping_cart.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../../assets/css/header.css">
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
                    <a href="../../views/user/login.php" class="d-block text-dark">Login</a>
                    <a href="../../views/user/register.php" class="d-block text-dark">Register</a>
                </div>
            </div>
        </div>
    </header><br>
    
    <section class="cart-section">
        <div class="container">
            <div class="cart">
                <?php if (!empty($data['cartItems'])): ?>
                    <?php foreach ($data['cartItems'] as $item): ?>
                        <div class="cart-item mb-3">
                            <div class="contain_cart p-2 border rounded">
                                <div class="row g-0 align-items-center">
                                    <div class="col-md-2">
                                        <img src="<?= htmlspecialchars($item['image']); ?>" alt="<?= htmlspecialchars($item['name']); ?>" width="200">
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <div class="card-body">
                                            <h5 class="card-title"><?= htmlspecialchars($item['name']); ?></h5>
                                        </div>
                                        <div class="card-body">
                                        </div>
                                    </div>

                                    <div class="col-md-3 text-center">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <a href="/Cart/decreaseQuantity?product_id=<?= intval($item['product_id']); ?>&quantity=<?= intval($item['quantity']) - 1; ?>">
                                                <button class="btn btn-outline-secondary btn-sm reduce" type="button">-</button>
                                            </a>
                                            <input type="text" value="<?= intval($item['quantity']); ?>"
                                                class="form-control mx-2 text-center quantity" style="width: 50px;">
                                            <a href="/Cart/increaseQuantity?product_id=<?= intval($item['product_id']); ?>&quantity=<?= intval($item['quantity']) + 1; ?>">
                                                <button class="btn btn-outline-secondary btn-sm increase" type="button">+</button>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="col-md-4 d-flex justify-content-between align-items-center">
                                    <p class="price mb-0"><?= number_format($item['total_price'], 0, ',', '.'); ?> VND</p>
                                        <a href="/Cart/removeFromCart?product_id=<?= intval($item['product_id']); ?>">
                                            <button class="btn btn-sm text-danger" type="button">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Giỏ hàng của bạn trống!</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="button">
            <a href="http://localhost:/Gleamcraft_MVC/app/views/payment/"><button type="button" class="btn btn-dark payment">Payment</button></a>
        </div>
    </section>

    <?php
    // require_once "../shared/footer.php";
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
