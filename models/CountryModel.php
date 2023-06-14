<?php
namespace Models;

use Exception;

class CountryModel{
    protected int $id_country = 0;
    protected ?string $name_country = null;
    private $stmt ;
    
    private function GET(){
        $SQL = "SELECT id_country, name_country FROM countries ";
        if($this->id_country!==0){
            $SQL .= " WHERE id_country=:id_country";
        }
        return $SQL;
    }
    
    private function POST(){
        $SQL = "INSERT INTO countries (name_country) VALUES (:name_country)";
        return $SQL;
    }

    private function DELETE(){
        $SQL = "DELETE FROM countries WHERE id_country = :id_country";
        return $SQL;
    }

    private function UPDATE(){        
        if($this->id_country == 0) throw new Exception('ERROR: INVALID PARAMETER');
        if($this->name_country == null)return $this->GET();        
        $SQL = "UPDATE countries SET name_country = :name_country WHERE id_country = :id_country";        
        return $SQL;
    }
    private function get_sql(){
        $method = $_SERVER['REQUEST_METHOD'];
        return match($method){
            'GET'=>$this->GET(),
            'POST'=>$this->POST(),
            'DELETE'=>$this->DELETE(),
            'PUT'=>$this->UPDATE(),
            default=>throw new \Exception('INVALID REQUEST_METHOD')
        };
    }

    private function get_params():?array{
        $datos = [];
        if($this->id_country!==0){
            $id = filter_var($this->id_country,FILTER_VALIDATE_INT);            
            $datos['id_country'] = $id;
        }        
        if($this->name_country!==null){            
            $name = strip_tags($this->name_country);
            $name = filter_var($name,FILTER_SANITIZE_SPECIAL_CHARS);            
            $name = trim($name,'/\s/');
            $datos['name_country']= strtolower($name);
        }                
        if(empty($datos))return null;
        return $datos;
    }
    
    protected function prepare(\PDO $conn){
        $SQL = $this->get_sql();                
        $this->stmt = $conn->prepare($SQL);
        return $this;
    }    
    protected function execute():array{        
        try {
            $status = $this->stmt->execute($this->get_params());
            $datos = $this->stmt->fetchAll();
            
            return [
                'status'=>$status,
                'data'=>$datos
            ];
        } catch (\PDOException $e) {
            return [
                'status'=>'error',
                'data'=>$e->getMessage()
            ];
        }
    }
    protected function redirect_to_country($message){
        return <<<HTML
            <script>
                let host = location.origin;
                alert("$message");
                location.replace(host + '/countries');                                
            </script>
        HTML;
    }
}