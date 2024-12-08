<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sticky Header</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1030; 
            background-color: #f8f9fa;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); 
        }

        body {
            padding-top: 100px; 
        }

        .navbar-brand img {
            width: 80px;
            height: 80px;
            object-fit: cover;
        }

        .user-icon {
            font-size: 2rem;
        }
    </style>
</head>
<body>
<header class="bg-light border-bottom d-flex align-items-center">
    <div class="container-fluid d-flex justify-content-between align-items-center px-4">
        <a href="/" class="navbar-brand d-flex align-items-center">
            <img src="../../../assets/images/brands/logo.jpg" alt="Logo">
        </a>

        <nav>
            <ul class="nav">
                <li class="nav-item"><a href="/" class="nav-link text-dark">Trang chủ</a></li>
                <li class="nav-item"><a href="/about" class="nav-link text-dark">Về chúng tôi</a></li>
                <li class="nav-item"><a href="/collections" class="nav-link text-dark">Bộ sưu tập</a></li>
                <li class="nav-item"><a href="/products/women" class="nav-link text-dark">Sản phẩm nữ</a></li>
                <li class="nav-item"><a href="/products/men" class="nav-link text-dark">Sản phẩm nam</a></li>
                <li class="nav-item"><a href="/brands" class="nav-link text-dark">Thương hiệu khác</a></li>
            </ul>
        </nav>

        <a href="/user/profile" class="text-dark user-icon">
            <i class="bi bi-person"></i>
        </a>
    </div>
</header>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>