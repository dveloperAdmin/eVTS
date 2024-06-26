<?php
include '../include/_dbconnect.php';
$user_id = $_SESSION['user_id'];
$user_data_sql = mysqli_fetch_assoc(mysqli_query($conn, "select * from `user` where `uid`='$user_id'"));
?>
<style>
.closebtn {
  margin-left: 15px;
  color: white;
  font-weight: bold;
  float: right;
  font-size: 22px;
  line-height: 20px;
  cursor: pointer;
  transition: 0.3s;
  padding-right: 1%;
}

.closebtn:hover {
  color: black;
}

#connection_sts {
  margin: initial;
  font-size: 1.3em;
  text-align: center;
  font-family: monospace;
  font-weight: 600;
}
</style>

<nav class="navbar header-navbar pcoded-header">
  <div class="navbar-wrapper">
    <div id="alert_show">
      <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
      <p id="connection_sts"></p>

    </div>
    <div class="navbar-logo">
      <a class="mobile-menu waves-effect waves-light" id="mobile-collapse" href="#!">
        <i class="ti-align-right" style="font-weight:bolder"></i>
      </a>
      <div class="mobile-search waves-effect waves-light">
        <div class="header-search">
          <div class="main-search morphsearch-search">
            <div class="input-group">
              <span class="input-group-prepend search-close"><i class="ti-close input-group-text"></i></span>
              <input type="text" class="form-control" placeholder="Enter Keyword">
              <span class="input-group-append search-btn"><i class="ti-search input-group-text"></i></span>
            </div>
          </div>
        </div>
      </div>
      <a href="index.php">
        <h5 class="lineUp" style="text-transform: none;font-family: 'El Messiri', sans-serif;font-size:2.5rem;">
          <img class="img-fluid" src="assets/images/favicon.png" alt="Theme-Logo" style="    padding-right: 1rem;" />
          eVTS
        </h5>
      </a>
      <a class="mobile-options waves-effect waves-light">
        <i class="ti-more"></i>
      </a>
    </div>
    <div class="navbar-container container-fluid">
      <ul class="nav-left">
        <li>
          <div class="sidebar_toggle"><a href="javascript:void(0)"><i class="ti-menu"></i></a></div>
        </li>
        <li>
          <h5 id="nav-title">Easy Visitor Tarcking System
            <?php echo $branchNameNav; ?>
          </h5>
        </li>
      </ul>
      <ul class="nav-right">
        <li>

          <span id="date_span"></span>
        </li>
        <li style="width: 8rem;" id="">

          <span id="clock_span"></span>
        </li>
        <li class="user-profile header-notification">
          <a href="#!" class="waves-effect waves-light">
            <img src="assets/images/458.jpg" class="img-radius" alt="User-Profile-Image">
            <span><?php echo $user_data_sql['name']; ?></span>
            <i class="ti-angle-down"></i>
          </a>
          <ul class="show-notification profile-notification">
            <li class="waves-effect waves-light">
              <a href="my_details">
                <i class="ti-user"></i> Profile Details
              </a>
            </li>
            <li class="waves-effect waves-light">
              <a href="change_password.php">
                <i class="ti-settings"></i> Change Password
              </a>
            </li>
            <!-- <li class="waves-effect waves-light">
                            <a href="user-profile.html">
                                <i class="ti-user"></i> Profile
                            </a>
                        </li> -->

            <a href="../include/_logout.php">
              <li class="waves-effect waves-light">
                <i class="ti-lock"></i> Logout
              </li>
            </a>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>