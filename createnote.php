<?php
require_once "connection.php";

$name = $_POST["name_note"];
$folder = $_POST["folder_id"];

if (mysqli_connect_errno()) {
  printf("Connect failed: %s\n", mysqli_connect_error());
  exit;
}
   
    $query = "INSERT INTO note (id_note, name_note, content, id_folder) VALUES (NULL, '".$name."', ' ' , ".$folder.");";
    $result = $link->query($query);     
    if (!$result) {
    printf("Query failed: %s\n", $link->error);
    exit;
    }  
    $result->close();
    $link->close();
    echo "success";

?>