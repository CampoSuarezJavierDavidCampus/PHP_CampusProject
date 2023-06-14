<?php
namespace Router;
use Helpers\Controllers;

class Router {    
    private string $model;    
    
    public function __construct(
        private ?\PDO $conn,        
    ){                        
        $uri = explode('/',trim($_SERVER['REQUEST_URI'],'/'));
        $model = isset($uri[0]) && $uri[0]!='/'?$uri[0]:'home';  
        $this->model = $model;          
    }
    public function render(){        
        try {
            $view = (new Controllers($this->conn))->get_controller($this->model);
            return $view;
        } catch (\Throwable $e) {
            echo $e->getMessage();
        }
    }

}