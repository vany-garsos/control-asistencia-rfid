<?php

//el metodo POST para que cree un archivo temporal de los datos que vienen de arduino
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["rfid"])) {
    file_put_contents("rfid.txt", $_POST["rfid"]);
    echo "UID recibido: " . $_POST["rfid"];
    exit();

    //el metoodo GET para que el ajax del js que obtiene el archivo temporal
} else if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if(file_exists("rfid.txt")){
        echo file_get_contents("rfid.txt");
    }else{
        echo "No hay UID almacenado";
    }
    exit();
} 

