<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$des = "Page Load View visitor Log";
$rem = "View visitor Log";
$head = "Visitor Info";
include '../include/_audi_log.php';
$sql_check_reject = mysqli_query($conn, "select * from `visitor_log` where `security_approval`='Reject' or `Emp_approve`='Reject'");
if (mysqli_num_rows($sql_check_reject) >= 1) {
  while ($reject_data = mysqli_fetch_assoc($sql_check_reject)) {
    $v_id = $reject_data['visit_uid'];
    mysqli_query($conn, "update `visitor_log` set `check_status`='OUT' where `visit_uid` ='$v_id'");
  }
}
if (isset($_GET['id'])) {
  $form_action = "preschedul_view";
  $sql_vistor = mysqli_query($conn, "select * from `visitor_log` where `branch_id` = '$branch_id'and `security_approval`='Pending' and Emp_approve!='Reject' order by `sl_no` desc");
  $serach_visit = mysqli_query($conn, "select distinct `visitor_id` from `visitor_log` where `branch_id` = '$branch_id'and `security_approval`='Pending'  order by `sl_no` desc");
} else {
  $form_action = "Visitor_details";
  $sql_vistor = mysqli_query($conn, "select * from `visitor_log` where `branch_id` = '$branch_id'and `security_approval`!='Pending' order by `sl_no` desc");
  $serach_visit = mysqli_query($conn, "select distinct `visitor_id` from `visitor_log` where `branch_id` = '$branch_id'and `security_approval`!='Pending' order by `sl_no` desc");

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
                    <div class="card">
                      <div class="col-md-6" style="    padding-top: .3rem;">
                        <div class="form-group row" style="margin:5px;">
                          <label class="col-sm-3 col-form-label" style="padding-right: 0;flex:0 0 10%;">Search</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" placeholder="Search" id="searchInput"
                              style="width:60%">



                          </div>
                        </div>
                      </div>
                      <div class="card-block table-border-style" style="padding-top:5px;">
                        <div class="table-responsive table-short" style="height: 376px;">
                          <table class="table" id="dataTable">
                            <thead>
                              <tr>
                                <th style="width: 4rem;padding-bottom:2px;padding-top:2px;">
                                  Sl No.</th>
                                <th style="padding-bottom:2px;padding-top:2px;">Visit Id
                                </th>
                                <th style=" width: 10%; padding-bottom:2px;padding-top:2px;">Id Card </th>
                                <th style=" padding-bottom:2px;padding-top:2px;">
                                  Visitor Name</th>
                                <th style="padding-bottom:2px;padding-top:2px;">Com.
                                  Name</th>
                                <th style="padding-bottom:2px;padding-top:2px;">
                                  Visit To Wish</th>
                                <th style="padding-bottom:2px;padding-top:2px;">
                                  Reg. Type</th>
                                <th style="padding-bottom:2px;padding-top:2px;">
                                  Emp. Permit</th>
                                <th style="padding-bottom:2px;padding-top:2px;">
                                  Secq. Permit</th>
                                <th style="padding-bottom:2px;padding-top:2px;">Status
                                </th>
                                <th style="  width: 10%;padding-bottom:2px;padding-top:2px;">
                                  Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $i = 0;
                              while ($visitor_data = mysqli_fetch_assoc($sql_vistor)) {
                                $v_nam = "";
                                $v_com = "";
                                $e_name = "";
                                $visitor_id = $visitor_data['visitor_id'];
                                $visitor_details = mysqli_fetch_assoc(mysqli_query($conn, "select * from `visitor_info` where `visitor_id` = '$visitor_id' "));
                                if ($visitor_details != "") {
                                  $v_nam = $visitor_details['name'];
                                  $v_com = $visitor_details['com_name'];
                                }

                                $emp_id = $visitor_data['emp_id'];
                                $emp_details = mysqli_fetch_assoc(mysqli_query($conn, "select * from `eomploye_details` where `Emp_code`= '$emp_id'"));
                                if ($emp_details != "") {
                                  $e_name = $emp_details['EmployeeName'];
                                }

                                $i++;

                                ?>
                                <tr>
                                  <th scope="row" style="padding:1px;"><?php echo $i; ?>
                                  </th>
                                  <td style="padding:1px;">
                                    <?php
                                    $id = explode("-", rtrim($visitor_data['visit_uid']));
                                    if ($id != "") {
                                      echo $id[1];
                                    } ?>
                                  </td>
                                  <td style="padding:1px;">
                                    <?php echo $visitor_data['id_card_no']; ?>
                                  </td>
                                  <td style="padding:1px;"><?php echo ucfirst($v_nam); ?>
                                  </td>
                                  <td style="padding:1px;"><?php echo ucfirst($v_com); ?>
                                  </td>
                                  <td style="padding:1px;"><?php echo ucfirst($e_name); ?>
                                  </td>
                                  <td style="padding:1px;"><?php echo ucfirst($visitor_data['register_type']); ?>
                                  </td>
                                  <td style="padding:1px;">
                                    <?php
                                    if ($visitor_data['Emp_approve'] == 'Pending') {
                                      echo '<i class="icofont icofont-history" style="color:blue; font-size:2rem; font-weight:900"></i>';
                                    } else if ($visitor_data['Emp_approve'] == 'Approve') {
                                      echo '<i class="icofont icofont-tick-mark" style="color:green; font-size:2rem;"></i>';
                                    } else {
                                      echo '<i class="icofont icofont-not-allowed" style="color:red; font-size:2rem; font-weight:900"></i>';
                                    }
                                    ?>
                                  </td>
                                  <td style="padding:1px;"><?php
                                  if ($visitor_data['security_approval'] == 'Pending') {
                                    echo '<i class="icofont icofont-history" style="color:blue; font-size:2rem; font-weight:900"></i>';
                                  } else if ($visitor_data['security_approval'] == 'Approve') {
                                    echo '<i class="icofont icofont-tick-mark" style="color:green; font-size:2rem;"></i>';
                                    ;
                                  } else {
                                    echo '<i class="icofont icofont-not-allowed" style="color:red; font-size:2rem; font-weight:900"></i>';
                                  }
                                  ?></td>
                                  <td style="padding: 0; text-align:center;">
                                    <?php
                                    if ($visitor_data['check_status'] == 'OUT') {
                                      echo '<i class="icofont icofont-arrow-right" style="color:red; font-size:2.2rem; "></i>';
                                    } else if ($visitor_data['check_status'] == 'IN') {
                                      echo '<i class="icofont icofont-arrow-left" style="color:green; font-size:2.2rem;"></i>';
                                      ;
                                    } else {
                                      echo '<i class="icofont icofont-history" style="color:blue; font-size:2rem; font-weight:900"></i>';

                                    }
                                    ?>
                                  </td>

                                  <td style="padding:1px;">
                                    <form action="<?php echo $form_action; ?>" method="post">
                                      <input type="hidden" name="v_id" value="<?php echo $visitor_data['visit_uid']; ?>">
                                      <button class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                        name="view_v" style="padding: 4px 11px 4px 11px;"><i
                                          class="icofont icofont-eye-alt"></i>View</button>
                                    </form>

                                  </td>


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
<script>
  $("#searchInput").keyup(function () {
    var searchText = $(this).val().toLowerCase();

    $("#dataTable tbody tr").each(function () {
      var rowData = $(this).text().toLowerCase();
      if (rowData.indexOf(searchText) === -1) {
        $(this).hide();
      } else {
        $(this).show();
      }
    });
  });



  $('.delt_href').on('click', function (e) {
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
    $(':focus').blur();
  })
</script>

</html>