<?php
$country = $result['contents'][0];
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
                value="<?php echo $country->name; ?>"
            />
        </div>          
        <div class=" col-12 m-2">                  
            <button type="submit" class="btn btn-primary">GUARDAR</button>
        </div>
    </div>    
</form>