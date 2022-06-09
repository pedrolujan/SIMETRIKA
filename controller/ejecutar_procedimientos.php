<?php
session_start();
// $zonelist = array('America/New_York' => -5.00, 'America/Caracas' => -4.30, 'America/Halifax' => -4.00, 'America/St_Johns' => -3.30, 'America/Argentina/Buenos_Aires' => -3.00, 'America/Sao_Paulo' => -3.00, 'Atlantic/South_Georgia' => -2.00, 'Atlantic/Azores' => -1.00, 'Europe/Dublin' => 0, 'Europe/Belgrade' => 1.00, 'Europe/Minsk' => 2.00, 'Asia/Kuwait' => 3.00, 'Asia/Tehran' => 3.30, 'Asia/Muscat' => 4.00, 'Asia/Yekaterinburg' => 5.00, 'Asia/Kolkata' => 5.30, 'Asia/Katmandu' => 5.45, 'Asia/Dhaka' => 6.00, 'Asia/Rangoon' => 6.30, 'Asia/Krasnoyarsk' => 7.00, 'Asia/Brunei' => 8.00, 'Asia/Seoul' => 9.00, 'Australia/Darwin' => 9.30, 'Australia/Canberra' => 10.00, 'Asia/Magadan' => 11.00, 'Pacific/Fiji' => 12.00, 'Pacific/Tongatapu' => 13.00);
date_default_timezone_set('America/Lima');
// date_default_timezone_set('America/Maxico_City');
// setlocale(LC_TIME,"es_PE");
include("../model/conexion.php");
$Con = new ApptivaDB();
$usuario = "";
$consultaCursos = "";
if (isset($_SESSION["asistenteLogeado"])) {
    $usuario = $_SESSION["asistenteLogeado"];
} else if (isset($_POST["idUsuario"])) {
    $usuario = $_POST["idUsuario"];
} else {
    $usuario = 0;
}


