<?php


require_once('sendinblue_addContacts.php');
include "../model/conexion.php";
//  include "../model/conexionPruebas.php";
$con = new ApptivaDB();

$Correo = $_POST["txtEmail"];
$apellidos = $_POST["txtApellidos"];

$nombres = $_POST["txtnombres"];
$edad = "";
$cbopais = $_POST["CboPais"];
$telefono = $_POST["txtNumCelular"];
$codigoPais = $_POST["txtCodigoPais"];

// $idLista = (int)$_POST['txtIdLista'];


$telefonoCodigo = $codigoPais . $telefono;
$cantidadEvetos = $_POST["txtNumWebinars"];

$idsEventos = "";
$valuesWebinar = "";



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

////recortar el primer nombre /////
// $apellidosSeparados = explode(" ", $apellidos);
// if (count($apellidosSeparados) > 1) {
//     $ape_paterno = $apellidosSeparados[0];
//     $ape_materno = $apellidosSeparados[1];
// } else {
//     $ape_paterno = $apellidosSeparados[0];
//     $ape_materno = "";
// }

// $primerNombre = explode(" ", $nombres);

$date = date_default_timezone_set('America/lima');
$fecha_actual = date('Y-m-d H:i:s');;
$fecha = date("y-m-d");

$busqID = $con->buscarConsultas(
    "u.idUsuario",
    "usuarios u",
    "u.ID_CARGO=3"
);
foreach ($busqID as $e) {
    $obj[] = $e["idUsuario"];
}
///genero los ids aleatrorios////////  
$idRandon = rand(0, count($obj) - 1);
$buscarExistencia = $con->buscarFech(
    "p.idProspecto",
    "prospectos p",
    "p.pros_email='" . $Correo . "'"
);


$data = json_decode($_POST['arregloWebinars']);

return print_r($data);




$existencia = mysqli_num_rows($buscarExistencia);

if ($existencia > 0) {
    $respExistencia = mysqli_fetch_array($buscarExistencia);
    $idExistencia = $respExistencia["idProspecto"];

    for ($i = 0; $i < count($data); $i++) {
        if ($i + 1 == count($data)) {
            $idsEventos .= $data[$i];
            $valuesWebinar .= "('" . $idExistencia . "','" . $data[$i] . "','" . $_POST["txtIdCampania"] . "','" . $fecha_actual . "')";
        } else {
            $idsEventos .= $data[$i] . ",";
            $valuesWebinar .= "('" . $idExistencia . "','" . $data[$i] . "','" . $_POST["txtIdCampania"] . "','" . $fecha_actual . "'),";
        }
    }


    $registroUnion = $con->insertar(
        "cursos_prospecto(ID_PROSPECTO,ID_CURSO,ID_CAMPANIA,fecha_registro)",
        $valuesWebinar
    );

    // return;

    if ($registroUnion) {
        $IdListaCursos = $con->buscarFech(
            " c.idListaSendBl",
            " cursos c",
            " c.idCursos IN(" . $idsEventos . ")"
        );

        //envio a registrar en la lista de sendinblue
        while ($rowl = mysqli_fetch_array($IdListaCursos)) {
            // $idsListas .= $rowl["idListaSendBl"];
            fnInsertarSendinBlue($Correo, $nombres, $apellidos, $telefonoCodigo, intval($rowl["idListaSendBl"]));
        }
    } else {

        $respuesta["error"] = "Errror en el registro";
        // return false;
    }
} else {
    $buscarIdProspecto = fnObtenerUltimoId($con, "idProspecto", "prospectos");

    $resgPros = $con->insertar(
        "prospectos(pros_codigo,pros_nombres,pros_apellidos,pros_edad,pros_email,pros_telefono,ID_PAIS,pros_estado,idUsuario)",
        "(concat('PS',LPAD($buscarIdProspecto,8, '0')),'$nombres','$apellidos','$edad','$Correo','$telefonoCodigo','$cbopais','1','$obj[$idRandon]')"
    );

    if ($resgPros) {
        $buscar = $con->buscarFech(
            "idProspecto",
            "prospectos",
            "pros_nombres='$nombres' AND pros_apellidos='$apellidos' AND pros_telefono='$telefonoCodigo' AND pros_email='$Correo'"
        );

        if ($buscar) {
            $resp = mysqli_fetch_array($buscar);
            $id = $resp["idProspecto"];

            for ($i = 0; $i < count($data); $i++) {
                if ($i + 1 == count($data)) {
                    $idsEventos .= $data[$i];
                    $valuesWebinar .= "('" . $id . "','" . $data[$i] . "','" . $_POST["txtIdCampania"] . "','" . $fecha_actual . "')";
                } else {
                    $idsEventos .= $data[$i] . ",";
                    $valuesWebinar .= "('" . $id . "','" . $data[$i] . "','" . $_POST["txtIdCampania"] . "','" . $fecha_actual . "'),";
                }
            }


            $registroUnion = $con->insertar(
                "cursos_prospecto(ID_PROSPECTO,ID_CURSO,ID_CAMPANIA,fecha_registro)",
                $valuesWebinar
            );


            if ($registroUnion) {
                $IdListaCursos = $con->buscarFech(
                    " c.idListaSendBl",
                    " cursos c",
                    " c.idCursos IN(" . $idsEventos . ")"
                );
                $idsListas = "";
                $CorrecTo = false;
                //envio a registrar en la lista de sendinblue
                while ($rowl = mysqli_fetch_array($IdListaCursos)) {
                    $idsListas .= $rowl["idListaSendBl"];
                    $CorrecTo = fnInsertarSendinBlue($Correo, $nombres, $apellidos, $telefonoCodigo, intval($rowl["idListaSendBl"]));
                }
                if ($CorrecTo) {
                    $respuesta["exito"] = "Ud. se Registro Correctamnete";
                } else {
                    $respuesta["error"] = "Error en el registro -> comunique al administrador ⚠️";
                }
                // print_r($idsListas);
                // return;    
            } else {
                $respuesta["error"] = "Error en el registro -> comunique al administrador ⚠️";
                // echo "error";
            }
        } else {
            $respuesta = "hubo un error en el registro";
        }
    }
}







