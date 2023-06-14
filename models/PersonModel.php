<?php
namespace Models;
use App\Model;
use Exception;

class PersonModel extends Model{
    protected function GET():array{
        $SQL['contents']= "SELECT p.id_person AS id,p.firstname_person AS firstname, p.lastname_person AS lastname, CONCAT(p.firstname_person, ' ' ,p.lastname_person) as name, p.birthday_person AS birthday, p.id_city AS id_city, CONCAT(c.name_city,' - ',r.name_region,' ',ctr.name_country) AS city  FROM persons AS p INNER JOIN cities AS c ON p.id_city = c.id_city INNER JOIN regions AS r ON c.id_region = r.id_region INNER JOIN countries AS ctr ON r.id_country = ctr.id_country ";
        if(!empty($this->obj->id)){
            $SQL['contents'].= " WHERE p.id_person = :id";
        }
        $SQL['cities']="SELECT c.id_city AS id, c.name_city AS name, c.id_region AS id_region, name_region AS region FROM cities AS c INNER JOIN regions AS r ON c.id_region = r.id_region";
        return $SQL;
    }
    protected function POST():string{
        if(!empty($this->obj->id))throw new Exception('PERSON NOT FOUND');        
        return "INSERT INTO persons (id_person, firstname_person, lastname_person, birthday_person, id_city) VALUES (:current_id, :firstname_person, :lastname_person, :birthday_person, :id_city)";

    }
    protected function DELETE():string{
        if(empty($this->obj->id))throw new Exception('PERSON NOT FOUND');
        return "DELETE FROM persons WHERE id_person = :id";
    }
    
    protected function UPDATE():string|array{
        if(empty($this->obj->id))throw new Exception('PERSON NOT FOUND');        
        if(!empty($_POST)){                   
            return "UPDATE persons SET 
            id_person = :current_id,
            firstname_person = :firstname_person,
            lastname_person = :lastname_person,
            birthday_person = :birthday_person,
            id_city = :id_city 
            WHERE id_person = :id";
        }
        return $this->GET();
    }
}