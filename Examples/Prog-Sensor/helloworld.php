<HTML>
<HEAD>
 <TITLE>Hello World</TITLE>
</HEAD>
<BODY>
<?php
  include('../../php8/yocto_api.php');

  // Use explicit error handling rather than exceptions
  YAPI::DisableExceptions();

  // Setup the API to use the VirtualHub on local machine
  if(YAPI::RegisterHub('http://127.0.0.1:4444/',$errmsg) != YAPI::SUCCESS) {
      die("Cannot contact VirtualHub on 127.0.0.1");
  }

  $sensor = YSensor::FirstSensor();
  if(is_null($sensor)) {
      die("No sensor connected (check USB cable and firmware version)");
  }
  while(!is_null($sensor)) {
      Print($sensor->get_friendlyName().': '.$sensor->get_currentValue().' '.$sensor->get_unit()."<br>\n");
      $sensor = $sensor->nextSensor();
  }

  // trigger auto-refresh after one second
  Print("<script language='javascript1.5' type='text/JavaScript'>\n");
  Print("setTimeout('window.location.reload()',1000);");
  Print("</script>\n");
?>
</BODY>
</HTML>
