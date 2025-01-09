<?php
require_once 'C:\xampp\htdocs\GleamCraft_MVC\app\core\Db.php';  
class ReviewsModel extends Database
{
    public function getAllReview()
    {
        $sql = "SELECT * FROM reviews";
        $result = $this->conn->query($sql);
        return $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
    public function getReviewsByProductId($product_id)
    {
        $query = "SELECT reviews.review_id, reviews.comment, reviews.created_at, users.name AS user_name 
              FROM reviews 
              INNER JOIN users ON reviews.user_id = users.user_id
              WHERE reviews.product_id = ?";
        if ($stmt = $this->conn->prepare($query)) {
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $reviews = [];
            while ($row = $result->fetch_assoc()) {
                $reviews[] = $row;
            }
            $stmt->close();
            return $reviews;
        } else {
            echo "Error: " . $this->conn->error;
            return [];
        }
    }
    public function addReview($product_id, $user_id, $comment)
    {
        $query = "SELECT COUNT(*) FROM products WHERE product_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();
        if ($count == 0) {
            echo "Product does not exist.";
            return false;
        }
        $query = "INSERT INTO reviews (product_id, user_id, comment) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iis", $product_id, $user_id, $comment);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }
}
?>