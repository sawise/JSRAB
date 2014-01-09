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

//----------------

function yearViewtest(){
    $startyear = 2013;
    $thisyear = 2014;
     $html = '<div id="yeartabs"><ul>';
        for($i = $startyear; $i <= $thisyear; $i++){
          $html .= '<li><a href="weekoverview.php?year='.$i.'">'.$i.'</a></li>';
        }
        $html .= '</ul></div>';
    return $html;
  }

  function weekViewtest($year){//, $searchresult){
  $startweek = 1;
  $totalweeks = 52;

   $html = '';
  $html = '<style> #weektabs_'.$year.' .ui-tabs-nav li { font-size: 0.7em; font-family: \'Ubuntu Mono\';}</style>';
    $html .= '<div id="weektabs_'.$year.'"><ul>';  
      for($i = $startweek; $i <= $totalweeks; $i++){
          $html .= '<li><a href="orderinweek.php?year='.$year.'&week='.$i.'">'.$i.'</a></li>';
      }
      $html .= '</ul></div>';
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

function showTooltip($searchresults){
  $html = '';
  foreach($searchresults as $searchresult){
    $html .= '<style>';
      $html .= '.ttip_'.$searchresult->id.' {';
    $html .= 'position: absolute;
        color: #fff;
        width: 50%;
        padding: 20px;
        -webkit-box-shadow: 0 1px 2px #303030;
        -moz-box-shadow: 0 1px 2px #303030;
        box-shadow: 0 1px 2px #303030;
        border-radius: 8px 8px 8px 8px;
        -moz-border-radius: 8px 8px 8px 8px;
        -webkit-border-radius: 8px 8px 8px 8px;
        -o-border-radius: 8px 8px 8px 8px;
        background-image:-moz-linear-gradient(top, #F45000, #FF8000);
        background-image: -webkit-gradient(linear, left top, left bottom, from(#F45000), to(#FF8000));
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#F45000\', endColorstr=\'#FF8000\', GradientType=0);
        background-color:#000;
        display: none
        }';

$html .= '.contents_'.$searchresult->id.' {';
   $html .= ' font-size: 15px;
    font-size: 1em; 
    font-family: \'Ubuntu Mono\';
       font-weight:bold;
       text-align:left;
       }';

$html .= '.note_'.$searchresult->id.' {';
  $html .= '  font-size: 13px;
      text-align:center;
      display:block;
      width: 100%
  }';
  $html .= '</style>';

  //Script
     $html .= '<script>';
     $html .= '$(\'.tooltip_display_'.$searchresult->id.'\').click(function() {';
    $html .= 'var $this = $(this);';
        /*$("#background").css({
        "opacity": "0.3"
        }).fadeIn("slow");*/

        $html .= '$("#large").html(function() {';
        $html .= '$(\'.ttip_'.$searchresult->id.'\').css({';
        $html .=  'left: $this.position() + \'20px\',';
        $html .= 'top: $this.position() + \'50px\'';
        $html .= '}).show(500)';
        $html .= '}).fadeIn("slow");';
        $html .= '});';

         $html .= '$(\'.note_'.$searchresult->id.'\').on(\'click\', function() {';
        $html .= '$(\'.ttip_'.$searchresult->id.'\').hide(500);';
        //$("#background").fadeOut("slow");
        $html .= '$("#large").fadeOut("slow");';
        $html .= '});';
        $html .= '$("#large").click(function() {';
        $html .= '$(this).fadeOut();';
      $html .= '});';
    $html .= '</script>';
  }

  return $html;
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
