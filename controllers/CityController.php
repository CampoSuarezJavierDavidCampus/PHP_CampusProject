<?php
namespace Controllers;
use App\Controller;
use App\Clases\City;
use Views\CityView;
class CityController extends Controller{
    public function __construct(
        string|int $id
    ){        
        $this->_name = 'City';         
        $this->set_obj(new City($id));       
    }           
    
    protected function view(array $res):string{
        
        $template = new CityView([
            'contents'=>$res['contents']['data'],
            'form'=>$res['regions']['data']
        ]);
        return $template->render();
    }
}