if (isset($_POST["BusquedaVenta"])) {
    $Ventas = array();
    $codEstado = $_POST["codEstado"];
    $IdCampanina = $_POST["idCampania"];
    $HabilitarFechas = $_POST["Habilitarfechas"];
    $FechaIn = $_POST["dFechaInicio"];
    $FechaFin = $_POST["dFechaFin"];
    $valores = "$usuario,$codEstado,$IdCampanina,$HabilitarFechas,'$FechaIn','$FechaFin'";
    // $valores = "3,'$_POST[codEstado]','$_POST[idCampania]','$_POST[Habilitarfechas]','$_POST[dFechaIn]','$_POST[dFechaFin]'";
    // $valores = "".'3'.",".$_POST['codEstado'].",".$_POST['idCampania'].",".$_POST['Habilitarfechas'].",".$_POST['dFechaIn'].",".$_POST['dFechaFin'];

    // $consulta = $Con->EjecutarProcedimiento("spBuscarVenta", $valores);

    $consulta = $Con->buscarConsultas(
        "V.idventa,ev.idEvento,V.cCodVenta,c.codCliente,c.idCliente,c.nombresCliente,SUBSTRING_INDEX(SUBSTRING_INDEX(c.apellidosCliente, ' ', 1), ' ', -1) AS apellido,V.fecha_registroV,dv.numeroCuotas,CONCAT(tm.SimboloMoneda,dv.importeTotal) as total,tc.cCodTab estadoVenta
        ,tc.cNomTab,p.per_nombre,cr.fechaInicio fInicioClase,cr.fechaFinal fFinalClase,cr.progresoClase ,ev.cDescripcion,tcMod.cCodTab codModalidad,tcMod.cNomTab modalidad",
        "venta V 
        INNER JOIN detalleventa dv ON dv.fk_codVenta=V.cCodVenta
        INNER JOIN clase_realizar cr ON cr.fk_codVenta=V.cCodVenta
        INNER JOIN detalle_evento de ON de.idDetalleEvento=cr.fk_idEventoVenta
        INNER JOIN eventos_venta ev ON ev.idEvento=de.fk_idEvento
        INNER JOIN tablacod tcMod ON ev.cCodModalidad=tcMod.cCodTab
        INNER JOIN campaniassmtk cm ON cm.idCampania=cr.fk_idCampania
        INNER JOIN clientes c ON V.fk_IdAlumno=c.idCliente
        INNER JOIN tipomoneda tm ON tm.idTipoMoneda=dv.fk_tipoMoneda
        INNER JOIN usuarios u ON u.idUsuario=V.idUsuario
        INNER JOIN personal p ON p.idPersonal=u.ID_PERSONAL    
        INNER JOIN tablacod tc ON tc.cCodTab=V.estadoVenta ",
        "(($usuario=0) OR(V.idUsuario= $usuario))
    AND (($IdCampanina=0) OR (cr.fk_idCampania=$IdCampanina))
    AND (($codEstado='0') OR (V.estadoVenta=$codEstado))
    AND (($HabilitarFechas=0) OR (V.fecha_registroV BETWEEN '$FechaIn' AND DATE_ADD('$FechaFin', INTERVAL 1 DAY)))"
    );
    // print_r($valores);
    // return;
    foreach ($consulta as $row) {
        $Ventas[] = array(
            'Idventa' => $row['idventa'],
            'CodVenta' => $row['cCodVenta'],
            'idEvento' => $row['idEvento'],
            'idCliente' => $row['idCliente'],
            'codCliente' => $row['codCliente'],
            'Alumno' => $row['nombresCliente'] . " " . $row['apellido'],
            'NombreCurso' => $row['cDescripcion'],
            'CodModalidad' => $row['codModalidad'],
            // 'FechaReg' =>strftime("%d de %b  %Y", strtotime($row['fecha_registroV'])),
            'FechaReg' => $Con->fnObtenePrmtFecha($row['fecha_registroV'], "d") . " de " . $Con->fnConvertirFechas($Con->fnObtenePrmtFecha($row['fecha_registroV'], "m")) . " del " . $Con->fnObtenePrmtFecha($row['fecha_registroV'], "Y"),
            // 'FechaInicioCurso' => strftime("%d de %b del %Y", strtotime($row['fInicioClase'])),
            'FechaInicioCurso' => $Con->fnObtenePrmtFecha($row['fInicioClase'], "d") . " de " . $Con->fnConvertirFechas($Con->fnObtenePrmtFecha($row['fInicioClase'], "m")) . " del " . $Con->fnObtenePrmtFecha($row['fInicioClase'], "Y"),
            'FechaIni' => date("Y-m-d", strtotime($row['fInicioClase'])),
            // 'FechaFinalCurso' => strftime("%d de %b del %Y", strtotime($row['fFinalClase'])),
            'FechaFinalCurso' => $Con->fnObtenePrmtFecha($row['fFinalClase'], "d") . " de " . $Con->fnConvertirFechas($Con->fnObtenePrmtFecha($row['fFinalClase'], "m")) . " del " . $Con->fnObtenePrmtFecha($row['fFinalClase'], "Y"),
            'FechaFinal' => date("Y-m-d", strtotime($row['fFinalClase'])),
            'NumCuotas' => $row['numeroCuotas'],
            'ImporteTotal' => $row['total'],
            'cCodProgresoClase' => $row['progresoClase'],
            'CodEstadoventa' => $row['estadoVenta'],
            'NomEstadoventa' => $row['cNomTab'],
            'Personal' => $row['per_nombre']
        );
    }
    echo json_encode($Ventas);
}

