<?php
session_start();
include("model/url.php");
include('model/conexion.php');

if (!(isset($_SESSION['adminLogeado']) || isset($_SESSION["supervisorLogeado"]) || isset($_SESSION["asistenteLogeado"]))) {
    header("Location:" . $urlProyecto . "views/login");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simetrika</title>
    <link rel="stylesheet" href="CSS/bootstrap.min.css">
    <link rel="stylesheet" href="CSS/estilos_header.css">
    <!-- <link rel="stylesheet" href="CSS/estilos_sideBar.css"> -->
    <link rel="stylesheet" href="CSS/estilos_Cliente.css">
    <link rel="stylesheet" href="CSS/estilos_dashboard.css">
    <link rel="stylesheet" href="fonts/style.css">

    <link rel="stylesheet" href="fontawesome/css/all.css">
    <link rel="stylesheet" href="CSS/estilos_menu_navbar.css">

    <link rel="icon" href="IMAGENES/faviconn.png" type="image/png" />
</head>

<body class="bodyy">
    <?php include("views/menu/menu_lateral.php"); ?>
    <?php include("views/header.php"); ?>
    <div id="main" class="main   main-expanded col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">

        <?php
        include("views/dashboard.php");
        ?>

    </div>

    <script src="JS/jquery-3.5.1.min.js"></script>
   <script src="JS/scrip_general.js?dcfh" type="module"></script>
   <script src="JS/scrip_dashboard.js?dcfh" type="module"></script>
    <!-- <script type="module" src="JS/scripPagClientes.js?asrs"></script> -->
    <!-- <script src="JS/BOOTSTRAP/jquery-3.5.1.slim.min.js"></script> -->
    <script src="JS/BOOTSTRAP/popper.min.js"></script>
    <script src="JS/BOOTSTRAP/bootstrap.js"></script>
    <!-- <script src="JS/scripAreaPersonal.js" type="module"></script> -->
    <script src="JS/graficos/Chart.bundle.min.js"></script>
    <script src="JS/graficos/Chart.min.js"></script>
    <script src="JS/scrip-graficos.js"></script>

</body>

</html>