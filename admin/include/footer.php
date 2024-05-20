<script>
  document.getElementById("alert_show").style.display = "none";
  window.addEventListener("online", onFunction);
  window.addEventListener("offline", offFunction);

  function onFunction() {
    document.getElementById("alert_show").style.cssText = "display: block; background:#53e600; color:#fff;";
    document.getElementById("connection_sts").innerHTML = "Back to Online.";
  }

  function offFunction() {
    document.getElementById("alert_show").style.cssText = "display: block; background:red; color:#fff;";
    document.getElementById("connection_sts").innerHTML = "Your are Offline.";
  }
  $("#searchInput").keyup(function () {
    var searchText = $(this).val().toLowerCase();

    $("#dataTable tbody tr").each(function () {
      var rowData = $(this).text().toLowerCase();
      if (rowData.indexOf(searchText) === -1) {
        $(this).hide();
      } else {
        $(this).show();
      }
    });
  });

  $("#appBranch").change(function () {
    let branchValue = $(this).val();
    var formData = new FormData();
    formData.append("branchValue", branchValue);
    $.ajax({
      url: "ajax.php", // Update the URL to your server-side script
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        if (response.error) {
          console.log('Error:', response.error);
        } else {
          if (response.AppSts.length) {
            $("#appSts").val(response.AppSts).attr({
              disabled: false,
              hidden: false
            }).text(response.AppSts);

          }
          if (response.camSts.length) {
            $("#camSts").val(response.camSts).attr({
              disabled: false,
              hidden: false
            }).text(response.camSts);
          }
          if (response.emailSts.length) {
            $("#emailSts").val(response.emailSts).attr({
              disabled: false,
              hidden: false
            }).text(response.emailSts);

          }
          if (response.metEndRefSts.length) {
            $("#reffSts").val(response.metEndRefSts).attr({
              disabled: false,
              hidden: false
            }).text(response.metEndRefSts);

          }
        }
      },
      error: function (xhr, status, error) {
        console.error('AJAX Error:', status, error);
      }
    })
  });
</script>
<script type="text/javascript" src="assets/js/jquery/jquery.min.js "></script>
<script type="text/javascript" src="assets/js/jquery-ui/jquery-ui.min.js "></script>
<script type="text/javascript" src="assets/js/popper.js/popper.min.js"></script>
<script type="text/javascript" src="assets/js/bootstrap/js/bootstrap.min.js "></script>
<!-- waves js -->
<script src="assets/pages/waves/js/waves.min.js"></script>
<!-- jquery slimscroll js -->
<script type="text/javascript" src="assets/js/jquery-slimscroll/jquery.slimscroll.js"></script>

<!-- slimscroll js -->
<script src="assets/js/jquery.mCustomScrollbar.concat.min.js "></script>

<!-- menu js -->
<script src="assets/js/pcoded.min.js"></script>
<script src="assets/js/vertical/vertical-layout.min.js "></script>

<script type="text/javascript" src="assets/js/script.js "></script>
<script src="assets/js/developer_9.js "></script>
<script src="assets/js/clock.js"></script>


<?php if (isset($_SESSION['status']) && $_SESSION['status'] != '') { ?>
  <script>
    Swal.fire({
      icon: '<?php echo $_SESSION['icon'] ?>',
      title: '<?php echo $_SESSION['status'] ?>',
      showCloseButton: true,
      confirmButton: true,

    })
  </script>
  <?php
  unset($_SESSION['status']);
  unset($_SESSION['icon']);
} ?>