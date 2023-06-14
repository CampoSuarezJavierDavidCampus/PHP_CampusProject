<?php
namespace Views;
use Views\BaseTemplate;
class RegionView extends BaseTemplate{
    private string $content;
    private ?string $form = null;
    public function __construct(
        array $data
    )
    {           
        $is_method_put  = $_SERVER['REQUEST_METHOD'] == 'PUT';     
        $this->form = $this->get_php_template('Components/Region/Form.php',$data['countries']);
        $file =$is_method_put ?'UpdateForm.php':'Table.php';
        $this->content = $this->get_php_template("Components/Region/$file",$is_method_put?$data:$data['contents']);
        
    }
    public function render():string{
        $template = $this->get_base_template('Regiones',$this->content,$this->form);
        return $template;
    }
}