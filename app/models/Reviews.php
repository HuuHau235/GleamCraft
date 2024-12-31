<?php
require_once 'C:\xampp\htdocs\GleamCraft_MVC\app\core\Db.php';  // Bao gồm lớp Db

class Reviews extends Database
{
    public function __construct()
    {
        parent::__construct(); // Gọi constructor của lớp Database để khởi tạo kết nối
    }

    public function insertReview($review_id, $product_id, $user_id, $comment)
    {
        $conn = $this->getConnection();

        $sql = "INSERT INTO reviews (review_id, product_id, user_id, comment, created_at, updated_at) 
                VALUES (?, ?, ?, ?, NOW(), NOW())";
        $stmt = $conn->prepare($sql);

        // Bind dữ liệu
        $stmt->bind_param('iiis', $review_id, $product_id, $user_id, $comment);

        // Thực thi câu lệnh
        if ($stmt->execute()) {
            return true; // Thêm thành công
        }
        return false; // Thêm thất bại
    }

    public function getAllReviewsByUser($user_id)
    {
        $conn = $this->getConnection();

        $sql = "SELECT * FROM reviews WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}

?>