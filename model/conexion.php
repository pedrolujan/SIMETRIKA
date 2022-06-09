
<?php

class ApptivaDB
{
    private $host   = "localhost";
    private $usuario = "root";
    private $clave  = "";
    private $db     = "bdsimetrika";
    public $conexion;
    public function __construct()
    {
        $this->conexion = new mysqli($this->host, $this->usuario, $this->clave, $this->db) or die();
        $this->conexion->set_charset("utf8");
    }
    //INSERTAR
    public function insertar($tabla, $datos)
    {
        $resultado =    $this->conexion->query("INSERT INTO $tabla VALUES $datos") or die($this->conexion->error);

        if ($resultado)
            return true;
        return false;
    }
    public function insertarXselect($insertar, $datAinsertar, $desde, $condicion)
    {
        $resultado =    $this->conexion->query("INSERT INTO $insertar SELECT $datAinsertar FROM $desde  WHERE $condicion") or die($this->conexion->error);

        if ($resultado)
            return true;
        return false;
    }
    public function insertarDatos($tabla, $datos)
    {
        $resultado =    $this->conexion->query("INSERT INTO $tabla VALUES (null,$datos)") or die($this->conexion->error);

        if ($resultado)
            return true;
        return false;
    }
    //BORRAR
    public function borrar($tabla, $condicion)
    {
        $resultado  =   $this->conexion->query("DELETE FROM $tabla WHERE $condicion") or die($this->conexion->error);

        if ($resultado)
            return true;
        return false;
    }
    //ACTUALIZAR

    public function actualizar($tabla, $campos, $condicion)
    {
        $resultado  =   $this->conexion->query("UPDATE $tabla SET $campos WHERE $condicion") or die($this->conexion->error);

        if ($resultado)
            return true;
        return false;
    }
    public function actualizar_ConInner($tabla, $campos,$Union, $condicion)
    {
        $resultado  =   $this->conexion->query("UPDATE $tabla SET $campos FROM $Union WHERE $condicion") or die($this->conexion->error);

        if ($resultado)
            return true;
        return false;
    }
    //BUSCAR

    public function EjecutarProcedimiento($usp, $valores)
    {

        $resultado = $this->conexion->query("CALL $usp($valores)") or die($this->conexion->error);

        if ($resultado){
            return true;
        }else{

            return false;
        }
            // return $resultado->fetch_all(MYSQLI_ASSOC);
    }
    public function EjecutarProcedimientosAlmacenados($usp, $valores)
    {

        $resultado = $this->conexion->query("CALL $usp($valores)") or die($this->conexion->error);

        if ($resultado){
            return $resultado->fetch_all(MYSQLI_ASSOC);
        }else{

            return false;
        }
            // return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function buscar($tabla, $condicion)
    {

        $resultado = $this->conexion->query("SELECT * FROM $tabla WHERE $condicion") or die($this->conexion->error);

        if ($resultado)
            return $resultado->fetch_all(MYSQLI_ASSOC);
        return false;
    }
    //BUSCAR carrito
    public function buscarCar($datos, $tabla, $condicion)
    {

        $resultado = $this->conexion->query("SELECT $datos FROM $tabla WHERE $condicion") or die($this->conexion->error);

        if ($resultado)
            return $resultado->fetch_all(MYSQLI_ASSOC);
        return false;
    }
    //BUSCAR con return simple
    public function buscarFech($datos, $tabla, $condicion)
    {

        $resultado = $this->conexion->query("SELECT DISTINCT $datos FROM $tabla WHERE $condicion") or die($this->conexion->error);

        if ($resultado){

            return $resultado;
        }else{

            return false;
        }
            // $resultado->fetch_all(MYSQLI_ASSOC);
    }
    //otrooo
    public function buscarValiar($tabla, $condicion, $segCond)
    {

        $resultado = $this->conexion->query("SELECT * FROM $tabla WHERE $condicion AND $segCond") or die($this->conexion->error);

        if ($resultado)
            return $resultado->fetch_all(MYSQLI_ASSOC);
        return false;
    }

    //busca todo

    public function buscarTodo($tabla, $orden)
    {
        $resultado = $this->conexion->query("SELECT * FROM $tabla ORDER BY $tabla.$orden asc") or die($this->conexion->error);

        if ($resultado)
            return $resultado->fetch_all(MYSQLI_ASSOC);
        return false;
    }

    public function buscarChat($tabla, $condicion, $id)
    {

        $resultado = $this->conexion->query("SELECT * FROM $tabla WHERE $condicion ORDER BY $id ASC") or die($this->conexion->error);

        if ($resultado)
            return $resultado->fetch_all(MYSQLI_ASSOC);
        return false;
    }
    public function buscarContador($datos, $tabla, $condicion)
    {

        $resultado = $this->conexion->query("SELECT $datos FROM $tabla WHERE $condicion") or die($this->conexion->error);

        if ($resultado)
            // return $resultado->fetch_all(MYSQLI_ASSOC);
            return $resultado;
        return false;
    }

    public function buscarGeneral($datos, $tabla, $condicion)
    {

        $resultado = $this->conexion->query("SELECT $datos FROM $tabla WHERE $condicion") or die($this->conexion->error);

        if ($resultado)
            // return $resultado->fetch_all(MYSQLI_ASSOC);
            return $resultado;
        return false;
    }

    public function buscarConsultas($datos,$tabla, $condicion)
    {

        $resultado = $this->conexion->query("SELECT $datos FROM $tabla WHERE $condicion") or die($this->conexion->error);

        if ($resultado)
            return $resultado->fetch_all(MYSQLI_ASSOC);
        return false;
    }



    // debolver fechas

    public function fnObtenePrmtFecha($fecha,$opcion){
        $fechaComoEntero = strtotime($fecha);
       return date($opcion, $fechaComoEntero);
    }
    public function fnConvertirFechas($mes){
        switch ($mes) {
        
            case $mes=="01":
              $mes="Enero";
                break;
            case $mes=="02":
              $mes="Febrero";
                break;
            case $mes==03:
              $mes="Marzo";
                break;
            case $mes=="04":
              $mes="Abril";
                break;
            case $mes=="05":
              $mes="Mayo";
                break;
            case $mes=="06":
              $mes="Junio";
                break;
            case $mes=="07":
              $mes="Julio";
                break;
            case $mes=="08":
              $mes="Agosto";
                break;
            case $mes=="09":
              $mes="Setiembre";
                break;
            case $mes=="10":
              $mes="Octubre";
                break;
            case $mes=="11":
              $mes="Noviembre";
                break;
            case $mes=="12":
              $mes="Diciembre";
                break;
            
           
        }
        return $mes;
    }
    
}
?>