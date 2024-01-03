<h2 class="nombre-pagina">Servicios</h2>
<p class="descripcion-pagina">Administracion de servicios</p>

<?php
    include_once __DIR__. '/../templates/barra.php';
?>


<ul class="servicios">
    <?php //iterando los resultados de la db
        foreach ($servicios as $servicio){
    ?>
        <li>
            <p>Nombre: <span><?php echo $servicio->nombre; ?></span></p>
            <p>precio: <span>$ <?php echo $servicio->precio; ?></span></p>

            <div class="acciones">
                <a class="boton" href="/servicios/actualizar?id=<?php echo $servicio-> id;?>">Actualizar</a>
               
                <form action="/servicios/eliminar" method="POST">
                    <input type="hidden" name="id" value="<?php echo $servicio-> id;?>">

                    <input type="submit" class="boton boton-eliminar" value="borrar">
                </form>
            </div>
        </li>

    <?php
        }//cierre foreach
    ?>
</ul>