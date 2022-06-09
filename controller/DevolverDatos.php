<?php
session_start();
header('Acces-Control-Allow-Origin: *');
// ini_set('session.gc_maxlifetime',60*60);  // 1 hora
include("../model/conexion.php");
include("../model/url.php");
// require_once("../model/Clases.php");
$busq = new ApptivaDB();
$CodigoPais = array();
$Codigo = "";
$institucion = "";
$cboInstitucion = "";
$cboCursos = "";

$ZonaHoraria = date_default_timezone_set('America/lima');
$fecha_actual = date("Y-m-d");
$fecha_sumada = date("Y-m-d", strtotime($fecha_actual . "+ 1 days"));
$fecha_restada = date("Y-m-d", strtotime($fecha_actual . "- 30 days"));


$idUsuLogeado = 0;
$idUsuLogeadoAlerVentas = 0;
if (isset($_SESSION['adminLogeado'])) {
    $idUsuLogeado = $_SESSION['adminLogeado'];
    $idUsuLogeadoAlerVentas=0;
} else
if (isset($_SESSION["supervisorLogeado"])) {
    $idUsuLogeado = $_SESSION['supervisorLogeado'];
    $idUsuLogeadoAlerVentas=0;
} else if (isset($_SESSION["asistenteLogeado"])) {
    $idUsuLogeado = $_SESSION['asistenteLogeado'];
    $idUsuLogeadoAlerVentas=$_SESSION['asistenteLogeado'];
}
if(isset($_POST["buscarUbigeo"])){
    if($_POST["combo"]=="CboDepartamento"){
        $select = $busq->buscarCar(
            "d.idDepa id,d.cNomDep nombre",
            "Departamento d 
            INNER JOIN pais p ON p.Codigo=d.idPais",
            "p.Codigo='" . $_POST["codABuscar"] . "'"
        );
        $cboDatos .= "<option value='0'>Seleccione Departamento</option>";
    }
    if($_POST["combo"]=="CboProvincia"){
        $select = $busq->buscarCar(
            "p.idProv id,p.cNomProv nombre",
            "Provincia p 
            INNER JOIN Departamento d ON d.idDepa=p.idDepa",
            "d.idDepa='" . $_POST["codABuscar"] . "'"
        );
        $cboDatos .= "<option value='0'>Seleccione Provincia</option>";
    }
    if($_POST["combo"]=="CboDistrito"){
        $select = $busq->buscarCar(
            "d.idDist id,d.cNomDist nombre",
            "Distrito d 
            INNER JOIN Provincia p ON p.idProv=d.idProv",
            "p.idProv='" . $_POST["codABuscar"] . "'"
        );
        $cboDatos .= "<option value='0'>Seleccione Distrito</option>";
    }
    
   
    foreach ($select as $cur) {
        $cboDatos .= "<option value=" . $cur['id'] . ">" . $cur['nombre'] . "</option>";
    }
    echo $cboDatos;
}
//codigo para obtener los datos del usuario logeado//
if (isset($_POST["Logeo"])) {
    $usuarioLogeado = $busq->buscarFech(
        "p.imagen,p.per_nombre,p.per_apellido_paterno,c.nombreCargo",
        "personal p
        INNER JOIN usuarios u ON p.idPersonal=u.ID_PERSONAL
        INNER JOIN cargos c ON u.ID_CARGO=c.idCargo",
        "u.idUsuario='" . $idUsuLogeado . "'"
    );
    foreach ($usuarioLogeado as $un) {
        $usuLogeado['imgUsuario'] = $un['imagen'];
        $usuLogeado['usuario'] = $un['per_nombre'] . " " . $un['per_apellido_paterno'];
        $usuLogeado['cargo'] = mb_convert_case($un['nombreCargo'], MB_CASE_TITLE, "UTF-8");
    }

    echo json_encode($usuLogeado);
}



if (isset($_POST["AlertTotalVentas"])) {
    $cantVentas = $busq->buscarFech(
        " ifnull(COUNT(v.idventa),0) numVentas, ifnull(SUM(dv.importeTotal),0) sumaVentas,tm.SimboloMoneda",
        " venta v
        INNER JOIN detalleventa dv ON dv.fk_codVenta=v.cCodVenta
                INNER JOIN usuarios u ON u.idUsuario=v.idUsuario
                INNER JOIN tipomoneda tm ON tm.idTipoMoneda=dv.fk_tipoMoneda",
        " v.estadoVenta='ESTV0002'
        AND tm.idTipoMoneda=1
         AND (( '$idUsuLogeadoAlerVentas'=0) OR (v.idUsuario='" . $_SESSION['asistenteLogeado'] . "'))
         AND v.fecha_registroV BETWEEN '" . $fecha_restada . "' AND '" . $fecha_sumada . "'"
    );
    $cantVentasDolar = $busq->buscarFech(
        "ifnull(COUNT(v.idventa),0) numVentasDolar, ifnull(SUM(dv.importeTotal),0) sumaVentas,tm.SimboloMoneda",
        " venta v
        INNER JOIN detalleventa dv ON dv.fk_codVenta=v.cCodVenta
                INNER JOIN usuarios u ON u.idUsuario=v.idUsuario
                INNER JOIN tipomoneda tm ON tm.idTipoMoneda=dv.fk_tipoMoneda",
        " v.estadoVenta='ESTV0002'
        AND tm.idTipoMoneda=2
         AND (( '$idUsuLogeadoAlerVentas'=0) OR (v.idUsuario='" . $_SESSION['asistenteLogeado'] . "'))
         AND v.fecha_registroV BETWEEN '" . $fecha_restada . "' AND '" . $fecha_sumada . "'"
    );
    while ($row = mysqli_fetch_array($cantVentas)) {
        $ArrayVentas[] = array(
            'numeroVentas' => $row['numVentas'],
            'sumaVentas' => $row["SimboloMoneda"] . " " . number_format($row['sumaVentas'], 1)
        );
    }
    while ($row = mysqli_fetch_array($cantVentasDolar)) {
        $ArrayVentas[] = array(
            'numeroVentasDolar' => $row['numVentasDolar'],
            'sumaVentasDolar' => $row["SimboloMoneda"] . " " . number_format($row['sumaVentasDolar'], 1)
        );
    }

    echo json_encode($ArrayVentas);
}

