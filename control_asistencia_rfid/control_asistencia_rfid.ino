#include <SPI.h> // Libreria SPI
#include <HTTPClient.h> //Liberia para conexion con el servidor
#include <MFRC522.h> // Libreria para el lector RFID
#include <WiFi.h> // Libreria para utilizar el modulo wifi del esp32
#include <Wire.h> // Libreria para pantalla LCD 16x2
#include <LiquidCrystal_PCF8574.h>


/*=====Definir las credenciales del modem=====*/
#define nombreSSID "Vitoi"
#define password "FamGarciaSosa"


const int RST_PIN = 22;          // pin reset
const int SS_PIN = 2;         // pin slave select
const int BUZZER = 5;         // pin buzzer

MFRC522 mfrc522(SS_PIN, RST_PIN);  // Crear objeto mfrc522 enviando los pines
LiquidCrystal_PCF8574 pantalla (0x27);


void setup() {
  Serial.begin(115200);
  /*=====Configuraciones para el RFID=====*/
  SPI.begin();      // Iniciar SPI
  mfrc522.PCD_Init();   // Iniciar el modulo lector

  /*=====Configuraciones para la conexion WiFi=====*/
  WiFi.begin(nombreSSID, password);
  Serial.println("Conectando al WIFI");
  while (WiFi.status() != WL_CONNECTED) {
    Serial.print(".");
    delay(300);
  }
  Serial.println();
  Serial.println("Conectado al WIFI");
  Serial.println("Conectado con la IP");
  Serial.println(WiFi.localIP());

  /*=====Configuraciones para el buzzer=====*/
  pinMode(BUZZER, OUTPUT);

  /*=====Configuraciones para la pantalla LCD=====*/
  Wire.begin(21, 4); //configurar PIN21 para SDA y PIN4 para SLC
  pantalla.begin(16, 2);
  pantalla.setBacklight(180);
  pantalla.setCursor(0, 0);
  pantalla.print("ESCANEE SU");
  pantalla.setCursor(0, 1);
  pantalla.print("TARJETA");
}

void loop() {

  // si no hay una tarjeta, retorna al loop
  if ( ! mfrc522.PICC_IsNewCardPresent()) {
    return;
  }

  // si no lee los datos de la tarjeta, retorna esperando otra tarjeta
  if ( ! mfrc522.PICC_ReadCardSerial()) {
    return;
  } else {
    mostrarMensaje();
  }

  String rfid = ""; // declarar para almacenar uid convertido en String para pasarlo al Servidor
  //convertir uid en string
  for (byte i = 0; i < mfrc522.uid.size; i++) {
    rfid += String(mfrc522.uid.uidByte[i], HEX);
  }

  Serial.println ("UID ES: " + rfid);
  String urlRegistrarUid = "http://192.168.1.166/controlasistencia/vistas/modulos/recibirUID.php";
  String urlRegistrarAsistencia = "http://192.168.1.166/controlasistencia/vistas/modulos/registrarAsistencia.php";

  Serial.print(urlRegistrarAsistencia);
  //llaamar a la funcion para enviar rfid al servidor con la url dependiendo si se guarda o se registra asistencia
  enviarAsistencia(rfid, urlRegistrarUid);
  enviarAsistencia(rfid, urlRegistrarAsistencia);
}



//funcion para enviar el rfid al servidor

void enviarAsistencia(String rfid, String url) {
  if (WiFi.status() == WL_CONNECTED) {

    HTTPClient http; // variable para usar libreria;
    String datos_a_enviar = "rfid=" + rfid;

    //Serial.println("Enviando datos: " + datos_a_enviar);
    http.begin(url); //indicamos la URL del servidor destino
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");

    int codigo_respuesta = http.POST(datos_a_enviar);

    if (codigo_respuesta > 0) {
      Serial.println("CODIGO HTTP " + String(codigo_respuesta));

      if (codigo_respuesta == 200) {
        String cuerpo_respuestra = http.getString();
        Serial.println("el servidor respondio " + cuerpo_respuestra);
      } else {
        Serial.println("ERRIR el servidor NO respondio");
      }
    } else {
      Serial.println("no hay conexion con el servidor");
    }
    http.end();
    mfrc522.PICC_HaltA(); //Indica a la tarjeta que finaliza la comunicacio


  }
}



//funcion para sonar buzzer y mostrar mensajes en la pantalla LCD

void mostrarMensaje(){
    pantalla.clear();
    pantalla.setCursor(0, 0);
    pantalla.print("REGISTRO");
    pantalla.setCursor(0, 1);
    pantalla.print("EXITOSO");
    digitalWrite(BUZZER, HIGH);
    delay(500);
    digitalWrite(BUZZER, LOW);
    delay(4000);
    pantalla.clear();
    pantalla.setCursor(0, 0);
    pantalla.print("ESCANEE SU");
    pantalla.setCursor(0, 1);
    pantalla.print("TARJETA");
}
