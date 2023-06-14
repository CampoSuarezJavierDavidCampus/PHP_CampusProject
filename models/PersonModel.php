<?php
namespace Models;

use Exception;

class PersonModel{
    protected ?string $id_person = null;
    protected ?string $firstname_person = null;
    protected ?string $lastname_person = null;
    protected ?string $birthday_person = null;
    protected ?int $id_city = null;
    private ?string $id_person_current = null;
    private array $stmt = [];

    private function GET():array{
        $SQL['contents']= "SELECT p.id_person AS id,p.firstname_person AS firstname, p.lastname_person AS lastname, CONCAT(p.firstname_person, ' ' ,p.lastname_person) as name, p.birthday_person AS birthday, p.id_city AS id_city, CONCAT(c.name_city,' - ',r.name_region,' ',ctr.name_country) AS city  FROM persons AS p INNER JOIN cities AS c ON p.id_city = c.id_city INNER JOIN regions AS r ON c.id_region = r.id_region INNER JOIN countries AS ctr ON r.id_country = ctr.id_country ";
        if(!empty($this->id_person)){
            $SQL['contents'].= " WHERE p.id_person = :id_person";
        }
        $SQL['cities']="SELECT c.id_city AS id, c.name_city AS name, c.id_region AS id_region, name_region AS region FROM cities AS c INNER JOIN regions AS r ON c.id_region = r.id_region";
        return $SQL;
    }
    private function POST(){
        if(!empty($id_person))throw new Exception('PERSON NOT FOUND');
        return "INSERT INTO persons (id_person, firstname_person, lastname_person, birthday_person, id_city) VALUES (:id_person, :firstname_person, :lastname_person, :birthday_person, :id_city)";
    }
    private function DELETE(){
        if(empty($this->id_person))throw new Exception('PERSON NOT FOUND');
        return "DELETE FROM persons WHERE id_person = :id_person";
    }
    
    private function UPDATE(){        
        if(empty($this->id_person))throw new Exception('PERSON NOT FOUND');
        if(!empty($this->firstname_person)){
            return "UPDATE persons SET 
            id_person = :id_person_current,
            firstname_person = :firstname_person,
            lastname_person = :lastname_person,
            birthday_person = :birthday_person,
            id_city = :id_city 
            WHERE id_person = :id_person";
        }
        return $this->GET();
    }

    private function get_sql(){
        return match($_SERVER['REQUEST_METHOD']){
            'GET'=>$this->GET(),
            'POST'=>$this->POST(),
            'DELETE'=>$this->DELETE(),
            'PUT'=>$this->UPDATE(),
            default => throw new \Exception('ERROR: NOT FOUND 404')
        };
    }
    private function get_params(){
        $datos = [];
        if(!empty($this->id_person))$datos['id_person']=$this->id_person;
        if(!empty($this->firstname_person))$datos['firstname_person']=$this->firstname_person;
        if(!empty($this->lastname_person))$datos['lastname_person']=$this->lastname_person;
        if(!empty($this->birthday_person))$datos['birthday_person']=$this->birthday_person;
        if(!empty($this->id_city))$datos['id_city']=$this->id_city;
        if(!empty($this->id_person_current))$datos['id_person_current']=$this->id_person_current;        
        return $datos;
    }
    protected function set_id($id){
        $id = strip_tags($id);
        $id_person = filter_var($id,FILTER_SANITIZE_SPECIAL_CHARS);
        $id_person = strtoupper(trim($id_person));        
        if(!empty($this->id_person) && isset($_POST['documento'])){            
            $this->id_person_current = $id;
        }else{
            $this->id_person = $id_person;

        }
    }
    private function validate(){
        if( empty($_POST) ||
            (isset($_POST['documento']) && empty($_POST['documento'])) ||
            !isset($_POST['nombre']) || empty(trim($_POST['nombre'])) ||
            !isset($_POST['apellido']) || empty(trim($_POST['apellido'])) ||
            !isset($_POST['fecha_nacimiento']) || empty(trim($_POST['fecha_nacimiento'])) ||
            !isset($_POST['ciudad']) || empty(trim($_POST['ciudad']))                                                
        ){
            $date = explode('-',trim($_POST['fecha_nacimiento']));
            if(count($date)!==3)throw new \Exception('ERROR: INVALID DATE');
            list($year,$month,$day) = $date;
            if(!checkdate($month,$day,$year))throw new \Exception('ERROR: INVALID DATE');
            if(!is_numeric($_POST['ciudad']))throw new \Exception('ERROR: INVALID CITY');
            throw new \Exception('ERROR: INVALID PARAMETERS');
        }
        if(isset($_POST['documento'])){            
            $id = filter_input(INPUT_POST,'documento',FILTER_SANITIZE_SPECIAL_CHARS);
            $this->set_id($id);
        }
        $firstname_person = filter_input(INPUT_POST,'nombre',FILTER_SANITIZE_SPECIAL_CHARS);        
        $firstname_person = strtolower(trim($firstname_person));        
        $lastname_person = filter_input(INPUT_POST,'apellido',FILTER_SANITIZE_SPECIAL_CHARS);
        $lastname_person = strtolower(trim($lastname_person));
        $birthday_person = filter_input(INPUT_POST,'fecha_nacimiento',FILTER_SANITIZE_SPECIAL_CHARS);
        $birthday_person = strtolower(trim($birthday_person));
        $id_city = filter_input(INPUT_POST,'ciudad',FILTER_SANITIZE_NUMBER_INT);        
        return [$firstname_person,$lastname_person,$birthday_person,$id_city];        
    }
    protected function set_parameters(){
        list($firstname_person,
        $lastname_person,
        $birthday_person,
        $id_city) = $this->validate();
        $this->firstname_person = $firstname_person;
        $this->lastname_person = $lastname_person;
        $this->birthday_person = $birthday_person;
        $this->id_city = $id_city;        
    }
    private function prepare(\PDO $conn){
        $SQL = $this->get_sql();                        
        if(!is_array($SQL))$SQL = ['contents'=>$SQL];           
        $this->stmt['contents'] = $conn->prepare($SQL['contents']);

        if(isset($SQL['cities']))
            $this->stmt['cities'] = $conn->prepare($SQL['cities']);                    
    }
    private function get_stmt(string $query,bool $params = true):?array{
        if(!isset($this->stmt[$query]))return null;
        try {                               
            $status = $this->stmt[$query]->execute($params?$this->get_params():[]);
            $datos = $this->stmt[$query]->fetchAll();
            return [
                'status'=>$status,
                'data'=>$datos
            ];
        } catch (\PDOException $e) {            
            return $this->set_error($e->getMessage());
        }        
    }
    private function set_error($message){
        return [
            ['status'=>'error',
            'message'=>$message]
        ];
    }
    protected function execute(\PDO $conn){
        $res =[];
        try {            
            $this->prepare($conn);
            $res['contents']= $this->get_stmt('contents');
            $cities =$this->get_stmt('cities',false);
            if($cities)$res['cities']=$cities;
            return $res;
        } catch (\Throwable $e) {            
            return $this->set_error($e->getMessage());            
        }
                
    }
    protected function redirect_to_persons($message){
        return <<<HTML
            <script>
                let host = location.origin;
                alert("$message");
                location.replace(host + '/persons');                                
            </script>
        HTML;
    }
}