<?php
$respProspecto = isset($_SESSION["asistenteLogeado"]) ? "Prospectos a Cargo" : "Total Prospectos";
$respVentasAbiertas = isset($_SESSION["asistenteLogeado"]) ? "Ventas abiertas" : "Total Ventas abiertas";
$respVentas = isset($_SESSION["asistenteLogeado"]) ? "Tus Ventas" : "Total Ventas";
$fecha_actual = date("Y-m-d");
$fecha_sumada = date("Y-m-d", strtotime($fecha_actual . "- 30 days"));
?>

<div class="row mb-2 contenedor_dashboard col-xs-12 col-sm-12 col-md-12 col-lg-12 m-0" id="">
    <div class="contenCaja1 conten col-xs-12 col-sm-12 col-md-12 col-lg-3 " id="gbTotalProspectos">
        <div class="contenInfo_logo">
            <div class="contenInfo">
                <div>
                    <h2 class="dNumeroTotal"></h2>
                    <span class="dDescripcionTotal"><?php echo $respProspecto ?></span>
                </div>
            </div>
            <div class="contenLogo">
                <span class="fas fa-users"></span>
            </div>
        </div>
        <div class="contenEstActual estadoActua1">
            <div>
                <span class="dNumeroTotalHoy">.</span>
                <span>.</span>
            </div>
        </div>
    </div>
    <div class="contenCaja2 conten col-xs-12 col-sm-12 col-md-12 col-lg-3" id="gbProspectosSeguidos">
        <div class="contenInfo_logo">
            <div class="contenInfo">
                <div>
                    <h2 class="dNumeroCSeguimiento"></h2>
                    <span class="dDescripcionCSeguimiento">Pros. en Seguimiento </span>
                </div>
            </div>
            <div class="contenLogo">
                <span class="fas fa-user-edit"></span>
            </div>
        </div>
        <div class="contenEstActual estadoActua2">
            <div>
                <span class="dNUmeroCSeguimientoHoy">.</span>
                <span>.</span>
            </div>
        </div>
    </div>
    <div class="contenCaja3 conten col-xs-12 col-sm-12 col-md-12 col-lg-3" id="gbTotalVentas">
        <div class="contenInfo_logo">
            <div class="contenInfo">
                <div>
                    <h2 class="dNumeroTotalVentas"></h2>
                    <span class="dDescripcionSinSeguimiento"><?php echo $respVentas ?></span>
                </div>
            </div>
            <div class="contenLogo">
                <span class="fas fa-hand-holding-usd"></span>
            </div>
        </div>
        <div class="contenEstActual estadoActua3">
            <div>
                <span class="dNumeroTotalVentasHoy">.</span>
                <span>.</span>
            </div>
        </div>
    </div>
    <div class="contenCaja4 conten col-xs-12 col-sm-12 col-md-12 col-lg-2" id="gbVentas">
        <div class="contenInfo_logo">
            <div class="contenInfo">
                <div>
                    <h2 class="dNumeroVentas"></h2>
                    <span class="dDescripcionSinSeguimiento"><?php echo $respVentasAbiertas; ?> </span>
                </div>
            </div>
            <div class="contenLogo">
                <span class="fas fa-coins"></span>
            </div>
        </div>
        <div class="contenEstActual estadoActua3">
            <div>
                <span class="dNumeroVentasHoy">.</span>
                <span>.</span>
            </div>
        </div>
    </div>

