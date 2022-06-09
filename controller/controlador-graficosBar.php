<?php
include("../model/conexion.php");
$busq = new ApptivaDB();
if (isset($_POST["vacio"])) {
    $consulta = $busq->buscarFech(
        "c.nombreCorto,COUNT(cp.ID_PROSPECTO) AS TOTAL",
        "cursos_prospecto cp
                                INNER join prospectos p ON cp.ID_PROSPECTO=p.idProspecto
                                INNER JOIN cursos c ON cp.ID_CURSO=c.idCursos
                                INNER JOIN campania ca ON cp.ID_CAMPANIA=ca.idCampania",
        "cp.ID_CAMPANIA='2'  
                                GROUP by c.nombreCorto"
    );
    while ($row = mysqli_fetch_array($consulta)) {
        $json[] = array(
            'fecha' => $row['nombreCorto'],
            'cantidad' => $row['TOTAL'],
            'tipoGrafica' =>  "Prospectos por cursos"
        );
    }
} else {
    $fechaInicio = $_POST["fechaIni"];
    $fechaFinal = $_POST["fechaFin"];
    $tipoConsulta = $_POST["itemDashboard"];
    $idCampania = $_POST["cboIdCampania"];
    $idCurso = $_POST["cboIdCurso"];
    $consulta = "";
    $json = array();
    $mensaje = [];

    setlocale(LC_ALL, "es_ES.UTF-8", "es_ES", "es");

    $ZonaHoraria = date_default_timezone_set('America/lima');
    $fecha_actual = date("Y-m-d");

    if ($tipoConsulta == "totalProspectos") {
        $consulta = $busq->buscarFech(
            "DATE(cp.fecha_registro) AS FECHA,COUNT(cp.ID_PROSPECTO) TOTAL",
            "cursos_prospecto cp
            INNER join prospectos p ON cp.ID_PROSPECTO=p.idProspecto
            INNER JOIN cursos c ON cp.ID_CURSO=c.idCursos
            INNER JOIN campania ca ON cp.ID_CAMPANIA=ca.idCampania",
            "('".$idCampania."'='0' OR cp.ID_CAMPANIA='" . $idCampania . "')
            AND('" . $idCurso . "'='0' OR c.idCursos='" . $idCurso . "')
            AND (('" . $fechaInicio . "'='' OR '" . $fechaFinal . "'='') OR (cp.fecha_registro BETWEEN '" . $fechaInicio . "' AND '" . $fechaFinal . "' ) )  
            GROUP BY DATE(cp.fecha_registro)
            ORDER BY DATE(cp.fecha_registro)"
        );
        while ($row = mysqli_fetch_array($consulta)) {
            $json[] = array(
                'fecha' => strftime("%d de %B del %Y", strtotime($row['FECHA'])),
                'cantidad' => $row['TOTAL'],
                'tipoGrafica' =>  "Numero de Prospectos"
            );
        }
    } elseif ($tipoConsulta == "prospectosSeguidos") {

        $consulta = $busq->buscarFech(
            "DATE(cp.fecha_registro) AS FECHA,COUNT(cp.ID_PROSPECTO) TOTAL",
            "cursos_prospecto cp
            INNER join prospectos p ON cp.ID_PROSPECTO=p.idProspecto
            INNER JOIN cursos c ON cp.ID_CURSO=c.idCursos
            INNER JOIN campania ca ON cp.ID_CAMPANIA=ca.idCampania",
            "('".$idCampania."'='0' OR cp.ID_CAMPANIA='" . $idCampania . "')
            AND('" . $idCurso . "'='0' OR c.idCursos='" . $idCurso . "')
            AND p.pros_estado_segimiento='1'
            AND (('" . $fechaInicio . "'='' OR '" . $fechaFinal . "'='') OR (cp.fecha_registro BETWEEN '" . $fechaInicio . "' AND '" . $fechaFinal . "' ) )  
            GROUP BY DATE(cp.fecha_registro)
            ORDER BY DATE(cp.fecha_registro)"
        );
        while ($row = mysqli_fetch_array($consulta)) {
            $json[] = array(
                'fecha' => strftime("%d de %B del %Y", strtotime($row['FECHA'])),
                'cantidad' => $row['TOTAL'],
                'tipoGrafica' =>  "Numero de Prospectos seguidos"
            );
        }
    } elseif ($tipoConsulta == "prospectosNoSeguidos") {
        $consulta = $busq->buscarFech(
            "DATE(cp.fecha_registro) AS FECHA,COUNT(cp.ID_PROSPECTO) TOTAL",
            "cursos_prospecto cp
            INNER join prospectos p ON cp.ID_PROSPECTO=p.idProspecto
            INNER JOIN cursos c ON cp.ID_CURSO=c.idCursos
            INNER JOIN campania ca ON cp.ID_CAMPANIA=ca.idCampania",
            "('".$idCampania."'='0' OR cp.ID_CAMPANIA='" . $idCampania . "')
            AND('" . $idCurso . "'='0' OR c.idCursos='" . $idCurso . "')
            AND p.pros_estado_segimiento='0'
            AND (('" . $fechaInicio . "'='' OR '" . $fechaFinal . "'='') OR (cp.fecha_registro BETWEEN '" . $fechaInicio . "' AND '" . $fechaFinal . "' ) )  
            GROUP BY DATE(cp.fecha_registro)
            ORDER BY DATE(cp.fecha_registro)"
        );
        while ($row = mysqli_fetch_array($consulta)) {
            $json[] = array(
                'fecha' => strftime("%d de %B del %Y", strtotime($row['FECHA'])),
                'cantidad' => $row['TOTAL'],
                'tipoGrafica' =>  "Numero de Prospectos no seguidos"
            );
        }
    }else if($tipoConsulta == "totalVentas"){
        $consulta = $busq->buscarFech(
            "DATE(cr.fechaRegistro) fecha,SUM(dv.importeTotal) TOTAL",
            "clase_realizar cr 
            INNER JOIN venta v ON v.cCodVenta=cr.fk_codVenta
            INNER JOIN detalleventa dv ON dv.fk_codVenta=v.cCodVenta",
            "('".$idCampania."'='0' OR cr.fk_idCampania='" . $idCampania . "')
            AND (('" . $fechaInicio . "'='' OR '" . $fechaFinal . "'='') OR (DATE(cr.fechaRegistro) BETWEEN '" . $fechaInicio . "' AND '" . $fechaFinal . "' ))  
            GROUP BY MONTHNAME(cr.fechaRegistro)"
        );
        while ($row = mysqli_fetch_array($consulta)) {
            $json[] = array(
                'fecha' => $busq->fnConvertirFechas($busq->fnObtenePrmtFecha($row["fecha"],"m"))." del ".$busq->fnObtenePrmtFecha($row["fecha"],"y"),
                'cantidad' => $row['TOTAL'],
                'tipoGrafica' =>  "Grafico de ventas"
            );
        }
    }
}
echo json_encode($json);
