<table class="table table-custom ">    
    <thead>
        <tr>
            <th scope="col">ID </th>
            <th scope="col">Ciudad</th> 
            <th scope="col">Region</th> 
            <th scope="col">Pais</th>            
            <th scope="col">ACCIONES</th>            
        </tr>
    </thead>
    <tbody class="" id="tabla">           
        <?php               
            foreach($result as $city){                  
                echo <<<HTML
                    <tr>
                        <td>$city->id</td>
                        <td class="text-capitalize">$city->city</td>                        
                        <td class="text-capitalize">$city->region</td>                        
                        <td class="text-capitalize">$city->country</td>                        
                        <td>
                            <a class="btn btn-danger" href="../cities/delete/$city->id">Eliminar</a>
                            <a class="btn btn-success" href="../cities/edit/$city->id">Editar</a>
                        </td>                
                    </tr>
                HTML;
            } 
        ?>
    </tbody>    
</table>

         