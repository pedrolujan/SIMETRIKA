<?php
session_start();
$idUsuario = 0;
if (isset($_SESSION["adminLogeado"])) {
    $idUsuario = 0;
} elseif (isset($_SESSION["asistenteLogeado"])) {
    $idUsuario = $_SESSION["asistenteLogeado"];
} elseif (isset($_SESSION["supervisorLogeado"])) {
    $idUsuario = 0;
}
include("../../model/url.php");
include('../../model/conexion.php');

?>
<div class="container col-xs-12 col-sm-12 col-md-12 col-lg-12 pb-0  d-flex mt-0 justify-content-center align-items-center">
    <div class="contenedorBuscarGeneral d-block  col-xs-12 col-sm-12  col-md-12 col-lg-12 d-md-flex">
        <div class="contenedorbuscar p-0 col-xs-12 col-sm-12 col-md-10 col-lg-10 d-block pb-3 fielset">
            <legend class="mb-0 col-xs-12 col-sm-12 col-md-10 col-lg-10">Buscar por:</legend>
            <div class="form-check col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="ContenedorBuscarPorFechas d-block col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-1 p-2 d-md-flex justify-content-left align-items-center">
                    <div class="conten-campania conten-combo pb-2 col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Campaña: <br>
                        <select name="CboCampaniaVenta" class="form-control col-xs-12 col-sm-12 col-md-12 col-lg-12" id="CboCampaniaVenta">
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
                    <div class="pb-2 col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Evento: <br>
                        <select name="CboCampania" class="form-control col-xs-12 col-sm-12 col-md-12 col-lg-12" id="CboCampania">

                            <option value="0">Todo</option>
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
                    <div class="pb-2 col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Curso: <br>
                        <select name="CboCursos" class="form-control col-xs-12 col-sm-12 col-md-12 col-lg-12" id="CboCursos">

                        </select>
                    </div>
                </div>
                Fechas
                <div class="ContenedorBuscarPorFechas d-block col-xs-12 col-sm-12 col-md-12 col-lg-12 m-0 p-2 d-md-flex justify-content-left align-items-center">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <label for="">Desde</label></br>
                        <input id="fecha_inicio" type="date" name="fecha_inicio" class="form-control col-xs-12 col-sm-12 col-md-12 col-lg-12" required />
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <label>Hasta</label></br>
                        <input id="fecha_final" type="date" name="fecha_final" class="form-control col-xs-12 col-sm-12 col-md-12 col-lg-12" required />
                    </div>
                </div>
                <!-- <div class="mt-3 p-2 ContenedorBuscarPorFechas d-flex" >

                    <div class="col-lg-5 d-block d-none">
                        pais
                        <select name="CboPais" id="CboPais">
                            <option value="0">Seleccione pais</option>
                            <?php
                            $con = new ApptivaDB();
                            $pais = $con->buscarTodo("pais", "Nombre_pais");
                            foreach ($pais as $cat) { ?>
                                <option value="<?php echo $cat['Codigo'] ?>">
                                    <?php echo $cat['Nombre_pais'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div> -->

            </div>
        </div>
        <div class="Contenedor_Loader" id="Contenedor_Loader">
            <div class="loader" id="loader"></div>
        </div>
        <form id="buscar" action="" class="col-xs-12 col-sm-12 col-md-2 col-lg-2 d-flex justify-content-center align-items-center">
            <!-- <input type="text" class="col-xs-8 col-sm-8 col-md-10 col-lg-10" id="text_buscar" placeholder="Buscar usuarios.." /> -->
            <button type="submit" id="btn_txtBuscar" class="btn_txtBuscar col-xs-12 col-sm-12 col-md-12 col-lg-12"><img src="<?php echo $urlProyecto ?>IMAGENES/search_simetrica.png" alt="">Buscar</button>

        </form>
    </div>
</div>
<div class="row p-1 m-0 col-xs-12 col-sm-12 col-md-12 col-lg-12 conten_cargar_datos" id="conten_cargar_datos">
    <div class='contenedorExportarDatos d-none  col-xs-12 col-sm-12 col-md-12 col-lg-12'>
        <h4> Exportar para</h4>
        <form class='d-block col-xs-12 col-sm-12 col-md-12 col-lg-12 d-md-flex justify-content-center align-items-center' action='../../controller/descargar_datos.php' method='post'>
            <div class='d-block col-xs-12 col-sm-12 col-md-10 col-lg-10 d-md-flex justify-content-between align-items-center'>
                <label class='col-xs-12 col-sm-12 col-md-3 col-lg-3'><input type='radio' name='rbexportar' id='rbCompleto' value='completo' checked>Exel (completo)<img src='<?php echo $urlProyecto ?>IMAGENES/todo.png' alt='' srcset=''></label>
                <label class='col-xs-12 col-sm-12 col-md-3 col-lg-3'><input type='radio' name='rbexportar' id='rbSendinBlue' value='Sendinblue'>Sendinblue<img src='<?php echo $urlProyecto ?>IMAGENES/sendinblue.png' alt='' srcset=''> </label>
                <label class=' col-xs-12 col-sm-12 col-md-3 col-lg-3'><input type='radio' name='rbexportar' id='rbContactos' value='Contactos'>Contactos <img src='<?php echo $urlProyecto ?>IMAGENES/googleContact.png' alt='' srcset=''> </label>
            </div>
            <input type="hidden" name="txtCampaniaGeneral" id="txtCampaniaGeneral">
            <input type="hidden" name="txtEvento" id="txtEvento">
            <input type="hidden" name="txtCurso" id="txtCurso">
            <input type="hidden" name="txtidPersonal" id="txtidPersonal" value="<?php echo $idUsuario; ?>">
            <input type="hidden" name="txtFechaIni" id="txtFechaIni">
            <input type="hidden" name="txtFechaFinal" id="txtFechaFinal">
            <div class='mt-3 col-xs-12 col-sm-12 col-md-2 col-lg-2 d-flex justify-content-center align-items-center'>
                <button type='submit' id='export_data' name='export_data' value='Export to excel' class='btn btn-info col-xs-12 col-sm-12 col-md-12 col-lg-12'><img src='<?php echo $urlProyecto ?>IMAGENES/export_csv.png' alt=''>Exportar</button>
            </div>
        </form>
    </div>
    <div class='contenedorContador d-flex align-items-center' id='contenedorContador'>

        <a href="#frmReguistrarProspectos" rel="modal:open" class='icon-plus contenBtnAdd'></a>
        <div class='contador'></div>
    </div>
    <div class="col-12 responsive p-0">
        <table id="tableProspectos" class='table  table-responsive-md table-responsive-col'>
            <thead>
                <tr>
                    <th class="col-1">N°</th>
                    <th class="col-3">Cliente</th>
                    <th class="col-2">Correo_electronico</th>
                    <th class="col-2">Telefono</th>
                    <th class="col-1">Pais</th>
                    <th class="col-2">Curso</th>
                    <th class="col-1">Seguimiento</th>
                </tr>
            </thead>
            <tbody id="tbofy">
            </tbody>


        </table>
    </div>


    <!-- <div class="contenPaginacion">
        <span>Paginacion:</span>

        <div class="holder"></div>
    </div> -->
</div>




<!-- <nav aria-label="Page navigation example">
    <ul class="pagination">
        <li class="page-item">
            <a class="page-link" href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
            </a>
        </li>
        <li class="page-item"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item"><a class="page-link" href="#">1</a></li>
        <li class="page-item">
            <a class="page-link" href="#" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
            </a>
        </li>
    </ul>
</nav> -->
<!-- <script type="module" src="<?php echo $urlProyecto ?>JS/scripPagClientes.js"></script> -->