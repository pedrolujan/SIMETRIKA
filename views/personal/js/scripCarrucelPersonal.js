const fila=document.querySelector('.contenedor-carrusel-items');
const items=document.querySelectorAll('.car-items');
const itemsTabs=document.querySelectorAll('.nav-link');
const itemPersonal=document.querySelectorAll('.contenedorDatos');

const flechaIzquierda=document.getElementById('flecha-izquierda');
const flechaDerecha=document.getElementById('flecha-derecha');

flechaDerecha.addEventListener('click',()=>{
    fila.scrollLeft +=fila.offsetWidth;

    const indicadorActivo=document.querySelector('.indicadores .activo');
   
    if(indicadorActivo.nextSibling){

        indicadorActivo.nextSibling.classList.add('activo');
        indicadorActivo.classList.remove('activo');
    }
})
flechaIzquierda.addEventListener('click',()=>{
    fila.scrollLeft -=fila.offsetWidth;
    const indicadorActivo=document.querySelector('.indicadores .activo');
   
    if(indicadorActivo.previousSibling){

        indicadorActivo.classList.remove('activo');
        indicadorActivo.previousSibling.classList.add('activo');
    }
})
/////paginacion///
const numeroPaginas=Math.ceil(items.length / 3);
for (let i = 0; i < numeroPaginas; i++) {
    const indicador =document.createElement('button');
    if(i===0){
        indicador.classList.add('activo');
    }
    document.querySelector('.indicadores').appendChild(indicador);
    indicador.addEventListener('click',(e)=>{
        fila.scrollLeft=i*fila.offsetWidth;

        document.querySelector('.indicadores .activo').classList.remove('activo');
        e.target.classList.add('activo');
    })
}

/////hover/////

items.forEach((item)=>{
    item.addEventListener('mouseenter',(e)=>{
        const elemento=e.currentTarget;
        setTimeout(() => {
            items.forEach(item => item.classList.remove('hover'));
            elemento.classList.add('hover');
        },10);
    })

    ///codigo para poner el evento activo  a los items de los prospectos//////
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

itemsTabs.forEach((item)=>{
    ///codigo para poner el evento activo  a los items de los prospectos//////
    item.addEventListener('click',(e)=>{
        const el=e.currentTarget;
        setTimeout(() => {
            itemsTabs.forEach(item => item.classList.remove('active'));
            el.classList.add('active');
        },10);
    })

})

$(document).on("click","#tbProspecto",function(){
$("#prospectos").removeClass("d-none");
$("#prospectos").addClass("d-block");
$("#ventas").addClass("d-none");
$("#ventas").removeClass("d-block");
})
$(document).on("click","#tbVenta",function(){
$("#ventas").removeClass("d-none");
$("#ventas").addClass("d-block");
$("#prospectos").addClass("d-none");
$("#prospectos").removeClass("d-block");
})