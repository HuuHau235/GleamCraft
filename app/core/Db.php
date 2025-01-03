<?php
class Database {  // Đổi tên lớp từ Db thành Database
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $port = 3307;
    private $dbname = "gleamcraft"; // Tên cơ sở dữ liệu của bạn
    protected $conn;

    public function __construct() {
        // Kết nối cơ sở dữ liệu với OOP MySQLi
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbname, $this->port);

        // Kiểm tra lỗi kết nối
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error); // In ra lỗi chi tiết
        }
    }

    public function getConnection() {
        return $this->conn;
    }

    // Phương thức đóng kết nối (tốt cho việc sử dụng lâu dài)
    public function closeConnection() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
?>
