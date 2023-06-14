<?php
namespace Models;

use Exception;

class RegionModel{
    protected int $id_region = 0;
    protected ?string $name_region = null;    
    protected ?int $id_country = null;
    protected ?array $stmt;
    private function GET(){        
        $SQL =[];
        $SQL['content'] = "SELECT r.id_region AS id, r.name_region AS region, c.name_country AS country, c.id_country AS id_country FROM regions as r INNER JOIN countries as c ON r.id_country = c.id_country ";
        if($this->id_region !== 0){
            $SQL['content'] .= " WHERE r.id_region = :id_region";
        }        
        $SQL['countries'] = "SELECT id_country AS id, name_country AS name FROM countries";
        return $SQL;
    }
    private function POST(){
        if($this->name_region == null || $this->id_country == null)throw new Exception('Error: INVALID PARAMETERS');
        $SQL = "INSERT INTO regions(name_region,id_country) VALUES (:name_region, :id_country)";
        return $SQL;
    }
    private function DELETE(){
        if($this->id_region === 0)throw new Exception('ERROR: INVALID PARAMETERS');
        $SQL = "DELETE FROM regions WHERE id_region = :id_region";
        return $SQL;
    }
    private function UPDATE(){
        if(
            !empty($_POST) &&
            ($this->name_region == null || 
            !$this->id_region ||
            !$this->id_country)
        )throw new Exception('Error: INVALID PARAMETERS');
        if(!empty($_POST)){            
            return  "UPDATE regions SET name_region = :name_region, id_country = :id_country WHERE id_region = :id_region";            
        }
        return  $this->GET();                
    }
    private function get_sql():string | array{
        return match($_SERVER["REQUEST_METHOD"]){
            'GET'=>$this->GET(),
            'POST'=>$this->POST(),
            'DELETE'=>$this->DELETE(),
            'PUT'=>$this->UPDATE(),
            default => throw new Exception('INVALID REQUEST')
        };
    }
    private function get_params():?array{
        $datos = [];
        if($this->id_region!== 0)$datos['id_region'] = $this->id_region;
        if($this->name_region)$datos['name_region'] = $this->name_region;
        if($this->id_country && $this->id_country!== 0)$datos['id_country']= $this->id_country;
        if(empty($datos))return null;       
        return $datos;
    }
    protected function prepare(\PDO $conn){
        $SQL = $this->get_sql();
        if(is_array($SQL) ){            
            $this->stmt['contents'] = $conn->prepare($SQL['content']);
            $this->stmt['countries'] = $conn->prepare($SQL['countries']);
        }else{
            $this->stmt['contents'] = $conn->prepare($SQL);
        }
        return $this;
    }
    
    protected function execute(){
        try {                        
            $status = $this->stmt['contents']->execute($this->get_params());
            $datos = $this->stmt['contents']->fetchAll();
            $res['contents'] =  [
                'status' => $status,
                'data' => $datos
            ];
            if(isset($this->stmt['countries'])){
                $status = $this->stmt['countries']->execute();
                $datos = $this->stmt['countries']->fetchAll();
                $res['countries']=  [
                    "status" => $status,
                    "data" => $datos
                ];
            }
            $this->stmt = null;
            return $res;            
        } catch (\PDOException $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
    protected function redirect_to_regions($message){
        return <<<HTML
            <script>
                let host = location.origin;
                alert("$message");
                location.replace(host + '/regions');                                
            </script>
        HTML;
    }
}