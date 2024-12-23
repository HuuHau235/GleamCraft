<?php
require_once '../../config/db.php';
require_once '../models/UserModel.php';

class AuthController
{
    private $auth; // Khởi tạo một biến 

    public function __construct($conn)
    {
        $this->auth = new Login_Data($conn);
    }

    public function processLogin($email, $password)
    {
        // Kiểm tra xem có rỗng hay không
        if (!empty($email) && !empty($password)) {
            $loginResult = $this->auth->login($email, $password);

            if ($loginResult['success']) {
                $user = $loginResult['user'];
                $this->auth->setUserSession($user);
                header("Location: ../../public/");
                exit();
            } else {
                $errorMessage = '';
                switch ($loginResult['error']) {
                    case 'wrong_password':
                        $errorMessage = 'You have entered the wrong password. Please re-enter.';
                        break;
                    case 'email_not_found':
                        $errorMessage = 'Email does not exist, please re-enter.';
                        break;
                    case 'query_error':
                        $errorMessage = 'An error occurred. Please try again.';
                        break;
                }
                header("Location: ../views/user/login.php?error=" . urlencode($errorMessage));
                exit();
            }
        } else {
            header("Location: ../../views/user/login.php?error=" . urlencode("Please enter both email and password."));
            exit();
        }
    }
}

// Xử lý yêu cầu POST
if (isset($_POST['login'])) {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $controller = new AuthController($conn);
    $controller->processLogin($email, $password);
}
?>
<!-- XỬ LÍ ĐĂNG KÍ -->
<?php
session_start();
error_reporting(E_ALL);
require_once "../../config/db.php";
require_once "../models/UserModel.php"; 

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

    // Lấy dữ liệu từ form
    $username = $_POST['username'];
    $phonenumber = $_POST['phonenumber'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    // Tạo đối tượng model để xử lý dữ liệu
    $UserModel = new UserModel($conn);

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
    if (count($UserModel->checkEmailExists($email)) > 0) {
        $_SESSION['error'] = "Email đã tồn tại!";
        header("location:../views/user/register.php");
        exit();
    }

    // Lấy vai trò người dùng
    $role = $UserModel->getRole();

    // Thêm người dùng vào cơ sở dữ liệu
    if ($UserModel->registerUser($username, $email, $password, $phonenumber, $role)) {
        sendWelcomeEmail($username, $email, $password); // Gửi email chào mừng
        $_SESSION['success'] = "Đăng ký thành công!";
        header("location:../views/user/login.php");
        exit();
    } else {
        $_SESSION['error'] = "Lỗi khi đăng ký.";
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


