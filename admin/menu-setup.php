<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$des="Page Load menu-setup";
$rem="menu-setup";
$head = "Canteen SetUp";
include '../include/_audi_log.php';

$days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];

$item_data = mysqli_query($conn, "select * from `canteen_item`");

$p=0;

$menu_day_data = mysqli_query($conn, "select * from `menu`");
$e = false;
if(isset($_POST['edit_btn'])){
    $edit_id = $_POST['edit_id'];
    $e = true;
 
    $menu_data = mysqli_fetch_assoc(mysqli_query($conn, "select *  from `menu` where `sl_no`='$edit_id'"));
    $menu_day = $menu_data['menu_day']; 
    $menu_item_id = $menu_data['menu_item']; 
    $menu_item_head = $menu_data['menu_item_head']; 
    $menu_dest = $menu_data['menu_description']; 
    $menu_remak = $menu_data['menu_remaks']; 


    $item_data_sql = mysqli_fetch_assoc(mysqli_query($conn,"select * from `canteen_item` where `itm_code`= '$menu_item_id'"));
    $item = $item_data_sql['Item_name'].' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  '.$item_data_sql['start_time'].'&nbsp; - &nbsp;'.$item_data_sql['end_time'] ;
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
                                        <?php  if($p == 0 ){?>
                                        <div class="row">
                                            <?php if($e!=true){?>
                                            <div class="col-md-6" style="width:20%;     flex: 0 0 37.3%; ">
                                                <div class="card" style="margin-bottom: 8px; width:30rem ">
                                                    <div class="card-header"
                                                        style="padding-bottom:8px;padding-top:8px;">
                                                        <h5>Menu Setup By Day</h5>
                                                    </div>
                                                    <div class="card-block">
                                                        <form action="canteen_process" method="post">
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label"
                                                                    style="padding-right: 0;">Day <span style="color:red"> *</span></label>
                                                                <div class="col-sm-9">
                                                                    <select name="manu_day" id="" class="form-control" style="height: 2.4rem;">
                                                                        <option value="" disabled selected hidden>Select Day</option>
                                                                        <?php for($i=0; $i<7; $i++){ ?>
                                                                        <option value="<?php echo $days[$i];?>"><?php echo $days[$i];?></option>
                                                                        <?php }?>

                                                                    </select>
                                                                        
                                                                            
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label"
                                                                    style="padding-right: 0;">Item <span style="color:red"> *</span></label>
                                                                <div class="col-sm-9" >
                                                                <select name="manu_item_day" id="" class="form-control" style="height: 2.4rem;">
                                                                        <option value="" disabled selected hidden>Select Item</option>
                                                                       
                                                                             <?php while($items = mysqli_fetch_assoc($item_data)){ ?>
                                                                            <option value="<?php echo $items['itm_code'];?>"><?php echo ucfirst($items['Item_name']).' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  '.$items['start_time'].'&nbsp; - &nbsp;'.$items['end_time'] ;?></option>
                                                                            <?php }?>
                                                                            </select>

                                                                </div>
                                                            </div>
                                                            
                                                            <!-- <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label"
                                                                    style="padding-right: 0;">Time</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Time"
                                                                        name="manu_time" required>
                                                                </div>
                                                            </div> -->
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label"
                                                                    style="padding-right: 0;">Item Head <span style="color:red"> *</span></label>
                                                                <div class="col-sm-9">
                                                                    <select name="manu_item_head_day" id="" class="form-control" style="height: 2.4rem;">
                                                                        <option value="" disabled selected hidden>Select Item Head</option>
                                                                        <option value="Vage">Vage</option>
                                                                        <option value="NoneVage">NoneVage</option>
                                                                        <option value="Vage And NoneVage">Vage And NoneVage</option>
                                                                        <option value="General">General</option>
                                                                    </select>
                                                                    
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label"
                                                                    style="padding-right: 0;">Menu Description</label>
                                                                <div class="col-sm-9">
                                                                    <input  type="text" class="form-control"
                                                                        placeholder="Enter Manu Description"
                                                                        name="manu_description_day" required>
                                                                        
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label"
                                                                    style="padding-right: 0;">Remarks</label>
                                                                <div class="col-sm-9">
                                                                    <input  type="text" class="form-control"
                                                                        placeholder="Enter Remarks"
                                                                        name="manu_remark_day" >
                                                                        
                                                                </div>
                                                            </div>


                                                            <div class="user-entry">

                                                                <button type="reset"
                                                                    class="btn waves-effect waves-light btn-inverse btn-outline-inverse"
                                                                    style="padding: 7px 20px;"><i
                                                                        class="icofont icofont-exchange"></i>Cancel</button>
                                                                <button type="submit"
                                                                    class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                                                    style="padding: 7px 20px;" name="manu_day_btn"><i
                                                                        class="fa fa-plus"
                                                                        style="    font-size: 20px;margin-right: 10px;"></i>
                                                                    Add manu</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>

                                            </div>
                                            <?php }else if($e==true){?>
                                                <div class="col-md-6" style="width:20%;     flex: 0 0 37.3%; ">
                                                <div class="card" style="margin-bottom: 8px; width:30rem ">
                                                    <div class="card-header"
                                                        style="padding-bottom:8px;padding-top:8px;">
                                                        <h5>Edit Menu By Day</h5>
                                                    </div>
                                                    <div class="card-block">
                                                        <form action="canteen_process" method="post">
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label"
                                                                    style="padding-right: 0;">Day <span style="color:red"> *</span></label>
                                                                <div class="col-sm-9">
                                                                    <select name="emanu_day" id="" class="form-control" style="height: 2.4rem;">
                                                                        <option value="<?php echo $menu_day;?>"  selected ><?php echo $menu_day;?></option>

                                                                        <?php for($i=0; $i<7; $i++){ ?>
                                                                        <option value="<?php echo $days[$i];?>"><?php echo $days[$i];?></option>
                                                                        <?php }?>

                                                                    </select>
                                                                        
                                                                            
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="edit_id" value="<?php echo $edit_id;?>">
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label"
                                                                    style="padding-right: 0;">Item <span style="color:red"> *</span></label>
                                                                <div class="col-sm-9" >
                                                                <select name="emanu_item_day" id="" class="form-control" style="height: 2.4rem;">
                                                                        <option value="<?php echo $menu_item_id;?>"  selected ><?php echo $item;?></option>
                                                                       
                                                                             <?php while($items = mysqli_fetch_assoc($item_data)){ ?>
                                                                            <option value="<?php echo $items['itm_code'];?>"><?php echo ucfirst($items['Item_name']) .' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  '.$items['start_time'].'&nbsp; - &nbsp;'.$items['end_time'] ;?></option>
                                                                            <?php }?>
                                                                            </select>

                                                                </div>
                                                            </div>
                                                            
                                                            
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label"
                                                                    style="padding-right: 0;">Item Head <span style="color:red"> *</span></label>
                                                                <div class="col-sm-9">
                                                                    <select name="emanu_item_head_day" id="" class="form-control" style="height: 2.4rem;">
                                                                        <option value="<?php echo $menu_item_head;?>"  selected ><?php echo $menu_item_head;?></option>
                                                                        <option value="Vage">Vage</option>
                                                                        <option value="NoneVage">NoneVage</option>
                                                                        <option value="Vage And NoneVage">Vage And NoneVage</option>
                                                                        <option value="General">General</option>
                                                                    </select>
                                                                    
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label"
                                                                    style="padding-right: 0;">Menu Description</label>
                                                                <div class="col-sm-9">
                                                                    <input  type="text" class="form-control"
                                                                        placeholder="Enter Manu Description"
                                                                        name="emanu_description_day" required value="<?php echo $menu_dest;?>">
                                                                        
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label"
                                                                    style="padding-right: 0;">Remarks</label>
                                                                <div class="col-sm-9">
                                                                    <input  type="text" class="form-control"
                                                                        placeholder="Enter Remarks"
                                                                        name="emanu_remark_day" value="<?php echo $menu_remak;?>">
                                                                        
                                                                </div>
                                                            </div>


                                                            <div class="user-entry">

                                                                <button type="reset"
                                                                    class="btn waves-effect waves-light btn-inverse btn-outline-inverse"
                                                                    style="padding: 7px 20px;"><i
                                                                        class="icofont icofont-exchange"></i>Cancel</button>
                                                                <button type="submit"
                                                                    class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                                                    style="padding: 7px 20px;" name="emenu_day_btn"><i
                                                                        class="fa fa-arrow-up"
                                                                        style="    font-size: 20px;margin-right: 10px;"></i>
                                                                    Edit manu</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>

                                            </div>

                                            <?php } ?>

                                            <div class="col-md-6" style="max-width: 65%; flex: 1 0 56%;">

                                                

                                                <div class="card">
                                                    <div class="card-block table-border-style">
                                                        <div class="table-responsive table-short" style="height:368px">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="">Sl No.</th>
                                                                        <th>Day</th>
                                                                        <th>Item</th>
                                                                        <th>Item Head </th>
                                                                        

                                                                        <th colspan=2 style="  width: 30%;">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php $i = 0; while($manu_data = mysqli_fetch_assoc($menu_day_data)){ $i++?>
                                                                    <tr>
                                                                        <th scope="row"><?php echo $i;?></th>
                                                                        <td><?php echo $manu_data['menu_day'];?></td>
                                                                        <td>
                                                                            <?php 
                                                                                $menu_id = $manu_data['menu_item'];
                                                                                $item_sql = mysqli_fetch_assoc(mysqli_query($conn,"select * from `canteen_item` where `itm_code`= '$menu_id'"));
                                                                                echo $item_sql['Item_name'];
                                                                            ?>
                                                                        </td>
                                                                        <td><?php echo $manu_data['menu_item_head'];?></td>
                                                                        



                                                                        <td>
                                                                            <form action="" method="post">
                                                                                <input type="hidden" name="edit_id" value="<?php echo $manu_data['sl_no'];?>">
                                                                                <button class="btn waves-effect waves-light btn-primary btn-outline-primary" name="edit_btn"><i
                                                                                        class="icofont icofont-ui-edit"></i>Edit</button>

                                                                            </form>
                                                                            
                                                                        </td>
                                                                        <td>
                                                                            <a href="canteen_process?dlid=<?php echo $manu_data['sl_no'];?>" class="delt_href">
                                                                                <button
                                                                                    class="btn waves-effect waves-light btn-danger btn-outline-danger"><i
                                                                                        class="icofont icofont-delete-alt"></i>Delete</button>
                                                                            </a>
                                                                        </td>

                                                                    </tr>
                                                                    <?php }?>
                                                                    
                                                                   
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>




                                        <?php }else{?>




                                            <div class="row">
                                            <div class="col-md-6" style="width:20%;     flex: 0 0 37.3%; ">
                                                <div class="card" style="margin-bottom: 8px; width:30rem ">
                                                    <div class="card-header"
                                                        style="padding-bottom:8px;padding-top:8px;">
                                                        <h5>Manu Setup By Date</h5>
                                                    </div>
                                                    <div class="card-block">
                                                        <form>
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label"
                                                                    style="padding-right: 0;">Date</label>
                                                                <div class="col-sm-9">
                                                                    <input  type="date" class="form-control"
                                                                        placeholder="Enter Day" name="menu_date"
                                                                        required>
                                                                       
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label"
                                                                    style="padding-right: 0;">Item</label>
                                                                <div class="col-sm-9" >
                                                                <input list = "item" type="text" class="form-control"
                                                                        placeholder="Enter Item" name="menu_item"
                                                                        required>
                                                                        <datalist id="item">
                                                                            <option value="Acording to item table"></option>
                                                                            <!-- <?php for($i=0; $i<7; $i++){ ?>
                                                                            <option value="<?php echo $days[$i];?>"></option>
                                                                            <?php }?> -->
                                                                        </datalist>

                                                                </div>
                                                            </div>
                                                            
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label"
                                                                    style="padding-right: 0;">Time</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control"
                                                                        placeholder="Time"
                                                                        name="manu_time" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label"
                                                                    style="padding-right: 0;">Item Head</label>
                                                                <div class="col-sm-9">
                                                                    <input list="manu-head" type="text" class="form-control"
                                                                        placeholder="Enter Item Head"
                                                                        name="manu_item_head" required>
                                                                        <datalist id = "manu-head">
                                                                            <option value="Vage"></option>
                                                                            <option value="NoneVage"></option>
                                                                            <option value="General"></option>
                                                                            </datalist>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label"
                                                                    style="padding-right: 0;">Menu Description</label>
                                                                <div class="col-sm-9">
                                                                    <input  type="text" class="form-control"
                                                                        placeholder="Enter Manu Description"
                                                                        name="manu_description" required>
                                                                        
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-3 col-form-label"
                                                                    style="padding-right: 0;">Remarks</label>
                                                                <div class="col-sm-9">
                                                                    <input  type="text" class="form-control"
                                                                        placeholder="Enter Remarks"
                                                                        name="manu_remark_date" >
                                                                        
                                                                </div>
                                                            </div>


                                                            <div class="user-entry">

                                                                <button
                                                                    class="btn waves-effect waves-light btn-inverse btn-outline-inverse"
                                                                    style="padding: 7px 20px;"><i
                                                                        class="icofont icofont-exchange"></i>Cancel</button>
                                                                <button
                                                                    class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                                                    style="padding: 7px 20px;" name="manu_date"><i
                                                                        class="fa fa-plus"
                                                                        style="    font-size: 20px;margin-right: 10px;"></i>
                                                                    Add Manu</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>

                                            </div>


                                            <div class="col-md-6" style="max-width: 65%; flex: 1 0 56%;">

                                                

                                                <div class="card">
                                                    <div class="card-block table-border-style">
                                                        <div class="table-responsive table-short" style="height:410px">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="">Sl No.</th>
                                                                        <th>Item Head </th>
                                                                        <th>Item</th>
                                                                        <th>Day</th>
                                                                        

                                                                        <th colspan=2 style="  width: 30%;">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                        
                                                                    <tr>
                                                                        <th scope="row">1</th>
                                                                        <td>Admin</td>
                                                                        <td>Admin</td>
                                                                        <td>Admin</td>
                                                                        



                                                                        <td>
                                                                            <a href="">
                                                                                <button
                                                                                    class="btn waves-effect waves-light btn-primary btn-outline-primary"><i
                                                                                        class="icofont icofont-ui-edit"></i>Edit</button>
                                                                            </a>
                                                                        </td>
                                                                        <td>
                                                                            <a href="">
                                                                                <button
                                                                                    class="btn waves-effect waves-light btn-danger btn-outline-danger"><i
                                                                                        class="icofont icofont-delete-alt"></i>Delete</button>
                                                                            </a>
                                                                        </td>

                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">1</th>
                                                                        <td>Admin</td>
                                                                        <td>Admin</td>
                                                                        <td>Admin</td>
                                                                        



                                                                        <td>
                                                                            <a href="">
                                                                                <button
                                                                                    class="btn waves-effect waves-light btn-primary btn-outline-primary"><i
                                                                                        class="icofont icofont-ui-edit"></i>Edit</button>
                                                                            </a>
                                                                        </td>
                                                                        <td>
                                                                            <a href="">
                                                                                <button
                                                                                    class="btn waves-effect waves-light btn-danger btn-outline-danger"><i
                                                                                        class="icofont icofont-delete-alt"></i>Delete</button>
                                                                            </a>
                                                                        </td>

                                                                    </tr>
                                                                    
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php }?>
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
<script>
    $('.delt_href').on('click', function(e){
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
   
  }else{
    
  }
})

})
</script>
</html>