<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$head = "Visitor Info";
$des = "Page Load new_visitor_final";
$rem = "New visitor";
include '../include/_audi_log.php';

$visitor_log_id = "";
$visitor_data = "";
$gvt_id_type = "";
$gvt_id_no = "";
$name = "";
$company = "";
$desig = "";
$add = "";
$gmail = "";
$cont = "";
$id_no = "";
$visit_id = "";
$arr_time = "";
$arr_date = "";
$gate_no = "";
$arr_status = "";
$visit_purpose = "";
$meterial = "";
$visitor_type = "";
$emp_code = "";
$employee_name = "";
$employee_com = "";
$employee_depart = "";
$contact_no = "";
$vehical_type = "";
$vehical_no = "";
$issud_id_no = "";
$v_log_id = "";
$v_in_date = "";
$sequri_sts = "Approve";
$approval_sts = "Panding";
$co_id = "";
$dept_id = "";
$designation = "";
$e = false;
if (isset($_POST['img_submit'])) {
  $e = true;
  $v_log_id = $_POST['uid'];
  $folderPath = "../upload_temp/";
  $file_name = $folderPath . $v_log_id . ".png";

  if (!file_exists($file_name)) {
    if ($Approval['Camera'] != "" && $Approval['Camera'] != null) {
      if ($Approval['Camera'] == 'Activate') {
        $img = $_POST['image'];
        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $v_log_id . '.png';

        $file = $folderPath . $fileName;
        file_put_contents($file, $image_base64);

      } else {
        if ($_FILES['image']['name'] != "") {
          $fileNameParts = explode('.', $_FILES['image']['name']);
          $fileExtension = end($fileNameParts);

          if (in_array($fileExtension, array('jpg', 'jpeg', 'png'))) {
            if ($_FILES['image']['size'] <= (500 * 1024)) {
              $name = $v_log_id . '.png';
              $file = $folderPath . $name;
              move_uploaded_file($_FILES['image']['tmp_name'], $file);

            } else {
              echo $_FILES['image']['size'];
              $_SESSION['icon'] = 'warning';
              $_SESSION['status'] = 'Image Size within 500kb';
              header("location:new_visitor1");
            }
          } else {
            $_SESSION['icon'] = 'warning';
            $_SESSION['status'] = 'Uploded file should be jpeg or PNG';
            header("location:new_visitor1");
          }

        } else {
          $_SESSION['icon'] = 'warning';
          $_SESSION['status'] = 'Image not Selected ';
          header("location:new_visitor1");
        }
      }
    } else {
      $_SESSION['icon'] = 'info';
      $_SESSION['status'] = 'Image upload permission denied';
      header("location:new_visitor1");
    }
  }


  $visit_id = $_POST['visit_id'];
  $v_info = $_POST["visit"];
  $emp_details = $v_info[0];
  $full1 = explode(' ', $emp_details);
  $emp_code = $full1[0];
  $sql_emp_data = mysqli_fetch_assoc(mysqli_query($conn, "select * from `eomploye_details` where `Emp_code`='$emp_code'"));
  if ($sql_emp_data != "") {
    $employee_name = $sql_emp_data['EmployeeName'];
    $dept_id = $sql_emp_data['DepartmentId'];
    $sql_dept = mysqli_fetch_assoc(mysqli_query($conn, "select * from `department` where `department_code`='$dept_id'"));
    if ($sql_dept != "") {
      $employee_depart = $sql_dept['department_name'];
    }
    $co_id = $sql_emp_data['CompanyId'];
    $sql_co = mysqli_fetch_assoc(mysqli_query($conn, "select * from `company_details` where`company_id` ='$co_id'"));
    if ($sql_co != "") {
      $employee_com = $sql_co['companyFname'];
    }
    $contact_no = $sql_emp_data['ContactNo'];
    $designation = $sql_emp_data['DesignationId'];

    $v_desig_sql = mysqli_fetch_assoc(mysqli_query($conn, "select * from `designation` where `designation_code`='$designation'"));
    if ($v_desig_sql != "") {
      $designation = $v_desig_sql['designation'];
    } else {
      $designation = "";
    }

  }

  $arr_status = $v_info[1];
  $arr_time = $v_info[2];
  $arr_time_db = date("H:i:s", strtotime($arr_time));
  $arr_date = date("Y-m-d");
  $v_in_date = date("d-M-Y");
  $gate_no = $v_info[3];
  $visit_pur_id = $v_info[4];
  $visito_purpse_sql = mysqli_fetch_assoc(mysqli_query($conn, "select * from `visit_purpose` where `purpose_id` = '$visit_pur_id'"));
  if ($visito_purpse_sql != "") {
    $visit_purpose = $visito_purpse_sql['purpose'];
  }
  $v_govt_id = $v_info[6];
  $name = $v_info[7];
  $company = $v_info[8];
  $desig = $v_info[9];
  $add = $v_info[10];
  $gmail = $v_info[11];
  $cont = $v_info[12];
  $issud_id_no = $v_info[13];
  $visitor_type_id = $v_info[14];
  $visit_type_sql = mysqli_fetch_assoc(mysqli_query($conn, "select * from `vsitor_type` where `type_id` = '$visitor_type_id' "));
  if ($visit_type_sql != "") {
    $visitor_type = $visit_type_sql['type_name'];
  }
  $meterial = $v_info[15];
  $vehical_type = $v_info[16];
  if ($vehical_type != "" && $vehical_type != "NO" && $vehical_type != "Cycle") {
    $vehical_no = $v_info[17];
  }
  $user_id = $_SESSION['user_id'];
  $v_emp_code = $emp_code;
  include '../include/_approval.php';
  $emp_visit_status = $emp_status;
  if ($sequri_sts == "Approve" && $emp_visit_status == "Approve") {
    $approval_sts = "Approve";
  }
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

                  <!-- Page body start -->
                  <div class="page-body">


                    <div class="card" style="margin-bottom:0px;">
                      <div class="card-header" style="    padding: 0.5rem 1px 0.5rem 1.4rem;">
                        <div class="row" style="height:1.5rem;">
                          <div class="col-md-3" style="flex:0 0 25%; max-width:40%;">
                            <h5> Visitor Info :- <?php $v_id = explode("-", $v_log_id);
                            echo $v_id[1]; ?> </h5>

                          </div>
                          <div class="col-md-3" style="flex:0 0 25%; max-width:40%;">
                            <h5> Arrival Date :- <?php echo $v_in_date; ?></h5>

                          </div>
                          <div class="col-md-3" style="flex:0 0 22%; max-width:40%;">
                            <h5> Arrival Time :- <?php echo $arr_time; ?> </h5>

                          </div>
                          <div class="col-md-3" style="flex:0 0 25%; max-width:40%;">
                            <h5> Approval Sts.: - <?php echo $approval_sts; ?></h5>

                          </div>

                        </div>
                      </div>

                      <section class="animate pop">
                        <div class="container" style="padding:1rem;">
                          <div class="admit-card">
                            <div class="BoxD mar-bot">
                              <div class="row">
                                <div class="col-sm-10" style=" max-width: 100%; flex: 0 0 100%;">
                                  <table class="table" style="margin-bottom:0px">
                                    <tbody>
                                      <tr>
                                        <td colspan="3"
                                          style="font-size:19px; padding:0rem;font-family: 'Aboreto', cursive;font-weight:700;border-bottom:2px solid #000;text-align:left;font-family: 'El Messiri', sans-serif; font-style:italic;">
                                          Visitor Info</td>
                                      </tr>
                                      <tr>
                                        <td id="tb"
                                          style="padding:0;padding-left: 1rem; height:2rem;text-align:left; width:45%;">
                                          <b>Visitor Name:- &nbsp;</b><?php echo $name; ?>
                                        </td>
                                        <td style="padding:0; height:2rem;text-align:left;"><b>Govt. Id:-
                                            &nbsp;</b><?php echo $v_govt_id; ?> </td>
                                        <th rowspan="4" scope="row txt-center" style="width:8rem;"><img
                                            src="../upload_temp/<?php echo $v_log_id; ?>.png" width="123px"
                                            height="120px" onerror="this.src='../src/error.png'" /></th>

                                      </tr>
                                      <tr>
                                        <td id="tb"
                                          style="padding:0;padding-left: 1rem; height:2rem;text-align:left; width:45%;">
                                          <b>Comopany:- &nbsp;</b><?php echo $company; ?>
                                        </td>
                                        <td style="padding:0; height:2rem;text-align:left;"><b>Mobile No :-
                                            &nbsp;</b><?php echo $cont; ?></td>

                                      </tr>
                                      <tr>
                                        <td id="tb"
                                          style="padding:0;padding-left: 1rem; height:2rem;text-align:left; width:45%;">
                                          <b>Designation:- &nbsp;</b><?php echo $desig; ?>
                                        </td>
                                        <td style="padding:0; height:2rem;text-align:left;"><b>Email:-
                                            &nbsp;</b><?php echo $gmail; ?></td>

                                      </tr>
                                      <tr>
                                        <td id="tb"
                                          style="padding:0;padding-left: 1rem; height:2rem;text-align:left; width:45%;">
                                          <b>Address:- &nbsp;</b><?php echo $add; ?>
                                        </td>
                                        <td style="padding:0; height:2rem;text-align:left;"><b>Issued Id No:-
                                            &nbsp;</b><?php echo $issud_id_no; ?></td>

                                      </tr>
                                      <tr>
                                        <td id="tb"
                                          style="padding:0;padding-left: 1rem; height:2rem;text-align:left; width:45%;">
                                          <b>Visitor Type:- &nbsp;</b><?php echo $visitor_type; ?>
                                        </td>
                                        <td style="padding:0; height:2rem;text-align:left;"><b>Purpose:
                                            &nbsp;</b><?php echo $visit_purpose; ?></td>
                                        <td style="padding:0; height:2rem;text-align:left;"><b>Gate No:-
                                            &nbsp;</b><?php echo $gate_no; ?></td>
                                      </tr>
                                      <tr>
                                        <td id="tb"
                                          style="padding:0;padding-left: 1rem; height:2rem;text-align:left; width:45%;">
                                          <b>Mterials Carried:- &nbsp;</b><span
                                            style="word-break: break-all;"><?php echo $meterial; ?></span>
                                        </td>
                                        <td style="padding:0; height:2rem;text-align:left;"><b>Vehicle Type(With No):
                                            &nbsp;</b><?php echo $vehical_type; ?></td>
                                        <td style="padding:0; height:2rem;text-align:left;"><?php echo $vehical_no; ?>
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-sm-10" style="max-width: 100%; flex: 0 0 100%;">
                                <table class="table" style="margin:0px;">
                                  <tbody>
                                    <tr>
                                      <td colspan="2"
                                        style="font-size:19px; padding:0rem;font-family: 'Aboreto', cursive;font-weight:700;border-bottom:2px solid #000;text-align:left;font-family: 'El Messiri', sans-serif; font-style:italic;">
                                        TO Meet</td>
                                    </tr>
                                    <tr>
                                      <td id="tb" style="padding:0;padding-left: 1rem; height:2rem;text-align:left;">
                                        <b>Employe Code:- &nbsp;</b><?php echo $emp_code; ?>
                                      </td>
                                      <td style="padding:0; height:2rem;text-align:left;"><b>Employe Name:-
                                          &nbsp;</b><?php echo $employee_name; ?></td>
                                      <!-- <td><b>DOB: </b>02 Jul 2019</td> -->
                                    </tr>
                                    <tr>
                                      <td id="tb" style="padding:0;padding-left: 1rem; height:2rem;text-align:left;">
                                        <b>Department:- &nbsp;</b><?php echo $employee_depart; ?>
                                      </td>
                                      <td style="padding:0; height:2rem;text-align:left;"><b>Designation:-
                                          &nbsp;</b><?php echo $designation; ?></td>
                                      <!-- <td><b>DOB: </b>02 Jul 2019</td> -->
                                    </tr>
                                  </tbody>
                                </table>
                              </div>

                            </div>
                          </div>
                        </div>
                      </section>

                      <div class="card-block " style=" padding-top:0;">
                        <div class="user-entry"
                          style="margin-right: 1.3rem; display:flex; width:30rem;     justify-content: end;">
                          <form action="new_visit_process" method="post">
                            <?php
                            if ($e == true) {

                              foreach ($v_info as $id => $value) { ?>
                            <input type="hidden" name="visit[]" value="<?php echo $value; ?>">
                            <?php
                              }
                            }
                            ?>
                            <input type="hidden" name="visit_id" value="<?php echo $visit_id; ?>" />
                            <input type="hidden" name="uid" value="<?php echo $v_log_id; ?>" />

                            <a href="new_visitor1"><button type="button"
                                class="btn waves-effect waves-light btn-inverse btn-outline-inverse"><i
                                  class="icofont icofont-exchange"></i>Cancel</button></a>
                            <button type="submit" class="btn waves-effect waves-light btn-primary btn-outline-primary"
                              name="final_dubmit" style="margin-left:1rem;"><i class="fa fa-arrow-right"
                                style="    font-size: 20px;margin-right: 10px;"></i>Save & Next</button>
                          </form>

                        </div>
                      </div>



                      </form>
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