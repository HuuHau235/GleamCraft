<?php
namespace App\Models;

class Review
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function addReview($product_id, $user_id, $comment)
    {
        $query = "INSERT INTO Reviews (product_id, user_id, comment, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("iis", $product_id, $user_id, $comment);
        return $stmt->execute();
    }

    public function getReviewsByProductId($product_id)
    {
        $query = "SELECT r.comment, r.created_at, u.name AS user_name
                  FROM Reviews r
                  JOIN Users u ON r.user_id = u.user_id
                  WHERE r.product_id = ?
                  ORDER BY r.created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $reviews = [];
        while ($row = $result->fetch_assoc()) {
            $reviews[] = $row;
        }
        return $reviews;
    }
}
