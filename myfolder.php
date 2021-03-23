<?php
// Iniciar la sesión
session_start();
 
// Revisar si el usuario está logueado
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($_SESSION["username"]); ?>:Mi Carpeta</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <h1 class="my-5">Hola, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Bienvenido.</h1>
    <p>
        <a href="reset-password.php" class="btn btn-warning">Cambiar contraseña</a>
        <a href="logout.php" class="btn btn-danger ml-3">Salir de su cuenta</a>
    </p>

    <div class="shadow p-3 m-5 bg-white rounded">

     <div class="container">
        <div class="row">
            <div class="col-8"><input id="note-name" type="text" name="note-name" class="form-control w-25 name-note" placeholder="Nombre"></div>
            <div class="col-4"><input type="button" class="btn btn-primary" value="Crear Nota" onclick="callNotes()"></div>
        </div>
      </div>

      <div class="shadow p-3 m-5 bg-light rounded list-notes"></div>
          
    </div>

    <script src="script.js"></script>
</body>
</html>