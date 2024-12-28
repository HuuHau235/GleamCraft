<?php
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\core\Controller.php');
require_once('C:\xampp\htdocs\GleamCraft_MVC\app\models\Products.php');  // Bao gồm model sản phẩm

class HomepageController extends Controller {
    public function index() {
        // Tạo kết nối cơ sở dữ liệu
        $db = new Database();  // Khởi tạo đối tượng Db
        
        // Tạo đối tượng ProductModel và truyền kết nối CSDL vào
        $productModel = $this->model('Products', [$db->getConnection()]);  // Truyền kết nối CSDL
        
        // Lấy danh sách sản phẩm từ model
        $productHomepage = $productModel->getProductHomepage();
        
        // Truyền dữ liệu vào view
        $this->view('homepage/index', ['productHomepage' => $productHomepage]);
    }
}
?>
