
let paso = 1;
const pasoInicial = 1;
const pasoFinal =3;

/* objeto de cita para enviar al jason*/

const cita  = {
    id : '',
    nombre : '',
    fecha : '',
    hora : '',
    servicios : [] //arreglo
}


/**/

document.addEventListener('DOMContentLoaded', function(){
    iniciarApp();
});


function iniciarApp(){


 
        mostrarSeccion();//muestra y oculta las seccion
        tabs();//cambia la seccion cuando se presionen los tabs

        paginador();//agrega o quita los botones del paginador
        paginaAnterior();
        paginaSiguiente(); 
        nombreCliente();
        SeleccionarFecha();
        SeleccionarHora();
        muestraResumen();
        /**API**/
        ConsultarAPI();
        /**fin **/

        idCliente();



}

function tabs(){
    const botones = document.querySelectorAll('.tabs button')
       

    //debo interar por cada uno de los botones

    botones.forEach( boton =>{

        boton.addEventListener('click' , function(e){
         //   console.log(e);
            e.preventDefault();
            paso = parseInt( e.target.dataset.paso);
            
            mostrarSeccion();
            paginador();
            /*
            paginaSiguiente();
            paginaAnterior();*/
            
        })

    } );
    
}

function mostrarSeccion (){
    
    //ocultar la seccion previa

    const seccionANterior = document.querySelector('.mostrar');

    if(seccionANterior){
        seccionANterior.classList.remove('mostrar');
    }

    //selecionar la seccion con el paso
    const pasoSelector = `#paso-${paso}`;

    const seccion= document.querySelector(pasoSelector);
    seccion.classList.add('mostrar');


    //desmarco el tab anterior
    const tabANterior = document.querySelector('.actual');

    if(tabANterior){
        tabANterior.classList.remove('actual');
    }

    //resalta el tab actual

    const tab = document.querySelector(`[data-paso="${paso}"]`); //atributo personalizado


    tab.classList.add('actual');


}


function paginador(){
    const paginaSiguiente = document.querySelector('#siguiente');

    const paginaAnterior = document.querySelector('#anterior');

    if(paso === 1){
        paginaAnterior.classList.add('ocultar');
        paginaSiguiente.classList.remove('ocultar')
     

    }else if (paso === 3){   
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.add('ocultar');
  
        muestraResumen();
     
    }else{
       

        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }

    mostrarSeccion();
}

 function paginaAnterior(){
        const paginaAnterior = document.querySelector('#anterior');

        paginaAnterior.addEventListener('click', function(){
           
            if( paso <= pasoInicial)return;
            paso--;
           /*console.log(paso);*/
           paginador();
        });
}

function paginaSiguiente(){
    const paginaSiguiente = document.querySelector('#siguiente');

    
    paginaSiguiente.addEventListener('click', function(){
       
        if( paso >= pasoFinal)return;
        paso++;
        
        paginador();
    });
}

//funciones asincronas
async  function ConsultarAPI(){
    
    try{
        //url que voy a consumir
        const url = `${location.origin}/api/servicios`;

        //espera el resultado
        const resultado = await fetch(url);
        const servicios = await resultado.json();

        // console.log (servicios);
        //luego avanza
        mostrarServicios(servicios);

    }catch(error){
        console.log(error);
    }
}
function mostrarServicios(servicios){
    //consumiendo archivos de la db con js
    servicios.forEach(servicio => {
        const { id , nombre, precio} =servicio;

        const nombreSericio = document.createElement('P');
        nombreSericio.classList.add('nombre-servicio');
        nombreSericio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent = `$${precio}`;

        //crear el contenedor
        const servicioDiv = document.createElement('DIV');
        servicioDiv.classList.add('servicio');
        servicioDiv.dataset.idServicio = id;
        servicioDiv.onclick = function () 
        {
            selecionarServicio(servicio)
        }; //callback

        servicioDiv.appendChild(nombreSericio);
        servicioDiv.appendChild(precioServicio);

        //inyectanmos todo el codigo que acabamos generar en #sericios
        document.querySelector('#servicios').appendChild(servicioDiv);

        //console.log(servicioDiv)
    });


    function selecionarServicio(servicio) {
        const {servicios} = cita; //extraigo el arreglo de servicio
        const {id} =servicio;
        //realizo una copia  y lo agrego al nuevo servicio
        cita.servicios =[...servicios , servicio];
        const servicioSeleccionado = `[data-id-servicio="${id}"]`;
        const divServicio = document.querySelector( servicioSeleccionado);  
    
        //Comprueba  si el objeto fue seleccionado
        //arraymethod
        //some (sirve para revisar en un arreglo ya esta en un elemento )
        if(servicios.some(agregado => agregado.id === id)){
            // Ya esta agregado , eliminar
            //filter sirve para sacar un elemento bajo una condicion
            cita.servicios = servicios.filter (agregado => agregado.id !== id);
            divServicio.classList.remove('seleccionado');

        }else{
            //articulo nuevo que no estaba agregado, agregarlo 
            divServicio.classList.add('seleccionado');
        }

        //console.log(cita)

    }
}

function nombreCliente(){
    const nombre = document.querySelector('#nombre').value; //accedemos al valor
    //se lo asignamos el arreglo de cita
    cita.nombre = nombre;
    //console.log(cita);
}

function idCliente(){
    cita.id = document.querySelector('#id').value; //accedemos al valor
    //se lo asignamos el arreglo de cita
    //cita.id = id;
    //console.log(cita);
}

