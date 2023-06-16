<?php
namespace Models;
use App\Model;
use Exception;

class CityModel extends Model{
    protected function GET():array{
        $SQL['contents']= "SELECT cty.id_city AS id, cty.name_city AS name, cty.id_region AS id_region, CONCAT(r.name_region,' - ',c.name_country) AS ubicacion FROM cities as cty INNER JOIN regions AS r ON r.id_region = cty.id_region INNER JOIN countries As c ON c.id_country = r.id_country";
        if(!empty($this->obj->id)){
            $SQL['contents'].= " WHERE cty.id_city = :id";
        }
        $SQL['regions']="SELECT id_region AS id, name_region AS name FROM regions";        
        return $SQL;
    }
    protected function POST():string{
        if(!empty($this->obj->id))throw new Exception('ERROR: NO SE AGREGO NINGUNA CIUDAD');        
        return "INSERT INTO cities (name_city, id_region) VALUES (:name_city, :id_region)";

    }
    protected function DELETE():string{
        if(empty($this->obj->id))throw new Exception('ERROR: CIUDAD NO ENCONTRADA');
        return "DELETE FROM cities WHERE id_city = :id";
    }
    
    protected function UPDATE():string|array{
        if(empty($this->obj->id))throw new Exception('ERROR: CIUDAD NO ENCONTRADA NO SE ALTERO NINGUN REGISTRO');        
        if(!empty($_POST)){                   
            return "UPDATE cities SET 
            name_city = :name_city,
            id_region = :id_region
            WHERE id_city = :id";
        }
        return $this->GET();
    }
}