<?php
$url = 'region/insert';    
if(count(explode('/',$_SERVER['REQUEST_URI'])) >= 3){
    $url = '../../'.$url;
}
?>
<form class="col d-flex flex-wrap" action="<?= $url?>" method="POST">
    <div class="mb-3 col-12">
        <label class="form-label" for='nombre'>NOMBRE</label>
        <input 
            type="text"
            id="nombre"
            name="nombre"
            class="form-control"  
        />
    </div>

    <div class="mb-3 col-12">
        <label class="form-label" for='pais'>SELECCIONE EL PAIS</label>
        <select name="pais" class="form-control" id="pais">
            <?php    
                foreach ($result as $country){
                    echo <<<HTML
                        <option value="$country->id">$country->name</option>
                    HTML;
                }                
            ?>
        </select>
    </div>

    <button type="submit" class="btn btn-success mt-4">Enviar</button>
</form>