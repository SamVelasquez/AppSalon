document.addEventListener('DOMContentLoaded',function() {
    inicarApp();
});

function inicarApp(){
    buscarPorFecha();
}

function buscarPorFecha() {
    const fechaImput = document.querySelector('#fecha');

    fechaImput.addEventListener('input', function(e){

        const fechaSeleccionada =  e.target.value; //lee la fecha

        window.location = `?fecha=${fechaSeleccionada}`;
    })
}