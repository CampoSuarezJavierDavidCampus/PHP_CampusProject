<?php
$url = 'country/insert';    
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

    <button type="submit" class="btn btn-success mt-4">Enviar</button>
</form>