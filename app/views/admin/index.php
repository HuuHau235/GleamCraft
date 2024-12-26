<?php
require_once('../../controllers/AdminController.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../../assets/css/admin.css">
</head>


    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar">
                <button class="btn btn-light active" onclick="showTab('user')">User</button>
                <button class="btn btn-light" onclick="showTab('product')">Product</button>
                <button class="btn btn-light" onclick="showTab('review')">Review</button>
                <button class="btn btn-light" onclick="showTab('payment')">Payment</button>
            </div>

            <!-- Main Content -->
            <div class="col-md-10">
                <!-- User Table -->
                <div id="user" class="tab-content">
                    <h3 class="mt-4">User Management</h3>
                    <table class="table table-striped mt-3">
                        <thead class="table-light">
                            <tr>
                                <th>Number</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Password</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Create At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // $sqlUser = "SELECT * FROM users";
                            $resultUser = $conn->query($sqlUser);
                            if ($resultUser->num_rows > 0) {
                                $number = 1;
                                while ($row = $resultUser->fetch_assoc()) {
                                    echo "<tr data-user-id='" . $row['user_id'] . "'>";
                                    echo "<td>" . $number . "</td>";
                                    echo "<td>" . $row['name'] . "</td>";
                                    echo "<td>" . $row['email'] . "</td>";
                                    echo "<td>" . str_repeat('•', strlen($row['password'])) . "</td>";
                                    echo "<td>" . $row['phone'] . "</td>";
                                    echo "<td>" . $row['role'] . "</td>";
                                    echo "<td>" . $row['created_at'] . "</td>";
                                    echo "<td>
                                        <button class='btn btn-sm btn-primary' onclick=\"openEditForm('" . $row['user_id'] . "', '" . $row['name'] . "', '" . $row['email'] . "', '" . $row['password'] . "', '" . $row['phone'] . "', '" . $row['role'] . "')\">Edit</button>
                                        <a href='?delete_user=true&user_id={$row['user_id']}' class='btn btn-sm btn-danger' onclick=confirmDelete()>Del</a>
                                    </td>";
                                    echo "</tr>";
                                    $number++;
                                }
                            } else {
                                echo "<tr><td colspan='8'>No users found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- Product Table -->
                <div id="product" class="tab-content d-none">
                    <h3 class="mt-4">Product Management</h3>
                    <table class="table table-striped mt-3">
                        <thead class="table-light">
                            <tr>
                                <th>Number</th>
                                <th>Product Name</th>
                                <th>Description</th>
                                <th>Color</th>
                                <th>Gender</th>
                                <th>Type Name</th>
                                <th>Price</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Truy vấn sản phẩm từ cơ sở dữ liệu
                            $sqlProduct = "SELECT * FROM products";
                            $resultProduct = $conn->query($sqlProduct);
                            if ($resultProduct->num_rows > 0) {
                                $number = 1;
                                while ($row = $resultProduct->fetch_assoc()) {
                                    echo "<tr data-product_id='" . $row['product_id'] . "'>";
                                    echo "<td>$number</td>";
                                    echo "<td>{$row['name']}</td>";
                                    echo "<td>{$row['description']}</td>";
                                    echo "<td>{$row['color']}</td>";
                                    echo "<td>{$row['gender']}</td>";
                                    echo "<td>{$row['type_name']}</td>";
                                    echo "<td>{$row['price']}</td>";
                                    echo "<td><img src='{$row['image']}' alt='{$row['name']}' style='width: 100px;'></td>";
                                    echo "<td>
                                            <button class='btn btn-primary btn-sm' onclick=\"openEditFormProduct(
                                                '{$row['product_id']}', '{$row['name']}', '{$row['description']}',
                                                '{$row['color']}', '{$row['gender']}', '{$row['type_name']}',
                                                '{$row['price']}', '{$row['image']}'
                                            )\">Edit</button>
                                        
                                        <a href='?delete_product=true&product_id={$row['product_id']}' class='btn btn-sm btn-danger' onclick=confirmDelete()>Del</a>

                                          </td>";
                                    echo "</tr>";
                                    $number++;
                                }
                            } else {
                                echo "<tr><td colspan='9'>No products found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- Review Table -->
                <div id="review" class="tab-content d-none">
                    <h3 class="mt-4">Review Management</h3>
                    <table class="table table-striped mt-3">
                        <thead class="table-light">
                            <tr>
                                <th>Number</th>
                                <th>Review ID</th>
                                <th>Product ID</th>
                                <th>User ID</th>
                                <th>Comment</th>
                                <th>Create At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($reviews)): ?>
                                <?php foreach ($reviews as $index => $review): ?>
                                    <tr>
                                        <td><?php echo $index + 1; ?></td>
                                        <td><?php echo htmlspecialchars($review['review_id']); ?></td>
                                        <td><?php echo isset($review['product_id']) ? htmlspecialchars($review['product_id']) : 'N/A'; ?></td>
                                        <td><?php echo isset($review['user_id']) ? htmlspecialchars($review['user_id']) : 'N/A'; ?></td>
                                        <td><?php echo htmlspecialchars($review['comment']); ?></td>
                                        <td><?php echo htmlspecialchars($review['created_at']); ?></td>
                                        <td>
                                        <a href="?deleteReview&review_id=<?php echo htmlspecialchars($review['review_id']); ?>" class="btn btn-sm btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">No reviews found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>

                    </table>
                </div>

                <!-- Payment Table -->
                <div id="payment" class="tab-content d-none">
                    <h3 class="mt-4">Payment Management</h3>
                    <table class="table table-striped mt-3">
                        <thead class="table-light">
                            <tr>
                                <th>Number</th>
                                <th>Payment ID</th>
                                <th>Order ID</th>
                                <th>Payment Method</th>
                                <th>Total Amount</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($payments)): ?>
                                <?php foreach ($payments as $index => $payment): ?>
                                    <tr>
                                        <td><?php echo $index + 1; ?></td>
                                        <td><?php echo htmlspecialchars($payment['payment_id']); ?></td>
                                        <td><?php echo htmlspecialchars($payment['order_id']); ?></td>
                                        <td><?php echo htmlspecialchars($payment['payment_method']); ?></td>
                                        <td><?php echo htmlspecialchars($payment['total_amount']); ?></td>
                                        <td><?php echo htmlspecialchars($payment['payment_date']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7">No payment records found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Create form edits for Users  -->
        <div id="overlay" onclick="closeEditFormUser()"></div>
        <div id="edit-form-user" style="display: none;">
            <h4>Edit User</h4>
            <form id="edit-user-form" action="'../../controllers/AdminController.php'">
                <input type="hidden" name="user_id" id="edit-user-id">
                <i class="fas fa-times close-icon" onclick="closeEditFormUser()"></i>

                <div class="mb-3">
                    <label for="edit-name" class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" id="edit-name" required>
                </div>
                <div class="mb-3">
                    <label for="edit-email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" id="edit-email" required>
                </div>
                <div class="mb-3">
                    <label for="edit-password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="edit-password" required>
                </div>
                <div class="mb-3">
                    <label for="edit-phone" class="form-label">Phone</label>
                    <input type="text" class="form-control" name="phone" id="edit-phone" required>
                </div>
                <div class="mb-3">
                    <label for="edit-role" class="form-label">Role</label>
                    <input type="text" class="form-control" name="role" id="edit-role" required>
                </div>
                <div>
                    <button type="submit" class="btn btn-success">Save Changes</button>
                    <button type="button" class="btn btn-secondary" onclick="closeEditFormUser()">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Edit Product Form -->
    <div id="overlay" onclick="closeEditFormProduct()"></div>
        <form id="edit-product-form" style="display:none;">
            <input type="hidden" id="edit-product-id">

            <div class="mb-3">
                <label for="edit-name" class="form-label">Name</label>
                <input type="text" class="form-control" id="edit-name" required>
            </div>
            <div class="mb-3">
                <label for="edit-description" class="form-label">Description</label>
                <input type="text" class="form-control" id="edit-description" required>
            </div>
            <div class="mb-3">
                <label for="edit-color" class="form-label">Color</label>
                <input type="text" class="form-control" id="edit-color" required>
            </div>
            <div class="mb-3">
                <label for="edit-gender" class="form-label">Gender</label>
                <input type="text" class="form-control" id="edit-gender" required>
            </div>
            <div class="mb-3">
                <label for="edit-type-name" class="form-label">Type Name</label>
                <input type="text" class="form-control" id="edit-type-name" required>
            </div>
            <div class="mb-3">
                <label for="edit-price" class="form-label">Price</label>
                <input type="text" class="form-control" id="edit-price" required>
            </div>
            <div class="mb-3">
                <label for="edit-image" class="form-label">Image</label>
                <input type="text" class="form-control" id="edit-image" required>
            </div>
            <button type="submit" class="btn btn-success">Save Changes</button>
            <button type="button" class="btn btn-secondary" onclick="closeEditFormProduct()">Cancel</button>

    </form>
    <script src="../../../assets/js/admin.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>