<?php
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\core\Controller.php');
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\models\UserModel.php');
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\models\Reviews.php');
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\models\ProductsModel.php');
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\models\PaymentModel.php');

class AdminController extends Controller
{
    protected $userModel;
    protected $productModel;
    protected $paymentMethod;
    protected $reviewMethod;
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->productModel = new ProductsModel();
        $this->paymentMethod = new PaymentModel();
        $this->reviewMethod = new ReviewsModel();
    }
    public function index()
    {
        $users = $this->userModel->getUserList();
        $products = $this->productModel->getAllProduct();
        $reviews = $this->reviewMethod->getAllReview();
        $payment = $this->paymentMethod->getAllPayments();
        // var_dump($users); die;
        $this->view("admin/index", [
            "users" => $users,
            "products" => $products,
            "reviews" => $reviews,
            "payment" => $payment,
        ]);
    }
    public function research($query)
    {
        // Lấy giá trị của tham số 'query' từ URL
        $query = isset($_GET['query']) ? $_GET['query'] : '';

        // Kiểm tra nếu có dữ liệu tìm kiếm
        if ($query) {
            $users = $this->userModel->searchUsersByAll($query);
            $products = $this->productModel->searchProductByALL($query);
        } else {
            $users = $this->userModel->getUserList();
            $products = $this->productModel->getAllProduct();
        }

        // Gọi view và truyền dữ liệu
        $this->view("Admin/index", [
            "users" => $users,
            "products" => $products,
            "query" => $query
        ]);
    }
    // Xóa User
    public function deleteUser($user_id)
    {
        if (isset($_GET['user_id'])) {
            $user_id = $_GET['user_id'];
            $user = $this->userModel->getUserById($user_id);

            if ($user) {
                if ($user['role'] === "admin") {
                    echo "<script>alert('You are not allowed to delete the admin account.'); window.location.href = '/Admin';</script>";
                    exit;
                } else {
                    $this->userModel->deleteUser($user_id);
                    echo "<script>alert('You have successfully deleted the user account.'); window.location.href = '/Admin';</script>";
                    exit;
                }
            } else {
                echo "User not found.";
            }
        } else {
            echo "User ID is required.";
        }
        header("Location: /Admin");
        exit;
    }
    public function deleteProduct($product_id)
    {
        if (isset($_GET['product_id'])) {
            $product_id = $_GET['product_id'];
            $this->productModel->deleteProducts($product_id);
            echo "Product deleted successfully.";
        } else {
            echo "Product ID is required.";
        }
        header("Location: /Admin");
        exit;
    }
    // Xóa Reviews
    public function deleteReview($review_id)
    {
        if (isset($_GET['review_id'])) {
            $review_id = $_GET['review_id'];
            $this->productModel->deleteReview($review_id);
            echo "Review deleted successfully.";
        } else {
            echo "Review ID is required.";
        }
        header("Location: /Admin");
        exit;
    }
    // Xóa phương thức thanh toán
    public function deletePayment($payment_id)
    {
        if (isset($_GET['payment_id'])) {
            $payment_id = $_GET['payment_id'];
            $this->paymentMethod->deletePayment($payment_id);
            echo "Payment method deleted successfully.";
        } else {
            echo "Payment ID is required.";
        }
        header("Location: /Admin");
        exit;
    }
    //Chỉnh sửa User
    public function editUser($user_id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ form
            $name = htmlspecialchars($_POST['name']);
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);
            $phone = htmlspecialchars($_POST['phone']);
            $role = htmlspecialchars($_POST['role']);
            // Lấy thông tin người dùng để kiểm tra vai trò
            $user = $this->userModel->getUserById($user_id);
            if ($user['role'] === 'admin' && $role === 'admin') {
                $this->userModel->updateUser($user_id, $name, $email, $password, $phone, $role);
                echo "<script>alert('Tài khoản admin đã được cập nhật thành công.'); window.location.href = '/Admin';</script>";
                exit;
            }
            $adminCount = $this->userModel->getAdminCount();
            if ($role === 'admin' && $adminCount >= 1) {
                echo "<script>alert('Bạn không được phép chỉ vai trò thành admin vì đã có một tài khoản admin.'); window.location.href = '/Admin';</script>";
                exit;
            }
            // Cập nhật thông tin người dùng
            $this->userModel->updateUser($user_id, $name, $email, $password, $phone, $role);
            echo "<script>alert('User updated successfully.'); window.location.href = '/Admin';</script>";
            exit;
        } else {
            $user = $this->userModel->getUserById($user_id);
            if ($user) {
                $this->view("admin/index", ['user' => $user]);
            } else {
                header("Location:/Admin");
                exit;
            }
        }
    }
    //Chỉnh sửa Products
    public function editProducts($product_id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = htmlspecialchars($_POST['name']);
            $description = htmlspecialchars($_POST['description']);
            $color = htmlspecialchars($_POST['color']);
            $gender = htmlspecialchars($_POST['gender']);
            $type_name = htmlspecialchars($_POST['type_name']);
            $price = htmlspecialchars($_POST['price']);
            $image = htmlspecialchars($_POST['image']);
            if ($this->productModel->updateProducts($product_id, $name, $description, $color, $type_name, $gender, $price, $image)) {
                header("Location:/Admin");
                exit;
            } else {
                echo "Có lỗi khi cập nhật sản phẩm!";
            }
        } else {
            $product = $this->productModel->getProductById($product_id);
            if ($product) {
                $this->view("admin/editProduct", ['product' => $product]);
            } else {
                header("Location:/Admin");
                exit;
            }
        }
    }
}
?>