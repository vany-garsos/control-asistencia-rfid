package com.example.controlasistencianotificaciones;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;

import android.os.Bundle;
import android.util.Log;
import android.widget.TextView;
import android.widget.Toast;

import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.Task;
import com.google.firebase.messaging.FirebaseMessaging;


public class MainActivity extends AppCompatActivity {

    private static final String TAG = "MainActivity";

    private TextView tv1;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        // Llamar a la funcion para registrar el dispositivo
        RegistrarDispositivo();
    }
    //Recuperar token del dispositivo
    public void RegistrarDispositivo() {
        //codigo de la documentacion de FireBase
        FirebaseMessaging.getInstance().getToken()
                .addOnCompleteListener(new OnCompleteListener<String>() {
                    @Override
                    public void onComplete(@NonNull Task<String> task) {
                        if (!task.isSuccessful()) {
                            Log.w(TAG, "Fetching FCM registration token failed", task.getException());
                            return;
                        }

                        // Obtener el token de registro FCM
                        String token = task.getResult();

                        //log y toast con el token
                        Log.d(TAG, "Token FCM: " + token);
                        Toast.makeText(MainActivity.this, "Token: " + token, Toast.LENGTH_LONG).show();

                        // Enviar el token al servidor
                        DeviceManager.enviarToken(MainActivity.this, token, null);
                    }
                });
    }

}
