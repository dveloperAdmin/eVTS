<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$des = "Page Load Company";
$rem = "Company";
$head = "User Info";
include '../include/_audi_log.php';

if (isset($_POST['reset_pass'])) {
    $user_id = $_POST['U_id'];
    $check_no = mysqli_num_rows(mysqli_query($conn, "select * from `user` where `user_name` = '$user_id'"));
    if ($check_no) {
        $pass_u = 'vms' . date('Y');
        $pass = password_hash($pass_u, PASSWORD_DEFAULT);
        $update_pass = mysqli_query($conn, "update `user` set `password`='$pass' where `user_name` = '$user_id'");
        if ($update_pass) {
            $_SESSION['icon'] = 'success';
            $_SESSION['status'] = 'Password Reset Successfully..';
        } else {
            $_SESSION['icon'] = 'error';
            $_SESSION['status'] = 'Password Not Reset... ';
        }

    } else {
        $_SESSION['icon'] = 'info';
        $_SESSION['status'] = 'User Not Exist...';
    }
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

                  <!-- Page body start -->
                  <div class="page-body">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="card" style="margin-bottom: 8px;">
                          <div class="card-header" style="padding-bottom:8px;padding-top:8px;">
                            <h5>Reset Password</h5>
                          </div>
                          <div class="card-block">
                            <form action="" method="post">


                              <div class="form-group row">
                                <label class="col-sm-3 col-form-label">User Id</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" id="uid"
                                    oninput="this.value = this.value.toUpperCase()" placeholder="Enter User Id "
                                    maxlength="10" name="U_id" required>
                                </div>
                              </div>
                              <h5 style=" font-family: 'Noto Sans', sans-serif; font-style: italic;">
                                Default
                                Password :- vms<?php echo date('Y') ?></h5>

                              <div class="user-entry">

                                <button type="reset"
                                  class="btn waves-effect waves-light btn-inverse btn-outline-inverse"
                                  style="padding: 7px 20px;"><i class="icofont icofont-exchange"></i>Cancel</button>
                                <button type="submit"
                                  class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                  style="padding: 7px 20px;" name="reset_pass"><i class="fa fa-pencil-square"
                                    style="font-size: 20px;margin-right: 10px;"></i>Reset
                                  PassWord</button>
                              </div>
                            </form>
                          </div>
                        </div>

                      </div>


                      <div class="col-md-6" id="contact1">

                      </div>
                      <!-- <div class="col-md-6">

                                                <div class="card text-center order-visitor-card" id="total-c"
                                                    style="margin-bottom:8px">
                                                    <div class="card-block dsh-card" style="padding-bottom:8px;">
                                                        <i class="fa fa-building-o m-r-15 text-c-black"></i>
                                                        <div class="card-text">
                                                            <h6 class="m-b-0">TOTAL COMPANY</h6>
                                                            <h4 class="m-t-15 m-b-15">7652</h4>
                                                            <p class="m-b-0"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                 </div> 
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="card text-center order-visitor-card" id="total-ca">
                                                            <div class="card-block dsh-card">
                                                                <i class="fa fa-check-square m-r-15 text-c-black"></i>
                                                                <div class="card-text">
                                                                    <h6 class="m-b-0">Active Comapany</h6>
                                                                    <h4 class="m-t-15 m-b-15">7652</h4>
                                                                    <p class="m-b-0"></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="card text-center order-visitor-card" id="total-cda">
                                                            <div class="card-block dsh-card">
                                                                <i class="fa fa-window-close m-r-15 text-c-black"></i>
                                                                <div class="card-text">
                                                                    <h6 class="m-b-0">De-Active Company</h6>
                                                                    <h4 class="m-t-15 m-b-15">7652</h4>
                                                                    <p class="m-b-0"></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> -->
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
<script type="text/javascript">
$("#uid").keyup(function() {
  let uid = $(this).val();

  if (uid != "") {


    let emp_id = 'uid=' + uid;
    $.ajax({
      type: "POST",
      url: "ajax_chg_pass.php",
      data: emp_id,
      cache: false,
      success: function(cities) {
        $("#contact1").css("display", "block");
        $("#contact1").html(cities);
      }
    });
  } else {
    $("#contact1").css("display", "none");
  }

});
</script>