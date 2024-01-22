function mostrarTabla(){
    var btn = document.getElementById("btnOp");
    var input1 = document.getElementById("input1");
    var input2 = document.getElementById("input2");
    var query = "name="+ encodeURIComponent(input1.value)+"&ape="+encodeURIComponent(input2.value)+"&tipo="+encodeURIComponent(btn.innerText);
    var ajax = new XMLHttpRequest();
    ajax.open('POST', './proc/showResults.php');
    ajax.onload=function(){
        if(ajax.readyState ==4 && ajax.status==200){
            document.getElementById("tabla").innerHTML = ajax.responseText;
        }
    }
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    ajax.send(query);
}
function cambioTabla(){
    var btn = document.getElementById("btnOp");
    if(btn.innerText =="Mesas"){
        document.getElementById("input1").style.display="none";
        document.getElementById("lbl1").style.display="none";
        document.getElementById("input2").style.display="none";
        document.getElementById("lbl2").style.display="none";
        btn.innerText ="Empleados";

    }else{
        document.getElementById("input1").style.display="initial";
        document.getElementById("lbl1").style.display="initial";
        document.getElementById("input2").style.display="initial";
        document.getElementById("lbl2").style.display="initial";
        btn.innerText ="Mesas";
    }
    mostrarTabla()
}

function mostrarRegistro(){
    // console.log("hola");
    var sala = document.getElementById("sala");
    var emp = document.getElementById("emp");
    var date1 = document.getElementById("date1");
    var date2 = document.getElementById("date2");
    var csv = document.getElementById("csv");
    var query = "sala="+ encodeURIComponent(sala.value)+"&emp="+encodeURIComponent(emp.value);
    csv.href = "./proc/historico_csv.php?sala="+sala.value+"&emp="+emp.value
    if(date1.value !=""){
        query = query+"&date1="+encodeURIComponent(date1.value)
        csv.href += "&date1="+date1.value;
    }
    if(date2.value !=""){
        query = query+"&date2="+encodeURIComponent(date2.value)
        csv.href += "&date2="+date2.value;
    }
    // if(date1.value="")

    var ajax = new XMLHttpRequest();
    ajax.open('POST', './proc/mostrarRegistro.php');
    ajax.onload=function(){
        if(ajax.readyState ==4 && ajax.status==200){
            document.getElementById("tabla").innerHTML = ajax.responseText;
        }
    }
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    ajax.send(query);
}
function cargarMapa(){
    var ajax = new XMLHttpRequest();
    ajax.open('POST', './proc/mapa_proc.php');
    ajax.onload=function(){
        if(ajax.readyState ==4 && ajax.status==200){
            document.getElementById("reservasContainer").innerHTML = ajax.responseText;
        }
    }
    ajax.send();
}
function removeUsr(usr){
    Swal.fire({
        title: "Quieres eliminar el usuario?",
        text: "Esta acción no se puede deshacer",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si",
        cancelButtonText: "Cancelar"
      }).then((result) => {
        if (result.isConfirmed) {
        var ajax = new XMLHttpRequest();
        var formdata = new FormData();
        formdata.append('usr', usr);
    
        ajax.open('POST', './proc/removeUsr.php');
        ajax.onload=function(){
            if(ajax.readyState ==4 && ajax.status==200){
                if(ajax.responseText == "ok"){
                    Swal.fire({
                        title: "Borrado!",
                        text: "El usuario ha sido eliminado",
                        icon: "success"
                    });
                    mostrarTabla();
                }
            }
        }
        ajax.send(formdata);
        }
      });
}

function modMesa(id){
    document.getElementById("mesaId").value = id;
    formContainer = document.getElementById("modMesa");
    formContainer.style.display = "initial";

    var ajax = new XMLHttpRequest();
        var formdata = new FormData();
        formdata.append('id', id);
    
        ajax.open('POST', './proc/getMesaInfo.php');
        ajax.onload=function(){
            if(ajax.readyState ==4 && ajax.status==200){
                var json=JSON.parse(ajax.responseText);
                document.getElementById("mod_nomMesa").innerText ="Mesa numero ";
                document.getElementById("mod_estado").innerText ="Estado: ";
                document.getElementById("mesaId").value = json[0].mesa;
                document.getElementById("mod_nomMesa").innerText +=" "+json[0].mesa;
                if(json[0].disponibilidad == 0){
                    document.getElementById("mod_estado").innerText +=" Libre";
                }else{
                    document.getElementById("mod_estado").innerText +=" Ocupada";
                }
                document.getElementById("mod_num").innerText =json[0].numero_sillas;
                document.getElementById("mod_img").src="./img/mesaIcon/mesa"+json[0].numero_sillas+".png"
            }
        }
        ajax.send(formdata);
}
function cerrarMesa(){
    formContainer = document.getElementById("modMesa");
    formContainer.style.display = "none";
}

function modMesaProc(input){
    var id = document.getElementById("mesaId").value;
    var numMesas = document.getElementById("mod_num").innerText;
    var ajax = new XMLHttpRequest();
    var formdata=""
    if(input =="1"){
        if(numMesas <=5){
            var formdata = new FormData();
            formdata.append('op', input);
        }
    }
    if(input =="-1"){
        if(numMesas >0){
            var formdata = new FormData();
            formdata.append('op', input);
        }
    }
    if(formdata !=""){
        formdata.append('id', id);
        ajax.open('POST', './proc/updateMesa.php');
        ajax.onload=function(){
            if(ajax.readyState ==4 && ajax.status==200){
                document.getElementById("mod_num").innerText = ajax.responseText;
                document.getElementById("mod_img").src="./img/mesaIcon/mesa"+ajax.responseText+".png"
                // console.log(ajax.responseText);
            }
        }
        ajax.send(formdata);
    }
}