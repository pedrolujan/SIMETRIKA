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
    <link rel="icon" href="../../../IMAGENES/faviconn.png" type="image/png" />
        <link rel="stylesheet" href="../../../fontawesome/css/all.css">
        <style>
        .fa-whatsapp-square{
            color: #28C34C; 
            margin-left:5px; 
            font-size:40px;
        }
        .fa-whatsapp-square:hover{
            font-size:50px;
        }
        </style>

</head>

<body class="">
    <div class="contenedorProspecto col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex pb-5">

        <div class="contenedorFormProspecto col-xs-12 col-sm-12 col-md-9 col-lg-6  m-auto">
            <form action="#" class="contenedor_formulario" id="contenedor_formulario" method="post">
                <div class="row">
                    <div class="col-xs-12  col-sm-12 col-md-12 col-lg-12 contenGeneralImg">
                        <div class="form-group contenImg">
                            <img src="<?php echo $urlProyecto ?>IMAGENES/banner.JPG" />
                        </div>
                    </div>
                </div>


                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 contenGeneralInfo">
                    <div class="form-group contenInfoEvento">
                        <h2 class="titulo_evento text-center" style="font-size:28px;">¡ Gracias por inscribirte! 📃🤩</h2>
                        <span class="DescripcionEvento"></span>

                        <span class="DescripcionEvento text-center" style="font-size:17px;">recibirás un correo de confirmación. Para conectarte en vivo a los talleres, sigue el siguiente enlace:.  </span>
                        <span class="DescripcionEvento text-left"> ✅Viernes 30 de abril 8:00 p.m. (hora de Perú, México, Colombia) con el Ing. Renzo Rios Rugel y la clase magistral de  "Evolución del BIM en la Industria de la Construcción" </span>
                         <span class="DescripcionEvento text-left">Link <a href="https://zoom.us/j/99893977409"> https://zoom.us/j/99893977409</a> </span>
                         <!--<span class="DescripcionEvento text-left">Agregar al calendar Link <a href="https://bit.ly/3tsrktr"> https://bit.ly/3tsrktr</a> </span>-->
                        <br>
                            
                        <span class="DescripcionEvento text-center" style="color: #3C7CBC; font-size:16px;">
                            Si tienes alguna otra inquietud                               
                             envia un coreo a                          
                              <h6 class="text-center font-weight-bold" style="color: #7B3090; margin-top:5px;"> hola@simetrika.pe </h6>.
                              
                              o escribenos al WhatsApp <h6 class="text-center font-weight-bold" style="color: #7B3090; margin-top:5px;">+51 943 373 300</br><a href="https://api.whatsapp.com/send?phone=51943373300&text=Hola%20Simetrika"><span class="fab fa-whatsapp-square"></span> </a></h6></span>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>