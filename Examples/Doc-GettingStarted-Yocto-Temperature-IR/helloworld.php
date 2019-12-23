<HTML>
<HEAD>
 <TITLE>Hello World</TITLE>
</HEAD>
<BODY>
<?php
  include('../../Sources/yocto_api.php');
  include('../../Sources/yocto_temperature.php');

  // Use explicit error handling rather than exceptions
  YAPI::DisableExceptions();

  // Setup the API to use the VirtualHub on local machine
  if(YAPI::RegisterHub('http://127.0.0.1:4444/',$errmsg) != YAPI::SUCCESS) {
      die("Cannot contact VirtualHub on 127.0.0.1");
  }

  @$serial = $_GET['serial'];
  if ($serial != '') {
      // Check if a specified module is available online
      $temp = YTemperature::FindTemperature("$serial.temperature1");
      if (!$temp->isOnline()) {
          die("Module not connected (check serial and USB cable)");
      }
  } else {
      // or use any connected module suitable for the demo
      $temp = YTemperature::FirstTemperature();
      if(is_null($temp)) {
          die("No module connected (check USB cable)");
      } else {
          $serial = $temp->module()->get_serialnumber();
      }
  }
  Print("Module to use: <input name='serial' value='$serial'><br>");

  $temp1 = YTemperature::FindTemperature("$serial.temperature1");
  Printf("Ambiant temperature  : %.1f &deg;C<br>",$temp1->get_currentValue());

  $temp2 = YTemperature::FindTemperature("$serial.temperature2");
  Printf("Infrared temperature : %.1f &deg;C<br>",$temp2->get_currentValue());
  YAPI::FreeAPI();

  // trigger auto-refresh after one second
  Print("<script language='javascript1.5' type='text/JavaScript'>\n");
  Print("setTimeout('window.location.reload()',1000);");
  Print("</script>\n");
?>
</BODY>
</HTML>
