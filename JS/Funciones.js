var menu = "";
function login() {
    var datos = new FormData();
    var sol = new XMLHttpRequest;
    datos.append(`mostrarLogin`, `User`);
    sol.addEventListener('load', function(e) {
        document.getElementsByClassName(`main`)[0].innerHTML = e.target.responseText;
    }, false);

    sol.open('POST', '../PHP/Funciones.php',true);
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
        menu = e.target.responseText;
        document.getElementsByClassName(`main`)[0].innerHTML = e.target.responseText;
    }, false);

    sol.open('POST', '../PHP/Funciones.php',true);
    sol.send(datos);
}

function nuevoUsuario() {
    var datos = new FormData();
    var sol = new XMLHttpRequest;
    let sex = null;
    let form = document.querySelector("#form");
    if(document.getElementById(`woman`).checked) {
        sex = document.getElementById(`woman`).value;
    }
    else if(document.getElementById(`man`).checked) {
        sex = document.getElementById(`man`).value;
    }
    datos.append(`nuevoUsuario`, `newUser`);
    datos.append(`nombre`,form.nombre.value);
    datos.append(`paterno`, form.paterno.value);
    datos.append(`materno`, form.materno.value);
    datos.append(`sexo`, `${sex}`);
    datos.append(`telefono`, form.telefono.value);
    datos.append(`correo`, form.correo.value);
    if(form.file.files.length > 0) {
        datos.append(`fotoPerfil`, form.file.files[0]);
    }
    datos.append(`username`, form.username.value);
    datos.append(`password`, form.password.value);
    datos.append(`repeat`, form.repeatPass.value);
    sol.addEventListener('load', function(e) {
        console.log(e.target.responseText);
    }, false);

    sol.open('POST', '../PHP/Funciones.php',true);
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
    sol.open('POST', '../PHP/Funciones.php',true);
    sol.send(datos);
}

function mostrarDetalles(id) {
    var datos = new FormData();
    var sol = new XMLHttpRequest;
    datos.append(`detalleUsuario`, `${id}`);
    sol.addEventListener('load', function(e) {
        document.getElementsByClassName(`main`)[0].innerHTML = menu + e.target.responseText;
    }, false);
    sol.open('POST', '../PHP/Funciones.php',true);
    sol.send(datos);
}

function editarEmpleado(id) {

}

function eliminarEmpleado(id) {

}