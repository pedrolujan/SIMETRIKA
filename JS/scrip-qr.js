import { urlProyect } from "./urlProyecto.js?hjhj";

// const asss=document.getElementById("contenedor");
const canvas = document.getElementById("canvas1");
const canvasAtras = document.getElementById("canvas2");
const ctx = canvas.getContext("2d");
const ctxAtras = canvasAtras.getContext("2d");
const image = new Image();
const imgQr = new Image();
var urlQr="";
$(document).ready(function () {
  
    // fnPintarCertificado(ctxAtras,image,"IMAGENES/certificados/certificado.png",imgQr,"IMAGENES/user.png",560,280);


})

$(document).on("click","#btnpasarqr",function(){
    console.log($("#mostrarQR").attr("src"));
    fnPintarCertificado(ctx, image, urlProyect+"IMAGENES/certificados/certificado.png", 0, 0, imgQr, "", 590, 280);
    fnPintarCertificado(ctxAtras, image, urlProyect+"IMAGENES/certificados/certificado.png", 0, 0, imgQr,$("#mostrarQR").attr("src"), 620, 280);
})
// var arrOk=new Array();
$(document).on("click", "#btnDescargar", function () {
    var imgData = canvas.toDataURL('image/png');
    var imgData1 = canvasAtras.toDataURL('image/png');

    var doc = new jsPDF('L', 'mm');

    const imgWidth = 285; 
    const imgHeight = canvas.height * imgWidth / canvas.width;
    // const contentDataURL = canvas.toDataURL('image/png');
    // const pdf = new jsPDF('p', 'mm', 'a4'); // A4 size page of PDF
    const position = 6;
    doc.addImage(imgData, 'PNG', 5, position, imgWidth, imgHeight);
    
    // doc.addImage(imgData, 'PNG', marginX, marginY, canvasWidth, canvasHeight);
    doc.addPage()
    doc.addImage(imgData1, 'PNG', 5, position, imgWidth, imgHeight);
    // doc.addImage(imgData1, 'PNG', marginX, marginY, canvasWidth, canvasHeight);


    // doc.addImage(imgData, 'PNG', 30, 15);
    // doc.addImage(imgData1, 'PNG', 30, 15);

    $hola=doc.save('Certificado.pdf');

    alert($hola);
    console.log($hola);
});


function fnPintarCertificado(ctx, image, imgsrc, xx, yy, qr, qrsrc, qrx, qry,) {
    image.src = "IMAGENES/certificados/certificado.png";
    image.src = imgsrc;
    ctx.drawImage(image, xx, yy, 750, 500);


    qr.src = qrsrc;
    ctx.drawImage(qr, qrx, qry, 100, 100);

    ctx.textAlign = "center";
    ctx.textBesaline = "middle"
    var x = canvas.width / 2;

    ctx.font = "16px Arial";
    ctx.fillText("Certifica a", x, 110)

    ctx.font = "40px Arial";
    ctx.fillText("Lujan Marcelo Pedro", x, 150)
    ctx.fillText("_______________________", x, 155)

    ctx.font = "16px Arial";
    ctx.fillText("por haber participado en la clase magistral", x, 200)

    ctx.font = "30px Arial";
    ctx.fillText("Modelamiento Bim Aplicado en infraestuctura", x, 240)
}








$(document).on("click", "#btnGenerar", function () {
    let datos = $("#txtUrl").val();
    let color = $("#txtColor").val();
    $.ajax({
        data: {
            datos,color
        },
        url: urlProyect+"controller/generadorQr.php",
        type: "post",
        beforeSend: function () {},
        success: function (resp) {  
            let spn=`<a href="${resp}">${resp}</a >`;
            let imag=`<img src="${resp}" alt="qr code" id="mostrarQR">`;     
            $("#contenQR").html(imag);
            $("#contenQRLabel").html(spn);
            console.log(imag);
        },
        
        error: function () {
            alert("error");
        }
    });
})
