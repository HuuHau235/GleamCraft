<?php
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
}
