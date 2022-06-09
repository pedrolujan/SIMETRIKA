<?php
// error_reporting(0);
// return print_r($_POST);
session_start();

include("../model/conexion.php");
$con = new ApptivaDB();

$idPersonal = 0;
if (isset($_SESSION["asistenteLogeado"])) {
    $idPersonal = $_SESSION["asistenteLogeado"];
} else if (isset($_SESSION["supervisorLogeado"])) {
    $idPersonal = $_SESSION["supervisorLogeado"];
} else {
    $idPersonal = $_SESSION["adminLogeado"];
}

$IdCampania = $_POST["CboCampania_NV"];
$IdModalidad = $_POST["CboModalidad_NV"];
$IdEstado = $_POST["CboEstado_NV"];
$idDocente = $_POST["CboDocente_NV"];
$Descripcion = $_POST["txtDescripcion"];
$fecha_in = $_POST["fecha_in_NV"];
$fecha_fin = $_POST["fecha_fin_NV"];
$CantidadCursos = $_POST["txtNumCursos"];
$importeMonLocal = $_POST["txtImporteMonLocal"];
$importeMonCambio = $_POST["txtImporteMonCambio"];
$valuesCursos = "";
$valuesTemplateCertificado = "";
$ZonaHoraria = date_default_timezone_set('America/lima');
$fecha_actual = date("Y-m-d h:m:s");

// capturo los datos de los certificados
$certificadoFrontal = $_FILES["txtTemplateCertificadoFron"];
$name_Frontal = $certificadoFrontal["name"];
$tipoArchivo_Frontal = $certificadoFrontal["type"];
$temp_nameFrontal = $certificadoFrontal["tmp_name"];

$certificadoPosterior = $_FILES["txtTemplateCertificadoPost"];
$name_Posterior = $certificadoPosterior["name"];
$tipoArchivo_Posterior = $certificadoPosterior["type"];
$temp_namePosterior = $certificadoPosterior["tmp_name"];

$rutabdCertificadoFron="";
$rutabdCertificadoPost="";

// $fechaVencimiento= date("Y-m-d",strtotime($fecha_actual."+ 7 days"));

