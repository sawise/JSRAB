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
			                <td><a class="tooltip_display_<?php echo $searchresult->id ?> btn btn-mini btn-primary btn-Action" href="#" type="button">Mer info</button></td>
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
							</div>
			 			</tr>
			 		<?php endforeach ?>
					</tbody>
			 		</table>
			 		<div id="large"></div>

			<?php //$_SESSION['search'] = null;$_SESSION['searchstring'] = null; <-- class="btn btn-mini btn-primary btn-Action" type="button"--> ?>
		 <?php endif ?>
		</div>


		