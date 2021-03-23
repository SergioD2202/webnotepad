<?php
session_start();
require_once "connection.php";

$name = $_SESSION["name_note"];

if (mysqli_connect_errno()) {
  printf("Connect failed: %s\n", mysqli_connect_error());
  exit;
}
   
    $query = "DELETE FROM `note` WHERE `note`.`name_note` ='".$name."';";
    $result = $link->query($query);     
    if (!$result) {
    printf("Query failed: %s\n", $link->error);
    exit;
    }  
    $result->close();
    $link->close();
    echo "success";
?>