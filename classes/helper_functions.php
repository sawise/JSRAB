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

function form_select_script(){

}

function form_select($name, $title, $items, $selected_id = null, $dbcolumn/*, $toggle, $togglearray*/) {
  $html = form_control_wrapper($name.'-');
    $html .= form_label($name.'-', $title);
    $html .= '<div class="controls">';
    $html .= '<select name="'.$name.'" id="'.$name.'">';
    $html .= '<option value="">Select one...</option>';
    foreach ($items as $item) {
      $selected = '';
      if ($selected_id && $selected_id == $item->id) {
        $selected = ' selected="selected"';
      }
      $html .= '<option'.$selected.' value="'.$item->id.'">'.$item->$dbcolumn.'</option>';
    }

    $html .= '</select>';
    //$html .= toggle($toggle,$togglearray);
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
    $html .= $placeholder_text.' onKeyDown="LimitText(this.form.notes,this.form.countdown,255);"
onKeyUp="LimitText(this.form.notes,this.form.countdown,1000);" rows="8" maxlength="255">';
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

function yearView(){
    $thisyear = date("Y");
     $html = '<div id="yeartabs"><ul>';
        for($i = $thisyear; $i <= $thisyear+10; $i++){
          $html .= '<li><a href="weekoverview.php?year='.$i.'">'.$i.'</a></li>';
        }
        $html .= '</ul></div>';
    return $html;
  }


function prevyearView(){
    $thisyear = date("Y");
     $html = '<div id="prevyeartabs"><ul>';
        for($i = 1995; $i < $thisyear; $i++){
          $html .= '<li><a href="weekoverview.php?year='.$i.'">'.$i.'</a></li>';
        }
        $html .= '</ul></div>';
    return $html;
  }

  function weekView($year, $currentdate){
  $startweek = 1;
  $totalweeks = 52;

   $html = '';
  $html = '<style> #weektabs_'.$year.' .ui-tabs-nav li { font-size: 0.7em; font-family: \'Ubuntu Mono\';}</style>';
    $html .= '<div id="weektabs_'.$year.'"><ul>';  
      for($i = $startweek; $i <= $totalweeks; $i++){
        $week = date('W', strtotime($currentdate));
        $yearloop = date('Y', strtotime($currentdate));
          $weektab = $week-1;
          $html .= '<li><a href="orderinweek.php?year='.$year.'&week='.$i.'">'.$i.'</a></li>';
          if($i == $week && $yearloop == $year){
              $script .=  "$('#weektabs_".$year."').tabs({active: ".$weektab."})";
          }
      }
      $html .= '</ul></div>';
$html .= '<script>'.$script.'</script>';
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


function showTooltiptest($searchresult){
            $html = tooltipContent($searchresult);
            $html .= '<a href="#" id="searchItem_'.$searchresult->id.'" rel="popover"><i class="glyphicon glyphicon-info-sign"></i></a> ';
            $html .= '<a href="index.php?editOrder='.$searchresult->id.'"><i class="glyphicon glyphicon-edit"></i></a> ';
            $html .= '<a href="deleteorder.php?orderid='.$searchresult->id.'"><i class="glyphicon glyphicon-trash"></i></a>';
/*  $html .= '<div><span id="searchItem_'.$searchresult->id.'" rel="popover" class="btn">
            Mer info
            </span>';*/
$html .= '<script>
            $(document).ready(function() {
              var div1Html = $(\'#content_'.$searchresult->id.'\').html();
                $("#searchItem_'.$searchresult->id.'").popover({
                    html: true,
                    animation: true,
                    content: div1Html,
                    placement: "bottom"
                });

            });
      $(\'#content_'.$searchresult->id.'\').hide()
        </script></div>';
  return $html;
}

function tooltipContent($searchresult){
   $content = '<div id="content_'.$searchresult->id.'" class="Ubuntufont"><p>Leveransdatum:'.$searchresult->deliverydate.'</p>
                 <p>Kund:'.$searchresult->customer_name.'</p>
                 <p>Däckmönster: '.$searchresult->tiretread_name.'</p>
                 <p>Däckstorlek: '.$searchresult->tiresize_name.'</p>
                 <p>Antal: '.$searchresult->total.'</p>
                 <p>Kommentarer: '.$searchresult->comments.'</p>
                 <p>Senast ändrad av: '.$searchresult->username.' '.$searchresult->lastChange.' </p>';
              $content .= '<p><a href="index.php?editOrder='.$searchresult->id.'">Redigera</p></a>';
              $content .= '<p><a href="deleteorder.php?orderid='.$searchresult->id.'">Ta bort</p></a>';
            $content .= '</div>';
            return $content;
}



function set_feedback($status, $text) {
    $_SESSION['feedback'] = array('status' => $status, 'text' => $text);
  }

  function get_feedback() {
    $html = "";
    if (isset($_SESSION['feedback'])) {
      $html .= '<div class="alert alert-'.$_SESSION['feedback']['status'].' onfront">';
      $html .= '<button type="button" class="close" data-dismiss="alert">×</button>';
      $html .= $_SESSION['feedback']['text'];
      $html .= '</div>';
      $_SESSION['feedback'] = null;
    }
    return $html;
  }

 ?>
