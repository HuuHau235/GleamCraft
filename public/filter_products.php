<?php
require_once '../../controllers/ProductController.php';
$productController = new ProductController();
$productController->filterProducts();
