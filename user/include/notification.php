<?php
$today = date("Y-m-d");
$emp_code = $_SESSION['emp_code'];
$emp_details = mysqli_query($conn, "select * from `visitor_log` where `emp_id` = '$emp_code' and `Emp_approve` = 'Pending' ");









?>

<?php if(mysqli_num_rows($emp_details)>=1){?>
    <div class="card" style="padding:.5rem;    margin-bottom: 0.8rem;">
    <div class="card-block table-border-style" style="padding-top:5px;">
        <div class="table-responsive table-short" >
            <table class="table" id="myTable">
                <thead>
                    <tr>
                        <td colspan = "2" style="    padding: 0;    border: none;    text-align: left;">
                            <div class="card" style="padding:0rem .5rem;    margin-bottom: 0rem;">
                                <div class="card-header" style="padding: 0;">
                                    <div class="col-md-3">
                                        <h5 id="bio_sync" style="margin: 0; margin-bottom:.3rem;">Visitor Info</h5>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </thead>
                <tbody> 
                    <?php if($emp_details!=""){while($visit_data = mysqli_fetch_assoc($emp_details)){
                        $v_slutation = "";
                        $v_name= "";
                        $v_company = "";
                            $v_id = $visit_data['visitor_id'];
                            $v_details = mysqli_fetch_assoc(mysqli_query($conn, "select * from `visitor_info` where `visitor_id` = '$v_id'"));
                            if($v_details!=""){
                                $v_slutation=$v_details['salutation'];
                                $v_name = ucfirst($v_details['name']);
                                $v_company =$v_details['com_name'];

                            }
                        ?>
                    <tr>
                        <td style="padding:0;    border: none;    border-bottom: 1px solid #d5e1e1">
                            <Span style="color:#1d7802; font-family:time-new-roman; font-size:25px;  "><?php echo $v_slutation." ".  $v_name;?> comes to visit with you from <?php echo $v_company;?> company Please check it ............. </Span>
                        </td>
                            
                        <td style="padding:1px;width: 10%;  border: none;    border-bottom: 1px solid #d5e1e1">
                            <form action="visitor_app_rej_details.php" method="post">
                                <input type="hidden" name="v_id" value="<?php echo $visit_data['visit_uid'];?>">
                                <button class="btn waves-effect waves-light btn-primary btn-outline-primary" name = "view_v" style="padding: 4px 11px 4px 11px;" id="total-visit-purpose"><i class="icofont icofont-eye-alt"></i>View</button>
                            </form>
                            
                        </td>
                    </tr>
                    <?php }}?>
                </tbody>
            </table>
        </div>
    </div>
    </div>
<?php }?>