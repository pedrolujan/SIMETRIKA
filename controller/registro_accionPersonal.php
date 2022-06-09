<?php


include "../model/conexion.php";
$query = new ApptivaDB();
if(isset($_POST["txtidUsuarioPersonal"])) {
    $IdUsuarioPersonal = $_POST["txtidUsuarioPersonal"];
    $IdProspecto = $_POST["txtIdProspecto"];
    $tipoSeguimiento = $_POST["rbSegimiento"];
    $descripcion = $_POST["txtDescripcion"];

    $date = date_default_timezone_set('America/lima');
    $fecha_actual = date('Y-m-d H:i:s');;
    $fecha = date("y-m-d");

    if ($descripcion == null) {
        $respuesta["error"] = "Porfavor describa el seguimiento realizado";
    } else {

        $registro = $query->insertar(
            "seguimiento(ID_PROSPECTO,ID_USUARIO_PERSONAL,tipoSeguimiento,descripcionSeguimiento,fecha_registro)",
            "('$IdProspecto','$IdUsuarioPersonal','$tipoSeguimiento','$descripcion','$fecha_actual')"
        );
        if ($registro) {
            $buscar = $query->buscarFech(
                "ID_PROSPECTO",
                "seguimiento",
                "ID_PROSPECTO='$IdProspecto' AND ID_USUARIO_PERSONAL='$IdUsuarioPersonal' AND descripcionSeguimiento='$descripcion'"
            );
            if ($buscar) {
                $resp = mysqli_fetch_array($buscar);
                $id = $resp["ID_PROSPECTO"];

                $actualizarEstado = $query->actualizar(
                    "prospectos",
                    "pros_estado_segimiento='1',
                tipoSeguimiento='$tipoSeguimiento'",
                    "idProspecto='$id'"
                );

                if ($actualizarEstado) {
                    $respuesta["exito"] = "Seguimiento registrado Correctamente";
                } else {

                    $respuesta["error"] = "Hubo un errror en el registro del seguimiento";
                    return false;
                }
            } else {
                $respuesta["error"] = "No se encontro el prospecto";
            }
        }
    }
    echo json_encode($respuesta);
}else{
    $Nombres=$_POST["txtNombres"];
    $Apellidos=$_POST["txtApellidos"];
    $Correo=$_POST["txtCorreo"];
    $Telefono=$_POST["txttelefono"];
    $Pais=$_POST["cboPais"];
    $IdProspecto=$_POST["txtIdProspecto"];

    $result=$query->actualizar("prospectos","pros_nombres='".$Nombres."',pros_apellidos='".$Apellidos."',pros_email='".$Correo."',pros_telefono='".$Telefono."',ID_PAIS='".$Pais."'","idProspecto ='".$IdProspecto."'");
    if($result){
        $sms["ok"]="Actualizacion Correcta";
    }else{
        $sms["error"]="Error en la actualizacion";
    }

    echo json_encode($sms);
}
