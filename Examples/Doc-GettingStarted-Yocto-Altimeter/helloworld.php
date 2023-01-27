<HTML>
<HEAD>
 <TITLE> Hello World</TITLE>
</HEAD>
<BODY>
<?php
  include('../../php8/yocto_api.php');
  include('../../php8/yocto_altitude.php');
  include('../../php8/yocto_pressure.php');
  include('../../php8/yocto_temperature.php');

  // Use explicit error handling rather than exceptions
  YAPI::DisableExceptions();

  // Setup the API to use the VirtualHub on local machine
  if(YAPI::RegisterHub('http://127.0.0.1:4444/',$errmsg) != YAPI::SUCCESS) {
      die("Cannot contact VirtualHub on 127.0.0.1");
  }

  @$serial = $_GET['serial'];
  if ($serial != '') {
      // Check if a specified module is available online
      $alt = YAltitude::FindAltitude("$serial.altitude");
      if (!$alt->isOnline()) {
          die("Module not connected (check serial and USB cable)");
      }
  } else {
      // or use any connected module suitable for the demo
      $alt = YAltitude::FirstAltitude();
      if(is_null($alt)) {
          die("No module connected (check USB cable)");
      } else {
          $serial = $alt->module()->get_serialnumber();
      }
  }
  Print("Module to use: <input name='serial' value='$serial'><br>");

  // Get altitude and temperature as well
  $alt  = YAltitude::FindAltitude("$serial.altitude");
  $temp = YTemperature::FindTemperature("$serial.temperature");
  $press = YPressure::FindPressure("$serial.pressure");

  $hvalue = $alt->get_currentValue();
  $qvalue = $alt->get_qnh();
  $pvalue = $press->get_currentValue();
  $tvalue = $temp->get_currentValue();
  Print("Altitude: $hvalue m  (QNH=$qvalue hPa)<br>");
  Print("Temperature: $tvalue deg C <br>");
  Print("Pressure: $pvalue hPa<br>");
  YAPI::FreeAPI();

  // trigger auto-refresh after one second
  Print("<script language='javascript1.5' type='text/JavaScript'>\n");
  Print("setTimeout('window.location.reload()',1000);");
  Print("</script>\n");
?>
</BODY>
</HTML>
