<HTML>
<HEAD>
 <TITLE>Hello World</TITLE>
</HEAD>  
<BODY>
<?php
  include('../../Sources/yocto_api.php');
  include('../../Sources/yocto_gps.php');

  // Use explicit error handling rather than exceptions
  //yDisableExceptions();

  // Setup the API to use the VirtualHub on local machine
  if(yRegisterHub('http://127.0.0.1:4444/',$errmsg) != YAPI_SUCCESS) {
      die("Cannot contact VirtualHub on 127.0.0.1");
  }

  @$serial = $_GET['serial'];
  if ($serial != '') {
      // Check if a specified module is available online
      $gps = yFindGps("$serial.gps");
      if (!$gps->isOnline()) { 
          die("Module not connected (check serial and USB cable)");
      }
  } else {
      // or use any connected module suitable for the demo
      $gps = yFirstGps();
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
      Printf("Gps : %s %s<br>",$gps->get_latitude(),$gps->get_latitude());  
 
  // trigger auto-refresh after one second
  Print("<script language='javascript1.5' type='text/JavaScript'>\n");
  Print("setTimeout('window.location.reload()',1000);");
  Print("</script>\n");
?>  
</BODY>
</HTML> 
