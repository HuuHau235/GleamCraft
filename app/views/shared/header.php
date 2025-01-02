<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sticky Header</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../assets/css/header.css">
</head>
<body>
<header class="bg-light border-bottom d-flex align-items-center">
    <div class="container-fluid d-flex justify-content-between align-items-center px-4">
        <a href="/" class="navbar-brand d-flex align-items-center">
            <img src="../assets/images/brands/logo.jpg" alt="Logo">
        </a>

        <nav>
            <ul class="nav">
                <li class="nav-item"><a href="/" class="nav-link text-dark">Home</a></li>
                <li class="nav-item"><a href="/about" class="nav-link text-dark">About us</a></li>
                <li class="nav-item"><a href="/collections" class="nav-link text-dark">Collection</a></li>
                <li class="nav-item"><a href="/Product/" class="nav-link text-dark">Products</a></li>
                <li class="nav-item"><a href="/brands" class="nav-link text-dark">Brands</a></li>
            </ul>
        </nav>

        <div class="user-icon position-relative">
            <i class="bi bi-person"></i>
            <div class="tooltip-box">
                <a href="user/login" class="d-block text-dark">Login</a>
                <a href="user/register" class="d-block text-dark">Register</a>
            </div>
        </div>
    </div>
</header>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>