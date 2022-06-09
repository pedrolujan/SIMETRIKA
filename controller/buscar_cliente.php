<!-- <link rel="stylesheet" href="css/estilos_principal.css"> -->
<?php
sleep(1);
session_start();
include("../model/conexion.php");
include("../model/url.php");
$user = new ApptivaDB();

$html = "";
if ($_POST['idCampania'] != 0 && isset($_SESSION["asistenteLogeado"])) {
    $u = $user->buscarFech(
        "*",
        "cursos_prospecto cp
        INNER JOIN cursos c ON cp.ID_CURSO=c.idCursos
        INNER JOIN prospectos p ON cp.ID_PROSPECTO=p.idProspecto
        INNER JOIN campania ca On cp.ID_CAMPANIA=ca.idCampania
        INNER JOIN pais pa ON p.ID_PAIS=pa.Codigo",
        "cp.ID_CAMPANIA='" . $_POST['idCampania'] . "'
        AND p.pros_estado='1'
        AND cp.idUsuario='".$_SESSION["asistenteLogeado"]."'"
    );

    $cont = $user->buscarContador(
        "COUNT(*) cantidad",
        "cursos_prospecto cp
        INNER JOIN cursos c ON cp.ID_CURSO=c.idCursos
        INNER JOIN prospectos p ON cp.ID_PROSPECTO=p.idProspecto
        INNER JOIN campania ca On cp.ID_CAMPANIA=ca.idCampania
        INNER JOIN pais pa ON p.ID_PAIS=pa.Codigo",
        "cp.ID_CAMPANIA='" . $_POST['idCampania'] . "'
        AND p.pros_estado='1'
        AND cp.idUsuario='".$_SESSION["asistenteLogeado"]."'"
    );
}
if ($_POST['idCampania'] != 0 && $_POST['idCurso'] != 0 && isset($_SESSION["asistenteLogeado"])) {
    $u = $user->buscarFech(
        "*",
        "cursos_prospecto cp
        INNER JOIN cursos c ON cp.ID_CURSO=c.idCursos
        INNER JOIN prospectos p ON cp.ID_PROSPECTO=p.idProspecto
        INNER JOIN campania ca On cp.ID_CAMPANIA=ca.idCampania
        INNER JOIN pais pa ON p.ID_PAIS=pa.Codigo",
        "cp.ID_CAMPANIA='" . $_POST['idCampania'] . "'
        AND cp.ID_CURSO='" . $_POST['idCurso'] . "'
        AND p.pros_estado='1'
         AND cp.idUsuario='".$_SESSION["asistenteLogeado"]."'"
    );

    $cont = $user->buscarContador(
        "COUNT(*) cantidad",
        "cursos_prospecto cp
    INNER JOIN cursos c ON cp.ID_CURSO=c.idCursos
    INNER JOIN prospectos p ON cp.ID_PROSPECTO=p.idProspecto
    INNER JOIN campania ca On cp.ID_CAMPANIA=ca.idCampania
    INNER JOIN pais pa ON p.ID_PAIS=pa.Codigo",
        "cp.ID_CAMPANIA='" . $_POST['idCampania'] . "'
        AND cp.ID_CURSO='" . $_POST['idCurso'] . "'
        AND p.pros_estado='1'
         AND cp.idUsuario='".$_SESSION["asistenteLogeado"]."'"
    );
}
if ($_POST['idCampania'] != 0 && $_POST['idCurso'] != 0 && $_POST['fechaInicio'] != "" && $_POST['fechaFinal'] != "" && isset($_SESSION["asistenteLogeado"])) {
    $fechaInicio = $_POST['fechaInicio'];
    $fechaFinal = $_POST['fechaFinal'];

    $u = $user->buscarFech(
        "*",
        "cursos_prospecto cp
        INNER JOIN cursos c ON cp.ID_CURSO=c.idCursos
        INNER JOIN prospectos p ON cp.ID_PROSPECTO=p.idProspecto
        INNER JOIN campania ca On cp.ID_CAMPANIA=ca.idCampania
        INNER JOIN pais pa ON p.ID_PAIS=pa.Codigo",
        "cp.ID_CAMPANIA='" . $_POST['idCampania'] . "'
        AND cp.ID_CURSO='" . $_POST['idCurso'] . "'
        AND cp.fecha_registro BETWEEN'" . $fechaInicio . "'
        AND '" . $fechaFinal . "'
        AND p.pros_estado='1'
         AND cp.idUsuario='".$_SESSION["asistenteLogeado"]."'"
    );

    $cont = $user->buscarContador(
        "COUNT(*) cantidad",
        "cursos_prospecto cp
        INNER JOIN cursos c ON cp.ID_CURSO=c.idCursos
        INNER JOIN prospectos p ON cp.ID_PROSPECTO=p.idProspecto
        INNER JOIN campania ca On cp.ID_CAMPANIA=ca.idCampania
        INNER JOIN pais pa ON p.ID_PAIS=pa.Codigo",
        "cp.ID_CAMPANIA='" . $_POST['idCampania'] . "'
        AND cp.ID_CURSO='" . $_POST['idCurso'] . "'
        AND cp.fecha_registro BETWEEN'" . $fechaInicio . "'
        AND '" . $fechaFinal . "'
        AND p.pros_estado='1'
         AND cp.idUsuario='".$_SESSION["asistenteLogeado"]."'"
    );
}
if ($_POST['idCampania'] == 0 && $_POST['idCurso'] == 0 && $_POST['fechaInicio'] == "" && $_POST['fechaFinal'] == "" && isset($_SESSION["asistenteLogeado"])) {
    $u = $user->buscarFech(
        "*",
        "cursos_prospecto cp
        INNER JOIN cursos c ON cp.ID_CURSO=c.idCursos
        INNER JOIN prospectos p ON cp.ID_PROSPECTO=p.idProspecto
        INNER JOIN campania ca On cp.ID_CAMPANIA=ca.idCampania
        INNER JOIN pais pa ON p.ID_PAIS=pa.Codigo",
        "p.pros_estado='1'
         AND cp.idUsuario='".$_SESSION["asistenteLogeado"]."'"
    );

    $cont = $user->buscarContador(
        "COUNT(*) cantidad",
        "cursos_prospecto cp
        INNER JOIN cursos c ON cp.ID_CURSO=c.idCursos
        INNER JOIN prospectos p ON cp.ID_PROSPECTO=p.idProspecto
        INNER JOIN campania ca On cp.ID_CAMPANIA=ca.idCampania
        INNER JOIN pais pa ON p.ID_PAIS=pa.Codigo",
        "p.pros_estado='1'
         AND cp.idUsuario='".$_SESSION["asistenteLogeado"]."'"
    );
}
if (!isset($_SESSION["asistenteLogeado"])) {
    $u = $user->buscarFech(
        "p.idProspecto,p.pros_apellido_paterno,p.pros_apellido_materno,p.pros_nombres,p.pros_email,p.pros_telefono,pa.Nombre_pais,c.nombreCorto        
        ",
        "
    cursos_prospecto cp
        INNER JOIN cursos c ON cp.ID_CURSO=c.idCursos
        INNER JOIN prospectos p ON cp.ID_PROSPECTO=p.idProspecto
        INNER JOIN campania ca On cp.ID_CAMPANIA=ca.idCampania
        INNER JOIN pais pa ON p.ID_PAIS=pa.Codigo",
        "p.pros_estado='1'
        AND cp.ID_CAMPANIA='" . $_POST['idCampania'] . "'
        AND cp.ID_CURSO='" . $_POST['idCurso'] . "'
        GROUP BY p.pros_email
        "
    );

    $cont = $user->buscarContador(
        "COUNT(DISTINCT p.pros_email) cantidad",
        "cursos_prospecto cp
        INNER JOIN cursos c ON cp.ID_CURSO=c.idCursos
        INNER JOIN prospectos p ON cp.ID_PROSPECTO=p.idProspecto
        INNER JOIN campania ca On cp.ID_CAMPANIA=ca.idCampania
        INNER JOIN pais pa ON p.ID_PAIS=pa.Codigo",
        "p.pros_estado='1'
        AND cp.ID_CAMPANIA='" . $_POST['idCampania'] . "'
        AND cp.ID_CURSO='" . $_POST['idCurso'] . "'"
    );
}

