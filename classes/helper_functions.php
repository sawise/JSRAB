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
  
 ?>
