<?php 
  require_once('../config.php');
  $year = $_GET['year'];
  $db = new Db();
  $searchresults = $db->searchyear($year);
?>	

<div class="searchResult">
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
			<tr>
			<td><?php echo getWeekday($searchresult->deliverydate) ?></td>
				<td><?php echo $searchresult->customer_name ?></td>
				<td><?php echo $searchresult->tiretread_name ?></td>
				<td><?php echo $searchresult->tiresize_name ?></td>
				<td><?php echo $searchresult->total ?></td>
				<td><a href="#" class="btn btn-mini btn-primary btn-Action" type="button">Mer info</button></a></td>
			</tr>
		<?php endforeach ?>
		</tbody>
	</table>
</div>