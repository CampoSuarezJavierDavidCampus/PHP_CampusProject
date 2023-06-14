<?php
namespace Controllers\City;
use Models\CityModel;
use Views\CityView;
class GetCityController extends CityModel{
    public function __construct(
        int $id
    )
    {
        if($id)$this->id_city = $id;
    }
    public function render($conn){        
        $response = $this->execute($conn);
        $view = new CityView([
            "contents"=>$response['contents']['data'],
            "regions"=>$response['regions']['data'],
        ]);        
        return $view->render();
    }
}