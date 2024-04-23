<?php 
include "../include/_session.php";
include "../include/_dbconnect.php";
$des="Page Load my_details";
$rem="my_ddetails";
$head = "My Details";
include "../include/_audi_log.php";


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
                                        <div class="row">
                                            <div class="col-md-6" style="flex: 0 0 27%;">
                                                <div class="card" style="margin-bottom: 8px;">
                                                    <div class="card-header"  style="padding-bottom:8px;padding-top:8px;">
                                                        <h5>Menu Details By Day</h5>
                                                    </div>
                                                    <div class="card-block table-border-style">
                                                        <div class="table-responsive" style="height:auto">
                                                            <table class="table" style="color:black; font-weight:600;"border="1">
                                                                
                                                                <tbody>
                                                                    <tr style="">
                                                                    
                                                                        <td style="padding:.34rem;"><input type="button" value="Monday" class="btn btn-primary m-btn " style="background:purple"> </td>
                                                                    
                                                                        
                                                                    </tr>
                                                                    
                                                                    <tr style="">
                                                                        
                                                                    <td style="padding:.34rem;"><input type="button" value="Tuesday" class="btn btn-primary m-btn " style="background:blue" > </td>
                                                                        
                                                                        
                                                                    </tr>
                                                                    <tr style="">
                                                                        
                                                                    <td style="padding:.34rem;"><input type="button" value="Wednesday" class="btn btn-primary m-btn "  > </td>
                                                                        
                                                                        
                                                                    </tr>
                                                                    <tr style="">
                                                                        
                                                                    <td style="padding:.34rem;"><input type="button" value="Thursday" class="btn btn-primary m-btn " style="background:Green"  > </td>
                                                                        
                                                                        
                                                                    </tr>
                                                                    <tr style="">
                                                                        
                                                                    <td style="padding:.34rem;"><input type="button" value="Friday" class="btn btn-primary m-btn " style="background:Yellow;color: #0715a5;"  > </td>
                                                                    
                                                                        
                                                                    </tr>
                                                                    <tr style="">
                                                                        
                                                                    <td style="padding:.34rem;"><input type="button" value="Saturday" class="btn btn-primary m-btn " style="background:#fba400;"  > </td>
                                                                    
                                                                        
                                                                    </tr>
                                                                    <tr style="">
                                                                        
                                                                    <td style="padding:.34rem;"><input type="button" value="Sunday" class="btn btn-primary m-btn " style="background:red;"  > </td>
                                                                        
                                                                    </tr>
                                                                
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6" style="flex: 0 0 77%; max-width:72.5%;padding-left: 0;">
                                            <div class="card" style="margin-bottom: 8px;  padding:8px;" id="total-desig">
                                            
                                            <div class="card" style="margin-bottom: 0px;  " id="contact1">
                                            <div class="card-header" style="padding-bottom: 8px; padding-top: 8px;">
                                                <h5>Day Wise Menu Details</h5>
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
    <?php include "include/footer.php";?>
</body>

</html>
<script>
$(".m-btn").click(function(){

let emp=$(this).val();console.log(emp);

if(emp!=""){

   
    let emp_id='id='+ emp;
    $.ajax
    ({
    type: "POST",
    url: "ajax.php",
    data: emp_id,
    cache: false,
    success: function(cities)
    {
   
    $("#contact1").html(cities);
    } 
    });
}else{
    $("#contact1").css("display","none");
} 

});

</script>