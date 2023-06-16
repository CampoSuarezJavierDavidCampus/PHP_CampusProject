<?php
namespace Models;
use App\Model;
use Exception;

class CountryModel extends Model{
    protected function GET():string{
        $SQL= "SELECT id_country AS id, name_country AS name FROM countries";
        if(!empty($this->obj->id)){
            $SQL.= " WHERE id_country = :id";
        }
        return $SQL;
    }
    protected function POST():string{
        if(!empty($this->obj->id))throw new Exception('ERROR: PAIS NO AGREGADO');        
        return "INSERT INTO countries (name_country) VALUES (:name_country)";

    }
    protected function DELETE():string{
        if(empty($this->obj->id))throw new Exception('ERROR: PAIS NO ENCONTRADO');
        return "DELETE FROM countries WHERE id_country = :id";
    }
    
    protected function UPDATE():string|array{
        if(empty($this->obj->id))throw new Exception('ERROR: PAIS NO ENCONTRADO');        
        if(!empty($_POST)){                   
            return "UPDATE countries SET 
            name_country = :name_country
            WHERE id_country = :id";
        }
        return $this->GET();
    }
}