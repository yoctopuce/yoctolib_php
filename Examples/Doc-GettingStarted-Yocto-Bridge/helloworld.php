<HTML>
<HEAD>
 <TITLE>Hello World</TITLE>
</HEAD>
<BODY>
<?php
  include('../../php8/yocto_api.php');
  include('../../php8/yocto_weighscale.php');

  // Use explicit error handling rather than exceptions
  YAPI::DisableExceptions();

  // Setup the API to use the VirtualHub on local machine
  if(YAPI::RegisterHub('http://127.0.0.1:4444/',$errmsg) != YAPI::SUCCESS) {
      die("Cannot contact VirtualHub on 127.0.0.1");
  }

  @$serial = $_GET['serial'];
  if ($serial != '') {
      // Check if a specified module is available online
      $sensor = YWeighScale::FindWeighScale("$serial.weighScale1");
      if (!$sensor->isOnline()) {
          die("Module not connected (check serial and USB cable)");
      }
  } else {
      // or use any connected module suitable for the demo
      $sensor = YWeighScale::FirstWeighScale();
      if(is_null($sensor)) {
          die("No module connected (check USB cable)");
      } else {
          $serial = $sensor->module()->get_serialnumber();
      }
  }
  Print("Module to use: <input name='serial' value='$serial'><br>");
  $sensor = YWeighScale::FindWeighScale("$serial.weighScale1");

  if($sensor->get_excitation() == Y_EXCITATION_OFF) {
      $sensor->set_excitation(Y_EXCITATION_AC);
  }
  Printf("Weight: %.1f %s<br>",$sensor->get_currentValue(),$sensor->get_unit());

  YAPI::FreeAPI();

  // trigger auto-refresh after one second
  Print("<script language='javascript1.5' type='text/JavaScript'>\n");
  Print("setTimeout('window.location.reload()',1000);");
  Print("</script>\n");
?>
</BODY>
</HTML>
