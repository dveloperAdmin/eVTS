<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$head = "Visitor Info";
$des = "Page Load Prescheduled Image ";
$rem = "Preschedul visitor";
include '../include/_audi_log.php';

if (isset($_POST['view_v'])) {
  $v_id = $_POST['v_id'];
} else {
  header('location:view_visitor?id=1');
}










?>
<!DOCTYPE html>
<html lang="en">

<?php include "include/head.php"; ?>
<style>
input[type="file"]::file-selector-button {
  background-color: #4CAF50;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
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
                  <!-- Page-body start -->
                  <div class="page-body">
                    <div class="card">
                      <div class="card-header" style="padding-top:8px; padding-bottom:8px;">
                        <div class="row">
                          <div class="col-md-3" style="flex:0 0 30%; max-width:35%;">

                            <h5>Upload Visitor Image</h5>
                          </div>
                        </div>
                      </div>

                      <div class="row" style="max-height:20rem;">
                        <div class="col-md-6">
                          <div class="card-block">
                            <form action="visitor_app_rej_details" method="post" enctype="multipart/form-data">
                              <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Upload Image</label>
                                <div class="col-sm-9">

                                  <input type="file" class="form-control" id="imgFileInput" name="image"
                                    accept=".jpg, .jpeg, .png" Required />
                                  <span style="color:red;">Image Size within 250 Kb</span>
                                </div>
                              </div>
                              <div class="user-entry">

                                <a href="view_visitor?id=1">
                                  <button type="reset"
                                    class="btn waves-effect waves-light btn-inverse btn-outline-inverse"><i
                                      class="icofont icofont-exchange"></i>Back</button>
                                </a>

                              </div>

                              <input type="hidden" name="v_id" value="<?php echo $v_id; ?>" />
                              <!-- <input type="hidden" name="image" class="image-tag" /> -->
                              <input type="hidden" name="uid" value="<?php echo "VSL-" . abs(crc32(uniqid())); ?>" />
                              <!-- <input type="text" value="yes" id = "img2"> -->

                          </div>
                        </div>
                        <div class="col-md-6" style=" display:grid; place-content:center; ">
                          <div id="results" style="width:218px; height:223px; margin-top:.2rem;">

                          </div>
                          <div id="subBtn" class="user-entry"
                            style="margin-left: .4rem; padding:.5rem; padding-top:1.5rem; display:grid;">
                            <button type="submit" class="btn waves-effect waves-light btn-primary btn-outline-primary"
                              name="view_v"><i class="fa fa-camera"
                                style="    font-size: 20px;margin-right: 10px;"></i>Submit</button>
                          </div>

                        </div>
                        </form>
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

</html>
<script language="JavaScript">
$("#imgFileInput").change(function() {
  let img = document.getElementById("imgFileInput");
  // let imageProparty = $(this).prop('src');
  var file = this.files[0];
  var fileType = file["type"];
  var validImageTypes = ["image/gif", "image/jpeg", "image/png"];
  if ($.inArray(fileType, validImageTypes) < 0) {
    // invalid file type code goes here.


    console.log('Invalid image type');
  } else {
    document.getElementById("results").innerHTML =
      '<img style="width:218px; height:222px" src="' + URL.createObjectURL(img.files[0]) + '"/>';
    $('image-tag').val(img.files[0]);

  }

})
</script>