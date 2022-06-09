import { urlProyect } from "./urlProyecto.js?hjhj";
import { fnCargarLoader } from "./urlProyecto.js?hjhj";

// const asss=document.getElementById("contenedor");
const canvas = document.getElementById("canvas1");
const canvasAtras = document.getElementById("canvas2");

const canvasMostrar = document.getElementById("canvas1Mostrar");
const canvasAtrasMostrar = document.getElementById("canvas2Mostrar");

const ctx = canvas.getContext("2d");
const ctxAtras = canvasAtras.getContext("2d");

const ctxMostrar = canvasMostrar.getContext("2d");
const ctxAtrasMostrar = canvasAtrasMostrar.getContext("2d");

const image = new Image();
const image1 = new Image();

const imageMostrar = new Image();
const image1Mostrar = new Image();

const imgQr = new Image();
const imgQrMostar = new Image();

var imgData = "";
var imgData1 = "";

var doc = new jsPDF('L', 'mm','a4');

var  NombreAlumno="";
    
var urlQr=encodeURIComponent(location.href);
var imagenDirecta="";
let ImagenQr=`<img class="d-none" id="cargarImagen" src="http://api.qrserver.com/v1/create-qr-code/?color=000000&amp;bgcolor=FFFFFF&amp;data=${urlQr}&amp;qzone=1&amp;margin=0&amp;size=400x400&amp;ecc=L" alt="qr code" />`;    
let estado=false;

$("#contenCargarQr").html(ImagenQr);
fnBuscarCerificadoXAlumno();
$(document).ready(function() {
    // fnBuscarCerificadoXAlumno();
    fnCargarLoader("block");
    imagenDirecta= $("#cargarImagen").attr("src");
    imgQr.src =imagenDirecta
    imgQrMostar.src =imagenDirecta
    // fnBuscarCerificadoXAlumno();
    setTimeout(function () {
        $("#btnpasarqr").click();  
    }, 1000);
        // $("#btnpasarqr").click();  
    
           
});

function fnBuscarCerificadoXAlumno(){
    let codCliente= $.trim($("#txtCodCliente").val());
    let codEvento= $.trim($("#txtCodEvento").val());
    let idCurso= $.trim($("#txtIdCurso").val());
    let BusquedaCertificadoXAlumno = "ok";
  $.ajax({
    data: {
      codCliente,
      codEvento,
      idCurso,
      BusquedaCertificadoXAlumno
    },
    url: urlProyect + "controller/ejecutar_procedimientos.php",
    type: "post",
    beforeSend: function () {},
    success: function (resp) {
        let datos = JSON.parse(resp);
        let sumaXgeneral=0;
        let posYNombre=180;
        let posYDesdeHasta=146;
        let posYCodCerticicado=20;

        let xqr=1900;
        let yqr=1210;
        let wqr=350;
        let hqr=350;
        let nota=19;
        let notax=415;
        let notay=1537;
        // console.log(datos);
        datos.forEach(element => {
            // canvas para pdf
            NombreAlumno=element.nombresCliente;
            fnPintarCertificadoFrontal(
                element.certificadoFrontal,
                element.nombresCliente,
                element.fechaDeCurso,
                element.codCursoCertificado,
                zfill(element.idSecuencia,3),
                sumaXgeneral,
                posYNombre+410,
                posYDesdeHasta+350,
                posYCodCerticicado+50);

            fnPintarCertificadoPost(
                urlProyect+element.certificadoPosterior,
                xqr,yqr,wqr,hqr,element.promedio??0,notax,notay);

            fnPintarCertificadoFrontalMost(
                element.certificadoFrontal,
                element.nombresCliente,
                element.fechaDeCurso,
                element.codCursoCertificado,
                zfill(element.idSecuencia,3),
                sumaXgeneral,
                posYNombre,
                posYDesdeHasta,
                posYCodCerticicado
                );

            fnPintarCertificadoPostMost(
                urlProyect+element.certificadoPosterior,
                xqr-1295,yqr-853,wqr-237,hqr-237,element.promedio??0,notax-283,notay-1079);
            
           
            // canvas para mostrar           
            
                setTimeout(function () {
         
                fnCargarLoader("none");
                }, 15000);
            
            
        });

    },
    error: function () {
      alert("error al cargar certificados");
    },
  });
}

function zfill(number, width) {
    var numberOutput = Math.abs(number); /* Valor absoluto del número */
    var length = number.toString().length; /* Largo del número */ 
    var zero = "0"; /* String de cero */  
    
    if (width <= length) {
        if (number < 0) {
             return ("-" + numberOutput.toString()); 
        } else {
             return numberOutput.toString(); 
        }
    } else {
        if (number < 0) {
            return ("-" + (zero.repeat(width - length)) + numberOutput.toString()); 
        } else {
            return ((zero.repeat(width - length)) + numberOutput.toString()); 
        }
    }
}
$(document).on("click","#btnpasarqr",function(){
    // fnBuscarCerificadoXAlumno();
   
    imgQr.src =imagenDirecta
    imgQrMostar.src =imagenDirecta
})
// var arrOk=new Array();
$(document).on("click", "#btnDescargar", function () {
    fnCargarLoader("block");

    imgData = canvas.toDataURL('image/png');
    imgData1 = canvasAtras.toDataURL('image/png');
    const imgWidth = 297; 
    const imgHeight = canvas.height * imgWidth / canvas.width;
    const position = 0;

    setTimeout(function () {
        fnCargarLoader("block");
        doc.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
       doc.addPage()
    doc.addImage(imgData1, 'png', 0, position, imgWidth, imgHeight);
    doc.internal.scaleFactor = 1.33;

    doc.save(`${NombreAlumno}.pdf`);
}, 10);
setTimeout(function () {
   
    fnCargarLoader("none");
}, 3200);
    
   
    // fnCargarLoader("none");
});


