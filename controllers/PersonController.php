<?php
namespace Controllers;
use App\Controller;
use App\Clases\Person;
use Views\PersonView;
class PersonController extends Controller{
    public function __construct(
        string|int $id
    ){
        $this->_name = 'Person';         
        $this->set_obj(new Person($id));       
    }           
    
    protected function view(array $res):string{
        
        $template = new PersonView([
            'contents'=>$res['contents']['data'],
            'form'=>$res['cities']['data']
        ]);
        return $template->render();
    }
}