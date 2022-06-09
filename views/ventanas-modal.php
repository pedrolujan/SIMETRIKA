<?php
// require_once("../../model/url.php");
// require_once("../../model/Clases.php");


?>
<form action="#" method="post" id="formularioAsignacionManual" class="p-0 modal modalAsignarProspectos" enctype="multipart/form-dat">
    <h4 class="mb-0 p-2">Asignar Prospectos</h4>

    <h5 id="txtPersonalact" class="mt-0 text-left"> </h5>
    <div class="d-block p-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 d-lg-flex">
        <div class="text-left col-12 col-xs-12 col-sm-12 col-md-6 col-lg-6 d-block">
            <label class="m-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12"> Cunantos desea seleccionar:</label>
            <input type="text" name="txtCantidadItemsActivar" id="txtCantidadItemsActivar">
        </div>
    </div>
    <input type="hidden" name="txtMidPersonal" id="txtMidPersonal">
    <div class="contenedorAgignanarProspectos mt-2 p-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 d-lg-flex">
        <div class="contenedorCargarProspectos  m-0 p-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-7">
            <div id="contenedorProspectos" class="contenedorProspectos m-0 p-3 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">


            </div>

        </div>
        <div class="contenedorCargarPersonal ml-auto mr-auto p-2 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-5">

            <div class="group-combo text-left col-12 col-xs-12 col-sm-12 col-md-12 col-lg-11">
                <label for="" class="">Personal</label>
                <select name="cboidUsuarioPersonal" id="cboidUsuarioPersonal" class="mt-2 col-11 col-xs-11 col-sm-11 col-md-12 col-lg-12">
                    <option value="0">Seleccione Personal</option>
                    <?php
                    $user = new ApptivaDB();
                    $categorias = $user->buscarGeneral(
                        "u.idUsuario,p.per_nombre,p.per_apellido_paterno,c.nombreCargo",
                        "personal p
                        INNER JOIN  usuarios u ON u.ID_PERSONAL=p.idPersonal
                        INNER JOIN cargos c ON c.idCargo=u.ID_CARGO",
                        "u.ID_CARGO='3'"
                    );
                    foreach ($categorias as $cat) :   ?>
                        <option value="<?php echo $cat['idUsuario']; ?>">
                            <?php echo $cat['per_nombre'] . " " . $cat['per_apellido_paterno'] . ":  => " . $cat['nombreCargo']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>

            </div>
            <div class="group-vacio col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
            </div>
            <div class="msgAsignacion mb-3 p-2" id="msgAsignacion"></div>
            <div class="group-boton text-center m-auto col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <button id="btnGuardarAsignacion" class=" m-auto  col-12 col-xs-12 col-sm-12 col-md-8 col-lg-8">Guardar Asignacion</button>
            </div>
        </div>
    </div>
    <div class="holder holderModal"></div>