function fnPintarCertificadoFrontal(imagesrc,Alumno,fechas,codCertificado,codAlum,xplus,yyA,yyR,yyCodC) {
    // image.src = "IMAGENES/certificados/certificado.png";
    image.src = urlProyect+imagesrc;
    image.addEventListener("load",function(){
        fnPintarImagenEnPapel(xplus,Alumno,yyA,fechas,yyR,codCertificado,codAlum,yyCodC);
    })
   
    
    

}
function fnPintarCertificadoPost(imgsrc,xqr,yqr,wqr,hqr,nota,xnota,ynota) {
    // image.src = "IMAGENES/certificados/certificado.png";
    image1.src = imgsrc;
    image1.addEventListener("load",fnPintarImagenEnPapelAtras)
    
    // imgQr.src =imagenDirecta
    // qr.src =""
    imgQr.crossOrigin = 'Anonymous'
    imgQr.addEventListener("load",function(){
        fnPintarQREnPapelAtras(xqr,yqr,wqr,hqr,nota,xnota,ynota);
    })
   

   

}

function fnPintarCertificadoFrontalMost(imagesrc,Alumno,fechas,codCertificado,codAlum,sumaXgeneral,posYNombre,posYDesdeHasta,posYCodCerticicado) {
    // image.src = "IMAGENES/certificados/certificado.png";
    imageMostrar.src = urlProyect+imagesrc;
    imageMostrar.addEventListener("load",function(){
        fnPintarImagenEnPapelMost(sumaXgeneral,Alumno,posYNombre,fechas,posYDesdeHasta,codCertificado,codAlum,posYCodCerticicado);
    })

    
    

}
function fnPintarCertificadoPostMost(imgsrc,xqr,yqr,wqr,hqr,nota,notax,notay) {
    // image.src = "IMAGENES/certificados/certificado.png";
    image1Mostrar.src = imgsrc;
    

    image1Mostrar.addEventListener("load",fnPintarImagenEnPapelAtrasMost)
    
    // imgQrMostar.src =imagenDirecta
    // qr.src =""
    imgQrMostar.crossOrigin = 'Anonymous'
    imgQrMostar.addEventListener("load",function(){

     fnPintarQREnPapelAtrasMost(xqr,yqr,wqr,hqr,nota,notax,notay)
    })

    // qr.src =imagenDirecta
    // // qr.src =""
    // qr.crossOrigin = 'Anonymous'
    // ctx.drawImage(qr, qrx, qry, 130, 130);

    

}

function fnPintarImagenEnPapel(xplus,Alumno,yyA,fechas,yyR,codCertificado,codAlum,yyCodC){
    ctx.drawImage(image, 0, 0, 2368, 1674);
    ctx.textAlign = "center";
    ctx.textBesaline = "middle";
    var x = (canvas.width / 2)+xplus;
    // setTimeout(function () {

    ctx.font = "90px Arial";
    ctx.fillText(Alumno, x, yyA);

    // ctx.fillStyle = "black";
    ctx.font = "53px Arial";
    ctx.fillText(`${fechas}`, x, yyA+yyR);

    ctx.font = "48px Arial";
    ctx.fillText(`Codigo del certificado: `+codCertificado+`-`+codAlum, x, (yyA+yyR)+yyCodC);
         
    // }, 100);
}
function fnPintarImagenEnPapelAtras(){
    ctxAtras.drawImage(image1, 0, 0, 2368, 1674);
}


function fnPintarQREnPapelAtras(xqr,yqr,wqr,hqr,nota,xnota,ynota){
    ctxAtras.drawImage(imgQr, xqr, yqr, wqr, hqr);
    ctxAtras.textAlign = "center";
    ctxAtras.textBesaline = "middle";
    ctxAtras.font = "47px Arial";
    ctxAtras.fillText(`${nota}`, xnota, ynota);
}

function fnPintarImagenEnPapelMost(sumaXgeneral,Alumno,posYNombre,fechas,posYDesdeHasta,codCertificado,codAlum,posYCodCerticicado){
    ctxMostrar.drawImage(imageMostrar, 0, 0, 750, 500);

    ctxMostrar.textAlign = "center";
    ctxMostrar.textBesaline = "middle";
    var x = (canvasMostrar.width / 2)+sumaXgeneral;
    // setTimeout(function () {

        ctxMostrar.font = "30px Arial";
        ctxMostrar.fillText(Alumno, x, posYNombre);

        // ctxMostrar.fillStyle = "black";
        ctxMostrar.font = "17px Arial";
        ctxMostrar.fillText(`${fechas}`, x, posYNombre+posYDesdeHasta);

        ctxMostrar.font = "16px Arial";
        ctxMostrar.fillText("Código del certificado: "+codCertificado+"-"+codAlum, x,(posYNombre+posYDesdeHasta) +posYCodCerticicado);
         
    // }, 1000);
}

function fnPintarImagenEnPapelAtrasMost(){
    ctxAtrasMostrar.drawImage(image1Mostrar, 0, 0, 750, 500);
}

function fnPintarQREnPapelAtrasMost(xqr,yqr,wqr,hqr,nota,notax,notay){
    ctxAtrasMostrar.drawImage(imgQrMostar, xqr, yqr, wqr, hqr);

    ctxAtrasMostrar.textAlign = "center";
    ctxAtrasMostrar.textBesaline = "middle";

    ctxAtrasMostrar.font = "14px Arial";
    ctxAtrasMostrar.fillText(`${nota}`, notax, notay);
}






