<?php
namespace App;
use App\ORM;
use Helpers\Models;
abstract class Controller{    
    protected int|string $id;
    protected string $_name;
    protected $obj;
    abstract public function __construct(string|int $id);
    abstract protected function view(array $res):string;
    public function render($conn){             
        $res = (new Models($conn,$this->obj))->get_model($this->_name);
        if($_SERVER['REQUEST_METHOD']!='GET')$this->redirect_to_start($res,true);
        return $this->view($res);        
    }
    public function get_name(){
        return $this->_name;
    }
    protected function set_obj($obj){
        if(!$obj instanceof ORM)throw new \Exception('INVALID OBJECT');
        $this->obj = $obj;
    }
    private function redirect_to_start($res){
        $method = $_SERVER['REQUEST_METHOD'];               
        if(isset($res['Error']))$this->redirect('ERROR:NO SE REGISTRARON CAMBIOS');
        if($method !== 'PUT'||($method === 'PUT' && !empty($_POST)))$this->redirect('SE ALTERO UN ELEMENTO');
    }
    private function redirect(string $message, bool $status = false):void{
        $path = strtolower($this->_name);        
        $message = ($status)?'alert("$message")':'';
        echo <<<HTML
            <script>
                let host = location.origin;
                $message
                location.replace(host + '/$path');                                
            </script>
        HTML;
    }  

}