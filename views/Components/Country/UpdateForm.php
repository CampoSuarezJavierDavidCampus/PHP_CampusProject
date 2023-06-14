<form class="col d-flex flex-wrap" action=""  method="post">
    <div class="mb-1 col-12">
        <div class="mb-1 col-12">
            <label for="nombre" class="form-label">PAIS</label>
            <input 
                type="text"
                id="nombre"
                name="nombre"
                class="form-control"  
                value ="<?= $result[0]->name_country?>"
              />
        </div>                
        <div class=" col-12 m-2">                  
            <button type="submit" class="btn btn-primary">GUARDAR</button>
        </div>
    </div>    
</form>