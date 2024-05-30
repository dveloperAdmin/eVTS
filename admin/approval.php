<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$head = "Approval Status";
$des = "Page Load approval";
$rem = "approval status";
include '../include/_audi_log.php';
$log_out_time_sts = True;
$dataExists = mysqli_num_rows(mysqli_query($conn, 'select * from `approval_sts`'));

if (isset($_POST['set_app_sts'])) {
  // $com_id = $_POST['com_id'];
  $ap_branch = $_POST['branch_ap_id'];
  $app_sts = $_POST['app_sts'];
  $meet_end_sts = $_POST['end_sts'];
  $referral_sts = $_POST['end_sts'];
  $emailApp = $_POST['emailApp'];
  $camApproval = $_POST['camApp_sts'];
  if ($ap_branch != "" && $app_sts != "") {
    $sql_emp_code_temp = mysqli_query($conn, "select * from `approval_sts` where `branch_id`= '$ap_branch'");

    if (mysqli_num_rows($sql_emp_code_temp) < 1) {
      $sql_insert = mysqli_query($conn, "insert into `approval_sts`(`branch_id`, `Approve_status`, `meet_end_status`, `referral_status`, `emailApproval`, `camApprove`) values ('$ap_branch', '$app_sts', '$meet_end_sts', '$referral_sts', '$emailApp', '$camApproval')");

      if ($sql_insert != "") {
        $_SESSION['icon'] = 'success';
        $_SESSION['status'] = 'Approval Status Set Successfully';
        $des = "Page Load approval";
        $rem = "approval status Set Successfully";
      } else {
        $_SESSION['icon'] = 'error';
        $_SESSION['status'] = 'Approval Status Not Set ';
        $des = "Page Load approval";
        $rem = "approval status Set Unsuccessfully";

      }
    } else {
      $data = mysqli_fetch_assoc($sql_emp_code_temp);
      $sl_no = $data['sl_no'];

      $sql_update = mysqli_query($conn, "update `approval_sts` set `branch_id`='$ap_branch',`Approve_status`='$app_sts',`meet_end_status`='$meet_end_sts',`referral_status`='$referral_sts',`emailApproval` = '$emailApp', `camApprove`='$camApproval' where `sl_no` = '$sl_no'");
      if ($sql_update != "") {
        $_SESSION['icon'] = 'success';
        $_SESSION['status'] = 'Approval Status Update Successfully';
        $des = "Page Load approval";
        $rem = "approval status Update Successfully";
      } else {
        $_SESSION['icon'] = 'error';
        $_SESSION['status'] = 'Approval Status Not Update ';
        $des = "Page Load approval";
        $rem = "approval status Update Unsuccessfully";
      }
    }

  } else {
    $_SESSION['icon'] = 'error';
    $_SESSION['status'] = 'Insufficiant Data';
    $des = "Page Load approval";
    $rem = "approval status Set UNSuccessfully";
  }
  include '../include/_audi_log.php';
} else if (isset($_GET['did'])) {
  $delete_id = $_GET['did'];
  if ($delete_id != "") {
    $check_sql = mysqli_query($conn, "select * from `approval_sts` where `sl_no`= '$delete_id'");
    if (mysqli_num_rows($check_sql) >= 1) {
      $delete_sql = mysqli_query($conn, "delete from `approval_sts` where `sl_no`='$delete_id'");
      if ($delete_sql != "") {
        $_SESSION['icon'] = 'success';
        $_SESSION['status'] = 'Delete Status Successfull';
        $des = "Page Load approval";
        $rem = "approval status delete Successfully";

      } else {
        $_SESSION['icon'] = 'success';
        $_SESSION['status'] = 'Delete Status UnSuccessfull';
        $des = "Page Load approval";
        $rem = "approval status delete UnSuccessfully";
      }

    } else {
      $_SESSION['icon'] = 'error';
      $_SESSION['status'] = 'Data Not Found';
      $des = "Page Load approval";
      $rem = "approval status delete Successfully";
    }
  } else {
    $_SESSION['icon'] = 'error';
    $_SESSION['status'] = 'Insafficiant data';
    $des = "Page Load approval";
    $rem = "approval status delete Successfully";
  }
  include '../include/_audi_log.php';
}
if (isset($_POST['urlSet'])) {
  $url = $_POST['mailUrl'];
  if (!empty($url)) {
    // $insertUrl = mysqli_query($conn, "insert into `approval_sts` (url) values('$url')");
    $updateUrl = mysqli_query($conn, "update `approval_sts` set url ='$url'");
    if (!empty($insertUrl)) {
      $_SESSION['icon'] = 'success';
      $_SESSION['status'] = 'Url uploaded check it before use';
      $des = "Page Load approval";
      $rem = "approval status delete Successfully";
    }
  } else {
    $_SESSION['icon'] = 'error';
    $_SESSION['status'] = 'Insafficiant data';
    $des = "Page Load approval";
    $rem = "approval status delete Successfully";
  }
  include '../include/_audi_log.php';
}
if (isset($_GET['true'])) {
} else if (isset($_GET['false'])) {
  $content = file_get_contents('../Security/check_out1.php');
}


