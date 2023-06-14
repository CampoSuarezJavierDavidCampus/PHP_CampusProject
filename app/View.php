<?php 
namespace App;
use App\Clases\Template;
abstract class View extends Template{    
    protected string $_title;
    abstract public function __construct(array $datos);    
    public function render():string{
        $template = $this->get_base_template($this->_title,$this->content,$this->form);        
        return $template;
    }    
}