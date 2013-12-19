<html>tirethread
  <head>
  <meta charset="UTF-8">
  <script src="js/jquery-2.0.3.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Tangerine">
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <script>                    
	 $('body').hide();
	  $(window).ready(function() {
	  	$('body').fadeIn(500);               
	  });    
	</script>
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
  <link rel="stylesheet" href="css/style.css" type="text/css">
  <link rel="stylesheet" href="css/bootstrap.css" type="text/css">
  </head>
  <?php echo get_feedback(); ?>