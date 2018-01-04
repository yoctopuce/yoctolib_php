<HTML>
<HEAD>
 <TITLE>Hello World</TITLE>
</HEAD>
<BODY>
<FORM method='get'>
<?php
  include('../../Sources/yocto_api.php');
  include('../../Sources/yocto_relay.php');

  // Use explicit error handling rather than exceptions
  yDisableExceptions();

  // Setup the API to use the VirtualHub on local machine
  if(yRegisterHub('http://127.0.0.1:4444/',$errmsg) != YAPI_SUCCESS) {
      die("Cannot contact VirtualHub on 127.0.0.1");
  }

  @$serial = $_GET['serial'];
  if ($serial != '') {
      // Check if a specified module is available online
      $relay1 = yFindRelay("$serial.relay1");
      $relay2 = yFindRelay("$serial.relay2");
      if (!$relay1->isOnline()) {
          die("Module not connected (check serial and USB cable)");
      }
  } else {
      // or use any connected module suitable for the demo
      // (note that the order of enumeration may vary)
      $relay1 = yFirstRelay();
      if(is_null($relay1)) {
          die("No module connected (check USB cable)");
      } else {
          $relay2 = $relay1->nextRelay();
          $serial = $relay1->module()->get_serialnumber();
      }
  }
  Print("Module to use: <input name='serial' value='$serial'><br>");

  // Drive the selected module
  if (isset($_GET['state1'])) {
      $state = $_GET['state1'];
      if ($state=='A') $relay1->set_state(Y_STATE_A);
      if ($state=='B') $relay1->set_state(Y_STATE_B);
  }
  if (isset($_GET['state2'])) {
      $state = $_GET['state2'];
      if ($state=='A') $relay2->set_state(Y_STATE_A);
      if ($state=='B') $relay2->set_state(Y_STATE_B);
  }
  yFreeAPI();
?>
Relay 1: <input type='radio' name='state1' value='A'>Output A
         <input type='radio' name='state1' value='B'>Output B<br>
Relay 2: <input type='radio' name='state2' value='A'>Output A
         <input type='radio' name='state2' value='B'>Output B<br>
<input type='submit'>
</FORM>
</BODY>
</HTML>
