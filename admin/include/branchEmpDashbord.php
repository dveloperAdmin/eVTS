<?php
$first_date = date("Y-m-01");
$last_date = date("Y-m-t");
$today = date("Y-m-d");
$branch_details = mysqli_query($conn, "select * from `branch`");
function generateRandomColorCode()
{

  $color = "#";
  for ($i = 0; $i < 6; $i++) {
    // Generate a random hexadecimal digit (0-9, A-F)
    $color .= dechex(mt_rand(0, 15));
  }
  return $color;
}

// Generate an array of 10 random bright color codes


function generateBrightBlendColors($baseColor, $numStops)
{
  $baseRGB = sscanf($baseColor, "#%02x%02x%02x");
  $output = "linear-gradient(-90deg, ";
  //  #f8ff0073, #78db1e 100%);
  for ($i = 0; $i < $numStops; $i++) {
    $brightness = $i * (100 / ($numStops - 1)); // Adjust brightness from 0% to 100%
    $color = adjustBrightness($baseRGB, $brightness);
    $output .= "rgb(" . implode(",", $color) . ")";
    $output .= ($i < $numStops - 1) ? " 0%, " : "";
  }

  $output .= " 100%);";

  return $output;
}

function adjustBrightness($color, $brightness)
{
  foreach ($color as &$value) {
    $value = max(3, min(255, $value + ($brightness * 1.55))); // Adjust brightness
  }

  return $color;
}


function adjustColorBrightness($color, $targetLuminance = 0.7)
{
  $rgb = sscanf($color, "#%02x%02x%02x");

  $luminance = 0.2126 * $rgb[0] / 255 + 0.7152 * $rgb[1] / 255 + 0.0722 * $rgb[2] / 255;

  if ($luminance < $targetLuminance) {
    // Adjust the color to make it brighter
    $adjustmentFactor = $targetLuminance / $luminance;

    foreach ($rgb as &$value) {
      $value = min(255, $value * $adjustmentFactor);
    }

    return sprintf("#%02x%02x%02x", $rgb[0], $rgb[1], $rgb[2]);
  }

  return $color;
}
$color = generateRandomColorCode();
// echo adjustColorBrightness($color, $targetLuminance = 0.7);


?>
<!-- date("Y-m-t") -->

<div class="page-body">
  <!-- sale card start -->
  <?php for ($i = 0; $i < mysqli_num_rows($branch_details); $i++) {
    $branch_name = "";
    $branch_detais = mysqli_fetch_assoc($branch_details);
    $num_visit_as_branch = "";
    if ($branch_detais != "") {
      $branch_name = $branch_detais["branch_name"];
      $branch_code = $branch_detais["branch_code"];
      $num_visit_as_branch = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total_employees, COUNT(CASE WHEN Status = 'Working' THEN 1 END) AS working_employees, COUNT(CASE WHEN Status = 'Resign' THEN 1 END) AS resigned_employees FROM eomploye_details where `BranchId` = '$branch_code'"));



    }



    ?>
    <div class="row">
      <div class="col-xl-6 col-md-12" style="max-width: 62%;flex: 0 0 62%;">
        <div class="row">
          <div class="col-md-6" style="max-width: 60%;flex: 0 0 49%;">
            <div class="card text-center order-visitor-card"
              style="background: linear-gradient(-90deg, <?php echo adjustColorBrightness(generateRandomColorCode(), $targetLuminance = 0.7); ?> 0% , <?php echo adjustColorBrightness(generateRandomColorCode(), 0.7); ?> 100%">
              <div class="card-block dsh-card">
                <i class="icofont icofont-ui-user-group" style="font-size:4.5rem; margin-right:1rem;"></i>
                <div class="card-text">
                  <h6 class="m-b-0 m-b-275" style="font-size: 1.1rem;margin-left:1rem;"> Total Employees <br>
                    <?php echo strtoupper($branch_name); ?>
                  </h6>
                  <h4 class="m-t-15 m-b-15"><?php echo $num_visit_as_branch['total_employees']; ?></h4>
                  <p class="m-b-0"></p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6" style="max-width: 50%;flex: 0 0 50%;">
            <div class="card text-center order-visitor-card"
              style="background: linear-gradient(-90deg, <?php echo adjustColorBrightness(generateRandomColorCode(), $targetLuminance = 0.7); ?> 0% , <?php echo adjustColorBrightness(generateRandomColorCode(), 0.7); ?> 100%">
              <div class="card-block dsh-card">
                <i class="icofont icofont-business-man-alt-1" style="font-size:4.5rem; margin-right:.6rem;"><i
                    class="icofont icofont-pen-alt-1"></i></i>
                <div class="card-text">
                  <h6 class="m-b-0 m-b-275" style="font-size: 1.1rem;margin-left:1rem;"> Working Employees
                    <br>
                    <?php echo strtoupper($branch_name); ?>
                  </h6>
                  <p class="m-b-0"></p>
                  <h4 class="m-t-15 m-b-15"><?php echo $num_visit_as_branch['working_employees']; ?></h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-6 col-md-12" style="max-width: 44%;flex: 0 0 38%;">
        <div class="row">

          <div class="col-md-6" style="max-width: 77%;flex: 0 0 77%;">
            <div class="card text-center order-visitor-card"
              style="background: linear-gradient(-90deg, <?php echo adjustColorBrightness(generateRandomColorCode(), $targetLuminance = 0.7); ?> 0% , <?php echo adjustColorBrightness(generateRandomColorCode(), 0.7); ?> 100%">
              <div class="card-block dsh-card">
                <i class="icofont icofont-wheelchair" style="font-size:4.5rem; margin-right:1rem;"></i>
                <div class="card-text">
                  <h6 class="m-b-0 m-b-275" style="font-size: 1.1rem;margin-left:1rem;"> Resigned Employees <br>
                    <?php echo strtoupper($branch_name); ?>
                  </h6>
                  <h4 class="m-t-15 m-b-15"><?php echo $num_visit_as_branch['resigned_employees']; ?></h4>
                  <p class="m-b-0"></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- </div> -->

<?php } ?>


</div>

<!-- <div class="col-xl-6 col-md-12">
    <div class="row">
        sale card start -
        <?php ?> 

    
        <div class="col-md-6">
            <div class="card text-center order-visitor-card" style="background: <?php echo $blend2; ?>">
                <div class="card-block dsh-card">
                <i class="icofont icofont-users-social m-r-15 text-c-black" style="font-size:3rem"></i>
                <div class="card-text">
                    <h6 class="m-b-0 m-b-275"> TOTAL VISITORS</h6>
                    <!-- <h4 class="m-t-15 m-b-15"><?php echo $sql_total_no_of_v_month; ?></h4> 
                    <p class="m-b-0"></p>
                </div>
                </div>
            </div>
        </div>
        
    </div>
</div> -->