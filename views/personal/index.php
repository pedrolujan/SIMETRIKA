<?php
require_once("../../model/url.php");
require_once("../../model/conexion.php");
session_start();
// unset($_SESSION["idpersonalNoMostrar"]);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal</title>

    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/bootstrap.min.css">
    <link rel="stylesheet" href="../../CSS/estilos_sideBar.css">
    <link rel="stylesheet" href="../../CSS/estilos_header.css">
    <link rel="stylesheet" href="../../CSS/estilosPersonal.css?rtew">
    <link rel="stylesheet" href="../../fontawesome/css/all.css">
    <!-- <link rel="stylesheet" href="../../CSS/estilosTabla.css"> -->
    <link rel="stylesheet" href="../../fonts/style.css">

    <link rel="stylesheet" href="../../fontawesome/css/all.css">
    <link rel="stylesheet" href="../../CSS/estilos_menu_navbar.css">
    <link rel="stylesheet" href="../../JS/modals/jquery.modal.min.css">
    <link rel="stylesheet" href="../../CSS/estilosVentanasModal.css">

    <link rel="stylesheet" href="../../CSS/estilosLoader.css">

    <link rel="stylesheet" href="../../DataTables/datatables.min.css">
    <!--datables estilo bootstrap 4 CSS-->
    <link rel="stylesheet" type="text/css" href="../../DataTables/DataTables-1.10.25/css/dataTables.bootstrap4.min.css">

    <link rel="stylesheet" href="../../CSS/pages/jPages.css">
    <link rel="stylesheet" href="../../CSS/pages/animate.css">
    <script src="<?php echo $urlProyecto ?>JS/jquery-3.5.1.min.js"></script>
    <script src="<?php echo $urlProyecto ?>/JS/pages/jPages.min.js"></script>


</head>

