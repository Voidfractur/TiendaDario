<?php
require_once("Conexion.lib.php");
class Producto {

    private $cnn;
    public function __construct() {
        $this->cnn = conexion();
    }

    public function getProductos()
    {
        return $this->cnn->query("SELECT * FROM tiendita.producto WHERE `status_pro` = 1");
    }

    public function addProducto($codigo_pro,$nombre_pro,$stock_max,$stock_min,$cantidad,$img_ruta,$precio_pro){
        return $this->cnn->query("INSERT INTO `tiendita`.`producto` (`codigo_pro`, `nombre_pro`, `stock_max`, `stock_min`, `status_pro`, `cantidad`, `img_ruta`, `precio_pro`) VALUES ('$codigo_pro','$nombre_pro', '$stock_max', '$stock_min', '1', '$cantidad', '$img_ruta', '$precio_pro')
        ");
    }

    public function getProducto($id_pro)
    {
        return $this->cnn->query("SELECT * FROM tiendita.producto where id_pro=$id_pro");
    }

    public function delProducto($id_pro)
    {
        return $this->cnn->query("UPDATE `tiendita`.`producto` SET `status_pro` = '0' WHERE (`id_pro` = '$id_pro');");
    }
}