if (isset($_POST["BusquedaDetalleVenta"])) {

    $EventoUnico = array();
    $DetalleEventos = array();

    $codigoVenta = $_POST["codigoVenta"];
    $codigoCliente = $_POST["codigoCliente"];
    $idEvento = $_POST["idEvento"];

    $consultaEvento = $Con->buscarConsultas(
        "cl.idCliente,cl.codCliente,cl.nombresCliente,cl.apellidosCliente,cl.correoCliente,cl.telefonoCliente,
        ev.idEvento,ev.cDescripcion,cm.cNombreCampania",
        "clase_realizar cr 
        INNER JOIN clientes cl ON cl.codCliente=cr.fk_codAlumno
        INNER JOIN detalle_evento de ON de.idDetalleEvento=cr.fk_idEventoVenta
        INNER JOIN eventos_venta ev ON ev.idEvento=de.fk_idEvento
        INNER JOIN campaniassmtk cm ON cm.idCampania=ev.fk_idCampania",
        "cr.fk_codVenta='".$codigoVenta."'
        AND cl.codCliente='".$codigoCliente."'
        AND ev.idEvento=$idEvento
        GROUP BY cr.fk_codVenta"
    );
    $consultaDetalleEvento = $Con->buscarConsultas(
        "cv.idCursoV,cr.idClaseRealizar,cr.codClaseRealizar,cr.progresoClase,cv.cNombreCortoCurso,ev.cCodModalidad,cr.fechaInicio,cr.fechaFinal,tc.cNomTab",
        "clase_realizar cr 
        INNER JOIN tablacod tc ON tc.cCodTab=cr.progresoClase
        INNER JOIN clientes cl ON cl.codCliente=cr.fk_codAlumno
        INNER JOIN detalle_evento de ON de.idDetalleEvento=cr.fk_idEventoVenta
        INNER JOIN eventos_venta ev ON ev.idEvento=de.fk_idEvento
        INNER JOIN cursos_venta cv ON cv.idCursoV=de.fk_idCurso",
        "cr.fk_codVenta='".$codigoVenta."'
        AND cl.codCliente='".$codigoCliente."'
        AND ev.idEvento=$idEvento"
    );

    foreach ($consultaDetalleEvento as $row) {
        $DetalleEventos[] = array(
            'idClaseRealizar' => $row['idClaseRealizar'],
            'cNombreCortoCurso' => $row['cNombreCortoCurso'],
            'cCodModalidad' => $row['cCodModalidad'],
            'fechaIni' => date("Y-m-d", strtotime($row['fechaInicio'])),
            'fechaFin' => date("Y-m-d", strtotime($row['fechaFinal'])),
            // 'fechaIni' => strftime("%d de %b del %Y", strtotime($row['fechaInicio'])),
            'FechaInicioCurso' => $Con->fnObtenePrmtFecha($row['fechaInicio'], "d") . " de " . $Con->fnConvertirFechas($Con->fnObtenePrmtFecha($row['fechaInicio'], "m")) . " del " . $Con->fnObtenePrmtFecha($row['fechaInicio'], "Y"),
            // 'fechaFin' => strftime("%d de %b del %Y", strtotime($row['fechaFinal'])),
            'FechaFinalCurso' => $Con->fnObtenePrmtFecha($row['fechaFinal'], "d") . " de " . $Con->fnConvertirFechas($Con->fnObtenePrmtFecha($row['fechaFinal'], "m")) . " del " . $Con->fnObtenePrmtFecha($row['fechaFinal'], "Y"),
            'cNomProgresoClase' => $row['cNomTab'],
            'cCodProgresoClase' => $row['progresoClase']
        );
    }
    foreach ($consultaEvento as $row) {
        $EventoUnico[] = array(
            'idCliente' => $row['idCliente'],
            'codCliente' => $row['codCliente'],
            'nombresCliente' => $row['nombresCliente'],
            'apellidosCliente' => $row['apellidosCliente'],
            'correoCliente' => $row['correoCliente'],
            'telefonoCliente' => $row['telefonoCliente'],
            'idEvento' => $row['idEvento'],
            'cDescripcion' => $row['cDescripcion'],
            'cNombreCampania' => $row['cNombreCampania'],            
            'detalleVenta' => $DetalleEventos
        );
    }
    echo json_encode($EventoUnico);

}
if(isset($_POST["BusquedaDetalleEventos"])){

    $EventoUnico = array();
    $DetalleEventos = array();

    $codigoEvento = $_POST["codigoEvento"];

    $consultaEvento = $Con->buscarConsultas(
        "ev.idEvento,ev.codEvento,ev.cDescripcion,ev.cCodModalidad,ev.importeMonedaCambio",
        "eventos_venta ev 
        INNER JOIN tablacod tc ON tc.cCodTab=ev.cCodModalidad",
        "ev.codEvento='".$codigoEvento."'"
    );
    $consultaDetalleEvento = $Con->buscarConsultas(
        "de.idDetalleEvento,cv.cNombreCortoCurso,tc.disenioFrontal,tc.disenioPosterior",
        "eventos_venta ev
        INNER JOIN detalle_evento de ON de.cCodEvento=ev.codEvento
        INNER JOIN cursos_venta cv ON cv.idCursoV=de.fk_idCurso
        INNER JOIN templatecerificado tc ON tc.idDetalleEvento=de.idDetalleEvento",
        "ev.codEvento='".$codigoEvento."'"
    );

    foreach ($consultaDetalleEvento as $row) {
        $DetalleEventos[] = array(
            'idDetalleEvento' => $row['idDetalleEvento'],
            'cNombreCortoCurso' => $row['cNombreCortoCurso'],
            'disenioFrontal' => $row['disenioFrontal'],
            'disenioPosterior' => $row['disenioPosterior']
        );
    }
    foreach ($consultaEvento as $row) {
        $EventoUnico[] = array(
            'idEvento' => $row['idEvento'],
            'codEvento' => $row['codEvento'],
            'cDescripcion' => $row['cDescripcion'],
            'cCodModalidad' => $row['cCodModalidad'],
            'importeMonedaCambio' => $row['importeMonedaCambio'],
            'certificado' => $DetalleEventos
        );
    }
    echo json_encode($EventoUnico);
}
if (isset($_POST["BusquedaCursos"])) {
    $Eventos = array();
    $docente = $_POST["idDocente"];
    $codModalidad = $_POST["modalidad"];
    $codEstado = $_POST["estadoEvento"];
    $IdCampanina = $_POST["idCampania"];
    $HabilitarFechas = $_POST["Habilitarfechas"];
    $FechaIn = $_POST["dFechaInicio"];
    $FechaFin = $_POST["dFechaFin"];

    // $valores = "3,'$_POST[codEstado]','$_POST[idCampania]','$_POST[Habilitarfechas]','$_POST[dFechaIn]','$_POST[dFechaFin]'";
    // $valores = "".'3'.",".$_POST['codEstado'].",".$_POST['idCampania'].",".$_POST['Habilitarfechas'].",".$_POST['dFechaIn'].",".$_POST['dFechaFin'];



    $consulta = $Con->buscarConsultas(
        "ev.idEvento,ev.codEvento,ev.cDescripcion,c.cNombreCortoCurso,dc.Nombes,dc.Apellidos, tc.cNomTab modalidad,ev.fecha_inicio,ev.fecha_final ,tcEs.cNomTab,tcEs.cCodTab codEstado",
        "eventos_venta ev 
            INNER JOIN detalle_evento de ON de.fk_idEvento=ev.idEvento
            INNER JOIN tablacod tc ON ev.cCodModalidad=tc.cCodTab 
            INNER JOIN tablacod tcEs ON ev.cEstadoEvento=tcEs.cCodTab
            INNER JOIN campaniassmtk cm ON ev.fk_idCampania=cm.idCampania 
            INNER JOIN cursos_venta c ON de.fk_idCurso=c.idCursoV 
            left JOIN docentes dc ON ev.fk_idDocente=dc.idDocente",
        "(($docente=0) OR(dc.idDocente= $docente))
            AND (($IdCampanina=0) OR (cm.idCampania=$IdCampanina))
            AND (($codModalidad='0') OR (tc.cCodTab=$codModalidad))
            AND (($codEstado='0') OR (tcEs.cCodTab=$codEstado))
            AND (($HabilitarFechas=0) OR (ev.fecha_inicio BETWEEN '$FechaIn' AND DATE_ADD('$FechaFin', INTERVAL 1 DAY)))
            GROUP BY ev.idEvento"
    );
    // print_r($valores);
    // return;
    foreach ($consulta as $row) {
        $contador = $Con->buscarConsultas(
            "COUNT(*) numAlumnos",
            "venta v
            INNER JOIN clientes cl ON cl.codCliente=v.fk_codAlumno
            INNER JOIN clase_realizar cr ON cr.fk_codVenta=v.cCodVenta
            INNER JOIN detalle_evento de ON de.idDetalleEvento=cr.fk_idEventoVenta
            INNER JOIN eventos_venta ev ON ev.idEvento=de.fk_idEvento",
            "ev.codEvento='" . $row["codEvento"] . "'"
        );
        foreach ($contador as $roww) {
            $NumAlumnos[] = array(
                'NumAlumnos' => $roww["numAlumnos"]
            );
        }

        $Eventos[] = array(
            'idEvento' => $row['idEvento'],
            'codEvento' => $row['codEvento'],
            'NombreCurso' => $row['cDescripcion'] == "" ? $row["cNombreCortoCurso"] : $row['cDescripcion'],
            'Docente' => $row['Nombes'] . " " . $row['Apellidos'],
            'modalidad' => $row['modalidad'],

            'FechaIni' => date("Y-m-d", strtotime($row['fecha_inicio'])),
            'FechaFinal' => date("Y-m-d", strtotime($row['fecha_final'])),

            // 'FechaReg_ini' => $Con->fnObtenePrmtFecha($row['fecha_inicio'], "d") . " de " . $Con->fnConvertirFechas($Con->fnObtenePrmtFecha($row['fecha_inicio'], "m")) . " del " . $Con->fnObtenePrmtFecha($row['fecha_inicio'], "Y"),
            'FechaReg_ini' => date("d/m/Y", strtotime($row['fecha_inicio'])),
            // 'FechaReg_fin' => $Con->fnObtenePrmtFecha($row['fecha_final'], "d") . " de " . $Con->fnConvertirFechas($Con->fnObtenePrmtFecha($row['fecha_final'], "m")) . " del " . $Con->fnObtenePrmtFecha($row['fecha_final'], "Y"),
            'FechaReg_fin' => date("d/m/Y", strtotime($row['fecha_final'])),
            'EstadoEvento' => $row['cNomTab'],
            'codEstado' => $row['codEstado'],
            'NumAlumnos' => $NumAlumnos
        );
    }
    echo json_encode($Eventos);
}
if (isset($_POST["BusquedaAlumnosXCursos"])) {
    $Alumnos = array();
    $Cursos = array();
    $Notas = array();
    $consultaCursos = $Con->buscarConsultas(
        "ev.codEvento,cv.idListaSendBl,cv.idCursoV,cv.cNombreCortoCurso  cNombreCurso,tc.cCodTab,tc.cNomTab,dc.Nombes,dc.Apellidos",
        "eventos_venta ev
        INNER JOIN clase_realizar cr ON cr.fk_idEventoVenta=ev.idEvento 
        INNER JOIN tablacod tc ON tc.cCodTab=ev.cCodModalidad
        INNER JOIN detalle_evento de ON de.cCodEvento=ev.codEvento
        INNER JOIN cursos_venta cv ON cv.idCursoV=de.fk_idCurso
        left JOIN docentes dc ON dc.idDocente=ev.fk_idDocente",
        "ev.codEvento='" . $_POST["codCurso"] . "'
        AND ((" . $_POST["idDocente"] . "='0') OR (dc.idDocente=" . $_POST["idDocente"] . "))
        AND ((" . $_POST["modalidad"] . "='0') OR (tc.cCodTab=" . $_POST["modalidad"] . "))
        AND ((" . $_POST["estadoEvento"] . "='0') OR (ev.cEstadoEvento=" . $_POST["estadoEvento"] . "))
        AND ((" . $_POST["idCampania"] . "=0) OR (cr.fk_idCampania=" . $_POST["idCampania"] . "))
        AND ((" . $_POST["Habilitarfechas"] . "=0) OR (cr.fechaInicio BETWEEN '" . $_POST["dFechaInicio"] . "' AND DATE_ADD('" . $_POST["dFechaFin"] . "', INTERVAL 1 DAY)))
        GROUP BY ev.codEvento
        "

    );
    $consulta = $Con->buscarConsultas(
        "cr.codClaseRealizar,cl.idCliente,cl.codCliente,cl.nombresCliente,cl.apellidosCliente,cr.progresoClase,cr.estadoEntregaCertificado,tc.cNomTab,
        nt.codNotas,nt.nota1,nt.nota2,nt.nota3,nt.promedio,nt.estadoNotas",
        "clientes cl 
        INNER JOIN venta v ON v.fk_codAlumno=cl.codCliente
        INNER JOIN clase_realizar cr ON cr.fk_codVenta=v.cCodVenta
        LEFT JOIN notas_alumno nt ON nt.codClaseRealizar=cr.codClaseRealizar
        INNER JOIN tablacod tc ON tc.cCodTab=cr.progresoClase 
        INNER JOIN eventos_venta ev ON ev.idEvento=cr.fk_idEventoVenta
        INNER JOIN detalle_evento de ON de.cCodEvento=ev.codEvento
        INNER JOIN cursos_venta cv ON cv.idCursoV=de.fk_idCurso",
        "ev.codEvento='" . $_POST["codCurso"] . "'
        AND (('" . $_POST["idCurso"] . "'='') OR (cv.idCursoV='" . $_POST["idCurso"] . "'))"
    );

    foreach ($consulta as $row) {

        $Alumnos[] = array(
            'codClase' => $row['codClaseRealizar'],
            'idCliente' => $row['idCliente'],
            'codCliente' => $row['codCliente'],
            'Cliente' => $row['nombresCliente'] . " " . $row["apellidosCliente"],
            'codProgresoClase' => $row['progresoClase'],
            'progresoClase' => $row['cNomTab'],
            'CodNotas' => $row['codNotas'],
            'nota1' => $row['nota1'],
            'nota2' => $row['nota2'],
            'nota3' => $row['nota3'],
            'promedio' => $row['promedio'],
            'estadCertificacion' => $row['estadoEntregaCertificado']

        );
    }
    foreach ($consultaCursos as $row) {
        $Cursos[] = array(
            'CodEvento' => $row['codEvento'],
            'idListaSendBl' => $row['idListaSendBl'],
            'IdCurso' => $row['idCursoV'],
            'nombreCurso' => $row['cNombreCurso'],
            'cModalidad' => $row['cNomTab'],
            'codModalidad' => $row['cCodTab'],
            'nombreDocente' => $row['Nombes'] . " " . $row['Apellidos'],
            'Alumnos' => $Alumnos

        );
    }
    echo json_encode($Cursos);
}

