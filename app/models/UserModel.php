<?php
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\core\Db.php');
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';
require '../PHPMailer-master/src/Exception.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class UserModel extends Database {
    public function register($name, $password, $email, $phone, $role = "User") {
        // Kiểm tra xem email đã tồn tại hay chưa
        $checkAccount = "SELECT COUNT(*) as user_count FROM Users WHERE email=?";
        $stmt = $this->conn->prepare($checkAccount);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row['user_count'] > 0) {
            return ['success' => false, 'message' => 'Email đã tồn tại!'];
        }

        // Băm mật khẩu
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Thêm người dùng mới
        $sql = "INSERT INTO Users (name, password, email, phone, role) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssis", $name, $hashedPassword, $email, $phone, $role);

        if ($stmt->execute()) {
            return ['success' => true];
        } else {
            return ['success' => false, 'message' => 'Lỗi khi đăng ký.'];
        }
    }

    public function sendConfirmationEmail($username, $email, $confirmationLink) {
        $mail = new PHPMailer(true);
        try {
            // Cấu hình SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'your_email@gmail.com'; // Cập nhật với email của bạn
            $mail->Password = 'your_password';  // Cập nhật với mật khẩu email của bạn
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('no-reply@gleamcraft.com', 'GleamCraft');
            $mail->addAddress($email, $username);

            // Cấu hình mã hóa UTF-8
            $mail->CharSet = 'UTF-8';

            // Nội dung email xác nhận
            $mail->isHTML(true);
            $mail->Subject = "Xác nhận địa chỉ email của bạn";
            $mail->Body = "Xin chào $username,<br><br>"
                . "Cảm ơn bạn đã đăng ký với GleamCraft!<br><br>"
                . "Để hoàn tất quá trình đăng ký, vui lòng nhấp vào đường dẫn dưới đây để xác nhận địa chỉ email của bạn:<br><br>"
                . "<a href='$confirmationLink' target='_blank'>Xác nhận email</a><br><br>"
                . "Chúc bạn một ngày tốt lành!";

            // Gửi email
            $mail->send();
            return ['success' => true];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Không thể gửi email xác nhận: ' . $e->getMessage()];
        }
    }
}