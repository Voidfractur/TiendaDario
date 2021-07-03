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
                                <li><a class="dropdown-item" onclick='vender();' style='cursor: pointer;'>Vender un producto</a></li>
                                <li><a class="dropdown-item" onclick='verCredito();' style='cursor: pointer;'>Ventas hechas a crédito</a></li>
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

function interfazVenderProducto() {
    $vender = <<<HDOC
        <form class="row g-3" style='margin-top: 10px;' id='form' action='javascript:buscarProducto();'>
            <div class="col-auto">
                <label for="producto" class="visually-hidden">Código de barras</label>
                <input type="number" class="form-control" required id="producto" placeholder="Código de barras">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary mb-3">Agregar producto</button>
            </div>
            <div>
                <button type="button" class="btn btn-primary" onclick='comprarCredito();'>Comprar a crédito</button>
                <button type="button" class="btn btn-success" onclick='comprarContado();'>Comprar al contado</button>
            </div>
        </form>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Código de barras</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Cantidad a comprar</th>
                    <th scope="col">Precio por unidad</th>
                    <th scope="col">Total</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
    HDOC;
    return $vender;
}

function agregarProducto($producto) {
    $producto = $producto->fetch_array(MYSQLI_ASSOC);
    $acciones = <<<HDOC
        <button type="button" onclick='eliminarUnaPieza($producto[codigo_pro]);' class="btn btn-danger">Eliminar una unidad</button>
        <button type="button" onclick='agregarOtroProducto($producto[codigo_pro]);' class="btn btn-primary">Agregar una unidad más</button>
        
    HDOC;
    $nuevoProducto = <<<HDOC
        <tr id='$producto[codigo_pro]'>
            <th scope="row">$producto[id_pro]</th>
            <td>$producto[codigo_pro]</td>
            <td class='$producto[codigo_pro]'>$producto[nombre_pro]</td>
            <td class='$producto[codigo_pro]'>1</td>
            <td class='$producto[codigo_pro]'>$producto[precio_pro]</td>
            <td class='$producto[codigo_pro]'>$producto[precio_pro]</td>
            <td>$acciones</td>
        </tr>
    HDOC;
    return $nuevoProducto;
}

function vistaComprarContado() {
    $compra = <<<HDOC
        <div class="accordion accordion-flush" id="accordionFlushExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                    Artículos a comprar
                    </button>
                </h2>
                <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        <ol class="list-group list-group-numbered" id='productosAComprar'></ol>
                    </div>
                </div>
            </div>
        </div>
        <form action="javascript:pagarSinRegistro();" enctype="multipart/form-data" id="form" style='margin-top: 10px;'>
            <button class="btn btn-link" onclick="vender();">Cancelar</button>
            <input type="submit" class="btn btn-primary" value="Pagar sin registrarse" id="submit">
        </form>
        <div class="register" style='margin-top: 30px;'>
            <h1>Nuevo Cliente</h1>
            <hr>
            <form action="javascript:pagarNuevoCliente();" enctype="multipart/form-data" id="form">
                <div class="inputs firstSection">
                    <label for=""  class="nombre_label">
                        <span onclick="focusCursor1(this)" class="nombre">Nombre</span>
                    <input type="text" id="nombre" name="nombre" autocomplete="off" required onfocus="movingSpan(this);" onfocusout="resetingSpan(this);">
                </label>
                <label for=""  class="paterno_label">
                    <span onclick="focusCursor1(this)" class="paterno">Apellido Paterno</span>
                    <input type="text" id="paterno" name="paterno" autocomplete="off" required onfocus="movingSpan(this);" onfocusout="resetingSpan(this);">
                </label>
                <label for=""  class="materno_label">
                    <span onclick="focusCursor1(this)" class="materno">Apellido Materno</span>
                    <input type="text" id="materno" name="materno" autocomplete="off" required onfocus="movingSpan(this);" onfocusout="resetingSpan(this);">
                </label>
                <label for="" class="telefono_label">
                    <span onclick="focusCursor1(this)" class="telefono">Teléfono</span>
                    <input type="number" id="telefono" name="telefono" autocomplete="off" required onfocus="movingSpan(this);" onfocusout="resetingSpan(this);" min="0">
                </label>
                <label for="" class="correo_label">
                    <span onclick="focusCursor1(this)" class="correo">Correo</span>
                    <input type="text" id="correo" name="correo" autocomplete="off" required onfocus="movingSpan(this);" onfocusout="resetingSpan(this);">
                </label>
                <div class='file-input' style="margin-bottom: 40px;">
                    <input type='file' id="file" name="file">
                </div>
                <div>
                    <input type="radio" id="woman"
                    name="contact" value="Femenino">
                    <label for="woman">Femenino</label>
                
                    <input type="radio" id="man"
                    name="contact" value="Masculino">
                    <label for="man">Masculino</label>
                </div>
            </div>
            <hr class="hr">
            <input type="submit" value="Registrar y pagar" id="submit">
            <button class="cancel" onclick="verUsuarios();">Cancel</button>
            <button class="back"onclick="verUsuarios();">Back</button>
        </form>
    </div>
    HDOC;
    return $compra;
}