if (isset($_POST["BusquedaCertificadoXAlumno"])) {
    try {
        $Certificado = array();
        $codCliente = $_POST["codCliente"];
        $codEvento = $_POST["codEvento"];
        $idCurso = $_POST["idCurso"];

        $consulta = $Con->buscarConsultas(
            "v.idventa,cl.nombresCliente,cl.apellidosCliente,cv.cNombreCurso,cv.codCursoCertificado,cm.idCampania,tc.disenioFrontal,tc.disenioPosterior,cr.idSecuenciaIncritos,cr.fechaInicio,cr.fechaFinal,nt.promedio",
            "clientes cl 
            INNER JOIN venta v ON v.fk_codAlumno=cl.codCliente
            INNER JOIN clase_realizar cr ON cr.fk_codVenta=v.cCodVenta
            LEFT JOIN notas_alumno nt ON nt.codClaseRealizar=cr.codClaseRealizar
            INNER JOIN campaniassmtk cm ON cm.idCampania=cr.fk_idCampania
            INNER JOIN eventos_venta ev ON ev.idEvento=cr.fk_idEventoVenta
            INNER JOIN detalle_evento de ON de.cCodEvento=ev.codEvento
            INNER JOIN templatecerificado tc ON tc.idDetalleEvento=de.idDetalleEvento
            INNER JOIN cursos_venta cv ON cv.idCursoV=de.fk_idCurso",
            "cl.codCliente='" . $codCliente . "'
            AND ev.codEvento='" . $codEvento . "'
            AND cv.idCursoV='" . $idCurso . "'"

        );
        foreach ($consulta as $row) {
            $Certificado[] = array(
                'codVenta' => $row['idventa'],
                'idSecuencia' => $row['idSecuenciaIncritos'],
                'certificadoFrontal' => $row['disenioFrontal'],
                'certificadoPosterior' => $row['disenioPosterior'],
                'nombresCliente' => mb_convert_case($row['nombresCliente'] . " " . $row['apellidosCliente'], MB_CASE_TITLE, "UTF-8"),
                'fechaDeCurso' => "Realizado del " . $Con->fnObtenePrmtFecha($row['fechaInicio'], "d") . " de "
                    . $Con->fnConvertirFechas($Con->fnObtenePrmtFecha($row['fechaInicio'], "m")) . " al "
                    . $Con->fnObtenePrmtFecha($row['fechaFinal'], "d") . " de " . $Con->fnConvertirFechas($Con->fnObtenePrmtFecha($row['fechaFinal'], "m")) . " del "
                    . $Con->fnObtenePrmtFecha($row['fechaFinal'], "Y"),

                'codCursoCertificado' => $row['codCursoCertificado'] . ".C-" . $row['idCampania'],
                'idCampania' => $row['idCampania'],
                'promedio' => $row['promedio']

            );
        }
    } catch (\Throwable $th) {
        // $respuesta["error"]="Error: ".$th;
    }
    echo json_encode($Certificado);
}

