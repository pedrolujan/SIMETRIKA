import { urlProyect } from "./urlProyecto.js?357";


UsuarioLogeado();
function UsuarioLogeado(){
    let Logeo=0;   
    $.ajax({
        url: urlProyect+'controller/DevolverDatos.php',
        type: 'post',
        data:{Logeo},
        dataType: 'json',
        success: function (respuesta) {
           console.log(respuesta);
                $(".imagenUsuarioLogeado").attr("src",urlProyect+`${respuesta.imgUsuario}`);
                $(".nombreUsuario").html(`${respuesta.usuario}`);
                $(".cargoUsuario").html(`${respuesta.cargo}`);
                         
        }
        
    })
  }

/* localStorage.removeItem('item') */
const fila=document.querySelector('.sidebar');
const items=document.querySelectorAll('.menu_items');

$(document).on("click","#logo-empresa",function () {
    location.href =urlProyect;
})
$(document).on("click",".nom-simetrika",function () {
    location.href =urlProyect;
})

// const itemsbOTON=document.querySelectorAll('.menu_items');
/* 
$( document ).ready(function() {
   
    window.history.forward();

    const itemEspecifico=localStorage.getItem('item');
    for (let index = 0; index < itemsbOTON.length; index++) {
      
        if(index==itemEspecifico){
            console.log(itemsbOTON[index]);
            itemsbOTON[index].classList.add('activo');
        }else{
            if(itemEspecifico==null){
                itemsbOTON[0].classList.add('activo');
            }else{

                itemsbOTON[index].classList.remove('activo');
            }
        }
               
    }
    
});
 */


items.forEach((item)=>{
    item.addEventListener('mouseenter',(e)=>{
        const elemento=e.currentTarget;
        setTimeout(() => {
            items.forEach(item => item.classList.remove('hover'));
            elemento.classList.add('hover');
        },10);
    })

    item.addEventListener('click',(e)=>{
        const elemento=e.currentTarget;
        setTimeout(() => {
            items.forEach(item => item.classList.remove('activo'));
            elemento.classList.add('activo');
        },10);
    })

})
fila.addEventListener('mouseleave',()=>{
    items.forEach(item => item.classList.remove('hover'));
})


$(document).on("click","#item-personal",function(e) {

    // localStorage.setItem('item','1')
    
    //   $("#main").load("views/personal/");
})
	
	
	
	
/*	$('#btnregGrado').click(function(){
		$('.contnRAat').load('php/registro_grado.php');
	});
	$('#btnregSeccion').click(function(){
		$('.contnRAat').load('php/registro_seccion.php');
	});
	$('#btnregCurso').click(function(){
		$('.contnRAat').load('php/registro_curso.php');
	});*/

//// alertas dashboard/////

alertasDashboard();
function alertasDashboard(){
    /* let fechaIni = $("#fecha_inicio").val();
    let fechaFin = $("#fecha_final").val();*/
    let dato=3; 
   
    $.ajax({
        url: urlProyect+'controller/alertas_dashboard.php',
        type: 'post',
        data:{dato},
        dataType: 'json',
        success: function (respuesta) {
            let pSinSeguimiento=0;
            pSinSeguimiento=(`${respuesta.prospectosTotal}`- `${respuesta.prospectosTotalSeguidos}`)
            if(pSinSeguimiento<0){
                pSinSeguimiento=0;
            }
             
                $(".dNumeroTotal").html(`${respuesta.prospectosTotal}`);
                $(".dNumeroCSeguimiento").html(`${respuesta.prospectosTotalSeguidos}`);
                $(".dNumeroSinSeguimiento").html(pSinSeguimiento);
                         
        }
        
    })
  }