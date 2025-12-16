
function mostrarForm(e){

    var opcion = e.target.value;

    let dia = document.getElementById('select-dia');
    let mes = document.getElementById('select-mes');
    let anio = document.getElementById('select-anio');
    let nombre = document.getElementById('select-nombre');
    let semana = document.getElementById('semana');
    let semana2= document.getElementById('semana2');
    let boton = document.getElementById('boton');




    dia.style.display = 'none';
    mes.style.display = 'none';
    anio.style.display = 'none';
    nombre.style.display = 'none';
    semana.style.display = 'none';
    semana2.style.display = 'none';
    boton.style.display = 'none';


    

    if(opcion === 'dia'){
        dia.style.display = 'block';
        boton.style.display = 'block';


   
    } else if(opcion === 'mes_anio'){
        mes.style.display='block';
        anio.style.display= 'block';
        boton.style.display = 'block';
 


    } else if(opcion === 'nombre'){
        nombre.style.display='block';
        boton.style.display = 'block';
 


    } else if(opcion === 'rango'){
        semana.style.display= 'block';
        semana2.style.display= 'block';
        boton.style.display = 'block';


    }


}
document.addEventListener('DOMContentLoaded', function() {
    const selectFiltro = document.getElementById('filtro');

    if (selectFiltro) {
        selectFiltro.addEventListener('change', mostrarForm);
    }
});