function fnInsertarSendinBlue($Correo, $nombres, $apellidos, $telefonoCod, $idLista)
{
    $estado = false;
    //recortamos el pruimer nombre
    $primerNombre = explode(" ", $nombres);

    $identificador = "";
    if (buscarContacto($Correo) != 404) {
        $identificador = $Correo;
    } else if (buscarContacto($telefonoCod) != 404) {
        $identificador = buscarContacto($telefonoCod);
    }

    if ($identificador != "") {
        $actualizarAtributos = ActualizarAtributosContacto($apellidos, $primerNombre[0], $nombres, $telefonoCod, $identificador);
        if ($actualizarAtributos == true) {
            $agregadoAOtraLista = fnAgregarContactoAotraLista($idLista, $identificador);
            if ($agregadoAOtraLista == true) {
                $estado = true;
            } else {
                $estado = false;
            }
        }
    } else {
        $resultado = agergarContactos($Correo, $apellidos, $primerNombre[0], $nombres, $telefonoCod, $idLista);
        if ($resultado == true) {
            $estado = true;
        } else {
            $resSinTelefono = agergarContactosSinTelefono($Correo, $apellidos, $primerNombre[0], $nombres, $idLista);
            if ($resSinTelefono == true) {
                $estado = true;
            } else {

                $estado = false;
            }
        }
    }

    return $estado;
}
echo json_encode($respuesta);

// function fnInsertarSendinBlue($Correo,$nombres,$apellidos,$telefono, $idLista)
// {
//     $estado=false;
//     //recortamos el pruimer nombre
//     $primerNombre = explode (" ", $nombres);

//     $busqueda = buscarContacto($Correo);

//     if ($busqueda == $Correo) {
//         $actualizarAtributos = ActualizarAtributosContacto($Correo, $apellidos, $primerNombre[0], $nombres, $telefono);
//         if ($actualizarAtributos == true) {
//             $ActualizarPreferencia = fnAgregarContactoAotraLista($idLista, $Correo);
//             if ($ActualizarPreferencia == true) {
//                 $respuesta["exito"] = "Usted se registró correctamente";
//                 $estado=true;
//             } else {
//                 $respuesta["error"] = "Error en el reguistro";
//                 $estado=false;
//             }
//         }
//     } else {
//         $resultado = agergarContactos($Correo, $apellidos, $primerNombre[0], $nombres, $telefono, $idLista);
//         if ($resultado == true) {
//             $respuesta["exito"] = "Usted se registró correctamente ";
//             $estado=true;
//         } else {
//             $resSinTelefono = agergarContactosSinTelefono($Correo, $apellidos, $primerNombre[0], $nombres, $idLista);
//             if ($resSinTelefono == true) {
//                 $respuesta["exito"] = "Usted se registró correctamente ";
//                 $estado=true;
//             } else {

//                 $respuesta["error"] = "Ingrese correctamente su telefono";
//                 $estado=false;
//             }
//         }
//     }

//     return $estado;
// }
