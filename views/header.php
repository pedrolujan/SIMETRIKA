<?php
error_reporting(0);
include("../model/url.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>


</head>

<body>
    <header class="w-100">
        <div class="m-0 p-0 sidebar-brand col-6 col-xs-6 col-sm-6 col-md-3 col-lg-3">
            <span class="nom-simetrika col-8 col-xs-8 col-sm-8 col-md-8 col-lg-8" id="nom-simetrika">SIMETRIKA</span>
            <label for="nav-toggle" class="m-0 h-100 col-2 col-xs-2 col-sm-2 col-md-2 col-lg-2">
                <span class="fas fa-bars m-0"></span>
            </label>
            <div class="logo-empresa m-0 d-none col-10 col-xs-10 col-sm-10 col-md-10 col-lg-10 d-lg-flex" id="logo-empresa">
                <img class="w-auto" src="<?php echo $urlProyecto ?>IMAGENES/simetrika.png" alt="" srcset="">
            </div>
        </div>
        <div class=" d-none col-4 col-xs-4 col-sm-4 col-md-4 col-lg-4 d-lg-block">

        </div>
        <div class="group-alert-Venta d-none  h-100  col-2 col-xs-2 col-sm-2 col-md-3 col-lg-3 d-md-flex align-items-center">
            <div class="col-4 col-xs-4 col-sm-4 col-md-4 col-lg-4" onClick="desplemenuPrecios()">
                <span class="fas fa-wallet"></span>
                <div class="alert-contador-ventas" id="alert-contador-ventas"></div>
                <div class="menuPrecios " id="menuPrecios">
                    <ul class="submenuPrecios" id="submenuPrecios" onClick="desplemenuPrecios()">
                        <li><i class="contadorVentasSoles"></i><a href="#" class="totalDineroVentasSoles"></a></li>
                        <li><i class="ContadorVentasDolar"></i><a href="#" id="btnperfil" class="totalDineroDolar"></a></li>
                    </ul>
                </div>
            </div>

            <div class="group-monto-total col-8 col-xs-8 col-sm-8 col-md-8 col-lg-8">
                <span class="" id="txtdineroTotalVentasHeader"></span>
            </div>

        </div>

        <div class="contenUsuario " onClick="desplemenulogin()">
            <div class="imagenUsuario">
                <img class="imagenUsuarioLogeado w-100" id="imagenUsuarioLogeado" src="<?php echo $urlProyecto ?>IMAGENES/personal/usuario03.png" alt="" srcset="">
            </div>
            <div id="datos-usuarioLogeado" class="d-block text-left ">
                <span id="nombreUsuario" class="nombreUsuario">pedro lujan</span>
                <small id="cargoUsuario" class="cargoUsuario">admin</small>
            </div>
            <div class="menuUsuario" id="menuUsuario">
                <ul class="celusubmenuUsuario" id="celusubmenu" onClick="desplemenulogin()">
                    <li onClick="desplemenulogin()"><i class="fas fa-key"></i><a href="#">Cabiar Contraseña</a></li>
                    <li onClick="desplemenulogin()"><i class="fas fa-user-cog"></i><a href="#" id="btnperfil">Perfil</a></li>
                    <li><i class="fas fa-sign-out-alt"></i><a href="<?php echo $urlProyecto ?>controller/salir.php">Salir</a></li>
                </ul>
            </div>
        </div>
    </header>
    <div class="msjs alert" id="msjs"></div>
    <?php

    include("model/url.php");
    // include("../../model/url.php");
    ?>

    <script>
        function desplemenulogin() {

            let menuchico = document.getElementById('menuUsuario');
            menuchico.classList.toggle('menuUsuarioActivo');
        }

        function desplemenuPrecios() {

            let menuchico = document.getElementById('menuPrecios');
            menuchico.classList.toggle('menuPreciosActivo');
        }
    </script>

</body>

</html>