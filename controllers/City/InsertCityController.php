<?php
namespace Controllers\City;
use Models\CityModel;
class InsertCityController extends CityModel{
    public function __construct(){
        if(empty($_POST) ||
            !isset($_POST['nombre']) ||
            !isset($_POST['region']) ||
            empty(trim($_POST['nombre'])) ||
            empty($_POST['region'])
        )echo $this->redirect_to_city('INVALID PARAMETERS');
        $name = filter_input(INPUT_POST,'nombre',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $name = strtolower(stripslashes(trim($name)));
        $id = filter_input(INPUT_POST,'region',FILTER_SANITIZE_NUMBER_INT);
        $this->id_region = $id;
        $this->name_city = $name;
    }
    public function render(\PDO $conn){
        $response = $this->execute($conn);
        if($response['status'] == 'error')return $this->redirect_to_city('NO SE LOGRO AGREGAR LA CIUDAD');
        return $this->redirect_to_city('UNA NUEVA CIUDAD HA CIDO AGREGADA');
    }
}