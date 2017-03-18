<?php  


date_default_timezone_set('Etc/UTC');

require 'PHPMailerAutoload.php'; 

error_reporting(1);
  
// Reset errors and success messages  
$errors = array();  
$success = array();


  
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Password Reset</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->

  </head>
  <body class="hold-transition login-page">
    

    <div class="row" style="padding-top:70px">
      <div class="col-xs-6 col-xs-offset-3 ">
        <div class="box">
          <div class="login-box-body">
            <div class="row">
              <div class="col-xs-6" style="border-right:solid #B2C95F;">
                <p class="login-box-msg"><b>Step I</b></p>
                <p class="login-box-msg">Can not remember your password? Enter your E-mail to get a password reset token.</p>
                <form style="padding-bottom:10px" name="userToken" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                  <div class="form-group has-feedback">
                    <input type="email" name="recover_email" class="form-control" placeholder="Email Address" required>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                  </div>
                  <div class="row">
                    <div class="col-xs-8 col-xs-offset-2">
                      <label for="userTokenSubmit">&nbsp;</label>  
                      <input type="hidden" name="userTokenSubmit" id="userTokenSubmit" value="true" />  
                      <button type="submit" class="btn btn-md btn-success btn-block">Get Token</button>
                    </div>
                  </div>
                </form>
              </div>
              <div class="col-xs-6">
                <p class="login-box-msg"><b>Step II</b></p>
                <p class="login-box-msg">Already have a password reset token? Please enter in below and click "Reset".</p>
                <form style="padding-bottom:10px" name="userPass" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                  <div class="form-group has-feedback">
                    <input type="text" name="recover_token" class="form-control" placeholder="Password Reset Token" required>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                  </div>
                  <div class="row">
                    <div class="col-xs-8 col-xs-offset-2">
                      <label for="userPassSubmit">&nbsp;</label>  
                      <input type="hidden" name="userPassSubmit" id="userPassSubmit" value="true" />  
                      <button type="submit" class="btn btn-md btn-success btn-block">Reset</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <center><a href="index.php" ><p style="padding-top:25px; margin-bottom:5px">Go back to login, I remembered my password.</p></a></center>
          </div>
        </div>
      </div>
    </div>

    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>

    <?php
      if(isset($_POST['userPassSubmit']) && $_POST['userPassSubmit'] == 'true'){ 
        $userResetToken = trim($_POST['recover_token']);
        $userNewPassword = generateRandomString(8); 
        // Establish a link to the database  

        // ESTABLIH LINK TO TTHE DATABASE - COPY THIS FROM YOUR CONFIG FILE
        $dbLink = new mysqli('127.0.0.1', 'root', 'PAS');   
        if (!$dbLink) die('Can\'t establish a connection to the database: ' . mysql_error());  
          
        $dbSelected = mysqli_select_db($dbLink, "DATABASE_NAME");  
        if (!$dbSelected) die ('We\'re connected, but can\'t use the table: ' . mysql_error());  

          $query  = 'SELECT * FROM users WHERE reset_token = "' . mysqli_real_escape_string($dbLink, $userResetToken). '" LIMIT 1';  
          $result = mysqli_query($dbLink, $query );
          if(mysqli_num_rows($result) == 1){ 
            $data = mysqli_fetch_array($result);
            $sql = "UPDATE users SET password=MD5('". $userNewPassword ."'), reset_token='0' WHERE reset_token='".$userResetToken."'";             
            if(mysqli_query($dbLink,$sql)){
              sendPassword($data['email'],$data['display_name'],$userNewPassword);
            }
            else{
              echo '<script type="text/javascript">BootstrapDialog.show({type:"type-danger", title: "Error",message: "Password could not be reset!"});</script>';
            }

          }
          else{
          
           echo '<script type="text/javascript">BootstrapDialog.show({type:"type-warning", title: "Warning",message: "User details could '. mysqli_error($dbLink).' not be verified!"});</script>';
          
          }
        }

      if(isset($_POST['userTokenSubmit']) && $_POST['userTokenSubmit'] == 'true'){ 
        $recoverEmail = trim($_POST['recover_email']);
        $userPasswordToken = generateRandomString(); 
        
        // ESTABLIH LINK TO TTHE DATABASE - COPY THIS FROM YOUR CONFIG FILE
        $dbLink = new mysqli('127.0.0.1', 'root', 'PAS');   
        if (!$dbLink) die('Can\'t establish a connection to the database: ' . mysql_error());  
          
        $dbSelected = mysqli_select_db($dbLink, "DATABASE_NAME");  
        if (!$dbSelected) die ('We\'re connected, but can\'t use the table: ' . mysql_error()); 

        $query  = 'SELECT * FROM users WHERE email = "' . mysqli_real_escape_string($dbLink, $recoverEmail). '" LIMIT 1';  
          $result = mysqli_query($dbLink, $query );
          echo '<script type="text/javascript">alert('. mysqli_num_rows($result).');</script>';
          
          if(mysqli_num_rows($result) == 1){
            $data = mysqli_fetch_array($result); 
            $sql = "UPDATE users SET reset_token='". $userPasswordToken ."' WHERE email='".$recoverEmail."'";             
            if(mysqli_query($dbLink,$sql)){
              //$data = mysqli_fetch_array($sql);
              sendToken($recoverEmail, $data['display_name'], $userPasswordToken);
              }
            else{
              //echo '<script type="text/javascript">alert("'.mysqli_error($dbLink).'");</script>';
              echo '<script type="text/javascript">alert("Password Could not be reset!");</script>';
            }

          }
          else{
           echo '<script type="text/javascript">BootstrapDialog.show({type:"type-warning", title: "Warning",message: "User details could not be verified!"});</script>';
          
          }
        }



      function generateRandomString($length = 12) {
          $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
          $charactersLength = strlen($characters);
          $randomString = '';
          for ($i = 0; $i < $length; $i++) {
              $randomString .= $characters[rand(0, $charactersLength - 1)];
          }
          return $randomString;
      }

      function sendPassword($userEmail, $userFullName, $userPassword){
          $mail = new PHPMailer;
          $mail->CharSet = 'utf-8';
          $mail->isSMTP();
          $mail->SMTPDebug = 0;
          $mail->Debugoutput = 'html';
          $mail->Host = "smtp.googlemail.com";
          $mail->Port = 465;
          $mail->SMTPAuth = true;
          $mail->Username = "your-gmail-address";
          $mail->Password = "your-gmail-address-password";
          $mail->SMTPSecure = 'ssl';  
          $mail->setFrom('your-gmail-address', 'your-custom-name');
          $mail->addAddress($userEmail);
          $mail->Subject = '';
          $mail->AltBody = '';
          $mail->Body    = 'Hello '.$userFullName.',<br/><br/>Your password has been successfully reset. Your new password is as follows:<br/><br/><b>Password: </b>'.$userPassword.'<br/><br/>Please note that this password is randomly generated. You can change your password from the profile section in the system once you log in.<br/><br/>If you need further assistance please contact one of the system admins. Please <b>do not</b> respond to this email.<br/><br/>Thanks<br/>';
          // $mail->addAttachment('images/phpmailer_mini.png');

          //send the message, check for errors
          if (!$mail->send()) {
              echo '<script type="text/javascript">BootstrapDialog.show({type:"type-danger", title: "Error",message: "New login details email could not be send. Please make sure you provide correct information."});</script>';              
          } else {
            echo '<script type="text/javascript">BootstrapDialog.show({type:"type-success", title: "Information",message: "Your password has been successfully reset! New login details have been sent to your email address."});</script>';        
          }
        }

        function sendToken($userEmail, $userFullName, $userToken){
          $mail = new PHPMailer;
          $mail->CharSet = 'utf-8';
          $mail->isSMTP();
          $mail->SMTPDebug = 0;
          $mail->Debugoutput = 'html';
          $mail->Host = "smtp.googlemail.com";
          $mail->Port = 465;
          $mail->SMTPAuth = true;
          $mail->Username = "your-gmail-address";
          $mail->Password = "your-gmail-address-password";
          $mail->SMTPSecure = 'ssl';  
          $mail->setFrom('your-gmail-address', 'your-custom-name');
          $mail->addAddress($userEmail);
          $mail->Subject = '';
          $mail->AltBody = '';
          $mail->Body    = 'Hello '.$userFullName.',<br/><br/>You have requested password reset for G&H System. Please use the reset token bellow to obtain your new password. Copy and paste in in the "Step II" form on the password reset screen and click "Reset".<br/><br/>Your reset token is as follows:<br/><b>Reset Token: </b>'.$userToken.'<br/><br/><br/><br/>If you need further assistance please contact one of the system admins. Please <b>do not</b> respond to this email.<br/><br/>If you have not requested password reset and you are receiving this email, please ignore it.<br/><br/>Thanks,<br/>G&H System';
          // $mail->addAttachment('images/phpmailer_mini.png');

          //send the message, check for errors
          if (!$mail->send()) {
            echo '<script type="text/javascript">BootstrapDialog.show({type:"type-danger", title: "Error",message: "Password token details email could not be send. Please make sure you provide correct information."});</script>';
                      
          } else {  
            echo '<script type="text/javascript">BootstrapDialog.show({type:"type-success", title: "Information",message: "Please follow the password reset instructions that have been sent to your email! If you need help or have not received an email please contact a system administor."});</script>';
          }
        }
    ?>
  </body>
</html>
