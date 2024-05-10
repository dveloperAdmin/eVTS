<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$des = "Page Load New Employe";
$rem = "New Employe";
$head = "Employe Info";
include '../include/_audi_log.php';


// sql for fectching data from others table
$company_details_sql = mysqli_query($conn, "select * from `company_details`");
if (in_array($user_role, array("Developer", "Super Admin"))) {
    $branch_details_sql = mysqli_query($conn, "select * from `branch`");

} else {

    $branch_details_sql = mysqli_query($conn, "select * from `branch`where `branch_code`= '$branch_id'");
}
$department_details_sql = mysqli_query($conn, "select * from `department`");
$subdepartment_details_sql = mysqli_query($conn, "select * from `subdepartment`");
$designation_details_sql = mysqli_query($conn, "select * from `designation`");
$location_details_sql = mysqli_query($conn, "select * from `location`");
$employetype_details_sql = mysqli_query($conn, "select * from `employetype`");
$empcategory_details_sql = mysqli_query($conn, "select * from `empcategory`");
$grade_details_sql = mysqli_query($conn, "select * from `grade`");
$view = false;
$e = false;
$emp_code250 = "";
if (isset($_POST['emp_edit'])) {
    $e_id = $_POST['emp_id'];

    // echo $e_id;
    if (isset($_POST['view'])) {
        $view = $_POST['view'];
    }
    $e = true;
    $sql_emp_data = mysqli_fetch_assoc(mysqli_query($conn, "select * from `eomploye_details` where `EmployeeId`='$e_id'"));

    $emp_code = $sql_emp_data['Emp_code'];
    $emp_code250 = $emp_code;
    $emp_name = $sql_emp_data['EmployeeName'];
    $emp_co_id = $sql_emp_data['CompanyId'];
    $emp_branch_id = $sql_emp_data['BranchId'];
    $emp_dept_id = $sql_emp_data['DepartmentId'];
    $emp_subdept_id = $sql_emp_data['Sub_DepartmentId'];
    $emp_desig_id = $sql_emp_data['DesignationId'];
    $emp_grade_id = $sql_emp_data['GradeId'];
    $emp_location = $sql_emp_data['Location'];
    $emp_emptype = $sql_emp_data['EmployeType'];
    $emp_empcat_id = $sql_emp_data['CategoryId'];
    $emp_mob = $sql_emp_data['ContactNo'];
    $emp_email = $sql_emp_data['email_id'];
    $emp_sts = $sql_emp_data['Status'];
    $sd_name = "";
    $ds_name = "";
    $g_name = "";
    $cat_name = "";
    $co_name = "";
    $b_name = "";
    $d_name = "";
    if ($emp_co_id != "") {
        $chek_co_details = mysqli_fetch_assoc(mysqli_query($conn, "select * from `company_details` where `company_id`='$emp_co_id'"));
        if ($chek_co_details != "") {
            $co_name = $chek_co_details['companyFname'];

        }

    }
    if ($emp_branch_id != "") {
        $chek_b_details = mysqli_fetch_assoc(mysqli_query($conn, "select * from `branch` where `branch_code`='$emp_branch_id '"));
        if ($chek_b_details != "") {
            $b_name = $chek_b_details['branch_name'];
        }
    }
    if ($emp_dept_id != "") {
        $chek_d_details = mysqli_fetch_assoc(mysqli_query($conn, "select * from `department` where `department_code`='$emp_dept_id'"));
        if ($chek_d_details != "") {
            $d_name = $chek_d_details['department_name'];

        }

    }

    if ($emp_subdept_id != "") {
        $chek_sd_details = mysqli_fetch_assoc(mysqli_query($conn, "select * from `subdepartment` where `subdepartment_code`='$emp_subdept_id'"));
        if ($chek_sd_details != "") {
            $sd_name = $chek_sd_details['subdepartment_name'];

        }

    }
    if ($emp_desig_id != "") {
        $chek_ds_details = mysqli_fetch_assoc(mysqli_query($conn, "select * from `designation` where `designation_code`='$emp_desig_id'"));
        if ($chek_ds_details != "") {
            $ds_name = $chek_ds_details['designation'];

        }

    }
    if ($emp_grade_id != "") {
        // echo $emp_grade_id;
        $chek_g_details = mysqli_fetch_assoc(mysqli_query($conn, "select * from `grade` where `grade_code`='$emp_grade_id'"));
        if ($chek_g_details != "") {
            $g_name = $chek_g_details['grade'];

        }

    }
    if ($emp_empcat_id != "") {
        $chek_cat_details = mysqli_fetch_assoc(mysqli_query($conn, "select * from `empcategory` where `empcat_code`='$emp_empcat_id'"));
        if ($chek_cat_details != "") {
            $cat_name = $chek_cat_details['empcat'];

        }

    }
    // if($emp_subdept_id!=""){
    //     $chek_sd_details = mysqli_fetch_assoc(mysqli_query($conn,"select * from `subdepartment` where `subdepartment_code`='$emp_subdept_id'"));
    //     $sd_name = $chek_sd_details['subdepartment_name'];

    // }
    // $chek_co_details = mysqli_fetch_assoc(mysqli_query($conn,"select * from `company_details` where `company_id`='$emp_co_id'"));
    // $co_name = $chek_co_details['companyFname'];
    // $chek_co_details = mysqli_fetch_assoc(mysqli_query($conn,"select * from `company_details` where `company_id`='$emp_co_id'"));
    // $co_name = $chek_co_details['companyFname'];
    // $chek_co_details = mysqli_fetch_assoc(mysqli_query($conn,"select * from `company_details` where `company_id`='$emp_co_id'"));
    // $co_name = $chek_co_details['companyFname'];
    // $chek_co_details = mysqli_fetch_assoc(mysqli_query($conn,"select * from `company_details` where `company_id`='$emp_co_id'"));
    // $co_name = $chek_co_details['companyFname'];


}








