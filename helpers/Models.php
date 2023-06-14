<?php
namespace Helpers;
use App\ORM;
use App\Model;
/* MY MODELS */
use Models\PersonModel;

class Models{        
    private array $models = [];    
    private ?\PDO $conn;
    private $obj = null;
    public function __construct(\PDO $conn,$obj = null)
    {        
        if(!$obj instanceof ORM)throw new \Exception('INVALID TABLE');
        $this->conn = $conn;
        $this->set_obj($obj);
        $this->init();
    }
    private function set_obj($obj):void{
        if($_SERVER['REQUEST_METHOD']!='GET' && !$obj instanceof ORM)throw new \Exception('ERROR UNDEFINED OBJ');
        $this->obj = $obj;
    }
    private function set_model(string $name, $model):void{        
        $this->models[$name] = $model;
    }    
    public function get_model(string $name):array{
        if(in_array($name,$this->models))throw new \Exception('UNDEFINED MODEL');      
        $res = [] ;
        new $this->models[$name]($this->obj,$this->conn,$res);    
        $this->conn = null;
        return $res;    
    }
    private function init():void{
        /* INSERT MODELS (los nombres van en singular.) => */
        $this->set_model('Person',PersonModel::class);
    }
}