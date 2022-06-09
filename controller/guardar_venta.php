<?php
// return print_r($_POST);
session_start();
// error_reporting(0);
include("../model/conexion.php");
$con = new ApptivaDB();
$idsEventos = "";
$cantidadEvetosVenta = $_POST["txtNumeroEventosClase"];
$arayIdsCursos = array();
for ($i = 0; $i < $cantidadEvetosVenta; $i++) {
    if ($i == count($arayIdsCursos) - 1) {
        $idsEventos .= $_POST["checksBoxClases" . $i];
    } else {
        $idsEventos .= $_POST["checksBoxClases" . $i] . ",";
    }
}
$buscarIdsCursos = $con->buscarFech("de.idDetalleEvento", "detalle_evento de  INNER JOIN eventos_venta ev ON de.fk_idEvento=ev.idEvento", " de.fk_idEvento IN('" . $idsEventos . "')");
while ($rowl = mysqli_fetch_array($buscarIdsCursos)) {
    $arayIdsCursos[] = $rowl["idDetalleEvento"];
}
// print_r($arayIdsCursos);
// return;




require_once('sendinblue_addContacts.php');
// include("../model/conexion.php");
// $con = new ApptivaDB();
$idPersonal = $_SESSION["asistenteLogeado"];
$idProspecto = $_POST["txtidcliente"];
$codigoProspecto = $_POST["txtCodCliente"];
$idCampania = $_POST["CboCampaniaVenta"];
$cantidadEvetosVenta = $_POST["txtNumeroEventosClase"];
$idPagoEstablecido = $_POST["CboPagoEstablecido"];
// $subtotal = $_POST["txtSubtotal"];
$estadoDescuento = $_POST["rbDescuento"];
$descuento = $_POST["txtDescuento"];
$TotalPagar = $_POST["txtTotalPagar"];
$observaciones = $_POST["txtObservaciones"];
$estadoVenta = $_POST["CboEstadoVenta"];
$pagoPorCuotas = $_POST["CboPagoPorCuotas"];
$numeroCuotas = $_POST["txtNumeroCuotas"];
$pagoPrimeraCuota = $_POST["txtPagoPrimeraCuota"];
$montoRestante = $_POST["txtMontoRestante"];

$tipoMoneda = $_POST["txtTipoMoneda"];

// $fechaProximoPago = $_POST[""];

$idTipoPago = $_POST["CboTipoPago"];
$idEntidadBancaria = $_POST["CboEntidadPago"];
// echo json_encode($_POST["checksBoxCursos0"]);
// echo json_encode($_POST["txtObservaciones"]);
// return var_dump($_POST);

$correoClienteOriginal = $_POST["txtCorreoCliOrig"];
$correoClienteActualizar = $_POST["txtCorreoCli"];

$nombresClienteOriginal = $_POST["txtNombresCliOrig"];
$nombresClienteAcualizar = $_POST["txtNombresCli"];
$apellidosCliente = $_POST["txtApellidosCli"];
$telefonoCliente = $_POST["txtCodigoPais"] . $_POST["txtTelefonoCli"];
$PaisCliente = $_POST["cboPais"];

// $idDocente = $_POST["txtDocente"];
// $cCodModalidad = $_POST["txtModalidadCurso"];
$evFechaInicio = $_POST["txtFechaInicio"];
$evFechaFinal = $_POST["txtFechaFin"];
$progresoClase = $_POST["txtProgresoClase"];

$tipoImagen = ["image/jpeg", "image/png", "image/gif"];

$imagenBoucher = $_FILES["imgBoucherPago"];
$nombreImagen = $imagenBoucher["name"];
$tipoArchivo = $_FILES['imgBoucherPago']['type'];
$tamanoArchivo = $_FILES['imgBoucherPago']['size'];
$temp_name = $_FILES['imgBoucherPago']['tmp_name'];
$ImagenSubida = fopen($_FILES['imgBoucherPago']['tmp_name'], 'r');
$binariosImagen = fread($ImagenSubida, $tamanoArchivo);

$link = mysqli_connect("localhost", "root", "", "bdsimetrika");
$binariosImagen =  mysqli_escape_string($link, $binariosImagen);

