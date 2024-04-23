<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$head="Import Employee Info";
$des="Page Load import_emp";
$rem="Import Info";
include '../include/_audi_log.php';
$month = ['January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December'];
$sql_emp_code_temp = mysqli_query($conn, "select * from `import_emp_temp`");
if(mysqli_num_rows($sql_emp_code_temp) >= 1){
    mysqli_query($conn, "truncate `import_emp_temp`");
    
}


  if(isset($_POST['excel_download'])){
      
      include "../include/xlsxgen.php";
      
      $table_formate =[
            
            ['<b>Sl_NO</b>','<b>Employee_Code','<b>Employee_Name','<b>Company_Name','<b>Branch','<b>Department','<b>Sub_Department','<b>Designation','<b>Location','<b>Employee_Type','<b>Category','<b>Contact','<b>Email']
    
      ];        // $datatable = emp_table();
     
    $xlsx = SimpleXLSXGen::fromArray($table_formate);
    $xlsx->downloadAs('Employee_details.xlsx');


    
  }                                                          

                                                        



?>
<!DOCTYPE html>
<html lang="en">

<?php include "include/head.php";?>

<body>
    <!-- Pre-loader start -->
    <?php include "include/pre_loader.php"; ?>
    <!-- Pre-loader end -->
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">
            <!-- navbar start -->
            <?php include "include/navbar.php"; ?>
            <!-- navbar end -->

            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">

                    <!-- Side Manu start -->
                    <?php include "include/manu.php"; ?>
                    <!-- Side Manu end -->

                    <div class="pcoded-content">

                        <!-- Page-header start -->
                        <?php include "include/header.php"?>
                        <!-- Page-header end -->

                        <div class="pcoded-inner-content">
                            <!-- Main-body start -->
                            <div class="main-body">
                                <div class="page-wrapper">

                                    <!-- Page body start -->
                                    <div class="page-body">
                                        <div class="row">
                                  


                                            <div class="col-md-6" style="max-width: 80%; flex: 1 0 56%;">
                                                <div class="card">
                                                <div class="card-header"
                                                        style="padding-bottom:8px;padding-top:8px;margin-bottom:1rem;">
                                                        <h5>Import Employee Details</h5>
                                                    </div>
                                                    
                                                    <div class="card-block table-border-style">

                                                        <form action="import_emp_process" method="post" enctype="multipart/form-data">
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label" style="padding-right: 0;max-width:7.7rem;">Import Excel File</label>
                                                                <div class="col-sm-9" style="max-width: 61%;">
                                                                <div class="row">

                                                                    <input type="file" class="form-control" id="mob"  name="excel_file" style="max-width:66%;  margin-right:1.5rem; " required>
                                                                            
                                                                    <button   class="btn waves-effect waves-light btn-primary btn-outline-primary" style="padding: 7px 20px; background-color:none;" name="excel_upload"><i class="icofont icofont-upload"  style="    font-size: 20px;margin-right: 10px;"></i>                 Import</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                        <div class="user-entry">
                                                            <!-- <button   class="btn waves-effect waves-light btn-primary btn-outline-primary" style="padding: 7px 20px; background-color:none;" name="emp_mob_pdf"><i class="icofont icofont-automation"  style="    font-size: 20px;margin-right: 10px;"></i>       Process</button> -->
                                                        </div>
                                                    </div>
                                                </div>
                                                <form action="" method="post">
                                                <div class="card-block table-border-style" style="padding-bottom:10pxpadding-top:0px;">
                                                    <div class="form-group row">

                                                            <div class="col-sm-9" style="max-width: 80%; padding:0px;">
                                                                <label class="col-sm-3 col-form-label" style="padding-right:0px;max-width:65%;font-size: 1.5rem;font-weight: 700;font-family: serif; color: #000;">Download And Fill Up This Excel Formate </label>
                                                                <button   class="btn waves-effect waves-light btn-primary btn-outline-primary" style="padding: 7px 20px; background-color:none;" name="excel_download"><i class="icofont icofont-download"  style="    font-size: 20px;margin-right: 10px;"></i>Download Excel Formate</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                </div>
                            </div>
                        </div>
                        <!-- Page-body end -->
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>

    <!-- Required Jquery -->
    <?php include "include/footer.php";?>
</body>

</html>
<script>
    $("#mob").keyup(function(){
       $("#emp_name").val('');
       $("#com").val('');
       $("#dept").val('');
       $("#bran").val('');
    })
    $("#emp_name").keyup(function(){
       $("#mob").val('');
       $("#com").val('');
       $("#dept").val('');
       $("#bran").val('');
    })
    $("#com , #dept, #bran").change(function(){
       $("#mob").val('');
       $("#emp_name").val('');
       
    })

</script>