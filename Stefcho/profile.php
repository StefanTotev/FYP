<?php  
include_once('config.php');  

error_reporting(0);
?>  


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>In - profile</title>
    <!-- Tell the browser to be responsive to screen width -->
    

  </head>
  <body class="hold-transition skin-green sidebar-mini sidebar-collapse">
    <div class="wrapper">


      <!-- Left side column. contains the logo and sidebar -->


      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Profiles
            <small>My Profile</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-user"></i> Profiles</a></li>
            <li class="active">My Profile</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

          <div class="row">
            <div class="col-lg-3 col-sm-12">
              <!-- Profile Image -->
              <div class="box box-success">
                <div class="box-body box-profile">
                  <h3 class="profile-username text-center"><?php echo $_SESSION['user'][display_name];?></h3>
                  <p class="text-muted text-center"><?php echo $_SESSION['user'][role_name];?></p>

                  <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                      <b>Email</b> <a class="pull-right"><?php echo $_SESSION['user'][email];?></a>
                    </li>
                    <li class="list-group-item">
                      <b>Role</b> <a class="pull-right"><?php echo $_SESSION['user'][role_name];?></a>
                    </li>
                  </ul>
                </div><!-- /.box-body -->
              </div><!-- /.box -->

              <!-- About Me Box -->
              
            </div><!-- /.col -->
            <div class="col-lg-9 col-sm-12">
                    <form class="form-horizontal" name="userPass" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                      <div class="form-group has-feedback">
                        <label for="old_password" class="col-sm-2 control-label">Current Password</label>  
                        <div class="col-sm-9">
                          <input class="form-control" placeholder="Current Password" type="password" name="current_password" required>
                        </div>
                      </div>
                      <div class="form-group has-feedback">
                        <label for="password" class="col-sm-2 control-label">New Password</label>  
                        <div class="col-sm-9">
                          <input class="form-control" placeholder="New Password" type="password" name="password" required>
                        </div>
                      </div>
                      <div class="form-group has-feedback">
                        <label for="repeat_password" class="col-sm-2 control-label">Repeat Password</label>  
                        <div class="col-sm-9">
                          <input class="form-control" placeholder="Repeat Password" type="password" name="repeat_password" required>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-xs-4 col-xs-offset-4">
                            <label for="userPassSubmit">&nbsp;</label>  
                            <input type="hidden" name="userPassSubmit" id="userPassSubmit" value="true" />  
                            <button type="submit" class="btn btn-md btn-success btn-block">Update Password</button>
                        </div><!-- /.col -->
                      </div>
                    </form>
            </div><!-- /.col -->

<!--             <form class="form-horizontal" name="pictureForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                <label>File: </label><input type="file" name="image" />
                <label for="pictureFormSubmit">&nbsp;</label>  
                <input type="hidden" name="pictureFormSubmit" id="pictureFormSubmit" value="true" />  
                <button type="submit" class="btn btn-md btn-success btn-block">Upload Picture</button>
            </form> -->


          </div><!-- /.row -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->


      <!-- Control Sidebar -->
      
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
    </div><!-- ./wrapper -->

  </body>

  <?php

  // Reset errors and success messages  
$errors = array();  
$success = array();


// Update Password  
if(isset($_POST['userPassSubmit']) && $_POST['userPassSubmit'] == 'true'){  
    $currentPass = trim($_POST['current_password']);
    $newPass = trim($_POST['password']);
    $repeatPass = trim($_POST['repeat_password']); 
    
    if(!$errors){
      $query  = 'SELECT * FROM users WHERE email = "' . $_SESSION['user'][email] . '" AND password = MD5("' . $currentPass . '") LIMIT 1';  
      $result = mysqli_query($dbLink,$query);  
      if(mysqli_num_rows($result) == 1){
        //echo '<script type="text/javascript">alert("Existing User");</script>'; 
        if($newPass==$repeatPass){
          //echo '<script type="text/javascript">alert("Passwords Match");</script>';
            $sql = "UPDATE users SET password=MD5('". $newPass ."') WHERE email='".$_SESSION['user'][email]."'";             
            if(mysqli_query($dbLink,$sql)){
              //echo '<script type="text/javascript">alert(MD5("testtest");</script>';
              echo '<script type="text/javascript">alert("Password Changed");</script>';
              //echo '<script type="text/javascript">BootstrapDialog.show({type:"type-success", title: "Information",message: "Password successfully changed!"});</script>';
              
              header("Refresh:0");
            }  
            else{
              echo '<script type="text/javascript">alert("Password Could not be changed!");</script>';
              //echo '<script type="text/javascript">BootstrapDialog.show({type:"type-danger", title: "Error",message: "Sorry, your password could not be changed!"});</script>';       
            }
        }
        else{
          echo '<script type="text/javascript">alert("New passwords do not match!");</script>';
          //echo '<script type="text/javascript">BootstrapDialog.show({type:"type-warning", title: "Warning",message: "Make sure you provide the same passwords!"});</script>';
        }
      }
      else{
        echo '<script type="text/javascript">alert("Incorrect password!");</script>';
       // echo '<script type="text/javascript">BootstrapDialog.show({type:"type-warning", title: "Warning",message: "Incorrect password!"});</script>';        
      } 
    }
  }
?>
</html>
  