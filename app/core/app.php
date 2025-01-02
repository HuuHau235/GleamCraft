<?php
class App {
    protected $controller = 'homepage'; // Default controller
    protected $method = 'index'; // Default method
    protected $params = []; // Default parameters

    public function __construct() {
        $url = $this->parsePath();
        //after parsing the path, we have an array with keys 'path' and 'params'
        //ex with url = 'user/login?blabla=1' => controller = user, method = login, params = ['blabla' => 1]
        //  it means call function login with parameter blabla = 1 in UserController
        if (!empty($url['path'])) {
            
            $controllerName = ucfirst($url['path'][0] ?? '') . 'Controller'; // get path[0] => get controller name = 'user'
            // after that, we add string 'Controller' => userController
            if (file_exists('./app/controllers/' . $controllerName . '.php')) {
                // check if file userController.php exists in folder app/controllers
                $this->controller = $controllerName;
            } else {
                http_response_code(404);
                die("Controller '{$controllerName}' not found.");
            }
            require_once './app/controllers/' . $this->controller . '.php';
            $controllerInstance = new $this->controller;
            // path[1] => method (login)
            if (isset($url['path'][1]) && method_exists($controllerInstance, $url['path'][1])) {
                $this->method = $url['path'][1];

            } elseif (!isset($url['path'][1])) {
                $this->method = 'index';
            } else {
                http_response_code(404);
                die("Method '{$url['path'][1]}' not found in controller '{$this->controller}'.");
            }
            $this->params = $url['params'] ?? [];
        }
        call_user_func_array([$controllerInstance, $this->method], $this->params);
    }

    private function parsePath() {
        // get url path
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        // return array of path and params
        $pathParts = explode('?', $path);
        $pathArray = explode('/', trim($pathParts[0], '/'));
        $params = [];
        if (isset($pathParts[1])) {
            parse_str($pathParts[1], $queryParams);
            $params = $queryParams;
        }
        return [
            'path' => $pathArray,
            'params' => $params
        ];
    }
}
?>