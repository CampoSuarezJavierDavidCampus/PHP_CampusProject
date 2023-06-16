<table class="table table-custom ">    
    <thead>
        <tr>
            <th scope="col">ID </th>
            <th scope="col">PAIS</th>        
            <th scope="col">ACCIONES</th>        
        </tr>
    </thead>
    <tbody class="" id="tabla">           
        <?php                
            foreach($result as $country){                
                echo <<<HTML
                    <tr>
                        <td>$country->id</td>
                        <td class="text-capitalize">$country->name</td> 
                        <td>
                            <a class="btn btn-danger" href="../country/delete/$country->id">Eliminar</a>
                            <a class="btn btn-success" href="../country/edit/$country->id">Editar</a>
                        </td>            
                    </tr>
                HTML;
            } 
        ?>
    </tbody>    
</table>
