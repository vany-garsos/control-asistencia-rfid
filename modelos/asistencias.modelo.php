<?php

require_once "conexion.php";

class ModeloAsistencias
{
    /** Mostrar asistencias junto con el nombre del alumno */
    static public function mdlMostrarAsistencias($tabla, $item, $campo)
    {
        if ($item != null && $campo != null) {
            $query = Conexion::start()->prepare("
            SELECT a.*, al.nombre 
            FROM $tabla a
            INNER JOIN alumnos al ON a.id_alumno = al.id
            WHERE a.$campo = :valor
        ");
            $query->bindParam(":valor", $item, PDO::PARAM_STR);
            $query->execute();
            return $query->fetch(PDO::FETCH_OBJ);
        } else {
            $query = Conexion::start()->prepare("
            SELECT a.*, al.nombre 
            FROM $tabla a
            INNER JOIN alumnos al ON a.id_alumno = al.id
            ORDER BY a.fecha ASC
        ");
            $query->execute();
            return $query->fetchAll(PDO::FETCH_OBJ);
        }

        $query->close();
        $query = null;
    }

    /**Buscar alumno en la base de datos por rfid*/
    static public function mdlBuscarAlumnoRfid($tabla, $parametros)
    {
        $cond = implode(array_map(function ($col) {
            return "{$col} =:{$col}";
        }, array_keys($parametros)));


        $query = Conexion::start()->prepare("SELECT id, nombre, padre_token FROM {$tabla} WHERE {$cond}");

        if ($query->execute($parametros)) {
            return $query->fetch(PDO::FETCH_ASSOC);
        } else {
            return "error";
        }
        $query->close();
        $query = null;
    }

    /**Verificar si el alumno ya tiene una entrada hoy*/
    static public function mdlVerificarEntrada($tabla, $parametros)
    {
        $cond = implode(' AND ', array_map(function ($col) {
            return "{$col} =:{$col}";
        }, array_keys($parametros)));

        $query = Conexion::start()->prepare("SELECT id, hora_entrada FROM {$tabla} WHERE {$cond}");

        if ($query->execute($parametros)) {
            return $query->fetch(PDO::FETCH_ASSOC);
        } else {
            return "error";
        }
        $query->close();
        $query = null;
    }
    /**Registrar una salida*/
    static public function mdlRegistrarSalida($tabla, $parametros)
    {

        $query = Conexion::start()->prepare("UPDATE {$tabla} SET hora_salida = :hora_salida WHERE id = :id_asistencia");

        if ($query->execute($parametros)) {
            return "ok";
        } else {
            return "error";
        }
        $query->close();
        $query = null;
    }
    /**Registrar una entrada*/
    static public function mdlRegistrarEntrada($tabla, $parametros)
    {
        $col = implode(', ', array_keys($parametros));
        $valores = ":" . implode(', :', array_keys($parametros));
        $query = Conexion::start()->prepare("INSERT INTO {$tabla} ({$col}) VALUES ({$valores})");
        if ($query->execute($parametros)) {
            return "ok";
        } else {
            return "error";
        }
        $query->close();
        $query = null;
    }
    /**Buscar informacion del alumno filtrando por dia*/
    static public function mdlBuscarAlumnoDia($tabla, $parametros)
    {
        $query = Conexion::start()->prepare("
            SELECT a.*, al.nombre 
            FROM {$tabla} a 
            INNER JOIN alumnos al ON a.id_alumno = al.id 
            WHERE a.fecha = :fecha
        ");

        if ($query->execute($parametros)) {
            return $query->fetchAll(PDO::FETCH_OBJ);
        } else {
            return "error";
        }

        $query->close();
        $query = null;
    }

    /**Filtrar busqueda por mes*/
    static public function mdlBuscarAlumnoMesAnio($tabla, $mes, $anio)
    {
        $query = Conexion::start()->prepare("
            SELECT a.*, al.nombre 
            FROM {$tabla} a
            INNER JOIN alumnos al ON a.id_alumno = al.id
            WHERE MONTH(a.fecha) = :mes AND YEAR(a.fecha) = :anio
        ");

        $query->bindParam(":mes", $mes, PDO::PARAM_INT);
        $query->bindParam(":anio", $anio, PDO::PARAM_INT);

        if ($query->execute()) {
            return $query->fetchAll(PDO::FETCH_OBJ);
        } else {
            return "error";
        }

        $query->close();
        $query = null;
    }

    static public function mdlBuscarAlumnoNombre($tabla, $nombre)
    {
        $query = Conexion::start()->prepare("
            SELECT a.*, al.nombre 
            FROM {$tabla} a
            INNER JOIN alumnos al ON a.id_alumno = al.id
            WHERE al.nombre LIKE :nombre
        ");

        $nombre = "%$nombre%"; // Búsqueda parcial
        $query->bindParam(':nombre', $nombre, PDO::PARAM_STR);

        if ($query->execute()) {
            return $query->fetchAll(PDO::FETCH_OBJ);
        } else {
            return "error";
        }

        $query->close();
        $query = null;
    }
    static public function mdlBuscarAlumnoSemana($tabla, $inicio, $fin)
    {
        $query = Conexion::start()->prepare("
            SELECT a.*, al.nombre 
            FROM {$tabla} a
            INNER JOIN alumnos al ON a.id_alumno = al.id
            WHERE a.fecha BETWEEN :inicio AND :fin
        ");

        $query->bindParam(':inicio', $inicio);
        $query->bindParam(':fin', $fin);

        if ($query->execute()) {
            return $query->fetchAll(PDO::FETCH_OBJ);
        } else {
            return "error";
        }

        $query->close();
        $query = null;
    }
}