</div>
<div class="z-index-none m-auto contenGraficos col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
    <div class="card-header">
        <div class="ContenedorBuscarPorFechas d-block col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-1 p-2 d-md-flex justify-content-left align-items-center">
            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                Campaña: <br>
                <select name="CboCampania" class="form-control col-xs-12 col-sm-12 col-md-6 col-lg-6" id="CboCampania">

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
            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                Curso: <br>
                <select name="CboCursos" class="form-control col-xs-12 col-sm-12 col-md-6 col-lg-6" id="CboCursos">

                </select>
            </div>
        </div>
        <div class="d-block col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-1 p-2 d-md-flex justify-content-between align-items-center">
            <input type="hidden" name="txtItemABuscar" id="txtItemABuscar" value="totalVentas" style="">
            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                <label for="">FECHA INICIO</label></br>
                <input id="fecha_inicio" class="form-control col-xs-12 col-sm-12 col-md-6 col-lg-6" type="date" name="fecha_inicio" value="<?php echo $fecha_sumada; ?>" required />
            </div>
            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                <LAbel>FECHA FIN</LAbel></br>
                <input id="fecha_final" class="form-control col-xs-12 col-sm-12 col-md-6 col-lg-6" type="date" name="fecha_final" value="<?php echo $fecha_actual; ?>" required />
            </div>
            <div class="mt-3 mt-md-0col-xs-2 col-sm-2 col-md-2 col-lg-2  d-flex justify-content-center align-items-center">
                <label for=""></label></br>
                <button id="btnBuscarEstadistica" class="btn col-xs-9 col-sm-9 col-md-9 col-lg-9">buscar</button>
            </div>
        </div>
    </div>


    <div class="m-0 mt-3 mt-md-5 p-0 col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="card-header mb-2 m-0 d-flex col-12">
            <h4 class="card-title m-0 col-12">Estadisticas Venta</h4>
        </div>
        <div class="d-md-flex p-0 col-lg-12" id="contenGraficos" style="width: 100%;">
            <div class="mr-1 col-lg-8" style="background-color: #F7F7F7;">
                <canvas id="GraficoFiltrado" style="background-color: #F7F7F7;"></canvas>
            </div>
            <div class="ml-1 mt-3 mt-md-0 p-0 col-lg-4" style="background-color: #F7F7F7;">
                <div class="card-header m-0  col-12">
                    <h4 class="card-title m-0 col-12">Ventas recientes</h4>

                    <div class="col-12 mt-2 d-flex" style="border-bottom: solid 1px #ccc;">
                        <div class="text-left m-0 p-0 col-5 col-md-4">Alumno</div>
                        <div class="text-left m-0 p-0 col-md-3">Modalidad</div>
                        <div class="text-center d-none d-md-block m-0 p-0 col-3">Curso</div>
                        <div class="text-center m-0 p-0 col-3 col-md-2">Importe</div>
                    </div>
                </div>
                <div class="col-12 pb-3" id="cargarUltimasVentas">

                </div>
            </div>
        </div>

        <div class="card-header mt-5  m-0 d-flex col-12">
            <h4 class="card-title m-0 col-12">Estadisticas Cursos</h4>
        </div>
        <div class="mt-2 mt-md-5 mt-md-1 d-md-flex p-0 col-lg-12" id="contenGraficos" style="width: 100%;">
            <div class="mr-1 col-lg-8" style="background-color: #F7F7F7;">
                <!-- <canvas id="GraficoFiltrado" style="background-color: #F7F7F7;"></canvas> -->
                <canvas id="graficopie" style="background-color: #F7F7F7;"></canvas>
            </div>
            <div class="ml-1 mt-3 mt-md-0 p-0 col-lg-4" style="background-color: #F7F7F7;">
                <div class="card-header m-0 col-12">
                    <h4 class="card-title m-0 col-12">Cursos con mas alumnado</h4>

                    <div class="m-0 p-0 col-12 mt-2 d-flex" style="border-bottom: solid 1px #ccc;">
                        <div class="text-left m-0 p-0 col-10 col-md-10">Curso</div>
                        <div class="text-left m-0 p-0 col-2 col-md-2">Alumnos</div>
                    </div>
                </div>
                <div class="col-12 pb-3" id="cargarCursosMayorAlumnado">

                </div>
            </div>
        </div>
        <!-- <div class="bg-success mt-5 d-flex p-0 col-lg-12" id="contenGraficos" style="width: 100%;">

            <div class=" bg-warning m-0 col-lg-8">
            </div>
            <div class="col-lg-4">
            </div>
        </div> -->
        <div class="row col-lg-12 contenDatosSegunGraficas">
        </div>
    </div>
</div>