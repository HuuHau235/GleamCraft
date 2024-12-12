<?php
session_start();
error_reporting(E_ALL);
require_once "../../config/db.php"; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Kiểm tra kết nối
    if (!$conn) {
        $_SESSION['error'] = "Kết nối cơ sở dữ liệu thất bại.";
        header("location:../views/user/register.php");
        exit();
    }

    $username = $_POST['username'];
    $phonenumber = $_POST['phonenumber'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    // Kiểm tra mật khẩu và xác nhận mật khẩu khớp nhau 
    if ($password !== $confirm_password) { 
        $_SESSION['error'] = "Mật khẩu và xác nhận mật khẩu không khớp!"; 
        header("location:../views/user/register.php"); 
        exit(); 
    }

    // Kiểm tra email hợp lệ
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Email không hợp lệ!";
        header("location:../views/user/register.php");
        exit();
    }

    // Kiểm tra email đã có trong bảng users hay chưa
    $check_email_sql = "SELECT * FROM users WHERE email = ?";
    $email_stmt = $conn->prepare($check_email_sql);
    $email_stmt->execute([$email]);
    $email_res = $email_stmt->fetchAll();

    if (count($email_res) > 0) {
        $_SESSION['error'] = "Email đã tồn tại!";
        header("location:../views/user/register.php");
        exit();
    }

    // Kiểm tra và xác định vai trò
    $role = (count($conn->query("SELECT * FROM users WHERE role = 'admin'")->fetchAll()) > 0) ? "user" : "admin";

}


?>
