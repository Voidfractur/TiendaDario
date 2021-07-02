<?php
require_once 'Conexion.lib.php';
$cnn = conexion();
if(isset($_POST['signin'])) {
    
}

if(isset($_POST['nuevoUsuario'])) {
    require_once 'Persona.php';
    $per = new Persona();
    $per->setNombre($_POST['nombre']);
    $per->setPaterno($_POST['paterno']);
    $per->setMaterno($_POST['materno']);
    $per->setSexo($_POST['sexo']);
    $per->setTelefono($_POST['telefono']);
    $per->setCorreo($_POST['correo']);
    $tipo = "";
    if ($_FILES["fotoPerfil"]["tmp_name"] != "") {
        $archivo = $_FILES["fotoPerfil"]["tmp_name"];
        $tipo = $_FILES["fotoPerfil"]["type"];
        $tam = $_FILES['fotoPerfil']["size"];

        $fp = fopen($archivo, "rb");
        $contenido = fread($fp, $tam);
        fclose($fp);
        $contenido = addslashes($contenido);
        $per->setFotoPerfil($contenido);
    }
    $persona = $cnn->query(" INSERT INTO persona values(null,'". $per->getPaterno(). "','".$per->getMaterno(). "','".$per->getNombre(). "','".$per->getSexo(). "',".$per->getTelefono(). ",'".$per->getCorreo(). "','". $per->getFotoPerfil(). "', '". $tipo ."')");
    echo $persona;
}