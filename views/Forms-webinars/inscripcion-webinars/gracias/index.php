<?php
$VarLinks48='<span class="DescripcionEvento text-left">Link 41<a href="https://zoom.us/j/94416439044"> https://zoom.us/j/94416439044</a> </span>';
$VarLinks49='<span class="DescripcionEvento text-left">Link 42<a href="https://zoom.us/j/94416439044"> https://zoom.us/j/94416439044</a> </span>';
$VarLinks50='<span class="DescripcionEvento text-left">Link 43<a href="https://zoom.us/j/94416439044"> https://zoom.us/j/94416439044</a> </span>';

$VarLinkCalendar48='<span class="DescripcionEvento text-left">Agregar al calendar Link <a href="https://bit.ly/3tsrktr"> https://bit.ly/3tsrktr</a> </span>';
$VarLinkCalendar49='<span class="DescripcionEvento text-left">Agregar al calendar Link <a href="https://bit.ly/3tsrktr"> https://bit.ly/3tsrktr</a> </span>';
$VarLinkCalendar50='<span class="DescripcionEvento text-left">Agregar al calendar Link <a href="https://bit.ly/3tsrktr"> https://bit.ly/3tsrktr</a> </span>';

$Descripcion48='<span class="DescripcionEvento text-left">  ✅Martes 27 de abril 8:00 p.m. (hora de Perú, México, Colombia) con el Ing. Mario Rodríguez y la clase magistral de  "El Concreto Prefabricado en Zonas de Alta Sismicidad" </span>';
$Descripcion49='<span class="DescripcionEvento text-left">  ✅Martes 27 de abril 8:00 p.m. (hora de Perú, México, Colombia) con el Ing. Mario Rodríguez y la clase magistral de  "El Concreto Prefabricado en Zonas de Alta Sismicidad" </span>';
$Descripcion50='<span class="DescripcionEvento text-left">  ✅Martes 27 de abril 8:00 p.m. (hora de Perú, México, Colombia) con el Ing. Mario Rodríguez y la clase magistral de  "El Concreto Prefabricado en Zonas de Alta Sismicidad" </span>';
include("../../../../model/url.php");




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
    <link rel="icon" href="<?php echo $urlProyecto ?>IMAGENES/faviconn.png" type="image/png" />
        <link rel="stylesheet" href="<?php echo $urlProyecto ?>fontawesome/css/all.css">
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
                       
                         
                        <?php
                            for ($i=0; $i < $_GET["size"]; $i++) { 
                            //    echo $VarLinks.;
                                if($_GET["idWeb".$i]==48){
                                    echo $Descripcion48;
                                    echo $VarLinks48;
                                    echo $VarLinkCalendar48;
                                    echo "</br>";
                                }
                                if($_GET["idWeb".$i]==49){
                                    echo $Descripcion49;
                                    echo $VarLinks49;
                                    echo $VarLinkCalendar49;
                                    echo "</br>";
                                }
                                if($_GET["idWeb".$i]==50){
                                    echo $Descripcion50;
                                    echo $VarLinks50;
                                    echo $VarLinkCalendar50;
                                    echo "</br>";
                                }
                            }
                            
                            

                        ?>
                        <!-- <span class="DescripcionEvento text-left">Link <a href="https://zoom.us/j/94416439044"> https://zoom.us/j/94416439044</a> </span> -->
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