</form>
<form action="#" method="post" id="formulariosBuscarCliente" class="modal p-0 col-11 col-xs-10 col-sm-10 col-md-8 col-lg-8" enctype="multipart/form-dat">
    <h6 class="mt-0">Buscar en:</h6>
    <div class="m-0 p-0 tabcontent contenedorBuscarCliente col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="text-left d-flex tab col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label for="rbCliente" class="lblRbCliente">
                CLiente:
                <input type="radio" name="rbtipoBusqueda" id="rbCliente" value="0">
            </label>
            <label for="rbProspecto" class="ml-5 lblRbProspecto">
                Prospecto:
                <input type="radio" name="rbtipoBusqueda" id="rbProspecto" value="1" checked>
            </label>
        </div>
        <div class="m-0 p-0  contenCliente col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12" id="contenCliente">
            <div class="m-0 p-0 contenBuscador col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="m-0 p-0 tab pb-2 contenCampanias  col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 d-lg-flex">
                    <div class="contenCampaniaBusq text-left  col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4">
                        <label for="">Campaña</label>
                        <select name="" id="cboCampaniaModal" class="form-control col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <option value="0">Seleccione Campaña</option>
                            <?php
                            $user = new ApptivaDB();
                            $categorias = $user->buscarConsultas("C.idCampania,C.cNombreCampania", "campaniassmtk C", "'1' ORDER BY C.idCampania DESC");
                            foreach ($categorias as $cat) :   ?>
                                <option value="<?php echo $cat['idCampania'] ?>">
                                    <?php echo $cat['cNombreCampania'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class=" text-left  divdinamicosBusqueda mt-3 mt-lg-0 col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4">
                        <label for="">Eventos</label>
                        <select name="" id="cboEventoModal" class="form-control col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <option value="0">Seleccione Evento</option>
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
                    <div class=" text-left divdinamicosBusqueda mt-3 mt-lg-0 col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4">
                        <label for="">cursos</label>
                        <select name="" id="cboCursosXevento" class="form-control col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        </select>
                    </div>
                </div>
                <div class="contenFechas tab pb-2 m-0 p-0  d-lg-flex col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class=" text-left mt-3 mt-lg-0 col-xs-12 col-sm-12 col-md-6 col-lg-4">
                        <label for="">Desde:</label></br>
                        <input id="fecha_inicio" class="form-control col-xs-12 col-sm-12 col-md-12 col-lg-12" type="date" name="fecha_inicio" value="<?php echo $fecha_sumada; ?>" />
                    </div>
                    <div class="text-left mt-3 mt-lg-0 col-xs-12 col-sm-12 col-md-6 col-lg-4">
                        <LAbel>Hasta:</LAbel></br>
                        <input id="fecha_final" class="form-control col-xs-12 col-sm-12 col-md-12 col-lg-12" type="date" name="fecha_final" value="<?php echo $fecha_actual; ?>" />
                    </div>
                    <div class="text-left mt-3 mt-lg-0 col-xs-12 col-sm-12 col-md-6 col-lg-4">
                        <label for="">Datos a buscar</label>
                        <input type="text" name="txtBuscarClienteModal" id="txtBuscarClienteModal" placeholder="cliente a buscar..." class="form-control col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    </div>
                </div>
            </div>
            <div class="contenTabla table-responsive col-12">
                <table class="table table-hover" id="tabla">
                    <thead>
                        <tr>
                            <th class="col-1">n°</th>
                            <th class="col-4" id="headerNombresAlumno">Prospecto</th>
                            <th class="col-4">Correo</th>
                            <th class="col-3">Telefono</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyBuscarClientes">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="contenPaginacion">
        <span>Paginacion:</span>

        <div class="holder"></div>
    </div>
</form>
<form action="#" method="post" id="formulariosBuscarClienteConCuotas" class="modal p-0 col-11 col-xs-10 col-sm-10 col-md-8 col-lg-8" enctype="multipart/form-dat">
    <h6>Buscar Ventas</h6>
    <div class="m-0 p-0 tabcontent contenedorBuscarCliente col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="m-0 p-0  contenCliente col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12" id="contenCliente">
            <div class="m-0 p-0 contenBuscador col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="m-0 p-0 tab pb-2 contenCampanias col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex">
                    <div class=" text-left col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        <label for="">Campaña</label>
                        <select name="" id="cboCampaniaModal" class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <option value="0">Seleccione Campaña</option>
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

                </div>
                <div class="contenFechas tab pb-2 m-0 p-0  d-lg-flex col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class=" text-left col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        <label for="">Desde:</label></br>
                        <input id="fecha_inicio" class=" col-xs-12 col-sm-12 col-md-12 col-lg-12" type="date" name="fecha_inicio" value="<?php echo $fecha_sumada; ?>" />
                    </div>
                    <div class="text-left col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        <LAbel>Hasta:</LAbel></br>
                        <input id="fecha_final" class="col-xs-12 col-sm-12 col-md-12 col-lg-12" type="date" name="fecha_final" value="<?php echo $fecha_actual; ?>" />
                    </div>
                    <div class="text-left col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        <label for="">Cod Venta</label>
                        <input type="text" name="txtBuscarClientedCuotas" id="txtBuscarClientedCuotas" placeholder="Venta a buscar..." class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    </div>
                </div>
            </div>
            <div class="contenTabla table-responsive">
                <table class="table table-hover" id="tabla">
                    <thead>
                        <tr>
                            <th>n°</th>
                            <th>Campania</th>
                            <th>Cod_Venta</th>
                            <th>Fecha_Venta</th>
                            <th>Tatal_Venta</th>
                            <th>N° Cuotas</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyBuscarClientesCuotas">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- <div class="contenPaginacion">
        <span>Paginacion:</span> -->

    <div class="holder"></div>
    <!-- </div> -->
</form>
<form action="#" method="post" id="formulariosDetallePago" class="modal p-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12" enctype="multipart/form-dat">
    <h6 class="text-left">Detalles del pago</h6>
    <input type="hidden" name="txtIdCuota" id="txtIdCuota">
    <input type="hidden" name="txtIdDetallePago" id="txtIdDetallePago">
    <div class=" tab text-left col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="mt-3 p-0 tab text-left col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h6>Datos de Venta</h6>
            <div class="p-3  tab text-left col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 d-lg-flex">
                <div class="mt-3 mt-lg-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-3">
                    <p class=" d-flex m-0 p-0">Campaña</p>
                    <input type="text" class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-12" name="txt-campania_VC" id="txt-campania_VC" readonly>
                </div>
                <div class="mt-3 mt-lg-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-3">
                    <p class=" d-flex m-0 p-0">Codigo</p><input type="text" class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-12" name="txt-codVenta_VC" id="txt-codVenta_VC" readonly>
                </div>
                <div class="mt-3 mt-lg-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-3">
                    <p class=" d-flex m-0 p-0">Fecha de Venta</p><input type="text" class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-12" name="txt-FechaDeVenta_VC" id="txt-FechaDeVenta_VC" readonly>
                </div>
                <div class="mt-3 mt-lg-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-3">
                    <p class=" d-flex m-0 p-0">Importe Total</p><input type="text" class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-12" name="txt-importeTotal_VC" id="txt-importeTotal_VC" readonly>
                </div>
            </div>

        </div>
        <div class="mt-3 p-0 tab text-left col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h6>Datos de Cuota:</h6>
            <div class="p-3 d-lg-flex tab justify-content-evenly col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="mt-3 mt-lg-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2"><span>Codigo</span><input type="text" class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12" name="txt-codCuota_CC" id="txt-codCuota_CC" readonly></div>
                <div class="mt-3 mt-lg-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2"><span>Fecha de Pago</span><input type="text" class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12" name="txt-fechaPago_CC" id="txt-fechaPago_CC" readonly></div>
                <div class="mt-3 mt-lg-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-3"><span>Importe</span><input type="text" class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12" name="txt-importCuota_CC" id="txt-importCuota_CC" readonly></div>
                <div class="mt-3 mt-lg-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2"><span>Tipo Pago</span><input type="text" class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12" name="txt-tipoPago_CC" id="txt-tipoPago_CC" readonly></div>
                <div class="mt-3 mt-lg-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-3"><span>Entidad Pago</span><input type="text" class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12" name="txt-entidadPago_CC" id="txt-entidadPago_CC" readonly></div>
            </div>
        </div>
        <div class="p-0 mb-5 mt-3 tab col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h6 class="text-left">Boucher:</h6>
            <div class=" p-3 text-center m-auto group-imagenBoucher-consultas col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                <img src="" id="imgBoucherDetallePagoConsulta" class="col-12 col-xs-12 col-sm-12 col-md-8 col-lg-8">
            </div>
        </div>
    </div>



</form>
<form action="#" method="post" id="formulariosGuardarPagoCuota" class="modal p-0 col-11 col-xs-10 col-sm-10 col-md-8 col-lg-8" enctype="multipart/form-dat">
    <h6>Guardar pago</h6>
    <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="mt-3 p-0 tab text-left col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <input type="hidden" name="txtIdClientePagoCuota" id="txtIdClientePagoCuota">
            <h6>Datos de Venta</h6>
            <div class="p-3  tab text-left col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 d-lg-flex">
                    <div class="mt-3 mt-lg-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-3">
                        <p class=" d-flex m-0 p-0">Campaña</p>
                        <input type="text" class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-12" name="txt-campania_VPC" id="txt-campania_VPC" readonly>
                    </div>
                    <div class="mt-3 mt-lg-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-3">
                        <p class=" d-flex m-0 p-0">Codigo</p><input type="text" class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-12" name="txt-codVenta_VPC" id="txt-codVenta_VPC" readonly>
                    </div>
                    <div class="mt-3 mt-lg-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-3">
                        <p class=" d-flex m-0 p-0">Fecha de Venta</p>

                        <input type="text" class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-12" name="txt-FechaDeVenta_VPC" id="txt-FechaDeVenta_VPC" readonly>
                    </div>
                    <div class="mt-3 mt-lg-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-3">
                        <p class=" d-flex m-0 p-0">Importe Total</p>
                        <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex">
                            <span class="lblSimboloMonedaCuota">$</span>
                            <input type="text" class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-12" name="txt-importeTotal_VPC" id="txt-importeTotal_VPC" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-lg-3">
                    <div class="mt-3 mt-lg-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-3">
                        <p class=" d-flex m-0 p-0">Importe Restante</p>
                        <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex">
                            <span class="lblSimboloMonedaCuota">$</span>
                            <input type="text" class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-12" name="txt-importeRestante_VPC" id="txt-importeRestante_VPC" readonly>
                        </div>
                        <input type="hidden" class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-12" name="txt-TotalCuotas_VPC" id="txt-TotalCuotas_VPC" readonly>
                        <input type="hidden" class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-12" name="txt-CuotasPagadas_VPC" id="txt-CuotasPagadas_VPC" readonly>
                        <input type="hidden" class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-12" name="txt-restaDeCuotas_VPC" id="txt-restaDeCuotas_VPC" readonly>
                        <input type="hidden" class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-12" name="txtTipoMonedaCuota" id="txtTipoMonedaCuota" readonly>
                    </div>
                </div>

            </div>

        </div>
        <div class="mt-3 p-0 tab text-left col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h6>Datos de Cuota:</h6>
            <div class="p-3  tab justify-content-evenly col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="d-lg-flex col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <input type="hidden" name="txt-idCuota_CPC" id="txt-idCuota_CPC" readonly>

                    <div class="mt-3 mt-lg-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-2">
                        <spann class="">Codigo</span>
                            <input type="text" class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12" name="txt-codCuota_CPC" id="txt-codCuota_CPC" readonly>
                    </div>
                    <div class="mt-3 d-block mt-lg-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <span class=" col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">Fecha de Pago</span>
                        <input type="date" class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-11" name="txt-fechaPago_CPC" id="txt-fechaPago_CPC">
                    </div>
                    <div class="mt-3 mt-lg-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <span class="">Importe</span>
                        <div class="divImporteCuota col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex">
                            <span class="lblSimboloMonedaCuota">$</span>
                            <input type="text" class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12" name="txt-importCuota_CPC" id="txt-importCuota_CPC">
                        </div>
                    </div>
                </div>
                <div class="mt-3 d-lg-flex col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="mt-3 mt-lg-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <span class="">Tipo Pago</span>
                        <select name="CboTipoPagoCuota" class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12" id="CboTipoPagoCuota">
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
                    </div>
                    <div class="mt-3 mt-lg-0 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-4">
                        <span class="">Entidad Pago</span>

                        <select name="CboEntidadPagoCuota" class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12" id="CboEntidadPagoCuota">

                        </select>
                    </div>

                </div>

            </div>
            <div class="group-item p-0 mt-3 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12  justify-content-center">
                <h6 class="text-left">Anexar Comprobante</h4>
                    <input type="file" name="imgBoucherPagoCuota" id="imgBoucherPagoCuota" style="display: none;">
                    <div class="contenedorRecibo">
                        <img src="" class=" rounded mx-auto d-block" id="imagenBoucherCuota" alt="" width="auto" srcset="">
                        <div class="divBoton divBotonPagoCuota">
                            <div>
                                <span class="fas fa-file-image"></span><br>
                                <p for="">Subir archivo</p>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        <div id="divMsgModal"></div>
        <div class="contenedorBoton  m-0 col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-content-center">
            <input type="submit" value="Guardar Pago" class="btnGuardarPagoDeCuota" id="btnGuardarPagoDeCuota">
        </div>

    </div>


</form>

<form action="#" method="post" id="formulariosBuscarCurso" class="modal-super p-0 col-11 col-xs-10 col-sm-10 col-md-8 col-lg-8">
    <div class="header-modal d-flex justify-content-between">
        <h6 class="">Seleccionar cursos</h6><span class="">X</span>
    </div>
    <!-- <div class="group-filtroBusq-curso text-left col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <select name="" id="" class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
            <option value="0">Seleccione Tipo Precio</option>
            <option value="0">Precio Normal</option>
            <option value="1">Precio Alumno</option>
        </select>
    </div> -->
    <div class="contenedorCargarCursos text-left p-4" id="contenedorCargarCursos">

    </div>
    <div class="contenedorBtnModal d-flex justify-content-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <a href="#" id="btnCapturarCursos" class="text-center">Aceptar </a>
    </div>
    <div class="holder"></div>
</form>
<form action="#" method="post" id="formulariosBuscarEventoClase" class="modal p-0 col-11 col-xs-10 col-sm-10 col-md-8 col-lg-8">
    <h5 class="mb-0 pl-3 text-left">Buscar Curso</h5>
    <div class="col-12 p-2 d-flex" style="border-bottom: solid 1px #ccc;">
        <span class="col-6 ">Clase</span>
        <span class="col-3 ">
            Precio
        </span>
        <span class="col-3"> Modalidad</span>
    </div>
    <!-- <div class="group-filtroBusq-curso text-left col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <select name="" id="" class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
            <option value="0">Seleccione Tipo Precio</option>
            <option value="0">Precio Normal</option>
            <option value="1">Precio Alumno</option>
        </select>
    </div> -->
    <div class="contenedorCargarEventos text-left pl-2 pr-2 pt-0 mb-4 overflow-auto" id="contenedorCargarEventos">

    </div>
    <div class="contenedorBtnModal mt-5 conten-boton d-flex justify-content-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <a href="#" id="btnCapturarEventosClase" class="text-center col-4 p-2">Aceptar </a>
    </div>
    <div class="holder"></div>
</form>

<form action="#" method="post" id="formulariosFiltrar" class="modal p-0 col-11 col-xs-10 col-sm-10 col-md-8 col-lg-8">
    <h5 class="mb-0">Filtrar Busqueda</h5>
    <div class="ContenedorFiltrar mt-0 col-xs-12 col-sm-12 col-md-12 col-lg-12  p-2 d-md-flex justify-content-left align-items-center">
        <div class="conten-campania conten-combo pb-2  p-1 col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 text-left">
            Campaña: <br>
            <select name="CboCampania_fl" class=" form-control border-1 m-0 col-xs-12 col-sm-12 col-md-12 col-lg-12" id="CboCampania_fl">
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
        <div class="pb-2  p-1 col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 text-left">
            Modalidad: <br>
            <select name="CboModalidad_fl" class="form-control border-1 col-xs-12 col-sm-12 col-md-12 col-lg-12" id="CboModalidad_fl">
                <option value="'0'">Todo</option>
                <?php
                $user = new ApptivaDB();
                $estadoVenta = $user->buscarGeneral("cCodTab ,cNomTab", "tablacod", "cCodTab LIKE 'MODV%' AND cCodTab<>'MODV0000'");
                foreach ($estadoVenta as $cat) :   ?>
                    <option value="'<?php echo $cat['cCodTab'] ?>'">
                        <?php echo mb_convert_case($cat['cNomTab'], MB_CASE_TITLE, "UTF-8") ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="pb-2  p-1 col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 text-left">
            Estado: <br>
            <select name="CboEstado_fl" class="form-control border-1 col-xs-12 col-sm-12 col-md-12 col-lg-12" id="CboEstado_fl">
                <option value="'0'">Todo</option>
                <?php
                $user = new ApptivaDB();
                $estadoVenta = $user->buscarGeneral("cCodTab ,cNomTab", "tablacod", "cCodTab LIKE 'ESEV%' AND cCodTab<>'ESEV0000'");
                foreach ($estadoVenta as $cat) :   ?>
                    <option value="'<?php echo $cat['cCodTab'] ?>'">
                        <?php echo mb_convert_case($cat['cNomTab'], MB_CASE_TITLE, "UTF-8") ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="ContenedorFiltrar mt-0 col-xs-12 col-sm-12 col-md-12 col-lg-12  p-2 d-md-flex justify-content-left align-items-center">
        <div class="pb-2 text-left  col-12 col-xs-12 col-sm-12 col-md-10 col-lg-10">
            Docentes: <br>
            <select name="CboDocente_fl" class="form-control border-1 col-xs-12 col-sm-12 col-md-12 col-lg-12" id="CboDocente_fl">
                <option value="'0'">Todo</option>
                <?php
                $user = new ApptivaDB();
                // $estadoVenta = $user->EjecutarProcedimiento("sp_listarPersonal", "");
                $estadoVenta = $user->buscarConsultas(
                    "dc.idDocente,ga.Abreviatura,dc.Nombes,dc.Apellidos",
                    "docentes dc
                    INNER JOIN gradoacademico ga ON dc.fk_GradoAcademico=ga.idGradoAc",
                    "'1'"
                );
                foreach ($estadoVenta as $cat) :   ?>
                    <option value="'<?php echo $cat['idDocente'] ?>'">
                        <?php echo mb_convert_case($cat['Abreviatura'] . " " . $cat["Nombes"] . " " . $cat["Apellidos"], MB_CASE_TITLE, "UTF-8") ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="ContenedorFiltrar mb-3 d-block col-xs-12 col-sm-12 col-md-12 col-lg-12 m-0 pb-3 d-md-flex justify-content-left align-items-center">
        <div class="text-left col-xs-12 col-sm-12 col-md-5 col-lg-6">
            Desde:</br>
            <input id="fecha_in_fl" type="date" name="fecha_in_fl" class="fechasBusqueda form-control border-1 col-xs-12 col-sm-12 col-md-12 col-lg-11" required />
        </div>
        <div class="text-left col-xs-12 col-sm-12 col-md-5 col-lg-6">
            Hasta:</br>
            <input id="fecha_fin_fl" type="date" name="fecha_fin_fl" class="fechasBusqueda form-control border-1 col-xs-12 col-sm-12 col-md-12 col-lg-11" required />

        </div>
    </div>

</form>

<!-- //codigo para agregar un nuevo evento -->
<form action="#" method="post" id="formularioNuevoEvento" class="modal p-0 col-11 col-xs-10 col-sm-10 col-md-8 col-lg-8">
    <h5 class="mb-0 text-left">Registrar Clase</h5>
    <div class=" mt-0 col-xs-12 col-sm-12 col-md-12 col-lg-12  p-2 d-md-flex justify-content-left align-items-center">
       
        <div class="conten-campania conten-combo pb-2  p-1 col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 text-left">
            Campaña: <br>
            <select name="CboCampania_NV" class=" form-control border-1 m-0 col-xs-12 col-sm-12 col-md-12 col-lg-12" id="CboCampania_NV">
                <option value="0">Selec. Campaña</option>
                <?php
                $user = new ApptivaDB();
                $categorias = $user->buscarConsultas("idCampania,cNombreCampania", "campaniassmtk", "'1' ORDER BY idCampania DESC");
                foreach ($categorias as $cat) :   ?>
                    <option value="<?php echo $cat['idCampania'] ?>">
                        <?php echo $cat['cNombreCampania'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="pb-2  p-1 col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 text-left">
            Modalidad: <br>
            <select name="CboModalidad_NV" class="form-control border-1 col-xs-12 col-sm-12 col-md-12 col-lg-12" id="CboModalidad_NV">
                <option value="'0'">Seleccione Modalidad</option>
                <?php
                $user = new ApptivaDB();
                $estadoVenta = $user->buscarGeneral("cCodTab ,cNomTab", "tablacod", "cCodTab LIKE 'MODV%' AND cCodTab<>'MODV0000'");
                foreach ($estadoVenta as $cat) :   ?>
                    <option value="'<?php echo $cat['cCodTab'] ?>'">
                        <?php echo mb_convert_case($cat['cNomTab'], MB_CASE_TITLE, "UTF-8") ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="pb-2  p-1 col-12 col-xs-12 col-sm-12 col-md-4 col-lg-4 text-left">
            Estado: <br>
            <select name="CboEstado_NV" class="form-control border-1 col-xs-12 col-sm-12 col-md-12 col-lg-12" id="CboEstado_NV">
                <option value="'0'">Seleccione Estado</option>
                <?php
                $user = new ApptivaDB();
                $estadoVenta = $user->buscarGeneral("cCodTab ,cNomTab", "tablacod", "cCodTab LIKE 'PCLA%' AND cCodTab<>'PCLA0000'");
                foreach ($estadoVenta as $cat) :   ?>
                    <option value="'<?php echo $cat['cCodTab'] ?>'">
                        <?php echo mb_convert_case($cat['cNomTab'], MB_CASE_TITLE, "UTF-8") ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class=" mt-0 col-xs-12 col-sm-12 col-md-12 col-lg-12  p-2 d-md-flex justify-content-left align-items-center">
        <div class="pb-2 text-left  col-12 col-xs-12 col-sm-12 col-md-10 col-lg-10">
            Docentes: <br>
            <select name="CboDocente_NV" class="form-control border-1 col-xs-12 col-sm-12 col-md-12 col-lg-12" id="CboDocente_NV">
                <option value="'0'">Todo</option>
                <?php
                $user = new ApptivaDB();
                // $estadoVenta = $user->EjecutarProcedimiento("sp_listarPersonal", "");
                $estadoVenta = $user->buscarConsultas(
                    "dc.idDocente,ga.Abreviatura,dc.Nombes,dc.Apellidos",
                    "docentes dc
                    INNER JOIN gradoacademico ga ON dc.fk_GradoAcademico=ga.idGradoAc",
                    "'1'"
                );
                foreach ($estadoVenta as $cat) :   ?>
                    <option value="'<?php echo $cat['idDocente'] ?>'">
                        <?php echo mb_convert_case($cat['Abreviatura'] . " " . $cat["Nombes"] . " " . $cat["Apellidos"], MB_CASE_TITLE, "UTF-8") ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="mb-3 d-block col-xs-12 col-sm-12 col-md-12 col-lg-12 m-0 pb-3 d-md-flex justify-content-left align-items-center">
        <div class="text-left mb-3 col-xs-12 col-sm-12 col-md-5 col-lg-6 mb-lg-0">
            Fecha Inicio:</br>
            <input id="fecha_in_NV" type="date" name="fecha_in_NV" class="fechasBusqueda form-control border-1 col-xs-12 col-sm-12 col-md-12 col-lg-11" required />
        </div>
        <div class="text-left col-xs-12 col-sm-12 col-md-5 col-lg-6">
            Fecha de Culminacion:</br>
            <input id="fecha_fin_NV" type="date" name="fecha_fin_NV" class="fechasBusqueda form-control border-1 col-xs-12 col-sm-12 col-md-12 col-lg-11" required />

        </div>
    </div>
    <div class="ContenedorCursos mb-3 d-block col-xs-12 col-sm-12 col-md-12 col-lg-12 m-0 pb-3 ">
        <div class="conten-boton mb-3 text-right col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <a id="btn-SIA_NuevoEvento" class="btn second col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <span class="fas fa-plus text-center"></span> Añadir Cursos
            </a>
        </div>
        <input type="hidden" name="txtNumCursos" id="txtNumCursos">
        <div id="contenedorLLanarCursosModal" class="contenedorLLanarCursos text-left col-xs-12 col-sm-12 col-md-12 col-lg-12">

        </div>
    </div>
    <div class="ContenedorCursos mb-3 border-top d-block col-xs-12 col-sm-12 col-md-12 col-lg-12 m-0 pb-3 ">
        <h5 class="text-left col-12">Diseño de certificado</h5>
        <div class="d-sm-flex text-center col-12">
            <div id="contenedorLLanartemplate" class="contenedorLLanartemplate text-center m-auto p-2 d-flex col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <img src="" id="imgTemplateCertificadofron" alt="" srcset="">
                <div id="btn-subirTemplateFron" class="contentbtnCertificados">Parte Frontal</div>
            </div>
            <div id="contenedorLLanartemplate" class="contenedorLLanartemplate p-2 text-center d-flex col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <img src="" id="imgTemplateCertificadoPost" alt="" srcset="">
                <div id="btn-subirTemplatePost" class="contentbtnCertificados">Parte Posterior</div>
            </div>
            <input type="file" name="txtTemplateCertificadoFron" id="txtTemplateCertificadoFron" class="d-none">
            <input type="file" name="txtTemplateCertificadoPost" id="txtTemplateCertificadoPost" class="d-none">

        </div>
    </div>
    <div class="mb-3 d-block col-xs-12 col-sm-12 col-md-12 col-lg-12 m-0 pb-3 d-lg-flex ">

        <div id="" class="text-left mb-3 col-xs-12 col-sm-12 col-md-12 col-lg-6 mb-lg-0">
            Importe en S/:
            <input type="text" name="txtImporteMonLocal" id="txtImporteMonLocal" class="form-control col-11 col-mb-11 col-lg-11" placeholder="Eje. 180.00">
        </div>
        <div id="" class="text-left col-xs-12 col-sm-12 col-md-12 col-lg-6">
            Importe en $/:
            <input type="text" name="txtImporteMonCambio" id="txtImporteMonCambio" class="form-control col-11 col-mb-11 col-lg-11" placeholder="Eje. 180.00">
        </div>
    </div>
    <div class="mb-3 d-block col-xs-12 col-sm-12 col-md-12 col-lg-12 m-0 pb-3 ">

        <div id="" class="text-left col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <textarea name="txtDescripcion" id="txtDescripcion" class="col-12 form-control" placeholder="Descripcion"></textarea>
        </div>
    </div>
    <div class="conten-boton mb-3 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <a id="btn-SIA_GuardarEvento" class="btn col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <span class="fas fa-save text-center"></span> Registrar Evento
        </a>
    </div>
</form>

<form action="#" method="post" id="formularioDatosDeClase" class="modal p-0 col-11 col-xs-10 col-sm-10 col-md-8 col-lg-5">
    <h5 class="text-left p-2">Datos de inicializacion de curso</h5>

    <div class="bg-warning p-2">
        <span class="mb-3" style="color: #000; font-weight: bold;">¡ PORFAVOR: Verificar las fechas de inicio y finalización del Curso para este alumno !</span><br>

    </div>
    <input type="hidden" name="txtCodAlumnoMod" id="txtCodAlumnoMod">
    <input type="hidden" name="txtCodVentaMod" id="txtCodVentaMod">
    <div class="text-left mt-4 col-xs-12 col-sm-12 col-md-12 col-lg-12 d-lg-flex">

        <div class="d-block text-left mb-3 col-xs-12 col-sm-12 col-md-12 col-lg-6">
            <span class="m-0 text-left col-xs-12 col-sm-12 col-md-5 col-lg-6">Fecha Inicio</span> <br>
            <input type="date" name="dtFechaInicio" id="dtFechaInicio" class="form-control col-xs-12 col-sm-12 col-md-12 col-lg-12">


        </div>
        <div class="d-block text-left mb-3 col-xs-12 col-sm-12 col-md-12 col-lg-6">

            <span class="m-0 text-left col-xs-12 col-sm-12 col-md-12 col-lg-12">Fecha final </span><br>
            <input type="date" name="dtFechaFin" id="dtFechaFin" class="form-control col-xs-12 col-sm-12 col-md-12 col-lg-12">


        </div>

    </div>
    <div class="text-left col-xs-12 col-sm-12 col-md-12 col-lg-12 d-lg-flex">
        <div class="pb-2 text-left  col-12 col-xs-12 col-sm-12 col-md-10 col-lg-10">
            Progreso Curso: <br>
            <select name="cboProgresoClase" class="form-control border-1 col-xs-12 col-sm-12 col-md-12 col-lg-12" id="cboProgresoClase">
                <option value="'0'">Todo</option>
                <?php
                $user = new ApptivaDB();
                $estadoVenta = $user->buscarGeneral("cCodTab ,cNomTab", "tablacod", "cCodTab LIKE 'PCLA%' AND cCodTab<>'PCLA0000'");
                foreach ($estadoVenta as $cat) :   ?>
                    <option value="'<?php echo $cat['cCodTab'] ?>'">
                        <?php echo mb_convert_case($cat['cNomTab'], MB_CASE_TITLE, "UTF-8") ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>


    <div class="contenedorBoton col-xs-12 m-4 col-sm-12 col-md-12 col-lg-12 d-flex justify-content-center">
        <input type="submit" value="Generar Venta" class="btnGuardarVenta boton" id="btnGuardarVenta">

    </div>

</form>

<form action="#" method="post" id="frmReguistrarProspectos" class="modal p-0 col-11 col-xs-10 col-sm-10 col-md-8 col-lg-6">
    <h5 class="p-2 text-left">Registrar Prospecto</h5>
    <div class="contenedorProspecto col-xs-12 col-sm-12 col-md-12 col-lg-12 d-flex">

        <div class="contenedorFormProspecto col-xs-12 col-sm-12 col-md-12 col-lg-11  m-auto">

            <div class="text-left col-xs-12 col-sm-12 col-md-12 col-lg-12 divCaja" id="grupo__txtEmail">
                <input type="hidden" name="txtNumeroPreguntas" id="txtNumeroPreguntas">
                <span class="titulo_preguntas">Correo electrónico </span>
                <div class="formulario__grupo-input">
                    <input type="email" name="txtEmail" id="txtEmail" class="" placeholder="Ej: nicorreo12@gmail.com" required>
                    <i class="formulario__validacion-estado fas fa-times-circle"></i>
                </div>
                <br><label class="mensaje" id="msj__txtEmail"></label>
            </div>
            <div class="contenedorItems">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 divCaja">
                    <div class="text-left col-xs-12 d-block col-sm-12 col-md-12 col-lg-12 d-lg-flex">
                        <div id="grupo__txtnombres" class="datosPersonales col-xs-12 col-sm-12 col-md-12 col-lg-6">
                            <span class="titulo_preguntas">Nombres </span>
                            <div class="formulario__grupo-input">
                                <input type="text" name="txtnombres" id="txtnombres" class="" placeholder="Ingrese nombres" required>
                                <i class="formulario__validacion-estado fas fa-times-circle"></i>
                            </div>
                            <br><label class="formulario__input-error  mensaje" id="mensajeNombres">Ingrese correctamente sus nombres</label>
                        </div>
                        <div id="grupo__txtApellidos" class="datosPersonales col-xs-12 col-sm-12 col-md-12 col-lg-6">
                            <span class="titulo_preguntas">Apellidos </span>
                            <div class="formulario__grupo-input">
                                <input type="text" name="txtApellidos" id="txtApellidos" class="" placeholder="Ingrese apellidos" required>
                                <i class="formulario__validacion-estado fas fa-times-circle"></i>
                            </div>
                            <br><label class="formulario__input-error  mensaje" id="mensajeEmail">Ingrese correctamente sus apellidos</label>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 divCaja">

                    <div class="text-left col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-3 d-lg-flex">

                        <div id="grupo__txtEdad" class="datosPersonales col-xs-12 col-sm-12 col-md-12 col-lg-6">
                            <span class="titulo_preguntas">Edad </span>
                            <div class="formulario__grupo-input">
                                <input type="number" name="txtEdad" id="txtEdad" class="" placeholder="Ingrese edad" required>
                                <i class="formulario__validacion-estado fas fa-times-circle"></i>
                            </div>
                            <br><label class="formulario__input-error  mensaje" id="mensajeEdad">Ingrese correctamente su edad, debe tener exactamnte dos caracteres</label>
                        </div>

                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 divCaja">
                    <div class="text-left d-block col-xs-12 col-sm-12 col-md-12 col-lg-12 d-lg-flex">
                        <div id="grupo__CboPais" class="datosPersonales col-xs-12 col-sm-12 col-md-12 col-lg-6">
                            <span class="titulo_preguntas">Pais</span>
                            <div class="formulario__grupo-input">
                                <select name="CboPais" id="CboPais">
                                    <option value="0">Seleccione pais</option>
                                    <?php
                                    $user = new ApptivaDB();
                                    $categorias = $user->buscarTodo("pais", "Nombre_pais");
                                    foreach ($categorias as $cat) :   ?>
                                        <option value="<?php echo $cat['Codigo'] ?>">
                                            <?php echo mb_convert_case($cat['Nombre_pais'], MB_CASE_TITLE, "UTF-8") ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <i class="formulario__validacion-estado fas fa-times-circle"></i>
                            </div>
                            <br><label class="mensaje" id="msj__txtEmail">Porfavor selecione pais</label>
                        </div>
                        <div id="grupo__txtNumCelular" class="datosPersonales col-xs-12 col-sm-12 col-md-12 col-lg-6">
                            <span class="titulo_preguntas">Numero de telefono </span>
                            <div class="formulario__grupo-input p-0">
                                <label class="CodigoPais" name="CodigoPais" id="CodigoPais">+00</label>
                                <input type="number" maxlength="12" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" name="txtNumCelular" id="txtNumCelular" class="" placeholder="Numero de celular" style="width: 70%;" required>
                                <input type="hidden" name="txtCodigoPais" class="CodigoPais">
                                <i class="formulario__validacion-estado fas fa-times-circle"></i>
                            </div>
                            <br><label class="mensaje" id="msjTelefono">Ingrese correctamente su numero telefonico</label>
                        </div>
                    </div>
                </div>

                <div class="cargarDatos">

                </div>
            </div>
            <?php
            include("../loader.php");
            ?>
            <div class=" mt-2 row divContenDentro contenBoton" id="contenBoton">

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="formulario__mensaje">

                </div>
                <div class="mt-3 col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-5 subContenBoton">
                    <input type="submit" id="btn_guardarProspectos" class="btn " value="Registrar >">
                </div>

            </div>
        </div>
    </div>

</form>