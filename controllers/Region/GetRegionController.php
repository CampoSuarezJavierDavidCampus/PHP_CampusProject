<?php
namespace Controllers\Region;
use Models\RegionModel;
use Views\RegionView;
class GetRegionController extends RegionModel{
    
    public function __construct(
        int $id
    )
    {
        if($id !== 0)$this->id_region = $id;        
    }
    public function render(\PDO $conn):string{
        $response = $this->prepare($conn)->execute();
        $view = new RegionView([
            'contents'=>$response['contents']['data'],
            'countries'=>$response['countries']['data']
        ]);
        return $view->render();
    }
}