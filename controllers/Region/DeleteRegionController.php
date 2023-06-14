<?php
namespace Controllers\Region;
use Models\RegionModel;
class DeleteRegionController extends RegionModel{
    public function __construct(
        int $id
    )
    {
        if($id === 0)throw new \Exception('ERROR: INVALID PARAMETERS');
        $this->id_region = $id;
    }
    public function render(\PDO $conn){
        $response = $this->prepare($conn)->execute();        
        if($response['status'] === 'error')return $this->redirect_to_regions('ERROR:CONNECTION ERROR');
        return $this->redirect_to_regions('SE HA ELIMINADO CORRECTAMENTE');
    }
}