<?php
class App {
    protected $controller = 'HomepageController';
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->parseUrl();

        // Xử lý controller
        if (isset($url[0]) && file_exists('./app/controllers/' . $url[0] . 'Controller.php')) {
            $this->controller = $url[0] . "Controller";
            unset($url[0]);
        }

        require_once '../app/controllers/' . $this->controller . '.php';
        $controller = new $this->controller;

        // Xử lý method
        if (isset($url[1]) && method_exists($controller, $url[1])) {
            $this->method = $url[1];
            unset($url[1]);
        }

        // Tham số
        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$controller, $this->method], $this->params);
    }

    // Hàm phân tích URL
    public function parseUrl() {
        if (isset($_GET['url']) && is_string($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return [];
    }
}

?>
