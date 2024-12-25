<?php
require_once('../../../config/db.php');
require_once('../../models/Admin.php');

if (isset($_GET['deleteReview']) && isset($_GET['review_id'])) {
    $review_id = $_GET['review_id'];
    if (!empty($review_id)) {
        $sqlCheckReview = "SELECT * FROM reviews WHERE review_id = ?";
        $stmtCheck = $conn->prepare($sqlCheckReview);
        if (!$stmtCheck) {
            die("Error preparing the statement: " . $conn->error);
        }
        $stmtCheck->bind_param("i", $review_id);
        $stmtCheck->execute();
        $result = $stmtCheck->get_result();

        if ($result->num_rows > 0) {
            $sqlDeleteReview = "DELETE FROM reviews WHERE review_id = ?";
            $stmtDelete = $conn->prepare($sqlDeleteReview);
            if (!$stmtDelete) {
                die("Error preparing the statement: " . $conn->error);
            }
            $stmtDelete->bind_param("i", $review_id);
            if ($stmtDelete->execute()) {
                $stmtDelete->close();
                echo "<script>alert('Đã xóa đánh giá thành công');</script>";
            } else {
                echo "<script>alert('Xóa không thành công: " . $stmtDelete->error . "');</script>";
            }
        } else {
            echo "<script>alert('Đánh giá không tồn tại.');</script>";
        }

        echo "<script>window.location.href = '../admin/index.php';</script>";
        exit;
    } else {
        echo "<script>alert('ID đánh giá không hợp lệ.');</script>";
    }
}
?>