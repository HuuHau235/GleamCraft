<?php
session_start();
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\core\Controller.php');
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\models\User1Model.php');
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\core\Db.php'); 
class UserController extends Controller {
    private $conn;

    public function __construct() {
        // Khởi tạo đối tượng Database và lấy kết nối CSDL
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function login() {
        // Kiểm tra nếu form đăng nhập được gửi
        if (isset($_POST['login'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Tạo đối tượng UserModel và gọi phương thức login
            $userModel = new User1Model($this->conn);
            $user = $userModel->login($email, $password);

            // Nếu đăng nhập thành công
            if ($user) {
                // Lưu thông tin người dùng vào session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                // Chuyển hướng đến trang chính (index)
                header("Location: /GleamCraft_MVC/");
                exit;
            } else {
                // Nếu đăng nhập không thành công, chuyển hướng về trang login và thông báo lỗi
                header("/user/login?error=Invalid email or password");
                exit;
            }
        } else {
            // Hiển thị form đăng nhập nếu không có POST
            $this->view('user/login');
        }
    }
// Đăng ký
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = isset($_POST['username']) ? trim($_POST['username']) : '';
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
            $password = isset($_POST['password']) ? trim($_POST['password']) : '';
            $confirmPassword = isset($_POST['confirmpassword']) ? trim($_POST['confirmpassword']) : '';
            
            $error = "";

            // Kiểm tra đầu vào
            if (empty($username) || empty($email) || empty($phone) || empty($password) || empty($confirmPassword)) {
                $error = "Vui lòng nhập đầy đủ thông tin.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Email không hợp lệ!";
            } elseif (strlen($password) < 5) {
                $error = "Mật khẩu phải có ít nhất 5 ký tự!";
            } elseif ($password !== $confirmPassword) {
                $error = "Mật khẩu không khớp!";
            }

            // Hiển thị form với lỗi nếu có
            if (!empty($error)) {
                $this->view('user/register', ['error' => $error]);
                return;
            }

            // Gọi model để thực hiện đăng ký
            $registerModel = $this->model("User1Model");
            $role = "User"; // Vai trò mặc định
            $result = $registerModel->registerUser($username, $password, $email, $phone, $role);

            // Kiểm tra kết quả từ model
            if ($result['success']) {
                // Gửi email xác nhận
                $confirmationLink = "http://your_confirmation_link.com"; // Đặt đường dẫn xác nhận của bạn
                $emailResult = $registerModel->sendConfirmationEmail($username, $email, $confirmationLink);

                // Kiểm tra kết quả gửi email nếu cần
                if (!$emailResult['success']) {
                    // Nếu gửi email thất bại, có thể lưu thông báo lỗi
                    $_SESSION['error'] = $emailResult['message'];
                }

                // Chuyển hướng đến trang đăng nhập
                $_SESSION['success'] = "Đăng ký thành công! Vui lòng kiểm tra email của bạn để xác nhận.";
                header("user/login");
                exit();
            } else {
                // Hiển thị lỗi từ model
                $this->view('user/register', ['error' => $result['message'] ?? 'Đăng ký thất bại.']);
            }
        } else {
            // Hiển thị form đăng ký nếu không có dữ liệu POST
            $this->view('user/register');
        }
    }
}
?>
