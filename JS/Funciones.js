var menu = "";
var tablaProductos = "";
var productos = [];
var contenidoProductos = "";
var tuplas = {
    'datos': []
};
var total = 0;

function login() {
    var datos = new FormData();
    var sol = new XMLHttpRequest;
    datos.append(`mostrarLogin`, `User`);
    sol.addEventListener('load', function(e) {
        document.getElementsByClassName(`main`)[0].innerHTML = e.target.responseText;
    }, false);

    sol.open('POST', '../PHP/Controlador.php', true);
    sol.send(datos);
}

login();

function inicioSesion() {
    var datos = new FormData();
    var sol = new XMLHttpRequest;
    datos.append(`signin`, `User`);
    // datos.append(`username`, document.get)
    let form = document.querySelector("#form");
    datos.append(`username`, form.username.value);
    datos.append(`password`, form.password.value);
    sol.addEventListener('load', function(e) {
        if(e.target.responseText != "Nombre de usuario o contraseña incorrectos") {
            menu = e.target.responseText;
            document.getElementsByClassName(`main`)[0].innerHTML = e.target.responseText;
        }
        else {
            alert("Usuario o contraseña incorrectos");
        }
    }, false);

    sol.open('POST', '../PHP/Controlador.php', true);
    sol.send(datos);
}

function verUsuarios() {
    var datos = new FormData();
    var sol = new XMLHttpRequest;
    datos.append('usuarioLogueado', document.getElementsByClassName(`usuario_logueado`)[0].id);
    datos.append(`verUsuarios`, `usuarios`);
    sol.addEventListener('load', function(e) {
        document.getElementsByClassName(`main`)[0].innerHTML = menu + e.target.responseText;
    }, false);
    sol.open('POST', '../PHP/Controlador.php', true);
    sol.send(datos);
}

