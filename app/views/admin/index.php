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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../assets/css/admin.css">
    <link rel="stylesheet" href="../../../assets/css/header.css">

    
</head>


<body>
<header class="bg-light border-bottom d-flex align-items-center">
    <div class="container-fluid d-flex justify-content-between align-items-center px-4">
        <a href="/" class="navbar-brand d-flex align-items-center">
            <img src="../assets/images/brands/logo.jpg" alt="Logo" height="40">
        </a>
        <ul class="nav d-flex justify-content-end align-items-center">
            <li class="nav-item">
                <form action="/Admin/research" method="GET" class="d-flex">
                    <input type="text" name="query" class="form-control me-2" placeholder="Tìm kiếm..."
                        value="<?= htmlspecialchars($query ?? '') ?>" />
                    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                </form>
                <div id="search-results" style="display: none;"></div>
            </li>
        </ul>
    </div>
</header>
    <div class="container-fluid">
        <!-- Hiển thị tìm kiếm của users -->
        <?php if (!empty($query)): ?>
            <?php if (!empty($users)): ?>
                <ul class="list-group mt-3">
                    <?php foreach ($users as $useproductsr): ?>
                        <li class="list-group-item">
                            <?= htmlspecialchars($user['name']) ?> (Email: <?= htmlspecialchars($user['email']) ?>)
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="mt-3">Không tìm thấy kết quả nào.</p>
            <?php endif; ?>
        <?php endif; ?>
        <!-- Hiển thị tìm kiếm của products -->
        <?php if (!empty($query)): ?>
            <?php if (!empty($products)): ?>
                <ul class="list-group mt-3">
                    <?php foreach ($products as $products): ?>
                        <li class="list-group-item">
                            <?= htmlspecialchars($products['name']) ?> (Email: <?= htmlspecialchars($products['email']) ?>)
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="mt-3">Không tìm thấy kết quả nào.</p>
            <?php endif; ?>
        <?php endif; ?>
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar">
                <button class="btn btn-light active" onclick="showTab('user')">User</button>
                <button class="btn btn-light" onclick="showTab('product')">Product</button>
                <button class="btn btn-light" onclick="showTab('review')">Review</button>
                <button class="btn btn-light" onclick="showTab('payment')">Payment</button>
                <a href="/User/login"><button class="btn btn-light" onclick="showTab('login')">Log Out</button></a>
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
                            $users = $data['users'];
                            ?>
                            <?php
                            if ($users) {
                                foreach ($users as $number => $row) {
                                    echo "<tr data-user-id='" . $row['user_id'] . "'>";
                                    echo "<td>" . $number + 1 . "</td>";
                                    echo "<td>" . $row['name'] . "</td>";
                                    echo "<td>" . $row['email'] . "</td>";
                                    echo "<td>" . str_repeat('•', strlen($row['password'])) . "</td>";
                                    echo "<td>" . $row['phone'] . "</td>";
                                    echo "<td>" . $row['role'] . "</td>";
                                    echo "<td>" . $row['created_at'] . "</td>";
                                    echo "<td>
                                        <button class='btn btn-sm btn-primary' onclick=\"openEditFormUser('" . $row['user_id'] . "', '" . $row['name'] . "', '" . $row['email'] . "', '" . $row['password'] . "', '" . $row['phone'] . "', '" . $row['role'] . "')\">Edit</button>
                                    <a href='/Admin/deleteUser?user_id={$row['user_id']}' class='btn btn-sm btn-danger' onclick=\"return confirmDelete()\">Del</a>
                                        

                                    </td>";
                                    echo "</tr>";
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
                            $products = isset($data['products']) ? $data['products'] : [];
                            ?>
                            <?php
                            if ($products) {
                                foreach ($products as $number => $row) { {
                                        echo "<tr data-product_id='" . $row['product_id'] . "'>";
                                        echo "<td>" . $number + 1 . "</td>";
                                        echo "<td style='width: 350px'>{$row['name']}</td>";
                                        echo "<td style='width: 350px'>{$row['description']}</td>";
                                        echo "<td>{$row['color']}</td>";
                                        echo "<td>{$row['gender']}</td>";
                                        echo "<td>{$row['type_name']}</td>";
                                        echo "<td>{$row['price']}</td>";
                                        echo "<td><img src='{$row['image']}' alt='{$row['name']}' style='width: 100px;'></td>";
                                        echo "<td>
                                        <button class='btn btn-sm btn-primary' onclick=\"openEditFormProduct('" . $row['product_id'] . "', '" . $row['name'] . "', '" . $row['description'] . "', '" . $row['color'] . "', '" . $row['gender'] . "', '" . $row['type_name'] . "', '" . $row['price'] . "', '" . $row['image'] . "')\">Edit</button>
                                            <a href='/Admin/deleteProduct?product_id={$row['product_id']}' class='btn btn-sm btn-danger' onclick=\"return confirmDelete()\">Del</a>

                                          </td>";
                                        echo "</tr>";
                                    }
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
                            <?php
                            $reviews = isset($data['reviews']) ? $data['reviews'] : [];
                            ?>
                            <?php
                            if ($reviews) {
                                foreach ($reviews as $index => $row) {
                                    echo "<tr data-review_id='" . htmlspecialchars($row['review_id']) . "'>";
                                    echo "<td>" . ($index + 1) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['review_id']) . "</td>";
                                    echo "<td>" . (isset($row['product_id']) ? htmlspecialchars($row['product_id']) : 'N/A') . "</td>";
                                    echo "<td>" . (isset($row['user_id']) ? htmlspecialchars($row['user_id']) : 'N/A') . "</td>";
                                    echo "<td>" . htmlspecialchars($row['comment']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                                    echo "<td>
                                   <a href='/Admin/deleteReview?review_id={$row['review_id']}' class='btn btn-sm btn-danger' onclick=\"return confirmDelete()\">Del</a>
              
                                      </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='7' class='text-center'>No reviews found.</td></tr>";
                            }
                            ?>

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
                                <th>Total Amount</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $payment = isset($data['payment']) ? $data['payment'] : [];
                            ?>
                            <?php
                            if ($payment) {
                                foreach ($payment as $index => $row) {
                                    echo "<tr>";
                                    echo "<td>" . ($index + 1) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['payment_id']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['order_id']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['total_amount']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['payment_date']) . "</td>";
                                    echo "<td>
                                    <a href='/Admin/deletePayment?payment_id={$row['payment_id']}' class='btn btn-sm btn-danger' onclick=\"return confirmDelete()\">Del</a </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6' class='text-center'>No payments found.</td></tr>";
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Create form edits for Users  -->
    <div id="overlay" onclick="closeEditFormUser()"></div>
    <div id="edit-form-user" style="display: none;">
        <h4>Edit User</h4>
        <form id="edit-user-form" action="" method="POST">
            <input type="hidden" name="user_id" id="edit-user-id" value="update_user">
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
                <!-- <a href="/Gleamcraft_MVC/public/Admin/edit?user_id={$row['user_id']}'"></a> -->
                <button type="submit" class="btn btn-success" name="update_user">Save Changes</button>
                <button type="button" class="btn btn-secondary" onclick="closeEditFormUser()">Cancel</button>
            </div>
        </form>
    </div>

    <div id="overlay" onclick="closeEditFormProduct()"></div>
    <div id="edit-form-product" style="display: none;">
        <h4>Edit Products</h4>
        <form id="edit-product-form" method="POST" action="">
            <input type="hidden" id="edit-product-id" name="product_id">
            <i class="fas fa-times close-icon" onclick="closeEditFormProduct()"></i>
            <div class="mb-3">
                <label for="editt-name" class="form-label">Name</label>
                <input type="text" class="form-control" id="editt-name" name="name">
            </div>
            <div class="mb-3">
                <label for="edit-description" class="form-label">Description</label>
                <input type="text" class="form-control" id="edit-description" name="description">
            </div>
            <div class="mb-3">
                <label for="edit-color" class="form-label">Color</label>
                <input type="text" class="form-control" id="edit-color" name="color">
            </div>
            <div class="mb-3">
                <label for="edit-gender" class="form-label">Gender</label>
                <input type="text" class="form-control" id="edit-gender" name="gender">
            </div>
            <div class="mb-3">
                <label for="edit-type-name" class="form-label">Type Name</label>
                <input type="text" class="form-control" id="edit-type-name" name="type_name">
            </div>
            <div class="mb-3">
                <label for="edit-price" class="form-label">Price</label>
                <input type="text" class="form-control" id="edit-price" name="price">
            </div>
            <div class="mb-3">
                <label for="edit-image" class="form-label">Image</label>
                <input type="text" class="form-control" id="edit-image" name="image">
            </div>
            <button type="submit" class="btn btn-success" name="update_product">Save Changes</button>
            <button type="button" class="btn btn-secondary" onclick="closeEditFormProduct()">Cancel</button>
        </form>
    </div>
    <script src="../../../assets/js/admin.js"></script>
</body>

</html>