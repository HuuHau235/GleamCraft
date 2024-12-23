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