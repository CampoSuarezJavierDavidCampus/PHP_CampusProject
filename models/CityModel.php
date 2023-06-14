<?php
namespace Models;
class CityModel{
    protected int $id_city = 0;
    protected ?string $name_city = null;
    protected ?int $id_region = null;
    private ?array $stmt =[] ;
    private function GET(){
        $SQL = [];
        $SQL['contents'] = "SELECT c.id_city AS id, c.name_city AS city, c.id_region AS id_region, r.name_region AS region, cr.name_country AS country FROM cities AS c INNER JOIN regions AS r ON c.id_region = r.id_region INNER JOIN countries AS cr ON cr.id_country = r.id_country";
        if(!empty($this->id_city)){            
            $SQL['contents'] .= " WHERE c.id_city = :id_city";
        }
        $SQL['regions'] = "SELECT r.id_region AS id, r.name_region AS name, r.id_country AS id_country, c.name_country AS country  FROM regions AS r INNER JOIN countries AS c ON r.id_country = c.id_country";
        return $SQL;
    }
    private function POST(){
        if(empty($this->name_city) || empty($this->id_region))throw new \Exception("ERROR: INVALID PARAMETERS");
        $SQL = "INSERT INTO cities (name_city, id_region) VALUES (:name_city, :id_region)";
        return $SQL;
    }

    private function DELETE(){
        if(empty($this->id_city))throw new \Exception('ERROR PARAMETERS INVALID');
        $SQL = "DELETE FROM cities WHERE id_city = :id_city";
        return $SQL;
    }

    private function UPDATE(){        
        if(!empty($_POST)){                  
            if(empty($this->name_city) || empty($this->id_region))throw new \Exception('ERROR: INVALID PARAMETERS');
            return 'UPDATE cities SET name_city = :name_city, id_region = :id_region WHERE id_city = :id_city ';
        }
        return $this->GET();
    }

    private function get_sql():string|array{
        return match($_SERVER["REQUEST_METHOD"]){
            'GET'=>$this->GET(),
            'POST'=>$this->POST(),
            'DELETE'=>$this->DELETE(),
            'PUT'=>$this->UPDATE(),
            default=>throw new \Exception('ERROR UNDEFINED METHOD')
        };
    }
    
    private function get_params(){
        $datos = [];
        if(!empty($this->id_city))$datos['id_city'] = $this->id_city;
        if(!empty($this->id_region))$datos['id_region'] = $this->id_region;
        if(!empty($this->name_city))$datos['name_city'] = $this->name_city;        
        return $datos;
    }
    private function prepare($conn){        
        $SQL = $this->get_sql();                
        if(!is_array($SQL))$SQL = ['contents' => $SQL];                
        if(isset($SQL['regions']))$this->stmt['regions'] = $conn->prepare($SQL['regions']);
        $this->stmt['contents'] = $conn->prepare($SQL['contents']);
        return $this;
    }
    protected function execute($conn):array{
        try {            
            $this->prepare($conn);
            $status = $this->stmt['contents']->execute($this->get_params());
            $datos = $this->stmt['contents']->fetchAll();
            $res = ["contents"=>[
                    'status' => $status,
                    'data' => $datos
                ]];        
            if(isset($this->stmt['regions'])){                
                $status = $this->stmt['regions']->execute();
                $datos = $this->stmt['regions']->fetchAll();
                $res["regions"]=[
                    'status' => $status,
                    'data' => $datos
                ];
            }
            $this->stmt = null;
            return $res;
        } catch (\PDOException $e) {
            $this->stmt = null;
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }
    protected function redirect_to_city($message){
        return <<<HTML
            <script>
                let host = location.origin;
                alert("$message");
                location.replace(host + '/cities');                                
            </script>
        HTML;
    }
}