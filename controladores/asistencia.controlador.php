<?php
require_once __DIR__ . "/../vendor/autoload.php";

use Google\Client;

class ControladorAsistencias
{
    /**
     * MOSTRAR ASISTENCIAS
     */
    static public function ctrMostrarAsistencias($item, $campo)
    {
        $tabla = 'asistencias';
        $respuesta = ModeloAsistencias::mdlMostrarAsistencias($tabla, $item, $campo);
        return $respuesta;
    }


    /*Buscar alumno en la base de datos por su rfid*/

    static public function ctrBuscarAlumnoRfid($rfid)
    {

        date_default_timezone_set("America/Mexico_City");

        $tabla = 'alumnos';

        $parametros = [
            'rfid' => $rfid
        ];
        //busca el alumno por su rfid
        $alumno = ModeloAsistencias::mdlBuscarAlumnoRfid($tabla, $parametros);

        if (!$alumno) {
            echo "Alumno no encontrado";
        }
        $id_alumno = $alumno['id'];
        $nombre = $alumno['nombre'];
        $padre_token = $alumno['padre_token'];
        $fecha = date("Y-m-d");
        $hora = date("H:i:s");


        $tabla = 'asistencias';
        $parametros = [
            'id_alumno' => $id_alumno,
            'fecha' => $fecha,
        ];

        //vefifica si el alumno tiene registrada una entrada
        $tieneEntrada = ModeloAsistencias::mdlVerificarEntrada($tabla, $parametros);

        if ($tieneEntrada) {
            $tabla = 'asistencias';
            $id = $tieneEntrada['id'];
            $parametros = [
                'id_asistencia' => $id,
                'hora_salida' => $hora
            ];
            //si la tiene, registra una salida
            $registrarSalida = ModeloAsistencias::mdlRegistrarSalida($tabla, $parametros);
            $mensaje = "$nombre ha salido de la escuela.";
        } else {
            $tabla = 'asistencias';

            $parametros = [
                'id_alumno' => $id_alumno,
                'fecha' => $fecha,
                'hora_entrada' => $hora,
            ];
            if (isset($id_alumno) || !empty($id_alumno)) {
                //si no tiene entrada, registra una entrada
                $insertarEntrada = ModeloAsistencias::mdlRegistrarEntrada($tabla, $parametros);
                $mensaje = "$nombre ha ingresado a la escuela.";
            }
        }

        if ($registrarSalida == "ok" || $insertarEntrada == "ok") {
            if (!empty($padre_token)) {
                enviarNotificacion($padre_token, $mensaje);
            }
        }
    }
    /*---------------------FILTROS--------------------------------*/

    /*Buscar alumno por dia*/
    static public function ctrBuscarAlumnoDia()
    {
        if (isset($_POST['fecha']) && !empty($_POST['fecha'])) {
            $tabla = 'asistencias';
            $parametros = [
                'fecha' => $_POST['fecha']
            ];

            $respuesta = ModeloAsistencias::mdlBuscarAlumnoDia($tabla, $parametros);

            if (!$respuesta) {
                echo '<script>
            swal({
                type: "error",
                title: "No hay registros con la fecha seleccionada",
                showConfirmButton: true,
                confirmButtonText: "Cerrar"
                }).then(function(result){
                    if(result.value){
                        window.location ="asistencias";
                     }                        
                });
            </script>';
            } else {
                return $respuesta;
            }
        }
    }

    /*Buscar alumno por mes*/
    static public function ctrBuscarAlumnoMesAnio()
    {
        if (!empty($_POST['mes']) && !empty($_POST['anio'])) {
            $tabla = 'asistencias';
            $mes = (int) $_POST['mes'];
            $anio = (int) $_POST['anio'];

            $respuesta = ModeloAsistencias::mdlBuscarAlumnoMesAnio($tabla, $mes, $anio);

            if (!$respuesta) {
                echo '<script>
                    swal({
                        type: "error",
                        title: "No hay registros para ese mes y año",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                    }).then(function(result){
                        if(result.value){
                            window.location ="asistencias";
                        }                        
                    });
                </script>';
            } else {
                return $respuesta;
            }
        }
    }

    static public function ctrBuscarAlumnoNombre()
    {
        if (isset($_POST['nombre']) && !empty($_POST['nombre'])) {
            $tabla = 'asistencias';
            $nombre = $_POST['nombre'];

            $respuesta = ModeloAsistencias::mdlBuscarAlumnoNombre($tabla, $nombre);

            if (!$respuesta) {
                echo '<script>
                swal({
                    type: "error",
                    title: "No hay asistencias registradas con ese nombre",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"
                }).then(function(result){
                    if(result.value){
                        window.location ="asistencias";
                    }                        
                });
                </script>';
            } else {
                return $respuesta;
            }
        }
    }
    static public function ctrBuscarAlumnoSemana()
    {
        if (!empty($_POST['semana_inicio']) && !empty($_POST['semana_fin'])) {
            $tabla = 'asistencias';
            $inicio = $_POST['semana_inicio'];
            $fin = $_POST['semana_fin'];

            $respuesta = ModeloAsistencias::mdlBuscarAlumnoSemana($tabla, $inicio, $fin);

            if (!$respuesta) {
                echo '<script>
                swal({
                    type: "info",
                    title: "No hay asistencias en esa semana",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"
                }).then(function(result){
                    if(result.value){
                        window.location ="asistencias";
                    }                        
                });
                </script>';
            } else {
                return $respuesta;
            }
        }
    }
}










/*Enviar notificacion*/
function enviarNotificacion($token, $mensaje)
{
    try {
        // Obtener el access token de Firebase
        $client = new Client();
        $client->setAuthConfig(__DIR__ . '/../credenciales/controlasistencia-f71d4-firebase-adminsdk-fbsvc-cadd87a330.json');
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        $client->fetchAccessTokenWithAssertion();
        $accessToken = $client->getAccessToken()['access_token'];

        // Configuracion del mensaje 
        $url = "https://fcm.googleapis.com/v1/projects/919182406180/messages:send";
        $headers = [
            "Authorization: Bearer " . $accessToken,
            "Content-Type: application/json"
        ];

        $fields = [
            "message" => [
                "token" => $token,
                "notification" => [
                    "title" => "Asistencia Registrada",
                    "body" => $mensaje
                ]
            ]
        ];

        //enviar la notificacion
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);

        // Verificar la respuesta de Firebase
        $responseData = json_decode($result, true);
        if (isset($responseData['error'])) {
            throw new Exception("Error en FCM: " . $responseData['error']['message']);
        }

        return "Notificacion enviada correctamente";
    } catch (Exception $e) {
        return "Error al enviar la notificacion: " . $e->getMessage();
    }
}
