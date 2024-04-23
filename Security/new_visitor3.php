<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$head = "Visitor Info";
$des = "Page Load new_visitor3";
$rem = "New visitor";
include '../include/_audi_log.php';
$visitor_data = "";
$gvt_id_type = "";
$gvt_id_no = "";
$name = "";
$company = "";
$desig1 = "";
$add = "";
$gmail = "";
$cont = "";
$id_no = "";
$saluation = "";
$e = false;
$visit_id = "";
if (isset($_POST['u_submit'])) {
    $e = true;
    $visitor_data = $_POST['visit'];
    $user_id = $_SESSION['user_id'];

    $gvt_id_type = $visitor_data[5];
    $gvt_id_no = $visitor_data[6];
    $saluation = $visitor_data[7];
    $name = $visitor_data[8];
    $company = $visitor_data[9];
    $desig = $visitor_data[10];
    $add = $visitor_data[11];
    $gmail = $visitor_data[12];
    $cont = $visitor_data[13];
    $id_no = $visitor_data[14];
    if ($desig == "") {
        $visitor_data[10] = " ";
    }

    if ($gmail == "") {
        $visitor_data[12] = " ";
    }


    if ($gvt_id_type != "" && $gvt_id_no != "" && $name != "" && $company != "" && $add != "" && $cont != "") {

        // echo $gvt_id_type."<br>".$gvt_id_no."<br>".$name."<br>".$company."<br>".$desig."<br>".$add."<br>".$gmail."<br>".$cont;

        if (strlen($cont) == 10) {



            $sql_check_id = mysqli_query($conn, "select * from `visitor_info` where `govt_id_type` = '$gvt_id_type' and `govt_id_no`='$gvt_id_no'");
            if (mysqli_num_rows($sql_check_id) > 0) {
                $data = mysqli_fetch_assoc($sql_check_id);
                $visit_id = $data['visitor_id'];

                $sql_update = mysqli_query($conn, "update `visitor_info` set `salutation`= '$saluation', `name`='$name',`com_name`='$company',`designation`='$desig',`address`='$add',`mail_id`='$gmail',`contact_no`='$cont', `register_by`='$user_id' where `visitor_id` = '$visit_id'");

            } else {
                $sql_no_data = mysqli_num_rows(mysqli_query($conn, "select * from `visitor_info`"));
                $visit_id = "VI-" . ($sql_no_data + 1) . "-" . time();
                $sql_insert = mysqli_query($conn, "insert into `visitor_info`(`visitor_id`, `govt_id_type`, `govt_id_no`, `salutation`, `name`, `com_name`, `designation`, `address`, `mail_id`, `contact_no`,`register_by`,`register_date`) values ('$visit_id','$gvt_id_type','$gvt_id_no','$saluation','$name','$company','$desig','$add','$gmail','$cont','$user_id',current_timestamp)");
            }
        } else {
            $_SESSION['icon'] = 'info';
            $_SESSION['status'] = 'You Should provide 10 digit mobile no';
            header("location:new_visitor1");
        }
    } else {
        $_SESSION['icon'] = 'info';
        $_SESSION['status'] = 'You Should provide all details carefully';
        header("location:new_visitor1");
    }
    $visitor_data[7] = "";
    $visitor_data[8] = $saluation . " " . $name;

} else {
    $_SESSION['icon'] = 'info';
    $_SESSION['status'] = 'Please Fill This Form At Fast';
    header("location:new_visitor1");
}












?>
<!DOCTYPE html>
<html lang="en">

<?php include "include/head.php"; ?>

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
                        <?php include "include/header.php" ?>
                        <!-- Page-header end -->

                        <div class="pcoded-inner-content">
                            <!-- Main-body start -->
                            <div class="main-body">
                                <div class="page-wrapper">
                                    <!-- Page-body start -->
                                    <div class="page-body">
                                        <div class="card">


                                            <div class="row">
                                                <div class="col-md-6" style=" display:grid; place-content:center;">
                                                    <div id="my_camera" style="width:303px; height:253px;"></div>
                                                    <div class="user-entry"
                                                        style="margin-left: .4rem; padding:1rem; margin-top:1.2rem;">

                                                        <a href="new_visitor1"><button type="button"
                                                                class="btn waves-effect waves-light btn-inverse btn-outline-inverse"><i
                                                                    class="icofont icofont-exchange"></i>Back</button></a>
                                                        <button type="click" id="click_pic"
                                                            class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                                            onclick="take_snapshot()"><i class="fa fa-camera"
                                                                style=" font-size: 20px;margin-right: 10px;"
                                                                autofocus></i>Click A Picture</button>
                                                    </div>
                                                    <form action="new_visitor_final" method="post"
                                                        enctype="multipart/form-data" id="img_sub">
                                                        <?php
                                                        if ($e == true) {

                                                            foreach ($visitor_data as $id => $value) {
                                                                if ($id != "7") {
                                                                    ?>
                                                                    <input type="hidden" name="visit[]"
                                                                        value="<?php echo $value; ?>">
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                        <input type="hidden" name="visit_id"
                                                            value="<?php echo $visit_id; ?>" />
                                                        <input type="hidden" name="image" class="image-tag" id="img2" />
                                                        <input type="hidden" name="uid"
                                                            value="<?php echo "VSL-" . abs(crc32(uniqid())); ?>" />
                                                        <!-- <input type="text" value="yes" id = "img2"> -->

                                                </div>
                                                <div class="col-md-6" style=" display:grid; place-content:center; ">
                                                    <div id="results"
                                                        style="width:303px; height:253px; margin-top:.2rem;"></div>
                                                    <div id="sub_id" class="user-entry"
                                                        style="margin-left: .4rem; padding:.5rem; padding-top:1.5rem; display:grid;">
                                                        <button type="submit"
                                                            class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                                            name="img_submit"><i class="fa fa-camera"
                                                                style="    font-size: 20px;margin-right: 10px;"></i>Submit</button>
                                                    </div>

                                                </div>
                                            </div>
                                            </form>
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
    <?php include "include/footer.php"; ?>
</body>

</html>
<script language="JavaScript">
    Webcam.set({
        width: 303,
        height: 250,
        image_format: "jpeg",
        jpeg_quality: 100,
    });

    Webcam.attach("#my_camera");

    function take_snapshot() {
        Webcam.snap(function (data_uri) {
            $(".image-tag").val(data_uri);
            document.getElementById("results").innerHTML =
                '<img src="' + data_uri + '"/>';
        });
    }
</script>