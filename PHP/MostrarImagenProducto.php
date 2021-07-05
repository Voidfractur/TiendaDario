<?php 
require_once "Producto.php";

$producto = new Producto();
$consul = $producto->getProducto($_GET['id']);
if($consul->num_rows>0) {
    $ren = $consul->fetch_array(MYSQLI_ASSOC);
    header("Content-type:".$ren["img_tipo"]);
    echo $ren["img_contenido"];
}