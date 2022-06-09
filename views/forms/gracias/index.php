<?php
include("../../../model/url.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gracias</title>
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilos_formProspecto.css">

</head>

<body class="">
    <div class="contenedorProspecto col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex">

        <div class="contenedorFormProspecto col-xs-12 col-sm-12 col-md-9 col-lg-6  m-auto">
            <form action="#" class="contenedor_formulario" id="contenedor_formulario" method="post">
                <div class="row">
                    <div class="col-xs-12  col-sm-12 col-md-12 col-lg-12 contenGeneralImg">
                        <div class="form-group contenImg">
                            <img src="<?php echo $urlProyecto ?>IMAGENES/header_form.png" />
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 contenGeneralInfo">
                    <div class="form-group contenInfoEvento">
                        <h2 class="titulo_evento">¡ Gracias por inscribirte !</h2>
                        <span class="DescripcionEvento">recibirás un correo de confirmación. Para conectarte en vivo a los talleres, sigue los siguientes enlaces:</span>

                        <span class="DescripcionEvento">✅Miércoles 03 de marzo 8:00 p.m. (hora de Perú, México, Colombia)
                            con el Ing. Mario Roberto Olortegui Iglesias y el Taller "Dibujo Técnico Especializado en 2D y 3D asistido por AutoCAD 2021"

                            Link:<a href="https://zoom.us/j/98131324528"> https://zoom.us/j/98131324528</a> </span>
                        <br> <span class="DescripcionEvento">✅Viernes 05 de marzo 8:00 p.m. (hora de Perú, México, Colombia)
                            con el Ing. Manuel Francisco Gutarra Vela y el Taller "Rutinas LISP en AutoCAD para Bloques Dinámicos e Integración con Excel"

                            Link:<a href="https://zoom.us/j/91579025370"> https://zoom.us/j/91579025370</a></span>
                        <span class="DescripcionEvento text-center">
                            Si tienes alguna otra inquietud
                            envía un correo a hola@simetrika.pe o al WhatsApp +51 943 373 300.</span>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>