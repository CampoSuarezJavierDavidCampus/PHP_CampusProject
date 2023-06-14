<?php
$person = $result['contents'][0];
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
                value="<?php echo $person->firstname; ?>"
            />
        </div> <div class="mb-1 col-12">
            <label class="form-label" for='apellido'>APELLIDO</label>
            <input 
                type="text"
                id="apellido"
                name="apellido"
                class="form-control"  
                value="<?php echo $person->lastname; ?>"                
            />
        </div> <div class="mb-1 col-12">
            <label class="form-label" for='fecha_nacimiento'>FECHA DE NACIMIENTO</label>
            <input 
                type="date"
                id="fecha_nacimiento"
                name="fecha_nacimiento"
                class="form-control" 
                value="<?php echo $person->birthday; ?>"
            />
        </div> <div class="mb-1 col-12">
            <label class="form-label" for='documento'>N° DOCUMENTO</label>
            <input 
                type="text"
                id="documento"
                name="documento"
                class="form-control"  
                value="<?php echo $person->id; ?>"
            />
        </div>    
        <div class="mb-3 col-12">
            <label class="form-label" for='ciudad'>SELECCIONES LA Ciudad</label>
            <select name="ciudad" class="form-control" id="ciudad">
            <?php                                
                    foreach ($result['cities'] as $city){
                        $selected = $city->id == $person->id_city ? ' selected="selected"' : '';
                        echo <<<HTML
                            <option value="$city->id" $selected>$city->name</option>
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