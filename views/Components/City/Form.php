<?php
$url = 'cities/insert';    
if(count(explode('/',$_SERVER['REQUEST_URI'])) >= 3){
    $url = '../../'.$url;
}
?>
<form class="col d-flex flex-wrap" action="<?= $url?>" method="POST">
<div class="mb-3 col-12">
    <label class="form-label" for='nombre'>NOMBRE DE LA CIUDAD</label>
    <input 
        type="text"
        id="nombre"
        name="nombre"
        class="form-control"  
    />
</div>
<div class="mb-3 col-12">
    <label class="form-label" for='region'>SELECCIONES LA REGION</label>
    <select name="region" class="form-control" id="region">
        <?php
        echo var_dump($result);
            foreach ($result as $city){
                echo <<<HTML
                    <option value="$city->id">$city->name</option>
                HTML;
            }                
        ?>
    </select>
</div>

<button type="submit" class="btn btn-success mt-4">Enviar</button>
</form>