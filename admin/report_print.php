<?php 
include "../include/_session.php";
include "../include/_dbconnect.php";
include '../include/_lic_check.php';
$head = "Dashbord";
$des="Page Load Report print";
$rem="Report Print";
include "../include/_audi_log.php";

// if($emp_id == 1){
//     $sql_get_data = mysqli_query($conn, "select * from `log_book`");
// }else{
//     $sql_get_data = mysqli_query($conn, "select * from `log_book`where `user_id`='$emp_id'");
// }
// if( $sql_get_data!=""){
   
   
// }else{
//     $_SESSION['icon']='error';
//     $_SESSION['status']='Data Not Found';

//     header("location:log_report");
// }

?>
<!DOCTYPE html>
<html lang="en">

<?php include "include/head.php";?>

<body>
    
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">
           

            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">

                    

                    <div class="pcoded-content">

                       

                        <div class="pcoded-inner-content">
                            <!-- Main-body start -->
                            <div class="main-body">
                                <div class="page-wrapper">
                                    <!-- Page-body start -->
                                    <div class="page-body">
                                        <div class="row">
                                           
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
