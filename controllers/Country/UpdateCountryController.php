<?php
namespace Controllers\Country;
use Models\CountryModel;
use Views\CountryView;
class UpdateCountryController extends CountryModel{
    public function __construct(
        int $id
    )
    {    
        if($id === 0)echo $this->redirect_to_country("ERROR PAIS NO ENCONTRADO");
        if(!empty($_POST) && isset($_POST['nombre'])){
            $name = $_POST['nombre'];
            $name = strtolower(trim(strip_tags($name)));
            if($name == "")echo $this->redirect_to_country('ERROR PAIS NO ACTUALIZADO');
            $name = filter_var($name, FILTER_SANITIZE_SPECIAL_CHARS);
            $this->name_country = $name;
        }
        $this->id_country = filter_var($id,FILTER_VALIDATE_INT);
    }
    public function render($conn):string{
        $response = $this->prepare($conn)->execute();
        if(empty($response['data'])){
            return $this->redirect_to_country('UN PAIS HA SIDO MODIFICADO');
        }
        $view = new CountryView($response['data']);
        return $view->render(); 
    }
}