$n_aleatorio = rand(10, 99);
$ZonaHoraria = date_default_timezone_set('America/lima');
$fecha_actual = date("Y-m-d h:m:s");
$fecha_Venta = $_POST["dtfecha_inicio_V"];
// $fechaVencimiento= date("Y-m-d",strtotime($fecha_actual."+ 7 days"));

$buscarIdVenta = fnObtenerUltimoId($con, "idventa", "venta");
$UltimoIdCliente = fnObtenerUltimoId($con, "idCliente", "clientes");

$buscarClienteExistente = $con->buscarFech(
    "idCliente,codCliente",
    "clientes",
    "codCliente='" . $codigoProspecto . "' AND idCliente='" . $idProspecto . "'"
);

$existenciaNumRows = mysqli_num_rows($buscarClienteExistente);
if ($existenciaNumRows > 0) {

    $respClienteExistente = mysqli_fetch_array($buscarClienteExistente);
    $idClienteExistente = $respClienteExistente["idCliente"];
    $codClienteExistente = $respClienteExistente["codCliente"];

    $registroVenta = $con->insertar("venta", "(null,concat('VSMTK', LPAD($buscarIdVenta, 8, '0')),'" . $idClienteExistente . "','" . $codClienteExistente . "','" . $fecha_actual . "','" . $fecha_Venta . "','" . $idPersonal . "'," . $estadoVenta . ")");
    if ($registroVenta) {
        $buscarDatVenta = $con->buscarFech(
            "idventa,cCodVenta",
            "venta",
            " fk_IdAlumno='" . $idClienteExistente . "' AND fk_codAlumno='" . $codClienteExistente . "' AND idUsuario='" . $idPersonal . "' AND idventa='" . $buscarIdVenta . "'"
        );

        if ($buscarDatVenta) {
            $respBusq = mysqli_fetch_array($buscarDatVenta);
            $idVenta = $respBusq["idventa"];
            $CodigoVenta = $respBusq["cCodVenta"];
            $valuesClaseRealizar = "";
            $codCuota = "CUT-V" . $idVenta;
            $valuesCuotas = "";
            $idsDetalleEventos = "";

            $registroDetalle = $con->insertar(
                "detalleventa(fk_Venta,fk_codVenta,numeroCuotas,importeTotal,importerestual,descuento,fk_tipoMoneda,fechaRegistro,idUsuario)",
                "('" . $idVenta . "','" . $CodigoVenta . "','" . $numeroCuotas . "','" . $TotalPagar . "','" . $montoRestante . "','" . $descuento . "','" . $tipoMoneda . "','" . $fecha_actual . "','" . $idPersonal . "')"
            );



            $buscarIdClaseRealizar = fnObtenerUltimoId($con, "idClaseRealizar", "clase_realizar");
            for ($i = 0; $i < count($arayIdsCursos); $i++) {
                $idSeqInscritos = fnObtenerUltimoIdParaCodCertificado($con, "idSecuenciaIncritos", "clase_realizar", "fk_idEventoVenta='" . $arayIdsCursos[$i] . "'");

                if ($i == count($arayIdsCursos) - 1) {
                    $idsDetalleEventos .= $arayIdsCursos[$i];
                    $valuesClaseRealizar .= "(concat('CRSMK',LPAD(" . ($buscarIdClaseRealizar + $i) . ", 8, '0')),'" . $codClienteExistente . "','" . $CodigoVenta . "','" . $arayIdsCursos[$i] . "','" . $idSeqInscritos . "','" . $idCampania . "','" . $fecha_actual . "','" . $evFechaInicio . "','" . $evFechaFinal . "'," . $progresoClase . ",'" . $idPersonal . "')";
                } else {
                    $idsDetalleEventos .= $arayIdsCursos[$i] . ",";
                    $valuesClaseRealizar .= "(concat('CRSMK',LPAD(" . ($buscarIdClaseRealizar + $i) . ", 8, '0')),'" . $codClienteExistente . "','" . $CodigoVenta . "','" . $arayIdsCursos[$i] . "','" . $idSeqInscritos . "','" . $idCampania . "','" . $fecha_actual . "','" . $evFechaInicio . "','" . $evFechaFinal . "'," . $progresoClase . ",'" . $idPersonal . "'),";
                }
            }

            $IdListaCursos = $con->buscarFech(
                "c.idListaSendBl",
                "detalle_evento de 
                INNER JOIN cursos_venta c ON de.fk_idCurso=c.idCursoV",
                " de.idDetalleEvento IN(" . $idsDetalleEventos . ")"
            );

            // $idsListas = "";
            if (isset($_POST["chkEnviarCorreo"])) {
                while ($rowl = mysqli_fetch_array($IdListaCursos)) {
                    // $idsListas .= $rowl["idListaSendBl"];
                    fnInsertarSendinBlue($correoClienteActualizar, $nombresClienteAcualizar, $apellidosCliente, $telefonoCliente, "", 98);
                }
            }

            // $arregloMSG["error"] = $idsListas;
            // echo json_encode($arregloMSG);
            // return
            $registroCuotas = $con->insertar(
                "clase_realizar(codClaseRealizar,fk_codAlumno,fk_codVenta,fk_idEventoVenta,idSecuenciaIncritos,fk_idCampania,fechaRegistro,fechaInicio,fechaFinal,progresoClase,idUsuario)",
                $valuesClaseRealizar
            );


            for ($i = 0; $i < $numeroCuotas; $i++) {
                if ($numeroCuotas == 1) {
                    $valuesCuotas .= "('" . $codCuota . "','" . $idVenta . "','" . $CodigoVenta . "','" . $fecha_actual . "','" . $fecha_actual . "','" . $fecha_actual . "','" . $idPersonal . "','ESTC0001')";
                } else {
                    if ($i == $numeroCuotas - 1) {
                        $valuesCuotas .= "('" . $codCuota . "','" . $idVenta . "','" . $CodigoVenta . "','" . $_POST["dtt" . ($i - 1)] . "','" . date("Y-m-d", strtotime($_POST["dtt" . ($i - 1)] . "+ 7 days")) . "','" . $fecha_actual . "','" . $idPersonal . "','ESTC0002')";
                    } else {
                        if ($i == 0) {
                            $valuesCuotas .= "('" . $codCuota . "','" . $idVenta . "','" . $CodigoVenta . "','" . $fecha_actual . "','" . $fecha_actual . "','" . $fecha_actual . "','" . $idPersonal . "','ESTC0001'),";
                        } else {
                            $valuesCuotas .= "('" . $codCuota . "','" . $idVenta . "','" . $CodigoVenta . "','" . $_POST["dtt" . ($i - 1)] . "','" . date("Y-m-d", strtotime($_POST["dtt" . ($i - 1)] . "+ 7 days")) . "','" . $fecha_actual . "','" . $idPersonal . "','ESTC0002'),";
                        }
                    }
                }
            }

            $registroCuotas = $con->insertar("pago_cuotas(CodCuota,fk_Venta,fk_codVenta,fechaPagoPC,fechaVencimientoPC,fechaRegistroPC,idUsuario,estadoPagoPC)", $valuesCuotas);

            if ($registroCuotas) {
                $buscarIdCuota = $con->buscarFech(
                    "idPagoCuotas,CodCuota",
                    "pago_cuotas",
                    "CodCuota='$codCuota' AND fk_Venta='$idVenta' AND idUsuario='$idPersonal' AND estadoPagoPC='ESTC0001'"
                );
                if ($buscarIdCuota) {
                    $respBusqCuota = mysqli_fetch_array($buscarIdCuota);
                    $idCuota = $respBusqCuota["idPagoCuotas"];
                    $codigoCuota = $respBusqCuota["CodCuota"];

                    // creamos las carpeta y ruta del boucher 

                    $CrearCarpeta = "../IMAGENES/bouchers/" . $CodigoVenta . "_" . $idClienteExistente . "/";
                    if (!file_exists($CrearCarpeta)) {
                        mkdir($CrearCarpeta, 0777, true);
                    }
                    $carpetaBoucher = $CrearCarpeta . $idCuota . "_" . $idClienteExistente . "_" . $n_aleatorio . "_" . $nombreImagen;
                    $rutabdBoucher = "IMAGENES/bouchers/" . $CodigoVenta . "_" . $idClienteExistente . "/" . $idCuota . "_" . $idClienteExistente . "_" . $n_aleatorio . "_" . $nombreImagen;

                    // $registroDetallePago = $con->insertar(
                    //     "detallepagos(fk_idPagoCuotas,fk_codCuotas,fecha_registroDP,fk_idEntidadPago,fk_tipoMoneda,importeCuotaDP,boucherPagoDP,boucherBlobDP,tipoImagen,observacionesDP,idUsuario)",
                    //     "('" . $idCuota . "','".$codigoCuota."','" . $fecha_actual . "','" . $idEntidadBancaria . "','" . $tipoMoneda . "','" . $pagoPrimeraCuota . "','" . $nombreImagen . "','" . $binariosImagen . "','" . $tipoArchivo . "','" . $observaciones . "','" . $idPersonal . "')"
                    // );
                    $registroDetallePago = $con->insertar(
                        "detallepagos(fk_idPagoCuotas,fk_codCuotas,fecha_registroDP,fecha_pagoCuotaDP,fk_idEntidadPago,fk_tipoMoneda,importeCuotaDP,boucherPagoDP,tipoImagen,observacionesDP,idUsuario)",
                        "('" . $idCuota . "','" . $codigoCuota . "','" . $fecha_actual . "','" . $fecha_actual . "','" . $idEntidadBancaria . "','" . $tipoMoneda . "','" . $pagoPrimeraCuota . "','" . $rutabdBoucher . "','" . $tipoArchivo . "','" . $observaciones . "','" . $idPersonal . "')"
                    );
                    if ($registroDetallePago) {
                        move_uploaded_file($temp_name, $carpetaBoucher);
                        $arregloMSG["ok"] = "La Venta se generó correctamente";
                    } else {
                        $arregloMSG["error"] = "Error en la venta";
                    }
                }
            }
        }
    }
    // Si el cliente aun no tiene Alguna compra
} else {

    $transladoCliente = $con->insertarXselect(
        "clientes(codCliente,codProspecto,nombresCliente,apellidosCliente,correoCliente,telefonoCliente,edadCliente,paisCliente,ocupacionCliente,institucionCliente,fechaRegistro,idUsuario)",
        "concat('CLI', LPAD($UltimoIdCliente, 7, '0')),p.pros_codigo,p.pros_nombres,p.pros_apellidos,p.pros_email,p.pros_telefono,p.pros_edad,p.ID_PAIS,p.pros_ocupacion,p.pros_institucion,'" . $fecha_actual . "','" . $idPersonal . "'",
        " prospectos p",
        " p.idProspecto='" . $idProspecto . "'
        AND p.pros_codigo='" . $codigoProspecto . "'"
    );
    if ($transladoCliente) {
        $buscarIdCliente = $con->buscarFech(
            "idCliente,codCliente",
            "clientes",
            "nombresCliente='" . $nombresClienteOriginal . "' AND correoCliente='" . $correoClienteOriginal . "' AND idCliente='" . $UltimoIdCliente . "'"
        );

        // $actualizarEstadProspecto = $con->actualizar("prospectos p", "p.pro_estadoCilente='1'", " p.idProspecto='" . $idProspecto . "'");

        if ($buscarIdCliente) {
            $respBusqIdCliente = mysqli_fetch_array($buscarIdCliente);
            $idCliente = $respBusqIdCliente["idCliente"];
            $codCliente = $respBusqIdCliente["codCliente"];

            $actualizarCliente = $con->actualizar("clientes", "nombresCliente='" . $nombresClienteAcualizar . "',apellidosCliente='" . $apellidosCliente . "',correoCliente='" . $correoClienteActualizar . "',telefonoCliente='" . $telefonoCliente . "',paisCliente='" . $PaisCliente . "'", "idCliente='" . $idCliente . "'");

            $registroVenta = $con->insertar("venta", "(null,concat('VSMTK', LPAD($buscarIdVenta, 8, '0')),'" . $idCliente . "','" . $codCliente . "','" . $fecha_actual . "','" . $fecha_Venta . "','" . $idPersonal . "'," . $estadoVenta . ")");
            if ($registroVenta) {
                $buscarDatVenta = $con->buscarFech(
                    "idventa,cCodVenta",
                    "venta",
                    " fk_IdAlumno='" . $idCliente . "' AND fk_codAlumno='" . $codCliente . "' AND idUsuario='" . $idPersonal . "' AND idventa='" . $buscarIdVenta . "'"
                );

                if ($buscarDatVenta) {
                    $respBusq = mysqli_fetch_array($buscarDatVenta);
                    $idVenta = $respBusq["idventa"];
                    $CodigoVenta = $respBusq["cCodVenta"];
                    $valuesClaseRealizar = "";
                    $codCuota = "CUT-V" . $idVenta;
                    $valuesCuotas = "";
                    $idsDetalleEventos = "";

                    $registroDetalle = $con->insertar(
                        "detalleventa(fk_Venta,fk_codVenta,numeroCuotas,importeTotal,importerestual,descuento,fk_tipoMoneda,fechaRegistro,idUsuario)",
                        "('" . $idVenta . "','" . $CodigoVenta . "','" . $numeroCuotas . "','" . $TotalPagar . "','" . $montoRestante . "','" . $descuento . "','" . $tipoMoneda . "','" . $fecha_actual . "','" . $idPersonal . "')"
                    );


                    $buscarIdClaseRealizar = fnObtenerUltimoId($con, "idClaseRealizar", "clase_realizar");
                    for ($i = 0; $i < count($arayIdsCursos); $i++) {
                        $idSeqInscritos = fnObtenerUltimoIdParaCodCertificado($con, "idSecuenciaIncritos", "clase_realizar", "fk_idEventoVenta='" . $arayIdsCursos[$i] . "'");

                        if ($i == count($arayIdsCursos) - 1) {
                            $idsDetalleEventos .= $arayIdsCursos[$i];
                            $valuesClaseRealizar .= "(concat('CRSMK',LPAD(" . ($buscarIdClaseRealizar + $i) . ", 8, '0')),'" . $codCliente . "','" . $CodigoVenta . "','" . $arayIdsCursos[$i] . "','" . $idSeqInscritos . "','" . $idCampania . "','" . $fecha_actual . "','" . $evFechaInicio . "','" . $evFechaFinal . "'," . $progresoClase . ",'" . $idPersonal . "')";
                        } else {
                            $idsDetalleEventos .= $arayIdsCursos[$i] . ",";
                            $valuesClaseRealizar .= "(concat('CRSMK',LPAD(" . ($buscarIdClaseRealizar + $i) . ", 8, '0')),'" . $codCliente . "','" . $CodigoVenta . "','" . $arayIdsCursos[$i] . "','" . $idSeqInscritos . "','" . $idCampania . "','" . $fecha_actual . "','" . $evFechaInicio . "','" . $evFechaFinal . "'," . $progresoClase . ",'" . $idPersonal . "'),";
                        }
                    }

                    $IdListaCursos = $con->buscarFech(
                        "c.idListaSendBl",
                        "detalle_evento de 
                        INNER JOIN cursos_venta c ON de.fk_idCurso=c.idCursoV",
                        " de.idDetalleEvento IN(" . $idsDetalleEventos . ")"
                    );


                    if (isset($_POST["chkEnviarCorreo"])) {
                        while ($rowl = mysqli_fetch_array($IdListaCursos)) {
                            // $idsListas .= $rowl["idListaSendBl"];
                            fnInsertarSendinBlue($correoClienteActualizar, $nombresClienteAcualizar, $apellidosCliente, $telefonoCliente, "",98);
                        }
                    }
                    // $arregloMSG["error"] = $idsListas;
                    // echo json_encode($arregloMSG);
                    // return
                    $registroCuotas = $con->insertar(
                        "clase_realizar(codClaseRealizar,fk_codAlumno,fk_codVenta,fk_idEventoVenta,idSecuenciaIncritos,fk_idCampania,fechaRegistro,fechaInicio,fechaFinal,progresoClase,idUsuario)",
                        $valuesClaseRealizar
                    );

                    // $BuscarIdListas = $con->buscarFech(
                    //     "idventa,cCodVenta",
                    //     "venta",
                    //     " fk_IdAlumno='" . $idCliente . "' AND fk_idCampania='" . $idCampania . "' AND  numeroCuotasV='" . $numeroCuotas . "' AND fk_tipoMoneda='" . $tipoMoneda . "' AND totalV='" . $TotalPagar . "' AND importeRestual='" . $montoRestante . "' AND idUsuario='" . $idPersonal . "'"
                    // );

                    for ($i = 0; $i < $numeroCuotas; $i++) {
                        if ($numeroCuotas == 1) {
                            $valuesCuotas .= "('" . $codCuota . "','" . $idVenta . "','" . $CodigoVenta . "','" . $fecha_actual . "','" . $fecha_actual . "','" . $fecha_actual . "','" . $idPersonal . "','ESTC0001')";
                        } else {
                            if ($i == $numeroCuotas - 1) {
                                $valuesCuotas .= "('" . $codCuota . "','" . $idVenta . "','" . $CodigoVenta . "','" . $_POST["dtt" . ($i - 1)] . "','" . date("Y-m-d", strtotime($_POST["dtt" . ($i - 1)] . "+ 7 days")) . "','" . $fecha_actual . "','" . $idPersonal . "','ESTC0002')";
                            } else {
                                if ($i == 0) {
                                    $valuesCuotas .= "('" . $codCuota . "','" . $idVenta . "','" . $CodigoVenta . "','" . $fecha_actual . "','" . $fecha_actual . "','" . $fecha_actual . "','" . $idPersonal . "','ESTC0001'),";
                                } else {
                                    $valuesCuotas .= "('" . $codCuota . "','" . $idVenta . "','" . $CodigoVenta . "','" . $_POST["dtt" . ($i - 1)] . "','" . date("Y-m-d", strtotime($_POST["dtt" . ($i - 1)] . "+ 7 days")) . "','" . $fecha_actual . "','" . $idPersonal . "','ESTC0002'),";
                                }
                            }
                        }
                    }

                    $registroCuotas = $con->insertar("pago_cuotas(CodCuota,fk_Venta,fk_codVenta,fechaPagoPC,fechaVencimientoPC,fechaRegistroPC,idUsuario,estadoPagoPC)", $valuesCuotas);

                    if ($registroCuotas) {
                        $buscarIdCuota = $con->buscarFech(
                            "idPagoCuotas,CodCuota",
                            "pago_cuotas",
                            "CodCuota='$codCuota' AND fk_Venta='$idVenta' AND idUsuario='$idPersonal' AND estadoPagoPC='ESTC0001'"
                        );
                        if ($buscarIdCuota) {
                            $respBusqCuota = mysqli_fetch_array($buscarIdCuota);
                            $idCuota = $respBusqCuota["idPagoCuotas"];
                            $codigoCuota = $respBusqCuota["CodCuota"];

                            // creamos las carpeta y ruta del boucher 

                            $CrearCarpeta = "../IMAGENES/bouchers/" . $CodigoVenta . "_" . $idCliente . "/";
                            if (!file_exists($CrearCarpeta)) {
                                mkdir($CrearCarpeta, 0777, true);
                            }
                            $carpetaBoucher = $CrearCarpeta . $idCuota . "_" . $idCliente . "_" . $n_aleatorio . "_" . $nombreImagen;
                            $rutabdBoucher = "IMAGENES/bouchers/" . $CodigoVenta . "_" . $idCliente . "/" . $idCuota . "_" . $idCliente . "_" . $n_aleatorio . "_" . $nombreImagen;

                            // $registroDetallePago = $con->insertar(
                            //     "detallepagos(fk_idPagoCuotas,fk_codCuotas,fecha_registroDP,fk_idEntidadPago,fk_tipoMoneda,importeCuotaDP,boucherPagoDP,boucherBlobDP,tipoImagen,observacionesDP,idUsuario)",
                            //     "('" . $idCuota . "','".$codigoCuota."','" . $fecha_actual . "','" . $idEntidadBancaria . "','" . $tipoMoneda . "','" . $pagoPrimeraCuota . "','" . $nombreImagen . "','" . $binariosImagen . "','" . $tipoArchivo . "','" . $observaciones . "','" . $idPersonal . "')"
                            // );
                            $registroDetallePago = $con->insertar(
                                "detallepagos(fk_idPagoCuotas,fk_codCuotas,fecha_registroDP,fecha_pagoCuotaDP,fk_idEntidadPago,fk_tipoMoneda,importeCuotaDP,boucherPagoDP,tipoImagen,observacionesDP,idUsuario)",
                                "('" . $idCuota . "','" . $codigoCuota . "','" . $fecha_actual . "','" . $fecha_actual . "','" . $idEntidadBancaria . "','" . $tipoMoneda . "','" . $pagoPrimeraCuota . "','" . $rutabdBoucher . "','" . $tipoArchivo . "','" . $observaciones . "','" . $idPersonal . "')"
                            );
                            if ($registroDetallePago) {
                                move_uploaded_file($temp_name, $carpetaBoucher);
                                $arregloMSG["ok"] = "La Venta se generó correctamente";
                            } else {
                                $arregloMSG["error"] = "Error en la venta";
                            }
                        }
                    }
                }
            }
        }
    }
}
echo json_encode($arregloMSG);

