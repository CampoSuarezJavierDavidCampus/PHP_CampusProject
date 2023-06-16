<?php
namespace Controllers;
use App\Controller;
use App\Clases\Region;
use Views\RegionView;
class RegionController extends Controller{
    public function __construct(
        string|int $id
    ){        
        $this->_name = 'Region';         
        $this->set_obj(new Region($id));       
    }           
    
    protected function view(array $res):string{
        
        $template = new RegionView([
            'contents'=>$res['contents']['data'],
            'form'=>$res['countries']['data']
        ]);
        return $template->render();
    }
}