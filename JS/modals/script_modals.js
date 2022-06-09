var urlProyecto="http://localhost/L&M.StoreTecnology/";

function abrirConfirElimina() {
    $('.modal_confirmar').fadeIn(100, function () {
        $('.contenMConfirmar').fadeIn(0);
    });
}
function cerrarConfirElimina() {
    $('.contenMConfirmar').fadeOut(100, function () {
        $('.modal_confirmar').fadeOut(0);
    });
}
$(document).on('click', '.btnAbreEliminarPro', function () {
    let element = $(this)[0].parentElement.parentElement.parentElement;
    let id = $(element).attr('capturoid');
    $("#txtObtId").val(id);
    abrirConfirElimina();

});
$(document).on('click', '.modal_confirmar', cerrarConfirElimina)
$(document).on('click', '.btnCerrar', cerrarConfirElimina);
$(document).on('click', '.btn_cancelar', cerrarConfirElimina);

/* codigo para elimminar producto */
$(document).on('click', '.btn_CambiarEstadoD', function (e) {
    e.preventDefault();
    var id = $("#txtObtId").val();
    $.ajax({
        url: '../controller/eliminar_productos.php',
        data: {id},
         type: 'post',
         dataType: 'json'
        })
         .done(function correcto(resp) {
        if (resp.exito != undefined) {
            document.location.href = urlProyecto+"views/Usuario.php" ;

        }
        if (resp.error != undefined) {
            $(".respuestas").html(resp.error).fadeIn();
           
            
        }
    }).fail(function error(e) {
        document.location.href = urlProyecto+"views/Usuario.php" ;
        cerrarConfirElimina();
    }).always(function final() {});
    setTimeout(function () {
        $(".respuestas").fadeOut(1500);
    }, 3000);
});
/* codigo para actualizar producto */
$(document).on("click", ".btnActualizarPro", function (e) {
    e.preventDefault();
    var datos = new FormData($("#formularioActPro")[0]);
    $.ajax({
        url: "../controller/actualizar_productos.php",
        data: datos,
        type: "POST",
        dataType: "json",
        contentType: false,
        processData: false
    }).done(function correcto(resp) {
        
        if (resp.error !== undefined) {
            $(".respuestas").html(resp.error).fadeIn();
            alert(resp.error);
            return false;
        }else if (resp.ok !== undefined) {
            $("#respuesta").addClass("respuestaOk").text("resp.ok").show(300).delay(4000).hide(300);              
            $("#respuesta").removeClass("respuestaError");
            cerrarRegistroA();
            location.reload();
           /*  $(".respuestas").html(resp.exito).fadeIn();
            let id = $("#capIdPro").val();
            $.ajax({
                data: {id},
                url: 'controller/detalle_producto.php',
                type: 'post',
                beforeSend: function () {},
                success: function (response) {
                    $(".cargarDatos").html(response);
                    $(".btnCargaDescrip").click();
                },
                error: function () {
                    alert("error")
                }
            }); */
        }
    })
    setTimeout(function () {
        $(".respuestas").fadeOut(1500);
    }, 3000);
})


/* codigo para logearse si desea comprar a carrito */
$(document).on("click", ".btnaccederM", function (e) {
    e.preventDefault();
    var usuario = $("#txtusuario").val();
    var clave = $("#txtpassword").val();
    var id = $("#idDetalle").val();
    $.ajax({
        data: {
            usuario,
            clave,id
        },
        url: urlProyecto+"controller/validar_acceso.php",
        type: "post",
        dataType: "json",
        async: true
    }).done(function correcto(resp) {
        if(resp.redirec!=undefined && resp.exito!=undefined){
            window.setTimeout(function(){
                window.location.href = urlProyecto+"views/detalle_producto.php?id="+resp.redirec;
     
            }, 3000);
        }
        if(resp.exito!=undefined){
            $("#salidaSMS").addClass("exito").text(resp.exito).show(300).delay(3000).hide(300);              
            $("#salidaSMS").removeClass("error");
            window.setTimeout(function(){
                window.location.href = urlProyecto+"views/Usuario.php";
     
            }, 4000);
        }else{
            $("#salidaSMS").removeClass("exito");
            $("#salidaSMS").addClass("error").fadeIn(100).text(resp.error).show(300).delay(3000).hide(300)
        }      
    })      
    
})
/*codigo para adicionar a carrito*/
var cont=0;
$(document).on("click",".btnAdicionarCar",function(){
    $(".sumarCarrito").text(cont);
    cont+=1;
})
/*codigo para despachos */
$(document).on("click",".bntConsulCostoPro",function(){
    $(".ftbody").load("descripcion_producto.php");
   
})

 /*codigo para cargar la descripcion y ficha tecnica de los productos*/
$(document).on("click",".btnCargaDescrip",function(){
    $(".ftbody").load("descripcion_producto.php");
   
})
$(document).on("click",".btnCargaFichaT",function(){
    /* capturo el id del producto luego cago la ficha tecnica y le envio el id */
    let element = $(this)[0].parentElement.parentElement;
    var id = $(element).attr('capturoid');
    $(".ftbody").load("ficha_tecnicaProducto.php",function(){
        mostrarFichaT(id);
        $("#txtidFT").val(id);
        
    });   
})

