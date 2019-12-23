<HTML>
<HEAD>
 <TITLE>Hello World</TITLE>
</HEAD>
<BODY>
<FORM method='get'>
<?php
  include('../../Sources/yocto_api.php');
  include('../../Sources/yocto_led.php');

  // Use explicit error handling rather than exceptions
  YAPI::DisableExceptions();

  // Setup the API to use the VirtualHub on local machine
  if(YAPI::RegisterHub('http://127.0.0.1:4444/',$errmsg) != YAPI::SUCCESS) {
      die("Cannot contact VirtualHub on 127.0.0.1");
  }

  @$serial = $_GET['serial'];
  if ($serial != '') {
      // Check if a specified module is available online
      $led = YLed::FindLed("$serial.led");
      if (!$led->isOnline()) {
          die("Module not connected (check serial and USB cable)");
      }
  } else {
      // or use any connected module suitable for the demo
      $led = YLed::FirstLed();
      if(is_null($led)) {
          die("No module connected (check USB cable)");
      } else {
          $serial = $led->module()->get_serialnumber();
      }
  }
  Print("Module to use: <input name='serial' value='$serial'><br>");

  // Drive the selected module
  if (isset($_GET['state'])) {
      $state = $_GET['state'];
      if ($state=='OFF') $led->set_power(Y_POWER_OFF);
      if ($state=='ON')  $led->set_power(Y_POWER_ON);
  }
  YAPI::FreeAPI();
?>
<input type='radio' name='state' value='ON'>Turn led ON
<input type='radio' name='state' value='OFF'>Turn led OFF
<br><input type='submit'>
</FORM>
</BODY>
</HTML>
