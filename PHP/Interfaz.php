<?php
function mostrarLogin() {
    return header('Location: ../HTML/Login.html');
}

function menu($datosUsuario) {
    $id = $datosUsuario->fetch_array(MYSQLI_ASSOC)['id_emp'];
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

function verUsuarios($usuarios) {
    $tabla = <<<HDOC
        <form class="d-flex" action='javascript:nuevoEmpleado();' style='margin-top: 20px; margin-bottom = 20px;'>
            <input type="submit" value="Nuevo empleado" class='btn btn-success'>
        </form>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th>Foto de Perfil</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Paterno</th>
                    <th scope="col">Materno</th>
                    <th scope="col">Fecha de contratación</th>
                    <th scope="col">Puesto</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
        HDOC;
    while ($ren = $usuarios->fetch_array(MYSQLI_ASSOC)) {
        $img = "";
        // if($ren['statusemp'] == "Despedido") { echo $ren['nombre']; continue; }
        if ($ren["perfil"] != NULL) { $img = "../PHP/MostrarImagen.php?id=$ren[persona]"; }
        else { $img = "../Images/noPhoto.png"; }
        $acciones = "";
        if($_POST['usuarioLogueado'] == $ren['empleado']) {
            $acciones = <<<HDOC
                <button type="button" onclick='mostrarDetalles($ren[empleado])' class="btn btn-secondary">Detalles</button>
                <button type="button" onclick='vistaModificar($ren[empleado])' class="btn btn-primary">Editar</button>
            HDOC;
        }
        else {
            $acciones = <<<HDOC
                <button type="button" onclick='mostrarDetalles($ren[empleado]);' class="btn btn-secondary">Detalles</button>
                <button type="button" onclick='vistaModificar($ren[empleado]);' class="btn btn-primary">Editar</button>
                <button type="button" onclick='eliminarEmpleado($ren[empleado]);' class="btn btn-danger">Eliminar</button>
            HDOC;
        }
        $tabla .= <<<HDOC
            <tr id='$ren[empleado]'>
                <th scope="row">$ren[empleado]</th>
                <td><img src='$img' width='80px' alt=''/></td>
                <td>$ren[nombre]</td>
                <td>$ren[paterno]</td>
                <td>$ren[materno]</td>
                <td>$ren[fecha]</td>
                <td>$ren[puesto]</td>
                <td>$acciones</td>
            </tr>
        HDOC;
    }
    $tabla .= "<tbodt></tbodt><table></table>";
    return $tabla;
}