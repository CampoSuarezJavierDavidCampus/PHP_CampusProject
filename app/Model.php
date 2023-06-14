<?php
namespace App;
use App\ORM;
abstract class Model{    
    protected array $stmt = [];
    protected $obj;

    protected function set_obj($obj){
        if(!$obj instanceof ORM)throw new \Exception('ERROR:UNDEFINED PARAMETERS');
        $this->obj = $obj;        
    }
    abstract protected function GET():string|array;
    abstract protected function POST():string|array;
    abstract protected function DELETE():string|array;
    abstract protected function UPDATE():string|array;
    public function __construct($obj, \PDO $conn , &$response){
        $this->set_obj($obj);        
        $response =$this->execute($conn);
    }
    protected function fetchAll(string $name, bool $params){           
        if(!array_key_exists($name,$this->stmt))throw new \Exception('ERROR: UNDEFINED RESPONSE');
        $status = $this->stmt[$name]->execute($params?$this->obj->get_params():[]);
        $datos = $this->stmt[$name]->fetchAll();
        $res =  [
            'status' => $status,
            'data' => $datos
        ];
        $this->stmt[$name] = null;
        return $res;
    }
    protected function get_sql():array{
        $SQL = match($_SERVER['REQUEST_METHOD']){
            'GET'=>$this->GET(),
            'POST'=>$this->POST(),
            'DELETE'=>$this->DELETE(),
            'PUT'=>$this->UPDATE(),
            default => throw new \Exception('ERROR: NOT FOUND 404')
        };        
        if(!is_array($SQL))$SQL = ['contents'=>$SQL];

        return $SQL;
    }
    protected function prepare(\PDO $conn):void{        
        $SQLs = $this->get_sql();
        if(empty($SQLs))throw new \Exception('ERROR: INVALID REQUEST');
        foreach($SQLs as $name => $SQL)        
            $this->set_stmt($name,$conn->prepare($SQL));        
        $conn = null;
    }

    protected function set_stmt(string $name, \PDOStatement $stmt):void{                   
        $this->stmt[$name]=$stmt;
    }
    
    protected function execute(\PDO $conn):array{                
        try {     
            try {                
                $this->prepare($conn);
                $res = [];                            
                foreach (array_keys($this->stmt) as $i => $name ) {    
                    /* !DESPUES DE LA PRIMERA SQL LAS DEMAS VAN SIN PARAMETROS */               
                    $params = $i>=1?false:true;            
                    $res[$name] = $this->fetchAll($name, $params);
                }                       

                if(empty($res))throw new \Exception('ERROR:UNDEFINED RESPONSE');
                return $res;  
            } catch (\PDOException $e) {                                
                throw new \Exception($e->getMessage());
            }
                  
        } catch (\Throwable $e) {
            return ['Error'=>[
                'status' => 'error',
                'message' => $e->getMessage()
            ]];
        }
    }      
}