$contador = mysqli_fetch_array($cont);
if (!$u) {
    $html .= "<p style='background: #D9534F; color: #fff; padding: 5px;'> No se encontraron datos </p>";
} else {
    $html .= "
    
    <div class='contenedorExportarDatos col-xs-12 col-sm-12 col-md-12 col-lg-12'>
        <h4> Exportar para</h4>   
        <form class='d-block col-xs-12 col-sm-12 col-md-12 col-lg-12 d-md-flex justify-content-center align-items-center' action='../../controller/descargar_datos.php' method='post'>
            <div class='d-block col-xs-12 col-sm-12 col-md-10 col-lg-10 d-md-flex justify-content-between align-items-center'>
                <label class='col-xs-12 col-sm-12 col-md-3 col-lg-3'><input type='radio' name='rbexportar' id='rbCompleto' value='completo' checked>Exel (completo)<img src='" . $urlProyecto . "IMAGENES/todo.png' alt='' srcset=''></label>
                <label class='col-xs-12 col-sm-12 col-md-3 col-lg-3'><input type='radio' name='rbexportar' id='rbSendinBlue' value='Sendinblue'>Sendinblue<img src='" . $urlProyecto . "IMAGENES/sendinblue.png' alt='' srcset=''> </label>
                <label class=' col-xs-12 col-sm-12 col-md-3 col-lg-3'><input type='radio' name='rbexportar' id='rbContactos' value='Contactos'>Contactos <img src='" . $urlProyecto . "IMAGENES/googleContact.png' alt='' srcset=''> </label>
            </div>   
            <div class='mt-3 col-xs-12 col-sm-12 col-md-2 col-lg-2 d-flex justify-content-center align-items-center'>
                <button type='submit' id='export_data' name='export_data' value='Export to excel' class='btn btn-info col-xs-12 col-sm-12 col-md-12 col-lg-12'><img src='" . $urlProyecto . "IMAGENES/export_csv.png' alt=''>Exportar</button>
            </div>   
        </form>
    </div>
   <div class='contenedorContador' id='contenedorContador'>
        <div class'contTexto'>Registros</div>
        <div class='contador'>" . $contador['cantidad'] . "</div>
   </div>
    <table class='table table-striped table-hover table-responsive-md table-responsive-col col-xs-12 col-sm-12 col-md-12 col-lg-12' id='tabla' >
    <thead>
        <tr>
            <th>Cliente</th>          
            <th>Correo_electronico</th>
            <th>Telefono</th>          
            <th>Pais</th>
            <th>Curso</th>
            <th>Seguimiento</th>
               
        </tr>
    </thead>
    <tbody>";
    $estado = "<i class='icon-home'></i>";
    $ExportarTodos = array();
    $ExportarSendinBlue = array();
    $ExportarContactos = array();
    foreach ($u as $v) {

        $ExportarTodos[] = array(
            mb_convert_case($v["pros_nombres"], MB_CASE_TITLE, "UTF8"),
            mb_convert_case($v["pros_apellido_paterno"], MB_CASE_TITLE, "UTF8"),
            mb_convert_case($v["pros_apellido_materno"], MB_CASE_TITLE, "UTF8"),
            $v["pros_email"],
            $v["pros_telefono"],
            mb_convert_case($v["Nombre_pais"], MB_CASE_TITLE, "UTF8")
        );

        $ExportarSendinBlue[] = array(
            mb_convert_case($v["pros_nombres"], MB_CASE_TITLE, "UTF8"),
            mb_convert_case($v["pros_apellido_paterno"], MB_CASE_TITLE, "UTF8")." ".
            mb_convert_case($v["pros_apellido_materno"], MB_CASE_TITLE, "UTF8"),
            $v["pros_email"],
            $v["pros_telefono"]
        );

        $ExportarContactos[] = array(
            mb_convert_case($v["pros_nombres"], MB_CASE_TITLE, "UTF8"),
            mb_convert_case($v["pros_apellido_paterno"], MB_CASE_TITLE, "UTF8"),
            $v["pros_telefono"]
        );
    }


    foreach ($u as $v) {
        if ($v["pros_estado_segimiento"] == '1' && $v["tipoSeguimiento"] == 'mensaje') {
            $estado = "<i class='icon-bubbles' style='color: green; font-size: 25px text-align: center;'></i>";
        } else if ($v["pros_estado_segimiento"] == '1' && $v["tipoSeguimiento"] == 'llamada') {
            $estado = "<i class='icon-phone' style='color: green; font-size: 25px; text-align: center;'></i>";
        }else{
            $estado = "<i class='icon-notification' style='color: brown;'></i>";

        }

        $html .= "
        <a href='views/login'>
                <tr captId='" . $v['idProspecto'] . "' class='celProspecto' >
               
                <td>" . mb_convert_case($v["pros_apellido_paterno"] . ' ' . $v["pros_apellido_materno"] . ' ' . $v["pros_nombres"], MB_CASE_TITLE, "UTF-8") . "</td>
                    <td>" . $v["pros_email"] . "</td>
                    <td>" . $v["pros_telefono"] . "</td>
                    <td>" . mb_convert_case($v["Nombre_pais"], MB_CASE_TITLE, "UTF-8") . "</td>                  
                    <td>" . mb_convert_case($v["nombreCorto"], MB_CASE_TITLE, "UTF-8") . "</td>                  
                    <td style='text-align: center;'>" . $estado . "</td>                  
                </tr>
                </a>
                ";
    }
    $html .= "</tbody>
    </table>
   
    </form>
    </div>";
    /*   return print_r($developer_records); */
    $_SESSION["ExportarTodo"] = $ExportarTodos;
    $_SESSION["ExportarSendinBlue"] = $ExportarSendinBlue;
    $_SESSION["ExportarContactos"] = $ExportarContactos;
}
echo $html;

?>