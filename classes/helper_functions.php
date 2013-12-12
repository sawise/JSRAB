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

function form_select($name, $title, $items, $selected_id = null) {
  $html = form_control_wrapper();
    $html .= form_label($name, $title);
    $html .= '<select name="'.$name.'">';
    $html .= '<option>-- Välj --</option>';

    foreach ($items as $item) {
      $selected = '';
      /*if ($selected_id && $selected_id == $item->id) {
        $selected = ' selected="selected"';
      }*/
      $html .= '<option'.$selected.' value="'.$item.'">'.$item.'</option>';
    }

    $html .= '</select>';
    $html .= '</div>';
    return $html;
  }

  function form_control_wrapper() {
    return '<div class="control-group">';
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

    $html = form_control_wrapper();
    $html .= form_label($name, $label_text);
    $html .= '<textarea id="'.$name.'" name="'.$name.'"';
    $html .= $placeholder_text.' onKeyDown="LimitText(this.form.notes,this.form.countdown,1000);"
onKeyUp="LimitText(this.form.notes,this.form.countdown,1000);" rows="8" maxlength="1000">';
    $html .= $valuetext;
    $html .= "</textarea></div>";

    return $html;
  }

  function hidden_input($name, $id) {
    $html = '<input type="hidden" name="'.$name.'" value="'.$id.'">';
    return $html;
  }

  function form_input($type, $name, $label_text, $placeholder_text = null, $valuetext = null) {
    if ($placeholder_text != null) {
      $placeholder_text = ' placeholder="'.$placeholder_text.'"';
    } if ($valuetext != null) {
      $valuetext = ' value="'.$valuetext.'"';
    }

    $html  = form_control_wrapper();
    $html .= form_label($name, $label_text);
    $html .= '<div class="controls">';
    $html .= '<input type="'.$type.'" id="'.$name.'" name="'.$name.'"  '.$placeholder_text.''.$valuetext.'>';
    $html .= '</div>';
    $html .= '</div>';

    return $html;
  }
/*<div class="tab-pane active fade in" id="w1">
          <table class="table table-striped">
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
      </table>
        </div>*/

  function yearView($tabs){
    $thisyear = 2013;
    $html = '<div class="tabbable tabs-below">';
      $html .= '<div class="tab-content">';
        $html .= '<ul class="nav nav-tabs" id="yearTab">';
        for($i = 2000; $i <= $thisyear; $i++){
          if($i == 2000){
            $html .= '<li class ="active"><a href="#'.$i.'" data-toggle="tab">'.$i.'</a></li>';
          } else{
            $html .= '<li><a href="#'.$i.'" data-toggle="tab">'.$i.'</a></li>';
          }
        }
        $html .= '</ul>';
      
        for($i = 2000; $i <= $thisyear; $i++){
          if($i == 2000){
            $html .= '<div class="tab-pane active fade in" id="'.$i.'">';
          } else {
            $html .= '<div class="tab-pane fade" id="'.$i.'">';
          }
           $html .=  $tabs;
           $html .= '  '.$i.'</div>';
      }
    $html .= '</div></div>';
    return $html;
  }

function weekView($orders){
   $totalweeks = 52;
   $html = '<div class="tabbable tabs-below">';
    $html .= '<div class="tab-content">';
     for($i = 1; $i <= $totalweeks; $i++){
      if($i == 1){
        $html .= '<div class="tab-pane active fade in" id="w'.$i.'">';
      } else {
        $html .= '<div class="tab-pane fade" id="w'.$i.'">';
      }
      
      $html .= '<table class="table table-striped">';
        $html .='<thead><th>Ordernummer<th>Företag/Kund<th>Mönster</th><th>Dimension</th><th>Antal</th><th></th></thead>';
        $html .= '<tbody>';
        foreach($orders as $order){
          $html .= '<tr>';
          $html .= '<td>'.$order[0].' week '.$i.'</td>';
          $html .= '<td>'.$order[1].'</td>';
          $html .= '<td>'.$order[2].'</td>';
          $html .= '<td>'.$order[3].'</td>';
          $html .= '<td>'.$order[4].'</td>';
          $html .= '<td><a href="#" class="btn btn-mini btn-primary btn-Action" type="button">Mer info</button></td>';
          $html .= '</tr>';
        }            
        $html .= '</tbody></table></div>';
      
    }
    $html .= '<ul class="nav nav-tabs" id="weekTab">';
    for($i = 1; $i <= $totalweeks; $i++){
      if($i == 1){
        $html .= '<li class ="active"><a href="#w'.$i.'" data-toggle="tab">'.$i.'</a></li>';
      } else{
        $html .= '<li><a href="#w'.$i.'" data-toggle="tab">'.$i.'</a></li>';
      }
    }
    $html .= '</ul></div></div>';
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

function submit_button($text) {
    $html  = '<div class="control-group">';
    $html .= '<div class="controls">';
    $html .= '<button type="submit" class="btn btn-primary">'.$text.'</button>';
    $html .= '</div>';
    $html .= '</div>';

    return $html;

  }

  /* Will be used later to sort items by week
  $week_start = new DateTime();
$week_start->setISODate(2013,2);
echo $week_start->format('d-M-Y');*/
 ?>