if (isset($_POST["idPais"])) {
    $Codigo = $busq->buscarFech(
        "pais.Codigo_pais",
        "pais",
        "pais.Codigo='" . $_POST["idPais"] . "'"
    );

    while ($row = mysqli_fetch_array($Codigo)) {
        $CodigoPais[] = array(
            'codigo' => $row['Codigo_pais']
        );
    }
    echo json_encode($CodigoPais);
} else if (isset($_POST["idCateInstitucion"])) {
    $institucion = $busq->buscarCar(
        "idInstitucion,nombre",
        "institucion",
        "institucion.ID_CATINSTITUCION='" . $_POST["idCateInstitucion"] . "'"
    );
    foreach ($institucion as $inst) {
        $cboInstitucion .= "<option value=" . $inst['idInstitucion'] . ">" . $inst['nombre'] . "</option>";
    }
    echo $cboInstitucion;
} elseif (isset($_POST["CURSOS"])) {
    $cursostodos = array();
    $cursos = $busq->buscarFech(
        "c.idCursoV,c.cNombreCortoCurso,c.precioCruso",
        "cursos_venta c",
        "'1'"
    );

    while ($row = mysqli_fetch_array($cursos)) {
        $cursostodos[] = array(
            'id' => $row['idCursoV'],
            'nombre' => $row['cNombreCortoCurso'],
            'precio' => $row['precioCruso']
        );
    }
    echo json_encode($cursostodos);
} elseif (isset($_POST["OCUPACION"])) {
    $Ocupaciones = array();
    $ocupacion = $busq->buscarFech(
        "ocupacion.idOcupacion,ocupacion.descripcion",
        "ocupacion",
        "'1'"
    );

    while ($row = mysqli_fetch_array($ocupacion)) {
        $Ocupaciones[] = array(
            'id' => $row['idOcupacion'],
            'nombre' => $row['descripcion']
        );
    }
    echo json_encode($Ocupaciones);
} elseif (isset($_POST["PREGUNTAS"])) {
    $Ocupaciones = array();
    $ocupacion = $busq->buscarFech(
        "preguntas.idPregunta,preguntas.pre_nombre",
        "preguntas",
        "preguntas.pre_estado='1'"
    );

    while ($row = mysqli_fetch_array($ocupacion)) {
        $respuesta = $busq->buscarFech(
            "DISTINCT respuestas.idRespuesta,respuestas.resp_nombre",
            "respuestas",
            "respuestas.ID_PREGUNTA='" . $row['idPregunta'] . "' AND respuestas.resp_estado='1'"
        );
        while ($row2 = mysqli_fetch_array($respuesta)) {
            $Re[] = array(
                'idResp' => intval($row2['idRespuesta']),
                'nombreResp' => $row2['resp_nombre']
            );
        }
        $Respuestas[] = array(
            'id' => intval($row["idPregunta"]),
            'pregunta' => $row['pre_nombre'],
            'respuestas' => $Re
        );
        unset($Re);
    }
    echo json_encode($Respuestas);
} elseif (isset($_POST["idCampania"])) {
    $Cursos = $busq->buscarCar(
        "DISTINCT idCursos,nombreCorto",
        "cursos_prospecto cp
        INNER JOIN cursos c ON cp.ID_CURSO=c.idCursos
        INNER JOIN prospectos p ON cp.ID_PROSPECTO=p.idProspecto
        INNER JOIN campania ca On cp.ID_CAMPANIA=ca.idCampania",
        "ca.idCampania='" . $_POST["idCampania"] . "'"
    );
    $cboCursos .= "<option value='0'>Seleccione Curso</option>";
    foreach ($Cursos as $cur) {
        $cboCursos .= "<option value=" . $cur['idCursos'] . ">" . $cur['nombreCorto'] . "</option>";
    }
    echo $cboCursos;
} elseif (isset($_POST["idPersonal"]) && isset($_POST["lntipoCon"])) {
    $prospectos = array();
    // if ($_POST["idPersonal"] == "" || $_POST["idPersonal"] == 0) {
    //     $prospecto = $busq->buscarGeneral(
    //         "p.idProspecto,p.pros_apellidos,p.pros_nombres,p.pros_email,p.pros_telefono,p.tipoSeguimiento,p.pros_estado_segimiento",
    //         "prospectos p",
    //         "p.pros_estado_segimiento='0'
    //         AND p.idUsuario='0'"
    //     );
    //     while ($row = mysqli_fetch_array($prospecto)) {
    //         $prospectos[] = array(
    //             'id' => $row['idProspecto'],
    //             'nombre' => mb_convert_case($row['pros_apellidos'] . " " . $row['pros_nombres'], MB_CASE_TITLE, "UTF-8"),
    //             'nombrePersonal' => mb_convert_case($row['per_nombre'] . " " . $row['per_apellido_paterno'], MB_CASE_TITLE, "UTF-8"),
    //             'email' => $row['pros_email'],
    //             'telefono' => $row['pros_telefono'],
    //             'tipoSeguimiento' => $row['tipoSeguimiento'],
    //             'estadoSeguimiento' => $row['pros_estado_segimiento']
    //         );
    //     }
    // } else {
        if ($_POST["lntipoCon"] == 0) {
            $prospecto = $busq->buscarGeneral(
                "p.idProspecto,p.pros_apellidos,p.pros_nombres,p.pros_email,p.pros_telefono,pa.Nombre_pais,per.per_nombre,p.tipoSeguimiento,p.pros_estado_segimiento",
                "prospectos p
                LEFT JOIN usuarios u ON p.idUsuario=u.idUsuario
                LEFT JOIN personal per ON u.ID_PERSONAL=per.idPersonal
                LEFT JOIN pais pa ON p.ID_PAIS=pa.Codigo",
                "p.idUsuario='" . $_POST["idPersonal"] . "'
                AND p.pros_estado='1'"
            );
            while ($row = mysqli_fetch_array($prospecto)) {
                $prospectos[] = array(
                    'id' => $row['idProspecto'],
                    'nombre' => mb_convert_case($row['pros_apellidos'] . " " . $row['pros_nombres'], MB_CASE_TITLE, "UTF-8"),
                    'email' => $row['pros_email'],
                    'telefono' => $row['pros_telefono'],
                    'pais' => mb_convert_case($row['Nombre_pais'], MB_CASE_TITLE, "UTF-8"),
                    'personal' => mb_convert_case($row['per_nombre'], MB_CASE_TITLE, "UTF-8"),
                    'tipoSeguimiento' => $row['tipoSeguimiento'],
                    'estadoSeguimiento' => $row['pros_estado_segimiento']
                );
            }
        } elseif ($_POST["lntipoCon"] == 1) {
            $prospecto = $busq->buscarGeneral(
                "p.idProspecto,p.pros_apellidos,p.pros_nombres,p.pros_email,p.pros_telefono,pa.Nombre_pais,per.per_nombre,per.per_apellido_paterno,p.tipoSeguimiento,p.pros_estado_segimiento",
                "prospectos p
                LEFT JOIN usuarios u ON p.idUsuario=u.idUsuario
                LEFT JOIN personal per ON u.ID_PERSONAL=per.idPersonal
                LEFT JOIN pais pa ON p.ID_PAIS=pa.Codigo",
                "p.idUsuario='" . $_POST["idPersonal"] . "'
                AND p.pros_estado='1'
                AND p.pros_estado_segimiento='0'"
            );
            while ($row = mysqli_fetch_array($prospecto)) {
                $prospectos[] = array(
                    'id' => $row['idProspecto'],
                    'nombre' => mb_convert_case($row['pros_apellidos'] . " " . $row['pros_nombres'], MB_CASE_TITLE, "UTF-8"),
                    'nombrePersonal' => mb_convert_case($row['per_nombre'] . " " . $row['per_apellido_paterno'], MB_CASE_TITLE, "UTF-8"),
                    'email' => $row['pros_email'],
                    'telefono' => $row['pros_telefono'],
                    'personal' => mb_convert_case($row['per_nombre'], MB_CASE_TITLE, "UTF-8"),
                    'tipoSeguimiento' => $row['tipoSeguimiento'],
                    'estadoSeguimiento' => $row['pros_estado_segimiento']
                );
            }
        }
    // }
    // $cuadrado = new Figura();
    // $cuadrado->setNombre($_POST["idPersonal"]);
    // $_SESSION["idpersonalNoMostrar"]=$_POST["idPersonal"];
    // $variableIdPersonal=$_POST["idPersonal"];
    echo json_encode($prospectos);
}
if (isset($_POST["Webinars"])) {
    $cursosWebinar = array();
    $cursos = $busq->buscarFech(
        "c.idCursos,c.nombre,c.nombreCorto,c.estado",
        "cursos c",
        "c.estado='1'"
    );

    while ($row = mysqli_fetch_array($cursos)) {
        $cursosWebinar[] = array(
            'id' => $row['idCursos'],
            'nombre' => $row['nombre'],
            'estado' => $row['estado']
        );
    }
    echo json_encode($cursosWebinar);
}
if (isset($_POST["idtipoPago"])) {
    $Entidad = $busq->buscarCar(
        "DISTINCT idEntidadPago,cNombreEntidadPago",
        "entidadespago ep
        INNER JOIN tipopagos tp ON tp.idTipoPago =ep.ID_TIPO_PAGO",
        "ep.ID_TIPO_PAGO='" . $_POST["idtipoPago"] . "'"
    );
    $cboEntidadPago .= "<option value='0'>Seleccione entidad</option>";
    foreach ($Entidad as $cur) {
        $cboEntidadPago .= "<option value=" . $cur['idEntidadPago'] . ">" . $cur['cNombreEntidadPago'] . "</option>";
    }
    echo $cboEntidadPago;
}
if (isset($_POST["idEvento"])) {
    $Cursos = $busq->buscarCar(
        "DISTINCT idCursos,nombreCorto",
        "cursos_prospecto cp
        INNER JOIN cursos c ON cp.ID_CURSO=c.idCursos
        INNER JOIN prospectos p ON cp.ID_PROSPECTO=p.idProspecto
        INNER JOIN campania ca On cp.ID_CAMPANIA=ca.idCampania",
        "ca.idCampania='" . $_POST["idEvento"] . "'"
    );
    $cboCursoModal .= "<option value='0'>Selec: Curso</option>";
    foreach ($Cursos as $cur) {
        $cboCursoModal .= "<option value=" . $cur['idCursos'] . ">" . $cur['nombreCorto'] . "</option>";
    }
    echo $cboCursoModal;
}

