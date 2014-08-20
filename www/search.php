<?php
	require_once('../config.php');
	 $db = new Db();
	$tirethreads = $db->getTiretreads();
   $tireSize = $db->getTiresize();
   $searchstring = '';
   $datestart = '';
   $dateend = '';
   $tiresizeID = '';
   $tirethreadID = '';
 //$adv->search->size->thread->datestart->dateend
if(isset($_SESSION['searchstring'])) {
	$searcharray = explode(",", $_SESSION['searchstring']);
		
   $tirethreadID = $searcharray[2];
   $tiresizeID = $searcharray[1];

		if($searcharray[0] != 'nosearch'){
			$searchstring = $searcharray[0];  
		}
		if($searcharray[3] != 'nodate' && $searcharray[4] != 'nodate') {
			$dateend = $searcharray[4];
			$datestart = $searcharray[3];
		}
		
		
		//var_dump($searcharray);
		} 
		

?>



 <link rel="stylesheet" type="text/css" href="css/flexigrid.pack.css" />
 <link rel="stylesheet" href="css/flexigridstyle.css" />
<script type="text/javascript" src="js/flexigrid.pack.js"></script>

<style>
  .custom-combobox {
    position: relative;
    display: inline-block;
  }
  .custom-combobox-toggle {
    position: absolute;
    top: 0;
    bottom: 0;
    margin-left: -1px;
    padding: 0;
    /* support: IE7 */
    *height: 1.7em;
    *top: 0.1em;
  }
  .custom-combobox-input {
    margin: 0;
    padding: 0.3em;
  }
  </style>
  <script>
setDefaultthread("<?php echo $tirethreadID ?>");
	  setDefaultsize("<?php echo $tiresizeID ?>");
function setDefaultthread(defValue) {
    $('#tirethreadssearch option').each(function () {
    	console.log("thread_"+$(this).attr('value'));
        if (($(this).attr('value')) == defValue) {
            $(this).attr('selected', 'selected');
        }
    });
}
function setDefaultsize(defValue) {
    $('#tiresizessearch option').each(function () {
    	console.log($(this).attr('value'));
        if (($(this).attr('value')) == defValue) {
            $(this).attr('selected', 'selected');
        }
    });
}

  (function( $ ) {
    $.widget( "custom.combobox", {
      _create: function() {
        this.wrapper = $( "<span>" )
          .addClass( "custom-combobox" )
          .insertAfter( this.element );
 
        this.element.hide();
        this._createAutocomplete();
        this._createShowAllButton();
      },
 
      _createAutocomplete: function() {
        var selected = this.element.children( ":selected" ),
          value = selected.val() ? selected.text() : "";
 
        this.input = $( "<input>" )
          .appendTo( this.wrapper )
          .val( value )
          .attr( "title", "" )
          .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
          .autocomplete({
            delay: 0,
            minLength: 0,
            source: $.proxy( this, "_source" )
          })
          .tooltip({
            tooltipClass: "ui-state-highlight"
          });
 
        this._on( this.input, {
          autocompleteselect: function( event, ui ) {
            ui.item.option.selected = true;
            this._trigger( "select", event, {
              item: ui.item.option
            });
          },
 
          autocompletechange: "_removeIfInvalid"
        });
      },
 
      _createShowAllButton: function() {
        var input = this.input,
          wasOpen = false;
 
        $( "<a>" )
          .attr( "tabIndex", -1 )
          .attr( "title", "Show All Items" )
          .tooltip()
          .appendTo( this.wrapper )
          .button({
            icons: {
              primary: "ui-icon-triangle-1-s"
            },
            text: false
          })
          .removeClass( "ui-corner-all" )
          .addClass( "custom-combobox-toggle ui-corner-right" )
          .mousedown(function() {
            wasOpen = input.autocomplete( "widget" ).is( ":visible" );
          })
          .click(function() {
            input.focus();
 
            // Close if already visible
            if ( wasOpen ) {
              return;
            }
 
            // Pass empty string as value to search for, displaying all results
            input.autocomplete( "search", "" );
          });
      },
 
      _source: function( request, response ) {
        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
        response( this.element.children( "option" ).map(function() {
          var text = $( this ).text();
          if ( this.value && ( !request.term || matcher.test(text) ) )
            return {
              label: text,
              value: text,
              option: this
            };
        }) );
      },
 
      _removeIfInvalid: function( event, ui ) {
 
        // Selected an item, nothing to do
        if ( ui.item ) {
          return;
        }
 
        // Search for a match (case-insensitive)
        var value = this.input.val(),
          valueLowerCase = value.toLowerCase(),
          valid = false;
        this.element.children( "option" ).each(function() {
          if ( $( this ).text().toLowerCase() === valueLowerCase ) {
            this.selected = valid = true;
            return false;
          }
        });
 
        // Found a match, nothing to do
        if ( valid ) {
          return;
        }
 
        // Remove invalid value
        this.input
          .val( "" )
          .attr( "title", value + " didn't match any item" )
          .tooltip( "open" );
        this.element.val( "" );
        this._delay(function() {
          this.input.tooltip( "close" ).attr( "title", "" );
        }, 2500 );
        this.input.data( "ui-autocomplete" ).term = "";
      },
 
      _destroy: function() {
        this.wrapper.remove();
        this.element.show();
      }
    });
  })( jQuery );
 
  $(function() {
    $( "#tiresizessearch" ).combobox();
    $( "#toggle" ).click(function() {
      $( "#tiresizessearch" ).toggle();
    });

  });
  $(function() {
    $( "#tirethreadssearch" ).combobox();
    $( "#toggle" ).click(function() {
      $( "#tirethreadssearch" ).toggle();
    });
  });
  </script>

