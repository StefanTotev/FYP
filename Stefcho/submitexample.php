<?php  
include_once('config.php');  

error_reporting(1);
// Reset errors and success messages  
$errors = array();  
$success = array();

  
?>  

<!DOCTYPE html>
<html>
  <head>
   
  </head>
  <body class="hold-transition skin-green sidebar-mini sidebar-collapse">
    <div class="wrapper">

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->


        <!-- Main content -->
        <section class="content">

          <div class="row">
            <div class="col-md-12">
              <div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title">Submit data example</h3>
                </div><!-- /.box-header -->
                <div class="box-body" id="timesheetSubmitBox">
                  <form class="visible-lg" id="timesheetForm" name="timesheetForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" type="file" method="post">
                      <fieldset>
                        
                        <div class='col-md-12'>
                          <div class='col-md-12' style="margin-bottom: 15px">
                              
                              <label for="comments">Comments</label>
                              <textarea name="comments" id="comments" name="comments" class="form-control vresize" style="resize:vertical;"></textarea>
                          </div>
                        </div>
                        <div class='col-md-6 col-md-offset-3'>       
                            <input type="hidden" name="timesheetFormSubmit" id="timesheetFormSubmit" value="true" />  
                            <button type="button" onclick="Formsubmission();" class="btn btn-md btn-success btn-block">Submit</button>
                        </div>
                      </fieldset>
                    </form>
                </div><!-- /.box-body -->
                
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
            </div><!-- /.col -->
          </div><!-- /.row -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

    </div><!-- ./wrapper -->


    <script type="text/javascript">
      function Formsubmission(){
        var empty = "false";
        if($("#comments").val() === ""){
          empty = "true";
        }
        
        if(empty == "false"){
          document.timesheetForm.submit();
        }
        else{
          alert("Please ensure all mandatory fields are completed");
        }
      }


      // EXAMPLE OF AXAJ POST REQUEST TO EXTERNAL PHP FILE USING JAVASCRIPT
      function getJobInfo(job){
      $.ajax({
        type: "GET",
        url: "viewjobinfo.php",
        //dataType: "JSON",
        data: {"job": job}, 
        success: function (data) { // on success the request returns the PHP echo as "data"
            var obj = JSON.parse(data); // parse the data if your PHP file returns JSON. if not just use "data"
            
            // do something with your data. Commented out functionality to populate fields ( might be useful )
            // $("#jobnumber").val(obj[0]['value']);
            // $("#jobnumber_mobile").val(obj[0]['value']);
        }
      });
    }
    </script>
  </body>
</html>


<?php


// Post Desktop Timesheet attempt  
if(isset($_POST['timesheetFormSubmit']) && $_POST['timesheetFormSubmit'] == 'true'){  
    // Detects that the Javascript has submitted the form => do you PHP logic here or move this to separate file. Get data from database from here
  }

// Unelegant way to use javascript in PHP
$variable = "penis";
echo '<script type="text/javascript">console.log("'.$variable.'");</script>';
            
 
?>  