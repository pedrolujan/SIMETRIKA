<?php
include("../../model/conexion.php");
include("../../model/url.php");
session_start();
$con = new ApptivaDB();
$sql = $con->buscarFech(
    "pros_nombres,pros_apellidos,pros_email,pros_telefono,Nombre_pais",
    "prospectos 
    LEFT JOIN pais on pais.Codigo=prospectos.ID_PAIS",
    "prospectos.idProspecto='" . $_POST["txtidProspecto"] . "'"
);
$sqlPersonal = $con->buscarFech(
    "per.imagen,per.per_nombre,per.per_apellido_paterno,per.per_apellido_materno,c.nombreCargo",
    "personal per 
    INNER JOIN usuarios us ON per.idPersonal=us.ID_PERSONAL
    INNER JOIN cargos c ON us.ID_CARGO=c.idCargo",
    "us.idUsuario='" . $_POST["txtidPersonal"] . "'"
);

$detalleSeguimiento = $con->buscarGeneral(
    "DISTINCT ca.Nonmbre_Camp,c.nombreCorto,seg.tipoSeguimiento,seg.descripcionSeguimiento,seg.fecha_registro",
    "prospectos p
    INNER JOIN usuarios u ON u.idUsuario=p.idUsuario
    INNER JOIN personal per ON u.ID_PERSONAL=per.idPersonal
    LEFT JOIN cursos_prospecto cp ON cp.ID_PROSPECTO
    LEFT JOIN cursos c ON cp.ID_CURSO=c.idCursos
    INNER JOIN campania ca On cp.ID_CAMPANIA=ca.idCampania
    INNER JOIN seguimiento seg ON u.idUsuario=seg.ID_USUARIO_PERSONAL
    ",
    "seg.ID_PROSPECTO='" . $_POST["txtidProspecto"] . "'
    AND seg.ID_USUARIO_PERSONAL='" . $_POST["txtidPersonal"] . "'
    AND p.pros_estado='1'
    GROUP BY seg.fecha_registro
    ORDER BY seg.fecha_registro DESC"
);


$datos = mysqli_fetch_array($sql);
$datosPer = mysqli_fetch_array($sqlPersonal);
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
    <link rel="stylesheet" href="../../CSS/estilosProspecto_ifo.css">
    <link rel="stylesheet" href="../../CSS/estilosTabla.css">
    <link rel="stylesheet" href="../../fontawesome/css/all.css">
    <!-- <link rel="stylesheet" href="../../css/estilos_menu_navbar.css"> -->
</head>

<body>
    <?php
    include("../header.php");
    ?>
    <div id="main" class="main group-detalle-segimiento col-xs-12 col-sm-12 col-md-12 col-lg-12">

        <div class="contenedor col-xs-12 col-sm-12 col-md-12 col-lg-12 d-md-flex">
            <div class="contenedorDatos col-xs-12 col-sm-12 col-md-12 col-lg-6">
                <h2 class="tituloInfoProspecto"> DATOS DEL PROSPECTO</h2>
                <br>

                <div class="datosPospectos"><label for=""> Nombre:</label><span><?php echo ucwords(strtolower($datos["pros_nombres"])) ?></span></div><br>
                <div class="datosPospectos"><label for=""> Apellido paterno:</label><span><?php echo  mb_convert_case($datos["pros_apellidos"], MB_CASE_TITLE, "UTF-8") ?></div></span><br>
                <div class="datosPospectos"><label for=""> Correo:</label><span><?php echo  $datos["pros_email"] ?></span></div><br>
                <div class="datosPospectos"><label for=""> Telefono:</label><span><?php echo  $datos["pros_telefono"] ?></span></div><br>
                <div class="datosPospectos"><label for=""> Pais:</label><span><?php echo  mb_convert_case($datos["Nombre_pais"], MB_CASE_TITLE, "UTF-8") ?></span></div><br>
            </div>
            <div class="contenedorDatos contenedorPersonal col-xs-12 col-sm-12 col-md-12 col-lg-6">
                <h2 class="tituloInfoProspecto"> DATOS DEL ENCARGADO DEL SEGUIMIENTO</h2>
                <br>

                <div class="contenImagenPersonal"><img src="<?php echo $urlProyecto . $datosPer["imagen"] ?>" alt="" srcset=""></div><br>
                <div class="datosPospectos"><label for=""> Nombre:</label><span><?php echo ucwords(strtolower($datosPer["per_nombre"])) ?></span></div><br>
                <div class="datosPospectos"><label for=""> Apellido paterno:</label><span><?php echo  mb_convert_case($datosPer["per_apellido_paterno"], MB_CASE_TITLE, "UTF-8") ?></div></span><br>
                <div class="datosPospectos"><label for=""> Apellido materno:</label><span><?php echo  mb_convert_case($datosPer["per_apellido_materno"], MB_CASE_TITLE, "UTF-8") ?></div></span><br>
                <div class="datosPospectos"><label for=""> Cargo:</label><span><?php echo  mb_convert_case($datosPer["nombreCargo"], MB_CASE_TITLE, "UTF-8") ?></span></div><br>

            </div>

        </div>

        <div class="table-responsive ">
            <h2 class="mt-3 detalleSeguimiento"> DETALLE DEL SEGUIMIENTO</h2>
            <table class='mb-5 w-100 table p-0 m-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12' id='tabla'>
                <thead class="w-100 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <tr class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <th>Campaña</th>
                        <th>Curso</th>
                        <th>Seguimiento</th>
                        <th>Descripcion</th>
                        <th>Fecha_seguimiento</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($detalleSeguimiento as $row) {
                    ?>
                        <tr>
                            <td><?php echo $row["Nonmbre_Camp"]; ?></td>
                            <td class="tdAling"><?php echo $row["nombreCorto"]; ?></td>
                            <td><?php echo $row["tipoSeguimiento"]; ?></td>
                            <td class="tdAling"><?php echo $row["descripcionSeguimiento"]; ?></td>
                            <td><?php echo $row["fecha_registro"]; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="formulario__mensaje" id="formulario__mensaje"></div>
        <!-- <div class="contenedor_venta_General col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label for="">REALIZAR VENTA </label> <br>
            <div class="conteneror_venta">
                <div class="contenedor_campanias_cursos col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex">
                    <div class="pb-2  col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        Campaña: <br>
                        <select name="CboCampania" class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="CboCampania">
                            <option value="0">Seleccione Campaña</option>
                            <?php
                            $user = new ApptivaDB();
                            $categorias = $user->buscarTodo("campania", "Nonmbre_Camp");
                            foreach ($categorias as $cat) :   ?>
                                <option value="<?php echo $cat['idCampania'] ?>">
                                    <?php echo $cat['Nonmbre_Camp'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="pb-2  col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        Curso: <br>
                        <select name="CboCursos" class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="CboCursos">

                        </select>
                    </div>
                </div>
                <div class="contenedor_boucher">
                    <input type="file" name="" id="">
                </div>
                <div class="contenedorBoton col-xs-12 col-sm-12 col-md-12 col-lg-6">
                    <input type="submit" value="Registrar Venta" class="btnGuardarRegistro" id="btnGuardarRegistro">
                </div>
            </div>
        </div> -->
    </div>

    <script src="<?php echo $urlProyecto ?>JS/jquery-3.5.1.min.js"></script>
    <script src="<?php echo $urlProyecto ?>JS/scrip_general.js" type="module"></script>
    <script type="module" src="<?php echo $urlProyecto ?>JS/scripPagClientes.js"></script>

</body>

</html>