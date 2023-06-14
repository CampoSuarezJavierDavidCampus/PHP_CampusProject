<?php
namespace Controllers\Country;
use Models\CountryModel;
use Views\CountryView;
class GetCountryController extends CountryModel {
    public function __construct(
        ?int $id
    )
    {
        $this->id_country = $id;
    }

    public function render($conn):string{
        $response  = $this->prepare($conn)->execute();
        $view = new CountryView($response['data']);
        return $view->render();        
    }
}
