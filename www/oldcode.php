/* function yearViewtest($db){
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
        $html .= '<table class="flexme1 Ubuntufont table table-striped">';
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
          $html .= '<td>'.showTooltiptest($ss).'</td>';
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
}*/
/*function tooltipButton($searchresult){
  $ordernumberArray = explode(",", $searchresult->comments);
   $html = '<a class="tooltip_display_'.$searchresult->id.' btn btn-mini btn-primary btn-Action" href="#" type="button">Mer info</button></a>';
   $html .= '<div class="ttip_'.$searchresult->id.'">';
   $html .= '<div class="contents_'.$searchresult->id.'">';
   $html .= '<p>Leveransdatum:'.$searchresult->customer_name.'</p>
               <p>Kund:'.$searchresult->customer_name.'</p>
               <p>Däckmönster: '.$searchresult->tiretread_name.'</p>
               <p>Däckstorlek: '.$searchresult->tiresize_name.'</p>
               <p>Antal: '.$searchresult->total.'</p>';
               
             for ($i=0; $i < count($ordernumberArray) ; $i++) { 
                $arrayCount = count($ordernumberArray);
                if($i == 0){
                  $html .= '<p>Ordernummer: '.$ordernumberArray[$i].'<p>';
                  $html .= '<p>Följenummer: '.$i;
                } else if($i == $arrayCount-1) {
                   $html .= $ordernumberArray[$i].'<p>'; 
                } else {
                  $html .= $ordernumberArray[$i].',';
                } 
            } 
              $html .= '</p>';
              $html .= '<p><a href="index.php?editOrder='.$searchresult->id.'">Redigera order</p></a>';
              $html .= '<p><a href="#">Skriv ut</p></a>';
              //$html .= '</div>';
              $html .= '<span class="note_'.$searchresult->id.'">(click here to close the box)</span>';
              $html .= '</div></div>';
              return $html;
}*/

/*
  Old beta
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
        }).fadeIn("slow");

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
}*/


//$dw = date( "w", $timestamp);
  /* Will be used later to sort items by week
  $week_start = new DateTime();
$week_start->setISODate(2013,2);
echo $week_start->format('d-M-Y');*/