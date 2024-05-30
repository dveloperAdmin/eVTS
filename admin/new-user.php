<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$des = "Page Load New User";
$rem = "New User";
$head = "User Info";
include '../include/_audi_log.php';
$e = false;
// registration form submit start 
$sql_branch_num = mysqli_query($conn, "select * from `branch`");
// $branch_id = "";
$user_id = $_SESSION['user_id'];
$user_data = mysqli_fetch_assoc(mysqli_query($conn, "select * from `user` where `uid` = '$user_id'"));
// if($user_data !="" ){
//     $emp_id = $user_data['EmployeeId'];
//     $emp_details = mysqli_fetch_assoc(mysqli_query($conn, "select * from `eomploye_details` where `EmployeeId` = '$emp_id'"));


//     if($emp_details!=""){
//         $branch_id = $emp_details['BranchId'];
//     }

// }
if (isset($_POST['u_submit'])) {
  $emp_code = $_POST['user_name'];


  $u_pass = $_POST['user_pass'];
  $u_role = $_POST['user_role'];
  $u_sts = $_POST['user_sts'];
  // echo $u_no;
  // echo "yes";
  // echo $emp_code;
  $empbranch_id = "";
  $u_name = "";

  $sql_check_emp_exist = mysqli_query($conn, "select * from `eomploye_details` where `EmployeeId`='$emp_code'");
  if (mysqli_num_rows($sql_check_emp_exist) > 0) {
    $emp_data = mysqli_fetch_assoc($sql_check_emp_exist);
    if ($emp_data != "") {
      $empbranch_id = $emp_data['BranchId'];
      $u_name = $emp_data['EmployeeName'];
    }

    $check_sql = mysqli_num_rows(mysqli_query($conn, "select * from `user` where `EmployeeId`='$emp_code'"));

    if ($check_sql == 0) {

      // echo $check_sql;
      $no_user = mysqli_num_rows(mysqli_query($conn, "select * from `user`"));
      $user_name = "";
      if ($no_user == 0) {
        $user_name = "VMS001";
      } else {
        $last_uid = mysqli_fetch_assoc(mysqli_query($conn, "select * from `user` order by `sl_no` desc"));
        $lats_id = $last_uid['user_name'];
        $length = strlen($lats_id);
        $rest_pasrt = substr($lats_id, 5, ($length - 5));
        // echo $rest_pasrt;
        $user_name = "VMS00" . ($rest_pasrt + 1);

      }
      $uid = 'VMS-U-' . ($no_user + 1) . '-' . date('hisy');

      $pass = password_hash($u_pass, PASSWORD_DEFAULT);

      $uinsert_sql = mysqli_query($conn, "insert into `user`( `uid`, `EmployeeId`,`BranchId`, `user_name`, `password`, `name`, `user_role`, `user_sts`,`registration_time_stamp`) values ('$uid','$emp_code','$empbranch_id','$user_name','$pass','$u_name','$u_role','$u_sts', now())");

      if ($uinsert_sql) {
        $_SESSION['icon'] = 'success';
        $_SESSION['status'] = 'New User Added Successfully Login Id :- ' . $user_name . '';

        // audi_log insert 
        $des = "Click Add User Button";
        $rem = "New User Register";
        include '../include/_audi_log.php';

      } else {
        $_SESSION['icon'] = 'error';
        $_SESSION['status'] = 'Invalid Data';
      }

    } else {
      $_SESSION['icon'] = 'info';
      $_SESSION['status'] = 'Dublicate User';
    }
  } else {
    $_SESSION['icon'] = 'error';
    $_SESSION['status'] = 'Employee Not Exist ';
  }
}

