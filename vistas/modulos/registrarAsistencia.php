<?php
require_once "../../controladores/asistencia.controlador.php";
require_once"../../modelos/asistencias.modelo.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rfid = $_POST["rfid"];

    if (empty($rfid)) {
        echo "no hay rfid";
    }

    $respuesta = ControladorAsistencias::ctrBuscarAlumnoRfid($rfid);
  //  var_dump($respuesta);

   
}
 