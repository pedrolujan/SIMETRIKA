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
                        "c.nombreCorto,cp.fecha_registro,COUNT(cp.ID_PROSPECTO) AS TOTAL",
                        "cursos_prospecto cp
                                INNER join prospectos p ON cp.ID_PROSPECTO=p.idProspecto
                                INNER JOIN cursos c ON cp.ID_CURSO=c.idCursos
                                INNER JOIN campania ca ON cp.ID_CAMPANIA=ca.idCampania",
                        "('" . $idCampania . "'='0' OR cp.ID_CAMPANIA='" . $idCampania . "')
                                AND('" . $idCurso . "'='0' OR c.idCursos='" . $idCurso . "')
                                AND (('" . $fechaInicio . "'='' OR '" . $fechaFinal . "'='') OR (cp.fecha_registro BETWEEN '" . $fechaInicio . "' AND '" . $fechaFinal . "' ) )  
                                GROUP by c.nombreCorto"
                );
                while ($row = mysqli_fetch_array($consulta)) {
                        $json[] = array(
                                'nombreCruso' => $row['nombreCorto'],
                                'cantidad' => $row['TOTAL'],
                                'tipoGrafica' =>  "Prospectos por cursos"
                        );
                }
        } elseif ($tipoConsulta == "prospectosSeguidos") {

                $consulta = $busq->buscarFech(
                        "c.nombreCorto,cp.fecha_registro,COUNT(cp.ID_PROSPECTO) AS TOTAL",
                        "cursos_prospecto cp
                                INNER join prospectos p ON cp.ID_PROSPECTO=p.idProspecto
                                INNER JOIN cursos c ON cp.ID_CURSO=c.idCursos
                                INNER JOIN campania ca ON cp.ID_CAMPANIA=ca.idCampania",
                        "('" . $idCampania . "'='0' OR cp.ID_CAMPANIA='" . $idCampania . "')
                                AND('" . $idCurso . "'='0' OR c.idCursos='" . $idCurso . "')
                                AND p.pros_estado_segimiento='1'
                                AND (('" . $fechaInicio . "'='' OR '" . $fechaFinal . "'='') OR (cp.fecha_registro BETWEEN '" . $fechaInicio . "' AND '" . $fechaFinal . "' ) )  
                                GROUP by c.nombreCorto"
                );
                while ($row = mysqli_fetch_array($consulta)) {
                        $json[] = array(
                                'nombreCruso' => $row['nombreCorto'],
                                'cantidad' => $row['TOTAL'],
                                'tipoGrafica' =>  "Prospectos por cursos"
                        );
                }
        } elseif ($tipoConsulta == "prospectosNoSeguidos") {

                $consulta = $busq->buscarFech(
                        "c.nombreCorto,cp.fecha_registro,COUNT(cp.ID_PROSPECTO) AS TOTAL",
                        "cursos_prospecto cp
                                INNER join prospectos p ON cp.ID_PROSPECTO=p.idProspecto
                                INNER JOIN cursos c ON cp.ID_CURSO=c.idCursos
                                INNER JOIN campania ca ON cp.ID_CAMPANIA=ca.idCampania",
                        "('" . $idCampania . "'='0' OR cp.ID_CAMPANIA='" . $idCampania . "')
                                AND('" . $idCurso . "'='0' OR c.idCursos='" . $idCurso . "')
                                AND p.pros_estado_segimiento='0'
                                AND (('" . $fechaInicio . "'='' OR '" . $fechaFinal . "'='') OR (cp.fecha_registro BETWEEN '" . $fechaInicio . "' AND '" . $fechaFinal . "' ) )  
                                GROUP by c.nombreCorto"
                );
                while ($row = mysqli_fetch_array($consulta)) {
                        $json[] = array(
                                'nombreCruso' => $row['nombreCorto'],
                                'cantidad' => $row['TOTAL'],
                                'tipoGrafica' =>  "Prospectos por cursos"
                        );
                }
        } else if ($tipoConsulta == "totalVentas") {
                $consulta = $busq->buscarFech(
                        "cv.cNombreCortoCurso,COUNT(*) numAlumnos",
                        "venta v
                        INNER JOIN clientes cl ON cl.codCliente=v.fk_codAlumno
                        INNER JOIN clase_realizar cr ON cr.fk_codVenta=v.cCodVenta
                        INNER JOIN eventos_venta ev ON ev.idEvento=cr.fk_idEventoVenta
                        INNER JOIN detalle_evento de ON de.cCodEvento=ev.codEvento
                        INNER JOIN cursos_venta cv ON cv.idCursoV=de.fk_idCurso",
                        "('" . $idCampania . "'='0' OR cr.fk_idCampania='" . $idCampania . "')
                        AND (('" . $fechaInicio . "'='' OR '" . $fechaFinal . "'='') OR (DATE(cr.fechaRegistro) BETWEEN '" . $fechaInicio . "' AND '" . $fechaFinal . "' ))  
                        GROUP BY cv.idCursoV"
                );

                while ($row = mysqli_fetch_array($consulta)) {
                        $json[] = array(
                                'nombreCruso' => $row['cNombreCortoCurso'],
                                'cantidad' => $row['numAlumnos'],
                                'tipoGrafica' =>  "Cursos con alumnos"
                        );
                }
                // $resultado = $busq->EjecutarProcedimientosAlmacenados("sp_ListarCursosConMayorAlumnado", "");

                // foreach ($resultado as $row) {
                //         $json[] = array(
                //                 'nombreCruso' => $row['cNombreCortoCurso'],
                //                 'cantidad' => $row['numAlumnos'],
                //                 'tipoGrafica' =>  "Cursos con alumnos"

                //         );
                // }
        }
}
echo json_encode($json);