function verUsuariosMensaje(mensaje) {
    var datos = new FormData();
    var sol = new XMLHttpRequest;
    datos.append('usuarioLogueado', document.getElementsByClassName(`usuario_logueado`)[0].id);
    datos.append(`verUsuarios`, `usuarios`);
    mensaje = `
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            ${mensaje}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
    sol.addEventListener('load', function(e) {
        document.getElementsByClassName(`main`)[0].innerHTML = menu + mensaje + e.target.responseText;
    }, false);
    sol.open('POST', '../PHP/Controlador.php', true);
    sol.send(datos);
}

function mostrarDetalles(id) {
    var datos = new FormData();
    var sol = new XMLHttpRequest;
    datos.append(`detalleUsuario`, `${id}`);
    sol.addEventListener('load', function(e) {
        document.getElementsByClassName(`main`)[0].innerHTML = menu + e.target.responseText;
    }, false);
    sol.open('POST', '../PHP/Controlador.php', true);
    sol.send(datos);
}

function vistaModificar(id) {
    var datos = new FormData();
    var sol = new XMLHttpRequest;
    datos.append(`vistaModificar`, `${id}`);
    sol.addEventListener('load', function(e) {
        document.getElementsByClassName(`main`)[0].innerHTML = menu + e.target.responseText;
    }, false);
    sol.open('POST', '../PHP/Controlador.php', true);
    sol.send(datos);
}

function modificar(id) {
    let result = "";
    var datos = new FormData();
    var sol = new XMLHttpRequest;
    datos.append(`modificar`, `${id}`);
    let form = document.querySelector("#form");
    let combo = document.getElementById("sexo");
    let sexo = combo.options[combo.selectedIndex].text;
    datos.append(`nombre`, form.nombre.value);
    datos.append(`paterno`, form.paterno.value);
    datos.append(`materno`, form.materno.value);
    datos.append(`sexo`, `${sexo}`);
    datos.append(`telefono`, form.telefono.value);
    datos.append(`correo`, form.correo.value);
    datos.append(`puesto`, form.puesto.value);
    if (form.file.files.length > 0) {
        datos.append(`fotoPerfil`, form.file.files[0]);
    }
    sol.addEventListener('load', function(e) {
        // document.getElementsByClassName(`main`)[0].innerHTML = menu;
        verUsuariosMensaje(`Empleado ${form.nombre.value} actualizado`);
    }, false);
    sol.open('POST', '../PHP/Controlador.php', true);
    sol.send(datos);
}

function nuevoEmpleado() {
    var datos = new FormData();
    var sol = new XMLHttpRequest;
    datos.append('interfazUsuario', 'nuevoUsuario');
    sol.addEventListener('load', function(e) {
        document.getElementsByClassName(`main`)[0].innerHTML = menu + e.target.responseText;
    }, false);

    sol.open('POST', '../PHP/Controlador.php', true);
    sol.send(datos);
}

function nuevoUsuario() {
    var datos = new FormData();
    var sol = new XMLHttpRequest;
    let sex = null;
    let form = document.querySelector("#form");
    if (document.getElementById(`woman`).checked) {
        sex = document.getElementById(`woman`).value;
    } else if (document.getElementById(`man`).checked) {
        sex = document.getElementById(`man`).value;
    }
    datos.append(`nuevoUsuario`, `newUser`);
    datos.append(`nombre`, form.nombre.value);
    datos.append(`paterno`, form.paterno.value);
    datos.append(`materno`, form.materno.value);
    datos.append(`sexo`, `${sex}`);
    datos.append(`telefono`, form.telefono.value);
    datos.append(`correo`, form.correo.value);
    if (form.file.files.length > 0) {
        datos.append(`fotoPerfil`, form.file.files[0]);
    }
    datos.append(`username`, form.username.value);
    datos.append(`password`, form.password.value);
    datos.append(`repeat`, form.puesto.value);
    sol.addEventListener('load', function(e) {
        console.log(e.target.responseText);
    }, false);

    sol.open('POST', '../PHP/Controlador.php', true);
    sol.send(datos);
    verUsuariosMensaje(`Usuario nuevo creado: ${form.nombre.value}`);
}

function eliminarEmpleado(id) {
    var datos = new FormData();
    var sol = new XMLHttpRequest;
    datos.append(`eliminarEmpleado`, `${id}`);
    sol.addEventListener('load', function(e) {
        verUsuariosMensaje(`El empleado con id: ${id} ha sido eliminado`);
    }, false);

    sol.open('POST', '../PHP/Controlador.php', true);
    sol.send(datos);
}

function venderSinMensaje() {
    productos = [];
    var datos = new FormData();
    var sol = new XMLHttpRequest;
    datos.append(`venderProductos`, `vender`);
    contenidoProductos = "";
    tablaProductos = "";
    tuplas = {
        'datos': []
    };
    sol.addEventListener('load', function(e) {
        tablaProductos = e.target.responseText;
        document.getElementsByClassName(`main`)[0].innerHTML = menu + e.target.responseText;
    }, false);

    sol.open('POST', '../PHP/Controlador.php', true);
    sol.send(datos);
}

function venderMensaje(mensaje) {
    productos = [];
    var datos = new FormData();
    var sol = new XMLHttpRequest;
    mensaje = `
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            ${mensaje}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
    datos.append(`venderProductos`, `vender`);
    contenidoProductos = "";
    tablaProductos = "";
    tuplas = {
        'datos': []
    };
    sol.addEventListener('load', function(e) {
        tablaProductos = e.target.responseText;
        document.getElementsByClassName(`main`)[0].innerHTML = menu + mensaje + e.target.responseText;
    }, false);

    sol.open('POST', '../PHP/Controlador.php', true);
    sol.send(datos);
}

function buscarProducto() {
    var datos = new FormData();
    var sol = new XMLHttpRequest;
    let form = document.querySelector("#form");
    datos.append(`agregar`, `agregar`);
    datos.append(`codigoBarras`, `${form.producto.value}`);
    sol.addEventListener('load', function(e) {
        if (e.target.responseText) {
            agregarProducto(form.producto.value);
        } else {
            document.getElementsByClassName(`main`)[0].innerHTML = menu + "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Error</strong> Producto no encontrado o sin existencia.<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>" + tablaProductos + contenidoProductos;
        }
    }, false);

    sol.open('POST', '../PHP/Controlador.php', true);
    sol.send(datos);
}

function agregarProducto(codigoBarras) {
    var datos = new FormData();
    var sol = new XMLHttpRequest;
    if (productos.length != 0) {
        for (let i = 0; i < productos.length; i++) {
            if (productos[i] == codigoBarras) {
                agregarOtroProducto(codigoBarras);
                return;
            }
        }
    }
    productos.push(codigoBarras);
    let form = document.querySelector("#form");
    datos.append(`agregarProducto`, `agregar`);
    datos.append(`codigoBarras`, `${codigoBarras}`);
    datos.append(`productosAgregados`, `${productos}`);
    sol.addEventListener('load', function(e) {
        // e.target.responseText
        document.getElementsByClassName(`main`)[0].innerHTML = menu + tablaProductos + contenidoProductos + e.target.responseText;
        contenidoProductos += e.target.responseText;
    }, false);

    sol.open('POST', '../PHP/Controlador.php', true);
    sol.send(datos);
}

