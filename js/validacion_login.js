var correo = document.getElementById("correo");
var pass = document.getElementById("contrasena");

correo.addEventListener("blur", validarEmail);
pass.addEventListener("blur", validarPass);

function validarEmail() {
    const email = correo.value; // Cambié input por correo
    var errorSpan = document.getElementById("email_error");
    var errorInput = document.getElementById("correo");
    const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

    if (email.trim() === "") {
        errorSpan.textContent = "Este campo es obligatorio.";
        errorInput.style.borderWidth = "4px";
        errorInput.style.borderColor = "red";
    } else if (!emailRegex.test(email)) {
        errorSpan.textContent = "Ingresa un correo electrónico válido.";
        errorInput.style.borderWidth = "4px";
        errorInput.style.borderColor = "red";
    } else {
        errorSpan.textContent = "";
        errorInput.style.borderWidth = "2px";
        errorInput.style.borderColor = "black";
    }
}
function validarPass() {
    const pass = contrasena.value;
    var errorPSpan = document.getElementById("pass_error");
    var errorPInput = document.getElementById("contrasena");

    if (pass.trim() === "") {
        errorPSpan.textContent = "Este campo es obligatorio.";
        errorPInput.style.borderWidth = "4px";
        errorPInput.style.borderColor = "red";
        return false;
    } else {
        errorPSpan.textContent = "";
        errorPInput.style.borderWidth = "2px";
        errorPInput.style.borderColor = "black";
        return true;
    }
}

function submitFrom(){
    var error = false;
    if(validarPass()){
        error = true;
    }
    if(validarEmail()){
        error = true;
    }
    return error;
}