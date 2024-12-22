<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar {
            height: 100vh;
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        .sidebar button {
            width: 90%;
            margin: 10px auto;
            border-radius: 5px;
        }
        .sidebar .active {
            background-color: #f7c6c7;
            color: black;
        }
    </style>
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
                            <th>Full_Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Create_at</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Hồ Thị Kim Thanh</td>
                            <td>Thanh hồ</td>
                            <td>thanh1234@gmail.com</td>
                            <td>0335044593</td>
                            <td>4/12/2024</td>
                            <td>
                                <button class="btn btn-sm btn-primary">Edit</button>
                                <button class="btn btn-sm btn-danger">Del</button>
                            </td>
                        </tr>
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
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Create_at</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Product A</td>
                            <td>Category 1</td>
                            <td>$50</td>
                            <td>100</td>
                            <td>4/12/2024</td>
                            <td>
                                <button class="btn btn-sm btn-primary">Edit</button>
                                <button class="btn btn-sm btn-danger">Del</button>
                            </td>
                        </tr>
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
                            <th>Reviewer Name</th>
                            <th>Product</th>
                            <th>Rating</th>
                            <th>Comment</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Nguyễn Văn A</td>
                            <td>Product A</td>
                            <td>5</td>
                            <td>Great product!</td>
                            <td>
                                <button class="btn btn-sm btn-primary">Edit</button>
                                <button class="btn btn-sm btn-danger">Del</button>
                            </td>
                        </tr>
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
                            <th>Transaction ID</th>
                            <th>User</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>TX123456</td>
                            <td>Hồ Thị Kim Thanh</td>
                            <td>$100</td>
                            <td>Completed</td>
                            <td>
                                <button class="btn btn-sm btn-primary">View</button>
                                <button class="btn btn-sm btn-danger">Del</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function showTab(tabId) {
        // Hide all tabs
        document.querySelectorAll('.tab-content').forEach(tab => tab.classList.add('d-none'));
        // Remove active class from all sidebar buttons
        document.querySelectorAll('.sidebar button').forEach(btn => btn.classList.remove('active'));
        // Show selected tab and activate the corresponding button
        document.getElementById(tabId).classList.remove('d-none');
        document.querySelector(`.sidebar button[onclick="showTab('${tabId}')"]`).classList.add('active');
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
