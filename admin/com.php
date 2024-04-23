<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$des="Page Load com ";
$rem="Comapany details";
$head = "Comapnay Details";
include '../include/_audi_log.php';
if(isset($_POST['com_sub'])){
    $com_name = $_POST['com'];
    $key= "<?php    $"."com_name = '". $com_name ."';    ?>";
    $fp = fopen("../include/_company.php", "r+");
    ftruncate($fp, 0);
    fclose($fp);
    
    $fp = fopen('../include/_company.php', 'w');
    fwrite($fp, $key);
    fclose($fp);
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
                                            
                                                <div class="col-md-6">
                                                    <div class="card" style="margin-bottom: 8px;">
                                                        <div class="card-header"  style="padding-bottom:8px;padding-top:8px;">
                                                            <h5>Company Details</h5>
                                                        </div>
                                                        <div class="card-block">
                                                            <form action="" method="post">
                                                            <div class="form-group row">
                                                                    <label class="col-sm-3 col-form-label" style="padding-right: 0;">Comapny Name</label>
                                                                    <div class="col-sm-9">
                                                                        <input type="text" class="form-control" placeholder="Enter Company Name" name="com" required>
                                                                    </div>
                                                                </div>
                                                            
                                                                <div class="user-entry">

                                                                    <button type="reset" class="btn waves-effect waves-light btn-inverse btn-outline-inverse"style="padding: 7px 20px;"><i class="icofont icofont-exchange"></i>Cancel</button>
                                                                    <button type="submit" class="btn waves-effect waves-light btn-primary btn-outline-primary"style="padding: 7px 20px;" name="com_sub"><i class="fa fa-plus" style=" font-size: 20px;margin-right: 10px;"></i> Add Company</button>
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
