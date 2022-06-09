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
    $idUsuario = $_SESSION["supervisorLogeado"];
} else {
    $idUsuario = 0;
}
if ($idUsuario == 0) {
    header("Location:" . $urlProyecto);
}
$con = new ApptivaDB();
$sql = $con->buscarFech(
    "pros_nombres,pros_apellidos,pros_email,pros_telefono,Nombre_pais",
    "prospectos 
 INNER JOIN pais on pais.Codigo=prospectos.ID_PAIS",
    "prospectos.idProspecto='" . $_POST["txtidProspecto"] . "'"
);

$datos = mysqli_fetch_array($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta Ventas</title>
    <link rel="stylesheet" href="../../../CSS/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilos_sideBar.css"> -->
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilos_header.css">
    <!-- <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilosProspecto_ifo.css"> -->
    <!-- <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilosTabla.css"> -->
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>fontawesome/css/all.css">
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>fonts/style.css">
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>fonts/azome/fontAsome.js">
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>fonts/fonts/style.css">
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>fonts/line/line-awesome.min.css">
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilos_menu_navbar.css">
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>JS/modals/jquery.modal.min.css">
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/pages/jPages.css">
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/pages/animate.css">
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilos-header-busqueda.css">
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilosLoader.css">
    
    <link rel="stylesheet" href="../../../DataTables/datatables.min.css">
    <!--datables estilo bootstrap 4 CSS-->
    <link rel="stylesheet" type="text/css" href="../../../DataTables/DataTables-1.10.25/css/dataTables.bootstrap4.min.css">
    <link rel="icon" href="<?php echo $urlProyecto ?>IMAGENES/faviconn.png" type="image/png" />
    <!-- <script src="<?php echo $urlProyecto ?>JS/pages/jPages.min.js"></script> -->
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilosVentanasModal.css">
</head>

<body>

    <?php
    include("../../menu/menu_lateral.php");
    require_once("../../ventanas-modal.php");
    include("../../header.php");
    ?>
arial 16 cursiva
    <div class="main pb-5">
        <div class="tabcontent col-xs-12 col-sm-12 col-md-12 col-lg-12" id="mainVentas">
            <div class="form-check m-auto pt-3 col-xs-12 col-sm-12 col-md-12 col-lg-11">
                <div class="ContenedorBuscarVentas  col-xs-12 col-sm-12 col-md-12 col-lg-12  p-2 d-md-flex justify-content-left align-items-center">
                    <div class="conten-campania conten-combo pb-2 col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Campaña: <br>
                        <select name="CboCampaniaVenta" class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="CboCampaniaVenta">
                            <option value="0">Todo</option>
                            <?php
                            $user = new ApptivaDB();
                            $categorias = $user->buscarTodo("campaniassmtk", "idCampania,cNombreCampania");
                            foreach ($categorias as $cat) :   ?>
                                <option value="<?php echo $cat['idCampania'] ?>">
                                    <?php echo $cat['cNombreCampania'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="pb-2  col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Estado: <br>
                        <a href=""></a>
                        <select name="CboEstadoVenta" class="col-xs-12 col-sm-12 col-md-10 col-lg-10" id="CboEstadoVenta">
                            <option value="'0'">Todo</option>
                            <?php
                            $user = new ApptivaDB();
                            $estadoVenta = $user->buscarGeneral("cCodTab ,cNomTab", "tablacod", "cCodTab LIKE 'ESTV%' AND cCodTab<>'ESTV0000'");
                            foreach ($estadoVenta as $cat) :   ?>
                                <option value="'<?php echo $cat['cCodTab'] ?>'">
                                    <?php echo mb_convert_case($cat['cNomTab'], MB_CASE_TITLE, "UTF-8") ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php if (isset($_SESSION["asistenteLogeado"])) { ?>
                        <div class="pb-2 d-none col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        <?php } else { ?>
                            <div class="pb-2  col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <?php } ?>
                            Personal: <br>
                            <select name="CboPersonal" class="col-xs-12 col-sm-12 col-md-10 col-lg-10" id="CboPersonal">
                                <option value="'0'">Todo</option>
                                <?php
                                $user = new ApptivaDB();
                                // $estadoVenta = $user->EjecutarProcedimiento("sp_listarPersonal", "");
                                $estadoVenta = $user->buscarConsultas(
                                    "u.idUsuario,CONCAT(p.per_nombre,'',p.per_apellido_paterno) AS personal",
                                    "personal p
                                 INNER JOIN usuarios u ON u.ID_PERSONAL=p.idPersonal
                                 INNER JOIN cargos c ON u.ID_CARGO=c.idCargo",
                                    "u.ID_CARGO=3;"
                                );
                                foreach ($estadoVenta as $cat) :   ?>
                                    <option value="'<?php echo $cat['idUsuario'] ?>'">
                                        <?php echo mb_convert_case($cat['personal'], MB_CASE_TITLE, "UTF-8") ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            </div>
                        </div>
                        Fechas
                        <div class="ContenedorBuscarVentas d-block col-xs-12 col-sm-12 col-md-12 col-lg-12 m-0 pb-3 d-md-flex justify-content-left align-items-center">
                            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
                                <label for="">Desde</label></br>
                                <input id="fecha_in" type="date" name="fecha_inicio" class="fechasBusqueda col-xs-12 col-sm-12 col-md-12 col-lg-11" required />
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
                                <label>Hasta</label></br>
                                <input id="fecha_fin" type="date" name="fecha_final" class="fechasBusqueda col-xs-12 col-sm-12 col-md-12 col-lg-11" required />

                            </div>
                        </div>

                </div>

                <div class="mainContent table-responsive mt-4 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <table id="example" class="dataTable table">
                        <thead>
                            <tr>
                                <!-- <th class="col-1">Nro:</th> -->
                                <!-- <th>Codigo:</th> -->
                                <th class="col-2">Alumno:</th>
                                <th class="col-2">Curso:</th>
                                <!-- <th class="col-3">Fecha.venta:</th> -->
                                <th class="col-3">Inicio.de.curso</th>
                                <th class="col-2">Finalizacion.curso</th>
                                <th class="col-0">Cuota:</th>
                                <th class="col-1">Importe:</th>
                                <th class="col-1">Estado</th>
                                <th class="col-1">Personal:</th>
                                <th class="col-1">Acciones:</th>
                            </tr>
                        </thead>
                        <tbody id="tbListarVentas">

                        </tbody>
                    </table>
                    <?php include("../../loader.php"); ?>
                    <a href="" class="cerrarModal" rel="modal:close"></a>
                </div>
            </div>
        </div>

        <script src="../../../JS/jquery-3.6.0.min.js"></script>
        <script type="module" src="<?php echo $urlProyecto ?>JS/scripBuscarVentas.js"></script>

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
        <script src="<?php echo $urlProyecto ?>JS/scrip_general.js" type="module"></script>

        <script>
            $(document).ready(function() {

            });
        </script>
</body>

</html>