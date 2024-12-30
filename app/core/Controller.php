<?php
class Controller {
    public function model($model, $args = []) {
        // Bao gồm file model
        require_once "../app/models/" . $model . ".php";
        return new $model(...$args);  // Sử dụng cú pháp unpacking để truyền tham số cho constructor
    }

    public function view($view, $data = []) {
        $file = "../app/views/" . $view . ".php";  // Đảm bảo đường dẫn đúng
        if (file_exists($file)) {
            require_once $file;  // Bao gồm view nếu tồn tại
        } else {
            die("View file does not exist: " . $file);  // Xử lý khi view không tồn tại
        }
    }

    public function redirect($url) {
        header("Location: $url");
        exit();
    }
}
?>