// codigo  para buscar los prospectos o clientes en el modal
if (isset($_POST["pcBuscar"]) && isset($_POST["RadioButon"]) && isset($_POST["Campania"]) && isset($_POST["Evento"]) && isset($_POST["CursoXevento"]) && isset($_POST["FechaInicio"]) && isset($_POST["FechaFinal"])) {
    $prospectos = array();
    if ($_POST["RadioButon"] == 0) {
        $prospecto = $busq->buscarGeneral(
            "C.idCliente idProspecto,C.codCliente codCliente, C.nombresCliente pros_nombres,C.apellidosCliente pros_apellidos,C.correoCliente pros_email,C.telefonoCliente pros_telefono,V.fecha_registroV",
            "venta V 
            INNER JOIN clientes C ON V.fk_IdAlumno=C.idCliente
            INNER JOIN clase_realizar cr ON cr.fk_codVenta=V.cCodVenta",
            "('" . $_POST["Campania"] . "'=0 OR cr.fk_idCampania='" . $_POST["Campania"] . "')
            AND (('" . $_POST["FechaInicio"] . "'='' OR '" . $_POST["FechaFinal"] . "'='') OR (cr.fechaRegistro BETWEEN '" . $_POST["FechaInicio"] . "' AND '" . $_POST["FechaFinal"] . "'))
            AND (('" . $_POST["pcBuscar"] . "'='') OR 
            (C.nombresCliente LIKE '%" . $_POST["pcBuscar"] . "%') OR 
                (CONCAT(substring_index(TRIM(C.nombresCliente),' ',1),' ',substring_index(TRIM(C.nombresCliente),' ',1)) LIKE '%" . $_POST["pcBuscar"] . "%') OR 
                (CONCAT(substring_index(substring_index(TRIM(C.nombresCliente),' ',-1),' ', 1),' ',substring_index(TRIM(C.apellidosCliente),' ',1)) LIKE '%" . $_POST["pcBuscar"] . "%') OR
                (C.apellidosCliente LIKE '%" . $_POST["pcBuscar"] . "%') OR
                (C.correoCliente LIKE '%" . $_POST["pcBuscar"] . "%') OR
                (C.telefonoCliente LIKE '%" . $_POST["pcBuscar"] . "%')
            
            )
            GROUP BY C.codCliente
            ORDER BY V.fecha_registroV desc
            "
        );
    } elseif ($_POST["RadioButon"] == 1) {
        $prospecto = $busq->buscarGeneral(
            "p.idProspecto,p.pros_codigo codCliente,TRIM(p.pros_nombres) pros_nombres,TRIM(p.pros_apellidos) pros_apellidos,p.pros_email,p.pros_telefono,p.fechaRegistro",
            "prospectos p
            LEFT JOIN cursos_prospecto cp ON p.idProspecto=cp.ID_PROSPECTO
            LEFT JOIN campania c ON cp.ID_CAMPANIA=c.idCampania
            LEFT JOIN campaniassmtk cs ON cs.idCampania=c.ID_CAMPANIA
            LEFT JOIN cursos cu ON cu.idCursos=cp.ID_CURSO",
            "('" . $_POST["Campania"] . "'=0 OR c.idCampania='" . $_POST["Campania"] . "')
            AND ('" . $_POST["Evento"] . "'=0 OR cp.ID_CAMPANIA='" . $_POST["Evento"] . "')
            AND (('" . $_POST["CursoXevento"] . "'=0 OR '" . $_POST["CursoXevento"] . "'='Null') OR cp.ID_CURSO='" . $_POST["CursoXevento"] . "')
            AND (('" . $_POST["FechaInicio"] . "'='' OR '" . $_POST["FechaFinal"] . "'='') OR (p.fechaRegistro BETWEEN '" . $_POST["FechaInicio"] . "' AND '" . $_POST["FechaFinal"] . "'))
            AND (('" . $_POST["pcBuscar"] . "'='') OR 
                (p.pros_nombres LIKE '%" . $_POST["pcBuscar"] . "%') OR 
                (CONCAT(substring_index(TRIM(p.pros_nombres),' ',1),' ',substring_index(TRIM(p.pros_apellidos),' ',1)) LIKE '%" . $_POST["pcBuscar"] . "%') OR 
                (CONCAT(substring_index(substring_index(TRIM(p.pros_nombres),' ',-1),' ', 1),' ',substring_index(TRIM(p.pros_apellidos),' ',1)) LIKE '%" . $_POST["pcBuscar"] . "%') OR
                (p.pros_apellidos LIKE '%" . $_POST["pcBuscar"] . "%') OR
                (p.pros_email LIKE '%" . $_POST["pcBuscar"] . "%') OR
                (p.pros_telefono LIKE '%" . $_POST["pcBuscar"] . "%')
                
                
                )
            AND p.pro_estadoCilente='0'
            ORDER BY p.fechaRegistro desc
            "
        );
    }
    $primerNombreArray = "";
    $primerNombre = "";
    $primerApellidoArray = "";
    $primerApellido = "";

    while ($row = mysqli_fetch_array($prospecto)) {

        $primerNombreArray = explode(" ", $row['pros_nombres']);
        $primerNombre = $primerNombreArray[0];
        $primerApellidoArray = explode(" ", $row['pros_apellidos']);
        $primerApellido = $primerApellidoArray[0];

        $prospectos[] = array(
            'id' => $row['idProspecto'],
            'codCliente' => $row['codCliente'],
            'nombre' => mb_convert_case($row['pros_nombres']. " " . $primerApellido, MB_CASE_TITLE, "UTF-8"),
            'email' => $row['pros_email'],
            'telefono' => $row['pros_telefono']

        );
    }
    echo json_encode($prospectos);
}
if (isset($_POST["idCliente"]) && isset($_POST["RadioButon"])) {
    if ($_POST["RadioButon"] == 0) {
        $prospecto = $busq->buscarGeneral(
            "cl.idCliente id,cl.codCliente codigo,cl.nombresCliente nombres,cl.apellidosCliente apellidos,cl.correoCliente correo,cl.telefonoCliente telefono,pa.Codigo codPais,pa.Nombre_pais",
            "clientes cl
            LEFT JOIN pais pa on pa.Codigo=cl.paisCliente",
            "cl.idCliente='" . $_POST["idCliente"] . "'
            AND cl.codCliente='".$_POST["codCliente"]."'"
        );

    } elseif ($_POST["RadioButon"] == 1) {
        $prospecto = $busq->buscarGeneral(
            "pr.idProspecto id,pr.pros_codigo codigo,pr.pros_nombres nombres,pr.pros_apellidos apellidos,pr.pros_email correo,
            CASE
                WHEN (pr.ID_PAIS<>'FALTA' AND SUBSTRING(pr.pros_telefono,1,1)='+') THEN SUBSTRING(pr.pros_telefono,1,char_length(pa.Codigo_pais)) 
                ELSE  '+00'
            END AS codigoTelPais ,
            CASE    
                WHEN (pr.ID_PAIS<>'FALTA' AND SUBSTRING(pr.pros_telefono,1,1)='+') THEN 						SUBSTRING(pr.pros_telefono,char_length(pa.Codigo_pais)+1,(char_length(pr.pros_telefono)-char_length(pa.Codigo_pais))) 
                ELSE pr.pros_telefono
            END AS numTelefono,
            pa.Codigo codPais,pa.Nombre_pais",
            "prospectos pr
            LEFT JOIN pais pa on pa.Codigo=pr.ID_PAIS",
            "pr.idProspecto='" . $_POST["idCliente"] . "'
            AND pr.pros_codigo='".$_POST["codCliente"]."'"
        );
    }
    while ($row = mysqli_fetch_array($prospecto)) {

        
        $prospectos[] = array(
            'id' => $row['id'],
            'codCliente' => $row['codigo'],
            'nombres' => mb_convert_case($row['nombres'], MB_CASE_TITLE, "UTF-8"),
            'apellidos' => mb_convert_case($row['apellidos'], MB_CASE_TITLE, "UTF-8"),
            'email' => $row['correo'],
            'telefono' => $row['numTelefono'],
            'codigoTelPais' => $row['codigoTelPais'],
            'codPais'=>$row['codPais']==""?"FALTA":$row['codPais'],
            'pais' => mb_convert_case($row['Nombre_pais'], MB_CASE_TITLE, "UTF-8")

        );
    }
    echo json_encode($prospectos);
}
if (isset($_POST["arregloCursos"])) {
    $Condicion = "";
    $data = json_decode($_POST['arregloCursos']);
    for ($i = 0; $i < count($data); $i++) {
        if ($i + 1 == count($data)) {

            $Condicion .= $data[$i];
        } else {

            $Condicion .= $data[$i] . ",";
        }
    }
    $cursosEspecificos = array();
    $cursos = $busq->buscarFech(
        "c.idCursoV,c.cNombreCortoCurso",
        "cursos_venta c",
        "c.idCursoV IN(" . $Condicion . ")"
    );

    while ($row = mysqli_fetch_array($cursos)) {
        $cursosEspecificos[] = array(
            'id' => $row['idCursoV'],
            'nombre' => $row['cNombreCortoCurso']
        );
    }


    echo json_encode($cursosEspecificos);
    unset($data);
    $Condicion = "";
}

