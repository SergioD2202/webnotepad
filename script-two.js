//Eliminar nota
function deleteNote(){
    if(confirm("¿Está seguro que quiere borrar esta nota?")) {
        const xhr = new XMLHttpRequest()

        xhr.onreadystatechange = function(){
            if(xhr.readyState==4) window.location.href="myfolder.php"
        }

        xhr.open('GET',"delete.php",true)

        xhr.send('')


    }
}

//Exportar nota
function expNote(){
    let name = document.querySelector(".name-note").value;
    let content = document.querySelector(".content").value;

    if(name==="") alert("No puede estar el nombre vacío")

    else{
        let blob = new Blob([content], { type: "text/plain;charset=utf-8" });
        saveAs(blob, name+".txt");
    }   
    
}
