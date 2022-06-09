<?php
session_start();
include("../../../model/conexion.php");
include("../../../model/url.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIA</title>
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilos_sideBar.css"> -->
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilos_header.css">
    <!-- <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilosProspecto_ifo.css"> -->
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilosCertificates.css?ort">

    <link rel="stylesheet" href="<?php echo $urlProyecto ?>fontawesome/css/all.css">
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>fonts/line/line-awesome.min.css">
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>fonts/style.css">
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>fonts/fonts/style.css">

    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilos_menu_navbar.css?kdg">
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilosLoader.css">
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilosContextMenu.css">

    <link rel="stylesheet" href="<?php echo $urlProyecto ?>JS/modals/jquery.modal.min.css">
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilosVentanasModal.css">
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/pages/jPages.css">
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/pages/animate.css">

    <link rel="stylesheet" href="../../../DataTables/datatables.min.css">
    <!--datables estilo bootstrap 4 CSS-->
    <link rel="stylesheet" type="text/css" href="../../../DataTables/DataTables-1.10.25/css/dataTables.bootstrap4.min.css">

    <link rel="icon" href="<?php echo $urlProyecto ?>IMAGENES/faviconn.png" type="image/png" />


</head>

<body>
    <?php

    if (!(isset($_SESSION['adminLogeado']) || isset($_SESSION["supervisorLogeado"]) || isset($_SESSION["asistenteLogeado"]))) {
    } else {
        include("../../menu/menu_lateral.php");
        include("../../header.php");
    }

    include("../../loader.php");
    include("../../context-menu.php");

    include("../../ventanas-modal.php");
    if (!(isset($_SESSION['adminLogeado']) || isset($_SESSION["supervisorLogeado"]) || isset($_SESSION["asistenteLogeado"]))) { ?>
        <div class="main m-0 w-100 border-bottom" id="main" style="background-color: #525659;">
            <div class="addFixedherder col-12 p-3 d-lg-flex align-items-center justify-content-between">
                <h5 class="bg-warning text-danger p-2 col-lg-8"> Si no aparecen tus datos porfavor actualizar la pagina</h5>
                <button id="btnDescargar" class="btn col-12 col-lg-2 btn-outline-danger p-3 fas fa-file-pdf "> Descargar Certificado</button>
            </div>
            <div class="contenedorLienzo overflow-auto col-12 d-flex justify-content-center">
        <?php
    } else {
        ?>

            <div class="main border-bottom" id="main">
                <div class="col-11 p-3 d-lg-flex align-items-center justify-content-between">
                    <div class="bg-warning text-danger text-uppercase p-2 col-12 col-md-7"> Si no Cargan sus datos porfavor actualizar la pagina</div>
                    <button id="btnDescargar" class="btn mt-2 mt-md-0 col-12 col-md-3 btn-outline-danger p-3 fas fa-file-pdf "> Descargar Certificado</button>
                </div>
                <div class="col-12 overflow-auto d-flex justify-content-center">
            <?php } ?>

                <div class="text-center overflow-auto p-2 m-2" id="contenedor">
                    <canvas id="canvas1Mostrar" width="750px" height="500px">

                    </canvas>
                    <canvas id="canvas2Mostrar" width="750px" height="500px">

                    </canvas>
                    <canvas id="canvas1" class="d-none" width="2368px" height="1674px">

                    </canvas>
                    <canvas id="canvas2" class="d-none" width="2368px" height="1674px">

                    </canvas>
                </div>
            </div>
            <input type="hidden" name="txtCodCliente" id="txtCodCliente" value="<?php echo base64_decode($_GET["identifiercustomer"]) ?> ">
            <input type="hidden" name="txtCodEvento" id="txtCodEvento" value="<?php echo base64_decode($_GET["identifierevent"]) ?> ">
            <input type="hidden" name="txtIdCurso" id="txtIdCurso" value="<?php echo base64_decode($_GET["identifiercourse"]) ?> ">

            <button id="btnpasarqr" class="d-none">pasar qr</button>
            <div id="contenCargarQr">
            </div>


            </div>
            <a href="" id="btnCerrarModal" rel="modal:close"></a>

            <script src="<?php echo $urlProyecto ?>JS/jquery-3.5.1.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
            <script src="<?php echo $urlProyecto ?>JS/pages/jPages.min.js"></script>
            <script src="<?php echo $urlProyecto ?>JS/modals/jquery.modal.min.js"></script>
            <!-- <script src="<?php echo $urlProyecto ?>JS/scripSIAEventos.js?gsd" type="module"></script> -->
            <script src="<?php echo $urlProyecto ?>JS/scrip_general.js?gsd" type="module"></script>
            <script src="<?php echo $urlProyecto ?>JS/scripSIACertificados.js?gsd" type="module"></script>
</body>

</html>