package com.example.controlasistencianotificaciones;

import android.content.Context;
import android.util.Log;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import java.util.HashMap;
import java.util.Map;

public class DeviceManager {
    //url del servidor para registrar dispositivo
    private static final String URL_REGISTRO = "http://192.168.1.166/controlasistencia/vistas/modulos/recibirToken.php";


    //funcion para enviar el padre_token al servidor
    public static void enviarToken(Context context, String token, String id) {
        if (token == null || token.isEmpty()) {
            Log.e("Volley", "El token es nulo o vacío, no se enviara la solicitud");
            return;
        }
//cola de solicitudes http usando la libreria VOLEY
        RequestQueue queue = Volley.newRequestQueue(context);
//creacion de la solicitud POST
        StringRequest request = new StringRequest(Request.Method.POST, URL_REGISTRO,
                new Response.Listener<String>() {
            //respuesta del servidor
                    @Override
                    public void onResponse(String response) {
                        Log.d("Volley", "Respuesta del servidor: " + response);
                    }
                },
                new Response.ErrorListener() {
            //respuesta edn caso de errores
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Log.e("Volley", "Error en la solicitud: " + error.toString());
                    }
                }) {
            //envio de parametros
            @Override
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<>();
                params.put("padre_token", token); // Asegurar que se envía correctamente
                if (id != null) {
                    params.put("id", id);
                }

                Log.d("Volley", "Enviando datos: " + params.toString());
                return params;
            }
        };
//agregar solicitud a la cola
        queue.add(request);
    }
}
