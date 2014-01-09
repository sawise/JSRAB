  <?php

        require_once('../config.php');
  //require_once('../style.php');

?>
<?php if(isset($_SESSION['search'])) : ?>   
	<?php $searchresults = $_SESSION['search'];
	echo showTooltip($searchresults); ?>
<?php endif ?>



  <div class="searchInput">
	         <form method="get" action="searchcaller.php">
	         <input id="search" name="search" type="text" placeholder="" value="<?php echo $_SESSION['searchstring'] ?>" class="input-xxlarge search-query">
			    <button type="submit" class="btn">Sök</button>	
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
			                <td><?php echo tooltipButton($searchresult); ?></td>
			               
			 			</tr>
			 		<?php endforeach ?>
					</tbody>
			 		</table>
			 		<div id="large"></div>

			<?php $_SESSION['search'] = null;$_SESSION['searchstring'] = null; ?>
		 <?php endif ?>
		</div>


		