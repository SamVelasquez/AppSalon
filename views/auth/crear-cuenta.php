<h1 class="nombre-pagina">crear cuenta</h1>
<p class="descripcion-pagina">Llena el siguiente formulario para craear cuenta</p>

<?php

    include_once __DIR__ . '/../templates/alertas.php';
?>

<form class="formulario" method="POST" action="/crear-cuenta">

    <div class="campo">
        <label for="nombre">Nombre</label>
        <input type="text"  
         id="nombre" 
            name="nombre"
            placeholder="Escribe tu Nombre"
            value="<?php echo s($usuario->nombre )?>"
        >
    </div>

    <div class="campo">
        <label for="apellido">Apellido</label>
        <input type="text"  id="apellido" name="apellido" placeholder="Escribe tu Apellido"
        value="<?php echo s($usuario->apellido )?>"
        >
    </div>

    <div class="campo">
        <label for="telefono">Telefono</label>
        <input type="text" id="telefono" name="telefono" placeholder="Numero de contacto"
        value="<?php echo s($usuario->telefono )?>"
        >
    </div>

    <div class="campo">
        <label for="email">Correo</label>
        <input type="email"  id="email" name="correo" placeholder="Escribe tu Correo"
        value="<?php echo s($usuario-> correo )?>"
        >
    </div>

    <div class="campo">
        <label for="password">Contraseña</label>
        <input type="password"  id="password" name="password" placeholder="Escribe tu Contraseña">
    </div>

    <input  type="submit" value="Crear Cuenta" class="boton">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Incia sesion</a>
    <a href="/recuperar">¿Olvidaste tu contraseña?</a>
 
</div>