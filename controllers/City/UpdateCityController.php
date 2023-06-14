<?php
namespace Controllers\City;
use Models\CityModel;
use Views\CityView;
class UpdateCityController extends CityModel{
    public function __construct(
        int $id
    ){
        if(empty($id) ||
            (!empty($_POST) &&
            (!isset($_POST['nombre']) ||
            !isset($_POST['region']) ||
            empty(trim($_POST['nombre'])) ||
            empty((int) $_POST['region'])))
        )echo $this->redirect_to_city('INVALID PARAMETERS');
        $this->id_city = $id;

        if(!empty($_POST)){
            $name = filter_input(INPUT_POST,'nombre',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $name = strtolower(trim($name));
            $id = filter_input(INPUT_POST,'region',FILTER_SANITIZE_NUMBER_INT);                
            $this->id_region = $id;
            $this->name_city = $name;
        }
    }
    public function render(\PDO $conn):string{
        $response = $this->execute($conn);   
        if(empty($response['contents']['data'])){
            if($response['contents']['status']==='error')return $this->redirect_to_city('ERROR: NO SE HA ACTUALIZADO NINGUNA CIUDAD');
            return $this->redirect_to_city('SE HA ACTUALIZADO UNA CIUDAD');
        }

        if(
            $response['contents']['status']==='error'||
            $response['regions']['status']==='error'
        )return $this->redirect_to_city('ERROR: NO SE MODIFICO NINGUN CAMPO');
        $view =  new CityView([
            'contents'=>$response['contents']['data'],
            'regions'=>$response['regions']['data']
        ]);
        return $view->render();
    }
}