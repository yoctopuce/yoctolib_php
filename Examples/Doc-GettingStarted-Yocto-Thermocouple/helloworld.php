<HTML>
<HEAD>
 <TITLE>Hello World</TITLE>
</HEAD>
<BODY>
<?php
  include('../../Sources/yocto_api.php');
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
      $temp = yFindTemperature("$serial.temperature1");
      if (!$temp->isOnline()) {
          die("Module not connected (check serial and USB cable)");
      }
  } else {
      // or use any connected module suitable for the demo
      $temp = yFirstTemperature();
      if(is_null($temp)) {
          die("No module connected (check USB cable)");
      } else {
          $serial = $temp->module()->get_serialnumber();
      }
  }
  Print("Module to use: <input name='serial' value='$serial'><br>");

  $temp1 = yFindTemperature("$serial.temperature1");
  Printf("Temperature channel 1: %.1f &deg;C<br>",$temp1->get_currentValue());

  $temp2 = yFindTemperature("$serial.temperature2");
  Printf("Temperature channel 2: %.1f &deg;C<br>",$temp2->get_currentValue());
  yFreeAPI();

  // trigger auto-refresh after one second
  Print("<script language='javascript1.5' type='text/JavaScript'>\n");
  Print("setTimeout('window.location.reload()',1000);");
  Print("</script>\n");
?>
</BODY>
</HTML>
