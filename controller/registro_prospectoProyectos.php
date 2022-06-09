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
$ocupacion = $_POST["txtOcupacion"];
$CboTipoProyecto = $_POST["CboTipoProyecto"];
$DescripcionPro = $_POST["txtDescripcion"];
$CboDistrito = $_POST["CboDistrito"];
$DireccionPro = $_POST["txtDireccion"];

$telefonoCodigo=$codigoPais.$telefono;
// $idLista = (int)$_POST['txtIdLista'];

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
    "p.codigo_prospectoPY",
    "prospectos_proyectos p",
    "p.email_prospectoPY='" . $Correo . "'"
);

$existencia = mysqli_num_rows($buscarExistencia);



if ($existencia > 0) {
    $respExistencia = mysqli_fetch_array($buscarExistencia);
    $codExistencia = $respExistencia["codigo_prospectoPY"];

    $buscaridConsulta = fnObtenerUltimoId($con, "idConsultas", "consultas_proyectos");
    $registroConsulta = $con->insertar(
        "consultas_proyectos(codConsulta,fk_codProspectoPY,fk_codTipoProyecto,descripcionProyecto,fk_idDistrito,DireccionProyecto,estado,idUsuario)",
        "(concat('CPY',LPAD($buscaridConsulta,7, '0')),'$codExistencia','$CboTipoProyecto','$DescripcionPro','$CboDistrito','$DireccionPro','1','$obj[$idRandon]')"
    );


    if ($registroConsulta) {                
        $respuesta["exito"] = "Registro Guardado Correctamnete";                
    } else {
        $respuesta["error"] = "Error en el registro -> comunique al administrador ⚠️";
    }

} else {
    $buscarIdProspecto = fnObtenerUltimoId($con, "idProspectosPY", "prospectos_proyectos");
    
    $resgPros = $con->insertar(
        "prospectos_proyectos(codigo_prospectoPY,nombres_prospectoPY,apellidos_prospectoPY,email_prospectoPY,telefono_prospectoPY,ocupacion_prospectoPY,fk_codPais,fechaRegistro,idUsuario,estado)",
        "(concat('PPY',LPAD($buscarIdProspecto,7, '0')),'$nombres','$apellidos','$Correo','$telefonoCodigo','$ocupacion','$cbopais','$fecha_actual','$obj[$idRandon]','1')"
    );

    if ($resgPros) {
        $buscar = $con->buscarFech(
            "codigo_prospectoPY",
            "prospectos_proyectos",
            "nombres_prospectoPY='$nombres' AND apellidos_prospectoPY='$apellidos' AND telefono_prospectoPY='$telefonoCodigo' AND email_prospectoPY='$Correo'"
        );

        if ($buscar) {
            $resp = mysqli_fetch_array($buscar);
            $codProspecto = $resp["codigo_prospectoPY"];

            $buscaridConsulta = fnObtenerUltimoId($con, "idConsultas", "consultas_proyectos");
            $registroConsulta = $con->insertar(
                "consultas_proyectos(codConsulta,fk_codProspectoPY,fk_codTipoProyecto,descripcionProyecto,fk_idDistrito,DireccionProyecto,estado,idUsuario)",
                "(concat('CPY',LPAD($buscaridConsulta,7, '0')),'$codProspecto','$CboTipoProyecto','$DescripcionPro','$CboDistrito','$DireccionPro','1','$obj[$idRandon]')"
            );


            if ($registroConsulta) {
                
                $respuesta["exito"] = "Registro Guardado Correctamnete";
                // $CorrecTo = false;
                // //envio a registrar en la lista de sendinblue
                // while ($rowl = mysqli_fetch_array($IdListaCursos)) {
                //     $idsListas .= $rowl["idListaSendBl"];
                //     $CorrecTo = fnInsertarSendinBlue($Correo, $nombres, $apellidos, $telefonoCodigo, intval($rowl["idListaSendBl"]));
                // }
                // if ($CorrecTo) {
                //     $respuesta["exito"] = "Ud. se Registro Correctamnete";
                // } else {
                //     $respuesta["error"] = "Error en el registro -> comunique al administrador ⚠️";
                // }
                // print_r($idsListas);
                // return;    
            } else {
                $respuesta["error"] = "Error en el registro -> comunique al administrador ⚠️";
                // echo "error";
            }
        } else {
            $respuesta["error"] = "Hubo un error en el registro";
        }
    }
}


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

function fnInsertarSendinBlue($Correo, $nombres, $apellidos, $telefonoCod,$link, $idLista)
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
        $actualizarAtributos = ActualizarAtributosContacto($apellidos, $primerNombre[0], $nombres, $telefonoCod,$link, $identificador);
        if ($actualizarAtributos == true) {
            $agregadoAOtraLista = fnAgregarContactoAotraLista($idLista, $identificador);
            if ($agregadoAOtraLista == true) {
                $estado = true;
            } else {
                $estado = false;
            }
        }
    } else {
        $resultado = agergarContactos($Correo, $apellidos, $primerNombre[0], $nombres, $telefonoCod,$link, $idLista);
        if ($resultado == true) {
            $estado = true;
        } else {
            $resSinTelefono = agergarContactosSinTelefono($Correo, $apellidos, $primerNombre[0], $nombres,$link, $idLista);
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