function SeleccionarFecha(){
    const inputFecha = document.querySelector('#fecha');
    inputFecha.addEventListener('input', function(e){

        //bloquear fechas no disponibles ejemplo fin de semanas

        const dia = new Date(e.target.value).getUTCDay();
        //console.log(dia);
        /*
            getUTCDay =
            0 = Domingo
            1 = Lunes
            2 = Martes
            3 = Miercoles
            4 = Jueves
            5 = Viernes
            6 = Sabado

        */
        if([0].includes(dia)){
            e.target.value = '';
            mostrarAlerta('Domingos no permitidos' , 'error', '.formulario');
            //console.log('Domingo no abrimos');
        }else {
            cita.fecha = e.target.value;//agrego la fecha al arreglo
        }

     

    });
}

function mostrarAlerta(mensaje, tipo , elemento, desaparece = true){
    //Previene que se generen mas alertas

    const alertaPrevia = document.querySelector('.alerta');
    if(alertaPrevia){
        alertaPrevia.remove();
    } 

    //scriptin de laerta
    const alerta = document.createElement('DIV');
    alerta.textContent= mensaje;
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);

    const referencia = document.querySelector(elemento); // indico donde aparecer a la alerta
    referencia.appendChild(alerta);
    //console.log (alerta);
    if (desaparece){
        setTimeout(() => {
            alerta.remove();
        }, 3000); //3s
    }
}
function SeleccionarHora(){
    const inputHora = document.querySelector('#Hora');

    inputHora.addEventListener('input', function(e){
        const horaCita = e.target.value;
        const hora = horaCita.split(":")[0];// el separador sera los ":"
        
        if (hora < 10 || hora > 18){
            e.target.value = '';
           mostrarAlerta('Hora no valida' , 'error', '.formulario');
        }else {
            cita.hora = e.target.value;
        }
        //console.log(cita)
    });
}

function muestraResumen(){
    const resumen = document.querySelector('.contenido-resumen');

    //limpiar contenido resumen

    while(resumen.firstChild){
        resumen.removeChild(resumen.firstChild);
    }

    if(Object.values(cita).includes('') || cita.servicios.length === 0 ) {
        mostrarAlerta('Hacen falta datos' , 'error', '.contenido-resumen', false );
        return;
    }

    //fromartear el div de resumen
    const { nombre , fecha , hora ,servicios} = cita;
    
    //heading para servicio en resumen
    const headingServicio = document.createElement('H3');
    headingServicio.textContent ='Resumen de Servicio';
    resumen.appendChild(headingServicio);

    //console.log(resumen);

    //iterando y mostrando los servicios
    servicios.forEach( servicios =>{
        const {id, precio, nombre} = servicios;

        const contenedorServicio = document.createElement('DIV');
        contenedorServicio.classList.add('contenedor-servicio');

        const textoServicio = document.createElement('P');
        textoServicio.textContent = nombre;

        const precioServicio =document.createElement('P');
        precioServicio.innerHTML = `<span>Precio:</span> $${precio}`;

        contenedorServicio.appendChild(textoServicio);
        contenedorServicio.appendChild(precioServicio);

        resumen.appendChild(contenedorServicio);
    });
    //heading de la cita
    const CitaResumen = document.createElement('H3');
    CitaResumen.textContent ='Resumen de la Cita';
    resumen.appendChild(CitaResumen);

    const nombreCliente = document.createElement('P');
    nombreCliente.innerHTML = `<span>Nombre</span> ${nombre}`;
    /***********FORMATEO DE FECHA*************** */
    //formatear la fecha en español
    const fechaNueva = new Date(fecha);
    const mes = fechaNueva.getMonth();
    const dia = fechaNueva.getDate() + 2; // por que lo utilizo 2 veces
    const year = fechaNueva.getFullYear();

    const fechaUTC = new Date(Date.UTC(year, mes, dia));
    const opciones = {weekday : 'long', year: 'numeric' , month: 'long' , day:'numeric'}
    const fechaFormateada = fechaUTC.toLocaleDateString('es-MX' , opciones);
    /************FIN FORMATEO*********** */

    const fechaCita = document.createElement('P');
    fechaCita.innerHTML = `<span>Fecha</span> ${fechaFormateada}`;

    const horaCita = document.createElement('P');
    horaCita.innerHTML = `<span>Hora</span> ${hora}`;

    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCita);
    resumen.appendChild(horaCita);

    //boton para crear una cita

    const botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add('boton');
    botonReservar.textContent ='Reservar Cita';
    botonReservar.onclick = function(){
          reservarCita();
    }
       
    resumen.appendChild(botonReservar);
}

//la api resive datos estructurados
async function reservarCita (){


    const {nombre, fecha, hora , servicios, id} = cita;
    //traigo las coindencia con el .map
    const idServicio = servicios.map(servicios => servicios.id);

    const datos = new FormData()
    //agregamos datos al formdata
    datos.append ('usuarioId' , id);
    datos.append ('fecha' , fecha);
    datos.append ('hora' , hora);
    datos.append ('servicios' , idServicio);


    try{
        const url = `${location.origin}/api/citas`;
        //usando asyc await
        const respuesta = await fetch(url , {
            method: 'POST',
            body: datos
        }) ;
    
        //envio el resultado a mi api
       const resultado = await respuesta.json();
        
       Swal.fire({
            icon: "success",
            title: "Cita Creada",
            text: "Tu Cita fue creada correctamente!",
            button: 'OK'
        }).then(() =>{//recargar la pagina

            setTimeout(() => {

                window.location.reload();
            }, 500 );//3s
          
        });
    }catch(error){
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Hubo un error al guardar la cita!",
           
        });
    }
    

}
