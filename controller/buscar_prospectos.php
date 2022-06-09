
<?php
// sleep(1);
session_start();
include("../model/conexion.php");
include("../model/url.php");
$user = new ApptivaDB();

$html = "";
$u = "";
$cont = "";
$contador = "";



if (isset($_POST["idCampaniaGeneral"]) && isset($_POST["Habilitarfechas"])) {
    $u = $user->buscarFech(
        "p.idProspecto,p.pros_apellidos,p.pros_nombres,p.pros_email,p.pros_telefono,pa.Nombre_pais,c.nombreCorto ,p.tipoSeguimiento,p.pros_estado_segimiento",
        "prospectos p
        LEFT JOIN cursos_prospecto cp ON cp.ID_PROSPECTO=p.idProspecto
        LEFT JOIN campania ca On cp.ID_CAMPANIA=ca.idCampania
        LEFT JOIN campaniassmtk cg ON ca.ID_CAMPANIA=cg.idCampania
        LEFT JOIN cursos c ON c.idCursos=cp.ID_CURSO
        LEFT JOIN pais pa ON pa.Codigo=p.ID_PAIS",
        "(('" . $_POST["idCampaniaGeneral"] . "'=0) OR (cg.idCampania='" . $_POST["idCampaniaGeneral"] . "'))
        AND (('" . $_POST['idCampania'] . "'=0) OR (cp.ID_CAMPANIA='" . $_POST['idCampania'] . "'))
        AND (('" . $_POST['idCurso'] . "'=0) OR (cp.ID_CURSO='" . $_POST['idCurso'] . "'))
        AND (('" . $_POST["Habilitarfechas"] . "'=0) OR (cp.fecha_registro BETWEEN'" . $fechaInicio . "' AND '" . $fechaFinal . "'))
        AND p.pros_estado='1'
         AND(('" . $_POST["idPersonal"]  . "'=0) OR (p.idUsuario='" . $_POST["idPersonal"] . "'))"
    );

    $cont = $user->buscarContador(
        "COUNT(*) cantidad",
        "prospectos p
        LEFT JOIN cursos_prospecto cp ON cp.ID_PROSPECTO=p.idProspecto
        LEFT JOIN campania ca On cp.ID_CAMPANIA=ca.idCampania
        LEFT JOIN campaniassmtk cg ON ca.ID_CAMPANIA=cg.idCampania
        LEFT JOIN cursos c ON c.idCursos=cp.ID_CURSO
        LEFT JOIN pais pa ON pa.Codigo=p.ID_PAIS",
        "(('" . $_POST["idCampaniaGeneral"] . "'='0') OR (cg.idCampania='" . $_POST["idCampaniaGeneral"] . "'))
        AND (('" . $_POST['idCampania'] . "'='0') OR (cp.ID_CAMPANIA='" . $_POST['idCampania'] . "'))
        AND (('" . $_POST['idCurso'] . "'='0') OR (cp.ID_CURSO='" . $_POST['idCurso'] . "'))
        AND (('" . $_POST["Habilitarfechas"] . "'='0') OR (cp.fecha_registro BETWEEN'" . $fechaInicio . "' AND '" . $fechaFinal . "'))
        AND p.pros_estado='1'
         AND(('" . $_POST["idPersonal"] . "'='0') OR (p.idUsuario='" . $_POST["idPersonal"] . "'))"
    );
    // } else {
    //     $u = $user->buscarFech(
    //         "p.idProspecto,p.pros_apellidos,p.pros_nombres,p.pros_email,p.pros_telefono,pa.Nombre_pais,p.pros_edad nombreCorto,p.tipoSeguimiento,p.pros_estado_segimiento",
    //         "prospectos p
    //         INNER JOIN pais pa ON p.ID_PAIS=pa.Codigo",
    //         "(('" . $_POST["Habilitarfechas"] . "'='0') OR (p.fechaRegistro BETWEEN'" . $fechaInicio . "' AND '" . $fechaFinal . "'))
    //         AND p.pros_estado='1'
    //          AND(('" . $Usuario . "'='0') OR (p.idUsuario='" . $Usuario . "'))"
    //     );

    //     $cont = $user->buscarContador(
    //         "COUNT(*) cantidad",
    //         "prospectos p
    //         INNER JOIN pais pa ON p.ID_PAIS=pa.Codigo",
    //         "(('" . $_POST["Habilitarfechas"] . "'='0') OR (p.fechaRegistro BETWEEN'" . $fechaInicio . "' AND '" . $fechaFinal . "'))
    //         AND p.pros_estado='1'
    //          AND(('" . $Usuario . "'='0') OR (p.idUsuario='" . $Usuario . "'))"
    //     );
    // }


    $contador = mysqli_fetch_array($cont);
    $prospectos = array();
    $primerNombreArray = "";
    $primerNombre = "";
    while ($row = mysqli_fetch_array($u)) {
        if ($row["pros_estado_segimiento"] == '1' && $row["tipoSeguimiento"] == 'mensaje') {
            $estado = "<i class='icon-bubbles' style='color: green; font-size: 25px text-align: center;'></i>";
        } else if ($row["pros_estado_segimiento"] == '1' && $row["tipoSeguimiento"] == 'llamada') {
            $estado = "<i class='icon-phone' style='color: green; font-size: 25px; text-align: center;'></i>";
        } else {
            $estado = "<i class='icon-notification' style='color: brown;'></i>";
        }
        $primerNombreArray = explode(" ", $apellidos);
        $primerNombre = $primerNombreArray[0];

        $prospectos[] = array(
            'id' => $row['idProspecto'],
            'nombre' => mb_convert_case($row["pros_apellidos"] . ' ' . $row["pros_nombres"], MB_CASE_TITLE, "UTF-8"),
            'email' => $row["pros_email"],
            'telefono' => $row['pros_telefono'],
            'pais' => mb_convert_case($row['Nombre_pais'], MB_CASE_TITLE, "UTF-8"),
            'curso' => mb_convert_case($row['nombreCorto'], MB_CASE_TITLE, "UTF-8"),
            'estado' => $estado,
            'numeroRegistros' => $contador
        );
    }
    echo json_encode($prospectos);
}
if (isset($_POST["idProspecto"]) && isset($_POST["idPersonal"]) && !isset($_POST["BuscarParaSeguimineto"])) {
    $seg = $user->buscarFech(
        "s.fecha_registro,s.tipoSeguimiento,s.descripcionSeguimiento",
        "seguimiento s",
        "ID_PROSPECTO='" . $_POST["idProspecto"] . "'
         AND ID_USUARIO_PERSONAL='" . $_POST["idPersonal"] . "'"
    );
    while ($row = mysqli_fetch_array($seg)) {
        $segimiento[] = array(
            'fecha' => strftime("%d de %B del %Y", strtotime($row['fecha_registro'])),
            'accion' => mb_convert_case($row["tipoSeguimiento"], MB_CASE_TITLE, "UTF-8"),
            'descripcion' => mb_convert_case($row["descripcionSeguimiento"], MB_CASE_TITLE, "UTF-8")

        );
    }
    echo json_encode($segimiento);
} 
if (isset($_POST["BuscarParaSeguimineto"])) {
    $Prospecto = $user->buscarFech(
        "p.pros_nombres,p.pros_apellidos,p.pros_email,p.pros_telefono,pa.Codigo,pa.Nombre_pais",
        "prospectos p
        LEFT JOIN pais pa on pa.Codigo=p.ID_PAIS",
        "p.idProspecto='" . $_POST["idProspecto"] . "'
         AND p.idUsuario='" . $_POST["idPersonal"] . "'"
    );
    while ($row = mysqli_fetch_array($Prospecto)) {
        $prospectoss[] = array(
            'nombres' => mb_convert_case($row["pros_nombres"], MB_CASE_TITLE, "UTF-8"),
            'apellidos' => mb_convert_case($row["pros_apellidos"], MB_CASE_TITLE, "UTF-8"),
            'Correo' => $row["pros_email"],
            'telefono' => $row["pros_telefono"]==""?"000000000":$row["pros_telefono"],
            'codPais' => $row["Codigo"]??"FALTA",
            'pais' => mb_convert_case($row["Nombre_pais"]??"SIn Especificar", MB_CASE_TITLE, "UTF-8")

        );
    }
    echo json_encode($prospectoss);
   
} 





/*   return print_r($developer_records); */
/*  $_SESSION["ExportarTodo"] = $ExportarTodos;
    $_SESSION["ExportarSendinBlue"] = $ExportarSendinBlue;
    $_SESSION["ExportarContactos"] = $ExportarContactos; */

?>