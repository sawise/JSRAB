<?php  $orders = array(array(1111, "Åkes D/S", "BDR-W+" , "315/80-22,5", 8),
               array(1112, "daiKalles Däcksy", "BDR-HG", "315/70-22,5" , 4),
               array(1113, "Däckia Kalmar", "bdy", "10.00-20" , 4),
               array(1114, "LINKÖPINGS DÄCKCENTRAL", "B104", "265/70-19,5" , 2),
               array(1115, "Olles D/S", "BDR-W+", "295/80-22,5" , 4)); 
              ?>

  <div class="searchInput">
	         <form method="get" action="searchcaller.php">
	         <input id="search" name="search" type="text" placeholder="" class="input-xxlarge search-query">
			    <button type="submit" class="btn">Search</button>	
		</form>
		</div>
<?php if(isset($_SESSION['search'])) : ?>   
			<?php $searchresults = $_SESSION['search']; ?>
	      <div class="searchResult"><table class="table table-striped">
	 		<thead><th>Leveransdatum<th>Företag/Kund<th>Mönster</th><th>Dimension</th><th>Antal</th><th></th></thead>
	 		 <tbody><?php foreach($searchresults as $searchresult) : ?>
	            <tr>
	                <td><?php echo $searchresult->deliverydate ?></td>
	                <td><?php echo $searchresult->customer_name ?></td>
	                <td><?php echo $searchresult->tiretread_name ?></td>
	                <td><?php echo $searchresult->tiresize_name ?></td>
	                <td><?php echo $searchresult->total ?></td>
	                <td><a href="#" class="btn btn-mini btn-primary btn-Action" type="button">Mer info</button></td>
	 			</tr>
	 		<?php endforeach ?>
			</tbody>
	 		</table>
 <?php endif ?>
		</div>