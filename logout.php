<?php
// Iniciar la sesión
session_start();
 
// Desechar todas las variables
$_SESSION = array();
 
// Destruyendo la sesión
session_destroy();
 
// Redirigir al login
header("location: index.php");
exit;
?>