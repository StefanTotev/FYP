<?php  
include_once('config.php');  

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
            Home - Logged in and Session establieshed

            <a href="logout.php" class="btn btn-default btn-flat">Sign out Button</a>

            <a href="adduser.php" class="btn btn-default btn-flat">Create New User Button</a>
            <small>System Components</small>
          </h1>
          </br>
          <p>Use php Session to display information from database:</p>
          <p>email: <?php echo $_SESSION['user'][email];?></p>
          <p>password: <?php echo $_SESSION['user'][password];?></p>
        </section>

      </div><!-- /.content-wrapper -->

    </div><!-- ./wrapper -->

  </body>
</html>
  