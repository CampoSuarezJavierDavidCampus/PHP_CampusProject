<?php
namespace Models;
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
    abstract public function __construct($obj, \PDO $conn, &$response);
    protected function fetchAll(string $stmt, bool $params){        
        if(!array_key_exists($stmt,$this->stmt))throw new \Exception('ERROR: UNDEFINED RESPONSE');
        $status = $this->stmt[$stmt]->execute($params?$this->obj->get_params():[]);
        $datos = $this->stmt[$stmt]->fetchAll();
        $res[$stmt] =  [
            'status' => $status,
            'data' => $datos
        ];
        $this->stmt[$stmt] = null;
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
        $this->$stmt[$name]=$stmt;
    }
    
    protected function execute(\PDO $conn):array{        
        try {     
            $this->prepare($conn);
            $res = [];
            foreach (array_keys($this->stmt) as $i => $stmt ) {
                $params = $i>=1?false:true;
                $res[$stmt] = $this->fetchAll($stmt, $params);
            }       
            if(empty($res))throw new \Exception('ERROR:UNDEFINED RESPONSE');
            return $res;            
        } catch (\Throwable $e) {
            return ['Error'=>[
                'status' => 'error',
                'message' => $e->getMessage()
            ]];
        }
    }

    protected function redirect(string $path, string $message):string{
        return <<<HTML
            <script>
                let host = location.origin;
                alert("$message");
                location.replace(host + '/$path');                                
            </script>
        HTML;
    }    
}