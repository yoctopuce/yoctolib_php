<HTML>
<HEAD>
 <TITLE>Hello World</TITLE>
</HEAD>
<BODY>
<?php
  include('../../php8/yocto_api.php');
  include('../../php8/yocto_spectralsensor.php');

  // Use explicit error handling rather than exceptions
  YAPI::DisableExceptions();
  $errmsg = "";
  // Setup the API to use the VirtualHub on local machine
  if(YAPI::RegisterHub('http://127.0.0.1:4444/',$errmsg) != YAPI::SUCCESS) {
      die("Cannot contact VirtualHub on 127.0.0.1");
  }

  @$serial = $_GET['serial'];
  if ($serial != '') {
      // Check if a specified module is available online
      $spectralSensor = YSpectralSensor::FindSpectralSensor("$serial.spectralSensor");
      if (!$spectralSensor->isOnline()) {
          die("Module not connected (check serial and USB cable)");
      }
  } else {
      // or use any connected module suitable for the demo
      $spectralSensor = YSpectralSensor::FirstSpectralSensor();
      if(is_null($spectralSensor)) {
          die("No module connected (check USB cable)");
      } else {
          $serial = $spectralSensor->module()->get_serialnumber();
      }
  }
  Print("Module to use: <input name='serial' value='$serial'><br>\n");

  // sample code reading MCP9804 temperature sensor
  $spectralSensor->set_gain(6);
  $spectralSensor->set_integrationTime(150);
  $spectralSensor->set_ledCurrent(6);
  
  Printf("Current color : %s <br>", $spectralSensor->get_nearSimpleColor());
  Printf("Color HEX : #%06x ", $spectralSensor->get_estimatedRGB());
  YAPI::FreeAPI();

  // trigger auto-refresh after one second
  Print("<script language='javascript1.5' type='text/JavaScript'>\n");
  Print("setTimeout('window.location.reload()',1000);");
  Print("</script>\n");
?>
</BODY>
</HTML>
