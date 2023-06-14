<table class="table table-custom ">    
    <thead>
        <tr>
            <th scope="col">ID </th>
            <th scope="col">Pais</th>            
            <th scope="col">ACCIONES</th>            
        </tr>
    </thead>
    <tbody class="" id="tabla">           
        <?php        
            foreach($result as $country){                                                
                echo <<<HTML
                    <tr>
                        <td>$country->id_country</td>
                        <td class="text-capitalize">$country->name_country</td>                        
                        <td>
                            <a class="btn btn-danger" href="../countries/delete/$country->id_country">Eliminar</a>
                            <a class="btn btn-success" href="../countries/edit/$country->id_country">Editar</a>
                        </td>                
                    </tr>
                HTML;
            } 
        ?>
    </tbody>    
</table>

         