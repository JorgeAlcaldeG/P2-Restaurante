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