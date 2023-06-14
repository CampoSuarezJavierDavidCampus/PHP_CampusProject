<?php
namespace Controllers\Country;
use Models\CountryModel;
class InsertCountryController extends CountryModel{    
    public function __construct()
    {
        if(
        empty($_POST) ||
        empty($_POST['nombre']) ||
        trim($_POST['nombre']) == '')echo $this->redirect_to_country("DATOS INVALIDOS");
        $this->name_country = filter_input(INPUT_POST,'nombre',FILTER_SANITIZE_SPECIAL_CHARS);
    }
    public function render(\PDO $conn){        
        $response = $this->prepare($conn)->execute();                
        if($response['status'] === 'error')echo $this->redirect_to_country("DATOS INVALIDOS");
        return $this->redirect_to_country('UN NUEVO PAIS A SIDO AGREGADO');
    }
}