function agregarOtroProducto(producto) {
    let aumentar = document.getElementsByClassName(`${producto}`);
    if(aumentar[2].textContent == 0) {
        alert("Ya no hay productos en existencia");
        return;
    }
    aumentar[1].textContent = parseInt(aumentar[1].textContent) + 1;
    aumentar[2].textContent = parseInt(aumentar[2].textContent) - 1; 
    aumentar[4].textContent = parseInt(aumentar[1].textContent) * parseInt(aumentar[3].textContent);
    contenidoProductos = document.getElementsByTagName(`tbody`)[0].innerHTML;
}

function eliminarUnaPieza(producto) {
    let eliminar = document.getElementsByClassName(`${producto}`);
    if (eliminar[1].textContent == 1) {
        document.getElementsByTagName(`tbody`)[0].removeChild(document.getElementById(`${producto}`));
        contenidoProductos = document.getElementsByTagName(`tbody`)[0].innerHTML;
        removeItemFromArr(productos, `${producto}`);
        return;
    }
    eliminar[1].textContent = parseInt(eliminar[1].textContent) - 1;
    eliminar[2].textContent = parseInt(eliminar[2].textContent) + 1;
    eliminar[4].textContent = parseInt(eliminar[4].textContent) - (eliminar[3].textContent);
    contenidoProductos = document.getElementsByTagName(`tbody`)[0].innerHTML;
}

function removeItemFromArr(arr, item) {
    var i = arr.indexOf(item);
    arr.splice(i, 1);
}

function comprarContado() {
    if (document.getElementsByTagName(`tr`).length == 1) {
        alert("No hay productos");
    } else {
        if (tuplas.datos.length == 0) {
            let tr = document.getElementsByTagName(`tr`);
            for (let i = 1; i < tr.length; i++) {
                let datosArticulo = document.getElementsByClassName(`${tr[i].id}`);
                tuplas.datos.push({ "nombre": datosArticulo[0].textContent, "costounidad": datosArticulo[3].textContent, "cantidadcomprada": datosArticulo[1].textContent, "total": datosArticulo[4].textContent, "codigobarras": tr[i].id });
            };
        }
        var datos = new FormData();
        var sol = new XMLHttpRequest;
        datos.append(`comprarContado`, `contado`);
        sol.addEventListener('load', function(e) {
            document.getElementsByClassName(`main`)[0].innerHTML = menu + e.target.responseText;
            agregarProductos();
        }, false);

        sol.open('POST', '../PHP/Controlador.php', true);
        sol.send(datos);
    }
}

function comprarCredito() {
    if (document.getElementsByTagName(`tr`).length == 1) {
        alert("No hay productos");
    } else {
        if (tuplas.datos.length == 0) {
            let tr = document.getElementsByTagName(`tr`);
            for (let i = 1; i < tr.length; i++) {
                let datosArticulo = document.getElementsByClassName(`${tr[i].id}`);
                tuplas.datos.push({ "nombre": datosArticulo[0].textContent, "costounidad": datosArticulo[3].textContent, "cantidadcomprada": datosArticulo[1].textContent, "total": datosArticulo[4].textContent, "codigobarras": tr[i].id });
            };
        }
        var datos = new FormData();
        var sol = new XMLHttpRequest;
        datos.append(`comprarCredito`, `credito`);
        sol.addEventListener('load', function(e) {
            document.getElementsByClassName(`main`)[0].innerHTML = menu + e.target.responseText;
            agregarProductos();
        }, false);

        sol.open('POST', '../PHP/Controlador.php', true);
        sol.send(datos);
    }
}

function agregarProductos() {
    let lista = document.getElementById(`productosAComprar`);
    let totalAPagar = 0;
    for (let i = 0; i < tuplas.datos.length; i++) {
        console.log("Entra al for");
        let articulos = `
            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div class="ms-2 me-auto">
                    <div class="fw-bold">${tuplas.datos[i].nombre}</div>
                        <p>Costo por unidad: <strong>$${tuplas.datos[i].costounidad}</strong></p>
                        <p>Cantidad comprada: <strong>${tuplas.datos[i].cantidadcomprada}</strong></p>
                    <p>Total: <strong>$${tuplas.datos[i].total}</strong></p>
                </div>
            </li>
        `;
        totalAPagar += parseFloat(tuplas.datos[i].total);
        lista.innerHTML += articulos;
    }

    lista.innerHTML += `
        <li class="list-group-item d-flex justify-content-between align-items-start">
            <div class="ms-2 me-auto">
                <div class="fw-bold" style='font-size: 20px;' id='totalParaPagar'>$${totalAPagar}</div>
            </div>
        </li>
    `;
    total = totalAPagar;
}

