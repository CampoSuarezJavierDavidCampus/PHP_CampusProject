<?php
namespace Views;
use Views\BaseTemplate;
class PersonView extends BaseTemplate{
    private string $content;
    private string $form;
    public function __construct(
        array $datos
    ){        
                               
        try {
            if(!isset($datos['contents']) ||
            !isset($datos['cities'])
            )
                throw new \Exception('ERROR: UNDEFINED VIEW');
            $is_method_put = $_SERVER['REQUEST_METHOD']=='PUT';
            $file = $is_method_put?'UpdateForm.php':'Table.php';
            $contents =$is_method_put?$datos:$datos['contents'];
            $this->content = $this->get_php_template("Components/Person/$file", $contents);
            $this->form = $this->get_php_template('Components/Person/Form.php',$datos['cities']);
        } catch (\Throwable $e) {
            echo $e->getMessage();
            echo 'ERROR: 500';
        }
    }
    public function render():string{
        $template = $this->get_base_template('Personas',$this->content,$this->form);
        return $template;
    }
}