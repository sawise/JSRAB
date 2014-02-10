<?php
	require_once('../../config.php');
	$db = new Db();	
	$user = $db->getUser($_GET['userid']);
if (isset($_POST['username'])) {
	$id = $_POST['userid'];
	$username = $_POST['username'];
	$password = hash('sha256', $_POST['password'].SALT);	
	$editUser = $db->updateUser($id, $username, $password);
	if($editUser){
		set_feedback("success", $editUser);
		header('location: admin.php');
	} else {
		echo $editUser;
		//set_feedback("error", "Ändringarna är inte sparade.");
		//header('location: admin.php');
	}
}
?>

    	<div class="searchInput">
    	<?php if(isset($_GET['userid'])) : ?>
        	<form role="form" method="post" action="editaccount.php">
        	<?php echo hidden_input('userid', $_GET['userid']); ?>
            	<div class="form-group">
                <label class="sr-only" for="username"></label>
                     <input type="text" class="form-control" id="username" name="username" placeholder="" value="<?php echo $user->username ?>" />
                </div>
                
                <div class="form-group">
               		<label class="sr-only" for="password"></label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" />
              	</div>
                <div class="form-group" id="login-button-group">
      				<button class="btn btn-primary" type="submit" id="login-button">Spara</button>
                </div>
    		</form>
    	<?php else : ?>
    		Välj ett konto via "Alla konton"
    	<?php endif ?>
        </div>
