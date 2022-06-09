<?php
session_start();
include("../../../../model/conexion.php");
include("../../../../model/url.php");
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
    <title>SIA/ALUMNOS</title>
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilos_sideBar.css"> -->
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilos_header.css">
    <!-- <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilosProspecto_ifo.css"> -->
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilosEventos.css?ort">

    <link rel="stylesheet" href="<?php echo $urlProyecto ?>fontawesome/css/all.css">
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>fonts/line/line-awesome.min.css">
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>fonts/style.css">
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>fonts/fonts/style.css">

    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilos_menu_navbar.css?kdg">
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilosLoader.css">
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilosContextMenu.css">

    <link rel="stylesheet" href="<?php echo $urlProyecto ?>JS/modals/jquery.modal.min.css">
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilosVentanasModal.css">
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilosTabla.css">
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/pages/jPages.css">
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/pages/animate.css">

    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilos-header-busqueda.css">
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilosLoader.css">

    <link rel="stylesheet" href="../../../../DataTables/datatables.min.css">
    <!--datables estilo bootstrap 4 CSS-->
    <link rel="stylesheet" type="text/css" href="../../../../DataTables/DataTables-1.10.25/css/dataTables.bootstrap4.min.css">

    <link rel="icon" href="<?php echo $urlProyecto ?>IMAGENES/faviconn.png" type="image/png" />
    <style>
        input[type=number]::-webkit-outer-spin-button,

        input[type=number]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>

</head>

<body>
    <?php
    include("../../../menu/menu_lateral.php");
    include("../../../header.php");
    include("../../../loader.php");
    include("../../../context-menu.php");

    include("../../../ventanas-modal.php");
    ?>
    <div class="main pb-5">
        <input type="text" name="txtCodEvento" id="txtCodEvento" value="<?php echo base64_decode($_GET["codeenvent"]); ?>">
        
        <div class="tabcontent m-0 p-0 col-xs-12 col-sm-12 col-md-12 col-lg-12" id="mainVentas">
            <div class="col-12  m-auto pt-3 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="ContenedorBuscarVentas contenedorDatosEvento  col-xs-12 col-sm-12 col-md-12 col-lg-12  p-2 d-md-flex justify-content-left align-items-center">

                </div>
<img src="" width="40" alt="" srcset="">
                <div class="mainContent table-responsive mt-4 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <table id="example" class="dataTable table">
                        <thead>
                            <tr>
                                <th class="col-1">Nro:</th>
                                <!-- <th>Codigo:</th> -->
                                <th class="col-4">Curso:</th>
                                <!-- <th class="col-3">Fecha.venta:</th> -->
                                <th class="col-2">Dieño frontal</th>
                                <th class="col-2">Dieño Posterior</th>
                                <th class="col-1">Acciones:</th>
                            </tr>
                        </thead>
                        <tbody id="tbListarTemplante">

                        </tbody>
                    </table>
                    <?php include("../../loader.php"); ?>
                    <a href="" class="cerrarModal" rel="modal:close"></a>
                </div>
            </div>
        </div>
    </div>
    <a href="" id="btnCerrarModal" rel="modal:close"></a>
    <script src="<?php echo $urlProyecto ?>JS/jquery-3.5.1.min.js"></script>

    <script src="<?php echo $urlProyecto ?>JS/pages/jPages.min.js"></script>
    <script src="<?php echo $urlProyecto ?>JS/BOOTSTRAP/bootstrap.min.js"></script>
    <script src="../../../../JS/BOOTSTRAP/popper.min.js"></script>
    <!-- datatables JS -->
    <script type="text/javascript" src="../../../../DataTables/datatables.min.js"></script>
    <!-- para usar botones en datatables JS -->
    <script src="../../../../DataTables/Buttons-1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="../../../../DataTables/JSZip-2.5.0/jszip.min.js"></script>
    <script src="../../../../DataTables/pdfmake-0.1.36/pdfmake.min.js"></script>
    <script src="../../../../DataTables/pdfmake-0.1.36/vfs_fonts.js"></script>
    <script src="../../../../DataTables/Buttons-1.7.1/js/buttons.html5.min.js"></script>

    <script src="<?php echo $urlProyecto ?>JS/modals/jquery.modal.min.js"></script>
    <script src="<?php echo $urlProyecto ?>JS/scripDetailsEventos.js?gsd" type="module"></script>
    <!-- <script src="<?php echo $urlProyecto ?>JS/scripSIAEventos.js?gsd" type="module"></script> -->
    <script src="<?php echo $urlProyecto ?>JS/scrip_general.js?gsd" type="module"></script>
    <script src="<?php echo $urlProyecto ?>JS/scrip-SIA_AL.js?gsd" type="module"></script>
</body>

</html>