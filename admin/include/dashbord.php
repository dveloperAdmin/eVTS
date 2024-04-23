<?php
if(in_array($user_role, array("Developer", "Super Admin"))){

    $total_user=mysqli_num_rows(mysqli_query($conn,"select * from `user` where `name`!='ADMIN'"));
    $total_admin=mysqli_num_rows(mysqli_query($conn,"select * from `user` where `user_role`='Admin' and `name`!='ADMIN'"));
    $total_end_user=mysqli_num_rows(mysqli_query($conn,"select * from `user` where `user_role`='User'"));
    $total_end_security=mysqli_num_rows(mysqli_query($conn,"select * from `user` where `user_role`='Security'"));
    $total_active=mysqli_num_rows(mysqli_query($conn,"select * from `user` where `user_sts`='Active' and `name`!='ADMIN'"));
    $total_deactive=mysqli_num_rows(mysqli_query($conn,"select * from `user` where `user_sts`='De-Active' and `name`!='ADMIN'"));
}else{
    
    $total_user=mysqli_num_rows(mysqli_query($conn,"select * from `user` where `BranchId` = '$branch_id'and `name`!='ADMIN'"));
    $total_admin=mysqli_num_rows(mysqli_query($conn,"select * from `user` where `BranchId` = '$branch_id'and `user_role`='Admin' and `name`!='ADMIN'"));
    $total_end_user=mysqli_num_rows(mysqli_query($conn,"select * from `user` where  `BranchId` = '$branch_id'and`user_role`='User'"));
    $total_end_security=mysqli_num_rows(mysqli_query($conn,"select * from `user` where `BranchId` = '$branch_id'and `user_role`='Security'"));
    $total_active=mysqli_num_rows(mysqli_query($conn,"select * from `user` where `BranchId` = '$branch_id'and `user_sts`='Active' and `name`!='ADMIN'"));
    $total_deactive=mysqli_num_rows(mysqli_query($conn,"select * from `user` where `BranchId` = '$branch_id'and `user_sts`='De-Active' and `name`!='ADMIN'"));
}






?>
<div class="col-xl-6 col-md-12">
<div class="row">
        <!-- sale card start -->

        <div class="col-md-6">
            <div class="card text-center order-visitor-card" id="total-u">
                <div class="card-block dsh-card">
                <i class="fa fa-users m-r-15 text-c-black"></i>
                <div class="card-text">
                    <h6 class="m-b-0">TOTAL USERS</h6>
                    <h4 class="m-t-15 m-b-15"><?php echo $total_user;?></h4>
                    <p class="m-b-0"></p>
                </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-center order-visitor-card" id="active">
                <div class="card-block dsh-card">
                <i class="fa fa-user-plus m-r-15 text-c-black"></i>
                <div class="card-text">
                    <h6 class="m-b-0">ACTIVE</h6>
                    <h4 class="m-t-15 m-b-15"><?php echo $total_active?></h4>
                    <p class="m-b-0"></p>
                </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-center order-visitor-card" id="total-A">
                <div class="card-block dsh-card">
                <i class="fa fa-500px m-r-15 text-c-black"></i>
                <div class="card-text ">
                    <h6 class="m-b-0">ADMIN</h6>
                    <h4 class="m-t-15 m-b-15"><?php echo $total_admin?></h4>
                    <p class="m-b-0"></p>
                </div>
                </div>
            </div>
        </div>
       
        <div class="col-md-6">
            <div class="card text-center order-visitor-card" id="users">
                <div class="card-block dsh-card">
                <i class="fa fa-user m-r-15 text-c-black"></i>
                <div class="card-text">
                    <h6 class="m-b-0"> USERS</h6>
                    <h4 class="m-t-15 m-b-15"><?php echo $total_end_user;?></h4>
                    <p class="m-b-0"></p>
                </div>
                </div>
            </div>
        </div>
        
        
        <!-- <div class="col-md-6">
            <div class="card text-center order-visitor-card">
                <div class="card-block">
                    <h6 class="m-b-0">Unique Visitors</h6>
                    <h4 class="m-t-15 m-b-15"><i class="fa fa-arrow-down m-r-15 text-c-red"></i>652</h4>
                    <p class="m-b-0">36% From Last 6 Months</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-center order-visitor-card">
                <div class="card-block">
                    <h6 class="m-b-0">Monthly Earnings</h6>
                    <h4 class="m-t-15 m-b-15"><i class="fa fa-arrow-up m-r-15 text-c-green"></i>5963</h4>
                    <p class="m-b-0">36% From Last 6 Months</p>
                </div>
            </div>
        </div> -->
        <!-- sale card end -->
    </div>
</div>
<div class="col-xl-6 col-md-12">
    <div class="row">
        <!-- sale card start -->
        <div class="col-md-6">
            <div class="card text-center order-visitor-card" id="deactive">
                <div class="card-block dsh-card">
                <i class="fa fa-user-times m-r-15 text-c-black"></i>
                <div class="card-text">
                    <h6 class="m-b-0">DE-ACTIVE</h6>
                    <h4 class="m-t-15 m-b-15"><?php echo $total_deactive;?></h4>
                    <p class="m-b-0"></p>
                </div>
                </div>
            </div>
        </div>
       
        <div class="col-md-6">
        </div>
        <div class="col-md-6">
            <div class="card text-center order-visitor-card" id="users" style="    background: linear-gradient(266deg, #fff700 0%, #ff0000c2 117%);">
                <div class="card-block dsh-card">
                <i class="fa fa-user m-r-15 text-c-black"></i>
                <div class="card-text">
                    <h6 class="m-b-0">SECURITIE</h6>
                    <h4 class="m-t-15 m-b-15"><?php echo $total_end_security;?></h4>
                    <p class="m-b-0"></p>
                </div>
                </div>
            </div>
        </div>
        <!-- <div class="col-md-6">
            <div class="card text-center order-visitor-card">
                <div class="card-block">
                    <h6 class="m-b-0">Order Status</h6>
                    <h4 class="m-t-15 m-b-15"><i class="fa fa-arrow-up m-r-15 text-c-green"></i>6325</h4>
                    <p class="m-b-0">36% From Last 6 Months</p>
                </div>
            </div>
        </div> -->
        <!-- <div class="col-md-6">
            <div class="card bg-c-red total-card">
                <div class="card-block">
                    <div class="text-left">
                        <h4>489</h4>
                        <p class="m-0">Total Comment</p>
                    </div>
                    <span class="label bg-c-red value-badges">15%</span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-c-green total-card">
                <div class="card-block">
                    <div class="text-left">
                        <h4>$5782</h4>
                        <p class="m-0">Income Status</p>
                    </div>
                    <span class="label bg-c-green value-badges">20%</span>
                </div>
            </div>
        </div> -->
        <!-- <div class="col-md-6">
            <div class="card text-center order-visitor-card">
                <div class="card-block">
                    <h6 class="m-b-0">Unique Visitors</h6>
                    <h4 class="m-t-15 m-b-15"><i class="fa fa-arrow-down m-r-15 text-c-red"></i>652</h4>
                    <p class="m-b-0">36% From Last 6 Months</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-center order-visitor-card">
                <div class="card-block">
                    <h6 class="m-b-0">Monthly Earnings</h6>
                    <h4 class="m-t-15 m-b-15"><i class="fa fa-arrow-up m-r-15 text-c-green"></i>5963</h4>
                    <p class="m-b-0">36% From Last 6 Months</p>
                </div>
            </div>
        </div> -->
        <!-- sale card end -->
    </div>
</div>