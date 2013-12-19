<!DOCTYPE html>
<?php

        require_once('../config.php');
        //require_once('../style.php');
    $db = new Db();

?>


		<div class="searchResult">
			<div class="searchInput">
			 <?php if(isset($_SESSION['createdorder'])){
        			echo $_SESSION['createdorder'];
        			$_SESSION['createdorder'] = null;
      				}
      		 ?>
			</div>
		</div>
