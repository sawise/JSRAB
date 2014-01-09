<?php 
  require_once('../config.php');
  $year = $_GET['year'];
  $week = $_GET['week'];
  $db = new Db();
  $searchresults = $db->searchyear($year);
  echo showTooltip($searchresults);
?>	
<style> #Ubuntufont { font-size: 0.7em; font-family: 'Ubuntu Mono';}</style>
<div class="searchResult Ubuntufont">
	<table class="table table-striped">
		<thead>
			<th>Leveransdatum</th>
			<th>Företag/Kund</th>
			<th>Mönster</th>
			<th>Dimension</th>
			<th>Antal</th>
			<th></th>
		</thead>
		<tbody>
		<?php foreach($searchresults as $searchresult) : ?>
			<?php if (getWeek($searchresult->deliverydate) == $week) : ?>
				<tr>
				<td><?php echo getWeekday($searchresult->deliverydate) ?></td>
					<td><?php echo $searchresult->customer_name ?></td>
					<td><?php echo $searchresult->tiretread_name ?></td>
					<td><?php echo $searchresult->tiresize_name ?></td>
					<td><?php echo $searchresult->total ?></td>
					<td><a class="tooltip_display_<?php echo $searchresult->id ?> btn btn-mini btn-primary btn-Action" href="#" type="button">Mer info</button></a></td>
					 <div class="ttip_<?php echo $searchresult->id ?>">
							  <div class="contents_<?php echo $searchresult->id ?>">
							  <p>Leveransdatum: <?php echo $searchresult->customer_name ?></p>
								 <p>Kund: <?php echo $searchresult->customer_name ?></p>
					              <p>Däckmönster: <?php echo $searchresult->tiretread_name ?></p>
					              <p>Däckstorlek: <?php echo $searchresult->tiresize_name ?></p>
					              <p>Antal: <?php echo $searchresult->total ?></p>
					               <p>Kommentarer<br><?php 
					               $ordernumberArray = explode(",", $searchresult->comments); 
								      for ($i=0; $i < count($ordernumberArray) ; $i++) { 
								        $arrayCount = count($ordernumberArray);
								        if($i == 0){
								          echo '<p>Ordernummer: '.$ordernumberArray[$i].'<p>';
								          echo '<p>Följenummer: '.$i;
								        } else if($i == $arrayCount-1) {
								           echo $ordernumberArray[$i].'<p>'; 
								        } else {
								          echo $ordernumberArray[$i].',';
								        } 
							      } ?></p>
							  </div>
							  <span class="note_<?php echo $searchresult->id ?>">(click here to close the box)</span> 
							</div>
				</tr>
			<?php endif ?>
		<?php endforeach ?>
		</tbody>
	</table><div id="large"></div>
</div>