
<?php

define('DB_SERVER', 'bqvkxucejn9m8q2b9l3j-mysql.services.clever-cloud.com');
define('DB_USERNAME', 'uuxm51iy6cohxzkq');
define('DB_PASSWORD', 'w8DNyQ7JOqmBSHQ3n0jk');
define('DB_NAME', 'bqvkxucejn9m8q2b9l3j');
 
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>



