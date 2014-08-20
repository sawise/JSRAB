<?php
	require_once('../config.php');
	
	$db = new Db();
		
  	if (isset($_POST) && isset($_POST['username'])) {
		$username = $_POST['username'];
		$password = hash('sha256', $_POST['password'].SALT);
		
		$db_username = $db->getUsername($username);
		$db_password = $db->getPassword($password);
		
		if (count($db_username) > 0) {		
			if ($db_username->username == $username) {
				if (count($db_password) > 0) {
					if ($db_password->password == $password) {
						$_SESSION['is_logged_in'] = true;
						$_SESSION['user_username'] = $db_username->username;
                      	$_SESSION['user_id'] = $db_username->id;
						
						if (isset($_SESSION['return_to'])) {
							$return_to = $_SESSION['return_to'];
							$_SESSION['return_to'] = null;
							header('location: '.$return_to);
						} else {
							$year = time() + 31536000;
							header('location: index.php');
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
		} else {
				set_feedback("error", "Wrong username or password.");
		}
  	}

  	$page_title = "Log in";
?>
<?php require_once(ROOT_PATH.'/header.php'); ?>

	<section>
    	<div class="login-form">
        	<form role="form" method="post" action="login.php">
            	<div class="form-group">
                <label class="sr-only" for="username"></label>
                     <input type="text" class="form-control" id="username" name="username" placeholder="Username" />
                </div>
                <div class="form-group">
               		<label class="sr-only" for="password"></label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" />
              	</div>
                <div class="form-group" id="login-button-group">
      				<button class="btn btn-primary" type="submit" id="login-button">Log in</button>
                </div>
    		</form>
        </div>
   	</section>

<?php require_once(ROOT_PATH.'/footer.php'); ?>