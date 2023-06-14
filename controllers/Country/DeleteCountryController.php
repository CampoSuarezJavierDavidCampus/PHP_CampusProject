<?php
namespace Controllers\Country;
use Models\CountryModel;
class DeleteCountryController extends CountryModel{
    public function __construct(
        int $id
    )
    {
        if($id === 0)echo $this->redirect_to_country("PAIS NO ENCONTRADO");
        $this->id_country = filter_var($id,FILTER_VALIDATE_INT);           
    }
    
    public function render($conn){
        $response = $this->prepare($conn)->execute();
        if($response['status']==='error')echo $this->redirect_to_country("NO SE EFECTUO LA OPERACION");
        return $this->redirect_to_country('UN PAIS HA SIDO ELIMINADO');
    }
}