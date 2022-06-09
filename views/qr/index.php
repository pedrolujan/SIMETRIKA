<?php
include("../../model/conexion.php");
include("../../model/url.php");
session_start();
$idUsuario = 0;
if (isset($_SESSION["adminLogeado"])) {
    $idUsuario = $_SESSION["adminLogeado"];
} elseif (isset($_SESSION["asistenteLogeado"])) {
    $idUsuario = $_SESSION["asistenteLogeado"];
} elseif (isset($_SESSION["supervisorLogeado"])) {
    $idUsuario = 0;
}
if ($idUsuario == 0) {
    header("Location:" . $urlProyecto);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR</title>
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilos_sideBar.css"> -->
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilos_header.css">
    <!-- <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilosProspecto_ifo.css"> -->

    <link rel="stylesheet" href="../../fontawesome/css/all.css">
    <link rel="stylesheet" href="../../fonts/line/line-awesome.min.css">
    <link rel="stylesheet" href="../../CSS/estilos_menu_navbar.css?kdg">
    <link rel="stylesheet" href="../../CSS/estilosLoader.css">

    <link rel="stylesheet" href="../../JS/modals/jquery.modal.min.css">
    <link rel="stylesheet" href="../../CSS/estilosVentanasModal.css">
    <link rel="stylesheet" href="../../CSS/pages/jPages.css">
    <link rel="stylesheet" href="../../CSS/pages/animate.css">

    <link rel="icon" href="../../IMAGENES/faviconn.png" type="image/png" />


</head>

<body>
    <?php
    include("../menu/menu_lateral.php");
    include("../header.php");
    include("../loader.php");

    include("../ventanas-modal.php");
    ?>
    <div class="main  col-12" id="main">

        <div class="col-12 d-flex">
            <div class="col-5">
                <label for="txtUrl"> Ingrese URL</label>
                <input type="text" class="form-control col-12" id="txtUrl"> <br>
            </div>
            <div class="col-7">
                <label for="txtColor">Elija El color</label><br>
                <input type="color" class="form-control col-3" name="txtColor" id="txtColor">
            </div>

        </div>
        <div class="col-12">

            <button id="btnGenerar" class="btn btn-info" style="background:#7B3090;">Generar QR</button>
            <button id="btnpasarqr" class="btn btn-info" style="background:#7B3090;">pasar QR</button>
        </div>
        <div class="col-12 mt-3 d-flex ">
            <div class="col-2" id="contenQR">


            </div>
            <div class="col-10" id="contenQRLabel">


            </div>
        </div>

        <div class="col-12 d-flex justify-content-center">

            <div class="text-center p-2 m-2" id="contenedor">
                <canvas id="canvas1" width="750px" height="700px">

                </canvas>
                <canvas id="canvas2" width="750px" height="700px">

                </canvas>
            </div>
        </div>
        <div class="col-12 p-3">
            <button id="btnDescargar" class="btn btn-outline-info "> descargar</button>
        </div>
        

    </div>

    <script src="<?php echo $urlProyecto ?>JS/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
    <script src="../../JS/pages/jPages.min.js"></script>
    <script src="../../JS/modals/jquery.modal.min.js"></script>
    <script src="<?php echo $urlProyecto ?>JS/scrip_general.js?gsd" type="module"></script>
    <script src="<?php echo $urlProyecto ?>JS/scrip-qr.js?gsd" type="module"></script>
</body>

</html>