// registration form submit start 











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
                            <h5>New Users Entry</h5>
                          </div>

                          <div class="card-block">
                            <form action="" method="post">
                              <?php if (mysqli_num_rows($sql_branch_num) > 1 && (in_array($user_role, array("Developer", "Super Admin")))) { ?>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">Branch</label>
                                  <div class="col-sm-9">
                                    <select name="user_role" id="branch" required class="form-control">
                                      <option value="" selected disabled hidden>Select
                                        Branch</option>
                                      <?php
                                      while ($branch_detils = mysqli_fetch_assoc($sql_branch_num)) { ?>
                                        <option value="<?php echo $branch_detils['branch_code'] ?>">
                                          <?php echo $branch_detils['branch_name']; ?>
                                        </option>
                                      <?php } ?>
                                    </select>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">User Name</label>
                                  <div class="col-sm-9">
                                    <input list="emps" type="text" class="form-control" placeholder="Enter Username "
                                      oninput="this.value = this.value.toUpperCase()" required id="emp">
                                    <datalist id="emps">


                                    </datalist>
                                    <input type="hidden" name="user_name" id="emp-hidden">

                                  </div>
                                </div>
                              <?php } else { ?>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label">User Name</label>
                                  <div class="col-sm-9">
                                    <input list="emps" type="text" class="form-control" placeholder="Enter Username "
                                      name="user_name" oninput="this.value = this.value.toUpperCase()" required id="emp">
                                    <datalist id="emps">

                                      <?php
                                      if (in_array($user_role, array("Developer", "Super Admin"))) {
                                        $sql_emp_data = mysqli_query($conn, "select * from `eomploye_details` and `Status` ='Working'");

                                      } else {
                                        $sql_emp_data = mysqli_query($conn, "select * from `eomploye_details` where `BranchId`='$branch_id' and `Status` ='Working'");

                                      }
                                      while ($emp_data = mysqli_fetch_assoc($sql_emp_data)) {
                                        ?>
                                        <option
                                          value="<?php echo $emp_data['EmployeeId'] . ' ' . $emp_data['EmployeeName']; ?>">
                                        <?php } ?>
                                    </datalist>

                                  </div>
                                </div>
                              <?php } ?>


                              <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Password</label>
                                <div class="col-sm-9">
                                  <input type="password" class="form-control" placeholder="Enter Pasword "
                                    name="user_pass" required>
                                </div>
                              </div>
                              <div class="form-group row">
                                <label class="col-sm-3 col-form-label">User Role</label>
                                <div class="col-sm-9">
                                  <select name="user_role" id="" required class="form-control">
                                    <option value="" selected disabled hidden>Select
                                      User Role</option>
                                    <option value="Admin">Admin</option>
                                    <option value="User">User</option>
                                    <option value="Security">Security</option>
                                    <?php if ($user_role == "Developer") { ?>
                                      <option value="Super Admin">Super Admin</option>
                                    <?php } ?>
                                  </select>

                                </div>

                              </div>
                              <div class="form-group row">
                                <label class="col-sm-3 col-form-label">User
                                  Status</label>
                                <div class="col-sm-9">
                                  <select name="user_sts" required class="form-control">
                                    <option value="" selected disabled hidden>Select
                                      User Satus</option>
                                    <option value="Active">Active</option>
                                    <option value="De-Active">De-Active</option>
                                  </select>

                                </div>

                              </div>


                              <div class="user-entry">

                                <button type="reset"
                                  class="btn waves-effect waves-light btn-inverse btn-outline-inverse"><i
                                    class="icofont icofont-exchange"></i>Cancel</button>
                                <button type="submit"
                                  class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                  name="u_submit"><i class="fa fa-user-plus"
                                    style="    font-size: 20px;margin-right: 10px;"></i>Add
                                  User</button>
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
  $("#branch").change(function () {
    $("#emp").val("");
    let branch = $(this).val();
    if (branch != "") {


      let branch_id = 'branch=' + branch;
      $.ajax({
        type: "POST",
        url: "ajax.php",
        data: branch_id,
        cache: false,
        success: function (cities) {
          // $("#emps").css("display","block");
          $("#emps").html(cities);
        }
      });
    } else {
      // $("#emps").css("display","none");
    }

  });
  $("#emp").change(function () {
    let emp = $("#emp-hidden").val();
    if (emp != "") {

      var emp_spl = emp.split(' ');
      let emp_id = 'id2=' + emp_spl[0];
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
</script>