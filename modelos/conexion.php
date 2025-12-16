<?php

class Conexion{
    public static function start(){
        try {
            return new PDO('mysql:host=localhost; dbname=final','root','12345678');
        } catch (PDOException $error) {
            die($error->getMessage());
        }
    }
}

