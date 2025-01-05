<?php
require_once 'C:\xampp\htdocs\GleamCraft_MVC\app\core\Db.php';  // Kết nối với lớp Database

class ReviewsModel extends Database
{
    public function __construct()
    {
        parent::__construct(); // Kết nối đến cơ sở dữ liệu
    }

    public function getProductDetails($product_id)
    {
        $sql = "SELECT * FROM products WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $product_id); // "i" indicates an integer parameter
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc(); // Return associative array of the row
        }

        return null; // Return null if query fails
    }

    // Lấy tất cả các đánh giá của sản phẩm
    public function getReviewsByProductId($product_id)
    {
        $sql = "SELECT * FROM reviews WHERE product_id = ? ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $product_id); // "i" indicates an integer parameter
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC); // Return all rows as an associative array
        }
    }
    // Lấy tất cả các review
    public function getAllReview()
    {
        $sql = "SELECT * FROM reviews";
        $result = $this->conn->query($sql);

        return $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // Lấy tất cả các review ID
    public function getAllReviewsID()
    {
        $query = "SELECT review_id FROM reviews";
        $result = $this->conn->query($query);

        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC); // Trả về danh sách ID dưới dạng mảng liên kết
        }
        return [];
    }

    // Kiểm tra tính hợp lệ của product_id
    public function isValidProductID($product_id)
    {
        $query = "SELECT product_id FROM products WHERE product_id = ?";
        $stmt = $this->conn->prepare($query);
        
        if ($stmt) {
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $result = $stmt->get_result();

            return $result->num_rows > 0;
        }

        return false;
    }

    // Thêm review mới vào cơ sở dữ liệu
    public function insertReview($product_id, $comment)
    {
        // Bắt đầu phiên làm việc với session
        if (session_status() == PHP_SESSION_NONE) {
            session_start();  // Đảm bảo session được khởi tạo
        }
    
        // Lấy user_id từ session
        $user_id = $_SESSION['user_id'] ?? null;
    
        // Kiểm tra xem user_id có hợp lệ không
        if ($user_id === null) {
            $_SESSION['error'] = "Bạn cần đăng nhập để thêm review.";
            return false; // Nếu không có user_id, không thêm review
        }
    
        // Kiểm tra xem product_id có hợp lệ không
        if (!$this->isValidProductID($product_id)) {
            $_SESSION['error'] = "Sản phẩm không hợp lệ.";
            return false; // Nếu không hợp lệ thì không thêm review
        }
    
        // Kiểm tra xem comment có được điền không
        if (empty($comment)) {
            $_SESSION['error'] = "Vui lòng nhập nội dung bình luận.";
            return false;
        }
    
        // Truy vấn SQL để chèn review vào bảng reviews
        $query = "INSERT INTO reviews (user_id, product_id, comment, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($query);
        
        if ($stmt === false) {
            $_SESSION['error'] = "Lỗi khi chuẩn bị câu lệnh SQL.";
            error_log("Lỗi chuẩn bị câu lệnh SQL: " . $this->conn->error);
            return false;
        }
    
        // Liên kết tham số
        $stmt->bind_param("iis", $user_id, $product_id, $comment);
    
        try {
            // Thực thi truy vấn
            if ($stmt->execute()) {
                $_SESSION['message'] = "Review đã được thêm thành công!";
                $stmt->close();
                return true; // Chèn thành công
            } else {
                $_SESSION['error'] = "Không thể thêm review. Vui lòng thử lại sau.";
                error_log("Lỗi SQL: " . $this->conn->error); // In lỗi SQL vào log
            }
        } catch (mysqli_sql_exception $e) {
            // Xử lý lỗi SQL nếu có
            error_log("Lỗi SQL: " . $e->getMessage());
            $_SESSION['error'] = "Có lỗi xảy ra khi thêm review. Vui lòng thử lại.";
        }
    
        // Đóng kết nối
        $stmt->close();
        return false; // Chèn thất bại
    }
    

    
}
?>