<script type="text/javascript">
 $(function() {
    $( "#datepickerstart" ).datepicker({
      showWeek: true,
      firstDay: 1,
      dateFormat: 'yy-mm-dd'
    });
    $( "#datepickerend" ).datepicker({
      showWeek: true,
      firstDay: 1,
      dateFormat: 'yy-mm-dd'
    });
  });
	$(function () {
	    $(".popover-examples").popover({
	        
	    });
	});
</script>

<!-- body -->
<div class="searchInput">
	<form method="get" action="searchcaller.php">
	<input id="search" name="search" type="text" placeholder="" value="<?php echo $searchstring ?>" class="input-xxlarge search-query">
	<button type="submit" class="btn "><span class="glyphicon glyphicon-search"></span></button>
	<a class="accordion-toggle" data-toggle="collapse" href="#collapseOne"><i class="glyphicon glyphicon-arrow-down"></i></a>
		<?php if(isset($_SESSION['searchstring'])) : ?>
			<a href="print.php?search=<?php echo $searchstring.'&tirethread='.$searcharray[2].'&tiresize='.$searcharray[1].'&datestart='.$searcharray[3].'&dateend='.$searcharray[4] ?>" target="_blank"><i id="printbutton" class="glyphicon glyphicon-print"></i></a>
		<?php endif ?>
	<div id="collapseOne" class="collapse adv">		
		<table class="adv">
			<td>
				<?php echo form_input('text', 'datepickerstart', 'Leveransdatum', 'Tryck här för att välja datum', $datestart) ?>
				<?php echo form_input('text', 'datepickerend', '|', 'Tryck här för att välja datum', $dateend) ?>	
			</td>
			<td>
				<?php echo form_select("tirethreadssearch", "Mönster", $tirethreads, $tirethreadID, 'name') ?>
				<?php  echo form_select("tiresizessearch", "Storlek", $tireSize, $tiresizeID, 'name') ?>
			</td>
		</table>
	</div>
	</form> 
</div>
    
<table class="flexme1 Ubuntufont">
</table>


	<?php if(isset($_SESSION['searchstring'])) : ?>   
<?php $_SESSION['print']  = $_SESSION['searchstring'];
 $_SESSION['searchstring'] = null; ?>
	        <script>
	        	$(".flexme1").flexigrid({
	                url : "post-json.php?search=<?php echo $searchstring.'&tirethread='.$searcharray[2].'&tiresize='.$searcharray[1].'&datestart='.$searcharray[3].'&dateend='.$searcharray[4] ?>",
	                dataType: 'json',
		colModel : [
		{display:  'ID', name : 'id', width : 20, sortable : true, align: 'left'},
		{display:  'Leveransdatum', name : 'deliverydate', width : 100, sortable : true, align: 'left'},
			{display: 'Kund', name : 'customer_name', width : 100, sortable : true, align: 'left'},
			{display:  'Mönster', name : 'tiretread_name', width : 100, sortable : true, align: 'left'},
			{display: 'Dimension', name : 'tiresize_name', width : 100, sortable : true, align: 'left'},
			{display: 'Antal', name : 'total', width : 35, sortable : true, align: 'left'},
			{display: 'Kommentarer', name : 'comments', width : 350, sortable : false, align: 'left'},
      {display: '', name : 'actions', width : 50, sortable : false, align: 'center'}
			], 	
		
		sortname: "deliverydate",
		sortorder: "asc",
		usepager: true,
		title: '',
		useRp: true,
		rp: 10,
		showTableToggleBtn: true,
		width: 880,
		height: 300
	            });      
	        </script>
	<?php endif ?>  
<body> <!--<a href="#" class="btn popover-examples" data-toggle="popover" title="Popover title" data-content="Default popover<br>ss<br>">Popover</a><?php //echo tooltipButton($searchresult); ?> -->