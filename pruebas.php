<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado</title>
    <link rel="stylesheet" href="CSS/bootstrap.min.css">
</head>

<body>
    <div class="col-12 ">
        <p>Ingrese Url</p>
       <input type="text" class="form-control col-5" name="txtUrl" id="txtUrl" placeholder="Ingrese urlA acortar"> 
       
    </div>
    <div class="col-12 p-3">
        <button id="btnDescargar" class="btn btn-outline-info "> descargar</button>
    </div>
    <div id="contendebolver">

    </div>
    <script src="JS/jquery-3.6.0.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script> -->
    <script src="scripPruebas.js"></script>
  
<?php
// echo '<a href="pruebas1.php?'.generaURLSegura("id","12345").'">Enviar datos</a>';
// function generaURLSegura ($metodo, $valor)
// {
//   return $metodo . "=" . base64_encode ($valor);
// }
?>
    
</body>

</html>