
<?php
/* header("Location:".$urlProyecto."descargar_datos.php"); */
session_start();
$arreglo=array();
    include("../model/url.php");
    include("../model/conexion.php");
    $conex=new ApptivaDB();
$Usuario = 0;
if (isset($_SESSION["asistenteLogeado"])) {
    $Usuario = $_SESSION["asistenteLogeado"];
} else {
    $Usuario = 0;
    }

$campaniaGeneral=$_POST["txtCampaniaGeneral"];
$Evento=$_POST["txtEvento"];

$idCurso = 0;
if ($_POST["txtCurso"] == "" || $_POST["txtCurso"] == null) {
    $idCurso = 0;
} else {

    $idCurso=$_POST["txtCurso"];
}
$dFechaInicio=$_POST["txtFechaIni"];
$dFechaFinal=$_POST["txtFechaFinal"];
$habilitarFecha=0;
if($dFechaInicio!="" && $dFechaFinal!=""){
    $habilitarFecha=1;
}
if($campaniaGeneral!=0){

    $u = $conex->buscarFech(
        "p.pros_nombres,p.pros_apellidos,p.pros_telefono",
        "cursos_prospecto cp
        INNER JOIN cursos c ON cp.ID_CURSO=c.idCursos
        right JOIN prospectos p ON cp.ID_PROSPECTO=p.idProspecto
        INNER JOIN campania ca On cp.ID_CAMPANIA=ca.idCampania
        INNER JOIN campaniassmtk cg ON ca.ID_CAMPANIA=cg.idCampania
        INNER JOIN pais pa ON p.ID_PAIS=pa.Codigo",
        "(('" . $campaniaGeneral . "'='0') OR (cg.idCampania='" . $campaniaGeneral . "'))
        AND (('" . $Evento . "'='0') OR (cp.ID_CAMPANIA='" . $Evento . "'))
        AND (('" . $idCurso . "'='0') OR (cp.ID_CURSO='" . $idCurso . "'))
        AND (('" . $habilitarFecha . "'='0') OR (cp.fecha_registro BETWEEN'" . $dFechaInicio . "' AND '" . $dFechaFinal . "'))
        AND p.pros_estado='1'
         AND(('" . $Usuario . "'='0') OR (p.idUsuario='" . $Usuario . "'))"
    );
}else{

    $u = $conex->buscarFech(
        "p.pros_nombres,p.pros_apellidos,p.pros_telefono",
        "prospectos p
        INNER JOIN pais pa ON p.ID_PAIS=pa.Codigo",
        "(('" . $habilitarFecha . "'='0') OR (p.fechaRegistro BETWEEN'" . $dFechaInicio . "' AND '" . $dFechaFinal . "'))
        AND p.pros_estado='1'
         AND(('" . $Usuario . "'='0') OR (p.idUsuario='" . $Usuario . "'))"
    );
}

    
if ($_POST["rbexportar"]=="completo") {
    session_start();
    $llego_array=array();
    header("Content-Type: txt/csv; charset=utf-8");
    header("Content-Disposition: attachment; filename= Prospectos.csv");
    $ouput = fopen("php://output", "w");
    $llego_array =$_SESSION["ExportarTodo"];
   
    fputcsv($ouput, array("Nombre", "Apellido paterno","Apellido Materno","Correo", "Telefono", "Pais"));
    foreach ($llego_array as $v) {
        fputcsv($ouput, $v);
       
    } 
    fclose($ouput);
    unset($_SESSION["ExportarTodo"]);
    unset($_SESSION["ExportarSendinBlue"]);
    unset($_SESSION["ExportarContactos"]);

    $arreglo["exito"]="Exportacion exitosa";
}else if ($_POST["rbexportar"]=="Sendinblue") {
    session_start();
    $llego_array=array();
    header("Content-Type: txt/csv; charset=utf-8");
    header("Content-Disposition: attachment; filename= Prospectos_SendinBlue.csv");
    $ouput = fopen("php://output", "w");
    $llego_array =$_SESSION["ExportarSendinBlue"];
    
    fputcsv($ouput, array("Nombres","Apellidos","Correo","Telefono"));

    foreach ($llego_array as $v) {
        fputcsv($ouput, $v);
       
    } 
    fclose($ouput);
    unset($_SESSION["ExportarTodo"]);
    unset($_SESSION["ExportarSendinBlue"]);
    unset($_SESSION["ExportarContactos"]);

    $arreglo["exito"]="Exportacion exitosa";

}else if ($_POST["rbexportar"]=="Contactos") {
 
    // $llego_array=array();
    header("Content-Type: txt/csv; charset=utf-8");
    header("Content-Disposition: attachment; filename= Prospectos_Contactos.csv");
    $ouput = fopen("php://output", "w");
    // $llego_array =$_SESSION["ExportarContactos"];   
    fputcsv($ouput, array("Name","Given Name", "Phone 1 - Value"));

    foreach ($u as $v) {
        fputcsv($ouput, $v);       
    } 
    fclose($ouput);
    /* if(fclose($ouput)){

        header("Location:".$urlProyecto."views/prospectos");
    } */
    
}
/* $arreglo["exito"]="Exportacion exitosa";
echo json_encode($arreglo); */

?>