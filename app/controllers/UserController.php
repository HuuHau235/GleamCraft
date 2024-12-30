<?php
session_start();
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\core\Controller.php');
// require_once('C:\xampp\htdocs\GleamCraft_MVC\app\models\User1Model.php');
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
                header("Location: /GleamCraft_MVC/views/login.php?error=Invalid email or password");
                exit;
            }
        } else {
            // Hiển thị form đăng nhập nếu không có POST
            $this->view('login');
        }
    }
}
?>
