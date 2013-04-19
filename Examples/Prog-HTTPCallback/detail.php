<?php
  
  // this is needed for the unserialize to work properly.
  include("config.php");

  $all_swi = LoadVirtualSwitches();
  $swi;
  if(isset($_GET['name']) ){
    $swi=$all_swi[$_GET['name']];
  }else{
  	$swi=new VirtualSwitch('unk',array(),array());
  }
?>
<!DOCTYPE html> 
<html>

<head>
	<meta charset="utf-8">
	<title><?php print($swi->getName());?></title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
	<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
</head> 



<body> 

<!-- Start of first page: #newswitch -->
<div data-role="page" id="detail"  data-add-back-btn="true">

	<div data-role="header">
		<h1><?php print($swi->getName());?></h1>
	</div><!-- /header -->

	<div data-role="content" >	
		<div data-role="controlgroup">
			<?php
		    Print('<a href="index.php?name='.$swi->getName().'&state=on" data-role="button" data-theme="'.($swi->getState()=='on'?'b':'').'">On</a>');
		    Print('<a href="index.php?name='.$swi->getName().'&state=off" data-role="button" data-theme="'.($swi->getState()=='off'?'b':'').'">Off</a>');
		    //Print('<a href="index.php?name='.$swi->getName().'&state=timed" data-role="button" class="ui-disabled">Timed</a>');
		    ?>
		</div>	

		<div data-role="popup" id="popupDialog" data-overlay-theme="a" data-theme="c" style="max-width:400px;" class="ui-corner-all">
			<div data-role="header" data-theme="a" class="ui-corner-top">
				<h1>Delete Page?</h1>
			</div>
			<div data-role="content" data-theme="d" class="ui-corner-bottom ui-content">
				<h3 class="ui-title">Are you sure you want to delete this page?</h3>
				<p>This action cannot be undone.</p>
				<a href="#" data-role="button" data-inline="true" data-rel="back" data-theme="c">Cancel</a>    
				<a href="<?php Print('index.php?name='.$swi->getName().'&action=delete');?>" data-role="button" data-inline="true" data-transition="flow" data-theme="b">Delete</a>  
		    
			</div>
		</div>


	</div><!-- /content -->


<div data-role="footer" class="ui-bar"  data-position="fixed">
        <?php Print('<a href="new.php?name='.$swi->getName().'&action=edit" data-role="button" data-icon="gear">Edit</a>');?>
    <a href="#popupDialog" data-rel="popup" data-position-to="window" data-role="button" data-transition="pop" data-icon="delete">Delete</a>		
</div>

</div><!-- /page newswitch -->



</body>
</html>