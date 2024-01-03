<h1 class="nombre-pagina">Recuperar Contraseña</h1>

<?php

    include_once __DIR__ . '/../templates/alertas.php';

?>

<p class="descripcion-pagina"> Coloca tu nueva contraseña a continuacion</p>

<?php if($error) return ; ?>
<form class="formulario" method="POST" >

    <div class="campo">
        <label for="password">Contraseña</label>
        <input type="password" 
                id="password"
                name="password"
                placeholder="Nueva Contraseña">
    </div>




    <input type="submit" class="boton" value="guardar nueva contraseña">

</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Incia sesion</a>
    <a href="/crear-cuenta">¿Aun no tienes una cuenta? Crea una</a>

</div>