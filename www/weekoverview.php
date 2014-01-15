
<?php
 require_once('../config.php');
	$year = $_GET['year'];
	?>

<script>
  $(function() {
    $( "#weektabs_<?php echo $year ?>" ).tabs({
      beforeLoad: function( event, ui ) {
        ui.jqXHR.error(function() {
          ui.panel.html(
            "Couldn't load this tab. We'll try to fix this as soon as possible. " +
            "If this wouldn't be a demo." );
        });
      }
    });
    $("div.ui-tabs-panel").css('padding','0px');
  });
</script>

<?php
	echo weekView($year);
 ?>