<?php
namespace Controllers;
use App\Controller;
use App\Clases\Country;
use Views\CountryView;
class CountryController extends Controller{
    public function __construct(
        string|int $id
    ){        
        $this->_name = 'Country';         
        $this->set_obj(new Country($id));       
    }           
    
    protected function view(array $res):string{
        
        $template = new CountryView([
            'contents'=>$res['contents']['data'],
        ]);
        return $template->render();
    }
}