<?php

session_start();
 

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
 

require_once "connection.php";
 

$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 

if($_SERVER["REQUEST_METHOD"] == "POST"){
 
   
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Por favor ingrese la nueva contraseña.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "La contraseña debe ser al menos 6 caracteres.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
   
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Por favor confirme su contraseña.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Las contraseñas no son iguales.";
        }
    }
        
   
    if(empty($new_password_err) && empty($confirm_password_err)){
        
        $sql = "UPDATE user SET password = ? WHERE id_user = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
           
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            
            
            $param_password = $new_password; //password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            
            if(mysqli_stmt_execute($stmt)){
                
                session_destroy();
                header("location: index.php");
                exit();
            } else{
                echo "Oops! algo salió mal.";
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
    <title>Cambiar contraseña</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; color:lightgray; }
        .wrapper{ width: 350px; padding: 30px; border-style:solid; border-width: 10px; }
    </style>
</head>
<body style="
    background: url(https://i.pinimg.com/originals/f1/a0/f2/f1a0f2d76534f4eff243066805c902de.jpg) no-repeat center center fixed; 
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
">
        <div class="wrapper ml-5 mt-5 border-primary">
            <h2>Cambiar contraseña</h2>
            <p>Por favor llene los campos para cambiar contraseña.</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
                <div class="form-group">
                    <label>Nueva Contraseña</label>
                    <input type="password" name="new_password" class="form-control <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_password; ?>">
                    <span class="invalid-feedback"><?php echo $new_password_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Confirmar Contraseña</label>
                    <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
                    <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Cambiar">
                    <a class="btn btn-link ml-2" href="welcome.php">Cancelar</a>
                </div>
            </form>
        </div>  
</body>
</html>