<?php
namespace Helpers;
use App\Controller;
/* MY CONTROLLERS */
use Controllers\PersonController;

class Controllers{    
    private array $controllers = [];
    private int $id;
    private ?string $id_2 = null;
    

    public function __construct(
        private ?\PDO $conn
    ){
        $this->init();
        $this->set_id();
    }
    private function set_id(){
        $uri = explode('/',trim($_SERVER['REQUEST_URI'],'/'));
        $function = isset($uri[1])?$uri[1]:null;
        $id = 0;
        if(isset($uri[2])){
            if(is_numeric($uri[2]))(int)$id = $uri[2];
            $this->set_identifier($uri[2]);
        }
        
        if($function){             
            if(is_numeric($function))$id = $function;            
            $this->set_identifier($function);                        
            if(($function === 'delete' || $function === 'edit') && isset($id) && is_numeric($id) && $id === 0 && $id ==$this->id_2)throw new \Exception('ERROR: INVALID REQUEST');            
            $function = match($function){
                'insert'=>'POST',
                'delete'=>'DELETE',
                'edit'=>'PUT',
                default=>null
            }; 
        }                                       
        $_SERVER['REQUEST_METHOD'] = $function??='GET';                      
        $this->id = $id;
        
    }
    private function get_id(){
        $id = ($this->id==$this->id_2 || empty($this->id_2))
        ?$this->id
        :$this->id_2;
        return $id;
    } 
    private function set_identifier($id){
        if(empty($this->id_2) &&
            !empty(trim($id)) &&
            $id != 'insert' &&
            $id != 'edit' &&
            $id != 'delete' &&
            $id != 'search'

        ){
            $identifier = strip_tags($id);
            $identifier = filter_var($identifier,FILTER_SANITIZE_SPECIAL_CHARS);
            $identifier = strtolower(trim($identifier));            
            $this->id_2 = $identifier;
        }
    }   
    private function set_controller(string $name, string $controller){
        $this->controllers[$name] = $controller;
    }
    public function get_controller(string $name){
        if(!in_array($name, array_keys($this->controllers)))throw new \Exception("ERROR: NOT FOUND");
        $controller = new ($this->controllers[$name])($this->get_id());
        if(!$controller instanceof Controller)throw new \Exception("ERROR: INVALID CONTROLLER");
        $view = $controller->render($this->conn);
        return $view;
    }
    private function init(){
        /* INSERT CONTROLLERS (los nombres van en singular.)=>*/
        $this->set_controller('person',PersonController::class);
    }

}