<?php
session_start();
include("../../model/url.php");

// if(isset($_SESSION["adminLogeado"]) || isset($_SESSION["supervisorLogeado"]) || isset($_SESSION["asistenteLogeado"])){

//     header("Location:".$urlProyecto."");
// }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Simetrika Login</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $urlProyecto?>CSS/estilos_login.css">
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<img class="wave" src="img/fondoLateral.png">
	<div class="infoEmpresa">
		<img src="img/logoBlanco.png" alt="" srcset="">
		<h2>SERVICIO DE CONSULTORIA</h2>
		<p>Cumple tus sueños</p>
		<p>○○○</p>
	</div>
	<div class="container">
		<div class="img">
			<img src="img/temaLogin.svg">
			
		</div>
		<div class="login-content">
			<form action="#" id="formularioLogeo">
				<img src="img/avatar.svg">
				<h2 class="title">Simetrika</h2>
           		<div class="input-div one">
           		   <div class="i">
           		   		<i class="fas fa-user"></i>
           		   </div>
           		   <div class="div">
           		   		<span>Usuario</span>
           		   		<input type="text" name="txtUsuario" class="input">
           		   </div>
           		</div>
           		<div class="input-div pass">
           		   <div class="i"> 
           		    	<i class="fas fa-lock"></i>
           		   </div>
           		   <div class="div">
           		    	<span>Contraseña</span>
           		    	<input type="password" name="txtClave" class="input">
            	   </div>
            	</div>
            	<a href="#">Olvidaste tu contraseña</a>
            	<input type="submit" class="btn" id="btnAcceder" value="Acceder">
				<div class="msj" id="msj"></div>
			</form>
        </div>
    </div>
    <script type="text/javascript" src="<?php echo $urlProyecto ?>JS/jquery-3.5.1.min.js"></script>
    <script type="module" src="<?php echo $urlProyecto ?>JS/scrip_login.js?357"></script>
</body>
</html>
