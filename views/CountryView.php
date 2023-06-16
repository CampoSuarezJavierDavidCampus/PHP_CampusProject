<?php
namespace Views;
use App\View;
class CountryView extends View{
    public function __construct(
        array $datos
    ){        
        $this->_title = 'Paises';
        $this->load_default_components('Country',$datos);
    }    
}