?>
<!DOCTYPE html>
<html lang="en">

<?php include "include/head.php"; ?>
<style>
select {
  max-height: 100%;
}

.col-sm-9 {
  height: 2.2rem;
}

.form-group {
  margin-bottom: 5px;
}

tbody td,
th {
  padding: 8px 20px;
}
</style>

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
                    <div class="card" style="margin-bottom:.3rem;">
                      <div class="card-header"
                        style="padding-bottom:8px;padding-top:8px;margin-bottom:1rem; margin-bottom:0px;">
                        <h5>Approval Status Details</h5>
                      </div>
                      <form action="" method="post" enctype="multipart/form-data">
                        <div class="row ">
                          <div class="col-md-6" style="max-width: 80%; flex: 0 0 40%;">
                            <div class="card-block table-border-style" style="padding-bottom:12px;">
                              <div class="form-group row">
                                <label class="col-sm-3 col-form-label" style="padding-right: 0;max-width:7.7rem;">Branch
                                  Name</label>
                                <div class="col-sm-9" style="max-width: 61%;">
                                  <select class="form-control" id="appBranch" name="branch_ap_id"
                                    style="    width: 23rem;margin-right: 1rem;" required>
                                    <option value="" selected disable hidden>Select
                                      Branch</option>
                                    <?php $sql_branch = mysqli_query($conn, "select *  from `branch`");
                                    while ($branch_details = mysqli_fetch_assoc($sql_branch)) { ?>
                                    <option value="<?php echo $branch_details['branch_code']; ?>">
                                      <?php echo $branch_details['branch_name']; ?>
                                    </option>
                                    <?php } ?>

                                  </select>
                                </div>
                              </div>
                              <div id="changeOne">

                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label"
                                    style="padding-right: 0;max-width:7.7rem;">Approval
                                    Status</label>
                                  <div class="col-sm-9" style="max-width: 61%;">
                                    <select class="form-control" id="mob" name="app_sts"
                                      style="width: 23rem;margin-right: 1rem;" required>
                                      <option value="" id="appSts" selected disable hidden>Select
                                        Approval Status</option>
                                      <option value="Activate">Activate</option>
                                      <option value="Deactivate">Deactivate</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label"
                                    style="padding-right: 0;max-width:7.7rem;">Camera
                                    Appr.</label>
                                  <div class="col-sm-9" style="max-width: 61%;">
                                    <select class="form-control" id="mob" name="camApp_sts"
                                      style="width: 23rem;margin-right: 1rem;" required>
                                      <option value="" id="camSts" selected disable hidden>Select Camera
                                        Approval Status</option>
                                      <option value="Activate">Activate</option>
                                      <option value="Deactivate">Deactivate</option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div id="changeTwo">
                            <div class="col-md-6" style="max-width: 100%; flex: 0 0 56%;">
                              <div class="card-block table-border-style">
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label"
                                    style="padding-right: 0;max-width:7.7rem;">Email
                                    Approval</label>
                                  <div class="col-sm-9" style="max-width: 61%;">
                                    <select class="form-control" name="emailApp"
                                      style="width: 23rem;margin-right: 1rem;" required>
                                      <option value="" id="emailSts" selected disable hidden>Select
                                        Email Approval Status</option>
                                      <option value="Activate">Activate</option>
                                      <option value="Deactivate">Deactivate</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-sm-3 col-form-label"
                                    style=" padding-right: 0;max-width:7.7rem;">Meet
                                    End & Ref.</label>
                                  <div class="col-sm-9" style="max-width: 61%;">
                                    <select class="form-control" name="end_sts" style="width: 23rem;margin-right: 1rem;"
                                      required>
                                      <option value="" id="reffSts" selected disable hidden>Select
                                        Meet & Referral Status</option>
                                      <option value="Activate">Activate</option>
                                      <option value="Deactivate">Deactivate</option>
                                    </select>
                                  </div>
                                </div>

                              </div>
                              <div class="form-group row">
                                <div class="col-sm-3" style="max-width: 61%;"></div>
                                <div class="col-sm-9" style="max-width: 70%;">
                                  <div class="user-entry">
                                    <button class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                      style="padding: 7px 20px; background-color:none;" name="set_app_sts"><i
                                        class="icofont icofont-settings-alt"
                                        style="    font-size: 20px;margin-right: 10px;"></i>Set</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </form>
                      <?php if ($dataExists > 0) { ?>
                      <div class="row ">
                        <div class="col-md-6" style="max-width: 80%; flex: 0 0 50%;">
                          <div class="card-block table-border-style">
                            <form action="" method="post" enctype="multipart/form-data">
                              <div class="form-group row">
                                <label class="col-sm-3 col-form-label" style="padding-right: 0;max-width:7.7rem;">Enter
                                  Url</label>
                                <div class="col-sm-9" style="max-width: 50%;">
                                  <input type="text" class="form-control" name="mailUrl" placeholder="Enter the url"
                                    required>

                                </div>
                                <button class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                  style="padding: 2px 15px; background-color:none;" name="urlSet"><i
                                    class="icofont icofont-settings-alt"
                                    style="    font-size: 20px;margin-right: 10px;"></i>Set Url</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                      <?php } ?>
                    </div>
                    <div class="card">
                      <div class="card-block table-border-style">
                        <div class="table-responsive table-short" style="height:115px;">
                          <table class="table">
                            <thead>
                              <tr>
                                <th style="width: 5rem;padding: 2px 10px">Sl No.</th>
                                <th style="padding: 2px 10px">Branch Name</th>
                                <th style="padding: 2px 10px">Approval Status</th>
                                <th style="padding: 2px 10px">Cam Appr. Status</th>
                                <th style="padding: 2px 10px">Email Approval</th>
                                <th style="padding: 2px 10px">Meeing End Status</th>
                                <th style="padding: 2px 10px">Referral Status</th>
                                <th style="padding: 2px 10px">Url</th>

                                <th style=" padding: 2px 10px;">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $i = 0;
                              $sql_app_sts = mysqli_query($conn, "select * from `approval_sts`");
                              while ($Approve_data = mysqli_fetch_assoc($sql_app_sts)) {
                                $i++;
                                $Branch_name = "";
                                $barnch = $Approve_data['branch_id'];
                                $sql_branch = mysqli_fetch_assoc(mysqli_query($conn, "select *  from `branch` where `branch_code`= '$barnch'"));
                                if ($sql_branch != "") {
                                  $comp_name = $sql_branch['branch_name'];
                                }

                                ?>
                              <tr>
                                <th style="padding:5px;" scope="row"><?php echo $i; ?></th>
                                <td style="padding:5px;"><?php echo ucfirst($comp_name); ?></td>
                                <td style="padding:5px;"><?php echo ucfirst($Approve_data['Approve_status']); ?>
                                <td style="padding:5px;"><?php echo ucfirst($Approve_data['camApprove']); ?>
                                </td>
                                <td style="padding:5px;"><?php echo ucfirst($Approve_data['emailApproval']); ?>
                                </td>
                                <td style="padding:5px;"><?php echo ucfirst($Approve_data['meet_end_status']); ?>
                                </td>
                                <td style="padding:5px;"><?php echo ucfirst($Approve_data['referral_status']); ?>
                                <td style="padding:5px;"><?php echo $Approve_data['url']; ?>
                                </td>
                                <td style="padding:5px;" class="th_width">
                                  <a href="approval? did=<?php echo $Approve_data['sl_no']; ?> " class="delt_href">
                                    <button class="btn waves-effect waves-light btn-danger btn-outline-danger"
                                      style="padding:5px 20px"><i class="icofont icofont-delete-alt"></i>Delete</button>
                                  </a>
                                </td>
                                <!-- <td class="th_width">
                                                                    <form action="" method="get">
                                                                        <?php if ($log_out_time_sts == False) { ?>
                                                                            <button class="btn waves-effect waves-light btn-success btn-outline-success" name="true"><i class="fa fa-smile-o" aria-hidden="true" style="font-size:1.3rem; font-weight:900;"></i>Log Out Timing</button>
                                                                        <?php } else { ?>
                                                                            <button class="btn waves-effect waves-light btn-danger btn-outline-danger" name="false"><i class="fa fa-frown-o" aria-hidden="true" style="font-size:1.3rem; font-weight:900;"></i>Log Out Timing</button>
                                                                        <?php } ?>

                                                                    </form>
                                                                </td> -->

                              </tr>
                              <?php } ?>
                            </tbody>
                          </table>
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


  <!-- Required Jquery -->
  <?php include "include/footer.php"; ?>
</body>

</html>
<script>
$("#mob").keyup(function() {
  $("#emp_name").val('');
  $("#com").val('');
  $("#dept").val('');
  $("#bran").val('');
})
$("#emp_name").keyup(function() {
  $("#mob").val('');
  $("#com").val('');
  $("#dept").val('');
  $("#bran").val('');
})
$("#com , #dept, #bran").change(function() {
  $("#mob").val('');
  $("#emp_name").val('');

})

$('.delt_href').on('click', function(e) {
  e.preventDefault();
  // console.log(e);
  var href = $(this).attr('href')
  console.log(href)

  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.value) {
      console.log(result.value);
      document.location.href = href;

    } else {

    }
  })

})
</script>