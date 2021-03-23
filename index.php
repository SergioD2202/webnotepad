<?php
// iniciar la sesión
session_start();
 
// revisar si el usuario ya tiene la sesión abierta, en caso de que si redirigirlo a folders.php
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: myfolder.php");
    exit;
}

// Incluir la conexión
require_once "connection.php";
 
// Define variables con espacios vacíos
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// procesando los datos
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    
    if(empty(trim($_POST["username"]))){
        $username_err = "Ingrese el usuario.";
    } else{
        $username = trim($_POST["username"]);
    }
    
   
    if(empty(trim($_POST["password"]))){
        $password_err = "ingrese la contraseña.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    
    if(empty($username_err) && empty($password_err)){
        
        $sql = "SELECT id_user, username, password FROM user WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            
            $param_username = $username;
            
            
            if(mysqli_stmt_execute($stmt)){
                
                mysqli_stmt_store_result($stmt);
                
                
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    
                    mysqli_stmt_bind_result($stmt, $id, $username, $param_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if($password==$param_password){   //if(password_verify($password, $param_password))
                            
                            
                            session_start();
                            
                            // Almacenar la sesión
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Entrar al directorio
                            header("location: myfolder.php");
                            
                        } else{
                            
                            $login_err = "La contraseña no es válida.";
                        }
                    }
                } else{
                    
                    $login_err = "No se consiguió una cuenta con ese usuario.";
                }
            } else{
                $login_err = "Oops! algo salió mal.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    
    // Close connection
    mysqli_close($link);
    
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notepad:Iniciar sesión</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; color:lightgray; }
        .wrapper{ width: 350px; padding: 20px; margin: auto; margin-top:8vh; box-shadow:0 0 0 2rem;}
    </style>
    
</head>
<body style="
    background: url(http://mediashift.org/wp-content/uploads/2016/03/Writing-memoir-by-Kristina-Strasunske-GettyImages.jpg) no-repeat center center fixed; 
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
">
    
    <div class="wrapper">
        <h2>Login</h2>
            <p>ingrese sus datos para entrar al blog.</p>
            <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                <div class="form-group">
                    <label>Usuario</label>
                    <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                    <span class="invalid-feedback"><?php echo $username_err; ?></span>
                </div>
                <div class="form-group">

                    <label>Contraseña</label>
                    <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                    <span class="invalid-feedback"><?php echo $password_err; ?></span>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Login">
                </div>

                <p>¿No tienes una cuenta? <a href="register.php">Regístrate</a>.</p>
           </form>
    </div> 
    

</body>
</html>