function fnInsertarSendinBlue($Correo, $nombres, $apellidos, $telefono, $LinkCertificado, $idLista)
{
    //recortamos el pruimer nombre
    $primerNombre = explode(" ", $nombres);
    $Estado = false;

    $identificador = "";
    if (buscarContacto($Correo) != 404) {
        $identificador = $Correo;
    } else if (buscarContacto($telefono) != 404) {
        $identificador = buscarContacto($telefono);
    }

    if ($identificador != "") {
        $actualizarAtributos = ActualizarAtributosContacto($apellidos, $primerNombre[0], $nombres, $telefono, $LinkCertificado, $identificador);
        if ($actualizarAtributos == true) {
            $agregadoAOtraLista = fnAgregarContactoAotraLista($idLista, $identificador);
            if ($agregadoAOtraLista == true) {
                $respuesta["exito"] = "Venta registrada correctamnete";
                $Estado = true;
            } else {
                $respuesta["error"] = "Error en el registro";
                $Estado = false;
            }
        }
    } else {
        $resultado = agergarContactos($Correo, $apellidos, $primerNombre[0], $nombres, $telefono, $LinkCertificado, $idLista);
        if ($resultado == true) {

            $Estado = true;
        } else {
            $resSinTelefono = agergarContactosSinTelefono($Correo, $apellidos, $primerNombre[0], $nombres, $LinkCertificado, $idLista);
            if ($resSinTelefono == true) {
                $respuesta["exito"] = "Venta registrada correctamnete";
                $Estado = true;
            } else {

                $respuesta["error"] = "Verifique  su Nro de telefono";
                $Estado = false;
            }
        }
    }
    return $Estado;
}



