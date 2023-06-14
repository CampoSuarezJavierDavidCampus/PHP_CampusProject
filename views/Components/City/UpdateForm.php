<form class="col d-flex flex-wrap" action=""  method="post">
    <div class="mb-1 col-12">
        <div class="mb-1 col-12">
            <label for="nombre" class="form-label">Ciudad</label>
            <input 
                type="text"
                id="nombre"
                name="nombre"
                class="form-control text-capitalize"  
                value ="<?php echo $result['contents'][0]->city;?>"
              />
        </div>    
        <div class="mb-3 col-12">
            <label class="form-label" for='region'>SELECCIONES EL PAIS</label>
            <select name="region" class="form-control" id="region">
                <?php
                    foreach ($result['regions'] as $region){
                        $selected = $region->id == $result['contents'][0]->id_region 
                            ? 'selected="selected"':'';
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
