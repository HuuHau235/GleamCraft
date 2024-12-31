<!-- 
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\core\Controller.php');
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\models\User1Model.php');
// require_once('C:\xampp\htdocs\GleamCraft_MVC\app\models\Products.php');
// require_once('C:\xampp\htdocs\GleamCraft_MVC\app\models\PaymentModel.php');

require_once('C:\xampp\htdocs\GleamCraft_MVC\app\core\Db.php');

class LoginController {
    public function showLoginForm() {
        require_once 'views/user/login.php';
    }

    public function handleLogin() {
        session_start(); // Bắt đầu session
    
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
    
        if (empty($email) || empty($password)) {
            $error = 'Email và mật khẩu không được để trống!';
            require_once 'views/login.php';
            return;
        }
    
        $userModel = new User1Model();
        // $user = $userModel->getUserByEmail($email);
    
        if ($user && password_verify($password, $user['password'])) {
            // Lưu thông tin người dùng vào session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
    
            // Chuyển hướng đến trang chủ sau khi đăng nhập thành công
            header("Location: /"); // Trang chủ (có thể thay bằng URL khác nếu cần)
            exit();
        } else {
            $error = 'Email hoặc mật khẩu không chính xác!';
            require_once 'views/user/login.php';
        }
    }
    
    
}

 -->
