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
function removeUsr(usr){
    Swal.fire({
        title: "Quieres eliminar el usuario?",
        text: "Esta acción no se puede rehacer",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si"
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