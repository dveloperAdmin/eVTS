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
<script src="assets/js/developer9.js "></script>

<script src="assets/js/clock1.js"></script>
<script src="assets/js/networkconn.js"></script>
<script>
$("#searchInput").keyup(function() {
  var searchText = $(this).val().toLowerCase();

  $("#dataTable tbody tr").each(function() {
    var rowData = $(this).text().toLowerCase();
    if (rowData.indexOf(searchText) === -1) {
      $(this).hide();
    } else {
      $(this).show();
    }
  });
});
</script>

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