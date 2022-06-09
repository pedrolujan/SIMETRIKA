<?php


require_once('sendinblue_addContacts.php');
include "../model/conexion.php";
// include "../model/conexionPruebas.php";
$query = new ApptivaDB();
/* $CantidadPreguntas = $_POST["txtNumeroPreguntas"]; */
$Correo = $_POST["wj_lead_email"];
$nombres = $_POST["wj_lead_first_name"];
$apellidos = $_POST["wj_lead_last_name"];
// $edad = $_POST["txtEdad"]; 
// $cbopais = $_GET["wj_lead_phone_country_code "];
$telefono = $_POST["wj_lead_phone_number"];
$codigoPais = $_POST["wj_lead_phone_country_code"];
// $direccion = $_POST["txtdireccion"];

$idLista = (int)$_POST['wj_lead_id_List'];

$telefonoCodigo = $codigoPais . $telefono;

////recortar el primer nombre /////
// $apellidosSeparados = explode (" ", $apellidos);
// if(count($apellidosSeparados)>1){
//     $ape_paterno = $apellidosSeparados[0];
//     $ape_materno = $apellidosSeparados[1];
// }else{
//     $ape_paterno = $apellidosSeparados[0];
//     $ape_materno = "";
// }


////recortar el primer nombre /////
$primerNombre = explode (" ", $nombres);


//cogemos el id del personal 

$busqID = $query->buscarGeneral(
    "u.idUsuario",
    "usuarios u",
    "u.ID_CARGO=3"
);
foreach ($busqID as $e) {
    $obj[] = $e["idUsuario"];
}
///genero los ids aleatrorios////////  
$idRandon = rand(0, count($obj) - 1);


$date = date_default_timezone_set('America/lima');
$fecha_actual = date('Y-m-d H:i:s');;
$fecha = date("y-m-d");

