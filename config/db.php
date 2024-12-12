<?php
class Database {
    protected $host = "localhost";
    protected $dbName = "gleamcraft";
    protected $username = "root";
    protected $password = "1234";
    private $conn; // Lưu đối tượng kết nối với database thành công

    // Hàm kết nối
    public function connect() {
        $this->conn = null; // Đảm bảo rằng không có dữ liệu nào kết nối trước đó
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->dbName,$this->username,$this->password
            );
            // Đặt chế độ lỗi cho PDO
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Kết nối thành công!"; // In ra thông báo nếu kết nối thành công
        } catch (PDOException $e) {
            echo "Kết nối thất bại: " . $e->getMessage(); // Thông báo lỗi nếu kết nối thất bại
        }
        return $this->conn;
    }
}

// Khởi tạo lớp và kiểm tra kết nối
$db = new Database();
$conn = $db->connect();
