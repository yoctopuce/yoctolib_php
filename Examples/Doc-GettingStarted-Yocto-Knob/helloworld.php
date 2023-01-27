<HTML>
<HEAD>
 <TITLE>Hello World</TITLE>
</HEAD>
<BODY>
<?php
  include('../../php8/yocto_api.php');
  include('../../php8/yocto_anbutton.php');

  // Use explicit error handling rather than exceptions
  YAPI::DisableExceptions();

  // Setup the API to use the VirtualHub on local machine
  if(YAPI::RegisterHub('http://127.0.0.1:4444/',$errmsg) != YAPI::SUCCESS) {
      die("Cannot contact VirtualHub on 127.0.0.1");
  }

  @$serial = $_GET['serial'];
  if ($serial != '') {
      // Check if a specified module is available online
      $input1 = YAnButton::FindAnButton("$serial.anButton1");
      if (!$input1->isOnline()) {
          die("Module not connected (check serial and USB cable)");
      }
  } else {
      // or use any connected module suitable for the demo
      $input1 = YAnButton::FirstAnButton();
      if(is_null($input1)) {
          die("No module connected (check USB cable)");
      } else {
          $serial = $input1->module()->get_serialnumber();
      }
  }
  Print("Module to use: <input name='serial' value='$serial'><br>");

  $input1 = YAnButton::FindAnButton("$serial.anButton1");
  $checked = $input1->get_isPressed() ? "checked" : "";
  $value   = $input1->get_calibratedValue();
  Print("Input 1: <input type='checkbox' readonly $checked> ");
  Print("pressed / analog value: $value<br>");
  $input5 = YAnButton::FindAnButton("$serial.anButton5");
  $checked = $input5->get_isPressed() ? "checked" : "";
  $value   = $input5->get_calibratedValue();
  Print("Input 5: <input type='checkbox' readonly $checked> ");
  Print("pressed / analog value: $value<br>");
  YAPI::FreeAPI();

  // trigger auto-refresh after one second
  Print("<script language='javascript1.5' type='text/JavaScript'>\n");
  Print("setTimeout('window.location.reload()',1000);");
  Print("</script>\n");
?>
</BODY>
</HTML>