function clienteRegistrado() {
    var datos = new FormData();
    var sol = new XMLHttpRequest;
    datos.append(`clientesRegistrados`, `clientes`);
    sol.addEventListener('load', function(e) {
        if (e.target.responseText != 0) { document.getElementsByClassName(`main`)[0].innerHTML = menu + e.target.responseText; } else { alert("No hay clientes registrados todavía"); }
    }, false);

    sol.open('POST', '../PHP/Controlador.php', true);
    sol.send(datos);
}

function pagarSinRegistro() {
    console.log(total);
    var datos = new FormData();
    var sol = new XMLHttpRequest;
    datos.append(`pagarContado`, `contado`);
    datos.append(`total`, total);
    datos.append('empleado', document.getElementsByClassName(`usuario_logueado`)[0].id);
    sol.addEventListener('load', function(e) {
        for (let i = 0; i < tuplas.datos.length; i++) {
            renglonTicket(tuplas.datos[i].cantidadcomprada, tuplas.datos[i].costounidad, tuplas.datos[i].codigobarras);
        }
        venderMensaje("La venta se ha realizado exitosamente");
    }, false);

    sol.open('POST', '../PHP/Controlador.php', true);
    sol.send(datos);
}

function renglonTicket(cantidad, precio, codigoBarras) {
    var datos = new FormData();
    var sol = new XMLHttpRequest;
    datos.append(`cantidad`, cantidad);
    datos.append(`precio`, precio);
    datos.append(`codigobarras`, codigoBarras);
    datos.append(`renglonticket`, `renglonticket`);
    sol.addEventListener('load', function(e) {
        console.log(e.target.responseText)
    }, false);

    sol.open('POST', '../PHP/Controlador.php', true);
    sol.send(datos);
}

function pagarNuevoCliente() {
    var datos = new FormData();
    var sol = new XMLHttpRequest;
    let sex = null;
    let form = document.querySelector("#formNuevoUsuario");
    if (document.getElementById(`woman`).checked) {
        sex = document.getElementById(`woman`).value;
    } else if (document.getElementById(`man`).checked) {
        sex = document.getElementById(`man`).value;
    }
    datos.append(`pagarRegistro`, `newUser`);
    datos.append(`nombre`, form.nombre.value);
    datos.append(`paterno`, form.paterno.value);
    datos.append(`materno`, form.materno.value);
    datos.append(`sexo`, `${sex}`);
    datos.append(`telefono`, form.telefono.value);
    datos.append(`correo`, form.correo.value);
    let total = parseFloat(document.getElementById(`totalParaPagar`).textContent.replace("$", ""));
    datos.append(`total`, total);
    datos.append('empleado', document.getElementsByClassName(`usuario_logueado`)[0].id);
    if (form.file.files.length > 0) {
        datos.append(`fotoPerfil`, form.file.files[0]);
    }
    sol.addEventListener('load', function(e) {
        for (let i = 0; i < tuplas.datos.length; i++) {
            renglonTicket(tuplas.datos[i].cantidadcomprada, tuplas.datos[i].costounidad, tuplas.datos[i].codigobarras);
        }
        venderMensaje("La venta y el registro del cliente fue exitosa");
    }, false);

    sol.open('POST', '../PHP/Controlador.php', true);
    sol.send(datos);
}

function comprarMisProductos(id_cli) {
    var datos = new FormData();
    var sol = new XMLHttpRequest;
    datos.append(`pagarClienteExistente`, `${id_cli}`);
    datos.append(`total`, total);
    datos.append('empleado', document.getElementsByClassName(`usuario_logueado`)[0].id);
    sol.addEventListener('load', function(e) {
        for (let i = 0; i < tuplas.datos.length; i++) {
            renglonTicket(tuplas.datos[i].cantidadcomprada, tuplas.datos[i].costounidad, tuplas.datos[i].codigobarras);
        }
        venderMensaje("La venta se ha realizado exitosamente");
    }, false);

    sol.open('POST', '../PHP/Controlador.php', true);
    sol.send(datos);
}

