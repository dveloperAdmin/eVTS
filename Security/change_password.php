<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
$des="Page Load change_password";
$rem="change_password";
$head  = "Change Password";
include '../include/_audi_log.php';
$c_fname = "";
$c_sname = "";
$p = false;



if(isset($_POST['pass_update'])){
    $old_pass= $_POST['old_pass'];
    $new_pass= $_POST['new_pass'];
    $user_id = $_SESSION['user_name'];
    $sql_user_check = mysqli_fetch_assoc(mysqli_query($conn,"select * from `user` where `user_name` = '$user_id'"));

    $db_pass  = $sql_user_check['password'];

    if(password_verify($old_pass, $db_pass)){
        $new_pass_hash = password_hash($new_pass,PASSWORD_DEFAULT);
        $sql_pass_update = mysqli_query($conn,"update `user` set `password`='$new_pass_hash' where `user_name`='$user_id'");
        if($sql_pass_update){
            $des="Password Change successfully";
            $rem="Password changed ";
            
            include '../include/_audi_log.php'; 
            
            $_SESSION['icon'] = 'success';
            $_SESSION['status'] = 'Password Change Password';
        }else{
            $des="Password Change unsuccessfull";
            $rem="Password not change ";
            
            include '../include/_audi_log.php'; 
            
            $_SESSION['icon'] = 'error';
            $_SESSION['status'] = 'Old Password Miss Match';
        }

    }else{
        $des="Password Change unsuccessfull";
        $rem="Password not change ";
        
        include '../include/_audi_log.php'; 
        
        $_SESSION['icon'] = 'error';
        $_SESSION['status'] = 'Old Password Miss Match';
    }

    
}








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

                                    <!-- Page body start -->
                                    <div class="page-body">
                                        <div class="row">
                                            <div class="col-md-6">

                                                <div class="card" style="margin-bottom: 8px;">
                                                    <div class="card-header"
                                                        style="padding-bottom:8px;padding-top:8px;">
                                                        <h5 style="width: 80%;">Change Password</h5>
                                                        
                                                    </div>
                                                    <div class="card-block">
                                                        <form action="" method="post">
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label">Old Password</label>
                                                                <div class="col-sm-9">
                                                                    <input type="password" class="form-control"
                                                                        placeholder="Enter Old Password"
                                                                        name="old_pass" required
                                                                        >
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="c_id"
                                                                value="<?php echo $e_id;?>">
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label">New Password</label>
                                                                <div class="col-sm-9">
                                                                    <input type="password" class="form-control"
                                                                        placeholder="Enter New Password"
                                                                        name="new_pass" required
                                                                        >
                                                                </div>
                                                            </div>


                                                            <div class="user-entry">

                                                                <button type="reset"
                                                                    class="btn waves-effect waves-light btn-inverse btn-outline-inverse"
                                                                    style="padding: 7px 20px;"><i
                                                                        class="icofont icofont-exchange"></i>Cancel</button>
                                                                <button type="submit"
                                                                    class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                                                    style="padding: 7px 20px;" name="pass_update"><i
                                                                        class="fa fa-pencil-square-o"
                                                                        style="    font-size: 20px;margin-right: 10px;"></i>Update Password</button>
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
<script>
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

</html>