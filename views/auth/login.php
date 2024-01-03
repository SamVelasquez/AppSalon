<h1 class="nombre-pagina">Login</h1>
<?php

    include_once __DIR__ . '/../templates/alertas.php';


?>

<p class="descripcion-pagina">Iniciar Sesion con</p>

<div class="g-signin2" data-onsuccess="onSignIn"></div>

<a href="/" onclick="signOut();">Sign out</a>

<hr class="hr">

<p class="descripcion-pagina">Inicia sesion con tus datos</p>



<form class="formulario" method="POST" action="/">

    <div class="campo">

        <label for="correo">Correo</label>
        <input type="email" 
            id="correo"
            placeholder="Tu Correo"
            name="correo"
            
        />
    </div>

    <div class="campo">
        
        <label for="password">Contraseña</label>
        <input type="password" 
                id="password"
                placeholder="Tu Contrasela"
                name="password"
        />
    </div>



    <input type="submit" class="boton" value="Iniciar sesion">

</form>

<div class="acciones">
    <a href="/crear-cuenta">¿Aun no tienes una cuenta?</a>
    <a href="/recuperar">¿Olvidaste tu contraseña?</a>
 
</div>
<?php

    $script = "
            <script src='https://accounts.google.com/gsi/client' async defer></script>
             
        ";
?>