// codigo para mostrar los eventos de venta en la ventana modal

if (isset($_POST["EventosClase"])) {
    $Eventostodos = array();
    $cursos = $busq->buscarFech(
        "ev.idEvento,ev.codEvento,cv.cNombreCortoCurso cDescripcion,tc.cNomTab,ev.importeMonedaLocal,ev.importeMonedaCambio",
        "eventos_venta ev
        INNER JOIN tablacod tc ON tc.cCodTab=ev.cCodModalidad
        INNER JOIN detalle_evento dev On dev.fk_idEvento=ev.idEvento
        INNER JOIN cursos_venta cv ON cv.idCursoV=dev.fk_idCurso",
        "'1'"
    );

    while ($row = mysqli_fetch_array($cursos)) {
        $Eventostodos[] = array(
            'id' => $row['idEvento'],
            'codEvento' => $row['codEvento'],
            'nombre' => $row['cDescripcion'],
            'precioLocal' => $row['importeMonedaLocal'],
            'precioCambio' => $row['importeMonedaCambio'],
            'modalidad' => $row['cNomTab']
        );
    }
    echo json_encode($Eventostodos);
}

// codigo para cargar los eventos seleccionados a la ventana de ventas
if (isset($_POST["arregloEventosClase"])) {
    $Condicion = "";
    $data = json_decode($_POST['arregloEventosClase']);
    for ($i = 0; $i < count($data); $i++) {
        if ($i + 1 == count($data)) {

            $Condicion .= $data[$i];
        } else {

            $Condicion .= $data[$i] . ",";
        }
    }
    $cursosEspecificos = array();
    $cursos = $busq->buscarFech(
        "ev.idEvento,cv.cNombreCortoCurso  cDescripCion,tc.cNomTab,ev.importeMonedaLocal,ev.importeMonedaCambio,ev.fecha_inicio,ev.fecha_final,ev.fk_idCampania",
        "eventos_venta ev
        INNER JOIN detalle_evento dev On dev.fk_idEvento=ev.idEvento
        INNER JOIN cursos_venta cv ON cv.idCursoV=dev.fk_idCurso
        INNER JOIN tablacod tc ON tc.cCodTab=ev.cCodModalidad
        INNER JOIN campaniassmtk cm ON cm.idCampania=ev.fk_idCampania",
        "ev.idEvento IN(" . $Condicion . ")"
    );

    while ($row = mysqli_fetch_array($cursos)) {
        $precioClase=$_POST["idMoneda"]==1?$row['importeMonedaLocal']:$row['importeMonedaCambio'];
        $cursosEspecificos[] = array(
            'id' => $row['idEvento'],
            'nombre' => $row['cDescripCion'],
            'precio' =>  $precioClase,            
            'modalidad' => $row['cNomTab'],
            'dFechaInicio' =>date("Y-m-d", strtotime($row['fecha_inicio'])),
            'dFechaFinal' => date("Y-m-d", strtotime($row['fecha_final'])),
            'idCampania' => $row['fk_idCampania']
        );
    }


    echo json_encode($cursosEspecificos);
    unset($data);
    $Condicion = "";
}

