<?php
namespace Models;
use App\Model;
use Exception;

class RegionModel extends Model{
    protected function GET():array{
        $SQL['contents']= "SELECT r.id_region AS id, r.name_region AS name, r.id_country AS id_country, c.name_country AS country  FROM regions AS r INNER JOIN countries AS c ON c.id_country = r.id_country";
        if(!empty($this->obj->id)){
            $SQL['contents'].= " WHERE r.id_region = :id";
        }
        $SQL['countries']="SELECT id_country AS id, name_country AS name FROM countries";
        return $SQL;
    }
    protected function POST():string{
        if(!empty($this->obj->id))throw new Exception('ERROR: NO SE AGREGO NINGUNA REGION');        
        return "INSERT INTO regions (name_region, id_country) VALUES (:name_region, :id_country)";

    }
    protected function DELETE():string{
        if(empty($this->obj->id))throw new Exception('ERROR: REGION NO ENCONTRADA');
        return "DELETE FROM regions WHERE id_region = :id";
    }
    
    protected function UPDATE():string|array{
        if(empty($this->obj->id))throw new Exception('ERROR: REGION NO ENCONTRADA NO SE ALTERO NINGUN REGISTRO');        
        if(!empty($_POST)){                   
            return "UPDATE regions SET 
            name_region = :name_region,
            id_country = :id_country
            WHERE id_region = :id";
        }
        return $this->GET();
    }
}
