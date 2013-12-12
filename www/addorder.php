 <div class="alignleft">	
 <?php 

   $tireTreads = $db->getTiretreads();
   $tireSize = $db->getTiresize();
   $toggleThrArray = array('tirethreadText-', 'tirethread'); 
   $toggleDimArray = array('dimensionText-', 'dimension'); 
 ?>
<script>
  $(function() {
    $( "#datepicker" ).datepicker({
      showWeek: true,
      firstDay: 1
    });
  });
  
$(function() {
    $( document ).tooltip();
  });

$(document).ready(function(){
  var tireText = document.getElementById('tirethreadText-');
   var dimText = document.getElementById('dimensionText-');
	tireText.style.display = 'none';
	dimText.style.display = 'none';
});




  </script> 
 <form class="form-horizontal"  method="post" action="">
 	 <fieldset>
 		 <?php echo form_input('text', 'datepicker', 'Leveransdatum:', 'Tryck här för att välja datum') ?>
		 <?php echo form_input('text', 'company', 'Kund:', 'Kundnamn') ?>
		 <?php echo form_select('tirethread', 'Mönster: ', $tireTreads, null, 'thread', 'toggle', $toggleThrArray) ?>
		  <?php echo form_input('text', 'tirethreadText', 'Mönster:', 'Skriv in däckmönstret här', '', 'untoggle', $toggleThrArray) ?>
		 <?php echo form_select('dimension', 'Dimension: ', $tireSize, null, 'size','toggle', $toggleDimArray) ?>
		 <?php echo form_input('text', 'dimensionText', 'Dimension:', 'Skriv in dimensionen här', '', 'untoggle', $toggleDimArray) ?>
		 <?php echo form_input('text', 'total', 'Antal:','ex. 1' ) ?>
		 <?php echo text_area('notes', 'Kommentar: ', 'Ordernummer, följenummer mm'); ?>
		 <?php echo submit_button("Spara") ?>
	 </fieldset>
 </form>
 </div>