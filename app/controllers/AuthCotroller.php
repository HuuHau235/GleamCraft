<?php
require_once '../../config/db.php';
require_once '../models/Login_Data.php';

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