// codigo para buscar las ventas realizadas en modal

if (isset($_POST["tipoBusqueda"]) && $_POST["tipoBusqueda"] == "Cuota") {

    $buscCliente = $busq->buscarGeneral(
        "p.idCliente,cr.fk_idCampania,c.cNombreCampania,v.fecha_registroV,p.nombresCliente,p.apellidosCliente,p.correoCliente,p.telefonoCliente,v.idVenta,v.cCodVenta,tm.SimboloMoneda,dv.importeTotal",
        "venta v
        INNER JOIN detalleventa dv ON dv.fk_codVenta=v.cCodVenta
        INNER JOIN tipomoneda tm ON tm.idTipoMoneda=dv.fk_tipoMoneda
        INNER JOIN clase_realizar cr ON cr.fk_codVenta=v.cCodVenta
        INNER JOIN clientes p ON p.idCliente=v.fk_IdAlumno
        INNER JOIN campaniassmtk c ON c.idCampania=cr.fk_idCampania",
        " v.idUsuario='".$idUsuLogeado."'
        AND ('" . $_POST["Campania"] . "'=0 OR cr.fk_idCampania='" . $_POST["Campania"] . "')
        AND (('" . $_POST["FechaInicio"] . "'='' OR '" . $_POST["FechaFinal"] . "'='') OR (v.fecha_registroV BETWEEN '" . $_POST["FechaInicio"] . "' AND '" . $_POST["FechaFinal"] . "'))
        AND ('" . $_POST["pcBuscar"] . "'='' OR v.cCodVenta LIKE '%" . $_POST["pcBuscar"] . "%')
        ORDER BY v.fecha_registroV DESC"
    );

    while ($row = mysqli_fetch_array($buscCliente)) {
        $countCuotas = $busq->buscarContador(
            "COUNT(pc.idPagoCuotas) numCuotas",
            "pago_cuotas pc
            INNER JOIN venta v ON v.idVenta=pc.fk_Venta",
            "v.fk_IdAlumno='" . $row['idCliente'] . "'
            AND v.cCodVenta='" . $row['cCodVenta'] . "'"
        );

        while ($row2 = mysqli_fetch_array($countCuotas)) {
            $ClientesVenta[] = array(
                'id' => $row['idCliente'],
                'campania' => $row['cNombreCampania'],
                'idVenta' => $row['idVenta'],
                'codVenta' => $row['cCodVenta'],
                'fechaVenta' => strftime("%d de %B del %Y", strtotime($row['fecha_registroV'])),
                'totalVenta' =>$row["SimboloMoneda"]." ".number_format($row['importeTotal'], 2),
                'nombres' => mb_convert_case($row['nombresCliente'] . " " . $row['apellidosCliente'], MB_CASE_TITLE, "UTF-8"),
                'email' => $row['pros_email'],
                'telefono' => $row['pros_telefono'],
                'numCuotas' => $row2['numCuotas']

            );
        }
    }
    echo json_encode($ClientesVenta);
}

