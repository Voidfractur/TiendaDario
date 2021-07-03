<?php 
require_once "Conexion.lib.php";

$cnn = conexion();
$consul = $cnn->query("SELECT * FROM persona WHERE id_per = '".$_GET['id']."'");
if($consul->num_rows>0) {
    $ren = $consul->fetch_array(MYSQLI_ASSOC);
    header("Content-type:".$ren["tipoarchivo_per"]);
    echo $ren["foto_per"];
}