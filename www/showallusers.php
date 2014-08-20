<?php
	require_once('../config.php');
	 $db = new Db();
	$users = $db->getUsers();


?>

<div class="searchInput">
	<table class="tableusers table-striped">
<thead>
  <tr>
    <th>Användarnamn</th>
    <th></th>
  </tr>
  </thead>
  <tbody>
  <?php  foreach ($users as $user) : ?>
          <tr>
            <td><?php echo $user->username ?></td>
            <td>
              <a href="admin.php?editaccount=<?php echo $user->id ?>"><i class ="glyphicon glyphicon-edit"></i></a>
              <a href="deleteaccount.php?id=<?php echo $user->id ?>"><i class ="glyphicon glyphicon-trash"></i></a>
            </td>
            </tr>
  <?php endforeach ?>
</tbody>
</table>
</div>
    


