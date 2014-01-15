
  <?php 

        require_once('../config.php');
  //require_once('../style.php');

?>
<script>
$(function() {
    $( "#yeartabs" ).tabs({
      beforeLoad: function( event, ui ) {
        ui.jqXHR.error(function() {
          ui.panel.html(
            "Couldn't load this tab. We'll try to fix this as soon as possible. ");
        });
      }
    });
    $("div.ui-tabs-panel").css('padding','0px');
  });
</script>

<?php echo yearView(); ?>

   

       