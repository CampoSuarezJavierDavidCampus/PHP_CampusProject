<?php
$city = $result['contents'][0];
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
                value="<?php echo $city->name; ?>"
            />
        </div> 
        <div class="mb-3 col-12">
            <label class="form-label" for='region'>SELECCIONE LA REGION</label>
            <select name="region" class="form-control" id="region">
            <?php                                
                    foreach ($result['form'] as $region){
                        $selected = $city->id_region == $region->id ? ' selected="selected"' : '';
                        echo <<<HTML
                            <option value="$region->id" $selected>$region->name</option>
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