<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$des = "Page Load View visitor Log";
$rem = "View visitor Log";
$head = "Visitor Info";
include '../include/_audi_log.php';
include '../include/_function.php';
$isPost = "";
if (isset($_POST['visitorView']) && $_POST['vId'] != "") {
  $visitorId = $_POST['vId'];
  $visitorUrl = $_POST['viewFrom'];
  $isPost = "POST";
  $visitorBasicInfo = mysqli_query($conn, "SELECT * from visitor_info where visitor_id = '$visitorId'");
  if
  (mysqli_num_rows($visitorBasicInfo) > 0) {
    $visitorBasicInfo = mysqli_fetch_assoc($visitorBasicInfo);
    if (in_array($user_role, array("Developer", "Super Admin"))) {
      $sqlVisitor = "SELECT * from visitor_log vl join visitor_info vi on vl.visitor_id = vi.visitor_id where vl.visitor_id
  = '$visitorId' order by vl.sl_no desc";
    } else {
      $sqlVisitor = "SELECT * from visitor_log vl join visitor_info vi on vl.visitor_id = vi.visitor_id where vl.visitor_id
  = '$visitorId' and vl.branch_id = '$branch_id' order by vl.sl_no desc";

    }

  } else {
    $_SESSION['icon'] = 'warning';
    $_SESSION['status'] = 'Data not Found...';
    $des = "Click On view visitor information ";
    $rem = "visitor not exits";
    include '../include/_audi_log.php';
    header("location:import_process");
  }

} else {
  if (in_array($user_role, array("Developer", "Super Admin"))) {
    $sqlVisitor = "SELECT * from visitor_log vl join visitor_info vi on vl.visitor_id = vi.visitor_id order by vl.sl_no
  desc";
  } else {
    $sqlVisitor = "SELECT * from visitor_log vl join visitor_info vi on vl.visitor_id = vi.visitor_id where vl.branch_id =
  '$branch_id' order by vl.sl_no desc";

  }

}
$sql_vistor = mysqli_query($conn, $sqlVisitor);




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

                      <?php if ($isPost == "POST") { ?>

                      <div style="padding:6px 20px; display:flex; flex-wrap: wrap;    align-items: baseline;">
                        <div style="flex:0 0 30%; max-width:30%;text-align:left">
                          <label class="col-sm-3 col-form-label"
                            style="padding-right: 0;max-width: 30%;font-family: 'El Messiri', sans-serif;  padding-bottom:0;  font-size: 18px;"><b>Visitor
                              Id :-</b>
                          </label>
                          <span style="font-style:italic; font-size:16px;"><?= $visitorBasicInfo['visitor_id'] ?></span>

                        </div>
                        <div style="flex:0 0 30%; max: width 30px;%;text-align:center">
                          <label class="col-sm-3 col-form-label"
                            style="padding-right: 0;max-width: 40%;font-family: 'El Messiri', sans-serif;  padding-bottom:0;  font-size: 18px;"><b>Visitor
                              Name
                              :-</b>
                          </label>
                          <span style="font-style:italic; font-size:16px;"><?= $visitorBasicInfo['name'] ?></span>
                        </div>
                        <div style="flex:0 0 30%; max-width:30%;text-align:right;padding-right:2rem;">
                          <label class="col-sm-3 col-form-label"
                            style="padding-right: 0;max-width: 36%;font-family: 'El Messiri', sans-serif;   padding-bottom:0; font-size: 18px;text-align:left;"><b></b>No
                            of
                            Visit :-
                            </b>
                          </label>
                          <span style="font-style:italic; font-size:16px;"><?= mysqli_num_rows($sql_vistor) ?></span>
                        </div>
                        <div style="flex:0 0 10%; max-width:10%;text-align:right;">
                          <a href="<?= $visitorUrl ?>" style="width:60%;  ">
                            <button class="btn waves-effect waves-light btn-inverse btn-outline-inverse"
                              style="height: 2.1rem; width:80%; padding: 0;"><i class="fa fa-arrow-left"
                                style="font-size: 20px;margin-right: 10px;"></i>Back</button>
                          </a>

                        </div>
                      </div>
                      <?php } else { ?>
                      <div class="col-md-6">
                        <div class="form-group row" style="margin:5px;">
                          <label class="col-sm-3 col-form-label" style="padding-right: 0;flex:0 0 10%;">Search</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" placeholder="Search" id="searchInput"
                              style="width:60%">
                          </div>
                        </div>
                      </div>
                      <?php } ?>
                      <div class="card-block table-border-style">
                        <div class="table-responsive table-short" style="height: 376px;">
                          <table class="table" id="dataTable">
                            <thead>
                              <tr>
                                <th style="width: 4rem;padding:2px 5px;">Sl No.</th>
                                <th style="padding:2px 5px;">Visit Id</th>
                                <th style="padding:2px 5px;">Comapny Name</th>
                                <th style="padding:2px 5px;">Visitor Type</th>
                                <th style="padding:2px 5px;">Purpose</th>
                                <th style="padding:2px 5px;">Visted Branch</th>
                                <th style="padding:2px 5px;">Visit To Wish</th>
                                <th style="padding:2px 5px;">Reg. Type</th>
                                <th style="padding:2px 5px;">Emp. Permit</th>
                                <th style="padding:2px 5px;">Sec. Permit</th>
                                <th style="padding:2px 5px;">Status</th>
                                <th style="padding:2px 5px;">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $i = 0;
                              while ($visitorData = mysqli_fetch_assoc($sql_vistor)) {
                                ?>
                              <tr>
                                <td><?= ++$i; ?></td>
                                <td>
                                  <?php
                                    $vID = explode('-', $visitorData['visit_uid']);
                                    echo $vID[1];
                                    ?>
                                </td>
                                <td><?= $visitorData['com_name'] ?></td>
                                <td><?= findVisitortype($conn, $visitorData['visitor_type']) ?></td>
                                <td><?= findVisitorPurpose($conn, $visitorData['visit_purpose']) ?></td>
                                <td><?= findBranch($conn, $visitorData['branch_id']) ?></td>
                                <td>
                                  <?php
                                    $empData = findEmp($conn, $visitorData['emp_id']);
                                    if ($empData != null) {
                                      echo $empData['EmployeeName'];
                                    } else {
                                      echo "Not Exist";
                                    }

                                    ?>
                                </td>
                                <td><?= $visitorData['register_type'] ?></td>
                                <td style="padding: 0">
                                  <?php
                                    if ($visitorData['Emp_approve'] == "Approve") {
                                      echo '<i class="icofont icofont-tick-mark" style="color:green; font-size:2rem;"></i>';
                                    } else if ($visitorData['Emp_approve'] == "Reject") {
                                      echo '<i class="icofont icofont-not-allowed" style="color:red; font-size:2rem; font-weight:900"></i>';
                                    } else {
                                      echo '<i class="icofont icofont-history" style="color:blue; font-size:2rem;font-weight:900;"></i>';
                                    }
                                    ?>
                                </td>
                                <td style="padding: 0">
                                  <?php
                                    if ($visitorData['security_approval'] == "Approve") {
                                      echo '<i class="icofont icofont-tick-mark" style="color:green; font-size:2rem;"></i>';
                                    } else if ($visitorData['security_approval'] == "Reject") {
                                      echo '<i class="icofont icofont-not-allowed" style="color:red; font-size:2rem; font-weight:900"></i>';
                                    } else {
                                      echo '<i class="icofont icofont-history" style="color:blue; font-size:2rem; font-weight:900"></i>';
                                    }
                                    ?>
                                </td>
                                <td style="padding: 0; text-align:center;">
                                  <?php
                                    if ($visitorData['check_status'] == "IN") {
                                      echo '<i class="icofont icofont-arrow-left" style="color:green; font-size:2.2rem;"></i>';
                                    } else if ($visitorData['check_status'] == "OUT") {
                                      echo '<i class="icofont icofont-arrow-right" style="color:red; font-size:2.2rem; "></i>';
                                    } else {
                                      echo '<i class="icofont icofont-history" style="color:blue; font-size:2rem; font-weight:bolder; "></i>';
                                    }
                                    ?>
                                </td>


                                <td style="padding:1px;">
                                  <form action="Visitor_details1" method="post">
                                    <input type="hidden" name="v_id" value="<?php echo $visitorData['visit_uid']; ?>">
                                    <input type="hidden" name="vUrl" value="<?php if ($isPost == "POST") {
                                        echo $visitorUrl;
                                      } else {
                                        echo "viewVisitor";
                                      } ?>
                                    ">


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
function quickSearch() {
  var input, filter, table, tr, td, i, txtValue;

  input = document.getElementById("myInput");
  filter = input.value;
  console.log(filter);
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}

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
  $(':focus').blur();
})
</script>

</html>