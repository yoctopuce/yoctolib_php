<?php

// this example is not a web page, it is meant to be started in php command line mode.
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
include("../../php8/yocto_api.php");
include("../../php8/yocto_anbutton.php");

function valueChangeCallBack($obj_fct, $str_value)
{
    $info = $obj_fct->get_userData();
    Print("{$info['name']}: $str_value {$info['unit']} (new value)\n");
}

function timedReportCallBack($obj_fct, $obj_measure)
{
    $info = $obj_fct->get_userData();
    Print("{$info['name']}: {$obj_measure->get_averageValue()} {$info['unit']} (timed report)\n");
}

function configChangeCallback($obj_module)
{
    Print("{$obj_module->get_serialNumber()}: configuration change\n");
}

function beaconCallback($obj_module, $int_beacon)
{
    Print("{$obj_module->get_serialNumber()}: beacon changed to $int_beacon\n");
}

function deviceArrival($module)
{
    $serial = $module->get_serialNumber();
    Print("New device: $serial\n");
    $module->registerConfigChangeCallback('configChangeCallback');
    $module->registerBeaconCallback('beaconCallback');

    // First solution: look for a specific type of function (eg. anButton)
    $fctcount = $module->functionCount();
    for ($i = 0; $i < $fctcount; $i++) {
        $hardwareId = "{$serial}.{$module->functionId($i)}";
        if (strpos($hardwareId, ".anButton") !== false) {
            Print("- {$hardwareId}\n");
            $button = YAnButton::FindAnButton($hardwareId);
            //$button->set_userData(Array('name' => $hardwareId, 'unit' => ''));
            //$button->registerValueCallback('valueChangeCallBack');
        }
    }

    // Alternate solution: register any kind of sensor on the device
    $sensor = YSensor::FirstSensor();
    while ($sensor) {
        $se= $sensor->get_hardwareId();
        //print("enum:$se\n");
        if ($sensor->get_module()->get_serialNumber() == $serial) {
            $hardwareId = $sensor->get_hardwareId();
            //Print("- {$hardwareId}\n");
            //$sensor->set_userData(Array('name' => $hardwareId, 'unit' => $sensor->get_unit()));
            //$sensor->registerValueCallback('valueChangeCallBack');
            //$sensor->registerTimedReportCallback('timedReportCallBack');
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
    while (true) {
        YAPI::Sleep(100);
        YAPI::UpdateDeviceList();
    }
}




// Setup the API to use the VirtualHub on local machine
if (YAPI::RegisterHub('http://127.0.0.1:4444/') != YAPI::SUCCESS) {
    Print("Cannot contact VirtualHub on 127.0.0.1");
}

YAPI::RegisterDeviceArrivalCallback('deviceArrival');
YAPI::RegisterDeviceRemovalCallback('deviceRemoval');
handleHotPlug();
?>