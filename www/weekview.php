<?php  $orders = array(array(1111, "Åkes D/S", "BDR-W+" , "315/80-22,5", 8),
               array(1112, "daiKalles Däcksy", "BDR-HG", "315/70-22,5" , 4),
               array(1113, "Däckia Kalmar", "bdy", "10.00-20" , 4),
               array(1114, "LINKÖPINGS DÄCKCENTRAL", "B104", "265/70-19,5" , 2),
               array(1115, "Olles D/S", "BDR-W+", "295/80-22,5" , 4)); ?>
  <div class="searchInput">
	        
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
<div class="pagination">
  <ul>
    <li class="disabled"><a href="#"><i class="icon-backward"></i></a></li>
    <li class="active"><a href="#">v1</a></li>
    <li class="active"><a href="#">v2</a></li>
    <li class="active"><a href="#">v3</a></li>
    <li class="active"><a href="#">v4</a></li>
    <li class="active"><a href="#">v5</a></li>
    <li class="disabled"><a href="#"><i class="icon-forward"></i></a></li>
  </ul>
</div>
		</div>