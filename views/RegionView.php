<?php
namespace Views;
use App\View;
class RegionView extends View{
    public function __construct(
        array $datos
    ){        
        $this->_title = 'Regiones';
        $this->load_default_components('Region',$datos);
    }    
}