/* CODIGO PARA MANDAR EL ID DE PRODUCTO A LA VENTANA MODAL */
$(document).on("click",".btnEditFT",function(){
   let id= $("#txtidFT").val();
    $("#txtidFtModal").val(id);   
  
})
/* cargo los datos de la descripcion de producto a la ventana modal */
$(document).on("click","#btnEditDetalle",function(){
    $('#acaFoto1DescripProducto').attr("src",$('.imagen1DescripPro').attr("src"));
    $('#acaFoto2DescripProducto').attr("src",$('.imagen2DescripPro').attr("src"));
    $('#TAdescripcionnn').html($('.textoDescripcion').html());
})
/* codigo para insertar datos de la ficha tecnica de cada producto */
$(document).on("click",".btnGuardarFTP",function(e){
  e.preventDefault();
  let id=$("#txtidFtModal").val();
  let datos=$("#form-fichaTecnica").serialize();
    $.ajax({
        data: datos,
        url: "../controller/Registrar_fichaTecnica.php",
        type: "post",
        dataType: "json",
        async: true
    }).done(function correcto(resp) {
        if (resp.error !== undefined) {
            alert(resp.error);       
            return false;
        }
        if(resp.exito !== undefined) {
            $("#respuesta").addClass("respuestaOk").text(resp.exito+"✔").show(300).delay(2000).hide(300);              
             $("#respuesta").removeClass("respuestaError");
            mostrarFichaT(id);
        }
    
    })   
  
})
 /* codigo para mostrar ficha tecnica de producto */
function mostrarFichaT(id){
    $.ajax({
        data:{id},
        url: "../controller/mostrar_fichaTecnica.php",
        type: "post",
        datatype: "json",
        beforeSend: function () {},
        success: function (response) {    
            let datosRes = JSON.parse(response);
            datosRes.exito.forEach(recor => {				
                $("#ftec-tipoP").html(`${recor.tipo_fht}`);
                $(".ftec-modelP").html(`${recor.modelo_fht}`);
                $(".ftec-tamPantP").html(`${recor.tamPantalla_fht}`);
                $(".ftec-DefinicionP").html(`${recor.definiPantalla_fht}`);
                $(".ftec-resolPP").html(`${recor.resolPantalla_fht}`);
                $(".ftec-pantTactilP").html(`${recor.pantTactil_fht}`);
                $(".ftec-anchoP").html(`${recor.ancho_fht}`);
                $(".ftec-altoP").html(`${recor.alto_fht}`);
        });
       
        },
        error: function () {
            alert("error");
        },
        });
}
/* enlazo el icono de la imagen descripcion de productos con el input filr */
$(document).on('click', '.btnSubeImg1descripPro', function () {
    $('#imagen1DescripProducto').click();
})
/* previsualizar imagenes de la descripcion del producto antes de subirla */
$(document).on("change", "#imagen1DescripProducto", function () {
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#form-DescripcionProducto + img').remove();
            $('#acaFoto1DescripProducto').attr("src", e.target.result);
        };

        reader.readAsDataURL(this.files[0]);
    }
});
/* enlazo el icono de la imagen descripcion de productos con el input filr */
$(document).on('click', '.btnSubeImg2descripPro', function () {
    $('#imagen2DescripProducto').click();
})
/* previsualizar imagenes de la descripcion del producto antes de subirla */
$(document).on("change", "#imagen2DescripProducto", function () {
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#form-DescripcionProducto + img').remove();
            $('#acaFoto2DescripProducto').attr("src", e.target.result);
        };

        reader.readAsDataURL(this.files[0]);
    }
});
/* capturar id de producto */
$(document).on("click",".btnCargaDescrip",function(){
    /* capturo el id del producto luego cago la ficha tecnica y le envio el id */
    let element = $(this)[0].parentElement.parentElement;
    var id = $(element).attr('capturoid');    
    $(".ftbody").load("descripcion_producto.php",function(){
        mostrarDEscripcionPro(id);
        $("#txtidDescripPro").val(id);
        
    });   
})

/* CODIGO PARA MANDAR EL ID DE PRODUCTO A LA VENTANA MODAL de descripcion */
$(document).on("click",".btnEditFT",function(){
    let id= $("#txtidDescripPro").val();
     $("#txtidDescripProModal").val(id);  
    
 })

/* codigo para registrar descripcion de productos */
    $(document).on("click",".btnGuardarDescripP",function(e){
        e.preventDefault();
        var datos = new FormData($("#form-DescripcionProducto")[0]);
       let id= $("#txtidDescripProModal").val();
        $.ajax({
            url: "../controller/registroDescripcion_productos.php",
            data: datos,
            type: "POST",
            dataType: "json",
            contentType: false,
            processData: false
        }).done(function correcto(resp) {
            if (resp.error !== undefined) {
                return false;
            }
            if (resp.exito !== undefined) {
                $("#respuesta").addClass("respuestaOk").text(resp.exito+"✔").show(300).delay(2000).hide(300);              
                $("#respuesta").removeClass("respuestaError");
                mostrarDEscripcionPro(id);
                /* setTimeout("location.href='login.php'", 1000); */
            }
            
        })
    });
    setTimeout(function () {
        $(".respuestas").fadeOut(1500);
    }, 3000);
/* codigo para mostrar descripcion  de producto */
function mostrarDEscripcionPro(id){
    $.ajax({
        data:{id},
        url: "../controller/mostrarDescripcion_producto.php",
        type: "post",
        datatype: "json",
        beforeSend: function () {},
        success: function (response) { 
            let datosRes = JSON.parse(response);
            datosRes.exito.forEach(recor => {				
                $(".imagen1DescripPro").attr("src",`${recor.fotoUno_descripPro}`);
                $(".textoDescripcion").html(`${recor.descripcion_descriPro}`);
                $(".imagen2DescripPro").attr("src",`${recor.fotoDos_descripPro}`);
                
        });
       
        },
        error: function () {/* 
            alert("error"); */
        },
        });
}

