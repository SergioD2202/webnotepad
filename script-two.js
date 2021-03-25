


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
