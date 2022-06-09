<?php
include("../../../model/conexion.php");
include("../../../model/url.php");
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
    <title>SIA-CURSOS</title>
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
    include("../../menu/menu_lateral.php");
    include("../../header.php");
    include("../../loader.php");

    include("../../ventanas-modal.php");
    ?>
    <div class="main border-bottom" id="main">

        <div class="groupGeneral-sia p-0 m-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="SIA_Ev-group  d-block col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 d-sm-flex justify-content-between">
                <div class="conten-boton pl-5  col-12 col-xs-12 col-sm-5 col-md-5 col-lg-5">
                    <a href="#formulariosFiltrar" id="btn-SIA_A-buscarAlumno" class="mb-2 mb-lg-0 btnBuscarCliente btn col-xs-12 col-sm-12 col-md-12 col-lg-12" rel="modal:open">
                        <span class="fas fa-search"></span> Filtrar Curso
                    </a>
                </div>
                <div class="conten-boton pl-5 col-12 col-xs-12 col-sm-5 col-md-5 col-lg-5">
                    <a href="#formularioNuevoEvento" id="btn-SIA_A-buscarAlumno" class="btnBuscarCliente btn col-xs-12 col-sm-12 col-md-12 col-lg-12" rel="modal:open">
                        <span class="fas fa-plus text-center" ></span> Nuevo curso
                    </a>
                </div>
            </div>

        </div>
       
        <div class="mainContent table-responsive mt-4 col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <table id="tbEventos" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th class="pl-2 pr-2">Nro</th>
                        <th class="pl-5 pr-5">Curso</th>
                        <th class="pl-5 pr-5">Docente</th>
                        <th>Modalidad</th>
                        <th >Fecha Inicio</th>
                        <th>Fecha Final</th>
                        <th class="text-center">N° Alumnos</th>
                        <th>Estado</th>
                        <th>Accion:</th>

                    </tr>
                </thead>
                <tbody id="tbListarEventos">


                </tbody>
            </table>

            <a href="" class="cerrarModal" rel="modal:close"></a>
        </div>
    </div>

    <script src="<?php echo $urlProyecto ?>JS/jquery-3.5.1.min.js"></script>
    
    <script src="<?php echo $urlProyecto ?>JS/pages/jPages.min.js"></script>
    <script src="<?php echo $urlProyecto ?>JS/BOOTSTRAP/bootstrap.min.js"></script>
    <script src="../../../JS/BOOTSTRAP/popper.min.js"></script>
    <!-- datatables JS -->
    <script type="text/javascript" src="../../../DataTables/datatables.min.js"></script>
    <!-- para usar botones en datatables JS -->
    <script src="../../../DataTables/Buttons-1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="../../../DataTables/JSZip-2.5.0/jszip.min.js"></script>
    <script src="../../../DataTables/pdfmake-0.1.36/pdfmake.min.js"></script>
    <script src="../../../DataTables/pdfmake-0.1.36/vfs_fonts.js"></script>
    <script src="../../../DataTables/Buttons-1.7.1/js/buttons.html5.min.js"></script>
    
    <script src="<?php echo $urlProyecto ?>JS/modals/jquery.modal.min.js"></script>
    <script src="<?php echo $urlProyecto ?>JS/scripSIAEventos.js?gsd" type="module"></script>
    <script src="<?php echo $urlProyecto ?>JS/scrip_general.js?gsd" type="module"></script>
    <script src="<?php echo $urlProyecto ?>JS/scrip-SIA_AL.js?gsd" type="module"></script>
</body>

</html>