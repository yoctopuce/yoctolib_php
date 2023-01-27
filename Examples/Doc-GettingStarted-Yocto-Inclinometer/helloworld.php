<HTML>
<HEAD>
 <TITLE> Hello World</TITLE>
</HEAD>
<BODY>
<?php
  include('../../php8/yocto_api.php');
  include('../../php8/yocto_tilt.php');

  // Use explicit error handling rather than exceptions
  YAPI::DisableExceptions();

  // Setup the API to use the VirtualHub on local machine
  if(YAPI::RegisterHub('http://127.0.0.1:4444/',$errmsg) != YAPI::SUCCESS) {
      die("Cannot contact VirtualHub on 127.0.0.1");
  }

  @$serial = $_GET['serial'];
  if ($serial != '') {
      // Check if a specified module is available online
      $anytilt = YTilt::FindTilt("$serial.tilt1");
      if (!$anytilt->isOnline()) {
          die("Module not connected (check serial and USB cable)");
      }
  } else {
      // or use any connected module suitable for the demo
      $anytilt = YTilt::FirstTilt();
      if(is_null($anytilt)) {
          die("No module connected (check USB cable)");
      } else {
          $serial = $anytilt->module()->get_serialnumber();
      }
  }
  Print("Module to use: <input name='serial' value='$serial'><br>");

  // Get all sensor on the device matching the serial
  $tilt1         = YTilt::FindTilt("$serial.tilt1");
  $tilt2         = YTilt::FindTilt("$serial.tilt2");
  $tilt3         = YTilt::FindTilt("$serial.tilt3");
 

  $tilt1value         =  $tilt1->get_currentValue();
  $tilt2value         =  $tilt2->get_currentValue();
  $tilt3value         =  $tilt3->get_currentValue();

  Print("tilt1: $tilt1value &deg;<br>");
  Print("tilt2: $tilt2value &deg;<br>");
  Print("tilt3: $tilt3value &deg;<br>");
  
  YAPI::FreeAPI();

  // trigger auto-refresh after one second
  Print("<script language='javascript1.5' type='text/JavaScript'>\n");
  Print("setTimeout('window.location.reload()',500);");
  Print("</script>\n");
?>
</BODY>
</HTML>
