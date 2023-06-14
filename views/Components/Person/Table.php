<table class="table table-custom ">    
    <thead>
        <tr>
            <th scope="col">ID </th>
            <th scope="col">NOMBRE</th>            
            <th scope="col">FECHA DE NACIMIENTO</th>            
            <th scope="col">UBICACIÓN</th>            
            <th scope="col">ACCIONES</th>            
        </tr>
    </thead>
    <tbody class="" id="tabla">           
        <?php                
            foreach($result as $person){                     
                $birthday= new \DateTime($person->birthday);
                $birthday = $birthday->format('d-m-Y');
                echo <<<HTML
                    <tr>
                        <td>$person->id</td>
                        <td class="text-capitalize">$person->name</td>                        
                        <td class="text-capitalize">$birthday</td>                        
                        <td class="text-capitalize">$person->city</td>                        
                        <td>
                            <a class="btn btn-danger" href="../persons/delete/$person->id">Eliminar</a>
                            <a class="btn btn-success" href="../persons/edit/$person->id">Editar</a>
                        </td>                
                    </tr>
                HTML;
            } 
        ?>
    </tbody>    
</table>

         