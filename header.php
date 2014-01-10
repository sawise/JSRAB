<html>
  <head>
  <meta charset="UTF-8">

                 
                

  <?php require_once('../style.php') ?>
  <script>
  $(function() {
    $( "#indextabs" ).tabs({
      beforeLoad: function( event, ui ) {
        ui.jqXHR.error(function() {
          ui.panel.html(
            "Couldn't load this tab. We'll try to fix this as soon as possible. " +
            "If this wouldn't be a demo." );
        });
      }
    });
  });

  </script>

  </head>
  <?php echo get_feedback(); ?>