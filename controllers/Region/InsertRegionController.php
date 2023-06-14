<?php
namespace Controllers\Region;
use Exception;
use Models\RegionModel;
class InsertRegionController extends RegionModel{    
    public function __construct(      
    ){                
        if(empty($_POST) || !isset($_POST['nombre']) || !isset($_POST['pais']))throw new Exception('ERROR: INVALID VALUES');                
        $_POST['nombre'] =strip_tags(trim(strtolower($_POST['nombre'])));
        $name = filter_input(INPUT_POST,'nombre',FILTER_SANITIZE_SPECIAL_CHARS);                
        $id = filter_input(INPUT_POST,'pais',FILTER_VALIDATE_INT);
        if($id === 0 || empty($name))throw new Exception('ERROR: INVALID VALUES');
        $this->id_country = $id;
        $this->name_region = strtolower($name);
    }                
    public function render(\PDO $conn):string{
        try {
            $response = $this->prepare($conn)->execute();        
            if($response['status'] === 'error')throw new Exception('ERROR: '.$response['message']);
            return $this->redirect_to_regions('UNA NUEVA REGION SE AGREGO CORRECTAMENTE');
        } catch (\Throwable $th) {            
            return $this->redirect_to_regions('ERROR: '.$th->getMessage());
        }
    }
}