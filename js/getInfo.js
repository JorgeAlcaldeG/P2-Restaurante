container = document.querySelector(".InfoContainer");
// console.log(container);
function Ocultar(){
    for (let i = 0; i < container.children.length; i++) {
        container.children[i].innerText ="";
        
    }
    container.children[0].innerText = "Pasa el ratón por la mesa para saber su información";
}
function Informacion(mesa){
    // var info = info.split('-');
    var info = mesa.children[1].innerText.split('-');
    var numMesa = mesa.children[0].value;
    container.children[0].innerText = numMesa;
    if(info[2]==1){
        container.children[1].innerText = "OCUPADO";
        container.children[1].style.color="red";
    }else{
        container.children[1].innerText = "DISPONIBLE";
        container.children[1].style.color="green";
    }
    container.children[2].innerHTML = `<p id="info"class="text-Center">Ubicación: </br> <span class="infoMesa">${info[0]}</span></p>`;
    container.children[3].innerHTML = `<p id="sillasDisp"class="text-Center">Numero de sillas: </br> <span class="infoMesa">${info[1]} sillas</span></p>`;
}



