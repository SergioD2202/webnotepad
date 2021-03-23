<?php
  session_start();
    require_once "connection.php";

if (mysqli_connect_errno()) {
  printf("Connect failed: %s\n", mysqli_connect_error());
  exit;
}
  $iduser = $_SESSION['id'];
   $queryfolder = "SELECT id_folder FROM folder WHERE id_user='$iduser'";
   $resultfolder = $link->query($queryfolder);
   if (!$resultfolder) {
    printf("Query failed: %s\n", $link->error);
    exit;
    }   
    while($rowf = $resultfolder->fetch_row()) {
      $rowsf[]=$rowf;
      }

      $idfolder = $rowsf[0][0];

    $query = "SELECT name_note FROM note WHERE id_folder='$idfolder'";
    $result = $link->query($query);     
      if (!$result) {
      printf("Query failed: %s\n", $link->error);
      exit;
      }     
      if($result->num_rows==0) exit;
      while($row = $result->fetch_row()) {
      $rows[]=$row;
      
      }
    $result->close();
    $resultfolder->close();
    $link->close();

    

    foreach($rows as $v) echo $v[0].'/';
    

?>