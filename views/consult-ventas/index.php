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
    header("Location:" . $urlProyecto . "views/prospectos");
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
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilos_sideBar.css">
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilos_header.css">
    <!-- <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilosProspecto_ifo.css"> -->
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilosVenta.css">
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilosTabla.css">
    <link rel="stylesheet" href="../../fontawesome/css/all.css">
    <link rel="stylesheet" href="../../fonts/style.css">
    <link rel="stylesheet" href="../../fonts/azome/fontAsome.js">
    <link rel="stylesheet" href="../../fonts/fonts/style.css">
    <link rel="stylesheet" href="../../fonts/line/line-awesome.min.css">

    <link rel="stylesheet" href="../../CSS/estilos_menu_navbar.css">

    <link rel="stylesheet" href="../../JS/modals/jquery.modal.min.css">
    <link rel="stylesheet" href="../../CSS/estilosVentanasModal.css">
    <link rel="stylesheet" href="../../CSS/estilosConsultVenta.css">
    <link rel="stylesheet" href="../../CSS/pages/jPages.css">
    <link rel="stylesheet" href="../../CSS/pages/animate.css">
    <link rel="icon" href="../../IMAGENES/faviconn.png" type="image/png" />
    <script src="<?php echo $urlProyecto ?>JS/jquery-3.5.1.min.js"></script>
    <script src="../../JS/pages/jPages.min.js"></script>


</head>

