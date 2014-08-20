<?php
	require_once('../config.php');
	$db = new Db();	
	
    $customer = $db->getUser($_GET['userid']);
    $tiretread = $db->getUser($_GET['userid']);
    $tiresize = $db->getUser($_GET['userid']);
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

    	<div class="searchInputt">
    	<?php if(isset($_GET['userid'])) : ?>
             <?php $user = $db->getUser($_GET['userid']); ?>
            Redigera användare
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
    	<?php endif ?>
        <?php if(isset($_GET['customerId'])) : ?>
            Redigera kund
            <form role="form" method="post" action="editaccount.php">
            <?php echo hidden_input('customerid', $_GET['customerid']); ?>
                <div class="form-group">
                <label class="sr-only" for="customername"></label>
                     <input type="text" class="form-control" id="username" name="username" placeholder="" value="<?php echo $user->username ?>" />
                </div>
                <div class="form-group" id="login-button-group">
                    <button class="btn btn-primary" type="submit" id="login-button">Spara</button>
                </div>
            </form>
        <?php endif ?>
        <?php if(isset($_GET['tiretreadid'])) : ?>
            Redigera däckmönster
            <form role="form" method="post" action="editaccount.php">
            <?php echo hidden_input('id', $_GET['tiretreadid']); ?>
                <div class="form-group">
                <label class="sr-only" for="name"></label>
                     <input type="text" class="form-control" id="username" name="username" placeholder="" value="<?php echo $user->username ?>" />
                </div>
                <div class="form-group" id="login-button-group">
                    <button class="btn btn-primary" type="submit" id="login-button">Spara</button>
                </div>
            </form>
        <?php endif ?>
        <?php if(isset($_GET['tiresizeid'])) : ?>
            Redigera däckstorlek
            <form role="form" method="post" action="editaccount.php">
            <?php echo hidden_input('id', $_GET['tiresizeid']); ?>
                <div class="form-group">
                <label class="sr-only" for="name"></label>
                     <input type="text" class="form-control" id="username" name="username" placeholder="" value="<?php echo $user->username ?>" />
                </div>
                <div class="form-group" id="login-button-group">
                    <button class="btn btn-primary" type="submit" id="login-button">Spara</button>
                </div>
            </form>
        <?php endif ?>
        </div>
        <script>
        
        $(document).ready(
            function() {
                var contentInDiv = $( "div.searchInputt" ).html().trim();
                if(contentInDiv == "" || contentInDiv == null){
                    $("div.searchInputt").text('Du måste välja något att redigera..');
                }      
            }
        );
        </script>
