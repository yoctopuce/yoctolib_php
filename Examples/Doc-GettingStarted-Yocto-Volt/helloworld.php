<HTML>
<HEAD>
 <TITLE>Hello World</TITLE>
</HEAD>
<BODY>
<?php
  include('../../Sources/yocto_api.php');
  include('../../Sources/yocto_voltage.php');

  // Use explicit error handling rather than exceptions
  YAPI::DisableExceptions();

  // Setup the API to use the VirtualHub on local machine
  if(YAPI::RegisterHub('http://127.0.0.1:4444/',$errmsg) != YAPI::SUCCESS) {
      die("Cannot contact VirtualHub on 127.0.0.1");
  }

  @$serial = $_GET['serial'];
  if ($serial != '') {
      // Check if a specified module is available online
      $sensor= YVoltage::FindVoltage("$serial.voltage1");
      if (!$sensor->isOnline()) {
          die("Module not connected (check serial and USB cable)");
      }
  } else {
      // or use any connected module suitable for the demo
      $sensor = YVoltage::FirstVoltage();
      if(is_null($sensor)) {
          die("No module connected (check USB cable)");
      } else {
          $serial = $sensor->module()->get_serialnumber();
      }
  }
  Print("Module to use: <input name='serial' value='$serial'><br>");

  if ($sensor->isOnline())
   {  $sensorDC = YVoltage::FindVoltage($serial.".voltage1");
      $sensorAC = YVoltage::FindVoltage($serial.".voltage2");
      $DC = $sensorDC->get_currentValue();
      $AC = $sensorAC->get_currentValue();
      Print("Voltage, DC : $DC v    AC : $AC v  <br>");
   }
  YAPI::FreeAPI();

  // trigger auto-refresh after one second
  Print("<script language='javascript1.5' type='text/JavaScript'>\n");
  Print("setTimeout('window.location.reload()',1000);");
  Print("</script>\n");
?>
</BODY>
</HTML>
