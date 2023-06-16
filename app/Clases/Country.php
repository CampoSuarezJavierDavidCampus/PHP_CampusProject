<?php
namespace App\Clases;
use App\ORM;
use Exception;

class Country extends ORM{ 
    protected ?string $name_country = null;
 
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
        $this->name_country =filter_input(INPUT_POST,'nombre',FILTER_SANITIZE_FULL_SPECIAL_CHARS);        
    }
    public function get_params():array{
        $this->validate();
        $datos = [];
        if(!empty($this->id))$datos['id']=$this->id;
        if(!empty($this->name_country))$datos['name_country']=$this->name_country;        
        return $datos;
    }
}