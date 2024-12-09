<?php

namespace App\Core;

class App {
    protected $controller = 'HomepageController'; // Controller mặc định
    protected $method = 'index'; // Phương thức mặc định
    protected $params = []; // Các tham số

    public function __construct() {
        $url = $this->parseUrl();

        // Kiểm tra controller
        if (isset($url[0]) && file_exists('../app/controllers/' . $url[0] . '.php')) {
            $this->controller = $url[0];
            unset($url[0]);
        }

        // Include controller
        $controllerPath = '../app/controllers/' . $this->controller . '.php';
        if (file_exists($controllerPath)) {
            require_once $controllerPath;
            $controllerClass = '\\App\\Controllers\\' . $this->controller;
            $this->controller = new $controllerClass;
        } else {
            die("Controller not found: " . $this->controller);
        }

        // Kiểm tra method
        if (isset($url[1]) && method_exists($this->controller, $url[1])) {
            $this->method = $url[1];
            unset($url[1]);
        }

        // Các tham số còn lại
        $this->params = $url ? array_values($url) : [];

        // Gọi controller và method
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    private function parseUrl() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return []; // Trả về mảng rỗng nếu không có URL
    }
}
