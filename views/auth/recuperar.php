<h1 class="nombre-pagina">¿Olvidaste tu Contraseña?</h1>

<?php

    include_once __DIR__ . '/../templates/alertas.php';

?>

<p>Reestablece tu contraseña escribiendo tu correo a contiuacion</p>


<form class="formulario" action="/recuperar" method="POST">

    <DIV class="campo">
        <label for="correo">Correo</label>
        <input
            type="email"
            id="correo"
            name="correo"
            placeholder="Escribe tu Correo"
        >
    </DIV>

    <input type="submit" value="Enviar Instrucciones" class="boton">

</form>

<div class="acciones">
  
    <a href="/">¿Ya tienes una cuenta? Incia sesion</a>

    <a href="/crear-cuenta">¿Aun no tienes una cuenta? Crea una</a>
 
</div>