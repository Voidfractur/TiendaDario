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
                                <li><a class="dropdown-item" onclick='vender();'>Vender un producto</a></li>
                                <li><a class="dropdown-item" onclick='verCredito();'>Ventas hechas a crédito</a></li>
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

function detalleUsuario($usuario) {
    $ren = $usuario->fetch_array(MYSQLI_ASSOC);
    $datosUsuario = <<<HDOC
        <ol class="list-group list-group-numbered">
    HDOC;
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
        <li class="list-group-item d-flex justify-content-between align-items-start">
            <div class="ms-2 me-auto">
                <div class="fw-bold">Fecha de contratación</div>
                    $ren[fecha]
            </div>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-start">
            <div class="ms-2 me-auto">
                <div class="fw-bold">Puesto</div>
                    $ren[puesto]
            </div>
        </li>
    HDOC;
    $datosUsuario .= "</ol> <button type='button' onclick='verUsuarios();' class='btn btn-secondary' style='margin-top: 10px;'>Regresar</button>";
    return $datosUsuario;
}

function vistaModificar($consult) {
    $ren = $consult->fetch_array(MYSQLI_ASSOC);
    $datosUsuario = <<<HDOC
        <form action='javascript:modificar($ren[persona]);' id='form'>
        <ol class="list-group list-group-numbered">
    HDOC;
    $datosUsuario .= <<<HDOC
        <li class="list-group-item d-flex justify-content-between align-items-start">
            <div class="ms-2 me-auto">
                <div class="fw-bold">Foto</div>
                <input type='file' name='file' id='file'>
            </div>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-start">
            <div class="ms-2 me-auto">
                <div class="fw-bold">Nombre</div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="nombre" placeholder="Nombre" value='$ren[nombre]' required>
                    <label for="nombre">Nombre</label>
                </div>
            </div>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-start">
            <div class="ms-2 me-auto">
                <div class="fw-bold">Paterno</div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="paterno" placeholder="Apellido Paterno" value='$ren[paterno]' required>
                    <label for="paterno">Apellido Paterno</label>
                </div>
            </div>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-start">
            <div class="ms-2 me-auto">
                <div class="fw-bold">Paterno</div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="materno" placeholder="Apellido Materno" value='$ren[materno]' required>
                    <label for="materno">Apellido Materno</label>
                </div>
            </div>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-start">
            <div class="ms-2 me-auto">
                <div class="fw-bold">Sexo</div>
                <select class="form-select" aria-label="Default select example" id='sexo' required>
                    <option value=''>Seleccione un sexo</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                </select>
            </div>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-start">
            <div class="ms-2 me-auto">
                <div class="fw-bold">Correo</div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="correo" placeholder="Correo Electrónico" value='$ren[correo]' required>
                    <label for="correo">Correo Electrónico</label>
                </div>
            </div>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-start">
            <div class="ms-2 me-auto">
                <div class="fw-bold">Telefono</div>
                <div class="form-floating mb-3">
                    <input type="number" class="form-control" id="telefono" placeholder="Teléfono" value='$ren[telefono]' required>
                    <label for="telefono">Teléfono</label>
                </div>
            </div>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-start">
            <div class="ms-2 me-auto">
                <div class="fw-bold">Puesto</div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="puesto" placeholder="Puesto" value='$ren[puesto]' required>
                    <label for="puesto">Puesto</label>
                </div>
            </div>
        </li>
    HDOC;
    $datosUsuario .= "</ol> <button type='button' onclick='verUsuarios();' class='btn btn-secondary' style='margin-top: 10px;'>Regresar</button> <input type='submit' name='update' id='update' value='Actualizar' class='btn btn-success'> </form>";
    return $datosUsuario;
}

function interfazUsuario() {
    return header('Location: ../HTML/SignUp.html');
}