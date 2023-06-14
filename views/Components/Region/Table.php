<table class="table table-custom ">    
    <thead>
        <tr>
            <th scope="col">ID </th>
            <th scope="col">REGION</th>            
            <th scope="col">Pais</th>            
            <th scope="col">ACCIONES</th>            
        </tr>
    </thead>
    <tbody class="" id="tabla">           
        <?php        
            foreach($result as $region){                                                
                echo <<<HTML
                    <tr>
                        <td>$region->id</td>
                        <td class="text-capitalize">$region->region</td>                        
                        <td class="text-capitalize">$region->country</td>                        
                        <td>
                            <a class="btn btn-danger" href="../regions/delete/$region->id">Eliminar</a>
                            <a class="btn btn-success" href="../regions/edit/$region->id">Editar</a>
                        </td>                
                    </tr>
                HTML;
            } 
        ?>
    </tbody>    
</table>

         