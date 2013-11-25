<?php
function menu($currentPage){
  $menuarray = array("Veckoöversikt", "Sök", "Lägg till ny order", "Logga ut");
  $menu .= '<div class="menu"><ul class="nav nav-pills">';
  foreach ($menuarray as $menuitem) {
    if($currentPage == $menuitem){
      $menu .= '<li  class="active"><a href="#">'.$menuitem.'</a></li>';
    } else{
      $menu .= '<li><a href="#">'.$menuitem.'</a></li>';
    }
  }
  $menu .= '</ul> </div>';
  return $menu;
}
function tableView(){
  $totalweeks = 52;
  $weeknumber = '';
  for($i = 1; $i <= $totalweeks; $i++){
    $weeknumber .= $i.' ';
  }
  return $weeknumber;
  /*<table class="table table-striped">
      <thead><th>Ordernummer<th>Företag/Kund<th>Mönster</th><th>Dimension</th><th>Antal</th><th></th></thead>
       <tbody><?php foreach($orders as $order) : ?>
              <tr>
                  <td><?php echo $order[0] ?></td>
                  <td><?php echo $order[1] ?></td>
                  <td><?php echo $order[2] ?></td>
                  <td><?php echo $order[3] ?></td>
                  <td><?php echo $order[4] ?></td>
                  <td><a href="#" class="btn btn-mini btn-primary btn-Action" type="button">Mer info</button></td>
        </tr>
      <?php endforeach ?>
      </tbody>
      </table>*/
}

  /* Will be used later to sort items by week
  $week_start = new DateTime();
$week_start->setISODate(2013,2);
echo $week_start->format('d-M-Y');*/
 ?>