<body>
    <?php include("../menu/menu_lateral.php");
    include("../loader.php");
    include("../header.php");
    include("../ventanas-modal.php");
    ?>

    <div id="main" class="main pl-2 pr-2 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">

        <?php
        $Con = new ApptivaDB();
        $busqueda = $Con->buscarGeneral(
            "u.idUsuario,p.idPersonal,p.imagen,p.per_nombre,p.per_apellido_paterno",
            "personal p
            INNER JOIN usuarios u ON p.idPersonal=u.ID_PERSONAL
            INNER JOIN cargos c ON u.ID_CARGO=c.idCargo",
            "c.idCargo=3"
        );
        ?>

        <div class="row contenedorGeneralPersonal p-0 col-xs-12 col-sm-12 col-md-12 col-lg-12 m-0  justify-content-evenly" id="">

            <!-- <?php
                    foreach ($busqueda as $row) {
                    ?>
                <div class="row contenedorPersonal p-0 m-1 col-xs-12 col-sm-6 col-md-4 col-lg-4">
                    <div class="row contenedorDatos m-0 p-1 col-xs-12 col-sm-12 col-md-12 col-lg-12 align-items-center justify-content-center">
                        <img src="../../<?php echo $row["imagen"] ?>" alt="" srcset="" class="">
                        <span class="text-center col-xs-12 col-sm-7 col-md-8 col-lg-8 text-md-left"><?php echo $row["per_nombre"] . "  " . $row["per_apellido_paterno"] ?></span>
                    </div>
                </div>
            <?php } ?> -->

            <div class="contenedor-personal col-xs-12 col-sm-12 col-md-12 col-lg-12 p-0 m-0">
                <div class="contenedor-titulo-controles col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <h3>Personal</h3>
                    <div class="indicadores">

                    </div>
                </div>
                <div class="contenedor-personal-carrusel">
                    <button role="button" id="flecha-izquierda" class="flecha-izquierda"><i class="fas fa-chevron-left"></i></button>
                    <div class="contenedor-carrusel-items">
                        <div class="contenedor-items p-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <?php
                            foreach ($busqueda as $row) {
                            ?>
                                <div class="car-items p-0 m-1 col-6 col-xs-6 col-sm-6 col-md-3 col-lg-3">
                                    <div capId="<?php echo $row["idUsuario"] ?>" id="personalUnico" class="contenedorDatos d-block m-0 p-1 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 d-md-flex align-items-center justify-content-center">
                                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 d-flex justify-content-center">
                                            <img src="../../<?php echo $row["imagen"] ?>" alt="" srcset="">
                                        </div>
                                        <div class="text-center m-0 p-0 col-12 col-xs-12 col-sm-12 col-md-7 col-lg-7 text-md-left">
                                            <span class=""><?php echo $row["per_nombre"] . "  " . $row["per_apellido_paterno"] ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <!--  <div class="car-items">
                                <a href="#">
                                    <img src="../../IMAGENES/personal/img1.png" alt="" srcset="">
                                </a>
                            </div> -->


                        </div>

                    </div>
                    <button role="button" id="flecha-derecha" class="flecha-derecha"><i class="fas fa-chevron-right"></i></button>
                </div>
            </div>
            <input type="hidden" name="txtIdPersonal" id="txtIdPersonal" value="0">

        </div>
        <div class="col-md-12 mt-3 group-nav p-0">
            <div role="tabpanel" class="p-0 m-0">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" id="tbProspecto" href="#">Prospectos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tbVenta" href="#">Ventas</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="group-contenedor-dat-personal pt-3 bg-info" id="group-contenedor-dat-personal">

            <div class="p-0 m-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12" id="prospectos">
                <div>
                    <div class="contenedorCampanias col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12  d-md-flex justify-content-left align-items-center">
                        <div class="pb-2  col-xs-12 col-sm-12 col-md-5 col-lg-5">
                            Evento: <br>
                            <select name="CboCampania" class="form-control col-xs-12 col-sm-12 col-md-12 col-lg-12" id="CboCampania">

                                <option value="0">Seleccione Evento</option>
                                <?php
                                $user = new ApptivaDB();
                                $categorias = $user->buscarTodo("campania", "idCampania,Nonmbre_Camp");
                                foreach ($categorias as $cat) :   ?>
                                    <option value="<?php echo $cat['idCampania'] ?>">
                                        <?php echo $cat['Nonmbre_Camp'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="pb-2  col-xs-12 col-sm-12 col-md-5 col-lg-5">
                            Curso: <br>
                            <select name="CboCursos" class="form-control col-xs-12 col-sm-12 col-md-12 col-lg-12" id="CboCursos">

                            </select>
                        </div>
                        <div class="pb-2  col-xs-12 col-sm-12 col-md-2 col-lg-2">
                            <a href="#formularioAsignacionManual" id="btnAsiganrProspectos" class="btn btn-primary " rel="modal:open">Asiganar prospectos</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class='table p-0 m-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12' id='tablaProspectos'>
                        <thead class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <tr class=" col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <th>N°</th>
                                <th class="w-25">Cliente</th>
                                <th class="w-25">Correo_electronico</th>
                                <th class="w-25">Telefono</th>
                                <th class="w-25">Pais</th>
                                <th class="w-25">Personal</th>
                                <th class="w-25">Seguimiento</th>

                            </tr>
                        </thead>
                        <tbody id="cargarDatosProspectos">

                        </tbody>
                    </table>
                </div>
                <div class="holder holderBase"></div>
            </div>


            <div class="d-none col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12" id="ventas">
                <div class="d-block col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-1 p-2 d-md-flex justify-content-between align-items-center">
                    <div class="col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        <label for="">Estado</label>
                        <select name="CboEstadoVenta" class="col-xs-12 col-sm-12 col-md-10 col-lg-10" id="CboEstadoVenta">
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
                    <div class="col-12 col-xs-12 col-sm-12 col-md-3 col-lg-3">
                        <label for="">Fecha Inicio</label></br>
                        <input id="fecha_inicio" class="col-xs-12 col-sm-12 col-md-6 col-lg-6" type="date" name="fecha_inicio" value="<?php echo $fecha_sumada; ?>" required />
                    </div>
                    <div class="col-12 col-xs-12 col-sm-12 col-md-3 col-lg-3">
                        <LAbel>Fecha Fin</LAbel></br>
                        <input id="fecha_final" class="col-xs-12 col-sm-12 col-md-6 col-lg-6" type="date" name="fecha_final" value="<?php echo $fecha_actual; ?>" required />
                    </div>
                    <div class="group-exportar p-0 m-0 col-2 col-xs-2 col-sm-2 col-md-2 col-lg-2  d-flex justify-content-center align-items-center">
                        <button type='submit' id='export_data' name='export_data' value='Export to excel' class='btn btn-info col-xs-12 col-sm-12 col-md-12 col-lg-12'><img src='<?php echo $urlProyecto ?>IMAGENES/export_csv.png' alt=''>Exportar Ventas</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class='p-0 m-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12' id='tabla'>
                        <thead class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <tr class=" col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <th>N°</th>
                                <th class="w-25">Cliente</th>
                                <th class="w-25">Correo_electronico</th>
                                <th class="w-25">Telefono</th>
                                <th class="w-25">Pais</th>
                                <th class="w-25">Personal</th>
                                <th class="w-25">Seguimiento</th>

                            </tr>
                        </thead>
                        <tbody id="cargarDatosProspectos">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



    <script src="js/scripCarrucelPersonal.js"></script>
    <!-- <script src="../../JS/jquery-3.5.1.min.js"></script> -->
    <script src="<?php echo $urlProyecto ?>JS/BOOTSTRAP/bootstrap.min.js"></script>
    <script src="../../JS/BOOTSTRAP/popper.min.js"></script>
    <!-- datatables JS -->
    <script type="text/javascript" src="../../DataTables/datatables.min.js"></script>
    <!-- para usar botones en datatables JS -->
    <script src="../../DataTables/Buttons-1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="../../DataTables/JSZip-2.5.0/jszip.min.js"></script>
    <script src="../../DataTables/pdfmake-0.1.36/pdfmake.min.js"></script>
    <script src="../../DataTables/pdfmake-0.1.36/vfs_fonts.js"></script>
    <script src="../../DataTables/Buttons-1.7.1/js/buttons.html5.min.js"></script>
    
    <script src="../../JS/modals/jquery.modal.min.js"></script>
    <script src="../../JS/scrip_general.js?hds" type="module"></script>
    <!-- <script src="../../JS/BOOTSTRAP/bootstrap.js"></script> -->
    <script src="../../JS/BOOTSTRAP/popper.min.js"></script>
    <script src="../../JS/scripAreaPersonal.js?bdgs" type="module"></script>
</body>

</html>