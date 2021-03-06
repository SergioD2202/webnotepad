<?php

require_once "connection.php";
 

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 

if($_SERVER["REQUEST_METHOD"] == "POST"){
 
   
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        
        $sql = "SELECT id_user FROM user WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            
            $param_username = trim($_POST["username"]);
            
            
            if(mysqli_stmt_execute($stmt)){
               
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

           
            mysqli_stmt_close($stmt);
        }
    }
    
   
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
   
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        
        $sql = "INSERT INTO user (username, password) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
           
            $param_username = $username;
            $param_password = $password;              //password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            
            if(mysqli_stmt_execute($stmt)){

                $query="SELECT id_user FROM user WHERE username = '$param_username'";
                $idsearch = $link->query($query);
                if (!$idsearch) {
                    printf("Query failed: %s\n", $link->error);
                    return 0;
                    }      
                    while($row = $idsearch->fetch_row()) {
                      $rows[]=$row;
                      }
                  
                      $idregister = $rows[0][0];
                      $second_query="INSERT INTO folder (id_folder,   name_folder, id_user, id_parent) VALUES (NULL, 'root', '$idregister' , NULL);";
                      $idsearch = $link->query($second_query);
                    if (!$idsearch) {
                    printf("Query failed: %s\n", $link->error);
                    return 0;
                    }  

                
                  
                header("location: index.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

           
            mysqli_stmt_close($stmt);
        }
    }
    
    
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif;  color:#121212;}
        .wrapper{ width: 350px; padding: 20px; margin: auto; margin-top:8vh; box-shadow:0 0 0 2rem; }
    </style>
</head>
<body style="
    background: url(https://miro.medium.com/max/6300/0*TCH5zNt1QnBC150w) no-repeat center center fixed; 
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
">
    <div class="wrapper">
        <h2>Registro</h2>
        <p>Por favor llene los datos para crear una cuenta</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Contrase??a</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirmar contrase??a</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
            <p>??Ya posee una cuenta? <a href="index.php">Ingrese aqu??</a>.</p>
        </form>
    </div>    
</body>
</html>

