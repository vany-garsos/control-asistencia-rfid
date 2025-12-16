<?php



require_once "conexion.php";

class ModeloAlumnos{
    /**Mostrar alumnos */
    static public function mdlMostrarAlumnos($tabla, $item, $campo){
        if ($item != null) {

            $query = Conexion::start()->prepare("SELECT * FROM $tabla WHERE $campo = '$item'"); 
            $query->execute();
            return $query->fetch();
        }else{
            $query = Conexion::start()->prepare("SELECT * FROM $tabla"); 
            $query->execute();
            return $query->fetchAll(PDO::FETCH_OBJ);
        }        

        $query->close();
        $query = null;
    }
    /***
     * CREAR ALUMNOS
     */
    static public function mdIgresarAlumnos($tabla,$parametros){
        $col = implode(', ',array_keys($parametros));
        $valores = ":". implode(', :',array_keys($parametros));  
        $query = Conexion::start()->prepare("INSERT INTO {$tabla} ({$col}) VALUES ({$valores})");
        if ($query->execute($parametros)) {
            return "ok";
            
        }else{
            return "error";
            
        }
        $query->close();
        $query = null;
    }

    /***
     * VERIFICAR SI EL UID O TOKEN PADRE EXISTEN
     */
    static public function mdIVerificarAlumnos($tabla, $parametros){
        $cond = implode(' OR ',array_map(function($col){
            return "{$col} =:{$col}";
        }, array_keys($parametros)));
        
        
        $query = Conexion::start()->prepare("SELECT id FROM {$tabla} WHERE {$cond}");
        //var_dump($query);
     
        if ($query->execute($parametros)) {
          return $query->fetch(PDO::FETCH_ASSOC);
             
        }else{
            return "error";
        }
        $query->close();
        $query=null;
    }
  
}