<?php
namespace Router;
use Router\Router;
use Controllers\Country\GetCountryController;
use Controllers\Country\InsertCountryController;
use Controllers\Country\DeleteCountryController;
use Controllers\Country\UpdateCountryController;

use Controllers\Region\GetRegionController;
use Controllers\Region\InsertRegionController;
use Controllers\Region\DeleteRegionController;
use Controllers\Region\UpdateRegionController;

use Controllers\City\GetCityController;
use Controllers\City\InsertCityController;
use Controllers\City\DeleteCityController;
use Controllers\City\UpdateCityController;

use Controllers\Person\GetPersonController;
use Controllers\Person\InsertPersonController;
use Controllers\Person\DeletePersonController;
use Controllers\Person\UpdatePersonController;

abstract class Routes{
    static function init(Router $router){
        $router->set_route(
            'countries',
            (new Route())
                ->set_controllers(
                    'GET',
                    fn(int $id)=>new GetCountryController($id)
                )
                ->set_controllers(
                    'POST',
                    fn()=>new InsertCountryController()
                )
                ->set_controllers(
                    'DELETE',
                    fn(int $id)=>new DeleteCountryController($id)
                )
                ->set_controllers(
                    'PUT',
                    fn(int $id)=>new UpdateCountryController($id)
                )
        );
        $router->set_route(
            'regions',
            (new Route())
                ->set_controllers(
                    'GET',
                    fn(int $id = 0)=> new GetRegionController($id)
                )
                ->set_controllers(
                    'POST',
                    fn()=> new InsertRegionController()
                )
                ->set_controllers(
                    'DELETE',
                    fn(int $id)=> new DeleteRegionController($id)
                )
                ->set_controllers(
                    'PUT',
                    fn(int $id)=> new UpdateRegionController($id)
                )
        );
        $router->set_route(
            'cities',
            (new Route())
                ->set_controllers(
                    'GET',
                    fn(int $id = 0)=> new GetCityController($id)
                )
                ->set_controllers(
                    'POST',
                    fn()=> new InsertCityController()
                ) 
                ->set_controllers(
                    'DELETE',
                    fn(int $id)=> new DeleteCityController($id)
                )
                ->set_controllers(
                    'PUT',
                    fn(int $id)=> new UpdateCityController($id)
                )
        );
        $router->set_route(
            'persons',
            (new Route())
                ->set_controllers(
                    'GET',
                    fn(string $id)=> new GetPersonController($id)
                ) 
                ->set_controllers(
                    'POST',
                    fn()=> new InsertPersonController()
                ) 
                ->set_controllers(
                    'DELETE',
                    fn(string $id)=> new DeletePersonController($id)
                ) 
                ->set_controllers(
                    'PUT',
                    fn(string $id)=> new UpdatePersonController($id)
                )                
        );
    }
}