<?php
namespace App;
abstract class ORM{
    public string|int $id = null;
    public string|int $current_id = null;
    protected function set_id(string|int $id,string|int $current_id = null):void{
        $id = strip_tags($id);
        $this->id = $id;
        if(!empty($this->id) && isset($current_id)){            
            $this->current_id = $id;
        }else{
            $this->id = $id;
        }
    }
    abstract protected function get_params():array;
    abstract protected function set_params():void;
    abstract protected function validate():array;
    public function __set(string $name, string $value):void{
        if($name=='get_params')throw new \Exception('ERROR:ACCESS DENIED');
        $value = filter_var($value,FILTER_SANITIZE_SPECIAL_CHARS);
        $this->{$name} = strtolower(trim($value));
    }
}

