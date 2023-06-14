<?php
namespace Router;
use Router\Routes;
use Router\Route;
use Exception;

class Router {
    private array $routes = [];
    private string $model;    
    private int $id;    
    private ?string $identifier = null;
    public function __construct(
        private ?\PDO $conn,        
    ){                
        $uri = explode('/',trim($_SERVER['REQUEST_URI'],'/'));                        
        $model = isset($uri[0])?$uri[0]:'home';        
        $function = isset($uri[1])?$uri[1]:null;
        $id = 0;
        if(isset($uri[2])){
            if(is_numeric($uri[2]))(int)$id = $uri[2];
            $this->set_identifier($uri[2]);
        }
        
        if($function){             
            if(is_numeric($function))$id = $function;            
            $this->set_identifier($function);                        
            if(($function === 'delete' || $function === 'edit') && isset($id) && is_numeric($id) && $id === 0 && $id ==$this->identifier)throw new Exception('ERROR: INVALID REQUEST');            
            $function = match($function){
                'insert'=>'POST',
                'delete'=>'DELETE',
                'edit'=>'PUT',
                default=>null
            }; 
        }
                                       
        $_SERVER['REQUEST_METHOD'] = $function??='GET';        
        $this->model = $model;        
        $this->id = $id;
        Routes::init($this);

    }
    public function set_route(string $name, Route $route){
        $this->routes[$name] = $route;
    }
    private function set_identifier($id){
        if(empty($this->identifier) &&
            !empty(trim($id)) &&
            $id != 'insert' &&
            $id != 'edit' &&
            $id != 'delete' &&
            $id != 'search'

        ){
            $identifier = strip_tags($id);
            $identifier = filter_var($identifier,FILTER_SANITIZE_SPECIAL_CHARS);
            $identifier = strtolower(trim($identifier));            
            $this->identifier = $identifier;
        }
    }   
    private function get_id(){
        $id = ($this->id==$this->identifier || empty($this->identifier))
        ?$this->id
        :$this->identifier;
        return $id;
    } 
    public function render(){;
        if(!isset($this->routes[$this->model]))throw new Exception('No route found');
        $controller = $this->routes[$this->model];                      
        $view =  $controller->render($this->conn,$this->get_id());
        $this->conn = null;
        return $view;
    }

}