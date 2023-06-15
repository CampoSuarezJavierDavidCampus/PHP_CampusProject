<?php
namespace App\Clases;
use App\ORM;
use Exception;

class Person extends ORM{ 
    protected ?string $firstname_person = null;
    protected ?string $lastname_person = null;
    protected ?string $birthday_person = null;
    protected ?int $id_city = null; 
 
    protected function validate():void{
        if((
            $_SERVER['REQUEST_METHOD']==='POST' ||
            ($_SERVER['REQUEST_METHOD']==='PUT' && !empty($_POST))) && 
            (empty($_POST) ||
            (isset($_POST['documento']) && empty($_POST['documento'])) ||
            !isset($_POST['nombre']) || empty(trim($_POST['nombre'])) ||
            !isset($_POST['apellido']) || empty(trim($_POST['apellido'])) ||
            !isset($_POST['fecha_nacimiento']) || empty(trim($_POST['fecha_nacimiento'])) ||
            !isset($_POST['ciudad']) || empty(trim($_POST['ciudad'])))                                                
        ){
            $date = explode('-',trim($_POST['fecha_nacimiento']));            
            if(count($date)!==3)throw new Exception('ERROR: INVALID DATE');
            list($year,$month,$day) = $date;
            if(!checkdate($month,$day,$year))throw new Exception('ERROR: INVALID DATE');
            if(!is_numeric($_POST['ciudad']))throw new Exception('ERROR: INVALID CITY');
            throw new Exception('ERROR: INVALID PARAMETERS');
        }
                   
    }
    protected function set_params():void{
        if(isset($_POST['documento'])){            
            $id = $_POST['documento'];
            $this->set_id($id);
        }
        $this->firstname_person = $_POST['nombre'];
        $this->lastname_person = $_POST['apellido'];
        $this->birthday_person = $_POST['fecha_nacimiento'];
        $this->id_city =  filter_input(INPUT_POST,'ciudad',FILTER_SANITIZE_NUMBER_INT);
    }
    public function get_params():array{
        $datos = [];
        if(!empty($this->id))$datos['id']=$this->id;
        if(!empty($this->firstname_person))$datos['firstname_person']=$this->firstname_person;
        if(!empty($this->lastname_person))$datos['lastname_person']=$this->lastname_person;
        if(!empty($this->birthday_person))$datos['birthday_person']=$this->birthday_person;
        if(!empty($this->id_city))$datos['id_city']=$this->id_city;
        if(!empty($this->current_id))$datos['current_id']=$this->current_id;           
        return $datos;
    }
}