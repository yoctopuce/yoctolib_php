<HTML>
<HEAD>
 <TITLE>Hello World</TITLE>
</HEAD>
<BODY>
<?php
  include('../../php8/yocto_api.php');
  include('../../php8/yocto_gps.php');

  // Use explicit error handling rather than exceptions
  //YAPI::DisableExceptions();

  // Setup the API to use the VirtualHub on local machine
  if(YAPI::RegisterHub('http://127.0.0.1:4444/',$errmsg) != YAPI::SUCCESS) {
      die("Cannot contact VirtualHub on 127.0.0.1");
  }

  @$serial = $_GET['serial'];
  if ($serial != '') {
      // Check if a specified module is available online
      $gps = YGps::FindGps("$serial.gps");
      if (!$gps->isOnline()) {
          die("Module not connected (check serial and USB cable)");
      }
  } else {
      // or use any connected module suitable for the demo
      $gps = YGps::FirstGps();
      if(is_null($gps)) {
          die("No module connected (check USB cable)");
      } else {
          $serial = $gps->module()->get_serialnumber();
      }
  }
  Print("Module to use: <input name='serial' value='$serial'><br>");

  if  ($gps->get_isFixed()!=Y_ISFIXED_TRUE)
      Print("Gps : fixing...<br>");
  else
      Printf("Gps : %s %s<br>", $gps->get_latitude(), $gps->get_longitude());
  YAPI::FreeAPI();

  // trigger auto-refresh after one second
  Print("<script language='javascript1.5' type='text/JavaScript'>\n");
  Print("setTimeout('window.location.reload()',1000);");
  Print("</script>\n");
?>
</BODY>
</HTML>
