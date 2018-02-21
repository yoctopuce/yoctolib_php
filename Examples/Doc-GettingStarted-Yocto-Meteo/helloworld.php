<HTML>
<HEAD>
 <TITLE> Hello World</TITLE>
</HEAD>
<BODY>
<?php
  include('../../Sources/yocto_api.php');
  include('../../Sources/yocto_humidity.php');
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
      $press = yFindPressure("$serial.pressure");
      if (!$press->isOnline()) {
          die("Module not connected (check serial and USB cable)");
      }
  } else {
      // or use any connected module suitable for the demo
      $press = yFirstPressure();
      if(is_null($press)) {
          die("No module connected (check USB cable)");
      } else {
          $serial = $press->module()->get_serialnumber();
      }
  }
  Print("Module to use: <input name='serial' value='$serial'><br>");

  // Get humidity and temperature as well
  $hum  = yFindHumidity("$serial.humidity");
  $temp = yFindTemperature("$serial.temperature");

  $hvalue = $hum->get_currentValue();
  $pvalue = $press->get_currentValue();
  $tvalue = $temp->get_currentValue();
  Print("Temperature: $tvalue °C<br>");
  Print("Humidity: $hvalue %RH<br>");
  Print("Pressure: $pvalue hPa<br>");
  yFreeAPI();

  // trigger auto-refresh after one second
  Print("<script language='javascript1.5' type='text/JavaScript'>\n");
  Print("setTimeout('window.location.reload()',1000);");
  Print("</script>\n");
?>
</BODY>
</HTML>
