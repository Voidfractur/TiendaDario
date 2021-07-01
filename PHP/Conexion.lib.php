<?php
function conexion(){
    $cnn = new mysqli("localhost", "root", "17650010", "tiendita");
    
    if(mysqli_connect_errno()) {
        exit();
        return NULL;
    }
    else { return $cnn; }
}