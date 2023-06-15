<?php
namespace App;
abstract class ORM{
    public string|int|null $id = null;
    public string|int|null $current_id = null;    
    protected function set_id(string|int $id):void{
        $id = filter_var($id,FILTER_SANITIZE_SPECIAL_CHARS);
        $id = strip_tags($id);        
        if($_SERVER['REQUEST_METHOD']==='POST' || (!empty($this->id) && $_SERVER['REQUEST_METHOD']==='PUT' && !empty($_POST))){            
            $this->current_id = $id;
        }else{            
            $this->id = $id;
        }
    }
    abstract public function get_params():array;
    abstract protected function set_params():void;
    abstract protected function validate():void;
    public function __construct(int|string|null $id = null){        
        $method = $_SERVER['REQUEST_METHOD'];
        if(!empty($id))$this->set_id($id);        
        if($_SERVER['REQUEST_METHOD'] !== 'POST' && $_SERVER['REQUEST_METHOD']!== 'GET' && empty($_POST) && empty($id))
        throw new \Exception('ERROR: NOT FOUND');        
        if($method=='POST' || ($method=='PUT' && !empty($_POST)) )$this->set_params();
    }
}