function pagarNuevoClienteCredito() {
    var datos = new FormData();
    var sol = new XMLHttpRequest;
    let sex = null;
    let form = document.querySelector("#formNuevoUsuario");
    let pagoInicial = "";
    if (form.pagoInicial.value != "") { pagoInicial = form.pagoInicial.value; }
    if (document.getElementById(`woman`).checked) {
        sex = document.getElementById(`woman`).value;
    } else if (document.getElementById(`man`).checked) {
        sex = document.getElementById(`man`).value;
    }
    datos.append(`pagarRegistro`, `newUser`);
    datos.append(`nombre`, form.nombre.value);
    datos.append(`paterno`, form.paterno.value);
    datos.append(`materno`, form.materno.value);
    datos.append(`sexo`, `${sex}`);
    datos.append(`telefono`, form.telefono.value);
    datos.append(`correo`, form.correo.value);
    let total = parseFloat(document.getElementById(`totalParaPagar`).textContent.replace("$", ""));
    datos.append(`total`, total);
    datos.append('empleado', document.getElementsByClassName(`usuario_logueado`)[0].id);
    if (form.file.files.length > 0) {
        datos.append(`fotoPerfil`, form.file.files[0]);
    }
    sol.addEventListener('load', function(e) {
        for (let i = 0; i < tuplas.datos.length; i++) {
            renglonTicket(tuplas.datos[i].cantidadcomprada, tuplas.datos[i].costounidad, tuplas.datos[i].codigobarras);
        }
        agregarCredito(pagoInicial);
        venderMensaje("La venta y el registro del cliente fue exitosa");
    }, false);

    sol.open('POST', '../PHP/Controlador.php', true);
    sol.send(datos);
}

function agregarCredito(pagoInicial) {
    var datos = new FormData();
    var sol = new XMLHttpRequest;
    datos.append(`pagoinicial`, `${pagoInicial}`);
    datos.append(`agregarcreditonuevo`, `credito`);
    datos.append('empleado', document.getElementsByClassName(`usuario_logueado`)[0].id);
    sol.addEventListener('load', function(e) {
        console.log(e.target.responseText);
    }, false);

    sol.open('POST', '../PHP/Controlador.php', true);
    sol.send(datos);
}

function clienteRegistradoCredito() {
    total = parseFloat(document.getElementById(`totalParaPagar`).textContent.replace("$", ""));
    var datos = new FormData();
    var sol = new XMLHttpRequest;
    datos.append(`clientesRegistradosCredito`, `clientes`);
    sol.addEventListener('load', function(e) {
        if (e.target.responseText != 0) { document.getElementsByClassName(`main`)[0].innerHTML = menu + e.target.responseText; } else { alert("No hay clientes registrados todavía"); }
    }, false);

    sol.open('POST', '../PHP/Controlador.php', true);
    sol.send(datos);
}

function comprarMisProductosCredito(id_cliente) {
    var datos = new FormData();
    var sol = new XMLHttpRequest;
    let pagoInicial = document.getElementById(`pagoInicial`).value;
    datos.append(`pagarClienteExistenteCredito`, `${id_cliente}`);
    datos.append(`total`, total);
    datos.append('empleado', document.getElementsByClassName(`usuario_logueado`)[0].id);
    sol.addEventListener('load', function(e) {
        for (let i = 0; i < tuplas.datos.length; i++) {
            renglonTicket(tuplas.datos[i].cantidadcomprada, tuplas.datos[i].costounidad, tuplas.datos[i].codigobarras);
        }
        agregarCredito(pagoInicial);
        venderMensaje("La venta se a crédito se ha realizado exitosamente");
    }, false);

    sol.open('POST', '../PHP/Controlador.php', true);
    sol.send(datos);
}

function verCredito(mensaje) {
    var datos = new FormData();
    var sol = new XMLHttpRequest;
    datos.append(`vercredito`, `credito`);
    sol.addEventListener('load', function(e) {
        document.getElementsByClassName(`main`)[0].innerHTML = menu + mensaje + e.target.responseText;
    }, false);

    sol.open('POST', '../PHP/Controlador.php', true);
    sol.send(datos);
}

function nombreCliente() {
    var datos = new FormData();
    var sol = new XMLHttpRequest;
    console.log(document.getElementById('nombre').value);
    datos.append(`filtrarnombre`, `${document.getElementById('nombre').value}`);
    sol.addEventListener('load', function(e) {
        document.getElementsByClassName(`main`)[0].innerHTML = menu + e.target.responseText;
    }, false);

    sol.open('POST', '../PHP/Controlador.php', true);
    sol.send(datos);
}

function nombreProducto() {
    var datos = new FormData();
    var sol = new XMLHttpRequest;
    console.log(document.getElementById('producto').value);
    datos.append(`filtrarproducto`, `${document.getElementById('producto').value}`);
    sol.addEventListener('load', function(e) {
        document.getElementsByClassName(`main`)[0].innerHTML = menu + e.target.responseText;
    }, false);

    sol.open('POST', '../PHP/Controlador.php', true);
    sol.send(datos);
}

