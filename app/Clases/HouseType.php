<?php
namespace App\Clases;
use App\ORM;
use Exception;

class HouseType extends ORM{ 
    protected ?string $name_hausetype = null;
 
    protected function validate():void{        
        if(($_SERVER['REQUEST_METHOD']==='POST' ||
            ($_SERVER['REQUEST_METHOD']==='PUT' && !empty($_POST))) && 
            (empty($_POST) ||
            !isset($_POST['nombre']) || empty(trim($_POST['nombre'])) )                                                
        )throw new Exception('ERROR: INVALID PARAMETERS');
        if(
            (!empty($this->id) && $_SERVER['REQUEST_METHOD']==='GET' && !is_numeric($this->id)) ||
            ($_SERVER['REQUEST_METHOD']!='GET' && $_SERVER['REQUEST_METHOD']!='POST' && !is_numeric($this->id))
        )throw new Exception('ERROR: INVALID PARAMETERS');           
    }
    protected function set_params():void{
        $this->name_hausetype =filter_input(INPUT_POST,'nombre',FILTER_SANITIZE_FULL_SPECIAL_CHARS);        
    }
    public function get_params():array{
        $this->validate();
        $datos = [];
        if(!empty($this->id))$datos['id']=$this->id;
        if(!empty($this->name_hausetype))$datos['name_hausetype']=$this->name_hausetype;        
        return $datos;
    }
}