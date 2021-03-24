
<?php
//3@-L7rJC$//MAYH?
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'id16448666_sergio');
define('DB_PASSWORD', '3@-L7rJC$//MAYH?');
define('DB_NAME', 'id16448666_mysqlnotepaddb');
 
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>


