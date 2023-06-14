<?php
namespace Controllers\City;
use Models\CityModel;
class DeleteCityController extends CityModel{
    public function __construct(int $id){
        if(empty($id))echo $this->redirect_to_city('INVALID PARAMETERS');
        $this->id_city = $id;
    }
    public function render(\PDO $conn):string{
        $response = $this->execute($conn);;
        if($response['status'] === 'error')return $this->redirect_to_city('ERROR: NO SE ELIMINO NINGUN REGISTRO');
        return $this->redirect_to_city('SE HA ELIMINADO UN ELEMENTO');        
    }
}