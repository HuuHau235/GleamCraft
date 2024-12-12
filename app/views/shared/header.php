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
        /* Style for the user icon */
        .user-icon {
            position: relative;
            font-size: 1.5rem;
            cursor: pointer;
        }

        /* Tooltip container (hidden by default) */
        .tooltip-box {
            display: none;
            position: absolute;
            top: 110%; /* Adjust position below the icon */
            left: 50%;
            transform: translateX(-50%);
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 10px;
            z-index: 10;
        }

        /* Links inside tooltip */
        .tooltip-box a {
            font-size: 0.9rem;
            text-decoration: none;
            margin: 5px 0;
            padding: 5px;
            display: block;
            text-align: center;
            transition: background-color 0.3s;
        }

        .tooltip-box a:hover {
            background-color: #f1f1f1;
        }

        .user-icon:hover .tooltip-box {
            display: block;
        }
    </style>
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
                <li class="nav-item"><a href="/products/women" class="nav-link text-dark">Products women</a></li>
                <li class="nav-item"><a href="/products/men" class="nav-link text-dark">Products men</a></li>
                <li class="nav-item"><a href="/brands" class="nav-link text-dark">Brands</a></li>
            </ul>
        </nav>

        <div class="user-icon position-relative">
            <i class="bi bi-person"></i>
            <div class="tooltip-box">
                <a href="app/views/user/login.php" class="d-block text-dark">Login</a>
                <a href="app/views/user/register.php" class="d-block text-dark">Register</a>
            </div>
        </div>
    </div>
</header>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>