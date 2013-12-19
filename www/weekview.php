
<?php

        require_once('../config.php');
        //require_once('../style.php');
    $db = new Db();

?>
<div class="searchResult">
	<?php
   echo yearView($db); ?>
</div>