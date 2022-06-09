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
        .btn{
            color:#7B3090 ;
            border: solid 1px #7B3090;
        }
        .btn:hover{
            background:#7B3090 ;
             border: solid 1px #7B3090;
             color: #fff;
        }
        .btn:active {
            background:#7B3090 ;
            border: solid 1px #7B3090;
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
                    
                   <form action="#" class="contenedor_Registro" id="contenedor_Registro" method="post">
                        <input tipe="hidden"  class="d-none"   name="wj_lead_email" id="wj_lead_email" value="<?php echo $_GET["wj_lead_email"]; ?>"/>
                        <input tipe="hidden" class="d-none"  name="wj_lead_first_name" id="wj_lead_first_name" value="<?php echo $_GET["wj_lead_first_name"]; ?>"/>
                        <input tipe="hidden" class="d-none"  name="wj_lead_unique_link_live_room" id="wj_lead_unique_link_live_room" value="<?php echo $_GET["wj_lead_unique_link_live_room"]; ?>"/>
                        <input tipe="hidden" class="d-none"  name="wj_lead_last_name" id="wj_lead_last_name" value="<?php echo $_GET["wj_lead_last_name"]; ?>"/>
                        <input tipe="hidden"  class="d-none" name="wj_lead_phone_number" id="wj_lead_phone_number" value="<?php echo $_GET["wj_lead_phone_number"]; ?>"/>
                        <input tipe="hidden" class="d-none"  name="wj_lead_phone_country_code" id="wj_lead_phone_country_code" value="<?php echo $_GET["wj_lead_phone_country_code"]; ?>"/>
                        <input tipe="hidden" class="d-none"  name="txtIdCurso" id="txtIdCurso" value="<?php echo $_GET["txtIdCurso"]; ?>"/>
                         <input tipe="hidden" class="d-none"  name="wj_lead_id_List" id="wj_lead_id_List" value="<?php echo $_GET["wj_lead_id_List"]; ?>"/>
                         <input tipe="hidden" class="d-none"  name="txtIdCampania" id="txtIdCampania" value="<?php echo $_GET["txtIdCampania"]; ?>"/>

                    </form>
                        <h2 class="titulo_evento text-center" style="font-size:28px;">¡ Gracias por inscribirte! 📃🤩</h2>
                        <span class="DescripcionEvento"></span>

                        <span class="DescripcionEvento text-center" style="font-size:17px;">recibirás un correo de confirmación. Para conectarte en vivo a la clase magistral, sigue el siguiente enlace:.  </span>
                        <span class="DescripcionEvento text-center ">
                        <a class="d-none btn primary" href="https://calendar.google.com/calendar/render?action=TEMPLATE&text=Evoluci%C3%B3n+de+Elementos+Finitos+en+el+An%C3%A1lisis+y+Dise%C3%B1o+Estructural&dates=20210505T170000Z/20210505T180000Z&details=Webinar:+Evoluci%C3%B3n+de+Elementos+Finitos+en+el+An%C3%A1lisis+y+Dise%C3%B1o+Estructural%0ADescription:+Evoluci%C3%B3n+del+M%C3%A9todo+de+Elementos+Finitos+en+el+An%C3%A1lisis+y+Dise%C3%B1o+Estructural+Asistido+por+Computadora%0AHost(s):+Jose+Velasquez%0AWebinar%20link:+https%3A%2F%2Fevent.webinarjam.com%2Fgo%2Flive%2F2%2Fogm1mfminnan7svr&recur=&location=&trp=false&sprop=name:name:Jose+Velasquez"> Agregar al calendario.📆 </a>
                        <br>
                         <a class="btn primary" href="<?php echo $_GET["wj_lead_unique_link_live_room"] ?>">Conectate a la clase magistral desde aqui.💻 📱</a> </span>
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
<script src="<?php echo $urlProyecto ?>JS/jquery-3.5.1.min.js"></script>
<script src="../jscrip/registrowebinar.js?dfsd" type="module"></script>

</html>