function verDetallesCredito(id_cre, mensaje) {
    var datos = new FormData();
    var sol = new XMLHttpRequest;
    let alerta = "";
    if(mensaje != "") {
        alerta = `
            <div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Error</strong> ${mensaje}<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>
        `;
    }
    datos.append(`detallescredito`, `${id_cre}`);
    sol.addEventListener('load', function(e) {
        document.getElementsByClassName(`main`)[0].innerHTML = menu + alerta + e.target.responseText;
    }, false);

    sol.open('POST', '../PHP/Controlador.php', true);
    sol.send(datos);
}

function liquidarCuenta(idCredito) {
    let abono = document.getElementById(`abono`).value;
    console.log(abono);
    let totalPagar = document.getElementsByTagName(`h3`)[0].innerText;
    totalPagar = totalPagar.substr(15);
    if(parseInt(abono) >= parseInt(totalPagar)) {
        var datos = new FormData();
        var sol = new XMLHttpRequest;
        datos.append(`liquidar`, `${idCredito}`);
        datos.append(`abono`, `${abono}`);
        datos.append('empleado', document.getElementsByClassName(`usuario_logueado`)[0].id);
        sol.addEventListener('load', function(e) {
            verCredito(e.target.responseText);
        }, false);

        sol.open('POST', '../PHP/Controlador.php', true);
        sol.send(datos);
    }
    else { verDetallesCredito(idCredito, "La cantidad de dinero no alcanza para liquidar la cuenta.") }
}

function verProductos() {
    var datos = new FormData();
    var sol = new XMLHttpRequest;
    datos.append(`listarProductos`, `all`);
    sol.addEventListener('load', function(e) {
        document.getElementsByClassName(`main`)[0].innerHTML = menu + e.target.responseText;
    }, false);

    sol.open('POST', '../PHP/Controlador.php', true);
    sol.send(datos);
}

function viewAddProduct() {
    var datos = new FormData();
    var sol = new XMLHttpRequest;
    datos.append(`viewAddProduct`, `new`);
    sol.addEventListener('load', function(e) {
        document.getElementsByClassName(`main`)[0].innerHTML = menu + e.target.responseText;
    }, false);

    sol.open('POST', '../PHP/Controlador.php', true);
    sol.send(datos);
}

function AddProduct() {
    var datos = new FormData();
    var sol = new XMLHttpRequest;

    let codigo_pro = document.getElementById("codigo_pro");
    let nombre_pro = document.getElementById("nombre_pro");
    let stock_max = document.getElementById("stock_max");
    let stock_min = document.getElementById("stock_min");
    let cantidad = document.getElementById("cantidad");
    let precio_pro = document.getElementById("precio_pro");
    let imagen = document.getElementById("imagen");

    datos.append(`AddProduct`, `new`);
    datos.append(`codigo_pro`, codigo_pro.value);
    datos.append(`nombre_pro`, nombre_pro.value);
    datos.append(`stock_max`, stock_max.value);
    datos.append(`stock_min`, stock_min.value);
    datos.append(`cantidad`, cantidad.value);
    datos.append(`precio_pro`, precio_pro.value);
    //datos.append("imagen", imagen.files[0]);
    if (imagen.files.length > 0) {
        datos.append(`imagen`, imagen.files[0]);
    }
    //if ((/\.(jpg|png|gif|jpeg)$/i).test(imagen.files[0].name)) {
    sol.addEventListener('load', function(e) {
        console.log(e.target.responseText);
        if (e.target.responseText == "200") {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Producto agregado correctamente',
                showConfirmButton: false,
                timer: 3000
            })
            verProductos();
        } else {
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Error Hubo un problema al guardar',
                showConfirmButton: false,
                timer: 1500
            })
        }

    }, false);

    sol.open('POST', '../PHP/Controlador.php', true);
    sol.send(datos);
    /*} else {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Archivo no aceptado!'
        })
    }*/

}

function detallesProductos(id_pro) {
    var datos = new FormData();
    var sol = new XMLHttpRequest;
    datos.append(`informacionProducto`, `new`);
    datos.append(`id_pro`, id_pro);

    sol.addEventListener('load', function(e) {
        document.getElementsByClassName(`main`)[0].innerHTML = menu + e.target.responseText;
    }, false);

    sol.open('POST', '../PHP/Controlador.php', true);
    sol.send(datos);
}

function viewDeleteProducto(id_pro) {
    var datos = new FormData();
    var sol = new XMLHttpRequest;
    datos.append(`viewDeleteProducto`, `new`);
    datos.append(`id_pro`, id_pro);

    sol.addEventListener('load', function(e) {
        document.getElementsByClassName(`main`)[0].innerHTML = menu + e.target.responseText;
    }, false);

    sol.open('POST', '../PHP/Controlador.php', true);
    sol.send(datos);
}


