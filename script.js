//Llenar de notas para leer
var fid

function readNotes(){
  const el = document.querySelector(".list-notes")

  
  const xhr = new XMLHttpRequest()
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
      const arr = this.responseText.split("/")
      if(arr.length==0) return 0
      arr.pop()
      el.innerHTML = "<h2>Lista de notas</h2> <br>"+arr.map(e=>'<input type="button" class="btn btn-outline-primary note-select" value="'+e+'"></a> <br> <br> <br>')
      

      const notes = document.querySelectorAll(".note-select");

      for (let i = 0; i < notes.length; i++) {
        notes[i].addEventListener("click", function(e) {
          const fd = new FormData()
          fd.append("name_note",e.target.value)
          const xhr = new XMLHttpRequest()
           xhr.onreadystatechange = function(){if (xhr.readyState === 4 || xhr.status==200) {
           location.href = "editor.php"
          }}
          xhr.open('POST', "note-select.php", true);
          xhr.send(fd);
          });
      }
    }
  }

  xhr.open('GET', "listnotes.php", true);
  xhr.send('');
}

readNotes()
searchFolderId()

//Conseguir el id_folder del folder del user con id_user

function searchFolderId(){
  xhr = new XMLHttpRequest()
  
  xhr.onload = function () {
    if (xhr.readyState === xhr.DONE) {
        if (xhr.status === 200) {
             fid = Number(this.responseText)
        }
    }
};

  xhr.open('GET', "searchfolderid.php", true);
  xhr.send('');
  
 }


//Funciones del CRUD de Notas

//Crear Nota

function callNotes(){
    const checkNote = new Promise( function (resolve, reject){
    const name = document.querySelector(".name-note")
    const fd = new FormData()

    if(name.value==="") alert("Por favor ingrese un nombre")

    else{
        fd.append("name_note",name.value)
        fd.append("folder_id",fid)
         const xhr = new XMLHttpRequest()
        xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
          resolve(this.responseText)
        }
      }
  
      xhr.open('POST', "checkexists.php", true);
      xhr.send(fd);

     }
   })
  
  const createNote = checkNote.then( res=>{
      if(Number(res)==1){
        const p2 = new Promise(function(resolve,reject){
        const name = document.querySelector(".name-note")
        const fd = new FormData()
        fd.append("name_note",name.value)
        fd.append("folder_id",fid)
        const xhr2 = new XMLHttpRequest()
          
        xhr2.onreadystatechange = function() {
          if (xhr2.readyState === 4) {
            readNotes()
            name.value=""
          }
        }
        xhr2.open('POST', "createnote.php", true);
        xhr2.send(fd);
      })
          
    }
    else alert("Error, el nombre de la nota ya existe")
  })
}




    

    