// codigo para actualizar las fechas de inicializacion y fin del curso
if (isset($_POST["ActualizarFechasCurso"])) {
    try {
        $dFechaIni = $_POST["dFechaIni"];
        $dFechaFin = $_POST["dFechaFin"];
        $cboProgreso = $_POST["cboProgreso"];
        $cCodAlumno = $_POST["codCliente"];
        $cCodVenta = $_POST["Codventa"];

        // $valores = "'" . $dFechaIni . "','" . $dFechaFin . "'," . $cboProgreso . ",'" . $cCodAlumno . "','" . $cCodVenta . "'";
        // $consulta = $Con->EjecutarProcedimiento("sp_actualizarCurso", $valores);
        
        $consulta = $Con->actualizar("clase_realizar", "fechaInicio='" . $dFechaIni . "',fechaFinal='" . $dFechaFin . "',progresoClase=" . $cboProgreso . "", "idClaseRealizar='" . $cCodVenta . "' AND fk_codAlumno='" . $cCodAlumno . "'");
        if ($consulta) {
            $respuesta["ok"] = "Actualización Correcta";
        } else {
            $respuesta["error"] = "Error en la Actualización";
        }
    } catch (\Throwable $th) {
        $respuesta["error"] = "Error: " . $th;
    }
    echo json_encode($respuesta);
}

