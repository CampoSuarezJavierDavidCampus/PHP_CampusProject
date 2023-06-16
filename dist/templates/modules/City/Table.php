<table class="table table-custom ">    
    <thead>
        <tr>
            <th scope="col">ID </th>
            <th scope="col">NOMBRE</th>            
            <th scope="col">UBICACION</th>                             
            <th scope="col">ACCIONES</th>            
        </tr>
    </thead>
    <tbody class="" id="tabla">           
        <?php                
            foreach($result as $city){                    
                echo <<<HTML
                    <tr>
                        <td>$city->id</td>
                        <td class="text-capitalize">$city->name</td>                                           
                        <td class="text-capitalize">$city->ubicacion</td>                        
                        <td>
                            <a class="btn btn-danger" href="../city/delete/$city->id">Eliminar</a>
                            <a class="btn btn-success" href="../city/edit/$city->id">Editar</a>
                        </td>                
                    </tr>
                HTML;
            } 
        ?>
    </tbody>    
</table>

         