<?php
require_once 'Conexion.lib.php';
if(isset($_SESSION['autenticacion']) && $_SESSION['autenticacion'] == 1) {
    echo $sistema;
    return;
}
$sistema = "";
$cnn = conexion();

if(isset($_POST['mostrarLogin'])) {
    header('Location: ../HTML/Login.html');
}

if(isset($_POST['signin'])) {
    $login = $cnn->query("SELECT * FROM empleado WHERE usuario_emp = '". $_POST['username'] ."' AND contrasenia_emp = '". $_POST['password']. "'");
    if($login->num_rows>0) {
        while ($ren = $login->fetch_array(MYSQLI_ASSOC)) {
            $id = $ren['id_emp'];
            session_start();
            $_SESSION['id_user'] = $ren['id_emp'];
            $_SESSION['username'] = $ren['usuario_emp'];
            $_SESSION['autenticacion'] = 1;
        }
        echo <<<HDOC
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <a class="navbar-brand" onclick="verUsuarios();" style="cursor: pointer;">Usuarios</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
            
                    <a class="navbar-brand" onclick="verClientes();" style="cursor: pointer;">Clientes</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
            
                    <a class="navbar-brand" style="cursor: pointer;">Productos</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
            
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Ventas
                            </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="#">Vender un producto</a></li>
                                    <li><a class="dropdown-item" href="#">Ventas hechas a crédito</a></li>
                                    <!-- <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li> -->
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <form class="d-flex">
                        <input type="submit" value="Cerrar sesión" id='$id' class="usuario_logueado">
                    </form>
                </div>
            </nav>
        HDOC;
    }
    else {
        echo "Nombre de usuario o contraseña incorrectos";
    }
}

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
    $persona = $cnn->query("INSERT INTO persona values(null,'". $per->getPaterno(). "','".$per->getMaterno(). "','".$per->getNombre(). "','".$per->getSexo(). "',".$per->getTelefono(). ",'".$per->getCorreo(). "','". $per->getFotoPerfil(). "', '". $tipo ."')");
    $consult = $cnn->query("SELECT max(id_per) as id FROM persona");
    $id = "";
    if($consult->num_rows>0) {
        while ($ren = $consult->fetch_array(MYSQLI_ASSOC)) {
            $id = $ren['id'];
        }
    }
    $user->setNombreUsuario($_POST['username']);
    $user->setContrasenia($_POST['password']);
    $user->setFechaRegistro(date("Y-m-d"));

    $nuevoUsuario = $cnn->query("INSERT INTO empleado VALUES(null, '". $user->getNombreUsuario() ."','". $user->getContrasenia() ."','". $user->getFechaRegistro() ."', ". $id .")");
    echo $nuevoUsuario;
}

if(isset($_POST['verUsuarios'])) {
    $consult = $cnn->query("SELECT nombre_per as nombre, ap_per as paterno, am_per as materno, e.id_emp as empleado, p.id_per as persona, foto_per as perfil FROM empleado e join persona p on e.cve_per = p.id_per");
    if($consult->num_rows>0) {
        $tabla = <<<HDOC
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th>Foto de Perfil</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Paterno</th>
                        <th scope="col">Materno</th>
                        <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
        HDOC;
        while ($ren = $consult->fetch_array(MYSQLI_ASSOC)) {
            $img = "";
            if ($ren["perfil"] != NULL) { $img = "../PHP/MostrarImagen.php?id=$ren[persona]"; }
            else { $img = "noPhoto.png"; }
            $acciones = "";
            if($_POST['usuarioLogueado'] == $ren['empleado']) {
                $acciones = <<<HDOC
                    <button type="button" onclick='mostrarDetalles($ren[empleado])' class="btn btn-secondary">Detalles</button>
                    <button type="button" onclick='vistaModificar($ren[empleado])' class="btn btn-primary">Editar</button>
                HDOC;
            }
            else {
                $acciones = <<<HDOC
                    <button type="button" onclick='mostrarDetalles($ren[empleado])' class="btn btn-secondary">Detalles</button>
                    <button type="button" onclick='editarEmpleado($ren[empleado])' class="btn btn-primary">Editar</button>
                    <button type="button" onclick='eliminarEmpleado($ren[empleado])' class="btn btn-danger">Eliminar</button>
                HDOC;
            }
            $tabla .= <<<HDOC
                <tr id='$ren[empleado]'>
                    <th scope="row">$ren[empleado]</th>
                    <td><img src='$img' width='80px' alt=''/></td>
                    <td>$ren[nombre]</td>
                    <td>$ren[paterno]</td>
                    <td>$ren[materno]</td>
                    <td>$acciones</td>
                </tr>
            HDOC;
        }
        $tabla .= "<tbodt></tbodt><table></table>";
        echo $tabla;
    }
    else { echo "Sin datos"; }
}

