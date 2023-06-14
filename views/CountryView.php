<?php 
namespace Views;
use Views\BaseTemplate;
class CountryView extends BaseTemplate{
    private ?string $form= null;
    private string $content;
    public function __construct(
        $result        
    )
    {        
        if(
            $_SERVER['REQUEST_METHOD'] !== 'GET' &&
            $_SERVER['REQUEST_METHOD'] !== 'PUT'
        )throw new \Exception('INVALID REQUEST');
        $this->form = $this->get_php_template('Components/Country/Form.php',null);
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            $this->content = $this->get_php_template('Components/Country/Table.php',$result);
        }else{
            $this->content = $this->get_php_template('Components/Country/UpdateForm.php',$result);
        }        
    }
    public function render(){        
        $response = $this->get_base_template('Paises',$this->content,$this->form);
        return $response;         
    }
    
}