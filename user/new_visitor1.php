<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$head = "Visitor Info";
$des = "Page Load new_visitor1";
$rem = "New visitor";
include '../include/_audi_log.php';
$e = false;

$folder_path = "../upload_temp/";

// List of name of files inside
// specified folder
$files = glob($folder_path . '/*');

// Deleting all the files in the list
foreach ($files as $file) {

    if (is_file($file))

        // Delete the given file
        unlink($file);

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
                    <!-- <?php echo $pass; ?> -->
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

                                    <!-- Page body start -->
                                    <div class="page-body">
                                        <div class="row">
                                            <div class="col-md-6">

                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5>New Visitor Entry</h5>
                                                    </div>

                                                    <div class="card-block">
                                                        <form action="new_visitor2" method="post">
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label">Employee
                                                                    Name<span style="color:red; padding:2px;">
                                                                        *</span></label>
                                                                <div class="col-sm-9">
                                                                    <input list="emps" type="text" class="form-control"
                                                                        placeholder="Enter Employe Name "
                                                                        oninput="this.value = this.value.toUpperCase()"
                                                                        required id="empData" autofocus>
                                                                    <datalist id="emps">

                                                                        <?php
                                                                        if (in_array($user_role, array("Developer", "Super Admin"))) {
                                                                            $sql_emp_data = mysqli_query($conn, "select eomploye_details.* from eomploye_details join user on eomploye_details.EmployeeId = user.EmployeeId where user.user_role != 'Security'");

                                                                        } else {
                                                                            $sql_emp_data = mysqli_query($conn, "select eomploye_details.* from eomploye_details join user on eomploye_details.EmployeeId = user.EmployeeId where user.user_role != 'Security'and eomploye_details.`BranchId`='$branch_id'");

                                                                        }

                                                                        while ($emp_data = mysqli_fetch_assoc($sql_emp_data)) {
                                                                            ?>
                                                                            <option
                                                                                data-value="<?= $emp_data['Emp_code'] ?>">
                                                                                <?= $emp_data['EmployeeName']; ?>
                                                                            </option>
                                                                        <?php } ?>
                                                                    </datalist>
                                                                    <input type="hidden" name="visit[]"
                                                                        id="empData-hidden">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label">Status</label>
                                                                <div class="col-sm-9">
                                                                    <label type="label" class="form-control"
                                                                        value="Arrived"><span
                                                                            style="color:green; font-weight:900;">Pre
                                                                            Schedule</span></label>
                                                                    <input type="hidden" name="visit[]"
                                                                        value="PRE SCHEDULE" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label"> Date <span
                                                                        style="color:red; padding:2px;">
                                                                        *</span></label>
                                                                <div class="col-sm-9">
                                                                    <!-- <label type="label" class="form-control" value="Arrived"><span style="color:green; font-weight:900;" ><?php echo date("d / M / Y") . " - "; ?> <span id= "clock_span2"></span></span></label> -->
                                                                    <input type="date" class="form-control"
                                                                        id="date_picker" name="visit[]" value=""
                                                                        required>
                                                                    <!-- <span style="color:red">* Date Should be greter then Today</span> -->
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label">Gate No<span
                                                                        style="color:red; padding:2px;">
                                                                        *</span></label>
                                                                <div class="col-sm-9">
                                                                    <select name="visit[]" id="gt_info"
                                                                        class="form-control" required>
                                                                        <option value="" selected disabled hidden>Select
                                                                            Gate No</option>
                                                                        <?php
                                                                        $sql_gate = mysqli_query($conn, "select * from `gate_info`");
                                                                        while ($gate = mysqli_fetch_assoc($sql_gate)) {
                                                                            ?>
                                                                            <option
                                                                                value="<?php echo $gate['gate_number']; ?>">
                                                                                <?php echo $gate['gate_number']; ?>
                                                                            </option>

                                                                        <?php } ?>
                                                                    </select>

                                                                </div>

                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label">Visit
                                                                    Purpose<span style="color:red; padding:2px;">
                                                                        *</span></label>
                                                                <div class="col-sm-9">
                                                                    <select name="visit[]" id="v_p" class="form-control"
                                                                        required>
                                                                        <option value="" selected disabled hidden>Select
                                                                            Purpose</option>
                                                                        <?php
                                                                        $sql_pur = mysqli_query($conn, "select * from `visit_purpose`");
                                                                        while ($pur = mysqli_fetch_assoc($sql_pur)) {
                                                                            ?>
                                                                            <option
                                                                                value="<?php echo $pur['purpose_id']; ?>">
                                                                                <?php echo $pur['purpose']; ?>
                                                                            </option>

                                                                        <?php } ?>
                                                                    </select>

                                                                </div>

                                                            </div>


                                                            <div class="user-entry">

                                                                <button type="reset"
                                                                    class="btn waves-effect waves-light btn-inverse btn-outline-inverse"><i
                                                                        class="icofont icofont-exchange"></i>Cancel</button>
                                                                <button type="submit"
                                                                    class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                                                    name="u_submit"><i class="fa fa-arrow-right"
                                                                        style="    font-size: 20px;margin-right: 10px;"></i>Next</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="card" id="contact1">
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
    <?php include "include/footer.php"; ?>
</body>

</html>
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js">
</script> -->

<script type="text/javascript">
    $("#date_picker").keypress(function (e) {
        return false;
    });
    $("#date_picker").keydown(function (e) {
        return false;
    });
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0');
    var yyyy = today.getFullYear();

    today = yyyy + '-' + mm + '-' + dd;
    $('#date_picker').attr('min', today);



    $("#empData").change(function () {
        $("#date_picker").val("");
        $("#gt_info").val("");
        $("#v_p").val("");
        let emp = $("#empData-hidden").val();
        // console.log(emp);
        if (emp != "") {


            let emp_id = 'id=' + emp;
            $.ajax({
                type: "POST",
                url: "ajax.php",
                data: emp_id,
                cache: false,
                success: function (cities) {
                    $("#contact1").css("display", "block");
                    $("#contact1").html(cities);
                }
            });
        } else {
            $("#contact1").css("display", "none");
        }

    });


    // function showTime() {
    //   var date = new Date();
    //   var h = date.getHours(); // 0 - 23
    //   var m = date.getMinutes(); // 0 - 59
    //   var s = date.getSeconds(); // 0 - 59
    //   var session = "AM";

    //   if (h == 0) {
    //     h = 12;
    //   }

    //   if (h > 12) {
    //     h = h - 12;
    //     session = "PM";
    //   }

    //   h = (h < 10) ? "0" + h : h;
    //   m = (m < 10) ? "0" + m : m;
    //   s = (s < 10) ? "0" + s : s;

    //   var time = h + ":" + m + ":" + s + " " + session;
    //   document.getElementById("clock_span2").innerText = time;
    //   document.getElementById("clock_span2").textContent = time;

    //   setTimeout(showTime, 1000);

    // }

    // showTime();
</script>