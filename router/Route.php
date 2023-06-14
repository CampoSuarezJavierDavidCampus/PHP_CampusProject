<?php
namespace Router;
use Exception;
class Route{    
    private array $controllers;
    public function __construct(){
        return $this;
    }
    public function set_controllers($method,callable $controller):Route{
        $this->controllers[$method] = $controller;
        return $this;
    }

    public function render(\PDO $conn,string|int $id){
        $method = $_SERVER['REQUEST_METHOD'];                         
        $controller = $this->controllers[$method];
        if($controller==null)throw new Exception('ACCESO DENEGADO');        
        return call_user_func($controller,$id)->render($conn);
    }
}