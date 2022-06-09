const fila=document.querySelector('.contenedor-carrusel-items');
const items=document.querySelectorAll('.car-items');
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

        indicadorActivo.previousSibling.classList.add('activo');
        indicadorActivo.classList.remove('activo');
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