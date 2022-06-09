<?php
session_start();
include("../../model/url.php");/* 
include("../../views/prospectos/"); */
/* header("Refresh: 3; URL='../../views/prospectos/'"); */
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prospectos</title>
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilos_sideBar.css"> -->
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilos_header.css">
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilosProspectosTabla.css?gfh">
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/estilosLoader.css">
    <!-- <link rel="stylesheet" href="../../CSS/estilosFormulario.css?098"> -->
    <link rel="stylesheet" href="../../fonts/style.css">
    <link rel="stylesheet" href="../../fontawesome/css/all.css">

    <link rel="stylesheet" href="../../JS/modals/jquery.modal.min.css">
    <link rel="stylesheet" href="../../CSS/estilosVentanasModal.css?jfh">

    <link rel="stylesheet" href="../../CSS/estilos_menu_navbar.css?kdf">

    <!-- <link rel="stylesheet" href="../../CSS/pages/jPages.css">
    <link rel="stylesheet" href="../../CSS/pages/animate.css"> -->

    <link rel="icon" href="../../IMAGENES/faviconn.png" type="image/png" />
   

   
    <link rel="stylesheet" href="../../DataTables/datatables.min.css">
    <!--datables estilo bootstrap 4 CSS-->
    <link rel="stylesheet" type="text/css" href="../../DataTables/DataTables-1.10.25/css/dataTables.bootstrap4.min.css">
    <style>
        .menuItem {
            list-style: none;
            list-style-type: none;
            list-style-position: outside;
        }

        .itemHijo {
            line-height: 30px;
            font-size: 16px;
            cursor: pointer;
        }

        .cntMenu {
            width: 250px;
            position: absolute;
            border: 1px solid black;
            background-color: burlywood;
            -moz-box-shadow: 0 0 5px #888;
            -webkit-box-shadow: 0 0 5px#888;
            box-shadow: 0 0 5px #888;
        }
    </style>

</head>

<body>
    <?php include("../menu/menu_lateral.php") ?>
    <?php include("../header.php"); ?>
    <?php include("../loader.php"); ?>
    <div id="main" class="main pl-3 col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12">

        <?php 
        include("../consultaClientes.php");
        include("../ventanas-modal.php");
         ?>

       <!--  <div id="menu" class="cntMenu">
            <ul class="menuItem">
                <li class="itemHijo" id="copiar">Copiar</li>
                <li class="itemHijo" id="mover">Mover</li>
                <li class="itemHijo" id="eliminar">Eliminar</li>
            </ul>
        </div> -->
        <div class='mensajes' id="mensajes"></div>
    </div>



    <script src="<?php echo $urlProyecto ?>JS/jquery-3.5.1.min.js"></script>
    <script type="module" src="<?php echo $urlProyecto ?>JS/scripPagClientes.js?asd"></script>

  <script src="<?php echo $urlProyecto ?>JS/pages/jPages.min.js"></script>
    <script src="<?php echo $urlProyecto ?>JS/BOOTSTRAP/bootstrap.min.js"></script>
    <script src="../../JS/BOOTSTRAP/popper.min.js"></script>
    <!-- datatables JS -->
    <script type="text/javascript" src="../../DataTables/datatables.min.js"></script>
    <!-- para usar botones en datatables JS -->
    <script src="../../DataTables/Buttons-1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="../../DataTables/JSZip-2.5.0/jszip.min.js"></script>
    <script src="../../DataTables/pdfmake-0.1.36/pdfmake.min.js"></script>
    <script src="../../DataTables/pdfmake-0.1.36/vfs_fonts.js"></script>
    <script src="../../DataTables/Buttons-1.7.1/js/buttons.html5.min.js"></script>

    <script src="<?php echo $urlProyecto ?>JS/redirect.js"></script>
    <script src="../../JS/modals/jquery.modal.min.js"></script>

    <script src="../../JS/scrip_general.js" type="module"></script>

    <!--  <script src="../JS/BOOTSTRAP/jquery-3.5.1.slim.min.js"></script>
    <script src="../JS/BOOTSTRAP/popper.min.js"></script>
    <script src="../JS/BOOTSTRAP/bootstrap.min.js"></script> -->
</body>

</html>