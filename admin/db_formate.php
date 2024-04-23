<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
// include '../include/_lic_check.php';

$des="Page Load db_backup";
$rem="Database Backup";
$head  = "Biometric SetUp";
include '../include/_audi_log.php';

// Size of Database 

$sql_db_size_cms = mysqli_fetch_assoc(mysqli_query($conn, "select table_schema 'db_name', sum( data_length + index_length) / 1024 / 1024 'db_size_in_mb' from information_schema.tables where table_schema='$db_cms' group by table_schema;"));



if(isset($_POST['formate_database'])){
    // formate license 
    $fp = fopen("../src/license.lic", "r+");
    ftruncate($fp, 0);
    fclose($fp);
    $fp = fopen("../include/_company.php", "r+");
    ftruncate($fp, 0);
    fclose($fp);

    $sql_select_derop= mysqli_query($conn,"select * from information_schema.tables where table_name like 'canteenreport%';");
    
    while($tables = mysqli_fetch_assoc($sql_select_derop)){
        $drop= $tables['TABLE_NAME'];
        mysqli_query($conn,"drop table $drop");
        // echo $drop."<br>";
    }

    $sql=mysqli_query($conn,"select concat('truncate table ',table_schema,'.',table_name, ';') 
        from information_schema.tables where table_schema in ('$db_cms') and table_name!='user';");

    while($table = mysqli_fetch_assoc($sql)){
        $sql_truncate= $table["concat('truncate table ',table_schema,'.',table_name, ';')"];
        mysqli_query($conn,$sql_truncate);
        // echo $sql_truncate."<br>";
    }

    $user_delete = mysqli_query($conn,"delete from `user` where `name`!='Admin'");
    $_SESSION['icon'] = 'success';
    $_SESSION['status'] = 'Database Fomated Successfully..';

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
                                                        <form action="" method="post">

                                                            <button
                                                                class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                                                style="padding: 7px 20px;" name="formate_database"><i
                                                                    class="fa fa-angle-double-up"
                                                                    style="    font-size: 20px;margin-right: 10px;"></i>
                                                                Formate <?php echo strtoupper($db_cms);?>  Database</button>
                                                        </form>
                                                        
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- <div class="card" style="padding:1rem">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h5 id="bio_sync" style="font-size:1rem;    font-family: emoji;">
                                                        Database Name
                                                        :-<?php  //echo"<span style='color:red; font-size: 16px;  padding-left: 2rem'>".$db_bio."</span>" ?>
                                                    </h5>
                                                    <h5 id="bio_sync" style="font-size:1rem;    font-family: emoji;">
                                                        Database Size
                                                        :-<?php  //echo"<span style='color:red; font-size: 16px;  padding-left: 2rem'>&nbsp;".number_format((float)$sql_db_size_bio['db_size_in_mb'], 3, '.', '')." Mb</span>" ?>
                                                    </h5>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="user-entry">
                                                        <a href="database_backup_bio">
                                                            <button
                                                                class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                                                style="padding: 7px 20px;" name="sync_upadate"><i
                                                                    class="fa fa-angle-double-up"
                                                                    style="    font-size: 20px;margin-right: 10px;"></i>
                                                                Download <?php //echo $db_bio ;?> Database</button>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div> -->
                                        

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