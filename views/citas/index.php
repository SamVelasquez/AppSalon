<h1 class="nombre-pagina">Crear nueva cita</h1>
<p class="descripcion-pagina">Elige tus servicios a contiacion</p>

<?php include_once __DIR__ . '/../templates/barra.php'; ?>

<div class="apps">

    <nav class="tabs">
        <button class="actual" type="button" data-paso="1">Servicios</button>
        <button type="button" data-paso="2">Informacion Cita</button>
        <button type="button" data-paso="3">Resumen</button>
    </nav>

    <div id="paso-1" class="seccion">
        <h2>Servicios</h2>
        <p class="text-center">Eligue tus servicios a contunacion</p>
        <div class="listado-servicios" id="servicios">

        </div>
    </div>

    <div id="paso-2" class="seccion">
        <h2>Tus datos y cita</h2>
        <p>coloca tus datos y fecha de tu cita</p>
        
        <form class="formulario">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input 
                    type="text"
                    id="nombre"
                    placeholder="Tu nombre"
                    value="<?php echo s($nombre)?>"
                    disabled
                >
            </div>
            <div class="campo">
                <label for="fecha">Fecha</label>
                <input 
                    type="Date"
                    id="fecha"
                    min="<?php echo date('Y-m-d'); /*bloqueo fechas anteriores* / 
                    /*strotime('+1')*/ /* para bloquear la fecha actual y que comience un dia despues */ ?>" 
                    
                >
            </div>
         
            <div class="campo">
                <label for="hora">Hora:</label>
                <input 
                    type="time"
                    id="Hora"
                >
            </div>

            <input type="hidden" id="id" value="<?php  echo $id; ?>">
         </form>
    </div>
    <div id="paso-3" class="seccion contenido-resumen">
        <h2>Resumen</h2>
        <p class="text-center">Verifica que la informacion sea correcta</p>
        <div class="listado-servicios" id="servicios">
            
        </div>
    </div>

    <div class="paginacion">
            <button
            id="anterior"
            class="boton"
            >&laquo; Anterior
            </button>

            <button
            id="siguiente"
            class="boton"
            > Siguiente &raquo;
            </button>
    </div>

</div>

<?php

    $script = "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script src='build/js/app.js'></script>
    ";
?>