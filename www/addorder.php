 <div class="alignleft">	
 <?php 
 	$items = array("BDR-W+","BDR-HG", "bdy", "B104", "BDR-W+"); 
 	$itemss = array("315/80-22,5","315/70-22,5" , "10.00-20" ,"265/70-19,5", "295/80-22,5"); 
 ?>
 
 <form class="form-horizontal"  method="post" action="">
 	 <fieldset>
		 <?php echo form_input('text', 'ordernumber', 'Ordernummer:', '', "" ) ?>
		 <?php echo form_input('text', 'company', 'Företag/Kund:', '', "" ) ?>
		 <?php echo form_select('monster', 'Mönster: ', $items) ?>
		 <?php echo form_select('monster', 'Dimension: ', $itemss) ?>
		 <?php echo form_input('text', 'total', 'Antal:', '', "" ) ?>
		 <?php echo text_area('notes', 'Kommentar: '); ?>
		 <?php echo submit_button("Spara") ?>
	 </fieldset>
 </form>
 </div>