<body>

    <?php
    include("../menu/menu_lateral.php");
    include("../header.php");
    include("../ventanas-modal.php");
    ?>

    <div class="main pb-5">
        <!-- <div class="tab">
            <button class="tablinks" onclick="openAbrirtabs(event, 'mainMisVentas')">Mis Venta</button>
            <button class="tablinks active" onclick="openAbrirtabs(event, 'mainVentas')">Nueva Venta</button>
        </div> -->

        <!-- <div class="tabcontent" id="mainMisVentas">
            <h2>aun en prueba</h2>
        </div> -->
        <div class="tabcontent mt-3  col-12" id="mainVentas">
            <form action="" method="post" id="formulario-Consultventas">
                <div class="m-auto mt-3 p-0 tab text-left col-12 col-xs-12 col-sm-12 col-md-12 col-lg-11">
                    <h6>Datos de Venta</h6>
                    <div class="p-3  tab text-left col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 d-lg-flex">
                        <div class="mt-3 mt-lg-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-3">
                            <p class=" d-flex m-0 p-0">Campaña</p>
                            <input type="text" class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-12" name="txt-CampaniaDV" id="txt-CampaniaDV" readonly>
                        </div>
                        <div class="mt-3 mt-lg-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-3">
                            <p class=" d-flex m-0 p-0">Codigo</p><input type="text" class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-12" name="txt-CodVentaDV" id="txt-CodVentaDV" readonly>
                        </div>
                        <div class="mt-3 mt-lg-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-3">
                            <p class=" d-flex m-0 p-0">Fecha de Venta</p><input type="text" class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-12" name="txt-FechaVentaDV" id="txt-FechaVentaDV" readonly>
                        </div>
                        <div class="mt-3 mt-lg-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-3">
                            <p class=" d-flex m-0 p-0">Importe Total</p><input type="text" class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-12" name="txt-importeTotal_DV" id="txt-importeTotal_DV" readonly>
                        </div>

                    </div>

                    <div class="conten-boton d-flex p-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <a href="#formulariosBuscarClienteConCuotas" id="btnBuscarClienteConCuotas" class="mr-10 btnBuscarCliente btn mr-auto ml-auto m-md-3 col-6 col-xs-6 col-sm-6 col-md-2 col-lg-2" rel="modal:open">
                            <span class="fas fa-search"> </span> Buscar Ventas</a>
                    </div>

                </div>
                <!-- recibo los datos que emvio por medio del formulario oculto desde scripBuscarVentas -->
                <input type="hidden" name="" id="txtGetCodVenta" value="<?php echo $_POST["codVenta"] ?>">
                <input type="hidden" name="" id="txtGetIdCliente" value="<?php echo $_POST["idAlumno"] ?>">

                <input type="hidden" name="" id="txtIdClientefrmConsultas" value="<?php echo $_POST["idAlumno"] ?>">
                <input type="hidden" name="" id="txtCodventafrmConsultas" value="<?php echo $_POST["codVenta"] ?>">

                <div class="mt-3 pl-0 pr-0 pb-3 ml-auto mr-auto tab text-left col-12 col-xs-12 col-sm-12 col-md-12 col-lg-11">
                    <h6>Datos de Cliente</h6>
                    <div class="p-3  tab text-left col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 d-lg-flex">
                            <div class="mt-3 mt-lg-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                <p class=" d-flex m-0 p-0">Nombres:</p>
                                <input type="text" class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-12" name="txt-NombresDV" id="txt-NombresDV" readonly>
                            </div>
                            <div class="mt-3 mt-lg-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                <p class=" d-flex m-0 p-0">Apellidos:</p>
                                <input type="text" class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-12" name="txt-ApellidosDV" id="txt-ApellidosDV" readonly>
                            </div>
                        </div>
                        <div class=" mt-3 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 d-lg-flex">
                            <div class="mt-3 mt-lg-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                <p class=" d-flex m-0 p-0">Correo</p>
                                <input type="text" class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-12" name="txt-CorreoDV" id="txt-CorreoDV" readonly>
                            </div>
                            <div class="mt-3 mt-lg-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                <p class=" d-flex m-0 p-0">Telefono:</p><input type="text" class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-12" name="txt-telefonoDV" id="txt-telefonoDV" readonly>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="mt-3 pl-0 mb-3 pr-0 pb-3 ml-auto mr-auto tab text-left col-12 col-xs-12 col-sm-12 col-md-12 col-lg-11">
                    <h6>Datos de la Clase</h6>
                    <div class="p-0  tab text-left col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 d-lg-flex">
                        <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 ">
                            <p>Datos del curso</p>
                            <div class="p-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 d-lg-flex">
                                <div id="gbCargarCursos" class="col-12">

                                </div>
                            </div>
                            <p class="mt-3">Fechas del curso</p>
                            <div class="p-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 d-lg-flex">
                                <div id="gbCargarFechasVenta" class="col-12">

                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6" style="border-left: 1px solid #ccc;">
                            <p>Datos del Docente</p>
                            <div class="p-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 d-lg-flex">
                                <div id="gbCargarDocentes">

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
            <div class="mainContent table-responsive p-1 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h6 class=" m-auto txtTituloCuotas col-12 col-xs-12 col-sm-12 col-md-12 col-lg-11">CUOTAS:</h6>
                <table class='mb-5 ml-auto mr-auto table table-striped table-hover col-12 col-xs-12 col-sm-12 col-md-12 col-lg-11' id='tabla'>
                    <thead>
                        <tr>
                            <th>N°:</th>
                            <th>Fecha_Venta:</th>
                            <th>Fecha_Pago:</th>
                            <th>Fecha_Vencimiento:</th>
                            <th>Importe:</th>
                            <th class="text-center">Estado</th>
                            <th></th>
                            <th>Accion:</th>

                        </tr>
                    </thead>
                    <tbody id="tbCuotasXCliente">
                    </tbody>


                </table>

                <a href="" class="cerrarModal" rel="modal:close"></a>
            </div>
        </div>
    </div>

    <!-- <script src="<?php echo $urlProyecto ?>JS/jquery-3.5.1.min.js"></script> -->
    <script src="../../JS/modals/jquery.modal.min.js"></script>
    <script src="<?php echo $urlProyecto ?>JS/scrip_general.js" type="module"></script>
    <script type="module" src="<?php echo $urlProyecto ?>JS/scripPagClientes.js"></script>
    <!-- <script type="module" src="<?php echo $urlProyecto ?>JS/scripBuscarVentas.js"></script> -->
    
    <script type="module" src="<?php echo $urlProyecto ?>JS/scripConsultVentas.js"></script>

</body>

</html>