<?php
session_start();
require_once '../../config/db.php';
class Login_Data
{
    private $conn;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    public function login($email, $password)
    {
        try {
            $query = "SELECT * FROM Users WHERE email=:email";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user) {
                if ($password == $user['password']) {
                    return ['success' => true, 'user' => $user];
                } else {
                    return ['success' => false, 'error' => 'wrong_password'];
                }
            }
            return ['success' => false, 'error' => 'email_not_found'];
        } catch (PDOException $e) {
            return ['success' => false, 'error' => 'query_error'];
        }
    }
    public function setUserSession($user)
    {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['password'] = $user['password'];
    }
    public function processLogin($email, $password)
    {
        if (!empty($email) && !empty($password)) {
            $loginResult = $this->login($email, $password);

            if ($loginResult['success']) {
                $user = $loginResult['user'];
                $this->setUserSession($user);
                header("Location: ../../public/index.php");
                exit(); // Dừng lại để chuyển sang trang mớii
            } else {
                $error = $loginResult['error']; 
                if ($error == 'wrong_password') {
                    echo "You have entered the wrong password. Please re-enter.";
                } elseif ($error == 'email_not_found') {
                    echo "Email does not exist, please re-enter.";
                } else {
                    echo "An error occurred. Please try again.";
                }
            }
        } else {
            echo "Please enter both email and password.";
            exit();
        }
    }
}
if (isset($_POST['login'])) {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $auth = new Login_Data($conn); 
    $auth->processLogin($email, $password);
}
?>
