 <div class="alignleft paddingInTab">	
 <?php 
require_once('../../config.php');
//require_once('../style.php');
$db = new Db();
   $tireTreads = $db->getTiretreads();
   $tireSize = $db->getTiresize();
   $customers = $db->getCustomers();
 ?>
<script>
  $(function() {
    $( "#datepicker" ).datepicker({
      showWeek: true,
      firstDay: 1,
       dateFormat: 'yy-mm-dd'
    });
  });

  $(function() {
	    var tireTreads = [
	    <?php for ($i = 0; $i < count($tireTreads); $i++){
	    	echo '"'.$tireTreads[$i]->name.'"';
	    	if($i < count($tireTreads)-1){
	    		echo ',';
	    	}
	    } ?>
	    ];

	    var customers = [
	    <?php for ($i = 0; $i < count($customers); $i++){
	    	echo '"'.$customers[$i]->name.'"';
	    	if($i < count($customers)-1){
	    		echo ',';
	    	}
	    } ?>
	    ];

	    var tireSize = [
	    <?php for ($i = 0; $i < count($tireSize); $i++){
	    	echo '"'.$tireSize[$i]->name.'"';
	    	if($i < count($tireSize)-1){
	    		echo ',';
	    	}
	    } ?>
	    ];

 $( "#customer" ).autocomplete({
      source: customers
    });

    $( "#dimension" ).autocomplete({
      source: tireSize
    });

    $( "#tirethreads" ).autocomplete({
      source: tireTreads
    });
  });

$(function() {
    $( document ).tooltip();
  });

//$(document).ready(function(){
  //var tireText = document.getElementById('tirethreadText-');
   //var dimText = document.getElementById('dimensionText-');
	//tireText.style.display = 'none';
	//dimText.style.display = 'none';
//});




  </script> 
 <form class="form-horizontal" method="post" action="createOrder.php">
 	 <fieldset>
 	 <?php echo hidden_input('user_id', $_SESSION['user_id']); ?>
 		 <?php echo form_input('text', 'datepicker', 'Leveransdatum:', 'Tryck här för att välja datum') ?>
		 <?php echo form_input('text', 'customer', 'Kund:', 'Kundnamn') ?>
		  <?php echo form_input('text', 'dimension', 'Dimension:', 'Skriv in dimensionen här', '') ?>
		 <?php echo form_input('text', 'tirethreads', 'Mönster:', 'Skriv in mönster här', '') ?>
		 <?php echo form_input('text', 'total', 'Antal:','ex. 1' ) ?>
		 <?php echo text_area('notes', 'Kommentar: ', 'Ordernummer, följenummer mm'); ?>
		 <?php echo submit_button("Spara") ?>
	 </fieldset>
 </form>
 </div>