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
$('input[list]').on('input', function(e) {
  var $input = $(e.target),
    list = $input.attr('list'),
    $options = $('#' + list + ' option'),
    $hiddenInput = $('#' + $input.attr('id') + '-hidden'),
    inputValue = $input.val();

  $hiddenInput.val(inputValue);

  $options.each(function() {
    var $option = $(this);

    // console.log('Data-value:', $option.data('value'));

    if ($option.val().toLowerCase() === inputValue.toLowerCase()) {

      $hiddenInput.val($option.data('value'));
      return false; // Break the loop
    }
  });
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
<script src="assets/js/developer_8.js "></script>

<script src="assets/js/clock1.js"></script>


<?php if(isset($_SESSION['status']) && $_SESSION['status']!=''){ ?>
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
  }?>