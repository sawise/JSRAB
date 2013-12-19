<?php 
  require_once('../config.php');
  $year = $_GET['year'];
  $week = $_GET['week'];
  $db = new Db();
  $searchresults = $db->searchyear($year);
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
					<td><a href="orderdetails.php" class="btn btn-mini btn-primary btn-Action" type="button">Mer info</button></a></td>
				</tr>
			<?php endif ?>
		<?php endforeach ?>
		</tbody>
	</table>
</div>