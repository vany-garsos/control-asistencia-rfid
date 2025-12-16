// funcion que trae los datos de recibirUID 
function escanear(){
    fetch('vistas/modulos/recibirUID.php') 
    .then(res => res.text())
    .then(uid => {
        let rfid = document.getElementById("rfid");
        if(!uid || uid==="No hay UID almacenado"){
           return;
        }else{
            rfid.value=uid;       
        }
        
    });
}

// funcion que trae los datos del token (recibirToken)
function recibirPadreToken(){
    fetch('vistas/modulos/recibirToken.php') 
    .then(res => res.text())
    .then(token => {
        let token_padre = document.getElementById("padre_token");
        if (!token || token==="No hay token almacenado") {
            return;
        }else{
            token_padre.value=token;
        }
    });
    
}

setInterval(escanear, 5000);
setInterval(recibirPadreToken, 5000);




