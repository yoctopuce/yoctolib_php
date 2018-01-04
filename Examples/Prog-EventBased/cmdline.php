<?php

// this example is not a web page, it is meant to be started in php command line mode.
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
include("../../Sources/yocto_api.php");
include("../../Sources/yocto_anbutton.php");

function valueChangeCallBack($obj_fct, $str_value)
{
    $info = $obj_fct->get_userData();

    $apival = $obj_fct->get_calibratedValue();
    $obj_fct->clearCache();
    $value1 = $obj_fct->get_calibratedValue();
    Print($obj_fct->get_hardwareId() . ": " . $str_value . "=" . $value1 . " (" . $apival . ")\n");


    //Print("{$info['name']}: $str_value {$info['unit']} (new value)\n");
}

function timedReportCallBack($obj_fct, $obj_measure)
{
    $info = $obj_fct->get_userData();
    Print("{$info['name']}: {$obj_measure->get_averageValue()} {$info['unit']} (timed report)\n");
}

function deviceArrival($module)
{
    $serial = $module->get_serialNumber();
    Print("New device: $serial\n");

    // First solution: look for a specific type of function (eg. anButton)
    $fctcount = $module->functionCount();
    for ($i = 0; $i < $fctcount; $i++) {
        $hardwareId = "{$serial}.{$module->functionId($i)}";
        if (strpos($hardwareId, ".anButton") !== false) {
            Print("- {$hardwareId}\n");
            $button = YAnButton::FindAnButton($hardwareId);
            $button->set_userData(Array('name'=>$hardwareId, 'unit'=>''));
            $button->registerValueCallback('valueChangeCallBack');
        }
    }

    // Alternate solution: register any kind of sensor on the device
    $sensor = YSensor::FirstSensor();
    while($sensor) {
        if($sensor->get_module()->get_serialNumber() == $serial) {
            $hardwareId = $sensor->get_hardwareId();
            Print("- {$hardwareId}\n");
            $sensor->set_userData(Array('name'=>$hardwareId, 'unit'=>$sensor->get_unit()));
            $sensor->registerValueCallback('valueChangeCallBack');
            $sensor->registerTimedReportCallback('timedReportCallBack');
        }
        $sensor = $sensor->nextSensor();
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


YAPI::$defaultCacheValidity = 5000;

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