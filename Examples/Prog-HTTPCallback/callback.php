<?php
include('../../Sources/yocto_api.php');
include('../../Sources/yocto_relay.php');
include("config.php");

// Use explicit error handling rather than exceptions
yDisableExceptions();

// Setup the API to use the VirtualHub on local machine
$errmsg = "";
if(yRegisterHub('callback',$errmsg) != YAPI_SUCCESS) {
	logtofile("Unable to start the API in callback mode ($errmsg)");
	die();		
}


// create an array of all connected Relay ( we do not use it
// no but if will be usefull when the user will configure his
// VirtualSwitch)
$detected_relay= LoadDetectedRelays();
$yrelay = yFirstRelay();
while($yrelay!=null){
	$detected_relay[$yrelay->get_hardwareId()] = new Relay($yrelay);
	$yrelay = $yrelay->nextRelay();
}
SaveDetectedRelays($detected_relay);

// load all VirtualSwitch that need to be updated
$all_vswitches = LoadVirtualSwitchesToUpdate();
foreach($all_vswitches as $name => $virtual_switch) {
	// retreive the list of all phisical relay off current
  	// Virtual Swithc to update
  	logtofile("$name = ".$virtual_switch->getState().'('.($virtual_switch->isOnNow()?'on':'off').')');
	logtofile("ON relays = ".print_r(expression));
	if($virtual_switch->isOnNow()){
		$relay_to_update =$virtual_switch->getRelaysForState('on');
	} else {
		$relay_to_update =$virtual_switch->getRelaysForState('off');
	}
	foreach ($relay_to_update as  $hwid => $action) {
	    //apply to the Yocto-Relay the corresponding action
		$yrelay = yFindRelay($hwid);
		if(!$yrelay->isOnline()){	
			logtofile("$hwid is not online");
		}
		switch($action){
		case 'stateOn':
			$yrelay->set_output(Y_OUTPUT_ON);
			break;
		case 'stateOff':
			$yrelay->set_output(Y_OUTPUT_OFF);
			break;
		case 'pulse':
			break;
		default:
			logtofile("Unspported action:".$action);
		}
	}
	foreach ($relay_to_update as  $hwid => $action) {
	    //apply to the Yocto-Relay the corresponding action
		$yrelay = yFindRelay($hwid);
		if(!$yrelay->isOnline()){	
			logtofile("$hwid is not online");
		}
		switch($action){
		case 'stateOn':
		case 'stateOff':
			break;
		case 'pulse':
			$yrelay->pulse(500);
			break;
		default:
			logtofile("Unspported action:".$action);
		}
	}
}



?>  
