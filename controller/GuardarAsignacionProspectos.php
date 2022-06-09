<?php
include("../model/conexion.php");
$con=new ApptivaDB();

$values="";
$numDeProspectos=$_POST["txtCantidadItemsActivar"];
$idPersonal=$_POST["cboidUsuarioPersonal"];

for ($i=0; $i < $numDeProspectos ; $i++) { 
    if($i==$numDeProspectos-1){
        $values.=$_POST["txtProspecto".$i];
    }else{
        $values.=$_POST["txtProspecto".$i].",";

    }
}
// echo $values;
// return;
$actualizar=$con->actualizar("prospectos p"," p.idUsuario='".$idPersonal."'"," p.idProspecto IN($values)");

if($actualizar){
    $msg["ok"]="Asignacion Realizada Correctamente";
}else{
    $msg["error"]="Error en la Asignacion";

}
echo json_encode($msg);