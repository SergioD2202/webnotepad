<?php
session_start();

// Revisar si el usuario está loggeado
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}

require "connection.php";
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit;
  }
  
  $check =  'SELECT id_note FROM note WHERE name_note ='.'"'.$_SESSION["name_note"].'";';
  
  $querycheck = $link->query($check);
  
  if (!$querycheck) {
      printf("Query failed: %s\n", $link->error);
      return 0;
      }      
      while($row = $querycheck->fetch_row()) {
        $rows[]=$row;
        }
        $querycheck->close();
        $link->close();
    
        $_SESSION['id_note'] = $rows[0][0];

        if($_SERVER['REQUEST_METHOD']=="POST"){
            $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
            $name = $_POST["note-name"];
            $content = $_POST['editor'];
            $id = $_SESSION['id_note'];
            $_SESSION['name_note']=$name;
            $_SESSION['content']=$content;
        
            if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit;
            } 
        
            try{
           
            $query = "UPDATE note SET name_note = '$name' , content = '$content'  WHERE id_note ='$id';";
            
            $result = $link->query($query);  
            if (!$result) {
            printf("Query failed: %s\n", $link->error);
            exit;
            } 
            header("Refresh:0"); 
            }
            catch(Exception $ex){
                echo "error";
            }
        
            $link->close();
        }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($_SESSION["username"]); ?>:<?php echo htmlspecialchars($_SESSION["name_note"]); ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <h1 class="my-5">Editor de la Nota: <b><?php echo htmlspecialchars($_SESSION["name_note"]); ?></b>.</h1>
    <p>
        <a href="myfolder.php" class="btn btn-warning">Volver a Mi Carpeta</a>
        <a href="editor.php" class="btn btn-danger ml-3">Revertir los cambios</a>
    </p>

    <div class="shadow p-3 m-5 bg-white rounded">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

            <div class="col-8"><input id="note-name" type="text" name="note-name" class="form-control w-25 name-note" placeholder="Nombre" value="<?php echo $_SESSION["name_note"] ?>"></div>

            <div class="shadow p-3 m-5 bg-light rounded editor">
            <div class="form-group purple-border">
                <label for="editor">Contenido de la nota</label>
                <textarea  name="editor" class="form-control content" id="editor" cols="30" rows="10"><?php echo htmlspecialchars($_SESSION["content"]); ?></textarea>
            </div>
            </div>
            
            <input type="submit" class="btn btn-primary" value="Guardar">
            
         
          <input type="button" class="btn btn-info exp" value="Exportar" onclick="expNote()">
          <input type="button" class="btn btn-danger" value="Borrar" onclick="deleteNote()">
          </form>
    </div>
    <script src="script-two.js"></script>
    <script>
        //Exportar nota
        function expNote(){
            var name = document.querySelector(".name-note").value;
            var content = document.querySelector(".content").value;

            if(name==="") alert("No puede estar el nombre vacío")

        else{
            var element = document.createElement('a');
            element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(content));
             element.setAttribute('download', name);

            element.style.display = 'none';
            document.body.appendChild(element);

            element.click();

            document.body.removeChild(element);
                }   
        }
    </script>
</body>
</html>