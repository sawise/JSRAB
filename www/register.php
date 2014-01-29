<?php
	require_once('../config.php');
	$register = true;	
if (isset($_POST) && isset($_POST['username'])) {
	$db = new Db();

	$username = $_POST['username'];
	$password = hash('sha256', $_POST['password'].SALT);
	$createduser = $db->createUser($username, $password);

	if($createduser != null){
		$db_username = $db->getUsername($username);
		$db_password = $db->getPassword($password);

		if (count($db_username) > 0) {		
			if ($db_username->username == $username) {
				if (count($db_password) > 0) {
					if ($db_password->password == $password) {
						$_SESSION['is_logged_in'] = true;
						$_SESSION['user_username'] = $db_username->username;
						$_SESSION['user_id'] = $db_username->id;
					header('location: index.php');
					} else {
					set_feedback("error", "Wrong username or password.");
					}
				} else {
					set_feedback("error", "Wrong username or password.");
				}
			} else {
				set_feedback("error", "Wrong username or password.");
			}
			} else {
			set_feedback("error", "Wrong username or password.");
	}
}
}
?>
<?php require_once(ROOT_PATH.'/header.php'); ?>

    	<div class="login-form">
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

<?php require_once(ROOT_PATH.'/footer.php'); ?>