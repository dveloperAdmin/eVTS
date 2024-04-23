<?php 
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$head  = "Visitor Info";
$des="Page Load new_visitor3";
$rem="New visitor";
include '../include/_audi_log.php';

if(isset($_POST['view_v'])){
    $v_id = $_POST['v_id'];
}else{header('location:view_visitor?id=1');}









?>
<!DOCTYPE html>
<html lang="en">

<?php include "include/head.php";?>

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
                        <?php include "include/header.php"?>
                        <!-- Page-header end -->

                        <div class="pcoded-inner-content">
                            <!-- Main-body start -->
                            <div class="main-body">
                                <div class="page-wrapper">
                                    <!-- Page-body start -->
                                    <div class="page-body">
                                        <div class="card">
                                            
                                            
                                            <div class="row">
                                                <div class="col-md-6" style=" display:grid; place-content:center;">
                                                    <div id="my_camera" style="width:303px; height:253px;"></div>
                                                    <div class="user-entry" style="margin-left: .4rem; padding:1rem; margin-top:1.2rem;">
                                                        
                                                    <a href="view_visitor?id=1"><button type="reset"    class="btn waves-effect waves-light btn-inverse btn-outline-inverse"><i  class="icofont icofont-exchange"></i>Back</button></a>
                                                    <button type="click"  id="click_pic" class="btn waves-effect waves-light btn-primary btn-outline-primary"    onclick="take_snapshot()"><i class="fa fa-camera" style=" font-size: 20px;margin-right: 10px;" autofocus></i>Click A Picture</button>
                                                </div>
                                                <form action="visitor_app_rej_details" method="post" enctype="multipart/form-data" id="img_sub">
                                                
                                                    <input type="hidden" name="v_id" value="<?php echo $v_id ;?>" />
                                                    <input type="hidden" name="image" class="image-tag" id = "img2"/>
                                                    <input type="hidden" name="uid" value="<?php echo "VSL-".abs( crc32( uniqid() ) );?>"/>
                                                    <!-- <input type="text" value="yes" id = "img2"> -->

                                                </div>
                                                <div class="col-md-6" style=" display:grid; place-content:center; ">
                                                    <div id="results" style="width:303px; height:253px; margin-top:.2rem;"></div>
                                                        <div id = "sub_id"class="user-entry" style="margin-left: .4rem; padding:.5rem; padding-top:1.5rem; display:grid;">
                                                            <button type="submit"   class="btn waves-effect waves-light btn-primary btn-outline-primary"   name="view_v"><i class="fa fa-camera" style="    font-size: 20px;margin-right: 10px;"></i>Submit</button>
                                                        </div>
                                                        
                                                </div>
                                            </div>
                                            </form>
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
    <?php include "include/footer.php";?>
</body>
</html>
<script language="JavaScript">
      Webcam.set({
        width: 303,
        height: 250,
        image_format: "jpeg",
        jpeg_quality: 100,
      });
 
      Webcam.attach("#my_camera");
 
      function take_snapshot() {
        Webcam.snap(function (data_uri) {
          $(".image-tag").val(data_uri);
          document.getElementById("results").innerHTML =
            '<img src="' + data_uri + '"/>';
        });
      }
    </script>