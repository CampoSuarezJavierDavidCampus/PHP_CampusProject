<?php
namespace Config;
use Config\DB;
use Config\Conf;
use Exception;

class Connection{
    private ?array $dbs;
    public function __construct(){
        Conf::init($this);
    }
    public function set_db(string $name, DB $db){
        $this->dbs[$name] = $db;
    }
    public function db($name):\PDO{
        if(isset($this->dbs[$name])){
            return $this->dbs[$name]->get_conn();
        }
        throw new Exception('ERRROR: DB NOT FOUND');        
    }
}