<?php
namespace Controllers\Person;
use Models\PersonModel;
use Views\PersonView;
class UpdatePersonController extends PersonModel{
    public function __construct(string $id)
    {        
        $this->set_id($id);
        if(!empty($_POST))$this->set_parameters();
    }
    public function render(\PDO $conn):string{        
        $res = $this->execute($conn);                
        if($res['contents']['status']==='error')return $this->redirect_to_persons('ERROR: SE MODIFICO NINGUN CAMPO');        
        if(empty($res['contents']['data']))return $this->redirect_to_persons('SE HA REALIZADO UN CAMBIO CON EXITO');
        $view = new PersonView([
            'contents'=>$res['contents']['data'],
            'cities'=>$res['cities']['data']
        ]);
        return $view->render();
    }
}