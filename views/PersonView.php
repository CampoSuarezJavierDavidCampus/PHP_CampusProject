<?php
namespace Views;
use App\View;
class PersonView extends View{
    public function __construct(
        array $datos
    ){        
        $this->_title = 'Personas';
        $this->load_default_components('Person',$datos);
    }    
}