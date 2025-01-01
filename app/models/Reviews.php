<?php
require_once 'C:\xampp\htdocs\GleamCraft_MVC\app\core\Db.php';  // Kết nối với lớp Database

class ReviewsModel extends Database
{
    public function __construct()
    {
        parent::__construct(); // Kết nối đến cơ sở dữ liệu
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
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }

    // Thêm review mới vào cơ sở dữ liệu
    public function insertReview($review_id, $product_id, $comment)
    {
        $query = "INSERT INTO reviews (review_id, product_id, comment) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        if ($stmt) {
            // Liên kết tham số
            $stmt->bind_param("iis", $review_id, $product_id, $comment);

            try {
                // Thực thi truy vấn
                if ($stmt->execute()) {
                    $stmt->close();
                    return true; // Chèn thành công
                }
            } catch (mysqli_sql_exception $e) {
                echo "Lỗi: " . $e->getMessage();
            }

            $stmt->close();
        }

        return false; // Chèn thất bại
    }
}
?>
