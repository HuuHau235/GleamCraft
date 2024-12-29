<?php
// class Database {
//     protected $host = "localhost";
//     protected $dbName = "gleamcraft";
//     protected $username = "root";
//     protected $password = "";
//     private $conn; 

//     // Hàm kết nối
//     public function connect() {
//         $this->conn = null; 
//         try {
//             $this->conn = new mysqli(
//                 $this->host,
//                 $this->username,
//                 $this->password,
//                 $this->dbName
//             );
//             if ($this->conn->connect_error) {
//                 die("Kết nối thất bại: " . $this->conn->connect_error);
//             }
//         } catch (Exception $e) {
//             echo "Kết nối thất bại: " . $e->getMessage(); 
//         }
//         return $this->conn;
//     }
// }

// $db = new Database();
// $conn = $db->connect();
?>