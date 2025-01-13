<?php
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\models\UserModel.php');
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\core\Controller.php');

class UserController extends Controller
{
    protected $userModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    public function index()
    {
        // Kiểm tra nếu người dùng đã đăng nhập
        if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
            header("Location: /homepage");  // Điều hướng đến homepage nếu đã đăng nhập
            exit();
        }
        $this->view("user/login");  // Hiển thị trang login
    }

    public function login()
    {
        // Lấy email và mật khẩu từ form gửi lên
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        // Kiểm tra nếu email và password không rỗng
        if ($email != '' && $password != '') {
            // Gọi phương thức login từ UserModel để kiểm tra người dùng
            $user = $this->userModel->login($email, $password);

            if ($user) {
                // Nếu đăng nhập thành công, lưu thông tin người dùng vào session
                $_SESSION['user_logged_in'] = true;
                $_SESSION['user_email'] = $email;
                $_SESSION['user_role'] = $user['role'];  // Giả sử trả về thông tin người dùng từ Model

                // Điều hướng đến trang admin hoặc homepage dựa trên vai trò người dùng
                $userRole = $_SESSION['user_role'];
                if ($userRole == 'admin') {
                    header("Location: /Admin/");
                } else {
                    header("Location: /homepage");
                }
                exit();
            } else {
                // Nếu đăng nhập không thành công (email hoặc mật khẩu không đúng)
                $_SESSION['login_error'] = 'Email hoặc mật khẩu không đúng. Vui lòng kiểm tra lại.';
                header("Location: /User");  // Quay lại trang login
                exit();
            }
        } else {
            // Nếu email hoặc password để trống
            $_SESSION['login_error'] = 'Vui lòng nhập đầy đủ email và mật khẩu.';
            header("Location: /User");  // Quay lại trang login
            exit();
        }
    }
    // Đăng Ký
    public function register()
    {
        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') == 0) { // So sánh không phân biệt hoa thường
            $username = isset($_POST['username']) ? trim($_POST['username']) : '';
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
            $password = isset($_POST['password']) ? trim($_POST['password']) : '';
            $confirmPassword = isset($_POST['confirmpassword']) ? trim($_POST['confirmpassword']) : '';
    
            $error = "";
    
            // Kiểm tra các điều kiện nhập liệu
            if (empty($username) || empty($email) || empty($phone) || empty($password) || empty($confirmPassword)) {
                $error = "Please enter complete information.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // Kiểm tra email hợp lệ
                $error = "Invalid email!";
            } elseif (strlen($password) < 5) {
                $error = "Password must have at least 5 characters!";
            } elseif ($password !== $confirmPassword) {
                $error = "Passwords do not match!";
            }
    
            // Hiển thị form kèm lỗi nếu có
            if (!empty($error)) {
                echo "<script>alert('$error');</script>";
                $this->view('User/register');
                return;
            }
    
            // Kiểm tra người dùng lần đầu tiên
            $userModel = $this->model("UserModel");
            $firstUser = $userModel->getFirstUser();
    
            // Nếu là người dùng đầu tiên, gán vai trò là admin
            $role = "User"; // Vai trò mặc định
            if ($firstUser == null) {
                $role = "Admin"; // Nếu là người dùng đầu tiên, gán quyền admin
            }
    
            // Gọi model để đăng ký người dùng
            $registerModel = $this->model("UserModel");
            $result = $registerModel->registerUser($username, $password, $email, $phone, $role);
    
            // Kiểm tra kết quả từ model
            if ($result['success']) {
                $_SESSION['success'] = "Registered successfully! Please check your email for confirmation.";
                header("Location: /User"); // Đảm bảo điều hướng đúng
                exit();
            } else {
                $this->view('User/register', ['error' => $result['message'] ?? 'Registration failed.']);
            }
        } else {
            $this->view('User/register'); // Hiển thị form đăng ký nếu không có POST
        }
    }
//     public function logout()
// {
//     // Hủy tất cả session và biến liên quan đến người dùng
//     session_start(); // Bắt đầu session để hủy session đã tồn tại
//     session_unset(); // Hủy tất cả các biến session
//     session_destroy(); // Hủy session

//     // Điều hướng về trang đăng nhập hoặc trang chủ sau khi đăng xuất
//     header("Location: /User"); // Điều hướng tới trang login
//     exit();
// }

}
?>