// codigo para actualizar las fechas del evento
if (isset($_POST["ActualizarFechasEvento"])) {
    try {
        $dFechaIni = $_POST["dFechaIni"];
        $dFechaFin = $_POST["dFechaFin"];
        $cboProgreso = $_POST["cboProgreso"];
        $idEvento = $_POST["IdEvento"];
        $cCodEvento = $_POST["CodEvento"];
        // $valores = "'" . $dFechaIni . "','" . $dFechaFin . "'," . $cboProgreso . ",'" . $cCodAlumno . "','" . $cCodVenta . "',cEstadoEvento=".$cboProgreso."";
        // $consulta = $Con->EjecutarProcedimiento("sp_actualizarCurso", $valores);
        // $consulta = $Con->actualizar("clase_realizar", "fechaInicio='" . $dFechaIni . "',fechaFinal='" . $dFechaFin . "',progresoClase=" . $cboProgreso . "", "idClaseRealizar='" . $cCodEvento . "'");

        $consulta = $Con->actualizar("eventos_venta", "fecha_inicio='" . $dFechaIni . "',fecha_final='" . $dFechaFin . "',cEstadoEvento=" . $cboProgreso . "", "codEvento='" . $cCodEvento . "'");
        if ($consulta) {

            $ActualizarClaseRalizar = $Con->actualizar(
                "clase_realizar cr
                INNER JOIN eventos_venta ev ON ev.idEvento =cr.fk_idEventoVenta",
                "cr.fechaInicio='" . $dFechaIni . "',cr.fechaFinal='" . $dFechaFin . "',cr.progresoClase=" . $cboProgreso . "",
                "cr.fk_idEventoVenta='" . $idEvento . "' AND ev.cCodModalidad='MODV0001'"
            );
            if ($ActualizarClaseRalizar) {

                $respuesta["ok"] = "Actualización Correcta";
            } else {

                $respuesta["error"] = "Error en la Actualización";
            }
        } else {
            $respuesta["error"] = "Error en la Actualización";
        }
    } catch (\Throwable $th) {
        $respuesta["error"] = "Error: " . $th;
    }
    echo json_encode($respuesta);
}


