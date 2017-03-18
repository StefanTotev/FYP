<?php  
include_once('config.php');
 
date_default_timezone_set('Etc/UTC');

error_reporting(0);

?>  

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>In</title>
    <!-- Tell the browser to be responsive to screen width -->
  </head>
  <body class="hold-transition skin-green sidebar-mini sidebar-collapse">
    <div class="wrapper">



      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Admin
            <small>Add User</small>
          </h1>
        </section>

        <!-- Main content -->
        <section class="content">

          <div class="row">
            <!-- <div class="col-xs-8 col-xs-offset-2"> -->
            <div class="col-md-12 col-md-8 col-md-offset-2">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Add a New User</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <form name="userForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <fieldset>
                      <div class="row">
                        <div class="col-md-6 col-xs-12">
                          <div class="form-group has-feedback">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Email" required>
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                          </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                          <div class="form-group has-feedback">
                            <label for="role_name">Retype Email</label>
                            <input type="retype_email" name="retype_email" id="retype_email" class="form-control" placeholder="Retype Email" required>
                            <span class="glyphicon glyphicon-repeat form-control-feedback"></span>
                          </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                          <div class="form-group has-feedback">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="password" required>
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                          </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                          <div class="form-group has-feedback">
                            <label for="role_password">Retype Password</label>
                            <input type="password" name="retype_password" id="retype_password" class="form-control" placeholder="Retype Password" required>
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                          </div>
                        </div>
                        
                      </div>
                      <div class="row">
                        <div class="col-md-4 col-md-offset-4 col-xs-6 col-xs-offset-3">
                          <label for="userFormSubmit">&nbsp;</label>  
                          <input type="hidden" name="userFormSubmit" id="userFormSubmit" value="true" />  
                          <input type="submit" class="btn btn-md btn-success btn-block" value="Register User" />
                           
                        </div><!-- /.col -->
                      </div>
                    </fieldset>
                  </form>
                </div><!-- /.nav-tabs-custom -->
              </div><!-- /.col -->
            </div>
          </div><!-- /.row -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->


      <!-- Control Sidebar -->
      
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
    </div><!-- ./wrapper -->

        <?php
        // Reset errors and success messages  
$errors = array();  
$success = array();


// Create user attempt  
if(isset($_POST['userFormSubmit']) && $_POST['userFormSubmit'] == 'true'){  

    $userEmail = $_POST['email'];
    $userREmail = $_POST['retype_email'];
    $userPassword = $_POST['password'];
    $userRPassword = $_POST['retype_password'];


    if($userEmail==$userREmail && $userPassword==$userRPassword){

        $query = 'INSERT INTO users SET email = ("' . mysqli_real_escape_string($dbLink, $userEmail) . '"), 
                                        password = ("' . mysqli_real_escape_string($dbLink, md5($userPassword)) . '")';
          
        if(mysqli_query($dbLink,$query)){
           // echo "test4";  
            $success['userFormSubmit'] = 'Your password has been reset. You have been emailed with the details.'; 
            echo '<script type="text/javascript">alert("user created");</script>'; 
            //echo '<script type="text/javascript">alert("'.$userPassword.'");</script>';
            //echo '<script type="text/javascript">alert("'.$userEmail.'");</script>';
            
        }else{  
           // echo "test5";
            $errors['userFormSubmit'] = mysqli_error($dbLink);
            echo '<script type="text/javascript">alert("'.mysqli_error($dbLink).'");</script>';
            //'There was a problem submitting your timesheet. Please check your details and try again.';  
        }  
    }

    else{
      echo '<script type="text/javascript">BootstrapDialog.show({type:"type-warning", title: "Warning",message: "User email address does not match. Please make sure you provide correct information."});</script>';             
    }
  } 

?>  
  </body>

</html>
