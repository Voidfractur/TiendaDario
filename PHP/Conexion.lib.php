<?php
function conexion(){
    $cnn = new mysqli("localhost", "root", "", "tiendita");
    
    if(mysqli_connect_errno()) {
        exit();
        return NULL;
    }
    else { return $cnn; }
}