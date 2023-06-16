<?php
$region = $result['contents'][0];
?>
<form class="col d-flex flex-wrap" action="" method="post">
    <div class="mb-1 col-12">
        <div class="mb-1 col-12">
            <label class="form-label" for='nombre'>NOMBRE</label>
            <input 
                type="text"
                id="nombre"
                name="nombre"
                class="form-control"  
                value="<?php echo $region->name; ?>"
            />
        </div> 
        <div class="mb-3 col-12">
            <label class="form-label" for='pais'>SELECCIONE EL PAIS</label>
            <select name="pais" class="form-control" id="pais">
            <?php                                
                    foreach ($result['form'] as $country){
                        $selected = $region->id_country == $country->id ? ' selected="selected"' : '';
                        echo <<<HTML
                            <option value="$country->id" $selected>$country->name</option>
                        HTML;
                    }                
                ?>
            </select>
        </div>            
        <div class=" col-12 m-2">                  
            <button type="submit" class="btn btn-primary">GUARDAR</button>
        </div>
    </div>    
</form>