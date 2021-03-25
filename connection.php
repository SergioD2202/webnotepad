
<?php
//mysql://b77242d24893b4:0cafa9f8@us-cdbr-east-03.cleardb.com/heroku_818f77c7f856347?reconnect=true
define('DB_SERVER', 'us-cdbr-east-03.cleardb.com');
define('DB_USERNAME', 'b77242d24893b4');
define('DB_PASSWORD', '0cafa9f8');
define('DB_NAME', 'heroku_818f77c7f856347');
 
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>