function fnObtenerUltimoId($con, $campo, $tabla)
{
    $cantRegistros = array();
    $buscar = "";
    /* consulta para buscar la cantidad de registros existentes en la tabla copras */
    $buscar = $con->buscarCar($campo, $tabla, "1");
    foreach ($buscar as $v) {
        $cantRegistros[] = $v[$campo];
    }
    /* si al  menos  un registro a la variable le agrego uno si no le agrego el id maximo */
    if (count($cantRegistros) < 1) {
        return 1;
    } else {
        $buscar = $con->buscarCar("MAX($campo) as id", $tabla, "1");
        foreach ($buscar as $v) {
            return ($v["id"] + 1);
        }
    }
}

function fnObtenerUltimoIdParaCodCertificado($con, $campo, $tabla, $condicion)
{
    $cantRegistros = array();
    $buscar = "";
    /* consulta para buscar la cantidad de registros existentes en la tabla copras */
    $buscar = $con->buscarCar($campo, $tabla, $condicion);
    foreach ($buscar as $v) {
        $cantRegistros[] = $v[$campo];
    }
    /* si al  menos  un registro a la variable le agrego uno si no le agrego el id maximo */
    if (count($cantRegistros) < 1) {
        return 1;
    } else {
        $buscar = $con->buscarCar("MAX($campo) as id", $tabla, $condicion);
        foreach ($buscar as $v) {
            return ($v["id"] + 1);
        }
    }
}
