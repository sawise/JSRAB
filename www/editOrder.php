 <div class="alignleft paddingInTab">	
 <?php 
require_once('../config.php');
//require_once('../style.php');
$db = new Db();
$tireTreads = $db->getTiretreads();
$tireSize = $db->getTiresize();
$customers = $db->getCustomers();
$order = '';
if(isset($_GET['orderId'])){
	$order = $db->getOrder($_GET['orderId']); 
}
  
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
	    	echo '"'.$tireTreads[$i]->id.'->'.$tireTreads[$i]->name.'"';
	    	if($i < count($tireTreads)-1){
	    		echo ',';
	    	}
	    } ?>
	    ];

	    var customers = [
	    <?php for ($i = 0; $i < count($customers); $i++){
	    	echo '"'.$customers[$i]->id.'->'.$customers[$i]->name.'"';
	    	if($i < count($customers)-1){
	    		echo ',';
	    	}
	    } ?>
	    ];

	    var tireSize = [
	    <?php for ($i = 0; $i < count($tireSize); $i++){
	    	echo '"'.$tireSize[$i]->id.'->'.$tireSize[$i]->name.'"';
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
    <?php if(!isset($_GET['orderId'])) : ?>
    		<?php echo 'Välj en order via sök eller veckoöversikt!' ?>
    	<?php endif ?>

  <?php if(isset($_GET['orderId'])) : ?>
	 <form class="form-horizontal" method="post" action="updateOrder.php">
	 	 <fieldset>
	 	 <?php $tirethread = $order->tiretreadID.'->'.$order->tiretread_name;
	 	 $customername = $order->customerID.'->'.$order->customer_name;
	 	 $tiresize = $order->tiresizeID.'->'.$order->tiresize_name; ?>
	 	 	<?php echo hidden_input('id', $order->id); ?>
	 		 <?php echo form_input('text', 'datepicker', 'Leveransdatum:', 'Tryck här för att välja datum', $order->deliverydate) ?>
			 <?php echo form_input('text', 'customer', 'Kund:', 'Kundnamn', $customername) ?>
			  <?php echo form_input('text', 'dimension', 'Dimension:', 'Skriv in däckmönstret här', $tirethread) ?>
			 <?php echo form_input('text', 'tirethreads', 'Mönster:', 'Skriv in mönster här', $tiresize) ?>
			 <?php echo form_input('text', 'total', 'Antal:','ex. 1', $order->total ) ?>
			 <?php echo text_area('notes', 'Kommentar: ', 'Ordernummer, följenummer mm', $order->comments); ?>
			 <?php echo submit_button("Spara") ?>
		 </fieldset>
 </form>
<?php endif ?>
 </div>