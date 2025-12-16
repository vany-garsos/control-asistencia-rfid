<?php

//el metodo POST para que cree un archivo temporal de los datos que vienen de arduino
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["padre_token"])) {
    file_put_contents("padre_token.txt", $_POST["padre_token"]);
    echo "Token recibido: " . $_POST["padre_token"];
    exit();

    //el metoodo GET para que el ajax del js que obtiene el archivo temporal
} else if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if(file_exists("padre_token.txt")){
        echo file_get_contents("padre_token.txt");
    }else{
        echo "No hay token almacenado";
    }
    exit();
}
