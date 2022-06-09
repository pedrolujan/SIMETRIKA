<?php
error_reporting(0);
include("model/url.php");

?>
<input type="checkbox" name="" id="nav-toggle" checked >
<div class="sidebar">
    <div class="sidebar-menu">
        <ul class="itemsMenu">
            <?php
            if (isset($_SESSION['adminLogeado']) || isset($_SESSION["supervisorLogeado"])) {
            ?>
                <li>
                    <a href="<?php echo $urlProyecto ?>" class="menu_items item-inicio">
                        <div class="m-0"><span class="fas fa-tachometer-alt"></span> <span class="name">Inicio</span></div>
                        <div class="m-0"><span class="select fas fa-sort-down"></span></div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $urlProyecto ?>views/personal" id="item-personal" class="menu_items item-personal">
                        <div class="m-0"><span class="fas fa-users-cog"></span> <span class="name">Personal</span></div>
                        <div class="m-0"><span class="select fas fa-sort-down"></span></div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $urlProyecto ?>views/prospectos" class="activo menu_items">
                        <div class="m-0"><span class="fas fa-users"></span> <span class="name">Seguimiento</span></div>
                        <div class="m-0"><span class="select fas fa-sort-down"></span></div>
                    </a>
                </li>
                <li class="submenu">
                    <a href="#" class="activo menu_items">
                        <div class="m-0"> <span class="fas fa-bookmark"></span> <span class="name">Clases</span></div>
                        <div class="m-0"><span class="select fas fa-sort-down"></span></div>
                    </a>

                    <ul class="children">
                        <li>
                            <a href="<?php echo $urlProyecto ?>views/sia/Evento">
                                <div class="m-0"> <span class="fas fa-bookmark"></span> <span class="name">Reg. Clase</span></div>
                                <div class="m-0"><span class="select "></span></div>
                            </a>
                        </li>
                        
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#" class="activo menu_items">
                        <div class="m-0"> <span class="fas fa-user-graduate"></span> <span class="name">SIA</span></div>
                        <div class="m-0"><span class="select fas fa-sort-down"></span></div>
                    </a>

                    <ul class="children">                       
                        <li>
                            <a href="<?php echo $urlProyecto ?>views/sia/alumnos">
                                <div class="m-0"> <span class="fas fa-user-graduate"></span> <span class="name">Alumnos</span></div>
                                <div class="m-0"><span class="select "></span></div>
                            </a>
                        </li>
                        
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#" class="activo menu_items">
                        <div class="m-0"> <span class="fas fa-hand-holding-usd"></span> <span class="name">Ventas</span></div>
                        <div class="m-0"><span class="select fas fa-sort-down"></span></div>
                    </a>

                    <ul class="children">
                        <li>
                            <a href="<?php echo $urlProyecto ?>views/ventas">
                                <div class="m-0"> <span class="fas fa-hand-holding-usd"></span> <span class="name">Registrar Venta</span></div>
                                <div class="m-0"><span class="select "></span></div>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $urlProyecto ?>views/ventas/search-sales">
                                <div class="m-0"> <span class="fas fa-search"></span> <span class="name">Consultar Venta</span></div>
                                <div class="m-0"><span class="select "></span></div>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $urlProyecto ?>views/consult-ventas">
                                <div class="m-0"> <span class="far fa-chart-bar"></span> <span class="name">Detalle Ventas</span></div>
                                <div class="m-0"><span class="select"></span></div>
                            </a>
                        </li>
                    </ul>
                </li>

            <?php } elseif (isset($_SESSION["asistenteLogeado"])) { ?>

                <li>
                    <a href="<?php echo $urlProyecto ?>" class="menu_items item-inicio">
                        <div class="m-0"><span class="fas fa-tachometer-alt"></span> <span class="name">Inicio</span></div>
                        <div class="m-0"><span class="select "></span></div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $urlProyecto ?>views/prospectos/" class="menu_items">
                        <div class="m-0"> <span class="fas fa-users"></span> <span class="name">Seguimiento</span></div>
                        <div class="m-0"><span class="select fas fa-sort-down"></span></div>
                    </a>
                </li>
                <li class="submenu">
                    <a href="#" class="activo menu_items">
                        <div class="m-0"> <span class="fas fa-hand-holding-usd"></span> <span class="name">Ventas</span></div>
                        <div class="m-0"><span class="select fas fa-sort-down"></span></div>
                    </a>

                    <ul class="children">
                        <li>
                            <a href="<?php echo $urlProyecto ?>views/ventas">
                                <div class="m-0"> <span class="fas fa-hand-holding-usd"></span> <span class="name">Registrar Venta</span></div>
                                <div class="m-0"><span class="select "></span></div>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $urlProyecto ?>views/ventas/search-sales">
                                <div class="m-0"> <span class="fas fa-search"></span> <span class="name">Consultar Venta</span></div>
                                <div class="m-0"><span class="select "></span></div>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $urlProyecto ?>views/consult-ventas">
                                <div class="m-0"> <span class="far fa-chart-bar"></span> <span class="name">Detalle Ventas</span></div>
                                <div class="m-0"><span class="select"></span></div>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- <li class="submenu">
                    <a href="#" class="activo menu_items">
                        <div class="m-0"> <span class="fas fa-bookmark"></span> <span class="name">Clases</span></div>
                        <div class="m-0"><span class="select fas fa-sort-down"></span></div>
                    </a>

                    <ul class="children">
                        <li>
                            <a href="<?php echo $urlProyecto ?>views/sia/Evento">
                                <div class="m-0"> <span class="fas fa-bookmark"></span> <span class="name">Reg. Clase</span></div>
                                <div class="m-0"><span class="select "></span></div>
                            </a>
                        </li>
                        
                    </ul>
                </li> -->
                <li class="submenu">
                    <a href="#" class="activo menu_items">
                        <div class="m-0"> <span class="fas fa-user-graduate"></span> <span class="name">SIA</span></div>
                        <div class="m-0"><span class="select fas fa-sort-down"></span></div>
                    </a>

                    <ul class="children">                       
                        <li>
                            <a href="<?php echo $urlProyecto ?>views/sia/alumnos">
                                <div class="m-0"> <span class="fas fa-user-graduate"></span> <span class="name">Alumnos</span></div>
                                <div class="m-0"><span class="select "></span></div>
                            </a>
                        </li>
                        
                    </ul>
                    <ul class="children">                       
                        <li>
                            <a href="<?php echo $urlProyecto ?>views/sia/certificates">
                                <div class="m-0"> <span class="fas fa-certificate"></span> <span class="name">Certificados</span></div>
                                <div class="m-0"><span class="select "></span></div>
                            </a>
                        </li>
                        
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#" class="activo menu_items">
                        <div class="m-0"> <span class="fas fa-qrcode"></span> <span class="name">Generar QR</span></div>
                        <div class="m-0"><span class="select fas fa-sort-down"></span></div>
                    </a>

                    <ul class="children">                       
                        <li>
                            <a href="<?php echo $urlProyecto ?>views/qr">
                                <div class="m-0"> <span class="fas fa-qrcode"></span> <span class="name">Generar Codigo</span></div>
                                <div class="m-0"><span class="select "></span></div>
                            </a>
                        </li>
                        
                    </ul>
                </li>

            <?php } ?>
        </ul>


    </div>
</div>