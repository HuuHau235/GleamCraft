<?php
require_once '../config/db.php';
require_once '../controllers/ProductController.php';

$db = new Database();
$conn = $db->connect();

$productController = new ProductController($db);
$productController->filterProducts();
