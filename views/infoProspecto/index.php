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
    header("Location:" . $urlProyecto . "views/prospectos");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Segimiento</title>
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilos_sideBar.css">
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilos_header.css">
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilosProspecto_ifo.css">
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilosTabla.css">
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilosLoader.css">
    <link rel="stylesheet" href="../../fontawesome/css/all.css">
    <link rel="stylesheet" href="../../CSS/estilos_menu_navbar.css">

    <link rel="icon" href="../../IMAGENES/faviconn.png" type="image/png" />
</head>

<body>

    <?php
    include("../menu/menu_lateral.php");
    include("../header.php");
    include("../loader.php");
    ?>
    <div class="main">
        <div class="tabcontent" id="mainSeguimiento">
            <div class="mainContent row  col-xs-12 col-sm-12 col-md-12 col-lg-12" id="main">
                <div class="contenedor col-xs-12 col-sm-12 col-md-12 col-lg-12 d-md-flex">
                    <div class="contenedorDatos col-xs-12 col-sm-12 col-md-12 col-lg-6">
                        <h2 class="tituloInfoProspecto"> DATOS DEL PROSPECTO</h2>
                        <br>
                        <form action="#" method="post" id="formularioActualizarProspectos">
                            <div class="datosPospectos col-12">
                                <label for="" class="col-4"> Nombres:</label>
                                <span class="spanDatos col-8" id="spanNombres"></span>
                                <input type="text" name="txtNombres" id="txtNombres" class="form-control col-8 d-none txtinputs " value="">
                            </div><br>
                            <div class="datosPospectos col-12">
                                <label for="" class="col-4"> Apellidos:</label>
                                <span class="spanDatos col-8" id="spanApellios"></span>
                                <input type="text" name="txtApellidos" id="txtApellidos" class="form-control col-8 d-none txtinputs " value="">
                            </div><br>
                            <div class="datosPospectos col-12">
                                <label for="" class="m-0 col-4"> Correo:</label>
                                <span class="spanDatos col-8" id="spanCorreo"></span>
                                <input type="text" name="txtCorreo" id="txtCorreo" class="form-control col-8 d-none txtinputs " value="">
                            </div><br>
                            <div class="datosPospectos col-12 text-left">
                                <label for="" class="m-0 col-4 "> Telefono:</label>
                                <div class="col-8 d-flex">
                                    <span class="spanDatos  " id="spanTelefono"></span>
                                    <input type="text" name="txttelefono" id="txttelefono" class="form-control col-8 d-none txtinputs " value="">
                                    <a id="aLinkWP" class="fab fa-whatsapp-square" href="" target="_blank"></a>
                                </div>

                            </div><br>
                            <div class="datosPospectos col-12">
                                <label for="" class="col-4"> Pais:</label>
                                <span class="spanDatos col-8" id="spanPais"></span>
                                <select name="cboPais" id="cboPais" class="form-control col-8 txtinputs  d-none col-8">
                                    <option value="FALTA">Seleccione Pais</option>
                                    <?php
                                    $con = new ApptivaDB();
                                    $categorias = $con->buscarTodo("pais", "Codigo,Nombre_pais");
                                    foreach ($categorias as $cat) :   ?>
                                        <option value="<?php echo $cat['Codigo'] ?>">
                                            <?php echo mb_convert_case($cat['Nombre_pais'], MB_CASE_TITLE, "UTF-8") ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div><br>
                            <input type="hidden" name="txtIdProspecto" id="txtIdProspecto" readonly="readonly" value="<?php echo base64_decode($_GET["identifier"]) ?>"><br>
                        </form>
                        <div class="contenedorBoton mt-3 col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-content-start">
                            <input type="submit" value="Editar Datos" class="btnGuardarRegistro" id="btnEditarNotas">
                        </div>
                    </div>
                    <div class="contenedorRespuesta col-xs-12 col-sm-12 col-md-12 col-lg-6 d-block">
                        <label for="">DESCRIBA SU SEGUIMIENTO </label> <br>
                        <form action="#" id="FormularioAccionSupervisor" method="post">
                            <input type="hidden" name="txtidUsuarioPersonal" id="txtidUsuarioPersonal" value="<?php echo $idUsuario ?>">
                            <input type="hidden" name="txtIdProspecto" id="txtIdProspecto" value="<?php echo base64_decode($_GET["identifier"]) ?>"><br>
                            <div class='d-block col-xs-12 col-sm-12 col-md-12 col-lg-12 d-md-flex justify-content-between align-items-center'>
                                <label class='col-xs-12 col-sm-12 col-md-3 col-lg-4'><input type='radio' name='rbSegimiento' id='rbCompleto' value='mensaje' checked>Mensages</label>
                                <label class='col-xs-12 col-sm-12 col-md-3 col-lg-4'><input type='radio' name='rbSegimiento' id='rbSendinBlue' value='llamada'>llamada</label>

                            </div>


                            <textarea name="txtDescripcion" id="txtDescripcion" cols="30" rows="10"></textarea>
                            <div class="contenedorBoton col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                <input type="submit" value="Guardar tarea" class="btnGuardarRegistro" id="btnGuardarRegistro">
                            </div>
                        </form>
                    </div>

                </div>
                <div class="formulario__mensaje" id="formulario__mensaje"></div>
                <br>
                <br>

                <table class='mb-5 ml-1 table table-striped table-hover table-responsive-md table-responsive-col col-xs-12 col-sm-12 col-md-12 col-lg-12' id='tabla'>
                    <thead>
                        <tr>
                            <th>Fecha:</th>
                            <th>Accion</th>
                            <th>Descrip. seguimiento</th>

                        </tr>
                    </thead>
                    <tbody id="tbDatosSeguimiento">
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <script src="<?php echo $urlProyecto ?>JS/jquery-3.5.1.min.js"></script>
    <script src="<?php echo $urlProyecto ?>JS/scrip_general.js" type="module"></script>
    <script type="module" src="<?php echo $urlProyecto ?>JS/scripSeguimiento.js"></script>
    <!-- <script src="<?php echo $urlProyecto ?>JS/scripSeguiVentas.js"></script> -->

</body>

</html>