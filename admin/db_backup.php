<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$des="Page Load db_backup";
$rem="Database Backup";
$head  = "Biometric SetUp";
include '../include/_audi_log.php';


$sql_db_size_cms = mysqli_fetch_assoc(mysqli_query($conn, "select table_schema 'db_name', sum( data_length + index_length) / 1024 / 1024 'db_size_in_mb' from information_schema.tables where table_schema='$db_cms' group by table_schema;"));
// $sql_db_size_bio = mysqli_fetch_assoc(mysqli_query($conn_bio, "select table_schema 'db_name', sum( data_length + index_length) / 1024 / 1024 'db_size_in_mb' from information_schema.tables where table_schema='$db_bio' group by table_schema;"));





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

                                        <div class="card" style="padding:1rem">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h5 id="bio_sync" style="font-size:1rem;    font-family: emoji;">
                                                        Database Name
                                                        :-<?php  echo"<span style='color:red; font-size: 16px;  padding-left: 2rem'>".$db_cms."</span>" ?>
                                                    </h5>
                                                    <h5 id="bio_sync" style="font-size:1rem;    font-family: emoji;">
                                                        Database Size
                                                        :-<?php  echo"<span style='color:red; font-size: 16px;  padding-left: 2rem'>&nbsp;".number_format((float)$sql_db_size_cms['db_size_in_mb'], 3, '.', '')." Mb</span>" ?>
                                                    </h5>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="user-entry">
                                                        <a href="database_backup_cms">
                                                            <button
                                                                class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                                                style="padding: 7px 20px;" name="sync_upadate"><i
                                                                    class="fa fa-angle-double-up"
                                                                    style="    font-size: 20px;margin-right: 10px;"></i>
                                                                Download <?php echo $db_cms;?>  Database</button>
                                                        </a>
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