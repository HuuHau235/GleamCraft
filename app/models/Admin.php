 <!-- Quản lí review -->
 <?php
$reviews = "SELECT * FROM reviews";
$resultUser = $conn->query($reviews);
$reviews = $resultUser->fetch_all(MYSQLI_ASSOC);
?>
<!-- Quản lí user -->
<?php
$sqlUser = "SELECT * FROM users";
$resultUser = $conn->query($sqlUser);
?>
<!-- Quản lí Products -->
<?php
$sqlProducts ="SELECT * FROM Products";
$resultProduct = $conn ->query(($sqlProducts));
?>
<!-- Dùng một lệnh đóng chung thôi -->
<?php
$conn->close();
?>