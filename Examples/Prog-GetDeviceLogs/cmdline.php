<?php
// this example is not a web page, it is meant to be started in php command line mode.
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
include("../../Sources/yocto_api.php");

function logfun($obj_module, $str_line)
{
    $info = $obj_fct->get_userData();
    Print($obj_module-get_serialNumber()+' : '+str_line+"\n");
}

function deviceArrival($obj_module)
{
    $serial = $obj_module->get_serialNumber();
    Print("New device: $serial\n");
    $obj_module->registerLogCallback('logfun');
}

function handleHotPlug()
{
    while(true) {
        YAPI::Sleep(100);
        YAPI::UpdateDeviceList();
    }
}

// Use explicit error handling rather than exceptions
YAPI::DisableExceptions();

// Setup the API to use the VirtualHub on local machine
if(YAPI::RegisterHub('http://127.0.0.1:4444/') != YAPI::SUCCESS) {
    Print("Cannot contact VirtualHub on 127.0.0.1");
}

YAPI::RegisterDeviceArrivalCallback('deviceArrival');
handleHotPlug();
?>