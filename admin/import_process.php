<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$head="Import Employee Info";
$des="Page Load import_process";
$rem="Import Procss";
include '../include/_audi_log.php';
$month = ['January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December'];

$sql_insert_no = mysqli_query($conn,"select * from `import_emp_temp` where `Status` = 'Insert'");
$sql_update_no = mysqli_query($conn,"select * from `import_emp_temp` where `Status` = 'Update'");


















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
                                                <div class="card-header" style="padding-bottom:8px;padding-top:8px;margin-bottom:1rem;">
                                                        <h5>Import Employee Process</h5>
                                                    </div>
                                                    
                                                    <div class="card-block table-border-style">
                                                        <div>
                                                            <h5 style="color:green; ">Inseert Employee No : <span style="color:Blue;"><?php echo mysqli_num_rows($sql_insert_no);?></span> </h5>
                                                            &nbsp;
                                                            &nbsp;
                                                            &nbsp;
                                                            <h5 style="color:green; ">Update Employee No : <span style="color:Blue;"><?php echo mysqli_num_rows($sql_update_no);?></span> </h5>
                                                        </div>
                                                        <div class="user-entry" style="margin-right: 1rem;">
                                                            <div class="form-group row">
                                                            <a href="import_emp"><button   class="btn waves-effect waves-light btn-primary btn-outline-primary" style="padding: 7px 20px; background-color:none; margin-right:1.5rem;" name="emp_mob_pdf"><i class="icofont icofont-arrow-left"  style="    font-size: 20px;margin-right: 10px;"></i>       Back</button></a>
                                                            
                                                            <form action="import_emp_process" method="post">
                                                                <button   class="btn waves-effect waves-light btn-primary btn-outline-primary" style="padding: 7px 20px; background-color:none;" name="emp_import_process"><i class="icofont icofont-automation"  style="    font-size: 20px;margin-right: 10px;"></i>       Process</button>

                                                            </form>

                                                        </div>
                                                    </div>
                                                </div>
                                                
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