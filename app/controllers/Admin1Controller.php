<?php
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\core\Controller.php');
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\models\User1Model.php');
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\models\Products.php');
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\models\PaymentModel.php');

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
        $users = $this->userModel->getUserList();
        $products = $this->productModel->getAllProduct();
        $reviews = $this->productModel->getAllReview();
        $payment = $this->paymentMethod->getAllPayment();

        $this->view("admin/index", [
            "users" => $users,
            "products" => $products,
            "reviews" => $reviews,
            "payment" => $payment,
        ]);
    }
    public function delete()
    {
        $user_id = $_GET['user_id'] ?? '';
        $product_id = $_GET['product_id'] ?? '';
        $review_id = $_GET['review_id'] ?? '';
        $payment_id = $_GET['payment_id'] ?? '';

        if ($user_id) $this->userModel->deleteUser($user_id);
        if ($product_id) $this->productModel->deleteProducts($product_id);
        if ($review_id) $this->productModel->deleteReview($review_id);
        if ($payment_id) $this->paymentMethod->deletePayment($payment_id);

        header("Location:/Gleamcraft_MVC/public/Admin1");
        exit;
    }

    public function editUser($user_id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = htmlspecialchars($_POST['name']);
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);
            $phone = htmlspecialchars($_POST['phone']);
            $role = htmlspecialchars($_POST['role']);

            $this->userModel->updateUser($user_id, $name, $email, $password, $phone, $role);
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
                header("Location:/Gleamcraft_MVC/public/Admin1");
                exit;
            } else {
                echo "Có lỗi khi cập nhật sản phẩm!";
            }
        } else {
            $product = $this->productModel->getProductById($product_id);
            if ($product) {
                $this->view("admin/editProduct", ['product' => $product]);
            } else {
                header("Location:/Gleamcraft_MVC/public/Admin1");
                exit;
            }
        }
    }
}
?>
