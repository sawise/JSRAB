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

function form_select($name, $title, $items, $selected_id = null, $dbcolumn, $toggle, $togglearray) {
  $html = form_control_wrapper($name);
    $html .= form_label($name, $title);
    $html .= '<div class="controls">';
    $html .= '<select name="'.$name.'">';
    $html .= '<option>-- Välj --</option>';

    foreach ($items as $item) {
      $selected = '';
      /*if ($selected_id && $selected_id == $item->id) {
        $selected = ' selected="selected"';
      }*/
      $html .= '<option'.$selected.' value="'.$item->$dbcolumn.'">'.$item->$dbcolumn.'</option>';
    }

    $html .= '</select>';
    $html .= toggle($toggle,$togglearray);
    $html .= '</div></div>';
    return $html;
  }

  function form_control_wrapper($id) {
    return '<div class="control-group" id="'.$id.'">';
  }

  function form_label($for, $text = null){
    if ($text != null) {
      $text = $text;
    }
    return '<label class="control-label" for="'.$for.'">'.$text.' </label>';
  }

  function text_area($name, $label_text, $placeholder_text = null, $valuetext = null){
    if ($placeholder_text != null) {
      $placeholder_text = ' placeholder="'.$placeholder_text.'"';
    }
    if ($valuetext != null) {
      $valuetext = $valuetext;
    }

    $html = form_control_wrapper($name.'-');
    $html .= form_label($name, $label_text);
    $html .= '<div class="controls">';
    $html .= '<textarea id="'.$name.'" name="'.$name.'"';
    $html .= $placeholder_text.' onKeyDown="LimitText(this.form.notes,this.form.countdown,1000);"
onKeyUp="LimitText(this.form.notes,this.form.countdown,1000);" rows="8" maxlength="1000">';
    $html .= $valuetext;
    $html .= "</textarea></div></div>";

    return $html;
  }

  function hidden_input($name, $id) {
    $html = '<input type="hidden" name="'.$name.'" value="'.$id.'">';
    return $html;
  }

  function form_input($type, $name, $label_text, $placeholder_text = null, $valuetext = null, $toggle = null, $togglearray = null) {
    if ($placeholder_text != null) {
      $placeholder_text = ' placeholder="'.$placeholder_text.'"';
    } if ($valuetext != null) {
      $valuetext = ' value="'.$valuetext.'"';
    }

    $html  = form_control_wrapper($name."-");
    $html .= form_label($name, $label_text);
    $html .= '<div class="controls">';
    $html .= '<input type="'.$type.'" id="'.$name.'" name="'.$name.'"  '.$placeholder_text.''.$valuetext.'>';
    $html .= toggle($toggle, $togglearray);
    $html .= '</div>';
    $html .= '</div>';

    return $html;
  }
function toggle($toggle = null, $togglearray = null){
  $html = '';
  if($toggle != null){
    if($toggle == 'toggle'){
      $html .= '<a href="#" data-toggle="tooltip" title="Lägg dit en ny" onclick="showHideDiv(\''.$togglearray[0].'\', \''.$togglearray[1].'\');"><i class="icon-arrow-right"></i></a>';
    } else if($toggle == 'untoggle') {
      $html .= '<a href="#" data-toggle="tooltip" title="Välj från listan" onclick="showHideDiv(\''.$togglearray[0].'\', \''.$togglearray[1].'\');"><i class="icon-arrow-left"></i></a>';
    }
  }
  return $html;
}

  function yearView($db){
    $startyear = 2012;
    $thisyear = 2014;
    $html = '<div class="tabbable tabs-below">';
      $html .= '<div class="tab-content">';
        $html .= '<ul class="nav nav-tabs" id="yearTab">';
        for($i = $startyear; $i <= $thisyear; $i++){
          if($i == $startyear){
            $html .= '<li class ="active"><a href="#'.$i.'" data-toggle="tab">'.$i.'</a></li>';
          } else{
            $html .= '<li><a href="#'.$i.'" data-toggle="tab">'.$i.'</a></li>';
          }
        }
        $html .= '</ul>';
      
        for($i = $startyear; $i <= $thisyear; $i++){
          if($i == $startyear){
            $html .= '<div class="tab-pane active fade in" id="'.$i.'">';
          } else {
            $html .= '<div class="tab-pane fade" id="'.$i.'">';
          }
           $html .=  weekView($i, $db);
           $html .=  '</div>';
      }
    $html .= '</div></div>';
    return $html;
  }

