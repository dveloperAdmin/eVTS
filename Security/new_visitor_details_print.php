<?php
include '../include/_dbconnect.php';
include '../include/_session.php';
include '../include/_lic_check.php';
$head = "Visitor Info Print";
$des = "Page Load new_visit_details_print";
$rem = "New visit print process";
include '../include/_audi_log.php';

if (isset($_GET['vid'])) {
    $exit_url = "new_visitor1";
    $id = base64_decode(base64_decode($_GET['vid']));
    $v_log_id = "VSL-" . $id;
    // echo $v_log_id;
    if (isset($_GET['id'])) {
        $exit_url = "view_visitor?id=1";
    }
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
                    <!-- <?php echo $pass; ?> -->
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
                                        <div class="row">
                                            <div class="col-md-6" style="flex:0 0 36%;">

                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5>Visitor Details Print :- &nbsp; <?php echo $id; ?> </h5>
                                                    </div>

                                                    <div class="card-block">

                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label"
                                                                style="flex:0 0 30%; max-width:30%">Print
                                                                Optiopn</label>
                                                            <div class="col-sm-9" style="flex:0 0 69%">
                                                                <select class="form-control" name="" id="url"
                                                                    style="margin-right:1rem;" autofocus>
                                                                    <option value="" selected disabled hidden>Select
                                                                        Print Option</option>
                                                                    <option value="new_visit_token">Short Token Print
                                                                    </option>
                                                                    <option value="new_visit_token_with_rules">Token
                                                                        Print</option>
                                                                    <option value="new_visit_short_recipt">Short Info
                                                                        Print</option>
                                                                    <option value="new_visit_recipt">Info Print</option>
                                                                </select>
                                                            </div>
                                                        </div>



                                                        <div class="form-group row">

                                                        </div>
                                                        <div class="form-group row">

                                                        </div>


                                                        <div class="user-entry">

                                                            <button type="click"
                                                                class="btn waves-effect waves-light btn-inverse btn-outline-inverse"
                                                                id="check_details"><i
                                                                    class="icofont icofont-search"></i>Check
                                                                Details</button>
                                                            <button type="submit"
                                                                class="btn waves-effect waves-light btn-primary btn-outline-primary"
                                                                name="check_in" id="print_url"><i class="fa fa-print"
                                                                    style="    font-size: 20px;margin-right: 10px;"></i>Print</button>
                                                            <a href="<?php echo $exit_url ?>"><button type="reset"
                                                                    class="btn waves-effect waves-light btn-danger btn-outline-danger"><i
                                                                        class="icofont icofont-arrow-right"></i>Exit</button></a>
                                                        </div>


                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-6"
                                                style="padding-left:0px; flex:0 0 63%; max-width: 63%;">
                                                <div class="card " id="contact1">
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


<script>
    $("#print_url").click(function (e) {
        // e.preventDefault();
        var url = $("#url").val();
        url = url + "?id=<?php echo $v_log_id; ?>-";

        printExternal(url);


    })

    function printExternal(url) {
        window.open(url, "print", "width=800, height=800, scrollbars=yes");


    }

    $("#check_details").click(function () {
        let emp = "<?= $id; ?>";
        // console.log(emp);
        if (emp != "") {

            var emp_spl = emp.split(' ');
            let emp_id = 'V_log=' + emp_spl;
            $.ajax({
                type: "POST",
                url: "ajax.php",
                data: emp_id,
                cache: false,
                success: function (cities) {
                    $("#contact1").css("display", "block");
                    $("#contact1").html(cities);
                }
            });
        } else {
            $("#contact1").css("display", "none");
        }

    });
</script>