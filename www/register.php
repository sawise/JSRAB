<?php
	require_once('../../config.php');
	$register = true;	
if (isset($_POST) && isset($_POST['username'])) {
	$db = new Db();

	$username = $_POST['username'];
	$password = hash('sha256', $_POST['password'].SALT);
	$createduser = $db->createUser($username, $password);

	if($createduser != null){
		set_feedback("success", "Kontot skapades.");
			header('location: admin.php');
	}
}
?>

    	<div class="searchInput">
        	<form role="form" method="post" action="register.php">
            	<div class="form-group">
                <label class="sr-only" for="username"></label>
                     <input type="text" class="form-control" id="username" name="username" placeholder="Username" />
                </div>
                <div class="form-group">
               		<label class="sr-only" for="password"></label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" />
              	</div>
                <div class="form-group" id="login-button-group">
      				<button class="btn btn-primary" type="submit" id="login-button">Create account</button>
                </div>
    		</form>
        </div>
