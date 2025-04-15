<HTML>
<HEAD>
 <TITLE>Hello World</TITLE>
</HEAD>
<BODY>
<?php
  include('../../php8/yocto_api.php');
  include('../../php8/yocto_colorsensor.php');

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
      $colorSensor = YColorSensor::FindColorSensor("$serial.colorSensor");
      if (!$colorSensor->isOnline()) {
          die("Module not connected (check serial and USB cable)");
      }
  } else {
      // or use any connected module suitable for the demo
      $colorSensor = YColorSensor::FirstColorSensor();
      if(is_null($colorSensor)) {
          die("No module connected (check USB cable)");
      } else {
          $serial = $colorSensor->module()->get_serialnumber();
      }
  }
  Print("Module to use: <input name='serial' value='$serial'><br>\n");

  
  $colorSensor->set_workingMode(Y_WORKINGMODE_AUTO);
  $colorSensor->set_estimationModel(Y_ESTIMATIONMODEL_REFLECTION);
  
  Printf("Current color : %s <br>", $colorSensor->get_nearSimpleColor());
  Printf("RGB HEX : #%06x ", $colorSensor->get_estimatedRGB());
  YAPI::FreeAPI();

  // trigger auto-refresh after one second
  Print("<script language='javascript1.5' type='text/JavaScript'>\n");
  Print("setTimeout('window.location.reload()',1000);");
  Print("</script>\n");
?>
</BODY>
</HTML>