// codigo para devolber venta especifica
if (isset($_POST["idCliente"]) && isset($_POST["CodVenta"])) {

    $buscCliente = $busq->buscarGeneral(
        "p.idCliente,cr.fk_idCampania,c.cNombreCampania,v.fecha_registroV,p.nombresCliente,p.apellidosCliente,p.correoCliente,p.telefonoCliente,v.idVenta,v.cCodVenta,dv.importeTotal,tm.SimboloMoneda",
        "venta v
        INNER JOIN detalleventa dv ON dv.fk_codVenta=v.cCodVenta
        INNER JOIN tipomoneda tm ON tm.idTipoMoneda=dv.fk_tipoMoneda
        INNER JOIN clase_realizar cr ON cr.fk_codVenta=v.cCodVenta
        INNER JOIN clientes p ON p.idCliente=v.fk_IdAlumno
        INNER JOIN campaniassmtk c ON c.idCampania=cr.fk_idCampania",
        "v.fk_IdAlumno='" . $_POST["idCliente"] . "' AND v.cCodVenta='" . $_POST["CodVenta"] . "'
        GROUP BY p.idCliente"
    );
    $busqCursosXventa = $busq->buscarGeneral(
        "DISTINCT v.cCodVenta,CONCAT(doc.Nombes,doc.Apellidos) docente,c.cNombreCortoCurso,tc.cNomTab,tc.cCodTab,cr.fechaInicio,cr.fechaFinal",
        "detalle_evento de
        INNER JOIN eventos_venta ev ON ev.codEvento=de.cCodEvento
        left JOIN docentes doc ON doc.idDocente=ev.fk_idDocente
        INNER JOIN tablacod tc ON tc.cCodTab=ev.cCodModalidad
        INNER JOIN cursos_venta c ON c.idCursoV=de.fk_idCurso
        INNER JOIN clase_realizar cr ON cr.fk_idEventoVenta=de.idDetalleEvento
        INNER JOIN venta v ON v.cCodVenta =cr.fk_codVenta",
        "v.cCodVenta='" .  $_POST["CodVenta"] . "'"
    );

    while ($row0 = mysqli_fetch_array($busqCursosXventa)) {
        $cursosXventa[] = array(
            'nombreCurso' => $row0['cNombreCortoCurso'],
            'codModalidadCurso' => $row0['cCodTab'],
            'modalidadCurso' => $row0['cNomTab'],
            'nombreDocente' => $row0['docente'],
            'fechaInicioAlumno' => strftime("%d de %B del %Y", strtotime($row0['fechaInicio'])),
            'fechaFinalAlumno' => strftime("%d de %B del %Y", strtotime($row0['fechaFinal'])),
        );
    }

    while ($row = mysqli_fetch_array($buscCliente)) {
        $countCuotas = $busq->buscarGeneral(
            "pc.idPagoCuotas,pc.CodCuota,pc.fk_Venta,pc.fechaRegistroPC,pc.fechaPagoPC,pc.fechaVencimientoPC,pc.estadoPagoPC,tc.cNomTab,dp.importeCuotaDP,dv.importeTotal",
            "pago_cuotas pc
            LEFT JOIN detallepagos dp ON pc.idPagoCuotas=dp.fk_idPagoCuotas
            INNER JOIN venta v ON v.idVenta=pc.fk_Venta   
            INNER JOIN detalleventa dv ON dv.fk_codVenta=v.cCodVenta    
            INNER JOIN tablacod tc ON tc.cCodTab=pc.estadoPagoPC",
            "v.fk_IdAlumno='" . $_POST["idCliente"] . "' AND v.cCodVenta='" . $row["cCodVenta"] . "'"
        );
        while ($row2 = mysqli_fetch_array($countCuotas)) {
            if($row2['estadoPagoPC']=="ESTC0001"){
                $calcImporteRestual=$row2['importeCuotaDP'];
            }

            $DatosCuota[]=array(
                'idCuota' => $row2['idPagoCuotas'],
                'CodCuota' => $row2['CodCuota'],
                'fechaVenta' => strftime("%d de %B del %Y", strtotime($row2['fechaRegistroPC'])),
                'fechaPago' => strftime("%d de %B del %Y", strtotime($row2['fechaPagoPC'])),
                'fechaVencimiento' => strftime("%d de %B del %Y", strtotime($row2['fechaVencimientoPC'])),
                'importeCuota' =>$row["SimboloMoneda"]." ".number_format($row2['importeCuotaDP']=$row2['estadoPagoPC']=="ESTC0001"?$row2['importeCuotaDP']:($row2['importeTotal']-$calcImporteRestual), 2),
                'estadoPago' => $row2['estadoPagoPC'],
                'cNomEstadoPago' => mb_convert_case($row2['cNomTab'], MB_CASE_TITLE, "UTF-8"),
            );
            
        }

        $ClientesVenta[] = array(
            'idCliente' => $row['idProspecto'],
            'campania' => $row['cNombreCampania'],
            'idVenta' => $row['idVenta'],
            'codVenta' => $row['cCodVenta'],
            'totalVenta' =>$row["SimboloMoneda"]." ".number_format($row['importeTotal'],2),
            'nombres' => mb_convert_case($row['nombresCliente'], MB_CASE_TITLE, "UTF-8"),
            'apellios' => mb_convert_case($row['apellidosCliente'], MB_CASE_TITLE, "UTF-8"),
            'email' => $row['correoCliente'],
            'cursos' => $cursosXventa,
            'telefono' => $row['telefonoCliente'],            
            'fechaVentaGeneral' => strftime("%d de %B del %Y", strtotime($row['fecha_registroV'])),
            'DatosCuota' => $DatosCuota,
            'DatosCursos' => $cursosXventa

        );

        
    }
    echo json_encode($ClientesVenta);
}

