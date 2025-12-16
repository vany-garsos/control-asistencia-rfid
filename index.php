<?php

/**
 * CONTROLADORES
 */
require_once "controladores/usuarios.controlador.php";
require_once "controladores/plantilla.controlador.php";
require_once "controladores/alumnos.controlador.php";
require_once "controladores/asistencia.controlador.php";


/**
 * MODELOS
 */

require_once "modelos/usuarios.modelo.php";
require_once "modelos/alumnos.modelo.php";
require_once "modelos/asistencias.modelo.php";

$plantilla = new ControladorPlantilla();

$plantilla -> ctrPlantilla();