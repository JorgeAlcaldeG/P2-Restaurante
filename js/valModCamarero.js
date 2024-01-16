nom = document.getElementById("nom");
ape = document.getElementById("ape");
pwd=document.getElementById("pwd");
email = document.getElementById("email")
function campoVacio(campo,mensaje){
    input = document.getElementById(campo);
    error = document.getElementById(mensaje);

    if(input.value == 0){
        error.innerText = `Campo ${campo} vacío`;
        return false;
    }else{
        error.innerText ="";
    }
    return true;
}

function validarEmail(){
    const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    error = document.getElementById("errorEmail")
    if(!campoVacio("email","errorEmail")){
        return false;
    }else{
        if(!emailRegex.test(email.value)){
            error.innerText = "El formato del correo no es correcto";
            return false;
        }
    }
    error.innerText =""
    return true
}
function validarForm(){
    error = true;
    if(!campoVacio("nom","errorNom")){error = false}
    if(!campoVacio("ape","errorApe")){error = false}
    if(!validarEmail()){error = false}
    return error;
}
nom.addEventListener("blur", ()=>campoVacio("nom","errorNom"));
ape.addEventListener("blur", ()=>campoVacio("ape","errorApe"));
email.addEventListener("blur", ()=>validarEmail());

