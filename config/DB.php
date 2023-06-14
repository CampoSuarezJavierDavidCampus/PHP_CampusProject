<?php
namespace Config;
class DB{
    public function __construct(
        private string $driver,
        private string $host,        
        private string $user,
        private string $password,
        private string $database,
        private array $flags
    )
    {
        $this->flags += [
            \PDO::ATTR_PERSISTENT => false,
            \PDO::ATTR_ERRMODE=>\PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_EMULATE_PREPARES=>true,
            \PDO::ATTR_DEFAULT_FETCH_MODE=>\PDO::FETCH_OBJ            
        ];
    }
    private function dsn():array{        
        return ["$this->driver:host=$this->host;dbname=$this->database",$this->user,$this->password,$this->flags];
    }
    public function get_conn():?\PDO{
        try {            
            return new \PDO(...$this->dsn()); 
        } catch (\PDOException $e) {            
            throw new \Exception('ERROR:connection failed: '.$e->getMessage());            
        }                    
    }
}