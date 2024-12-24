<?php
require_once "../../../config/db.php";
// Xử lý xóa người dùng
if (isset($_GET['delete_user']) && isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Kiểm tra tính hợp lệ của user_id
    if (is_numeric($user_id)) {
        // Lệnh SQL để xóa người dùng
        $sqlDeleteUser = "DELETE FROM users WHERE user_id = ?";

        // Chuẩn bị câu lệnh SQL
        $stmt = $conn->prepare($sqlDeleteUser);
        if (!$stmt) {
            die("Error preparing the statement: " . $conn->error);
        }

        // Liên kết tham số với câu lệnh SQL
        $stmt->bind_param("i", $user_id);

        // Thực thi câu lệnh
        if ($stmt->execute()) {
            $stmt->close();
            echo "<script>alert('Đã xóa thành công');</script>";
        } else {
            echo "<script>alert('Xóa không thành công: " . $stmt->error . "');</script>";
        }

        // Chuyển hướng lại trang sau khi xóa
        header("Location: ./testxoas.php");
        exit;
    } else {
        echo "<script>alert('ID người dùng không hợp lệ.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Người Dùng</title>
</head>
<body>

<h1>Danh Sách Người Dùng</h1>

<table border="1">
    <tr>
        <th>User ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Actions</th>
    </tr>

    <?php
    // Lấy danh sách người dùng từ cơ sở dữ liệu
    $result = $conn->query("SELECT user_id, name, email FROM users");

    // Hiển thị dữ liệu người dùng
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['user_id'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td><a href='?delete_user=true&user_id=" . $row['user_id'] . "' onclick='return confirm(\"Bạn có chắc chắn muốn xóa người dùng này?\");'>Xóa</a></td>";
        echo "</tr>";
    }

    // Đóng kết nối
    $conn->close();
    ?>

</table>

</body>
</html>
