<?php include('../../../config/db.php');
require_once "../../models/Admin.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../assets/css/admin.css">
</head>

<body>
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
                            if ($resultUser->num_rows > 0) {
                                $number = 1;
                                while ($row = $resultUser->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $number . "</td>";
                                    echo "<td>" . $row['name'] . "</td>";
                                    echo "<td>" . $row['email'] . "</td>";
                                    echo "<td>" . $row['password'] . "</td>";
                                    echo "<td>" . $row['phone'] . "</td>";
                                    echo "<td>" . $row['role'] . "</td>";
                                    echo "<td>" . $row['created_at'] . "</td>";
                                    echo "<td>
                                <button class='btn btn-sm btn-primary' onclick= OpenEditUser()>Edit</button>
                                <button class='btn btn-sm btn-danger'>Del</button>
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
                                <th style="width:300px;">Product Name</th>
                                <th style="width:200px;">Description</th>
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
                            if ($resultProduct->num_rows > 0) {
                                $number = 1;
                                while ($row = $resultProduct->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td style='text-align: center; vertical-align: middle;'>" . $number . "</td>";
                                    echo "<td style='text-align: center; vertical-align: middle;'>" . $row['name'] . "</td>";
                                    echo "<td style='text-align: center; vertical-align: middle;'>" . $row['description'] . "</td>";
                                    echo "<td style='text-align: center; vertical-align: middle;'>" . $row['color'] . "</td>";
                                    echo "<td style='text-align: center; vertical-align: middle;'>" . $row['gender'] . "</td>";
                                    echo "<td style='text-align: center; vertical-align: middle;'>" . $row['type_name'] . "</td>";
                                    echo "<td style='text-align: center; vertical-align: middle;'>" . $row['price'] . "</td>";
                                    echo "<td style='text-align: center; vertical-align: middle;'>
                                        <img src='" . $row['image'] . "' alt='" . $row['name'] . "' style='width: 100px; height: auto; display: block; margin: 0 auto;'>
                                         </td>";
                                    echo "<td style='text-align: center; vertical-align: middle;'>
                                            <button class='btn btn-sm btn-primary'>Edit</button>
                                            <button class='btn btn-sm btn-danger'>Del</button>
                                        </td>";
                                    echo "</tr>";
                                    $number++;
                                }
                            } else {
                                echo "<tr><td colspan='8' style='text-align: center; vertical-align: middle;'>No products found</td></tr>";
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
                                        <td><?php echo htmlspecialchars($review['product_id']); ?></td>
                                        <td><?php echo htmlspecialchars($review['user_id']); ?></td>
                                        <td><?php echo htmlspecialchars($review['comment']); ?></td>
                                        <td><?php echo htmlspecialchars($review['created_at']); ?></td>
                                        <td>
                                        <a href="index.php?action=deleteReview&review_id=<?php echo htmlspecialchars($review['review_id']); ?>" class="btn btn-sm btn-danger">Delete</a>
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
                                <th>Status</th>
                                <th>Amount</th>
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
        <div id="edit-form-user">
            <h4>Edit User</h4>
            <form action="" method="POST">
                <div class="mb-3">
                    <label for="" class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Email</label>
                    <input type="text" class="form-control" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Password</label>
                    <input type="text" class="form-control" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Phone</label>
                    <input type="text" class="form-control" name="phone" required>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Role</label>
                    <input type="text" class="form-control" name="role" required>
                </div>
                <div>
                    <button type="submit" class="btn btn-success">Save Changes</button>
                    <button type="button" class="btn btn-secondary" onclick="closeEditFormUser()">Cancel</button>
                </div>
            </form>
        </div>
    </div>
<script src="../../../assets/js/admin.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>