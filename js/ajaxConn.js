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
function mostrarReservas(){
    var mesa = document.getElementById("mesas").value;
    var date = document.getElementById("date").value;
    var time1 = document.getElementById("time1").value;
    var time2 = document.getElementById("time2").value;

    var formdata = new FormData();
    formdata.append('mesa', mesa);
    formdata.append('date', date);
    formdata.append('time1', time1);
    formdata.append('time2', time2);
    var ajax = new XMLHttpRequest();
    ajax.open('POST', './proc/listaReservas.php');
        ajax.onload=function(){
            if(ajax.readyState ==4 && ajax.status==200){
                if(ajax.responseText == "no"){
                    document.getElementById("textoReserva").innerText = "No se han encontrado reservas";
                    document.getElementById("reservaDatos").innerHTML ="";
                    if(mesa!="" && date!="" && time1!="" && time2!=""){
                        document.getElementById("btnReserva").disabled = false;
                    }else{
                        document.getElementById("btnReserva").disabled = true;
                    }
                }else{
                    document.getElementById("textoReserva").innerText = "Se han encontrado las siguientes reservas";
                    // console.log(ajax.responseText);
                    var json = JSON.parse(ajax.responseText);
                    var tabla ="";
                    json.forEach(function(item){
                        str="<tr><td>"+item.id_mesa+"</td>";
                        str+="<td>"+item.reserva_fecha+"</td>";
                        str+="<td>"+item.reserva_hora_ini+"</td>";
                        str+="<td>"+item.reserva_hora_final+"</td>";
                    tabla +=str; 
                    });
                    document.getElementById("reservaDatos").innerHTML = tabla;
                    document.getElementById("btnReserva").disabled = true;
                }
            }
        }
    ajax.send(formdata);
}

function crearReserva(){
    var mesa = document.getElementById("mesas").value;
    var date = document.getElementById("date").value;
    var time1 = document.getElementById("time1").value;
    var time2 = document.getElementById("time2").value;
    var numMesas = document.getElementById("numMesas").value;
    var formdata = new FormData();
    formdata.append('mesa', mesa);
    formdata.append('date', date);
    formdata.append('time1', time1);
    formdata.append('time2', time2);
    formdata.append('numMesas', numMesas);
    var ajax = new XMLHttpRequest();
    ajax.open('POST', './proc/CrearReserva.php');
    ajax.onload=function(){
        if(ajax.readyState ==4 && ajax.status==200){
            // console.log(ajax.responseText);
            if(ajax.responseText =="ok"){
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Registro creado correctamente",
                    showConfirmButton: false,
                    timer: 1000
                });
                mostrarReservas();
            }else{
                Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: "Se han encontrado los siguientes errores:",
                    html:ajax.responseText,
                    showConfirmButton: false,
                    timer: 1000
                });
            }
        }
    }
    ajax.send(formdata);
}