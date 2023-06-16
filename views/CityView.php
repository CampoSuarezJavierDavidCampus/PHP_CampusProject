<?php
namespace Views;
use App\View;
class CityView extends View{
    public function __construct(
        array $datos
    ){        
        $this->_title = 'Ciudades';
        $this->load_default_components('City',$datos);
    }    
}