function DeleteProducto(id_pro) {
    var datos = new FormData();
    var sol = new XMLHttpRequest;

    datos.append(`deleteProducto`, `del`);
    datos.append("id_pro", id_pro);

    sol.addEventListener('load', function(e) {
        if (e.target.responseText == "200") {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Producto Eliminado correctamente',
                showConfirmButton: false,
                timer: 3000
            })
            verProductos();
        } else {
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Error Hubo un problema al Eliminar',
                showConfirmButton: false,
                timer: 3000
            })
        }

    }, false);
    Swal.fire({
        title: '¿Estas seguro de eliminar este producto?',
        text: "Esta accion no se puede deshacer!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, borrar!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            sol.open('POST', '../PHP/Controlador.php', true);
            sol.send(datos);
        }
    })

}

function bajaProducto(id_pro) {
    var datos = new FormData();
    var sol = new XMLHttpRequest;

    datos.append(`bajaProducto`, `del`);
    datos.append("id_pro", id_pro);
    console.log("clickbaja");
    sol.addEventListener('load', function(e) {
        if (e.target.responseText == "200") {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Producto dado de baja correctamente',
                showConfirmButton: false,
                timer: 3000
            })
            verProductos();
        } else {
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Error Hubo un problema al dar de baja',
                showConfirmButton: false,
                timer: 3000
            })
        }

    }, false);

    sol.open('POST', '../PHP/Controlador.php', true);
    sol.send(datos);
}

function verClientes() {
    var datos = new FormData();
    var sol = new XMLHttpRequest;
    datos.append(`verClientes`, `clientes`);
    sol.addEventListener('load', function(e) {
        document.getElementsByClassName(`main`)[0].innerHTML = menu + e.target.responseText;
    }, false);

    sol.open('POST', '../PHP/Controlador.php', true);
    sol.send(datos);
}

