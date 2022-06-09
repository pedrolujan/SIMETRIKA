
<?php 

	class ApptivaDBPrueba{    
		private $host   ="sql209.epizy.com";
		private $usuario="epiz_28002065";
		private $clave  ="bFYKlaekY6mu2";
		private $db     ="epiz_28002065_bdsimetrika";
		public $conexion;
		public function __construct(){
			$this->conexion = new mysqli($this->host, $this->usuario, $this->clave,$this->db) or die();
			$this->conexion->set_charset("utf8");
			}
	//INSERTAR
    public function insertar($tabla, $datos){
        $resultado =    $this->conexion->query("INSERT INTO $tabla VALUES $datos") or die($this->conexion->error);
          
        if($resultado)
        return true;
    return false;
    } 
    //BORRAR
    public function borrar($tabla, $condicion){    
        $resultado  =   $this->conexion->query("DELETE FROM $tabla WHERE $condicion") or die($this->conexion->error);
       
		if($resultado)
            return true;
        return false;
    }
    //ACTUALIZAR
		
    public function actualizar($tabla, $campos, $condicion){    
        $resultado  =   $this->conexion->query("UPDATE $tabla SET $campos WHERE $condicion") or die($this->conexion->error);
		
        if($resultado)
            return true;
        return false;        
    } 
    //BUSCAR
    public function buscar($tabla, $condicion){
		
        $resultado = $this->conexion->query("SELECT * FROM $tabla WHERE $condicion") or die($this->conexion->error);
       
		if($resultado)
            return $resultado->fetch_all(MYSQLI_ASSOC);
        return false;
    } 
      //BUSCAR carrito
      public function buscarCar($datos,$tabla, $condicion){
		
        $resultado = $this->conexion->query("SELECT $datos FROM $tabla WHERE $condicion") or die($this->conexion->error);
       
		if($resultado)
            return $resultado->fetch_all(MYSQLI_ASSOC);
        return false;
    } 
    //BUSCAR con return simple
    public function buscarFech($datos,$tabla, $condicion){
		
        $resultado = $this->conexion->query("SELECT DISTINCT $datos FROM $tabla WHERE $condicion") or die($this->conexion->error);
       
		if($resultado)
           /*  return $resultado->fetch_all(MYSQLI_ASSOC); */
           return $resultado;
        return false;
    } 
    //otrooo
    public function buscarValiar($tabla, $condicion,$segCond){
		
        $resultado = $this->conexion->query("SELECT * FROM $tabla WHERE $condicion AND $segCond") or die($this->conexion->error);
       
		if($resultado)
            return $resultado->fetch_all(MYSQLI_ASSOC);
        return false;
    } 
    
    //busca todo

    public function buscarTodo($tabla,$orden){		
        $resultado = $this->conexion->query("SELECT * FROM $tabla ORDER BY $tabla.$orden asc") or die($this->conexion->error);
       
		if($resultado)
            return $resultado->fetch_all(MYSQLI_ASSOC);
        return false;
    } 
    
    public function buscarChat($tabla, $condicion,$id){
		
        $resultado = $this->conexion->query("SELECT * FROM $tabla WHERE $condicion ORDER BY $id ASC") or die($this->conexion->error);
       
		if($resultado)
            return $resultado->fetch_all(MYSQLI_ASSOC);
        return false;
    }
    public function buscarContador($datos,$tabla, $condicion){
		
        $resultado = $this->conexion->query("SELECT $datos FROM $tabla WHERE $condicion") or die($this->conexion->error);
       
		if($resultado)
            // return $resultado->fetch_all(MYSQLI_ASSOC);
        return $resultado;
        return false;
    }

    public function buscarGeneral($datos,$tabla, $condicion){
		
        $resultado = $this->conexion->query("SELECT $datos FROM $tabla WHERE $condicion") or die($this->conexion->error);
       
		if($resultado)
            // return $resultado->fetch_all(MYSQLI_ASSOC);
        return $resultado;
        return false;
    }


    
		
	}
?>