<?php
include("../../Sources/yocto_api.php");
include("../../Sources/yocto_anbutton.php");
include("../../Sources/yocto_temperature.php");
include("../../Sources/yocto_lightsensor.php");

function valueChangeCallBack($obj_fct, $str_value)
{
    // the field to update is stored in the function userData
    $fundescr = $obj_fct->get_functionDescriptor();
    Print("$fundescr: $str_value\n");
}

function deviceArrival($module)
{
    $serial = $module->get_serialNumber();
    Print("New device: $serial\n");

    $fctcount = $module->functionCount();
    for ($i = 0; $i < $fctcount; $i++) {
        $fctName = $module->functionId($i);
        $fctFullName = "{$serial}.{$fctName}";

         // register call back for anbuttons
        if (strpos($fctName, "anButton") !== false) { 
            $bt = YAnButton::FindAnButton($fctFullName);
            Print("- {$fctName}: {$fctFullName}\n");
            $bt->registerValueCallback('valueChangeCallBack');
         }
         
         // register call back for temperature sensors
        if (strpos($fctName, "temperature") !== false) { 
            $t = YTemperature::FindTemperature($fctFullName);
            Print("- {$fctName}: {$fctFullName}\n");
            $t->registerValueCallback('valueChangeCallBack');
        }
        
        // register call back for light sensors
        if (strpos($fctName, "lightSensor") !== false) { 
            $l = YLightSensor::FindLightSensor($fctFullName);
            Print("- {$fctName}: {$fctFullName}\n");
            $l->registerValueCallback('valueChangeCallBack');
        }
    }
 }

function deviceRemoval($module)
{
    $serial = $module->get_serialNumber();
    Print("Device unplugged: $serial\n");
}

function handleHotPlug()
{
    while(true) {
        ySleep(100);
        yUpdateDeviceList();
    }
}

// Use explicit error handling rather than exceptions
YAPI::DisableExceptions();

// Setup the API to use the VirtualHub on local machine
if(YAPI::RegisterHub('http://127.0.0.1:4444/') != YAPI::SUCCESS) {
    Print("Cannot contact VirtualHub on 127.0.0.1");
}

YAPI::RegisterDeviceArrivalCallback('deviceArrival');
YAPI::RegisterDeviceRemovalCallback('deviceRemoval');
handleHotPlug();
?>