<?php  
include_once('config.php');  



error_reporting(0);
  
// Reset errors and success messages  
$errors = array();  
$success = array();

  
?>

    <?php
      // Login attempt  
if(isset($_POST['loginSubmit']) && $_POST['loginSubmit'] == 'true'){  
    $loginEmail = trim($_POST['email']);  
    $loginPassword  = trim($_POST['password']);  
      
     // if (!preg_match("/^[_a-z0-9-] (.[_a-z0-9-] )*@[a-z0-9-] (.[a-z0-9-] )*(.[a-z]{2,3})$/", $loginEmail))  
     //    $errors['loginEmail'] = 'Your email address is invalid.';  

     // if(strlen($loginPassword) < 6 || strlen($loginPassword) > 12)  
     //    $errors['loginPassword'] = 'Your password must be between 6-12 characters.';
    if(!$errors){  
        $query  = 'SELECT * FROM users WHERE email = "' . mysqli_real_escape_string($dbLink, $loginEmail) . '" AND password = MD5("' . $loginPassword . '") LIMIT 1';  
        $result = mysqli_query($dbLink,$query);  
        if(mysqli_num_rows($result) == 1){  
            $user = mysqli_fetch_assoc($result);  
            $query = 'UPDATE users SET session_id = "' . session_id() . '" WHERE id = ' . $user['id'] . ' LIMIT 1';  
            mysqli_query($dbLink,$query); 

            if($_POST['remember']) {
                $year = time() + 31536000;
                setcookie('remember_me', $_POST['email'], $year);
                setcookie('remember_me_pass', $_POST['password'], $year);
            }
            else if(!$_POST['remember']) {
                if(isset($_COOKIE['remember_me'])) {
                    $past = time() - 100;
                    setcookie(remember_me, gone, $past);
                }
                if(isset($_COOKIE['remember_me_pass'])) {
                    $past = time() - 100;
                    setcookie(remember_me_pass, gone, $past);
                }
            }

            header('Location: home.php');  
            exit; 

            //echo '<script type="text/javascript">BootstrapDialog.show({type:"type-warning", title: "Warning",message: "test"});</script>';
         
        }else{  
            $errors['login'] = 'No user was found with the details provided.';  
            //echo '<script type="text/javascript">BootstrapDialog.show({type:"type-warning", title: "Warning",message: "User credentials could not be verified!"});</script>';
        }  
    }  
}  

    ?>


<!DOCTYPE html>
<html>
  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login Page</title>
    <!-- Tell the browser to be responsive to screen width -->

  </head>
  <body class="hold-transition login-page">


    <div class="login-box">
      <div class="login-box-body">
        <div class="login-logo">
        <a href="#"><b>G&H</b></a>
      </div><!-- /.login-logo -->
        <p class="login-box-msg">Sign in to start your session</p>
        <form style="padding-bottom:30px" name="loginForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
          <div class="form-group has-feedback">
            <label for="email"> Email Address</label>  
            <input class="form-control" placeholder="Email" type="text" name="email"  value="<?php echo $_COOKIE['remember_me']; ?>" />
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>  <!--value="<?php echo htmlspecialchars($loginEmail); ?>" -->
          </div>
          <div class="form-group has-feedback">
            <label for="password"> Password</label>  
            <input class="form-control" placeholder="Password" type="password" name="password" value="<?php echo $_COOKIE['remember_me_pass']; ?>" />  
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            
          </div>
          <input type="checkbox" name="remember" <?php if(isset($_COOKIE['remember_me'])) {
                echo 'checked="checked"';
            }
            else {
                echo '';
            }
            ?> > Remember me
          <div class="row">
            <div class="col-xs-4 col-xs-offset-4">
                <label for="loginSubmit">&nbsp;</label>  
                <input type="hidden" name="loginSubmit" id="loginSubmit" value="true" />  
                <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div><!-- /.col -->
          </div>
        </form>
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->


  </body>
</html>

