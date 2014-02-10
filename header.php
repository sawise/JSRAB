<html>
  <head>
  <meta charset="UTF-8">
<title>JS Retreading AB</title>
  <?php require_once(ROOT_PATH.'/style.php') ?>
  <script>
  $(function() {
    $( "#indextabs" ).tabs({
      beforeLoad: function( event, ui ) {
        ui.jqXHR.error(function() {
          ui.panel.html(
            "Couldn't load this tab. We'll try to fix this as soon as possible. " +
            "If this wouldn't be a demo." );
        });
      }
    });
    $("div.ui-tabs-panel").css('padding','0');
  });

  </script>
 
  </head>
  <div class="topright">
           <?php if (isset($_SESSION['is_logged_in']) && isset($_SESSION['user_username']) && !$print) : ?>
                <?php $username = $_SESSION['user_username']; ?>
                  <div class="well well-small" id="user_info">
              <?php if ($_SESSION['admin']) : ?>
                <p>Logged in as <span id="username-span"><?php echo $username; ?></span><br><a class="logout_link" href="logout.php">Log out</a> | <a class="logout_link" href="index.php">Tillbaka</a></p>
              <?php else : ?>
                <?php if($_SESSION['user_id'] == 8 || $_SESSION['user_id'] == 10) : ?>
                  <p>Logged in as <span id="username-span"><?php echo $username; ?></span><br><a class="logout_link" href="logout.php">Log out</a> | <a class="logout_link" href="admin.php">Admin</a></p>
                  <?php else : ?>
                  <p>Logged in as <span id="username-span"><?php echo $username; ?></span><br><a class="logout_link" href="logout.php">Log out</a></p>
                  <?php endif ?>
              <?php endif ?>
            <?php endif ?>
            </div>
    </div>
  <?php echo get_feedback(); ?>