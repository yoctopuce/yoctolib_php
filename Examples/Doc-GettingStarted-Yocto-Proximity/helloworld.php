<HTML>
<HEAD>
    <TITLE>Hello World</TITLE>
</HEAD>
<BODY>
<?php
include('../../Sources/yocto_api.php');
include('../../Sources/yocto_proximity.php');
include('../../Sources/yocto_lightsensor.php');

// Use explicit error handling rather than exceptions
yDisableExceptions();
// Setup the API to use the VirtualHub on local machine
if (yRegisterHub('http://127.0.0.1:4444/', $errmsg) != YAPI_SUCCESS) {
    die("Cannot contact VirtualHub on 127.0.0.1");
}

@$serial = $_GET['serial'];
if ($serial != '') {
    // Check if a specified module is available online
    $p = yFindProximity("$serial.proximity");
    if (!$p->isOnline()) {
        die("Module not connected (check serial and USB cable)");
    }
} else {
    // or use any connected module suitable for the demo
    $p = yFirstProximity();
    if (is_null($p)) {
        die("No module connected (check USB cable)");
    } else {
        $serial = $p->module()->get_serialnumber();
    }
}

$al = yFindLightSensor("$serial.lightSensor1");
$ir = yFindLightSensor("$serial.lightSensor2");

Print("Module to use: <input name='serial' value='$serial'><br>");
Print("Proximity:  {$p->get_currentValue()} <br>");
Print("Ambient:    {$al->get_currentValue()} <br>");
Print("IR:         {$ir->get_currentValue()} <br>");

yFreeAPI();

// trigger auto-refresh after one second
Print("<script language='javascript1.5' type='text/JavaScript'>\n");
Print("setTimeout('window.location.reload()',1000);");
Print("</script>\n");
?>
</BODY>
</HTML>
