<?php
class App {
    protected $controller = 'HomepageController';
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->parsePath();
        // var_dump($url); die;
        if (!empty($url)){
            $path = $url['path'];
            $params = $url['params'];
            // Xử lý controller
            if (isset($path[0]) && file_exists('./app/controllers/' . $path[0] . 'Controller.php')) {
                $this->controller = $path[0] . "Controller";
            }

            require_once './app/controllers/' . $this->controller . '.php';
            $controller = new $this->controller;
            // Xử lý method
            if (isset($path[1]) && method_exists($controller, $path[1])) {
                $this->method = $path[1];
            }
            // Tham số
            $this->params = $params ? array_values($params) : [];
        }
        call_user_func_array([$controller, $this->method], $this->params);
    }
    
    function parsePath() {
        $path = $_SERVER['REQUEST_URI'] ?? '';
        // Kiểm tra nếu đường dẫn trống
        if (empty($path)) {
            return [
                'path' => [],
                'params' => []
            ];
        }

        // Tách phần đường dẫn và phần query (nếu có)
        $pathParts = explode('?', $path);
        
        // Tách đường dẫn chính theo dấu "/"
        $pathArray = explode('/', $pathParts[0]);

        // Kiểm tra nếu đường dẫn có ít hơn 4 phần, trả về lỗi hoặc mảng trống
        if (count($pathArray) < 4) {
            return [
                'path' => [],
                'params' => []
            ];
        }

        // Loại bỏ 2 phần đầu tiên (aba và ab)
        $pathArray = array_slice($pathArray, 3);

        // Lấy phần thứ 3 và thứ 4 (nếu có) tạo thành mảng path
        $path = array_slice($pathArray, 0, 2);
        // Xử lý các phần còn lại sau thứ 4 hoặc phần query nếu có
        $params = [];
        if (count($pathArray) > 2) {
            // Phần còn lại sau thứ 4
            $params = array_slice($pathArray, 2);
        }

        // Nếu có phần query (sau dấu ?), tách và xử lý
        if (isset($pathParts[1])) {
            parse_str($pathParts[1], $queryParams);
            $params = array_merge($params, $queryParams);
        }

        return [
            'path' => $path,
            'params' => $params
        ];
    }
}


?>
