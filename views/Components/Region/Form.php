<?php
    $url = 'regions/insert';    
    if(count(explode('/',$_SERVER['REQUEST_URI'])) >= 3){
        $url = '../../'.$url;
    }
?>
<form class="col d-flex flex-wrap" action="<?= $url?>" method="POST">
    <div class="mb-3 col-12">
        <label class="form-label" for='nombre'>NOMBRE DE LA REGION</label>
        <input 
            type="text"
            id="nombre"
            name="nombre"
            class="form-control"  
        />
    </div>
    <div class="mb-3 col-12">
        <label class="form-label" for='pais'>SELECCIONES EL PAIS</label>
        <select name="pais" class="form-control" id="pais">
            <?php
            echo var_dump($result);
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