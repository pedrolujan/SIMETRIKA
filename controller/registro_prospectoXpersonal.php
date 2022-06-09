<?php

// require_once('sendinblue_addContacts.php');
include "../model/conexion.php";

// include "../model/conexionPruebas.php";
$con = new ApptivaDB();
// $direccion = $_POST["txtEmail"];
session_start();
$idUsuario = 0;
if (isset($_SESSION["adminLogeado"])) {
    $idUsuario = $_SESSION["adminLogeado"];
} elseif (isset($_SESSION["asistenteLogeado"])) {
    $idUsuario = $_SESSION["asistenteLogeado"];
} elseif (isset($_SESSION["supervisorLogeado"])) {
    $idUsuario = $_SESSION["supervisorLogeado"];
}

$Correo = $_POST["txtEmail"];
$nombres = $_POST["txtnombres"];
$apellidos = $_POST["txtApellidos"];
$edad = $_POST["txtEdad"];
$cbopais = $_POST["CboPais"];
$telefono = $_POST["txtNumCelular"];
$codigoPais = $_POST["txtCodigoPais"];
// $direccion = $_POST["txtdireccion"];

$telefonoCodigo = $codigoPais . $telefono;

$date = date_default_timezone_set('America/lima');
$fecha_actual = date('Y-m-d H:i:s');;
$fecha = date("y-m-d");

$buscarExistencia = $con->buscarFech(
    "p.idProspecto",
    "prospectos p",
    "p.pros_email='" . $Correo . "'"
);

$existencia = mysqli_num_rows($buscarExistencia);


if ($existencia > 0) {
    $respuesta["error"] = "Este prospecto ya se encuentra registrado ⚠️";
   
} else {

    $buscarIdProspecto = fnObtenerUltimoId($con, "idProspecto", "prospectos");

    $resgPros = $con->insertar(
        "prospectos(pros_codigo,pros_nombres,pros_apellidos,pros_edad,pros_email,pros_telefono,ID_PAIS,pros_estado,fechaRegistro,idUsuario)",
        "(concat('PS', LPAD($buscarIdProspecto, 8, '0')),'$nombres','$apellidos','$edad','$Correo','$telefonoCodigo','$cbopais','1','$fecha_actual','$idUsuario')"
    );
    if ($resgPros) {

        $respuesta["ok"] = "Registro realizado correctamente ✅";
        // echo "okok";
    } else {
        $respuesta["error"] = "Error en el registro -> comunique al administrador ⚠️";
        // echo "error";
    }
}
echo json_encode($respuesta);

function fnObtenerUltimoId($con, $campo, $tabl)
{
    $cantRegistros = array();
    $buscar = "";
    /* consulta para buscar la cantidad de registros existentes en la tabla copras */
    $buscar = $con->buscarCar($campo, $tabl, "1");
    foreach ($buscar as $v) {
        $cantRegistros[] = $v[$campo];
    }
    /* si has menos de un registro a la variable le agrego uno si no le agrego el id maximo */
    if (count($cantRegistros) < 1) {
        return 1;
    } else {
        $buscar = $con->buscarCar("MAX($campo) as id", $tabl, "1");
        foreach ($buscar as $v) {
            return ($v["id"] + 1);
        }
    }
}
