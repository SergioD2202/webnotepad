<?php

session_start();

require_once "connection.php";

$id=$_SESSION["id"];

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit;
  }
      $query = "SELECT id_folder FROM folder WHERE id_user=".$id;
      $result = $link->query($query);     
      if (!$result) {
          printf("Query failed: %s\n", $link->error);
      exit;
      }      
      while($row = $result->fetch_row()) {
      $rows[]=$row;
      }
      $result->close();
      $link->close();
  
      foreach($rows as $v) echo $v[0];

 

?>