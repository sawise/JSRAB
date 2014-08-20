  <?php 
  require_once('../config.php');

  $id = null;
  if (isset($_GET['orderid'])) {
    $id = $_GET['orderid'];
  }
  if (isset($_POST['orderid'])) {
    $id = $_POST['orderid'];
  }

  $db = new Db();

  $deleteOrder = $db->deleteOrder($id);

    if ($deleteOrder) {
    set_feedback('success', 'Utskicket togs bort');
  } else {
    set_feedback('error', 'Något blev fel, försök igen');
    echo 'fel';
  }

  header("Location: index.php");
