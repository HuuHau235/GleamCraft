<?php
class App {
    protected $controller = 'homepage'; // Default controller
    protected $method = 'index'; // Default method
    protected $params = []; // Default parameters

    public function __construct()
    {
        $url = $this->parsePath();
        // var_dump($url);
    
        if (!empty($url['path'])) {
            $controllerName = ucfirst($url['path'][0]) . 'Controller';
            
            if (file_exists('./app/controllers/' . $controllerName . '.php')) {
                $this->controller = $controllerName;
            } else {
                require_once './app/controllers/homepage.php';
            }
    
            require_once './app/controllers/' . $this->controller . '.php';
    
            $controllerInstance = new $this->controller();
    
            if (isset($url['path'][1]) && method_exists($controllerInstance, $url['path'][1])) {
                $this->method = $url['path'][1];
            } elseif (!isset($url['path'][1])) {
                $this->method = 'index';
            } else {
                http_response_code(404);
                die("Method '{$url['path'][1]}' not found in controller '{$this->controller}'.");
            }
    
            $this->params = $url['params'] ?? [];
        } else {
            http_response_code(404);
            die("No path found in URL.");
        }
        // var_dump($this->params);
        
        call_user_func_array([$controllerInstance, $this->method], $this->params);
    }
    

    private function parsePath()
{
    // Lấy URL path từ REQUEST_URI
    $path = $_SERVER['REQUEST_URI'] ?? '/';

    // Tách URL thành phần path và query string
    $pathParts = explode('?', $path);

    // Loại bỏ dấu '/' ở đầu và cuối path, sau đó tách thành mảng
    $pathArray = explode('/', trim($pathParts[0], '/'));

    // Mảng chứa các tham số
    $params = [];

    // Nếu có query string (phần sau dấu '?')
    if (isset($pathParts[1])) {
        parse_str($pathParts[1], $params); // Chuyển query string thành mảng
    }

    return [
        'path' => $pathArray,  // Trả về mảng các phần của path
        'params' => $params,   // Trả về mảng các tham số
    ];
}

}
?>