function verClientesMensaje(mensaje) {
    var datos = new FormData();
    var sol = new XMLHttpRequest;
    datos.append(`verClientes`, `clientes`);
    mensaje = `
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            ${mensaje}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
    sol.addEventListener('load', function(e) {
        document.getElementsByClassName(`main`)[0].innerHTML = menu + mensaje + e.target.responseText;
    }, false);
    sol.open('POST', '../PHP/Controlador.php', true);
    sol.send(datos);
}

function detallesCliente(id_cliente) {
    var datos = new FormData();
    var sol = new XMLHttpRequest;
    datos.append(`detalleCliente`, `${id_cliente}`);
    sol.addEventListener('load', function(e) {
        document.getElementsByClassName(`main`)[0].innerHTML = menu + e.target.responseText;
    }, false);

    sol.open('POST', '../PHP/Controlador.php', true);
    sol.send(datos);
}

function vistaModificarCliente(id_cliente) {
    var datos = new FormData();
    var sol = new XMLHttpRequest;
    datos.append(`vistaModificarCliente`, `${id_cliente}`);
    sol.addEventListener('load', function(e) {
        document.getElementsByClassName(`main`)[0].innerHTML = menu + e.target.responseText;
    }, false);

    sol.open('POST', '../PHP/Controlador.php', true);
    sol.send(datos);
}

function modificarCliente(id) {
    var datos = new FormData();
    var sol = new XMLHttpRequest;
    datos.append(`modificarCliente`, `${id}`);
    let form = document.querySelector("#form");
    let combo = document.getElementById("sexo");
    let sexo = combo.options[combo.selectedIndex].text;
    datos.append(`nombre`, form.nombre.value);
    datos.append(`paterno`, form.paterno.value);
    datos.append(`materno`, form.materno.value);
    datos.append(`sexo`, `${sexo}`);
    datos.append(`telefono`, form.telefono.value);
    datos.append(`correo`, form.correo.value);
    if (form.file.files.length > 0) {
        datos.append(`fotoPerfil`, form.file.files[0]);
    }
    sol.addEventListener('load', function(e) {
        // document.getElementsByClassName(`main`)[0].innerHTML = menu;
        verClientesMensaje(`Cliente ${form.nombre.value} actualizado`);
    }, false);
    sol.open('POST', '../PHP/Controlador.php', true);
    sol.send(datos);
}

function eliminarCliente(id_cli) {
    var datos = new FormData();
    var sol = new XMLHttpRequest;
    datos.append(`eliminarCliente`, `${id_cli}`);
    sol.addEventListener('load', function(e) {
        verClientesMensaje(`Cliente eliminado con éxito`);
    }, false);
    sol.open('POST', '../PHP/Controlador.php', true);
    sol.send(datos);
}

function viewModificarProducto(id) {
    var datos = new FormData();
    var sol = new XMLHttpRequest;
    datos.append(`vistaModificarProducto`, id);
    datos.append(`id_pro`, id);
    sol.addEventListener('load', function(e) {
        document.getElementsByClassName(`main`)[0].innerHTML = menu + e.target.responseText;
    }, false);
    sol.open('POST', '../PHP/Controlador.php', true);
    sol.send(datos);
}

function ModificarProducto() {
    var datos = new FormData();
    var sol = new XMLHttpRequest;
    let id_pro = document.getElementById("id_pro");
    let codigo_pro = document.getElementById("codigo_pro");
    let nombre_pro = document.getElementById("nombre_pro");
    let stock_max = document.getElementById("stock_max");
    let stock_min = document.getElementById("stock_min");
    let cantidad = document.getElementById("cantidad");
    let precio_pro = document.getElementById("precio_pro");
    let imagen = document.getElementById("imagen");

    datos.append(`UpdateProducto`, `new`);
    datos.append(`id_pro`, id_pro.value);
    datos.append(`codigo_pro`, codigo_pro.value);
    datos.append(`nombre_pro`, nombre_pro.value);
    datos.append(`stock_max`, stock_max.value);
    datos.append(`stock_min`, stock_min.value);
    datos.append(`cantidad`, cantidad.value);
    datos.append(`precio_pro`, precio_pro.value);
    console.log(imagen.files.length);
    if (imagen.files.length > 0) {
        datos.append(`imagen`, imagen.files[0]);
    }

    sol.addEventListener('load', function(e) {
        console.log(e.target.responseText);
        if (e.target.responseText == "200") {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Producto Modificado correctamente',
                showConfirmButton: false,
                timer: 3000
            })
            verProductos();
        } else {
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: 'Error Hubo un problema al Modificar',
                showConfirmButton: false,
                timer: 1500
            })
        }

    }, false);

    sol.open('POST', '../PHP/Controlador.php', true);
    sol.send(datos);
}

function verVentasHechas() {
    var datos = new FormData();
    var sol = new XMLHttpRequest;
    datos.append(`viewReportes`, `all`);

    sol.addEventListener('load', function(e) {
        document.getElementsByClassName(`main`)[0].innerHTML = menu + e.target.responseText;
    }, false);

    sol.open('POST', '../PHP/Controlador.php', true);
    sol.send(datos);
}

function buscarVentasHechas() {
    var datos = new FormData();
    var sol = new XMLHttpRequest;

    let fecha1 = document.getElementById("bfecha1");
    let fecha2 = document.getElementById("bfecha2");
    let cliente = document.getElementById("bcliente");
    let radio = document.querySelector('input[name="inlineRadioOptions"]:checked');
    datos.append(`buscarVentas`, `all`);
    datos.append(`fecha1`, fecha1.value);
    datos.append(`fecha2`, fecha2.value);
    datos.append(`cliente`, cliente.value);
    datos.append(`radio`, radio.value);
    sol.addEventListener('load', function(e) {
        document.getElementById(`bodytablareportes`).innerHTML = e.target.responseText;
    }, false);

    sol.open('POST', '../PHP/Controlador.php', true);
    sol.send(datos);
}

function buscarVentasHechaspdf() {
    var datos = new FormData();
    var sol = new XMLHttpRequest;

    let fecha1 = document.getElementById("bfecha1");
    let fecha2 = document.getElementById("bfecha2");
    let cliente = document.getElementById("bcliente");
    let radio = document.getElementById('radio');
    datos.append(`buscarVentas`, `all`);
    datos.append(`fecha1`, fecha1.value);
    datos.append(`fecha2`, fecha2.value);
    datos.append(`cliente`, cliente.value);
    datos.append(`radio`, radio.value);
    sol.addEventListener('load', function(e) {
        document.getElementById(`bodytablareportes`).innerHTML = e.target.responseText;
    }, false);

    sol.open('POST', '../PHP/Controlador.php', true);
    sol.send(datos);
}

function detallesVenta(id_tic) {
    var datos = new FormData();
    var sol = new XMLHttpRequest;
    datos.append(`detallesVenta`, `new`);
    datos.append(`id_tic`, id_tic);

    sol.addEventListener('load', function(e) {
        document.getElementsByClassName(`main`)[0].innerHTML = menu + e.target.responseText;
    }, false);

    sol.open('POST', '../PHP/Controlador.php', true);
    sol.send(datos);
}