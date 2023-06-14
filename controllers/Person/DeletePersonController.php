<?php
namespace Controllers\Person;
use Models\PersonModel;
class DeletePersonController extends PersonModel{
    public function __construct(
        string $id
    )
    {
        $this->set_id($id);
    }
    public function render(\PDO $conn){
        $res = $this->execute($conn);
        echo var_dump($res);
        if($res['content'][0]['errors']==='error')return $this->redirect_to_persons('ERROR: NO SE ENCONTRO EL PERSONA');
        return $this->redirect_to_persons('SE ELIMINO UNA PERSONA');
    }
}