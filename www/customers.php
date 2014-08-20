<?php
	require_once('../config.php');
	 $db = new Db();
	$customers = $db->getCustomers();
   $tireTreads = $db->getTiretreads();
   $tireSizes = $db->getTiresize();


?>

<div class="searchInput">
	<table class="tableusers table-striped">
  <thead>
    <tr>
      <th>Kunder</th>
      <th></th>
    </tr>
  </thead>
    <tbody>
      <?php  foreach ($customers as $customer) : ?>
              <tr>
                <td><?php echo $customer->name ?></td>
                <td>
                <a href="admin.php?editcustomer=<?php echo $customer->id ?>"><i class ="glyphicon glyphicon-edit"></i></a>
                <a href="deletecustomer.php?id=<?php echo $customer->id ?>"><i class ="glyphicon glyphicon-trash"></i></a>
                </td>
                </tr>
      <?php endforeach ?>
  </tbody>
</table>
<table class="tableusers table-striped">
  <thead>
    <tr>
      <th>Däckmönster</th>
      <th></th>
    </tr>
  </thead>
    <tbody>
    
      <?php  foreach ($tireTreads as $tireTread) : ?>
              <tr>
                <td><?php echo $tireTread->name ?></td>
                <td>
                <a href="admin.php?edittiretread=<?php echo $tireTread->id ?>"><i class ="glyphicon glyphicon-edit"></i></a>
                <a href="deletetiretread.php?id=<?php echo $tireTread->id ?>"><i class ="glyphicon glyphicon-trash"></i></a>
                </td>
                </tr>
      <?php endforeach ?>
  </tbody>
</table>
<table class="tableusers table-striped">
  <thead>
    <tr>
      <th>Däckstorlekar</th>
      <th></th>
    </tr>
  </thead>
    <tbody>
      <?php  foreach ($tireSizes as $tireSize) : ?>
              <tr>
                <td><?php echo $tireSize->name ?></td>
                <td>
                <a href="admin.php?edittiresize=<?php echo $tireSize->id ?>"><i class ="glyphicon glyphicon-edit"></i></a>
                <a href="deletetiresize.php?id=<?php echo $tireSize->id ?>"><i class ="glyphicon glyphicon-trash"></i></a>
                </td>
                </tr>
      <?php endforeach ?>
  </tbody>
</table>
</div>
    


