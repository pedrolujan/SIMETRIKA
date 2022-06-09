<?php
$datos=$_POST["datos"];
// $str = $_POST["color"];;
// $Color= ltrim ($str,'#');
$devolver='http://api.qrserver.com/v1/create-qr-code/?color=000000&amp;bgcolor=FFFFFF&amp;data='.$datos.'&qzone=1&amp;margin=0&amp;size=100x100&amp;ecc=L';
echo $devolver;