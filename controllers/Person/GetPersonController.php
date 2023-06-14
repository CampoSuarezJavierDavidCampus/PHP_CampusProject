<?php
namespace Controllers\Person;
use Models\PersonModel;
use Views\PersonView;
class GetPersonController extends PersonModel{
    public function __construct(
        string $id
    ){
        if(!empty($id))$this->id_person = $id;
    }
    public function render(\PDO $conn):string{
        $res = $this->execute($conn);                
        if($res['contents']['status'] === 'error' ||
        (isset($res['cities'])&&
        $res['cities']['status'] === 'error'        
        ))throw new \Exception('ERROR: ERROR 500');
        $template = new PersonView([
            'contents' => $res['contents']['data'],
            'cities' => $res['cities']['data']
        ]);
        return $template->render();
    }
}