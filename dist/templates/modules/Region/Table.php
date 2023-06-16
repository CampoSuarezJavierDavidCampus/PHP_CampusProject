<table class="table table-custom ">    
    <thead>
        <tr>
            <th scope="col">ID </th>
            <th scope="col">NOMBRE</th>            
            <th scope="col">PAIS</th>                             
            <th scope="col">ACCIONES</th>            
        </tr>
    </thead>
    <tbody class="" id="tabla">           
        <?php                
            foreach($result as $region){                
                echo <<<HTML
                    <tr>
                        <td>$region->id</td>
                        <td class="text-capitalize">$region->name</td>                                           
                        <td class="text-capitalize">$region->country</td>                        
                        <td>
                            <a class="btn btn-danger" href="../region/delete/$region->id">Eliminar</a>
                            <a class="btn btn-success" href="../region/edit/$region->id">Editar</a>
                        </td>                
                    </tr>
                HTML;
            } 
        ?>
    </tbody>    
</table>

         