// codigo para ver los detalles de las cuotas  y tambien para pagar las cuotas
if (isset($_POST["tipoBusqueda"]) && isset($_POST["idCuota"])) {
    if ($_POST["tipoBusqueda"] == "DetallePago") {
        $buscPagoCuotas = $busq->buscarGeneral(
            "dp.idPagoDP,c.cNombreCampania,v.cCodVenta,v.fecha_registroV,dv.importeTotal,pc.idPagoCuotas,pc.CodCuota,dp.fecha_registroDP,dp.importeCuotaDP,tp.cNombreTipoPago,ep.cNombreEntidadPago,dp.boucherPagoDP,dp.boucherBlobDP,dp.tipoImagen",
            "pago_cuotas pc 
            INNER JOIN venta v ON v.idVenta=pc.fk_Venta
            INNER JOIN detalleventa dv ON dv.fk_codVenta=v.cCodVenta
            INNER JOIN clase_realizar cr ON cr.fk_codVenta=v.cCodVenta
            INNER JOIN campaniassmtk c ON c.idCampania=cr.fk_idCampania
            INNER JOIN detallepagos dp ON dp.fk_idPagoCuotas=pc.idPagoCuotas
            INNER JOIN entidadespago ep ON ep.idEntidadPago= dp.fk_idEntidadPago
            INNER JOIN tipopagos tp ON tp.idTipoPago=ep.ID_TIPO_PAGO",
            "pc.idPagoCuotas='" . $_POST["idCuota"] . "'"
        );

        while ($row = mysqli_fetch_array($buscPagoCuotas)) {
            $PagoCuotas[] = array(
                'idDetallePago' => $row['idPagoDP'],
                'nomCampania' => $row['cNombreCampania'],
                'codVenta' => $row['cCodVenta'],
                'fechaVenta' => strftime("%d de %B del %Y", strtotime($row['fecha_registroV'])),
                'importeTotal' => number_format($row['importeTotal'], 1),
                'CodCuota' => $row['CodCuota'],
                'fechaPago' => strftime("%d de %B del %Y", strtotime($row['fecha_registroDP'])),
                'importeCuota' => number_format($row['importeCuotaDP'], 1),
                'tipoPago' => mb_convert_case($row['cNombreTipoPago'], MB_CASE_TITLE, "UTF-8"),
                'entidadPago' => $row['cNombreEntidadPago'],
                'tipoImagen' => $row['tipoImagen'],
                // 'imgBoucher' => base64_encode($row['boucherBlobDP']),
                'imgBoucher' => $row['boucherPagoDP']
            );
        }
        
    } elseif ($_POST["tipoBusqueda"] == "PagarCuota") {
        $buscPagoCuotas = $busq->buscarGeneral(
            "c.cNombreCampania,v.fk_IdAlumno,v.cCodVenta,v.fecha_registroV,tm.idTipoMoneda,tm.SimboloMoneda,dv.importeTotal,dv.importerestual,dv.numeroCuotas,pc.idPagoCuotas,pc.CodCuota,pc.fechaPagoPC",
            "pago_cuotas pc 
            INNER JOIN venta v ON v.idVenta=pc.fk_Venta
            INNER JOIN detalleventa dv ON dv.fk_codVenta=v.cCodVenta
            INNER JOIN tipomoneda tm ON tm.idTipoMoneda=dv.fk_tipoMoneda
            INNER JOIN clase_realizar cr ON cr.fk_codVenta=v.cCodVenta
            INNER JOIN campaniassmtk c ON c.idCampania=cr.fk_idCampania",
            "pc.idPagoCuotas='" . $_POST["idCuota"] . "'
            AND pc.estadoPagoPC='ESTC0002'"
        );

        while ($row = mysqli_fetch_array($buscPagoCuotas)) {
            $busqCuotasPagadas = $busq->buscarContador(
                "COUNT(*) cuotasPagadas",
                "pago_cuotas pc
                INNER JOIN venta v ON v.idventa=pc.fk_Venta",
                "v.cCodVenta='" . $row["cCodVenta"] . "' 
                AND v.fk_IdAlumno='" . $row["fk_IdAlumno"] . "'
                AND pc.estadoPagoPC='ESTC0001'"
            );

            $rowCuentasPagadas = mysqli_fetch_array($busqCuotasPagadas);
            $PagoCuotas[] = array(
                'idCliente' => $row['fk_IdAlumno'],
                'nomCampania' => $row['cNombreCampania'],
                'codVenta' => $row['cCodVenta'],
                'fechaVenta' => strftime("%d de %B del %Y", strtotime($row['fecha_registroV'])),
                'simboloMoneda' => $row['SimboloMoneda'],
                'idTipoMoneda' => $row['idTipoMoneda'],
                'importeTotal' => number_format($row['importeTotal'], 2),
                'imporRestante' => number_format($row['importerestual'], 2),
                'totalCuotas' => $row['numeroCuotas'],
                'totalCuotasPagadas' => $rowCuentasPagadas["cuotasPagadas"],
                'idCuota' => $row['idPagoCuotas'],
                'CodCuota' => $row['CodCuota'],
                'fechaPago' => date("Y-m-d", strtotime($row['fechaPagoPC']))
            );
        }
    }
    echo json_encode($PagoCuotas);
}
