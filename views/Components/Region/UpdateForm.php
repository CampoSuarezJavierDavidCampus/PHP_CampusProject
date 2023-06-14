<form class="col d-flex flex-wrap" action=""  method="post">
    <div class="mb-1 col-12">
        <div class="mb-1 col-12">
            <label for="nombre" class="form-label">REGION</label>
            <input 
                type="text"
                id="nombre"
                name="nombre"
                class="form-control text-capitalize"  
                value ="<?php echo $result['contents'][0]->region;?>"
              />
        </div>    
        <div class="mb-3 col-12">
            <label class="form-label" for='pais'>SELECCIONES EL PAIS</label>
            <select name="pais" class="form-control" id="pais">
                <?php
                    foreach ($result['countries'] as $country){
                        $selected = $country->id == $result['contents'][0]->id_country 
                            ? 'selected="selected"':'';
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