$codigoUsuario = date("dmyGi");
if(!empty($Correo)){

$buscarExistencia = $query->buscarFech(
    "p.idProspecto",
    "prospectos p",
    "p.pros_email='" . $Correo . "'"
);

$existencia = mysqli_num_rows($buscarExistencia);
$respExistencia = mysqli_fetch_array($buscarExistencia);
if ($existencia > 0) {
     
     $idP = $respExistencia["idProspecto"];
     $actEstProspecto = $query->actualizar("prospectos", "pros_telefono='".$telefonoCodigo."'", "idProspecto='$idP'");

    $buscarExistenciaConCurso = $query->buscarFech("cp.ID_PROSPECTO","cursos_prospecto cp","cp.ID_PROSPECTO='" . $idP . "' AND cp.ID_CURSO='".$_POST["txtIdCurso"]."'");
    
    $rowExistenciaPC = mysqli_num_rows($buscarExistenciaConCurso);
    if($rowExistenciaPC>0){

    }else{
            $registroUnionCursos = $query->insertar(
                "cursos_prospecto(ID_PROSPECTO,ID_CURSO,ID_CAMPANIA,fecha_registro)",
                "(" . $idP. "," . $_POST["txtIdCurso"] . "," . $_POST["txtIdCampania"] . ",'" . $fecha_actual . "')"
            );
            if ($registroUnionCursos) {
                $actEstProspecto = $query->actualizar("prospectos", "pros_estado='1'", "idProspecto='$idP'");

                //envio a registrar en la lista de sendinblue
                $busqueda = buscarContacto($Correo);

                if ($busqueda == $Correo) {
                    $actualizarAtributos = ActualizarAtributosContacto($Correo,$apellidos, $primerNombre[0], $nombres, $telefonoCodigo);
                    if ($actualizarAtributos == true) {
                        $ActualizarPreferencia = fnAgregarContactoAotraLista($idLista, $Correo);
                        if ($ActualizarPreferencia == true) {
                            $respuesta["exito"] = "Usted se registró correctamente";
                        } else {
                            $respuesta["error"] = "Error en el reguistro";
                        }
                    }
                } else {
                    $resultado = agergarContactos($Correo,$apellidos, $primerNombre[0], $nombres, $telefonoCodigo, $idLista);
                    if ($resultado == true) {
                        $respuesta["exito"] = "Usted se registró correctamente ";
                    } else {
                        $resSinTelefono = agergarContactosSinTelefono($Correo, $apellidos, $primerNombre[0], $nombres, $idLista);
                        if ($resSinTelefono == true) {
                            $respuesta["exito"] = "Usted se registró correctamente ";
                        } else {

                            $respuesta["error"] = "Ingrese correctamente su telefono";
                        }
                    }
                }

                
            }
    }
} else {
   
    $buscarIdProspecto =  fnObtenerUltimoId($query, "idProspecto", "prospectos");
    $resgPros = $query->insertar(
        "prospectos(pros_codigo,pros_nombres,pros_apellidos,pros_email,pros_telefono,pros_estado,fechaRegistro,idUsuario)",
        "(concat('PS', LPAD($buscarIdProspecto, 8, '0')),'$nombres','$apellidos','$Correo','$telefonoCodigo','0','$fecha_actual','$obj[$idRandon]')"
    );

    if ($resgPros) {
        $buscar = $query->buscarFech(
            "idProspecto",
            "prospectos",
            "pros_nombres='$nombres' AND pros_apellidos='$apellidos' AND pros_telefono='$telefonoCodigo' AND pros_email='$Correo' AND pros_estado='0'"
        );
        if ($buscar) {
            $resp = mysqli_fetch_array($buscar);
            $id = $resp["idProspecto"];

            /* for ($i = 0; $i <2; $i++) {
           
            $idcurso = $IdCursos[$i];
            if ($i == 1) {
                $values .= "(" . $id . "," . $idcurso.",'" . $fecha_actual . "')";
            } else {
                $values .= "(" . $id . "," . $idcurso.",'" . $fecha_actual . "'),";
            }
        } */
            /* $values = "";  
        for ($i = 1; $i <= $CantidadPreguntas; $i++) {
            $idPregunta = $_POST['txtIdPregunta' . $i];
            $idRespuesta = $_POST['Respuesta' . $i];
            if ($i == $CantidadPreguntas) {
                $values .= "(" . $id . "," . $idPregunta . "," . $idRespuesta . "," . $fecha_actual . ",'descripcion','1')";
            } else {
                $values .= "(" . $id . "," . $idPregunta . "," . $idRespuesta . "," . $fecha_actual . ",'descripcion','1'),";
            }
        } */
            /* $registroUnion = $query->insertar(
            "preguntas_prospecto(ID_PROSPECTO, ID_PREGUNTA,ID_RESPUESTA, fecha_registro, preguntaProspecto_detalle, estado)",
            $values
        ); */

            
            // print_r($obj);


            $registroUnionCursos = $query->insertar(
                "cursos_prospecto(ID_PROSPECTO,ID_CURSO,ID_CAMPANIA,fecha_registro)",
                "(" . $id . "," . $_POST["txtIdCurso"] . "," . $_POST["txtIdCampania"] . ",'" . $fecha_actual . "')"
            );
            if ($registroUnionCursos) {
                $actEstProspecto = $query->actualizar("prospectos", " pros_estado='1'", " idProspecto='$id'");

                //envio a registrar en la lista de sendinblue
                $busqueda = buscarContacto($Correo);

                if ($busqueda == $Correo) {
                    $actualizarAtributos = ActualizarAtributosContacto($Correo,$apellidos, $primerNombre[0], $nombres, $telefonoCodigo);
                    if ($actualizarAtributos == true) {
                        $ActualizarPreferencia = fnAgregarContactoAotraLista($idLista, $Correo);
                        if ($ActualizarPreferencia == true) {
                            $respuesta["exito"] = "Usted se registró correctamente";
                        } else {
                            $respuesta["error"] = "Error en el reguistro";
                        }
                    }
                } else {
                    $resultado = agergarContactos($Correo,$apellidos, $primerNombre[0], $nombres, $telefonoCodigo, $idLista);
                    if ($resultado == true) {
                        $respuesta["exito"] = "Usted se registró correctamente ";
                    } else {
                        $resSinTelefono = agergarContactosSinTelefono($Correo, $apellidos, $primerNombre[0], $nombres, $idLista);
                        if ($resSinTelefono == true) {
                            $respuesta["exito"] = "Usted se registró correctamente ";
                        } else {

                            $respuesta["error"] = "Ingrese correctamente su telefono";
                        }
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
}

}
echo json_encode($respuesta);



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