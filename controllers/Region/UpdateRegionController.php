<?php
namespace Controllers\Region;
use Models\RegionModel;
use Views\RegionView;
class UpdateRegionController extends RegionModel{
    public function __construct(
        int $id
    )
    {        
        if(empty($id) ||
        (!empty($_POST) &&
            (!isset($_POST['nombre']) ||
            !isset($_POST['pais']) || 
            empty($_POST['nombre']) ||
            empty($_POST['pais'])))            
        )throw new \Exception('ERROR: PARAMETERS INVALID');
        if(empty($id))throw new \Exception('ERROR INVALID PARAMETER');
        $this->id_region = $id;        
        if(!empty($_POST)){
            $name = filter_input(INPUT_POST,'nombre',FILTER_SANITIZE_SPECIAL_CHARS);
            $name = strtolower(trim($name));
            $id = filter_input(INPUT_POST,'pais',FILTER_VALIDATE_INT);
            $this->id_country = $id;
            $this->name_region = $name;
        }        
    }
    public function render(\PDO $conn):string{
        $response = $this->prepare($conn)->execute();
        if(!isset($response['countries']))return $this->redirect_to_regions('UNA REGION A SIDO ALTERADA');
        $view = new RegionView([
            'contents'=>$response['contents']['data'],
            'countries'=>$response['countries']['data']
        ]);
        return $view->render();        
    }
}