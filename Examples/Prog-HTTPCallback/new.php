<?php
  
  // this is needed for the unserialize to work properly.
  include("config.php");


	$all_swi = LoadVirtualSwitches();
	$title ="New Virtual Switch";
	$is_edit =false;
	$edit_swi=NULL;
    if(isset($_GET['action']) && $_GET['action']=='edit'){
    	$is_edit =true;
        $edit_swi  = $all_swi[$_GET['name']];
    	$title ="Edit {$_GET['name']}";
    }


  $all_relay=LoadDetectedRelays();

  function printOneRelaySelector($hwid,$name,$state,$defaultvalue)
  {
		Print("<li>");
		Print("<h3>$name</h3><p>");
		Print('<fieldset data-role="controlgroup" data-mini="true" data-type="horizontal" >');
		Print("<input type=\"radio\" name=\"{$hwid}_{$state}\" id=\"{$hwid}_stateOn_id\" value=\"stateOn\" ".($defaultvalue=="stateOn"?'checked="checked"':'')." />");
		Print("<label for=\"{$hwid}_stateOn_id\">ON</label>");
		Print("<input type=\"radio\" name=\"{$hwid}_{$state}\" id=\"{$hwid}_stateOff_id\" value=\"stateOff\" ".($defaultvalue=="stateOff"?'checked="checked"':'')." />");
		Print("<label for=\"{$hwid}_stateOff_id\">OFF</label>");
		Print("<input type=\"radio\" name=\"{$hwid}_{$state}\" id=\"{$hwid}_pulse_id\" value=\"pulse\" ".($defaultvalue=="pulse"?'checked="checked"':'')." />");
		Print("<label for=\"{$hwid}_pulse_id\">Pulse ON</label>");
		Print("<input type=\"radio\" name=\"{$hwid}_{$state}\" id=\"{$hwid}_none_id\" value=\"\" ".($defaultvalue==""?'checked="checked"':'')." />");
		Print("<label for=\"{$hwid}_none_id\">unused</label>");
		Print("</fieldset></p>");
		Print("<p class=\"ui-li-aside\"><strong>$hwid</strong></p>");
		Print('</li>');

  }

  function printRelaySelector($state,$swi)
  {
  	
  	global $all_relay;
	$unused_relay = $all_relay;
	if($swi!=NULL){
		$used_relays = $swi->getRelaysForState($state);
		foreach ($used_relays as  $hwid => $action) {
				printOneRelaySelector($hwid,$all_relay[$hwid]->getName(),$state,$action);
				unset($unused_relay[$hwid]);
		}
	}	
	foreach ($unused_relay as $relay) {
		printOneRelaySelector($relay->getHwId(),$relay->getName(),$state,"");
	}	

  }
?>
<!DOCTYPE html> 
<html>

<head>
	<meta charset="utf-8">
	<title><?php print($title);?></title> 
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
	<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
</head> 



<body> 


<!-- Start of first page: #newswitch -->
<div data-role="page" id="newswitch"  data-add-back-btn="true">

	<div data-role="header">
		<h1><?php print($title);?></h1>
	</div><!-- /header -->

	<div data-role="content" >	
		<form action="index.php" method="post">
<?php
		if(!$is_edit){
			print('<input id="action" name="action" type="hidden" value="new"/>'); 
			print('<div id="nameDiv" data-role="fieldcontain">');
			print('   <label for="nameSW">Virtual Switch Name</label>');
			print('  <input id="nameSW" name="nameSwitch" type="text" />');
			print('</div>');
		}else{
			print('<input id="action" name="action" type="hidden" value="new"/>'); 
			print('<input id="action" name="nameSwitch" type="hidden" value="'.$edit_swi->getName().'"/>'); 
		}
?>

			<label id="typeLabel" for="li-relays">Relays to activate on Power On:</label>  
			<ul data-role="listview" data-inset="true"  data-dividertheme="f" id="li-relays"> 
<?php
			printRelaySelector("on",$edit_swi);
?>

    		</ul> 
			<label id="typeLabel" for="li-relays">Relays to activate on Power Off:</label>  
			<ul data-role="listview" data-inset="true"  data-dividertheme="f" id="li-relays"> 
<?php
			printRelaySelector("off",$edit_swi);
?>

    		</ul> 

			<a href="#main" data-role="button" id="button_cancel" data-rel="back" data-inline="true">Cancel</a>
			<input type="submit" data-inline="true" data-theme="b" value="Save" />

		</form>

	</div><!-- /content -->
	<div data-role="footer" class="ui-bar"  data-position="fixed">
    		<h4> </h4> 
	</div> 
</div><!-- /page newswitch -->









</body>
</html>