function weekView($year, $searchresult){
  $startweek = 1;
  $totalweeks = 52;
  $s = $searchresult->searchyear($year);
  $html = '<div class="tabbable tabs-below">';
  $html .= '<div class="tab-content">';
  if($s != null){
    for($i = $startweek; $i <= $totalweeks; $i++){
      if($i == $startweek){
        $html .= '<div class="tab-pane active fade in" id="y'.$year.'_w'.$i.'">';
      } else {
        $html .= '<div class="tab-pane fade" id="y'.$year.'_w'.$i.'">';
      }
        $html .= '<table class="table table-striped">';
        $html .='<thead><th>Leveransdag<th>Företag/Kund<th>Mönster</th><th>Dimension</th><th>Antal</th><th></th></thead>';
        $html .= '<tbody>';
      foreach($s as $ss){
        $deldate = getWeek($ss->deliverydate);
        if($deldate == $i){
          $html .= '<tr>'; 
          //$html .= '<td>'.$ss->deliverydate.'</td>';
          $html .= '<td>'.getWeekday($ss->deliverydate).'</td>';
          $html .= '<td>'.$ss->customer_name.'</td>';
          $html .= '<td>'.$ss->tiretread_name.'</td>';
          $html .= '<td>'.$ss->tiresize_name.'</td>';
          $html .= '<td>'.$ss->total.'</td>';
          $html .= '<td>'.popUp(1).'</td>';
          $html .= '</tr>';
        } 
      }            
      $html .= '</tbody></table></div>';
     } 
  } else {
    $html .= 'Nada!';
  }
  
  if($s != null){
    $html .= '<ul class="nav nav-tabs" id="weekTab">';
    for($i = $startweek; $i <= $totalweeks; $i++){
      if($i == $startweek){
        $html .= '<li class ="active"><a href="#y'.$year.'_w'.$i.'" data-toggle="tab">'.$i.'</a></li>';
      } else{
        $html .= '<li><a href="#y'.$year.'_w'.$i.'"" data-toggle="tab">'.$i.'</a></li>';
      }
    }
    $html .= '</ul>';
  }
    
  $html .= '</div></div>';
  return $html;
}

function tableView(){
  $totalweeks = 52;
  $weeknumber = '';
  for($i = 1; $i <= $totalweeks; $i++){
    $weeknumber .= $i.' ';
  }
  return $weeknumber;
}

function popUp($id){
  $popup = "<a href=\"#\""; 
  $popup .= "onclick=\"window.open('orderdetails.php?id=".$id."', 'a', 'width=900, height=700, scrollbars=0, resizable=0')\""; 
  $popup .= "class=\"btn btn-mini btn-primary btn-Action\" type=\"button\">Mer info</button>";
  return $popup;
}

function submit_button($text) {
    $html  = '<div class="control-group">';
    $html .= '<div class="controls">';
    $html .= '<button type="submit" class="btn btn-primary">'.$text.'</button>';
    $html .= '</div>';
    $html .= '</div>';

    return $html;

  }
function getWeek($deliverydate){
  $week = date("W", strtotime($deliverydate));
  return $week;
}

function getWeekday($date){
  $weekday = date("w", strtotime($date));
  $returnWeekday = '';
  if($weekday == 0){
    $returnWeekday = 'Söndag';
  } else if($weekday == 1){
    $returnWeekday = 'Måndag';
  } else if($weekday == 2){
    $returnWeekday = 'Tisdag';
  }else if($weekday == 3){
    $returnWeekday = 'Onsdag';
  }else if($weekday == 4){
    $returnWeekday = 'Torsdag';
  }else if($weekday == 5){
    $returnWeekday = 'Fredag';
  }else if($weekday == 6){
    $returnWeekday = 'Lördag';
  }
  return $returnWeekday;
}

//$dw = date( "w", $timestamp);
  /* Will be used later to sort items by week
  $week_start = new DateTime();
$week_start->setISODate(2013,2);
echo $week_start->format('d-M-Y');*/

function set_feedback($status, $text) {
    $_SESSION['feedback'] = array('status' => $status, 'text' => $text);
  }

  function get_feedback() {
    $html = "";
    if (isset($_SESSION['feedback'])) {
      $html .= '<div class="alert alert-'.$_SESSION['feedback']['status'].'">';
      $html .= '<button type="button" class="close" data-dismiss="alert">×</button>';
      $html .= $_SESSION['feedback']['text'];
      $html .= '</div>';
      $_SESSION['feedback'] = null;
    }
    return $html;
  }

 ?>
