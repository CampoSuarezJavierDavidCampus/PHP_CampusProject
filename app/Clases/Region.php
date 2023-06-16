<?php
namespace App\Clases;
use App\ORM;
use Exception;

class Region extends ORM{ 
    protected ?string $name_region  = null;  
    protected ?int $id_country  = null;
    protected function validate():void{        
        if((
            $_SERVER['REQUEST_METHOD']==='POST' ||
            ($_SERVER['REQUEST_METHOD']==='PUT' && !empty($_POST))) && 
            (empty($_POST) ||            
            !isset($this->name_region) || empty(trim($this->name_region)) ||
            !isset($this->id_country) || empty(trim($this->id_country)))                                                
        ){            
            if(!is_numeric($this->id_country))throw new Exception('ERROR: INVALID COUNTRY');
            throw new Exception('ERROR: INVALID PARAMETERS');
        }
        if(
            (!empty($this->id) && $_SERVER['REQUEST_METHOD']==='GET' && !is_numeric($this->id)) ||
            ($_SERVER['REQUEST_METHOD']!='GET' && $_SERVER['REQUEST_METHOD']!='POST' && !is_numeric($this->id))
        )throw new Exception('ERROR: INVALID PARAMETERS');           
    }
    protected function set_params():void{
        $this->name_region =filter_input(INPUT_POST,'nombre',FILTER_SANITIZE_FULL_SPECIAL_CHARS);        
        $this->id_country =filter_input(INPUT_POST,'pais',FILTER_SANITIZE_FULL_SPECIAL_CHARS);        
    }
    public function get_params():array{
        $this->validate();
        $datos = [];
        if(!empty($this->id))$datos['id']=$this->id;
        if(!empty($this->name_region))$datos['name_region']=$this->name_region;        
        if(!empty($this->id_country))$datos['id_country']=$this->id_country;        
        return $datos;
    }
}