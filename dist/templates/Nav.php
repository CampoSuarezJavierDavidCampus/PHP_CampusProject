<?php
$extencion = '../';    
if(count(explode('/',$_SERVER['REQUEST_URI'])) >= 3){
    $extencion = '../'.$extencion;
}
?>
<nav class="parte-izquierda">
    <div class="perfil">
        <h3 style="margin-bottom: 2rem;">Laika</h3>
        <img src="../css/perro-globo.png" alt="" class="imagenPerfil">
    </div>
    <div class="menus">
        <a href="/" style="display: flex;gap:2px;">
          <i class="bi bi-house-door"> </i>
          <h3 style="margin: 0px;">Home</h3>
        </a>
        <a href="<?php echo $extencion;?>countries" style="display: flex;gap:1px;">
          <i class="bi bi-globe-americas"></i>
          <h3 style="margin: 0px;font-weight: 800;">Paises</h3>
        </a>
        <a href="<?php echo $extencion;?>regions" style="display: flex;gap:1px;">
          <i class="bi bi-building"></i>
          <h3 style="margin: 0px;font-weight: 800;">Regiones</h3>
        </a>
        <a href="<?php echo $extencion;?>cities" style="display: flex;gap:1px;">
          <i class="bi bi-geo-alt"></i>            
          <h3 style="margin: 0px;font-weight: 800;">Ciudades</h3>
        </a>
        <a href="<?php echo $extencion;?>persons" style="display: flex;gap:1px;">
          <i class="bi bi-emoji-laughing"></i>   
          <h3 style="margin: 0px;font-weight: 800;">Personas</h3>
        </a>
      </div>
</nav>