try {

    $buscarUltimoIdEvento = fnObtenerUltimoId($con, "idEvento", "eventos_venta");
    $registroCuotas = $con->insertar(
        "eventos_venta(codEvento,fk_idDocente,cCodModalidad,fk_idCampania,cDescripcion,fecha_registro,fecha_inicio,fecha_final,cEstadoEvento,importeMonedaLocal,importeMonedaCambio,idUsuario)",
        "(concat('EVT', LPAD($buscarUltimoIdEvento, 7, '0'))," . $idDocente . "," . $IdModalidad . ",'" . $IdCampania . "','" . $Descripcion . "','" . $fecha_actual . "','" . $fecha_in . "','" . $fecha_fin . "'," . $IdEstado . ",'" . $importeMonLocal . "','" . $importeMonCambio . "','" . $idPersonal . "')"
    );

    if ($registroCuotas) {
        $buscarIdEvento = $con->buscarFech(
            "idEvento,codEvento",
            "eventos_venta",
            "idEvento=$buscarUltimoIdEvento AND fk_idDocente=$idDocente AND cCodModalidad=$IdModalidad AND fk_idCampania=$IdCampania AND cDescripcion='$Descripcion' AND cEstadoEvento=$IdEstado AND importeMonedaLocal=$importeMonLocal AND importeMonedaCambio=$importeMonCambio"
        );
        if ($buscarIdEvento) {
            $respBusqIdEvento = mysqli_fetch_array($buscarIdEvento);
            $idEvento = $respBusqIdEvento["idEvento"];
            $codEvento = $respBusqIdEvento["codEvento"];

            for ($i = 0; $i < $CantidadCursos; $i++) {

                if ($i == $CantidadCursos - 1) {
                    // $idsCursos .= $_POST["checksBoxCursos" . $i];
                    $valuesCursos .= "('" . $idEvento . "','" . $codEvento . "','" . $_POST["checksBoxCursos" . $i] . "','" . $fecha_actual . "','" . $idPersonal . "')";
                } else {
                    // $idsCursos .= $_POST["checksBoxCursos" . $i] . ",";
                    $valuesCursos .= "('" . $idEvento . "','" . $codEvento . "','" . $_POST["checksBoxCursos" . $i] . "','" . $fecha_actual . "','" . $idPersonal . "'),";
                }
            }
            $UltimoIdDetalle = fnObtenerUltimoId($con, "idDetalleEvento", "detalle_evento");
            $registroCuotas = $con->insertar("detalle_evento(fk_idEvento,cCodEvento,fk_idCurso,dFechaRegistro,idUsuario)", $valuesCursos);
            if ($registroCuotas==true && $CantidadCursos==1) {
                $buscarIdDetEvento = $con->buscarFech(
                    "idDetalleEvento",
                    "detalle_evento",
                    "fk_idEvento=$idEvento AND cCodEvento='".$codEvento."'"
                );
                if ($buscarIdDetEvento) {
                    $respBusqIdEvento = mysqli_fetch_array($buscarIdDetEvento);
                    $idDetEvento = $respBusqIdEvento["idDetalleEvento"];

                    // creamos la carpeta donde se alojaran los certificados
                    $CrearCarpeta = "../IMAGENES/certificados/clase_" . $codEvento . "_" . $idDetEvento . "/";
                    if (!file_exists($CrearCarpeta)) {
                        mkdir($CrearCarpeta, 0777, true);
                    }
                    // imagen certificado frontal
                    $carpetaCertificadoFron = $CrearCarpeta . "Front_" . $codEvento . "_" . $idDetEvento . "_" . $name_Frontal;
                    $rutabdCertificadoFron = "IMAGENES/certificados/clase_" . $codEvento . "_" . $idDetEvento . "/Front_" . $codEvento . "_" . $idDetEvento . "_" . $name_Frontal;
                    // imagen certificado posterior
                    $carpetaCertificadoPost = $CrearCarpeta . "Post_" . $codEvento . "_" . $idDetEvento . "_" . $name_Posterior;
                    $rutabdCertificadoPost = "IMAGENES/certificados/clase_" . $codEvento . "_" . $idDetEvento . "/Post_" . $codEvento . "_" . $idDetEvento . "_" . $name_Posterior;



                    $registroCertificados = $con->insertar("templatecerificado(idDetalleEvento,disenioFrontal,disenioPosterior,idUsuario)",
                    "('".$idDetEvento."','".$rutabdCertificadoFron."','".$rutabdCertificadoPost."','". $idPersonal."')");
                    if($registroCertificados){
                        move_uploaded_file($temp_nameFrontal, $carpetaCertificadoFron);
                        move_uploaded_file($temp_namePosterior, $carpetaCertificadoPost);

                        $arregloMSG["ok"] = "Clase Registrada Correctamente";
                    }else{
                        $arregloMSG["error"] = "Ocurrio un Error en el Registro.";
                    }
                }else{
                    $arregloMSG["error"] = "Ocurrio un Error en el Registro.";
                }
                
            } else {
                
                for ($i = 0; $i < $CantidadCursos; $i++){
                    if ($i == $CantidadCursos - 1) {
                        // $idsCursos .= $_POST["checksBoxCursos" . $i];
                        $valuesTemplateCertificado .= "('" . ($UltimoIdDetalle+$i) . "','".$rutabdCertificadoFron."','".$rutabdCertificadoPost."','". $idPersonal."')";
                    } else {
                        // $idsCursos .= $_POST["checksBoxCursos" . $i] . ",";
                        $valuesTemplateCertificado .= "('" . ($UltimoIdDetalle+$i) . "','".$rutabdCertificadoFron."','".$rutabdCertificadoPost."','". $idPersonal."'),";
                    }
                    
                }
                $registroCertificados = $con->insertar("templatecerificado(idDetalleEvento,disenioFrontal,disenioPosterior,idUsuario)",$valuesTemplateCertificado);
                    if($registroCertificados){
                        $arregloMSG["ok"] = "Clase Registrada Correctamente";
                    }else{
                        $arregloMSG["error"] = "Ocurrio un Error en el Registro.";
                    }
            }
        }
    }
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}


echo json_encode($arregloMSG);



function fnObtenerUltimoId($con, $campo, $tabla)
{
    $cantRegistros = array();
    $buscar = "";
    /* consulta para buscar la cantidad de registros existentes en la tabla copras */
    $buscar = $con->buscarCar($campo, $tabla, "1");
    foreach ($buscar as $v) {
        $cantRegistros[] = $v[$campo];
    }
    /* si has menos de un registro a la variable le agrego uno si no le agrego el id maximo */
    if (count($cantRegistros) < 1) {
        return 1;
    } else {
        $buscar = $con->buscarCar("MAX($campo) as id", $tabla, "1");
        foreach ($buscar as $v) {
            return ($v["id"] + 1);
        }
    }
}
