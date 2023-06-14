<?php
namespace Views;
use Views\BaseTemplate;
class CityView extends BaseTemplate{
    private string $form;
    private string $content;
    public function __construct(
        $result
    ){
        $is_method_put = $_SERVER['REQUEST_METHOD'] == 'PUT';
        $file = $is_method_put?'UpdateForm.php':'Table.php';
        $this->form = $this->get_php_template('Components/City/Form.php',$result['regions']);
        $this->content = $this->get_php_template('Components/City/'.$file,$is_method_put?$result:$result['contents']);        
    }
    public function render():string{
        $template = $this->get_base_template('Ciudades',$this->content,$this->form);
        return $template;
    }
}