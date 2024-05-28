<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$head = "Referral Info";
$des = "Page Load refer_emp";
$rem = "Reffer";
include '../include/_audi_log.php';
$e = false;
$v_id = "";
$emp_code = "";
if (isset($_POST['reffer'])) {
    $v_id = $_POST['v_id'];
    $back_page = $_POST['back_page'];
    $emp_code = $_POST['emp_code'];
    if ($_SESSION['emp_code'] != "") {
        $emp_code = $_SESSION['emp_code'];

    }



} else {
    $_SESSION['icon'] = 'info';
    $_SESSION['status'] = 'Insuficant Data for Referral....';
    header("loction:view_visitor");
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
                                                        <h5> Reffer</h5>
                                                    </div>

                                                    <div class="card-block">
                                                        <form action="new_visit_process" method="post">
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label">User Name<span
                                                                        style="color:red; padding:2px;">
                                                                        *</span></label>
                                                                <div class="col-sm-9">
                                                                    <input list="emps" type="text" class="form-control"
                                                                        placeholder="Enter Employe Name "
                                                                        oninput="this.value = this.value.toUpperCase()"
                                                                        required id="empData" autofocus>
                                                                    <datalist id="emps">

                                                                        <?php
                                                                        if (in_array($user_role, array("Developer", "Super Admin"))) {
                                                                            $sql_emp_data = mysqli_query($conn, "select eomploye_details.* from eomploye_details join user on eomploye_details.EmployeeId = user.EmployeeId where eomploye_details.Emp_code!='$emp_code' and user.user_role != 'Security'");

                                                                        } else {
                                                                            $sql_emp_data = mysqli_query($conn, "select eomploye_details.* from eomploye_details join user on eomploye_details.EmployeeId = user.EmployeeId where eomploye_details.Emp_code!='$emp_code' and user.user_role != 'Security'and eomploye_details.`BranchId`='$branch_id'");

                                                                        }

                                                                        while ($emp_data = mysqli_fetch_assoc($sql_emp_data)) {
                                                                            ?>
                                                                            <option
                                                                                data-value="<?= $emp_data['Emp_code'] ?>">
                                                                                <?= $emp_data['EmployeeName']; ?>
                                                                            </option>
                                                                        <?php } ?>
                                                                    </datalist>
                                                                    <input type="hidden" name="refer_to"
                                                                        id="empData-hidden">
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label">Status</label>
                                                                <div class="col-sm-9">
                                                                    <label type="label" class="form-control"
                                                                        value="Arrived"><span
                                                                            style="color:green; font-weight:900;">Reffer</span></label>

                                                                </div>
                                                            </div>
                                                            <div class="user-entry">
                                                                <input type="hidden" name="back_page"
                                                                    value="view_visitor.php">
                                                                <input type="hidden" name="v_log_id"
                                                                    value="<?php echo $v_id; ?>">
                                                                <input type="hidden" name="back_page"
                                                                    value="<?php echo $back_page; ?>">
                                                                <button type="reset"
                                                                    class="btn waves-effect waves-light btn-inverse btn-outline-inverse"><i
                                                                        class="icofont icofont-exchange"></i>Cancel</button>
                                                                <button type="submit"
                                                                    class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                                                    name="refer_submit"><i class="fa fa-arrow-right"
                                                                        style="    font-size: 20px;margin-right: 10px;"></i>Reffer</button>
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
    $("#empData").change(function () {

        let emp = $("#empData-hidden").val();
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


    // function showTime(){
    //     var date = new Date();
    //     var h = date.getHours(); // 0 - 23
    //     var m = date.getMinutes(); // 0 - 59
    //     var s = date.getSeconds(); // 0 - 59
    //     var session = "AM";

    //     if(h == 0){
    //         h = 12;
    //     }

    //     if(h > 12){
    //         h = h - 12;
    //         session = "PM";
    //     }

    //     h = (h < 10) ? "0" + h : h;
    //     m = (m < 10) ? "0" + m : m;
    //     s = (s < 10) ? "0" + s : s;

    //     var time = h + ":" + m + ":" + s + " " + session;
    //     document.getElementById("clock_span2").innerText = time;
    //     document.getElementById("clock_span2").textContent = time;

    //     setTimeout(showTime, 1000);

    // }

    // showTime();
</script>