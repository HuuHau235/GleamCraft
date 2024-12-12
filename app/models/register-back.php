<?php
session_start();
error_reporting(E_ALL);
require_once "../../config/db.php"; 

// dùng để gửi email
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';
require '../PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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

    // Thêm người dùng vào cơ sở dữ liệu
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, phone, role) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$username, $email, $password, $phonenumber, $role]);

    if ($stmt) {
        sendWelcomeEmail($username, $email, $password); // Gửi email chào mừng
        $_SESSION['success'] = "Đăng ký thành công!";
        header("location:../views/user/login.php");
        exit();
    } else {
        $_SESSION['error'] = "Lỗi khi đăng ký: " . implode(", ", $stmt->errorInfo());
        header("location:../views/user/register.php");
        exit();
    }
}

// Hàm gửi email chào mừng
function sendWelcomeEmail($username, $email, $password) {
    $mail = new PHPMailer(true);

    try {
        // Cấu hình SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'Bithien6425@gmail.com'; // Email 
        $mail->Password = 'bqey serd have vhdl';  // Mật khẩu email
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('no-reply@gleamcraft.com', 'GleamCraft');
        $mail->addAddress($email, $username);

        // Cấu hình mã hóa UTF-8
        $mail->CharSet = 'UTF-8';

        // Nội dung email
        $mail->isHTML(true);
        $mail->Subject = "CHÀO MỪNG ĐẾN VỚI GleamCraft";
        $mail->Body = 'XIN CHÀO ' . $username . ',<br><br>CẢM ƠN BẠN ĐÃ ĐĂNG KÝ. CHÚC BẠN CÓ TRẢI NGHIỆM TUYỆT VỜI VỚI GleamCraft!<br><br>'
            . 'TÊN ĐĂNG NHẬP CỦA BẠN LÀ: ' . $username . '<br>'
            . 'MẬT KHẨU CỦA BẠN LÀ: ' . $password . '<br><br> CHÚC BẠN MỘT NGÀY TỐT LÀNH!';
        $mail->AltBody = 'XIN CHÀO ' . $username . "\n"
            . 'TÊN ĐĂNG NHẬP CỦA BẠN LÀ: ' . $username . "\n"
            . 'MẬT KHẨU CỦA BẠN LÀ: ' . $password . "\n\n CHÚC BẠN MỘT NGÀY TỐT LÀNH!";

        // Gửi email
        $mail->send();
    } catch (Exception $e) {
        echo "Email không gửi được. Lỗi: {$mail->ErrorInfo}";
    }
}
?>
