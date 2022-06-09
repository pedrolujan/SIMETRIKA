// // const asss=document.getElementById("contenedor");
// const canvas = document.getElementById("canvas1");
// const canvasAtras = document.getElementById("canvas2");
// const ctx = canvas.getContext("2d");
// const ctxAtras = canvasAtras.getContext("2d");

// const imgQr = new Image();

// $(document).ready(function () {
//     var rr = canvas.hidden;
//     cargarcertificates();
//     // fnPintarCertificado(ctxAtras,image,"IMAGENES/certificados/certificado.png",imgQr,"IMAGENES/user.png",560,280);


// })
// function cargarcertificates(){
//     fnPintarCertificado(ctx, "IMAGENES/certificados/certificado.png", 0, 0, imgQr, "", 590, 280);
//     fnPintarCertificado(ctxAtras, "IMAGENES/certificados/certificado.png", 0, 0, imgQr, "IMAGENES/qr.png", 620, 280);
// }


// // var arrOk=new Array();
// $(document).on("click", "#btnDescargar", function () {
//     var imgData = canvas.toDataURL('image/png');
//     var imgData1 = canvasAtras.toDataURL('image/png');

//     var doc = new jsPDF('L', 'mm');

//     const imgWidth = 285; 
//     const imgHeight = canvas.height * imgWidth / canvas.width;
//     // const contentDataURL = canvas.toDataURL('image/png');
//     // const pdf = new jsPDF('p', 'mm', 'a4'); // A4 size page of PDF
//     const position = 6;
//     doc.addImage(imgData, 'PNG', 5, position, imgWidth, imgHeight);
    
//     // doc.addImage(imgData, 'PNG', marginX, marginY, canvasWidth, canvasHeight);
//     doc.addPage()
//     doc.addImage(imgData1, 'PNG', 5, position, imgWidth, imgHeight);
//     // doc.addImage(imgData1, 'PNG', marginX, marginY, canvasWidth, canvasHeight);


//     // doc.addImage(imgData, 'PNG', 30, 15);
//     // doc.addImage(imgData1, 'PNG', 30, 15);

//     $hola=doc.save('Certificado.pdf');

//     alert($hola);
//     console.log($hola);
// });


// function fnPintarCertificado(ctx, imgsrc, xx, yy, qr, qrsrc, qrx, qry,) {
//     // image.src = "IMAGENES/certificados/certificado.png";
//     const image = new Image();
//     image.src = imgsrc;
//     ctx.drawImage(image, xx, yy, 750, 500);


//     qr.src = qrsrc;
//     ctx.drawImage(qr, qrx, qry, 100, 100);

//     ctx.textAlign = "center";
//     ctx.textBesaline = "middle"
//     var x = canvas.width / 2;

//     ctx.font = "16px Arial";
//     ctx.fillText("Certifica a", x, 110)

//     ctx.font = "40px Arial";
//     ctx.fillText("Lujan Marcelo Pedro", x, 150)
//     ctx.fillText("_______________________", x, 155)

//     ctx.font = "16px Arial";
//     ctx.fillText("por haber participado en la clase magistral", x, 200)

//     ctx.font = "30px Arial";
//     ctx.fillText("Modelamiento Bim Aplicado en infraestuctura", x, 240)
// }
$(document).on("click","#btnDescargar",function(){
    let txtUrl=$("#txtUrl").val();
    $.ajax({
        data: {
            txtUrl
        },
        url: "pruebas1.php",
        type: "post",
        beforeSend: function () {},
        success: function (resp) {
            let r=`<a href="${resp}">${resp}</a>`;
          $("#contendebolver").html(r);
        },
        error: function () {
          alert("error al cargar entidad bancaria");
        },
      });
})
