<?php
// session_start();
include("../../model/url.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Views</title>
    <link rel="stylesheet" href="<?php echo $urlProyecto ?>CSS/bootstrap.min.css">
</head>

<body>
    <?php
    if (!isset($_SESSION)) { ?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 p-5" style="background: rgb(123,48,144);">
           <h2 class="c-red" style="color: #fff; text-align: center;">Usted no tiene permisos para esta seccion</h2>
        </div>
    <?php }

    ?>
</body>

</html>