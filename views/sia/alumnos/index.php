<?php
session_start();
include("../../../model/conexion.php");
include("../../../model/url.php");
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
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/pages/jPages.css">
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/pages/animate.css">

    <link rel="stylesheet" href="../../../DataTables/datatables.min.css">
    <!--datables estilo bootstrap 4 CSS-->
    <link rel="stylesheet" type="text/css" href="../../../DataTables/DataTables-1.10.25/css/dataTables.bootstrap4.min.css">

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
    include("../../menu/menu_lateral.php");
    include("../../header.php");
    include("../../loader.php");
    include("../../context-menu.php");

    include("../../ventanas-modal.php");
    ?>
    <div class="main border-bottom" id="main">
        <input type="hidden" id="txtCodigoCurso" value="<?php echo $_POST["postCodClase"] ?>">
        <div class="groupGeneral-sia p-0 m-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="SIA_Ev-group  d-block col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 d-lg-flex justify-content-between">
                <div class="conten-boton pl-5  col-12 col-xs-12 col-sm-12 col-md-5 col-lg-5">
                    <a href="#formulariosFiltrar" id="btn-SIA_A-buscarAlumno" class=" btnBuscarCliente btn col-xs-12 col-sm-12 col-md-12 col-lg-12" rel="modal:open">
                        <span class="fas fa-sort-amount-down-alt"></span> Filtrar Alumnos
                    </a>
                </div>
                <div class="conten-boton pl-5 col-12 col-xs-12 col-sm-12 col-md-5 col-lg-5">
                    <a href="#formulariosBuscarEventoClase" id="btn-SIA_A-busCursos" class="btnBuscarCliente btn col-xs-12 col-sm-12 col-md-12 col-lg-12" rel="modal:open">
                        <span class="fas fa-search text-center"></span> Buscar Curso
                    </a>
                </div>
            </div>

        </div>
        <div class="groupGeneral-sia p-0  col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="contenedorDatosCurso mt-3 mb-3  d-block col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12  justify-content-center">

            </div>

        </div>
        <form action="#" id="FormularioNotas" class="responsive" method="post">
            <div id="contenedorAlumnosXCursos" class="mainContent table-responsive mt-4 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <input type="hidden" name="txtidListaSend" id="txtidListaSend">
                <input type="hidden" name="txtCodEvento" id="txtCodEvento">
                <input type="hidden" name="txtTotalAlumnos" id="txtTotalAlumnos">
                <input type="hidden" name="txtidCurso" id="txtidCurso" >
                <table id="tbAlumnosXCurso" class="table table-striped  table-bordered">
                    <thead>
                        <tr>
                            <th  class="col-1">Código</th>
                            <!-- <th class="d-none">CodAlumno</th> -->
                            <th class="col-3 pl-2 pr-5">Alumno</th>
                            <th class="col-2">Progreso</th>
                            <th class="col-1">Nota.1</th>
                            <th class="col-1">Nota.2</th>
                            <th class="col-1">Nota.3</th>
                            <th class="col-1">Promedio</th>
                            <th class="col-2 colLinkCertificado pl-3 pr-5">link de certificado</th>


                        </tr>
                    </thead>
                    <tbody id="tbLAlumnosXcursos">


                    </tbody>
                </table>

            </div>
        </form>
    </div>
    <a href="" id="btnCerrarModal" rel="modal:close"></a>
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
    <script src="<?php echo $urlProyecto ?>JS/scripSIAAlumnos.js?gsd" type="module"></script>
    <!-- <script src="<?php echo $urlProyecto ?>JS/scripSIAEventos.js?gsd" type="module"></script> -->
    <script src="<?php echo $urlProyecto ?>JS/scrip_general.js?gsd" type="module"></script>
    <script src="<?php echo $urlProyecto ?>JS/scrip-SIA_AL.js?gsd" type="module"></script>
</body>

</html>