?>
<!DOCTYPE html>
<html lang="en">

<?php include "include/head.php"; ?>
<style>
.form-group {
  margin-bottom: .1rem;
}

input,
select {
  margin-bottom: .5rem;
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
                    <?php if ($e != true) { ?>
                    <div class="card">
                      <div class="card-header" style="    padding: 12px 20px">
                        <h5>Add Employee Details</h5>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <!-- <div class="card"> -->
                          <div class="card-block">
                            <form action="emp_process" method="post">
                              <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Empolyee Code
                                  <span style="color:red"> *</span></label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" placeholder="Enter Empolyee Code "
                                    name="emp_code" required autofocus>
                                </div>
                              </div>

                              <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Employee Name
                                  <span style="color:red"> *</span></label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" placeholder="Enter Employee Name "
                                    name="emp_name" required>
                                </div>
                              </div>
                              <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Company Name
                                  <span style="color:red"> *</span></label>
                                <div class="col-sm-9">
                                  <select name="emp_co_name" id="" class="form-control fill" style="height: 2.3rem;"
                                    required>
                                    <option value="" disabled selected hidden>Select
                                      Company Name </option>
                                    <?php while ($company = mysqli_fetch_assoc($company_details_sql)) { ?>
                                    <option value="<?php echo $company['company_id']; ?>">
                                      <?php echo $company['companyFname']; ?>
                                    </option>
                                    <?php } ?>
                                  </select>

                                </div>
                              </div>
                              <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Branch <span style="color:red"> *</span></label>
                                <div class="col-sm-9">
                                  <select name="emp_branch" id="" class="form-control fill" style="height: 2.3rem;"
                                    required>
                                    <option value="" disabled selected hidden>Select
                                      Branch </option>
                                    <?php while ($branch = mysqli_fetch_assoc($branch_details_sql)) { ?>
                                    <option value="<?php echo $branch['branch_code']; ?>">
                                      <?php echo $branch['branch_name']; ?>
                                    </option>
                                    <?php } ?>
                                  </select>

                                </div>

                              </div>
                              <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Department <span style="color:red">
                                    *</span></label>
                                <div class="col-sm-9">
                                  <select name="emp_dept" id="" class="form-control fill" style="height: 2.3rem;"
                                    required>
                                    <option value="" disabled selected hidden>Select
                                      Department </option>
                                    <?php while ($department = mysqli_fetch_assoc($department_details_sql)) { ?>
                                    <option value="<?php echo $department['department_code']; ?>">
                                      <?php echo $department['department_name']; ?>
                                    </option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                              <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Sub-Department</label>
                                <div class="col-sm-9">
                                  <select name="emp_subdept" id="" class="form-control fill" style="height: 2.3rem;">
                                    <option value="" disabled selected hidden>Select
                                      Sub-Department </option>
                                    <?php while ($subdepartment = mysqli_fetch_assoc($subdepartment_details_sql)) { ?>
                                    <option value="<?php echo $subdepartment['subdepartment_code']; ?>">
                                      <?php echo $subdepartment['subdepartment_name']; ?>
                                    </option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                              <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Designation</label>
                                <div class="col-sm-9">
                                  <select name="emp_Desig" id="" class="form-control fill" style="height: 2.3rem;"
                                    name="emp_Desig">
                                    <option value="" disabled selected hidden>Select
                                      Designation </option>
                                    <?php while ($designation = mysqli_fetch_assoc($designation_details_sql)) { ?>
                                    <option value="<?php echo $designation['designation_code']; ?>">
                                      <?php echo $designation['designation']; ?>
                                    </option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>

                          </div>
                        </div>
                        <div class="col-md-6">
                          <!-- <div class="card"> -->

                          <div class="card-block">

                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Grade</label>
                              <div class="col-sm-9">
                                <select name="emp_grade" id="" class="form-control fill" style="height: 2.3rem;">
                                  <option value="" disabled selected hidden>Select
                                    Grade </option>
                                  <?php while ($grade = mysqli_fetch_assoc($grade_details_sql)) { ?>
                                  <option value="<?php echo $grade['grade_code']; ?>">
                                    <?php echo $grade['grade']; ?>
                                  </option>
                                  <?php } ?>
                                </select>

                              </div>

                            </div>

                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Location</label>
                              <div class="col-sm-9">
                                <select name="emp_loc" id="" class="form-control fill" style="height: 2.3rem;">
                                  <option value="" disabled selected hidden>Select
                                    Location </option>
                                  <?php while ($location = mysqli_fetch_assoc($location_details_sql)) { ?>
                                  <option value="<?php echo $location['location']; ?>">
                                    <?php echo $location['location']; ?>
                                  </option>
                                  <?php } ?>
                                </select>
                              </div>

                            </div>
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Employe Type</label>
                              <div class="col-sm-9">
                                <select name="emp_type" id="" class="form-control fill" style="height: 2.3rem;">
                                  <option value="" disabled selected hidden>Select
                                    Employe Type </option>
                                  <?php while ($emptype = mysqli_fetch_assoc($employetype_details_sql)) { ?>
                                  <option value="<?php echo $emptype['emptype']; ?>">
                                    <?php echo $emptype['emptype']; ?>
                                  </option>
                                  <?php } ?>
                                </select>
                              </div>

                            </div>
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Employe
                                Category</label>
                              <div class="col-sm-9">
                                <select name="emp_cat" id="" class="form-control fill" style="height: 2.3rem;">
                                  <option value="" disabled selected hidden>Select
                                    Employe Category </option>
                                  <?php while ($empcat = mysqli_fetch_assoc($empcategory_details_sql)) { ?>
                                  <option value="<?php echo $empcat['empcat_code']; ?>">
                                    <?php echo $empcat['empcat']; ?>
                                  </option>
                                  <?php } ?>
                                </select>
                              </div>

                            </div>
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Email Id <span style="color:red"> *</span></label>
                              <div class="col-sm-9">
                                <input type="email" class="form-control" placeholder="Enter Employe Email id"
                                  name="emp_email" required>
                              </div>

                            </div>
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Contact No <span style="color:red">
                                  *</span></label>
                              <div class="col-sm-9">
                                <input type="text" class="form-control" placeholder="Enter Employe Contact no"
                                  name="emp_mob" maxlength="10" required>
                              </div>

                            </div>
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Employe Status <span style="color:red">
                                  *</span></label>
                              <div class="col-sm-9">
                                <select name="emp_sts" id="" class="form-control fill" style="height: 2.3rem;">
                                  <option value="" disabled selected hidden>Select
                                    Employe Status </option>
                                  <option value="Working">Working </option>
                                  <option value="Resign">Resign </option>
                                </select>
                              </div>

                            </div>

                            <div class="form-group row user-entry" style="    margin-right: 0rem;">


                              <button type="reset"
                                class="btn waves-effect waves-light btn-inverse btn-outline-inverse"><i
                                  class="icofont icofont-exchange"></i>Cancel</button>
                              <button type="submit" class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                name="user_submit" style="margin-left:10px"><i class="fa fa-user-plus"
                                  style="    font-size: 20px;margin-right: 10px;"></i>Add
                                Employe</button>

                            </div>
                            </form>
                          </div>
                        </div>

                      </div>
                    </div>


                    <?php }
                                        if ($e == true) {
                                            ?>



                    <div class="card">
                      <div class="card-header" style="    padding: 12px 20px">
                        <h5 style="width:91%">
                          <?php
                                                        if ($view == false) {
                                                            echo "Edit Employee Details";
                                                        } else {
                                                            echo "View Employee Details";
                                                        }
                                                        ?>
                        </h5>
                        <a href="employe-view">
                          <button class="btn waves-effect waves-light btn-inverse btn-outline-inverse"
                            style="padding:3.5px 13px;"><i class="fa fa-arrow-right"></i>Back</button>

                        </a>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <!-- <div class="card"> -->
                          <div class="card-block">
                            <form action="emp_process" method="post" id="view_form">
                              <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Empolyee Code
                                </label>
                                <div class="col-sm-9">

                                  <label class="form-control"><?php echo $emp_code250; ?></label>

                                </div>
                              </div>
                              <input type="hidden" name="edit_id" value="<?php echo $e_id; ?>">
                              <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Employee Name
                                  <span style="color:red"> *</span></label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" placeholder="Enter Employee Name "
                                    name="uemp_name" required value="<?php echo $emp_name; ?>" id="emp_name_id">
                                </div>
                              </div>
                              <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Company Name
                                  <span style="color:red"> *</span></label>
                                <div class="col-sm-9">
                                  <select name="uemp_co_name" id="com_name" class="form-control fill"
                                    style="height: 2.3rem;" value="<?php echo $sql_emp_data['']; ?>" required>
                                    <option value="<?php echo $emp_co_id; ?>" selected><?php echo $co_name; ?></option>
                                    <?php while ($company = mysqli_fetch_assoc($company_details_sql)) { ?>
                                    <option value="<?php echo $company['company_id']; ?>">
                                      <?php echo $company['companyFname']; ?>
                                    </option>
                                    <?php } ?>
                                  </select>

                                </div>
                              </div>
                              <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Branch <span style="color:red"> *</span></label>
                                <div class="col-sm-9">
                                  <select name="uemp_branch" id="Branch_name" class="form-control fill"
                                    style="height: 2.3rem;" required>
                                    <option value="<?php echo $emp_branch_id; ?>" selected><?php echo $b_name; ?>
                                    </option>

                                    <?php while ($branch = mysqli_fetch_assoc($branch_details_sql)) { ?>
                                    <option value="<?php echo $branch['branch_code']; ?>">
                                      <?php echo $branch['branch_name']; ?>
                                    </option>
                                    <?php } ?>
                                  </select>

                                </div>

                              </div>
                              <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Department <span style="color:red">
                                    *</span></label>
                                <div class="col-sm-9">
                                  <select name="uemp_dept" id="dept_name" class="form-control fill"
                                    style="height: 2.3rem;" required>
                                    <option value="<?php echo $emp_dept_id; ?>" selected><?php echo $d_name; ?></option>
                                    <?php while ($department = mysqli_fetch_assoc($department_details_sql)) { ?>
                                    <option value="<?php echo $department['department_code']; ?>">
                                      <?php echo $department['department_name']; ?>
                                    </option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                              <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Sub-Department</label>
                                <div class="col-sm-9">
                                  <select name="uemp_subdept" id="sub_dept_name" class="form-control fill"
                                    style="height: 2.3rem;">
                                    <option value="<?php echo $emp_subdept_id; ?>" selected><?php echo $sd_name; ?>
                                    </option>
                                    <?php while ($subdepartment = mysqli_fetch_assoc($subdepartment_details_sql)) { ?>
                                    <option value="<?php echo $subdepartment['subdepartment_code']; ?>">
                                      <?php echo $subdepartment['subdepartment_name']; ?>
                                    </option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>
                              <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Designation</label>
                                <div class="col-sm-9">
                                  <select name="uemp_Desig" id="desig_name" class="form-control fill"
                                    style="height: 2.3rem;">
                                    <option value="<?php echo $emp_desig_id; ?>" selected><?php echo $ds_name; ?>
                                    </option>
                                    <?php while ($designation = mysqli_fetch_assoc($designation_details_sql)) { ?>
                                    <option value="<?php echo $designation['designation_code']; ?>">
                                      <?php echo $designation['designation']; ?>
                                    </option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>

                          </div>
                        </div>
                        <div class="col-md-6">
                          <!-- <div class="card"> -->

                          <div class="card-block">

                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Grade</label>
                              <div class="col-sm-9">
                                <select name="uemp_grade" id="grade_name" class="form-control fill"
                                  style="height: 2.3rem;">
                                  <option value="<?php echo $emp_grade_id; ?>" selected><?php echo $g_name; ?></option>
                                  <?php while ($grade = mysqli_fetch_assoc($grade_details_sql)) { ?>
                                  <option value="<?php echo $grade['grade_code']; ?>">
                                    <?php echo $grade['grade']; ?>
                                  </option>
                                  <?php } ?>
                                </select>

                              </div>

                            </div>

                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Location </label>
                              <div class="col-sm-9">
                                <select name="uemp_loc" id="loaction_name" class="form-control fill"
                                  style="height: 2.3rem;">
                                  <option value="<?php echo $emp_location; ?>" selected><?php echo $emp_location; ?>
                                  </option>
                                  <?php while ($location = mysqli_fetch_assoc($location_details_sql)) { ?>
                                  <option value="<?php echo $location['location']; ?>">
                                    <?php echo $location['location']; ?>
                                  </option>
                                  <?php } ?>
                                </select>
                              </div>

                            </div>
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Employe Type</label>
                              <div class="col-sm-9">
                                <select name="uemp_type" id="Emp_type_name" class="form-control fill"
                                  style="height: 2.3rem;">
                                  <option value="<?php echo $emp_emptype; ?>" selected>
                                    <?php echo $emp_emptype; ?>
                                  </option>
                                  <?php while ($emptype = mysqli_fetch_assoc($employetype_details_sql)) { ?>
                                  <option value="<?php echo $emptype['emptype']; ?>">
                                    <?php echo $emptype['emptype']; ?>
                                  </option>
                                  <?php } ?>
                                </select>
                              </div>

                            </div>
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Employe
                                Category</label>
                              <div class="col-sm-9">
                                <select name="uemp_cat" id="emp_cat_name" class="form-control fill"
                                  style="height: 2.3rem;">
                                  <option value="<?php echo $emp_empcat_id; ?>" selected><?php echo $cat_name; ?>
                                  </option>
                                  <?php while ($empcat = mysqli_fetch_assoc($empcategory_details_sql)) { ?>
                                  <option value="<?php echo $empcat['empcat_code']; ?>">
                                    <?php echo $empcat['empcat']; ?>
                                  </option>
                                  <?php } ?>
                                </select>
                              </div>

                            </div>
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Email Id <span style="color:red"> *</span></label>
                              <div class="col-sm-9">
                                <input type="email" class="form-control" placeholder="Enter Employe Email id"
                                  name="emp_email" required value="<?php echo $emp_email; ?>" id="emp_email_id">
                              </div>

                            </div>
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Contact No <span style="color:red">
                                  *</span></label>
                              <div class="col-sm-9">
                                <input type="text" class="form-control" placeholder="Enter Employe Contact no"
                                  name="uemp_mob" required value="<?php echo $emp_mob; ?>" maxlength="10" id="cont_num">
                              </div>

                            </div>
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">Employe Status <span style="color:red">
                                  *</span></label>
                              <div class="col-sm-9">
                                <select name="uemp_sts" id="emp_sts" class="form-control fill" style="height: 2.3rem;"
                                  required>
                                  <option value="<?php echo $emp_sts; ?>" selected>
                                    <?php echo $emp_sts; ?>
                                  </option>
                                  <option value="Working">Working </option>
                                  <option value="Resign">Resign </option>
                                </select>
                              </div>

                            </div>
                            <?php if ($view == false) { ?>

                            <div class="form-group row user-entry" style="    margin-right: 0rem;">


                              <button type="reset"
                                class="btn waves-effect waves-light btn-inverse btn-outline-inverse"><i
                                  class="icofont icofont-exchange"></i>Cancel</button>
                              <button type="submit" class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                name="user_edit" style="margin-left:10px"><i class="fa fa-arrow-up"
                                  style="    font-size: 20px;margin-right: 10px;"></i>Update
                                Employe</button>

                            </div>
                          </div>
                          <?php } else { ?>
                          <script>
                          var ids = ['emp_sts', 'cont_num', 'emp_email_id', 'Emp_type_name', 'loaction_name',
                            'emp_name_id', 'grade_name', 'emp_cat_name', 'desig_name', 'sub_dept_name', 'dept_name',
                            'Branch_name', 'com_name'
                          ];
                          for (var i = 0; i < ids.length; i++) {
                            if (i < 6) {
                              $('#' + ids[i]).replaceWith("<label class='form-control'>" + $('#' + ids[i]).val() +
                                "</label>");

                            } else {
                              // var value = $('#'+ids[i]+" option:selected");
                              $('#' + ids[i]).replaceWith("<label class='form-control'>" + $('#' + ids[i] +
                                " option:selected").text() + "</label>");


                            }

                          }
                          </script>
                          <?php } ?>
                        </div>

                      </div>
                      </form>
                    </div>
                    <?php } ?>
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

<script>

</script>