<?php
include("../model/conexion.php");
// include "../model/conexionPruebas.php";
include("../model/url.php");
$busq = new ApptivaDB();
$CodigoPais = array();
$Codigo = "";
$institucion = "";
if (isset($_POST["buscTelefono"])) {
    $telefono = $busq->buscarFech(
        "prospectos.pros_telefono",
        "prospectos",
        "prospectos.pros_telefono='" . $_POST["buscTelefono"] . "'"
    );
    $respTelefono = mysqli_fetch_array($telefono);

    if ($respTelefono["pros_telefono"] == $_POST["buscTelefono"]) {
        $Respuestas["error"] = "Este numero de telefono ya existe";
    } else {
        $Respuestas["exito"] = "";
    }

    echo json_encode($Respuestas);
}
if (isset($_POST["buscCorreo"])) {
    $correo = $busq->buscarFech(
    "p.pros_email,p.idProspecto,cp.ID_CURSO,c.nombre,p.pros_nombres,p.pros_apellidos,p.pros_telefono,p.ID_PAIS",
    "cursos_prospecto cp
    INNER JOIN prospectos p ON cp.ID_PROSPECTO=p.idProspecto
    INNER JOIN cursos c ON c.idCursos=cp.ID_CURSO",
    "p.pros_email='" . $_POST["buscCorreo"] . "'
    "
    );
    while ($row = mysqli_fetch_array($correo)) {
        $otrooo[] = array(
            'idCurso' => $row['ID_CURSO'],
            'NombreCurso' => $row['nombre'],
            'NombrePros' => $row['pros_nombres'],
            'ApellidoPros' => $row['pros_apellidos'],
            'error' => "Hola ".$row["pros_nombres"]." usted ya se encuentra registrado a las siguientes ! clase magistrales ¡   Adicione item ó acceda alos enlaces del evento 👇👇"

        );
    }
    // $respcorreo = mysqli_fetch_array($correo);

    // if ($respcorreo["pros_email"] == $_POST["buscCorreo"]) {
    //     // $Respuestas["error"] =;
    //     // while ($row=mysqli_fetch_array($correo)) {
    //     //     $Respuestas[] = array(
    //     //         'idCurso' => $respcorreo['ID_CURSO'],
    //     //         'error' => "Hola ".$respcorreo["pros_nombres"]." usted ya se encuentra registrado haga click en el boton para ir a los enlaces del evento 👇👇"
    //     //     );
           
    //     // }
        
        

    // } else {
    //     $Respuestas["exito"] = "";
    // }

    echo json_encode($otrooo);
}
