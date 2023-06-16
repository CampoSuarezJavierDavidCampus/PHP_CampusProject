<?php
$url = 'person/insert';    
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
</div><div class="mb-3 col-12">
    <label class="form-label" for='apellido'>APELLIDO</label>
    <input 
        type="text"
        id="apellido"
        name="apellido"
        class="form-control"  
    />
</div>
<div class="mb-3 col-12">
    <label class="form-label" for='fecha_nacimiento'>FECHA DE NACIMIENTO</label>
    <input 
        type="date"
        id="fecha_nacimiento"
        name="fecha_nacimiento"
        class="form-control"  
    />
</div>
<div class="mb-3 col-12">
    <label class="form-label" for='documento'>N° DOCUMENTO</label>
    <input 
        type="text"
        id="documento"
        name="documento"
        class="form-control"  
    />
</div>

<div class="mb-3 col-12">
    <label class="form-label" for='ciudad'>SELECCIONES LA Ciudad</label>
    <select name="ciudad" class="form-control" id="ciudad">
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