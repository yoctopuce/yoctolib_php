<HTML>
<HEAD>
    <TITLE>Hello World</TITLE>
</HEAD>
<BODY>
<?php
include('../../Sources/yocto_api.php');
include('../../Sources/yocto_rangefinder.php');
include('../../Sources/yocto_lightsensor.php');
include('../../Sources/yocto_temperature.php');

// Use explicit error handling rather than exceptions
YAPI::DisableExceptions();
// Setup the API to use the VirtualHub on local machine
if (YAPI::RegisterHub('http://127.0.0.1:4444/', $errmsg) != YAPI::SUCCESS) {
    die("Cannot contact VirtualHub on 127.0.0.1");
}

@$serial = $_GET['serial'];
if ($serial != '') {
    // Check if a specified module is available online
    $rf = YRangeFinder::FindRangeFinder("$serial.rangeFinder1");
    if (!$rf->isOnline()) {
        die("Module not connected (check serial and USB cable)");
    }
} else {
    // or use any connected module suitable for the demo
    $rf = YRangeFinder::FirstRangeFinder();
    if (is_null($rf)) {
        die("No module connected (check USB cable)");
    } else {
        $serial = $rf->module()->get_serialnumber();
    }
}

$ir = YLightSensor::FindLightSensor("$serial.lightSensor1");
$tmp = YTemperature::FindTemperature("$serial.temperature1");

Print("Module to use: <input name='serial' value='$serial'><br>");
Print("Distance:    {$rf->get_currentValue()} <br>");
Print("Ambient IR:  {$ir->get_currentValue()} <br>");
Print("Temperature: {$tmp->get_currentValue()} <br>");

YAPI::FreeAPI();

// trigger auto-refresh after one second
Print("<script language='javascript1.5' type='text/JavaScript'>\n");
Print("setTimeout('window.location.reload()',1000);");
Print("</script>\n");
?>
</BODY>
</HTML>
