<?php
namespace Controllers\Person;
use Models\PersonModel;
class InsertPersonController extends PersonModel{
    public function __construct(){        
        $this->set_parameters();        
    }
    public function render(\PDO $conn):string{        
        $res = $this->execute($conn);                
        if($res['contents']['status'] === 'error')return $this->redirect_to_persons('ERROR: NO SE INSERTO NINGUN ELEMENTO');        
        return  $this->redirect_to_persons('UNA PERSONA HA SIDO AGREGADA');
    }
}