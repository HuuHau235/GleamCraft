<?php
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\core\Controller.php');
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\models\User1Model.php');
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\models\Products.php'); // Thêm model sản phẩm
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\models\PaymentModel.php'); // Thêm model paymentMethod-

class Admin1Controller extends Controller
{
    protected $userModel;
    protected $productModel;
protected $paymentMethod;
    public function __construct()
    {
        $this->userModel = new User1Model();
        $this->productModel = new Products();
        $this->paymentMethod = new PaymentMethod();

    }

    public function index()
    {
        // Lấy danh sách người dùng
        $users = $this->userModel->getUserList();

        // Lấy danh sách sản phẩm
        $products = $this->productModel->getAllProduct();

        // Lấy danh sách đánh giá sản phẩm
        $reviewsProducts = new Products();
        $reviews = $reviewsProducts->getAllReview();
        // Lấy danh sách phương thức thanh toán
        $paymentMethod = new PaymentMethod();
        $payment = $this->paymentMethod->getAllPayment();
        // Truyền dữ liệu vào view
        $this->view("admin/index", [
            "users" => $users,
            "products" => $products,
            "reviews" => $reviews,
            "payment" => $payment  // Truyền payment vào view
        ]);

    }

    public function delete()
    {
        // Xóa người dùng
        $user_id = $_GET['user_id'] ?? '';
        if (!empty($user_id)) {
            $this->userModel->deleteUser($user_id);
        }

        // Xóa sản phẩm
        $product_id = $_GET['product_id'] ?? '';
        if (!empty($product_id)) {
            $this->productModel->deleteProducts($product_id);
        }

        $review_id = $_GET['review_id'] ?? '';
        if (!empty($review_id)) {
            $this->productModel->deleteReview($review_id);
        }

        $payment_id = $_GET['payment_id'] ?? '';
        if (!empty($payment_id)) {
            $this->paymentMethod->deletePayment($payment_id);
        }
        


        // Chuyển hướng sau khi xử lý
        header("Location:/Gleamcraft_MVC/public/Admin1");
        exit;

        

    }



    public function edit($user_id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $phone = $_POST['phone'];
            $role = $_POST['role'];
            $updatedUser = $this->userModel->updateUser($user_id, $name, $email, $password, $phone, $role);

            header("Location:/Gleamcraft_MVC/public/Admin1");
            exit;
        } else {
            $user = $this->userModel->getUserById($user_id);
            if ($user) {
                $this->view("admin/index", ['user' => $user]);
            } else {
                header("Location:/Gleamcraft_MVC/public/Admin1");
                exit;
            }
        }
    }

    public function editProduct($product_id)
{
    // Check if the request method is POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get data from the form
        $name = $_POST['name'];
        $description = $_POST['description'];
        $color = $_POST['color'];
        $gender = $_POST['gender'];
        $type_name = $_POST['type_name'];
        $price = $_POST['price'];
        $image = $_POST['image'];

        // Call the model method to update the product
        $updatedProduct = $this->productModel->updateProduct($product_id, $name, $description, $color, $gender, $type_name, $price, $image);

        // Redirect to the product list page
        header("Location:/Gleamcraft_MVC/public/Admin1");
        exit;
    } else {
        // If GET request, get the product details by ID
        $product = $this->productModel->getProductById($product_id);

        if ($product) {
            // Display the form with the existing product details
            $this->view("admin/editProduct", ['product' => $product]);
        } else {
            // If product doesn't exist, redirect to the product list page
            header("Location:/Gleamcraft_MVC/public/Admin1");
            exit;
        }
    }
}





}
?>