if(isset($_POST['detalleUsuario'])) {
    $consult = $cnn->query("SELECT p.id_per as persona, ap_per as paterno, am_per as materno, nombre_per as nombre, sexo_per as sexo, correo_per as correo, telefono_per as telefono, foto_per as foto, usuario_emp as usuario FROM empleado e join persona p on e.cve_per = p.id_per WHERE e.id_emp = ". $_POST['detalleUsuario']);
    if($consult->num_rows>0) {
        $datosUsuario = <<<HDOC
            <ol class="list-group list-group-numbered">
        HDOC;
        while($ren = $consult->fetch_array(MYSQLI_ASSOC)) {
            $img = "";
            if ($ren["foto"] != NULL) { $img = "../PHP/MostrarImagen.php?id=$ren[persona]"; }
            else { $img = "noPhoto.png"; }
            $datosUsuario .= <<<HDOC
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">Foto</div>
                        <img src='$img' width='80px' alt=''/>
                    </div>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">Nombre</div>
                            $ren[nombre]
                    </div>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">Apellidos</div>
                            $ren[paterno] $ren[materno]
                    </div>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">Sexo</div>
                            $ren[sexo]
                    </div>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">Correo</div>
                            $ren[correo]
                    </div>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">Teléfono</div>
                            $ren[telefono]
                    </div>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">Nombre de usuario</div>
                            $ren[usuario]
                    </div>
                </li>
            HDOC;
        }
        $datosUsuario .= "</ol> <button type='button' onclick='verUsuarios();' class='btn btn-secondary' style='margin-top: 10px;'>Regresar</button>";
        echo $datosUsuario;
    }
}

//MODIFICAR EL USUARIO: VISTA.
if(isset($_POST['vistaModificar'])) {
    $consult = $cnn->query("SELECT p.id_per as persona, ap_per as paterno, am_per as materno, nombre_per as nombre, sexo_per as sexo, correo_per as correo, telefono_per as telefono FROM empleado e join persona p on e.cve_per = p.id_per WHERE e.id_emp = ". $_POST['vistaModificar']);
    if($consult->num_rows>0) {
        $datosUsuario = <<<HDOC
            <form action='javascript:modificar($_POST[vistaModificar]);'>
            <ol class="list-group list-group-numbered">
        HDOC;
        while($ren = $consult->fetch_array(MYSQLI_ASSOC)) {
            $datosUsuario .= <<<HDOC
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">Foto</div>
                        <input type='file' name='archivo' id='archivo'>
                    </div>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">Nombre</div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="nombre" placeholder="Nombre" value='$ren[nombre]'>
                                <label for="nombre">Nombre</label>
                            </div>
                    </div>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">Paterno</div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="paterno" placeholder="Apellido Paterno" value='$ren[paterno]'>
                            <label for="paterno">Apellido Paterno</label>
                        </div>
                    </div>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">Paterno</div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="materno" placeholder="Apellido Materno" value='$ren[materno]'>
                            <label for="materno">Apellido Materno</label>
                        </div>
                    </div>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">Sexo</div>
                        <select class="form-select" aria-label="Default select example">
                            <option selected>Open this select menu</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                        </select>
                    </div>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">Apellidos</div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="correo" placeholder="Correo Electrónico" value='$ren[correo]'>
                            <label for="correo">Correo Electrónico</label>
                        </div>
                    </div>
                </li>
            HDOC;
        }
        $datosUsuario .= "</ol> <button type='button' onclick='verUsuarios();' class='btn btn-secondary' style='margin-top: 10px;'>Regresar</button> <input type='submit' name='update' id='update' value='Actualizar' class='btn btn-success'> </form>";
        echo $datosUsuario;
    }
}