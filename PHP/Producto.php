<?php
require_once("Conexion.lib.php");
class Producto
{

    private $cnn;
    public function __construct()
    {
        $this->cnn = conexion();
    }

    public function getProductos()
    {
        return $this->cnn->query("SELECT * FROM tiendita.producto WHERE `status_pro` = 1");
    }

    public function addProducto($codigo_pro, $nombre_pro, $stock_max, $stock_min, $cantidad, $img_contenido, $img_tipo, $precio_pro)
    {
        return $this->cnn->query("INSERT INTO `tiendita`.`producto` (`codigo_pro`, `nombre_pro`, `stock_max`, `stock_min`, `status_pro`, `cantidad`, `img_contenido`,`img_tipo`, `precio_pro`) VALUES ('$codigo_pro','$nombre_pro', '$stock_max', '$stock_min', '1', '$cantidad', '$img_contenido','$img_tipo', '$precio_pro')
        ");
    }

    public function getProducto($id_pro)
    {
        return $this->cnn->query("SELECT * FROM tiendita.producto where id_pro=$id_pro");
    }

    public function bajaProducto($id_pro)
    {
        return $this->cnn->query("UPDATE `tiendita`.`producto` SET `status_pro` = '0' WHERE (`id_pro` = '$id_pro');");
    }
    public function delProducto($id_pro)
    {
        return $this->cnn->query("DELETE FROM `tiendita`.`producto` WHERE (`id_pro` = '$id_pro')");
    }
    public function updateProductoWithImage($id_pro, $codigo_pro, $nombre_pro, $stock_max, $stock_min, $cantidad, $img_contenido, $img_tipo, $precio_pro)
    {
        return $this->cnn->query("UPDATE `tiendita`.`producto` SET `codigo_pro` = '$codigo_pro', `nombre_pro` = '$nombre_pro', `stock_max` = '$stock_max', `stock_min` = '$stock_min', `cantidad` = '$cantidad',`img_contenido` = '$img_contenido', `img_tipo` = '$img_tipo', `precio_pro` = '$precio_pro' WHERE (`id_pro` = '$id_pro');
    ");
    }

    public function updateProductoWithoutImage($id_pro, $codigo_pro, $nombre_pro, $stock_max, $stock_min, $cantidad, $precio_pro)
    {
        return $this->cnn->query("UPDATE `tiendita`.`producto` SET `codigo_pro` = '$codigo_pro', `nombre_pro` = '$nombre_pro', `stock_max` = '$stock_max', `stock_min` = '$stock_min', `cantidad` = '$cantidad', `precio_pro` = '$precio_pro' WHERE (`id_pro` = '$id_pro');
    ");
    }
}
