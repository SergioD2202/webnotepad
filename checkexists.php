<?php
require_once "connection.php";

$name = trim($_POST["name_note"]);
$folder = trim($_POST["folder_id"]);

if (mysqli_connect_errno()) {
  printf("Connect failed: %s\n", mysqli_connect_error());
  exit;
}

$check =  "SELECT id_note FROM note WHERE name_note ='".$name."';";

$querycheck = $link->query($check);

if (!$querycheck) {
    printf("Query failed: %s\n", $link->error);
    exit;
    }      
if($querycheck->num_rows>0) {
    echo 0;
}

else echo 1;

$querycheck->close();

$link->close();

?>