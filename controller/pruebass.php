<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../CSS/bootstrap.min.css">
</head>

<body>
    <form action="" method="post">
        <input type="text" class="form-control col-2 m-3" name="txtLongitud" id="txtLongitud">

        <input type="submit" class="m-3 btn btn-success" name="btnCalcular" value="Calcular">
        
    </form>

</body>

</html>

<?php
if(isset($_POST["btnCalcular"])){
    $lobgitud=$_POST["txtLongitud"];
$n1 = -1;
$n2 = 1;
for ($i = 0; $i < $lobgitud; $i++) {

    $n3 = $n2 + $n1;
    echo $n3 . ', ';
    $n1 = $n2;
    $n2 = $n3;
}
}

?>