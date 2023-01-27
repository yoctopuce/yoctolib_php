<HTML>
<HEAD>
 <TITLE>Hello World</TITLE>
</HEAD>
<BODY>
<FORM method='get'>
<?php
  include('../../php8/yocto_api.php');
  include('../../php8/yocto_relay.php');

  // Use explicit error handling rather than exceptions
  YAPI::DisableExceptions();

  // Setup the API to use the VirtualHub on local machine
  if(YAPI::RegisterHub('http://127.0.0.1:4444/',$errmsg) != YAPI::SUCCESS) {
      die("Cannot contact VirtualHub on 127.0.0.1");
  }

  @$serial = $_GET['serial'];
  if ($serial != '') {
      // Check if a specified module is available online
      $relay = YRelay::FindRelay("$serial.relay1");
      if (!$relay->isOnline()) {
          die("Module not connected (check serial and USB cable)");
      }
  } else {
      // or use any connected module suitable for the demo
      $relay = YRelay::FirstRelay();
      if(is_null($relay)) {
          die("No module connected (check USB cable)");
      } else {
          $serial = $relay->module()->get_serialnumber();
      }
  }
  Print("Module to use: <input name='serial' value='$serial'><br>");

  // Drive the selected module
  if (isset($_GET['state'])) {
      $state = $_GET['state'];
      if ($state=='A') $relay->set_state(Y_STATE_A);
      if ($state=='B') $relay->set_state(Y_STATE_B);
  }
  YAPI::FreeAPI();
?>
<input type='radio' name='state' value='A'>Output A
<input type='radio' name='state' value='B'>Output B
<br><input type='submit'>
</FORM>
</BODY>
</HTML>
