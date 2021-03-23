<?php
session_start();

require_once "connection.php";

$name = trim($_POST['name_note']);

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit;
  }
  
  $check =  "SELECT content FROM note WHERE name_note ='".$name."';";
  
  $result = $link->query($check);
  
  if (!$result) {
      printf("Query failed: %s\n", $link->error);
      exit;
      } 
      
      $array = array();
      while($row = mysqli_fetch_object($result))
      {
          $array[] = $row;
      }

      $content = $array[0]->content;

      $_SESSION['name_note']=$name;
      $_SESSION['content']= $content;
      
   echo $_SESSION['name_note'].' '.$_SESSION['content'];
   header("editor.php");
?>