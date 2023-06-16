<?php
namespace App\Clases;
use App\ORM;
use Exception;

class City extends ORM{ 
    protected ?string $name_city   = null;  
    protected ?int $id_region  = null;
    protected function validate():void{        
        if((
            $_SERVER['REQUEST_METHOD']==='POST' ||
            ($_SERVER['REQUEST_METHOD']==='PUT' && !empty($_POST))) && 
            (empty($_POST) ||            
            !isset($this->name_city) || empty(trim($this->name_city)) ||
            !isset($this->id_region) || empty(trim($this->id_region)))                                                
        ){            
            if(!is_numeric($this->id_region))throw new Exception('ERROR: INVALID CITY');
            throw new Exception('ERROR: INVALID PARAMETERS');
        }
        if(
            (!empty($this->id) && $_SERVER['REQUEST_METHOD']==='GET' && !is_numeric($this->id)) ||
            ($_SERVER['REQUEST_METHOD']!='GET' && $_SERVER['REQUEST_METHOD']!='POST' && !is_numeric($this->id))
        )throw new Exception('ERROR: INVALID PARAMETERS');           
    }
    protected function set_params():void{
        $this->name_city =filter_input(INPUT_POST,'nombre',FILTER_SANITIZE_FULL_SPECIAL_CHARS);        
        $this->id_region =filter_input(INPUT_POST,'region',FILTER_SANITIZE_FULL_SPECIAL_CHARS);        
    }
    public function get_params():array{
        $this->validate();
        $datos = [];
        if(!empty($this->id))$datos['id']=$this->id;
        if(!empty($this->name_city))$datos['name_city']=$this->name_city;        
        if(!empty($this->id_region))$datos['id_region']=$this->id_region;        
        return $datos;
    }
}