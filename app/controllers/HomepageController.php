<?php
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\core\Controller.php');
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\models\ProductsModel.php');  // Bao gồm model sản phẩm

class HomepageController extends Controller {
    public function index() {
        $db = new Database();  
        $productModel = $this->model('ProductsModel', [$db->getConnection()]); 
        $productHomepage = $productModel->getProductHomepage();
        $this->view('homepage/index', ['productHomepage' => $productHomepage]);
    }
    public function brands() {
        $this->view("brands/index", []);
    }
    public function Collection() {
        $this->view("collection/index", []);
    }
    public function AboutUs() {
        $this->view("AboutUs/index", []);
    }
}
?>
