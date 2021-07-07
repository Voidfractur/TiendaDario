<?php
function mostrarLogin()
{
    return header('Location: ../HTML/Login.html');
}

function menu($datosUsuario)
{
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
            
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Productos
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" onclick='verProductos();' style='cursor: pointer;'>Lista de productos</a></li>
                                <li><a class="dropdown-item" onclick='viewAddProduct();' style='cursor: pointer;'>Alta de productos</a></li>
                                <li><a class="dropdown-item" onclick='verProductos();' style='cursor: pointer;'>Baja de Productos</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Ventas
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" onclick='venderSinMensaje();;' style='cursor: pointer;'>Vender un producto</a></li>
                                <li><a class="dropdown-item" onclick='verCredito("");' style='cursor: pointer;'>Ventas hechas a crédito</a></li>
                                <li><a class="dropdown-item" onclick='verVentasHechas();' style='cursor: pointer;'>Ver todas las ventas</a></li>
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

function verUsuarios($usuarios)
{
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
        if ($ren["perfil"] != NULL) {
            $img = "../PHP/MostrarImagen.php?id=$ren[persona]";
        } else {
            $img = "../Images/noPhoto.png";
        }
        $acciones = "";
        if ($_POST['usuarioLogueado'] == $ren['empleado']) {
            $acciones = <<<HDOC
                <button type="button" onclick='mostrarDetalles($ren[empleado])' class="btn btn-secondary">Detalles</button>
                <button type="button" onclick='vistaModificar($ren[empleado])' class="btn btn-primary">Editar</button>
            HDOC;
        } else {
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

function verClientes($usuarios)
{
    $tabla = <<<HDOC
        <form class="d-flex" action='javascript:nuevoCliente();' style='margin-top: 20px; margin-bottom = 20px;'>
            <input type="submit" value="Nuevo cliente" class='btn btn-success'>
        </form>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th>Foto de Perfil</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Paterno</th>
                    <th scope="col">Materno</th>
                    <th scope="col">Teléfono</th>
                    <th scope="col">Correo electrónico</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
        HDOC;
    while ($ren = $usuarios->fetch_array(MYSQLI_ASSOC)) {
        $img = "";
        $telefono = $ren['telefono'] != "" ? $ren['telefono'] : "Sin número registrado";
        $correo = $ren['correo'] != "" ? $ren['correo'] : "Sin correo electrónico registrado";
        if ($ren["perfil"] != NULL) {
            $img = "../PHP/MostrarImagen.php?id=$ren[persona]";
        } else {
            $img = "../Images/noPhoto.png";
        }
        $acciones = "";
        if ($ren['nombre'] == "Público en general") {
            $acciones = <<<HDOC
                <button type="button" onclick='detallesCliente($ren[cliente]);' class="btn btn-secondary">Detalles</button>
            HDOC;
        } else {
            $acciones = <<<HDOC
                <button type="button" onclick='detallesCliente($ren[cliente]);' class="btn btn-secondary">Detalles</button>
                <button type="button" onclick='vistaModificarCliente($ren[cliente]);' class="btn btn-primary">Editar</button>
                <button type="button" onclick='eliminarCliente($ren[cliente]);' class="btn btn-danger">Eliminar</button>
            HDOC;
        }
        $tabla .= <<<HDOC
            <tr id='$ren[cliente]'>
                <th scope="row">$ren[cliente]</th>
                <td><img src='$img' width='80px' alt=''/></td>
                <td>$ren[nombre]</td>
                <td>$ren[paterno]</td>
                <td>$ren[materno]</td>
                <td>$telefono</td>
                <td>$correo</td>
                <td>$acciones</td>
            </tr>
        HDOC;
    }
    $tabla .= "<tbodt></tbodt><table></table>";
    return $tabla;
}

function detalleUsuario($usuario)
{
    $ren = $usuario->fetch_array(MYSQLI_ASSOC);
    $datosUsuario = <<<HDOC
        <ol class="list-group list-group-numbered">
    HDOC;
    $img = "";
    if ($ren["foto"] != NULL) {
        $img = "../PHP/MostrarImagen.php?id=$ren[persona]";
    } else {
        $img = "noPhoto.png";
    }
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

function detalleCliente($usuario)
{
    $ren = $usuario->fetch_array(MYSQLI_ASSOC);
    $datosUsuario = <<<HDOC
        <ol class="list-group list-group-numbered">
    HDOC;
    $img = "";
    if ($ren["foto"] != NULL) {
        $img = "../PHP/MostrarImagen.php?id=$ren[persona]";
    } else {
        $img = "../Images/noPhoto.png";
    }
    $telefono = $ren['telefono'] != "" ? $ren['telefono'] : "Sin número registrado";
    $correo = $ren['correo'] != "" ? $ren['correo'] : "Sin correo electrónico registrado";
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
                    $correo
            </div>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-start">
            <div class="ms-2 me-auto">
                <div class="fw-bold">Teléfono</div>
                $telefono
            </div>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-start">
            <div class="ms-2 me-auto">
                <div class="fw-bold">Fecha de registro del cliente</div>
                    $ren[fecharegistro]
            </div>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-start">
            <div class="ms-2 me-auto">
                <div class="fw-bold">Hora de registro del cliente</div>
                    $ren[horaregistro]
            </div>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-start">
            <div class="ms-2 me-auto">
                <div class="fw-bold">Tipo de cliente</div>
                    $ren[tipocliente]
            </div>
        </li>
    HDOC;
    $datosUsuario .= "</ol> <button type='button' onclick='verClientes();' class='btn btn-secondary' style='margin-top: 10px;'>Regresar</button>";
    return $datosUsuario;
}

function vistaModificar($consult)
{
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

function vistaModificarCliente($consult)
{
    $ren = $consult->fetch_array(MYSQLI_ASSOC);
    $datosUsuario = <<<HDOC
        <form action='javascript:modificarCliente($ren[persona]);' id='form'>
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
    HDOC;
    $datosUsuario .= "</ol> <button type='button' onclick='verClientes();' class='btn btn-secondary' style='margin-top: 10px;'>Regresar</button> <input type='submit' name='update' id='update' value='Actualizar' class='btn btn-success'> </form>";
    return $datosUsuario;
}

function interfazUsuario()
{
    return header('Location: ../HTML/SignUp.html');
}

function interfazVenderProducto()
{
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
                    <th scope="col">Existencia</th>
                    <th scope="col">Precio por unidad</th>
                    <th scope="col">Total</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
    HDOC;
    return $vender;
}

function agregarProducto($producto)
{
    $producto = $producto->fetch_array(MYSQLI_ASSOC);
    $acciones = <<<HDOC
        <button type="button" onclick='eliminarUnaPieza($producto[codigo_pro]);' class="btn btn-danger">Eliminar una unidad</button>
        <button type="button" onclick='agregarOtroProducto($producto[codigo_pro]);' class="btn btn-primary">Agregar una unidad más</button>
        
    HDOC;
    $existencia = $producto['cantidad'] - 1;
    $nuevoProducto = <<<HDOC
        <tr id='$producto[codigo_pro]'>
            <th scope="row">$producto[id_pro]</th>
            <td>$producto[codigo_pro]</td>
            <td class='$producto[codigo_pro]'>$producto[nombre_pro]</td>
            <td class='$producto[codigo_pro]'>1</td>
            <td class='$producto[codigo_pro]'>$existencia</td>
            <td class='$producto[codigo_pro]'>$producto[precio_pro]</td>
            <td class='$producto[codigo_pro]'>$producto[precio_pro]</td>
            <td>$acciones</td>
        </tr>
    HDOC;
    return $nuevoProducto;
}

function vistaComprarContado()
{
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
        <div style='margin-top: 10px;'>
            <button class="btn btn-link" onclick="venderSinMensaje();">Cancelar</button>
            <button class="btn btn-link" onclick="clienteRegistrado();">Buscar cliente registrado</button>
            <input type="button" onclick="pagarSinRegistro();" class="btn btn-primary" value="Pagar sin registrarse" id="submit">
        </div>
        <div class="register" style='margin-top: 30px;'>
            <h1>Nuevo Cliente</h1>
            <hr>
            <form action="javascript:pagarNuevoCliente();" enctype="multipart/form-data" id="formNuevoUsuario">
                <div class="inputs firstSection">
                    <label for=""  class="nombre_label">
                        <span class="nombre">Nombre</span>
                    <input type="text" id="nombre" name="nombre" autocomplete="off" required  >
                </label>
                <label for=""  class="paterno_label">
                    <span class="paterno">Apellido Paterno</span>
                    <input type="text" id="paterno" name="paterno" autocomplete="off" required  >
                </label>
                <label for=""  class="materno_label">
                    <span class="materno">Apellido Materno</span>
                    <input type="text" id="materno" name="materno" autocomplete="off" required  >
                </label>
                <label for="" class="telefono_label">
                    <span class="telefono">Teléfono</span>
                    <input type="number" id="telefono" name="telefono" autocomplete="off" required   min="0">
                </label>
                <label for="" class="correo_label">
                    <span class="correo">Correo</span>
                    <input type="text" id="correo" name="correo" autocomplete="off" required  >
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
        </form>
    </div>
    HDOC;
    return $compra;
}

function clientes($clientes)
{
    $tabla = <<<HDOC
    <button type="button" onclick='comprarContado();' class="btn btn-primary">Regresar</button>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th>Foto de Perfil</th>
                <th scope="col">Nombre</th>
                <th scope="col">Paterno</th>
                <th scope="col">Materno</th>
                <th scope="col">Comprar</th>
            </tr>
        </thead>
        <tbody>
    HDOC;
    while ($ren = $clientes->fetch_array(MYSQLI_ASSOC)) {
        $img = "";
        if ($ren["perfil"] != NULL) {
            $img = "../PHP/MostrarImagen.php?id=$ren[persona]";
        } else {
            $img = "../Images/noPhoto.png";
        }
        $acciones = <<<HDOC
            <button type="button" onclick='comprarMisProductos($ren[cliente])' class="btn btn-success">Comprar</button>
        HDOC;
        $tabla .= <<<HDOC
            <tr id='$ren[cliente]'>
                <th scope="row">$ren[cliente]</th>
                <td><img src='$img' width='80px' alt=''/></td>
                <td>$ren[nombre]</td>
                <td>$ren[paterno]</td>
                <td>$ren[materno]</td>
                <td>$acciones</td>
            </tr>
        HDOC;
    }
    $tabla .= "<tbodt></tbodt><table></table>";
    return $tabla;
}

function vistaComprarCredito()
{
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
        <div style='margin-top: 10px;'>
            <button class="btn btn-link" onclick="venderSinMensaje();">Cancelar</button>
            <button class="btn btn-link" onclick="clienteRegistradoCredito();">Buscar cliente registrado</button>
        </div>
        <div class="register" style='margin-top: 30px;'>
            <h1>Nuevo Cliente</h1>
            <hr>
            <form action="javascript:pagarNuevoClienteCredito();" enctype="multipart/form-data" id="formNuevoUsuario">
                <div class="inputs firstSection">
                    <label for=""  class="nombre_label">
                        <span class="nombre">Nombre</span>
                    <input type="text" id="nombre" name="nombre" autocomplete="off" required  >
                </label>
                <label for=""  class="paterno_label">
                    <span class="paterno">Apellido Paterno</span>
                    <input type="text" id="paterno" name="paterno" autocomplete="off" required  >
                </label>
                <label for=""  class="materno_label">
                    <span class="materno">Apellido Materno</span>
                    <input type="text" id="materno" name="materno" autocomplete="off" required  >
                </label>
                <label for="" class="telefono_label">
                    <span class="telefono">Teléfono</span>
                    <input type="number" id="telefono" name="telefono" autocomplete="off" required   min="0">
                </label>
                <label for="" class="correo_label">
                    <span class="correo">Correo</span>
                    <input type="text" id="correo" name="correo" autocomplete="off" required  >
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
            <div class="col-auto">
                <label for="producto" class="visually-hidden">Pago inicial</label>
                <input type="number" class="form-control" id="pagoInicial" placeholder="Pago inicial">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary mb-3">Comprar y registrar</button>
            </div>
        </form>
    </div>
    HDOC;
    return $compra;
}

function clientesCredito($clientes)
{
    $tabla = <<<HDOC
    <button type="button" onclick='comprarCredito();' class="btn btn-primary">Regresar</button>
    <div class="col-auto">
        <label for="producto" class="visually-hidden">Pago inicial</label>
        <input type="number" class="form-control" id="pagoInicial" placeholder="Pago inicial">
    </div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th>Foto de Perfil</th>
                <th scope="col">Nombre</th>
                <th scope="col">Paterno</th>
                <th scope="col">Materno</th>
                <th scope="col">Comprar</th>
            </tr>
        </thead>
        <tbody>
    HDOC;
    while ($ren = $clientes->fetch_array(MYSQLI_ASSOC)) {
        $img = "";
        if ($ren["perfil"] != NULL) {
            $img = "../PHP/MostrarImagen.php?id=$ren[persona]";
        } else {
            $img = "../Images/noPhoto.png";
        }
        $acciones = <<<HDOC
            <button type="button" onclick='comprarMisProductosCredito($ren[cliente])' class="btn btn-success">Comprar</button>
        HDOC;
        $tabla .= <<<HDOC
            <tr id='$ren[cliente]'>
                <th scope="row">$ren[cliente]</th>
                <td><img src='$img' width='80px' alt=''/></td>
                <td>$ren[nombre]</td>
                <td>$ren[paterno]</td>
                <td>$ren[materno]</td>
                <td>$acciones</td>
            </tr>
        HDOC;
    }
    $tabla .= "<tbodt></tbodt><table></table>";
    return $tabla;
}

function mostrarCreditos($creditos) {
    $tabla = <<<HDOC
        <form action="javascript:nombreCliente();" style='width: 600px; margin-bottom: 10px;'>
            <input type='text' id='nombre' placeholder='Buscar por nombre del cliente'>
            <input type='submit' class="btn btn-success" value="Buscar cliente">
        </form>
        <form action="javascript:nombreProducto();" style='width: 600px; margin-bottom: 10px;'>
            <input type='text' id='producto' placeholder='Buscar por producto'>
            <input type='submit' class="btn btn-success" value="Buscar producto">
        </form>
    HDOC;
    $tabla .= <<<HDOC
    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Cliente</th>
                <th scope="col">Producto</th>
                <th scope="col">Fecha de compra</th>
                <th scope="col">Total</th>
                <th scope="col">Pago inicial</th>
                <th scope="col">Restante</th>
                <th scope="col">Acción</th>
            </tr>
        </thead>
        <tbody>
    HDOC;
    while ($ren = $creditos->fetch_array(MYSQLI_ASSOC)) {
        $acciones = <<<HDOC
            <button type="button" onclick='verDetallesCredito($ren[credito], "")' class="btn btn-primary">Detalles</button>
        HDOC;
        $tabla .= <<<HDOC
            <tr id='$ren[credito]'>
                <th scope="row">$ren[cliente]</th>
                <td>$ren[persona] $ren[paterno] $ren[materno]</td>
                <td>$ren[producto]</td>
                <td>$ren[fechacompra]</td>
                <td>$ren[total]</td>
                <td>$ren[inicial]</td>
                <td>$ren[restante]</td>
                <td>$acciones</td>
            </tr>
        HDOC;
    }
    $tabla .= "<tbodt></tbodt><table></table>";
    return $tabla;
}


function detallesCredito($creditos, $idCredito) {
    $tabla = <<<HDOC
    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Producto</th>
                <th scope="col">Precio por unidad</th>
                <th scope="col">Cantidad comprada</th>
                <th scope="col">Total de cada producto</th>
            </tr>
        </thead>
        <tbody>
    HDOC;
    $total;
    while ($ren = $creditos->fetch_array(MYSQLI_ASSOC)) {
        $tabla .= <<<HDOC
            <tr id='$ren[credito]'>
                <th scope="row">$ren[credito]</th>
                <td>$ren[producto]</td>
                <td>$ren[preciounidad]</td>
                <td>$ren[cantidad]</td>
                <td>$ren[TotalProducto]</td>
            </tr>
        HDOC;
        $total = $ren['restante'];
    }
    $tabla .= <<<HDOC
            <tbodt></tbodt>
        </table>
        <h3>Total a pagar: $total</h3>
        <form action="javascript:liquidarCuenta($idCredito);" style='width: 600px;'>
            <button type="button" onclick='verCredito("")' class="btn btn-primary">Regresar</button>
            <input type='submit' class="btn btn-success" value="Liquidar cuenta">
            <div class="input-group mb-3">
                <span class="input-group-text">$</span>
                <span class="input-group-text">0.00</span>
                <input type="number" class="form-control" id="abono" aria-label="Dollar amount (with dot and two decimal places)" required>
            </div>
        </form>
    HDOC;
    return $tabla;
}

function viewProductos($datos)
{
    $tabla = <<<HDOC
    <div class='container'>
    <table  class='table table-striped table-hover'>
        <thead>
            <tr>
                <th>Numero</th>
                <th>Imagen</th>
                <th>Codigo</th>
                <th>Nombre del producto</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
    HDOC;

    while ($ren = $datos->fetch_array(MYSQLI_ASSOC)) {
        /*if ($ren["img_ruta"] != Null) {
            $img = "<img src='$ren[img_ruta]' width='100'>";
        } else {
            $img = "<img src='../Images/noimage.png' width='100'>";
        }*/
        $img = "";
        if ($ren["img_contenido"] != NULL) {
            $img = "../PHP/MostrarImagenProducto.php?id=$ren[id_pro]";
        } else {
            $img = "../Images/noimage.png";
        }
        $tabla .= <<<HDOC
        <tr id='r$ren[id_pro]'>
        <td>$ren[id_pro]</td>
        <td><img src="$img" width='100'></td>
        <td>$ren[codigo_pro]</td>
        <td>$ren[nombre_pro]</td>
        <td>$$ren[precio_pro].00</td>
        <td>$ren[cantidad]</td>
        <td>
        <button type="button" class="btn btn-success " onclick='javascript:detallesProductos($ren[id_pro])'>Informacion</button>
        <button type="button" class="btn btn-warning" onclick='javascript:viewModificarProducto($ren[id_pro])'>Modificar</button>
        <button type="button" class="btn btn-danger" onclick='javascript:viewDeleteProducto($ren[id_pro])'>Dar de baja</button>
        </td>
           </tr> 
        HDOC;
    }
    $tabla .= "</tbody></table></div>";
    return $tabla;
}

function viewAddProductos()
{
    $tabla = <<<HDOC
    <br>
    <br>
    <div class="container bg-dark text-light rounded">
    <form class="row g-4" action="javascript:AddProduct()" method="POST">
    <div class="col-md-6">
      <label for="codigo_pro" class="form-label">Codigo del Producto</label>
      <input type="text" class="form-control" id="codigo_pro" name="codigo_pro" required>
    </div>
    <div class="col-md-6">
      <label for="nombre_pro" class="form-label">Nombre del Producto</label>
      <input type="text" class="form-control" id="nombre_pro" required>
    </div>
    <div class="col-2">
      <label for="stock_max" class="form-label">Stock Maximo</label>
      <input type="number" class="form-control" id="stock_max" required>
    </div>
    <div class="col-2">
      <label for="stock_min" class="form-label">Stock minimo</label>
      <input type="number" class="form-control" id="stock_min" required>
    </div>
    <div class="col-md-2">
      <label for="cantidad" class="form-label">Stock Actual</label>
      <input type="text" class="form-control" id="cantidad" required>
    </div>
    <div class="col-md-2">
    <label for="precio_pro" class="form-label">Precio</label>
    <input type="text" class="form-control" id="precio_pro" required>
    </div>
    <div class="col-md-4">
      <label for="imagen" class="form-label">Imagen</label>
      <input type="file" class="form-control" id="imagen" required>
    </div>
    
 
    <div class="col-12">
      <button type="submit" class="btn btn-primary">Agregar Producto</button>
    </div>
    </form>
    <br>
    </div>
    HDOC;
    return $tabla;
}

function viewProducto($datos)
{
    $tabla = "";
    while ($ren = $datos->fetch_array(MYSQLI_ASSOC)) {
        /*if ($ren["img_ruta"] != Null) {
            $img = $ren["img_ruta"];
        } else {
            $img = "../Images/noimage.png";
        }*/
        $img = "";
        if ($ren["img_contenido"] != NULL) {
            $img = "../PHP/MostrarImagenProducto.php?id=$ren[id_pro]";
        } else {
            $img = "../Images/noimage.png";
        }
        $tabla .= <<<HDOC
        <div class="d-flex justify-content-center">
        <div class="card" style="width: 18rem;">
        <img src="$img" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title">Producto: $ren[nombre_pro]</h5>
        </div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item">Codigo: $ren[codigo_pro]</li>
          <li class="list-group-item">Stock Maximo: $ren[stock_max]</li>
          <li class="list-group-item">Stock Minimo: $ren[stock_min]</li>
          <li class="list-group-item">Status: $ren[status_pro]</li>
          <li class="list-group-item">Stock Actual: $ren[cantidad]</li>
          <li class="list-group-item"><h1> Precio:  $$ren[precio_pro]</h1></li>
        </ul>
        </div>
        </div>
        HDOC;
    }
    return $tabla;
}

function viewDeleteProducto($datos)
{
    $tabla = "";
    while ($ren = $datos->fetch_array(MYSQLI_ASSOC)) {
        /*if ($ren["img_ruta"] != Null) {
            $img = $ren["img_ruta"];
        } else {
            $img = "../Images/noimage.png";
        }*/
        $img = "";
        if ($ren["img_contenido"] != NULL) {
            $img = "../PHP/MostrarImagenProducto.php?id=$ren[id_pro]";
        } else {
            $img = "../Images/noimage.png";
        }
        $tabla .= <<<HDOC
        <div class="d-flex justify-content-center">
        <div class="card" style="width: 18rem;">
        <img src="$img" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title">Producto: $ren[nombre_pro]</h5>
        </div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item">Codigo: $ren[codigo_pro]</li>
          <li class="list-group-item">Stock Maximo: $ren[stock_max]</li>
          <li class="list-group-item">Stock Minimo: $ren[stock_min]</li>
          <li class="list-group-item">Status: $ren[status_pro]</li>
          <li class="list-group-item">Stock Actual: $ren[cantidad]</li>
          <li class="list-group-item"><h1> Precio:  $$ren[precio_pro]</h1></li>
        </ul>
        <button type="button" class="btn btn-danger" onclick='javascript:bajaProducto($ren[id_pro])'>Dar de baja</button>
        <button type="button" class="btn btn-dark" onclick='javascript:DeleteProducto($ren[id_pro])'>Eliminar</button>
        </div>
        </div>
        
        HDOC;
    }
    return $tabla;
}

function viewModificarProducto($datos)
{
    while ($ren = $datos->fetch_array(MYSQLI_ASSOC)) {
        $img = "";
        if ($ren["img_contenido"] != NULL) {
            $img = "../PHP/MostrarImagenProducto.php?id=$ren[id_pro]";
        } else {
            $img = "../Images/noimage.png";
        }
        $tabla = <<<HDOC
    <br>
    <br>
    <div class="container bg-dark text-light rounded">
    <form class="row g-4" action="javascript:ModificarProducto($ren[id_pro])" method="POST">
    <div class="col-md-2">
      <label for="id_pro" class="form-label">Id</label>
      <input type="text" class="form-control" id="id_pro" name="id_pro" value="$ren[id_pro]" readonly required>
    </div>
    <div class="col-md-4">
      <label for="codigo_pro" class="form-label">Codigo del Producto</label>
      <input type="text" class="form-control" id="codigo_pro" name="codigo_pro" value="$ren[codigo_pro]" required>
    </div>
    <div class="col-md-6">
      <label for="nombre_pro" class="form-label">Nombre del Producto</label>
      <input type="text" class="form-control" id="nombre_pro" value="$ren[nombre_pro]" required>
    </div>
    <div class="col-2">
      <label for="stock_max" class="form-label">Stock Maximo</label>
      <input type="number" class="form-control" id="stock_max" value="$ren[stock_max]" required>
    </div>
    <div class="col-2">
      <label for="stock_min" class="form-label">Stock minimo</label>
      <input type="number" class="form-control" id="stock_min" value="$ren[stock_min]" required>
    </div>
    <div class="col-md-2">
      <label for="cantidad" class="form-label">Stock Actual</label>
      <input type="text" class="form-control" id="cantidad" value="$ren[cantidad]" required>
    </div>
    <div class="col-md-2">
    <label for="precio_pro" class="form-label">Precio</label>
    <input type="text" class="form-control" id="precio_pro" value="$ren[precio_pro]" required>
    </div>
    <div class="col-md-4">
      <img src="$img" width='100' alt="...">
    </div>
    <div class="col-md-4">
      <label for="imagen" class="form-label">Imagen</label>
      <input type="file" class="form-control" id="imagen">
    </div>
    
 
    <div class="col-12">
      <button type="submit" class="btn btn-primary">Modificar Producto</button>
    </div>
    </form>
    <br>
    </div>
    HDOC;
    }
    return $tabla;
}

function viewReportes($datos,$clientes)
{
    $sumatotal=0;
    $licli = "";
    while ($ren = $clientes->fetch_array(MYSQLI_ASSOC)) {
        $licli .= <<<HDOC
            <option value="$ren[id_cli]"> $ren[nombre_per] $ren[ap_per]</option>
        HDOC;
    }
    $tabla = <<<HDOC
    <form class="row g-4" action="javascript:buscarVentasHechas()" method="POST">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid pl-1">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
          <div class="input-group mb-3">
            <input type="date" class="form-control" id="bfecha1" aria-label="Username" aria-describedby="basic-addon1" required>
          </div>
          </li>
          <li class="nav-item">
          <div class="input-group mb-3">
            <input type="date" class="form-control" id="bfecha2" aria-label="Username" aria-describedby="basic-addon1" required>
          </div>
          </li>
          <li class="nav-item">
          <select class="form-select" aria-label="Default select example" id="bcliente">
          <option value = "0" selected> Todos los clientes </option>
          $licli
          </select>
          </li>
          <li class="nav-item text-light">
          <div class="form-check form-check-inline ">
          <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="contado">
          <label class="form-check-label" for="inlineRadio1">Contado</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="credito">
          <label class="form-check-label" for="inlineRadio2">Credito</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="ambos" checked>
          <label class="form-check-label" for="inlineRadio3">Ambos</label>
        </div>
          </li>
          <li class="nav-item">
          <div class="input-group mb-3">
          <button type="Submit" class="btn btn-primary">Buscar</button>
          </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  </form>
HDOC;
    $tabla .= <<<HDOC
    <div class='container'>
    <table  class='table table-striped table-hover'>
        <thead>
            <tr>
                <th>Numero</th>
                <th>Fecha de la venta</th>
                <th>Total</th>
                <th>Nombre del cliente</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id = "bodytablareportes">
    HDOC;
    $cont = 0;
    while ($ren = $datos->fetch_array(MYSQLI_ASSOC)) {
        $cont++;
        $tabla .= <<<HDOC
        <tr id='r$ren[id_tic]'>
        <td>$cont</td>
        <td>$ren[fechaventa_tic]</td>
        <td>$$ren[total_tic].00</td>
        <td>$ren[nombre_per] $ren[ap_per]</td>
        <td>
        <button type="button" class="btn btn-success " onclick='javascript:detallesVenta($ren[id_tic])'>Informacion</button>
        </td>
           </tr> 
        HDOC;
        $sumatotal+=$ren["total_tic"];
    }
    if($datos->num_rows <= 0) {
        $tabla .= <<<HDOC
        <tr>
        <td> <h3> Sin ventas en el dia o rango de dias </h3> </td>
        </tr> 
        HDOC;
    }else{
        $tabla .= <<<HDOC
        <td>
        <div class="alert alert-success" role="alert">
        <h5>Numero de ventas $cont</h5></div>
        </td>
        <td>
        <FORM action="../pruebapdf.php" method="post" target="_blank" >
        <input type="hidden" value="0" id="hfecha" name="fecha1">
        <input type="hidden" value="0" id="hfecha2" name="fecha2">
        <input type="hidden" value="0" id="hcliente" name="cliente">
        <input type="hidden" value="ambos" id="hradio" name="radio">
        <button type="submit" class="btn btn-secondary" onclick="">Descargar Pdf</button>
        </FORM>
        </td>
        <td>
        <FORM action="../php/generarecxel.php" method="post" target="_blank" >
        <input type="hidden" value="0" id="hfecha" name="fecha1">
        <input type="hidden" value="0" id="hfecha2" name="fecha2">
        <input type="hidden" value="0" id="hcliente" name="cliente">
        <input type="hidden" value="ambos" id="hradio" name="radio">
        <button type="submit" class="btn btn-success" onclick="">Descargar Excel</button>
        </FORM>
        </td>
        <td>
        <div class="alert alert-success" role="alert">
        <h4> Total: $$sumatotal.00</h4></div>
        </td>
        HDOC;
    }
    $tabla .= "</tbody></table></div>";
    return $tabla;
}

function viewbusqueda($datos,$fecha1,$fecha2,$cliente,$radio)
{
    $tabla = "";
    $sumatotal=0;
    $cont = 0;
    while ($ren = $datos->fetch_array(MYSQLI_ASSOC)) {
        $cont++;
        $tabla .= <<<HDOC
        <tr id='r$ren[id_tic]'>
        <td>$cont</td>
        <td>$ren[fechaventa_tic]</td>
        <td>$$ren[total_tic].00</td>
        <td>$ren[nombre_per] $ren[ap_per]</td>
        <td>
        <button type="button" class="btn btn-success " onclick='javascript:detallesVenta($ren[id_tic])'>Informacion</button>
        </td>
           </tr> 
        HDOC;
        $sumatotal+=$ren["total_tic"];
    }
    if($datos->num_rows <= 0) {
        $tabla .= <<<HDOC
        <tr>
        <td> <h3> Sin ventas en el dia o rango de dias </h3> </td>
        </tr> 
        HDOC;
    }else{
        $tabla .= <<<HDOC
        <td>
        <div class="alert alert-success" role="alert">
        <h5>Numero de ventas $cont</h5></div>
        </td>
        <td>
        <FORM action="../pruebapdf.php" method="post" target="_blank" >
        <input type="hidden" value="$fecha1" id="hfecha" name="fecha1">
        <input type="hidden" value="$fecha2" id="hfecha2" name="fecha2">
        <input type="hidden" value="$cliente" id="hcliente" name="cliente">
        <input type="hidden" value="$radio" id="hradio" name="radio">
        <button type="submit" class="btn btn-secondary" onclick="">Descargar Pdf</button>
        </FORM>
        </td>
        <td>
        <FORM action="../php/generarecxel.php" method="post" target="_blank" >
        <input type="hidden" value="$fecha1" id="hfecha" name="fecha1">
        <input type="hidden" value="$fecha2" id="hfecha2" name="fecha2">
        <input type="hidden" value="$cliente" id="hcliente" name="cliente">
        <input type="hidden" value="$radio" id="hradio" name="radio">
        <button type="submit" class="btn btn-success" onclick="">Descargar Excel</button>
        </FORM>
        </td>
        <td>
        <div class="alert alert-success" role="alert">
        <h4> Total: $$sumatotal.00</h4></div>
        </td>

        HDOC;
    }
    return $tabla;
}

function viewdetallesVenta($datos)
{
    $sumatotal=0;
    $tabla = <<<HDOC
    <div class='container'>
    <table  class='table table-striped table-hover'>
        <thead>
            <tr>
                <th>#</th>
                <th>Codigo</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Importe</th>
            </tr>
        </thead>
        <tbody id = "bodytablareportes">
    HDOC;
    $cont = 0;
    while ($ren = $datos->fetch_array(MYSQLI_ASSOC)) {
        $cont++;
        $tabla .= <<<HDOC
        <tr>
        <td>$cont</td>
        <td>$ren[codigo_pro]</td>
        <td>$ren[nombre_pro]</td>
        <td>$ren[cantidad_ren]</td>
        <td>$$ren[precio_pro].00</td>
        <td>$$ren[importe].00</td>
           </tr> 
        HDOC;
        $sumatotal+=$ren["importe"];
    }
    if($datos->num_rows <= 0) {
        $tabla .= <<<HDOC
        <tr>
        <td> <h3> Error al cargar los productos </h3> </td>
        </tr> 
        HDOC;
    }else{
        $tabla .= <<<HDOC
        <td>
        <div class="alert alert-success" role="alert">
        <h5>Numero de productos $cont</h5></div>
        </td>
        <td>
        -
        </td>
        <td>
        -
        </td>
        <td>
        <div class="alert alert-success" role="alert">
        <h4> Total: $$sumatotal.00</h4></div>
        </td>
        HDOC;
    }
    $tabla .= "</tbody></table></div>";
    return $tabla;
}

function cuentaLiquidada($mensaje) {
    return <<<HDOC
    <div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>¡Felicidades!</strong>$mensaje<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>
    HDOC;
}