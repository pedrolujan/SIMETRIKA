<?php

/* use function GuzzleHttp\Promise\each; */


require_once('sendinblue_addContacts.php');
include "../model/conexion.php";
$query = new ApptivaDB();
/* $CantidadPreguntas = $_POST["txtNumeroPreguntas"]; */
$Correo = $_POST["txtEmail"];
$ape_paterno = $_POST["txtApePaterno"];
$ape_materno = $_POST["txtApeMaterno"];
$nombres = $_POST["txtnombres"];
$edad = $_POST["txtEdad"];
$cbopais = $_POST["CboPais"];
$telefono = $_POST["txtNumCelular"];
$codigoPais = $_POST["txtCodigoPais"];
$direccion = $_POST["txtdireccion"];

$idLista = (int)$_POST['txtIdLista'];

$telefonoCodigo = $codigoPais . $telefono;


/* $otraRespuesta = $_POST["txtOtraRespuesta"]; */


/* $IdCursos = [22, 23]; */


// $cboCateInstitucion=$_POST["CboCateIntitucion"];
// $cboInstitucion=$_POST["CboInstitucion"];

$date = date_default_timezone_set('America/lima');
$fecha_actual = date('Y-m-d H:i:s');;
$fecha = date("y-m-d");

$codigoUsuario = date("dmyGi");

/* $asunto = "Coreo de prueba";
$mensaje = "hola como estas es es el correo de prueba";
$header = "From: beatrizcmad24@gmail.com" . "\r\n";
$header .= "Reply-To: beatrizcmad24@gmail.com" . "\r\n";
$header .= "X-Mailer: PHP/" . phpversion();
 */

$resgPros = $query->insertar(
    "prospectos(pros_codigo,pros_nombres,pros_apellido_paterno,pros_apellido_materno,pros_edad,pros_email,pros_telefono,pros_direccion,ID_PAIS,ID_INSTITUCION,pros_estado)",
    "('$codigoUsuario','$nombres','$ape_paterno','$ape_materno','$edad','$Correo','$telefonoCodigo','$direccion','$cbopais','1','1')"
);
if ($resgPros) {
    $buscar = $query->buscarFech(
        "idProspecto",
        "prospectos",
        "pros_nombres='$nombres' AND pros_apellido_paterno='$ape_paterno' AND pros_apellido_materno='$ape_materno' AND pros_telefono='$telefonoCodigo' AND pros_email='$Correo'"
    );
    if ($buscar) {
        $resp = mysqli_fetch_array($buscar);
        $id = $resp["idProspecto"];


        // for ($i = 0; $i <2; $i++) {
           
        //     $idcurso = $IdCursos[$i];
        //     if ($i == 1) {
        //         $values .= "(" . $id . "," . $idcurso.",'" . $fecha_actual . "')";
        //     } else {
        //         $values .= "(" . $id . "," . $idcurso.",'" . $fecha_actual . "'),";
        //     }
        // }

        // $idPregunta = $_POST['txtIdPregunta1'];
        // $values = "";

        // for ($i = 0; $i <count($_POST["checkbox"]); $i++) {        
        //     if ($i == count($_POST["checkbox"])-1) {
        //         $values .= "(" . $id . "," . $idPregunta . "," . $_POST["checkbox"][$i] . ",'" . $fecha_actual . "','descripcion','1')";
        //     } else {
        //         $values .= "(" . $id . "," . $idPregunta . "," . $_POST["checkbox"][$i] . ",'" . $fecha_actual . "','descripcion','1'),";
        //     }
        // }

        // $registroUnion = $query->insertar(
        //     "preguntas_prospecto(ID_PROSPECTO,ID_PREGUNTA,ID_RESPUESTA,fecha_registro,preguntaProspecto_detalle,estado)",
        //     $values
        // );

        $registroUnionCursos = $query->insertar(
            "cursos_prospecto(ID_PROSPECTO,ID_CURSO,fecha_registro)",
            "(" . $id . "," . $_POST["txtIdCurso"] . ",'" . $fecha_actual . ",".$_POST['txtIdCampania'].")"
        );
        if ($registroUnion) {

            //envio a registrar en la lista de sendinblue
            $busqueda = buscarContacto($Correo);
            if ($busqueda == $Correo) {
                $borrar = borrarContacto($Correo);
                if ($borrar == true) {

                    $resultado = agergarContactos($Correo, $ape_paterno . " " . $ape_materno, $nombres, $telefonoCodigo, $idLista);
                    if ($resultado == true) {
                        $respuesta["exito"] = "Usted se registró correctamente ";
                    } else {
                        $respuesta["error"] = "Ingrese correctamente su telefono";
                    }
                }
            } else {
                $resultado = agergarContactos($Correo, $ape_paterno . " " . $ape_materno, $nombres, $telefonoCodigo, $idLista);
                if ($resultado == true) {
                    $respuesta["exito"] = "Usted se registró correctamente ";
                } else {
                    $respuesta["error"] = "Ingrese correctamente su telefono";
                }
            }







            /* $emailEnviado = @mail($Correo, $asunto, $mensaje, $header);
            if ($emailEnviado) {
                $respuesta["exito"] = "Correo enviado correctamente";
            } */
        } else {

            $respuesta["error"] = "Errror en el registro";
            return false;
        }
    }
}
echo json_encode($respuesta);
