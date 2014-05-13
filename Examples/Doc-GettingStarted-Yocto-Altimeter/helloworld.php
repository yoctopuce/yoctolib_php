<HTML>
<HEAD>
 <TITLE> Hello World</TITLE>
</HEAD>  
<BODY>
<?php
  include('../../Sources/yocto_api.php');
  include('../../Sources/yocto_altitude.php');
  include('../../Sources/yocto_pressure.php');
  include('../../Sources/yocto_temperature.php');

  // Use explicit error handling rather than exceptions
  yDisableExceptions();

  // Setup the API to use the VirtualHub on local machine
  if(yRegisterHub('http://127.0.0.1:4444/',$errmsg) != YAPI_SUCCESS) {
      die("Cannot contact VirtualHub on 127.0.0.1");
  }

  @$serial = $_GET['serial'];
  if ($serial != '') {
      // Check if a specified module is available online
      $alt = yFindAltitude("$serial.altitude");
      if (!$alt->isOnline()) { 
          die("Module not connected (check serial and USB cable)");
      }
  } else {
      // or use any connected module suitable for the demo
      $alt = yFirstAltitude();
      if(is_null($alt)) {
          die("No module connected (check USB cable)");
      } else {
          $serial = $alt->module()->get_serialnumber();
      }
  }
  Print("Module to use: <input name='serial' value='$serial'><br>");

  // Get altitude and temperature as well
  $alt  = yFindAltitude("$serial.altitude");
  $temp = yFindTemperature("$serial.temperature");
  $press = yFindPressure("$serial.pressure");

  $hvalue = $alt->get_currentValue();
  $qvalue = $alt->get_qnh();
  $pvalue = $press->get_currentValue();
  $tvalue = $temp->get_currentValue();
  Print("Altitude: $hvalue m  (QNH=$qvalue hPa)<br>");
  Print("Temperature: $tvalue deg C <br>");
  Print("Pressure: $pvalue hPa<br>");

  // trigger auto-refresh after one second
  Print("<script language='javascript1.5' type='text/JavaScript'>\n");
  Print("setTimeout('window.location.reload()',1000);");
  Print("</script>\n");
?>  
</BODY>
</HTML> 
