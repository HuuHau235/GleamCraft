<?php
session_start();
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
            $query = "SELECT * FROM Users WHERE email = ?";
            $stmt = $this->conn->prepare($query);

            if ($stmt === false) {
                return ['success' => false, 'error' => 'prepare_failed'];
            }


            $stmt->bind_param("s", $email);


            $stmt->execute();

            // Lấy kết quả
            $result = $stmt->get_result();
            $user = $result->fetch_assoc(); 

            if ($user) {
                if ($password === $user['password']) { 
                    return ['success' => true, 'user' => $user];
                } else {
                    return ['success' => false, 'error' => 'wrong_password'];
                }
            }
            return ['success' => false, 'error' => 'email_not_found'];
        } catch (Exception $e) {
            return ['success' => false, 'error' => 'query_error', 'message' => $e->getMessage()];
        }
    }

    public function setUserSession($user)
    {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['password'] = $user['password'];
    }
}
