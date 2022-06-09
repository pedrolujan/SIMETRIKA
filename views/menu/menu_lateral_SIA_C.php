<?php
error_reporting(0);
include("model/url.php");

?>
<input type="checkbox" name="" id="nav-toggle" checked>
<div class="sidebar">

    <div class="sidebar-menu">
        <ul class="itemsMenu">
            <?php
            if (isset($_SESSION['adminLogeado']) || isset($_SESSION["supervisorLogeado"])) {
            ?>
                <li>
                    <a href="../../" class="menu_items item-inicio">
                        <span class="fas fa-tachometer-alt"></span> <span>Inicio</span>
                    </a>
                </li>
                <li>
                    <a href="../personal" id="item-personal" class="menu_items item-personal">
                        <span class="fas fa-users-cog"></span> <span>Personal</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="activo menu_items">
                        <span class="fas fa-users"></span> <span>Seguimiemto</span>
                    </a>
                </li>

            <?php } elseif (isset($_SESSION["asistenteLogeado"])) { ?>

                <li>
                    <a href="../../" class="menu_items item-inicio">
                        <span class="fas fa-tachometer-alt"></span> <span>Inicio</span>
                    </a>
                </li>
                <li>
                    <a href="../prospectos/" class="menu_items">
                        <span class="fas fa-users"></span> <span>Seguimiemto</span>
                    </a>
                </li>
                <li>
                    <a href="../ventas" class="menu_items">
                        <span class="fas fa-hand-holding-usd"></span> <span>Ventas</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="menu_items">
                        <span class="far fa-chart-bar"></span> <span>Consultar Ventas</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="menu_items">
                        <span class="far fa-user"></span> <span>Consultar Alumnos</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="activo menu_items">
                        <span class="far fa-bookmark"></span> <span>Consultar Cursos</span>
                    </a>
                </li>
            <?php } ?>
        </ul>


    </div>
</div>