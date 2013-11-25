<!DOCTYPE html>
<?php
    require_once('../config.php');
$title = "Sök";

              ?>
<?php require_once(ROOT_PATH.'/header.php');?>
  <body><img src="img/logo.png" class="logo">
<div class="container centered mainDiv">
	<div class="row-fluid">
	<div class="span12">
	<?php echo menu($title); ?>
	  <div class="searchInput">
	         <form>
	         <input type="text" placeholder="" class="input-xxlarge search-query">
			    <button type="submit" class="btn">Search</button>	
			    
		</form>
		</div>
	      <div class="searchResult"><table class="table table-striped">
	 		<thead><th>Ordernummer<th>Företag/Kund<th>Mönster</th><th>Dimension</th><th>Antal</th><th></th></thead>
	 		 <tbody><?php foreach($orders as $order) : ?>
	            <tr>
	                <td><?php echo $order[0] ?></td>
	                <td><?php echo $order[1] ?></td>
	                <td><?php echo $order[2] ?></td>
	                <td><?php echo $order[3] ?></td>
	                <td><?php echo $order[4] ?></td>
	                <td><a href="#" class="btn btn-mini btn-primary btn-Action" type="button">Mer info</button></td>
	 			</tr>
	 		<?php endforeach ?>
			</tbody>
	 		</table>

		</div>
		</div>
	    </div>
  </div>
</div>
  
  </body>


<?php require_once(ROOT_PATH.'/footer.php');?>
