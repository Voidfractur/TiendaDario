<?php
require_once 'Conexion.lib.php';
require_once 'Interfaz.php';
if(isset($_SESSION['autenticacion']) && $_SESSION['autenticacion'] == 1) {
    echo $sistema;
    return;
}
$sistema = "";
$cnn = conexion();

if(isset($_POST['mostrarLogin'])) {
    echo mostrarLogin();
}

if(isset($_POST['signin'])) {
    $login = $cnn->query("SELECT * FROM empleado WHERE usuario_emp = '". $_POST['username'] ."' AND contrasenia_emp = '". $_POST['password']. "'");
    if($login->num_rows > 0) {
        echo menu($login);
    }
    else {
        echo "Nombre de usuario o contraseña incorrectos";
    }
}

//CREACIÓN DE UN NUEVO EMPLEADO
if(isset($_POST['nuevoUsuario'])) {
    require_once 'Persona.php';
    require_once 'Usuario.php';
    date_default_timezone_set("America/Mexico_City");
    $per = new Persona();
    $user = new Usuario();
    $per->setNombre($_POST['nombre']);
    $per->setPaterno($_POST['paterno']);
    $per->setMaterno($_POST['materno']);
    $per->setSexo($_POST['sexo']);
    $per->setTelefono($_POST['telefono']);
    $per->setCorreo($_POST['correo']);
    $tipo = "";
    if (isset($_FILES["fotoPerfil"]["tmp_name"]) && $_FILES["fotoPerfil"]["tmp_name"] != "") {
        $archivo = $_FILES["fotoPerfil"]["tmp_name"];
        $tipo = $_FILES["fotoPerfil"]["type"];
        $tam = $_FILES['fotoPerfil']["size"];

        $fp = fopen($archivo, "rb");
        $contenido = fread($fp, $tam);
        fclose($fp);
        $contenido = addslashes($contenido);
        $per->setFotoPerfil($contenido);
    }
    $persona = $cnn->query("INSERT INTO persona values(null,'". $per->getPaterno(). "','".$per->getMaterno(). "','".$per->getNombre(). "','".$per->getSexo(). "',".$per->getTelefono(). ",'".$per->getCorreo(). "','". $per->getFotoPerfil(). "', '". $tipo ."')");
    $consult = $cnn->query("SELECT max(id_per) as id FROM persona");
    $id = $consult->fetch_array(MYSQLI_ASSOC)['id'];
    $user->setNombreUsuario($_POST['username']);
    $user->setContrasenia($_POST['password']);
    $user->setFechaRegistro(date("Y-m-d"));
    $user->setPuesto($_POST['repeat']);

    $nuevoUsuario = $cnn->query("INSERT INTO empleado VALUES(null, '". $user->getNombreUsuario() ."','". $user->getContrasenia() ."','". $user->getPuesto() ."', 'Contratado', '". $user->getFechaRegistro(). "', ". $id .")");
}

if(isset($_POST['verUsuarios'])) {
    $consult = $cnn->query("SELECT nombre_per as nombre, ap_per as paterno, am_per as materno, e.id_emp as empleado, p.id_per as persona, foto_per as perfil, fechain_emp as fecha, puesto_emp as puesto, status_emp as statusemp FROM empleado e join persona p on e.cve_per = p.id_per WHERE e.status_emp = 'Contratado'");
    if($consult->num_rows>0) { echo verUsuarios($consult); }
    else { echo "Sin datos"; }
}

if(isset($_POST['detalleUsuario'])) {
    $consult = $cnn->query("SELECT p.id_per as persona, ap_per as paterno, am_per as materno, nombre_per as nombre, sexo_per as sexo, correo_per as correo, telefono_per as telefono, foto_per as foto, usuario_emp as usuario, fechain_emp as fecha, puesto_emp as puesto FROM empleado e join persona p on e.cve_per = p.id_per WHERE e.id_emp = ". $_POST['detalleUsuario']);
    if($consult->num_rows>0) {
        echo detalleUsuario($consult);
    }
}

//MODIFICAR EL USUARIO: VISTA.
if(isset($_POST['vistaModificar'])) {
    $consult = $cnn->query("SELECT p.id_per as persona, ap_per as paterno, am_per as materno, nombre_per as nombre, sexo_per as sexo, correo_per as correo, telefono_per as telefono, e.puesto_emp as puesto FROM empleado e join persona p on e.cve_per = p.id_per WHERE e.id_emp = ". $_POST['vistaModificar']);
    if($consult->num_rows>0) { echo vistaModificar($consult); }
}

if(isset($_POST['modificar'])) {
    require_once 'Persona.php';
    date_default_timezone_set("America/Mexico_City");
    $per = new Persona();
    $per->setNombre($_POST['nombre']);
    $per->setPaterno($_POST['paterno']);
    $per->setMaterno($_POST['materno']);
    $per->setSexo($_POST['sexo']);
    $per->setTelefono($_POST['telefono']);
    $per->setCorreo($_POST['correo']);
    $tipo = "";
    $cadArchi = "";
    if (isset($_FILES["fotoPerfil"]["tmp_name"]) && $_FILES["fotoPerfil"]["tmp_name"] != "") {
        $archivo = $_FILES["fotoPerfil"]["tmp_name"];
        $tipo = $_FILES["fotoPerfil"]["type"];
        $tam = $_FILES['fotoPerfil']["size"];

        $fp = fopen($archivo, "rb");
        $contenido = fread($fp, $tam);
        fclose($fp);
        $contenido = addslashes($contenido);
        $cadArchi = "foto_per='$contenido', tipoarchivo_per='$tipo',";
    }
    $persona = $cnn->query("UPDATE persona SET $cadArchi ap_per = '". $per->getPaterno(). "', am_per = '".$per->getMaterno(). "', nombre_per = '".$per->getNombre(). "', sexo_per = '".$per->getSexo(). "', telefono_per = ".$per->getTelefono(). ", correo_per = '".$per->getCorreo(). "' WHERE id_per = ". $_POST['modificar']);
    $cnn->query("UPDATE empleado SET puesto_emp = '". $_POST['puesto']. "' WHERE cve_per = ". $_POST['modificar']);
}

if(isset($_POST['interfazUsuario'])) {
    echo interfazUsuario();
}

if(isset($_POST['eliminarEmpleado'])) {
    $cnn->query("UPDATE empleado SET status_emp = 'Despedido' WHERE id_emp = ". $_POST['eliminarEmpleado']);
}