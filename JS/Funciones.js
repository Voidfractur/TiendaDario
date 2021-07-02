// function moveSpan(input) {
//     if(input.id == `username`) {
//         document.getElementsByTagName(`label`)[0].style.borderBottom = `0.1rem solid #4285f4`;
//         let span = document.getElementsByTagName(`span`)[0];
//         span.style.top = `-0.8rem`;
//         span.style.color = `#4285f4`;
//     }
//     else {
//         document.getElementsByTagName(`label`)[1].style.borderBottom = `0.1rem solid #4285f4`;
//         let span = document.getElementsByTagName(`span`)[1];
//         span.style.top = `-0.8rem`;
//         span.style.color = `#4285f4`;
//     }
// }
// function resetSpan(input) {
//     if(input.id == `username`) {
//         if(input.value == ``) {
//             document.getElementsByTagName(`label`)[0].style.borderBottom = `0.1rem solid silver`;
//             let span = document.getElementsByTagName(`span`)[0];
//             span.style.top = `1rem`;
//             span.style.left = `1rem`;
//             span.style.backgroundColor = ``;
//             span.style.color = `silver`;
//         }
//     }
//     else {
//         if(input.value == ``) {
//             document.getElementsByTagName(`label`)[1].style.borderBottom = `0.1rem solid silver`;
//             let span = document.getElementsByTagName(`span`)[1];
//             span.style.top = `1rem`;
//             span.style.left = `1rem`;
//             span.style.backgroundColor = ``;
//             span.style.color = `silver`;
//         }
//     }
// }

// function movingSpan(input) {
//     document.getElementsByClassName(`${input.id}_label`)[0].style.border = `0.1rem solid #4285f4`;
//     let span = document.getElementsByClassName(`${input.id}`)[0];
//     span.style.top = `-0.8rem`;
//     span.style.backgroundColor = `#fff`;
//     span.style.color = `#4285f4`;
// }
// function resetingSpan(input) {
//     if(input.value == ``) {
//         document.getElementsByClassName(`${input.id}_label`)[0].style.border = `0.1rem solid silver`;
//         let span = document.getElementsByClassName(`${input.id}`)[0];
//         span.style.top = `1rem`;
//         span.style.left = `1rem`;
//         span.style.backgroundColor = ``;
//         span.style.color = `silver`;
//     }
// }

// function focusCursor1(span) {
//     document.getElementById(`${span.className}`).focus();
// }

// function focusCursor(span) {
//     if(span.textContent == "USERNAME") {
//         document.getElementById(`username`).focus();
//     }
//     else {
//         document.getElementById(`password`).focus();
//     }
// }
function login() {
    document.getElementsByClassName(`main`)[0].innerHTML = `
        <form action="javascript:inicioSesion();" id="form">
            <h1>Sign In</h1>
            <label for="">
                <span">USERNAME</span>
                <input type="text" name="username" id="username" autocomplete="off" required >
            </label>
            <label for="">
                <span">PASSWORD</span>
                <input type="password" name="password" required id="password" >
            </label>
            <div class="signin">
                <input type="submit" name="signin" id="submit" value="Sign In">
                <img src="../Images/next.png" alt="">
            </div>
            <a href="#" class="form_password">Forgot Password?</a>
            <div class="form_socialmedia">
                <button class="twitter">
                    <img src="../Images/twitter.png" alt="">
                    TWITTER
                </button>
                <button class="facebook">
                    <img src="../Images/facebook.png" alt="">
                    FACEBOOK
                </button>
            </div>
            <div class="signup">
                <p>Don't have an account? <a href="#">Sign Up for free</a></p>
            </div>
        </form>
    `;
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