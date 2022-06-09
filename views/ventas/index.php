<?php
session_start();
include("../../model/conexion.php");
include("../../model/url.php");
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
date_default_timezone_set('America/lima');
$fecha_Actual = date("Y-m-d");
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
    <title>Ventas</title>
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilos_sideBar.css">
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilos_header.css">
    <!-- <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilosProspecto_ifo.css"> -->
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilosVenta.css?ort">
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilosTabla.css">
    <link rel="stylesheet" href="../../fontawesome/css/all.css">
    <link rel="stylesheet" href="../../fonts/line/line-awesome.min.css">
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>fonts/style.css">
    <link rel="stylesheet" href="../../CSS/estilos_menu_navbar.css?kdg">
    <link rel="stylesheet" href="../../CSS/estilosLoader.css">

    <link rel="stylesheet" href="../../JS/modals/jquery.modal.min.css">
    <link rel="stylesheet" href="../../CSS/estilosVentanasModal.css">
    <link rel="stylesheet" href="../../CSS/pages/jPages.css">
    <link rel="stylesheet" href="../../CSS/pages/animate.css">

    <link rel="icon" href="../../IMAGENES/faviconn.png" type="image/png" />

    <script src="<?php echo $urlProyecto ?>JS/jquery-3.5.1.min.js"></script>
    <script src="../../JS/pages/jPages.min.js"></script>

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
    include("../loader.php");
    include("../menu/menu_lateral.php");
    include("../header.php");
    include("../ventanas-modal.php");
    ?>

    <div class="main" id="main">
        <div class="tabcontent" id="mainVentas">
            <form action="" class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12" method="post" id="formulario-ventas" enctype="multipart/form-dat">
                <div class="groupGeneralCliente groupGeneral p-0  col-12 col-xs-12 col-sm-12 col-md-11 col-lg-11">
                    <h4>Datos del cliente</h4>
                    <div class="group  col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="group-item p-0  col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 d-md-flex justify-content-between">
                            <input type="hidden" name="txtidcliente" id="txtidcliente">
                            <input type="hidden" name="txtCodCliente" id="txtCodCliente">
                            <div class="datosPospectos d-flex justify-content-start align-items-center col-12 col-xs-12 col-sm-12 col-md-5 col-lg-5">
                                <span class=""> Nombres:</span>
                                <input type="text" name="txtNombresCli" id="lblNombresV">

                            </div>
                            <div class="datosPospectos d-flex justify-content-start align-items-center col-12 col-xs-12 col-sm-12 col-md-5 col-lg-5">
                                <span> Apellidos:</span>
                                <input type="text" name="txtApellidosCli" id="lblApellidosV">

                            </div>
                            
                        </div>
                        <div class="group-item p-0  col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 d-md-flex justify-content-between">

                            <div class="datosPospectos d-flex justify-content-start align-items-center col-12 col-xs-12 col-sm-12 col-md-5 col-lg-5">
                                <span> Correo:</span>
                                <input type="text" name="txtCorreoCli" id="lblCorreoV">

                            </div>
                            <div class="datosPospectos d-flex justify-content-start align-items-center col-12 col-xs-12 col-sm-12 col-md-5 col-lg-5">
                                <span> Telefono:</span>
                                <input type="text" name="txtCodigoPais" id="txtCodigoPais" class="col-2" readonly>
                                <input type="text" name="txtTelefonoCli" id="lblTelefonoV" class="col-10">

                            </div>

                        </div>
                        <div class="group-item group-boton p-0  col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 d-md-flex justify-content-between">
                            <div class="datosPospectos d-flex justify-content-start align-items-center col-12 col-xs-12 col-sm-12 col-md-5 col-lg-5">
                                <span> Pais:</span>
                                <select name="cboPais" id="cboPais" class="form-control col-6">
                                    <option value="FALTA">Seleccione Pais</option>
                                    <?php
                                    $user = new ApptivaDB();
                                    $categorias = $user->buscarTodo("pais", "Codigo,Nombre_pais,Codigo_pais");
                                    foreach ($categorias as $cat) :   ?>
                                        <option value="<?php echo $cat['Codigo'] ?>">
                                            <?php echo mb_convert_case($cat['Nombre_pais'], MB_CASE_TITLE, "UTF-8") ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="conten-boton p-0 col-12 col-xs-12 col-sm-12 col-md-5 col-lg-5">
                                <a href="#formulariosBuscarCliente" id="btnBuscarCliente" class=" btnBuscarCliente btn col-xs-12 col-sm-12 col-md-4 col-lg-4" rel="modal:open">
                                    <span class="fas fa-search"> </span> Buscar Cliente</a>
                            </div>
                        </div>
                        <div class="bg-warning p-2 mt-2" style="color: #000;"> Porfavor verifique el número de telefono para no tener problemas al agregar a sendinblue (código de pais mas telefono)</div>
                        <input type="text" name="txtCorreoCliOrig" id="txtCorreoCliOrig" class="d-none">
                        <input type="text" name="txtNombresCliOrig" id="txtNombresCliOrig" class="d-none">
                    </div>

                </div>
                <div class="groupGeneralCliente groupGeneral p-0 col-12 col-xs-12 col-sm-12 col-md-11 col-lg-11">
                    <h4>Datos de Moneda</h4>
                    <input type="hidden" name="txtTipoMoneda" id="txtTipoMoneda">
                    <div class="p-3 m-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 d-lg-flex justify-content-between">
                        <div class="mb-3 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 mb-lg-0 d-lg-block align-items-center">
                            <label for="">Tipo Moneda</label><br>
                            <select name="CboTipoMoneda" class="form-control col-xs-12 col-sm-12 col-md-12 col-lg-12" id="CboTipoMoneda">
                                <option value="0">Seleccione Tipo de moneda</option>
                                <?php
                                $user = new ApptivaDB();
                                $categorias = $user->buscarTodo("tipomoneda", "idTipoMoneda,nomMoneda");
                                foreach ($categorias as $cat) :   ?>
                                    <option value="<?php echo $cat['idTipoMoneda'] ?>">
                                        <?php echo $cat['nomMoneda'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                            <label for="">Fecha de venta</label></br>
                            <input id="dtfecha_inicio_V" class="form-control col-xs-12 col-sm-12 col-md-6 col-lg-6" type="date" name="dtfecha_inicio_V" value="<?php echo $fecha_Actual; ?>" required />
                        </div>
                    </div>

                </div>
                <div class="groupGeneralCliente groupGeneral p-0 col-12 col-xs-12 col-sm-12 col-md-11 col-lg-11">
                    <h4>Datos de el/los cursos</h4>
                    <div class="group col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="group-item p-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 d-lg-flex">
                            <div class="d-flex col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4 d-lg-block align-items-center">
                                <div class="conten-campania conten-combo col-xs-8 col-sm-8 col-md-8 col-lg-12 mb-lg-5">
                                    <select name="CboCampaniaVenta" class="form-control col-xs-12 col-sm-12 col-md-12 col-lg-12" id="CboCampaniaVenta">
                                        <option value="0">Seleccione Campaña</option>
                                        <?php
                                        $user = new ApptivaDB();
                                        $categorias = $user->buscarConsultas("C.idCampania,C.cNombreCampania","campaniassmtk C","'1' ORDER BY C.idCampania DESC");
                                        foreach ($categorias as $cat) :   ?>
                                            <option value="<?php echo $cat['idCampania'] ?>">
                                                <?php echo $cat['cNombreCampania'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="conten-boton col-4 col-xs-4 col-sm-4 col-md-4 col-lg-12">
                                    <a href="#formulariosBuscarEventoClase" id="btnBuscarEventoClase" class="btnBuscarCurso btn d-none col-xs-12 col-sm-12 col-md-12 col-lg-8" rel="modal:open">
                                        <span class="fas fa-search"></span>Buscar Clase </a>
                                </div>
                            </div>
                            <div class="group-item  m-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-8">
                                <input type="hidden" name="txtNumeroEventosClase" id="txtNumeroCursos">
                                <div class=" contenedorLLanarEventosClase overflow-auto col-xs-12 col-sm-12 col-md-12 col-lg-12">

                                </div>
                            </div>
                        </div>
                        <div class="group-precios mt-3 p-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 d-md-flex">
                            <div class="group-item col-12 col-xs-12 col-sm-12 col-md-5 col-lg-7 d-lg-flex">
                                <div class="d-none conten-combo group-usarPrecioEstablecido p-2 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <select name="CboPagoEstablecido" class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12" id="CboPagoEstablecido">
                                        <!-- <option value="0">Seleccione Opcion</option> -->
                                        <option value="1">Usar precio establecido</option>
                                        <option value="2">Añadir precio</option>
                                    </select>
                                </div>
                                <div class="d-none col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                    <label for="" id="rbDescuento" class="d-none">
                                        Descuento:
                                        <input type="radio" name="rbDescuento" id="" checked value="1">
                                    </label>
                                    <label for="" id="rbDUo" class="d-none">
                                        Duo:
                                        <input type="radio" name="rbDuo" id="ebDuo" value="2">
                                    </label>
                                    <!-- <label for="">
                                    Añadir precio diferente:
                                    <input type="radio" name="" id="">
                                </label> -->
                                </div>
                            </div>
                            <div class="group-items-precios col-12 col-xs-12 col-sm-12 col-md-7 col-lg-5 justify-content-end align-items-center d-flex">
                                <div class="p-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="items-precios p-0 mt-3 pb-3 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex">
                                        <div class="text-right m-0 col-4 col-xs-4 col-sm-4 col-md-5 col-lg-7">Descuento</div>
                                        <span class="col-1 col-xs-1 col-sm-1 col-md-1 col-lg-1 lblSimboloMoneda"></span>
                                        <input type="text" class="m-0 col-7 col-xs-7 col-sm-7 col-md-6 col-lg-4" name="txtDescuento" id="txtDescuento" value="">
                                    </div>
                                    <div class="d-none bg-info items-precios p-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="text-right m-0 col-4 col-xs-4 col-sm-4 col-md-5 col-lg-5">Otro Monto</div>
                                        <span class="col-1 col-xs-1 col-sm-1 col-md-1 col-lg-1"></span><input type="text" class="m-0 col-7 col-xs-7 col-sm-7 col-md-6 col-lg-6" name="txtOtroMonto" id="txtOtroMonto" value="0" disabled>
                                    </div>
                                    <div class="items-precios p-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex">
                                        <div class="text-right m-0 col-4 col-xs-4 col-sm-4 col-md-5 col-lg-7">Total a Pagar</div>
                                        <span class="col-1 col-xs-1 col-sm-1 col-md-1 col-lg-1 lblSimboloMoneda"></span>
                                        <input type="number" class="m-0 col-7 col-xs-7 col-sm-7 col-md-6 col-lg-4 " name="txtTotalPagar" id="txtTotalPagar" value="" >
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="groupGeneralCliente groupGeneral p-0  col-12 col-xs-12 col-sm-12 col-md-11 col-lg-11">
                    <h4>Datos requeridos</h4>
                    <div class="group  col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="group-item group-pago-por-cuotas   col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 d-lg-flex justify-content-between">
                            <div class="conten-combo   col-xs-12 col-sm-12 col-md-12 col-lg-5">
                                <select name="CboPagoPorCuotas" class="form-control col-xs-12 col-sm-12 col-md-12 col-lg-12" id="CboPagoPorCuotas">
                                    <option value="0">Seleccione Tipo de Pago</option>
                                    <option value="1" selected>Pago Unico</option>
                                    <option value="2">Pago Por Cuotas</option>
                                </select>
                            </div>
                            <div id="conten-txt-cuotas" class="conten-txt mt-5  col-xs-12 col-sm-12 col-md-12 col-lg-7 mt-lg-0 d-lg-flex justify-content-center">
                                <div class="p-0 d-block col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <label for="txtNumeroCuotas" class="p-0 m-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">Numero de cuotas</label>
                                    <input type="number" name="txtNumeroCuotas" id="txtNumeroCuotas" class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-8" placeholder="Numero de cuotas" value="1" readonly>
                                </div>
                                <div class=" p-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <label for="txtNumeroCuotas" class="p-0 m-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">Monto Cuota N° 1</label>
                                    <span class="lblSimboloMoneda"></span><input type="number" name="txtPagoPrimeraCuota" id="txtPagoPrimeraCuota" class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-8" placeholder="Monto" readonly>
                                </div>
                                <div class=" p-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <label for="txtNumeroCuotas" class="p-0 m-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">Monto Restante</label>
                                    <span class="spanMontoRestante lblSimboloMoneda"></span><input type="text" name="txtMontoRestante" id="txtMontoRestante" class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-8" placeholder="Monto restante" value="" readonly>
                                </div>

                            </div>
                        </div>
                        <div class="group-item p-0 mt-3  col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 d-lg-flex justify-content-between">

                            <div id="conten-dttme-cuotas" class="conten-dttme mt-5  col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-lg-0 d-lg-flex justify-content-between">



                            </div>
                        </div>
                        <div class="group group-anexar-comprobante mt-4 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 d-lg-flex justify-content-between">
                            <div class="group-item  p-0  col-12 col-xs-12 col-sm-12 col-md-12 col-lg-5 d-lg-flex justify-content-between">
                                <div class="conten-combo text-center d-block col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <h6 class="text-left mt-4 pl-0">Modo Pago</h6>
                                    <select name="CboTipoPago" class="form-control col-xs-12 col-sm-12 col-md-10 col-lg-10" id="CboTipoPago">
                                        <option value="0">Seleccione Modo de Pago</option>
                                        <?php
                                        $user = new ApptivaDB();
                                        $categorias = $user->buscarTodo("tipopagos", "idTipoPago,cNombreTipoPago");
                                        foreach ($categorias as $cat) :   ?>
                                            <option value="<?php echo $cat['idTipoPago'] ?>">
                                                <?php echo $cat['cNombreTipoPago'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <h6 class="text-left mt-4 pl-0">Entidad Pago</h6>
                                    <select name="CboEntidadPago" class="form-control col-xs-12 col-sm-12 col-md-10 col-lg-10" id="CboEntidadPago">

                                    </select>
                                    <div class="col-12 p-0 mt-5">
                                        <h6 class="text-left  pl-0">Estado Venta</h6>
                                        <select name="CboEstadoVenta" class="form-control col-xs-12 col-sm-12 col-md-10 col-lg-10" id="CboEstadoVenta">
                                            <option value="'0'">Seleccione Estado de Venta</option>
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
                                </div>
                            </div>


                            <div class="group-item p-0 mt-4 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-7 mt-lg-0  justify-content-between">
                                <h4 class="text-center ">Anexar Comprobante</h4>
                                <input type="file" name="imgBoucherPago" id="imgBoucherPago" style="display: none;" >
                                <div class="contenedorRecibo ">
                                    <img src="" class=" rounded mx-auto d-block" id="imgBoucher" alt="" width="auto" srcset="">
                                    <div class="divBoton">
                                        <div>
                                            <span class="fas fa-file-image"></span><br>
                                            <p for="">Subir archivo</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="groupGeneralCliente groupGeneral p-0  col-12 col-xs-12 col-sm-12 col-md-11 col-lg-11">
                    <h4>Observaciones</h4>
                    <div class="group  col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="group-item p-0  col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 d-md-flex justify-content-between">
                            <a href="" id="cerrarModal" rel="modal:close"></a>
                            <div class="contenObservaciones col-xs-12 col-sm-12 col-md-12 col-lg-12">

                                <textarea class="" name="txtObservaciones" id="txtObservaciones" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-none">
                    <input type="text" name="txtFechaInicio" id="txtFechaInicio">
                    <input type="text" name="txtFechaFin" id="txtFechaFin">
                    <input type="text" name="txtProgresoClase" id="txtProgresoClase">
                </div>
                <div class="contenedorBoton col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-content-center">
                    <label for="chkEnviarCorreo">
                        <input type="checkbox" name="chkEnviarCorreo" id="chkEnviarCorreo" checked>
                        Enviar Correo automaticamente? </label>
                </div>
                <div class="contenedorBoton col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-content-center">
                    <!-- <input type="submit" value="Generar Venta" class="btnGuardarVenta" id="btnGuardarVenta"> -->
                    <a href="#formularioDatosDeClase" id="btnFinalizarCompra" class="btnGuardarVenta text-center btnOpenModal col-xs-11 col-sm-11 col-md-6 col-lg-4" rel="modal:open">
                        Finalizar Venta</a>
                </div>
            </form>

        </div>
    </div>

    
    <!-- <script src="<?php echo $urlProyecto ?>JS/jquery-3.5.1.min.js"></script> -->
    <script src="../../JS/modals/jquery.modal.min.js"></script>
    <script src="<?php echo $urlProyecto ?>JS/scrip_general.js?gsd" type="module"></script>
    <!-- <script type="module" src="<?php echo $urlProyecto ?>JS/scripPagClientes.js?jkf"></script> -->
    <script type="module" src="<?php echo $urlProyecto ?>JS/scripVentas.js?ouuld"></script>

</body>

</html>