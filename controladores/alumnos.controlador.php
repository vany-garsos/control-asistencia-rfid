<?php

class ControladorAlumnos
{
    /**
     * MOSTRAR ALUMNOS
     */
    static public function ctrMostrarAlumnos($item, $campo)
    {
        $tabla = 'alumnos';

        $respuesta = ModeloAlumnos::mdlMostrarAlumnos($tabla, $item, $campo);
        return $respuesta;
    }
    /**
     * CREAR ALUMNOS
     */
    static public function ctrCrearAlumnos()
    {
        //   $validos = "/^[a-z]+$/";

        if (isset($_POST["nombre"])) {
            if (
                !empty($_POST['nombre'] && !empty($_POST['grupo']) &&
                    !empty($_POST['rfid']) &&  !empty($_POST['padre_token']))
            ) {
                $id = $_POST['id']  ?? NULL;
                                
                if ($id == NULL) {
                    
                    $tabla = 'alumnos';
                    $parametros = [ 
                        'rfid' => $_POST['rfid'],
                        'padre_token' => $_POST['padre_token']
                     ];
               
                    $respuesta = ModeloAlumnos::mdIVerificarAlumnos($tabla, $parametros);
                 
                     
                    if ($respuesta) {
                        echo '<script>
                        swal({
                            type: "error",
                            title: "El UID o el token ya estan registrados",
                            showConfirmButton: true,
                            confirmButtonText: "Cerrar"
                            }).then(function(result){
                                if(result.value){
                                    window.location ="alumnos";
                                 }                        
                            });
                        </script>';
                    }else {
                        $tabla = 'alumnos';
    
                        $parametros = [
                            'nombre' => $_POST['nombre'],
                            'grupo' => $_POST['grupo'],
                            'rfid' => $_POST['rfid'],
                            'padre_token' => $_POST['padre_token'],
                        ];
    
    
                        $respuesta =  ModeloAlumnos::mdIgresarAlumnos($tabla, $parametros);
                        if ($respuesta == "ok") {
                            echo '<script>
                            swal({
                                type: "success",
                                title: "Alumno Guardado correctamente",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar"
                                }).then(function(result){
                                    if(result.value){
                                        window.location ="alumnos";
                                     }                        
                                });
                            </script>';
                        } else {
                            echo '<script>
                            swal({
                                type: "error",
                                title: "El alumno no se guardo",
                                showConfirmButton: true,
                                confirmButtonText: "Cerrar"
                                }).then(function(result){
                                    if(result.value){
                                        window.location ="alumnos";
                                     }                        
                                });
                            </script>';
                        }
                    }
                   
                } 

            } else {
                echo '<script>
                    swal({
                        type: "error",
                        title: "No se admiten campos vacios",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"
                        }).then(function(result){
                            if(result.value){
                                window.location ="alumnos";
                             }                        
                        });
                    </script>';
            }
        }
    }
}