// codigo para actualizar el estado de progreso de las clases por evento
if (isset($_POST["ActualizarEstadoCursos"])) {

    try {
        $fecha_actual = date("Y-m-d");
        $valores = "'" . $fecha_actual . "'";
        $consulta = $Con->EjecutarProcedimiento("sp_actualizarInicioCurso", $valores);

        if ($consulta) {
            $respuesta["ok"] = "Actualización Correcta " . $fecha_actual;
        } else {
            $respuesta["error"] = "Error en la Actualización";
        }
    } catch (\Throwable $th) {
        //throw $th;
    }
    echo json_encode($respuesta);
}

// codigo para buscar historial de cliente
if (isset($_POST["BusquedaHistoryAlumno"])) {

    try {
        $jHistorial = array();
        $jAlumno = array();
        $Cod = addslashes($_POST["codCliente"]);
        $CodAlumno = "'" . $Cod . "'";

        // $Historial = $Con->EjecutarProcedimientosAlmacenados("sp_ListarHistoryAlumnos", $CodAlumno);

        $Historial = $Con->buscarConsultas(
            "cr.codClaseRealizar,cv.cNombreCortoCurso,ev.cCodModalidad,na.promedio,cr.fechaInicio,cr.fechaFinal,tm.SimboloMoneda,dv.importeTotal",
            "venta v 
            INNER JOIN detalleventa dv ON dv.fk_codVenta=v.cCodVenta
            INNER JOIN clientes cl ON cl.codCliente=v.fk_codAlumno
            INNER JOIN clase_realizar cr ON v.cCodVenta=cr.fk_codVenta
            LEFT JOIN notas_alumno na ON na.codClaseRealizar=cr.codClaseRealizar
            INNER JOIN eventos_venta ev ON ev.idEvento=cr.fk_idEventoVenta
            INNER JOIN tipomoneda tm ON tm.idTipoMoneda=dv.fk_tipoMoneda
            INNER JOIN detalle_evento de ON de.cCodEvento=ev.codEvento
            INNER JOIN cursos_venta cv ON cv.idCursoV=de.fk_idCurso",
            "cl.codCliente='" . $Cod . "'"

        );

        foreach ($Historial as $row) {
            $jHistorial[] = array(
                'nombreCruso' => $row['cNombreCortoCurso'],
                'modalidad' => $row['cCodModalidad'],
                'promedio' => $row['promedio'],
                'fechaIni' => $Con->fnObtenePrmtFecha($row['fechaInicio'], "d") . " de " . $Con->fnConvertirFechas($Con->fnObtenePrmtFecha($row['fechaInicio'], "m")) . " del "
                    . $Con->fnObtenePrmtFecha($row['fechaInicio'], "Y"),
                'fechaFin' => $Con->fnObtenePrmtFecha($row['fechaFinal'], "d") . " de " . $Con->fnConvertirFechas($Con->fnObtenePrmtFecha($row['fechaFinal'], "m")) . " del "
                    . $Con->fnObtenePrmtFecha($row['fechaFinal'], "Y"),
                'importeTotal' => $row['SimboloMoneda'] . " " . number_format($row["importeTotal"], 1)


            );
        }

        // $Alumno = $Con->buscarConsultas(
        //     "cl.nombresCliente,cl.apellidosCliente,cl.correoCliente,cl.telefonoCliente,pa.Nombre_pais",
        //     "clientes cl
        //     INNER JOIN pais pa ON pa.Codigo=cl.paisCliente",
        //     "cl.codCliente='" . $Cod . "'"

        // );
        $Alumno = $Con->EjecutarProcedimientosAlmacenados("sp_ListarAlumnoEspecifico", $CodAlumno);

        foreach ($Alumno as $row) {
            $jAlumno[] = array(
                'nombreAlumno' => $row['nombresCliente'] . " " . $row['apellidosCliente'],
                'correo' => $row['correoCliente'],
                'telefono' => $row['telefonoCliente'],
                'Nombre_pais' => $row['Nombre_pais'],
                'historial' => $jHistorial

            );
        }
    } catch (\Throwable $th) {
        //throw $th;
    }
    echo json_encode($jAlumno);
}
