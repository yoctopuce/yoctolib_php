<HTML>
<HEAD>
 <TITLE>Hello World</TITLE>
</HEAD>
<BODY>
<FORM method='get'>
<?php
  include('../../php8/yocto_api.php');
  include('../../php8/yocto_watchdog.php');

  // Use explicit error handling rather than exceptions
  YAPI::DisableExceptions();

  // Setup the API to use the VirtualHub on local machine
  if(YAPI::RegisterHub('http://127.0.0.1:4444/',$errmsg) != YAPI::SUCCESS) {
      die("Cannot contact VirtualHub on 127.0.0.1");
  }

  @$serial = $_GET['serial'];
  if ($serial != '') {
      // Check if a specified module is available online
      $watchdog = YWatchdog::FindWatchdog("$serial.watchdog1");
      if (!$watchdog->isOnline()) {
          die("Module not connected (check serial and USB cable)");
      }
  } else {
      // or use any connected module suitable for the demo
      $watchdog = YWatchdog::FirstWatchdog();
      if(is_null($watchdog)) {
          die("No module connected (check USB cable)");
      } else {
          $serial = $watchdog->module()->get_serialnumber();
      }
  }
  Print("Module to use: <input name='serial' value='$serial'><br>");

  // Drive the selected module
  if (isset($_GET['state'])) {
      $state = $_GET['state'];
      if ($state=='ON') $watchdog->set_running(Y_RUNNING_ON);
      if ($state=='OFF') $watchdog->set_running(Y_RUNNING_OFF);
      if ($state=='RESET') $watchdog->resetWatchdog();
  }
  YAPI::FreeAPI();
?>
<input type='radio' name='state' value='ON'>Start Watchdog
<input type='radio' name='state' value='RESET'>Reset Watchdog
<input type='radio' name='state' value='OFF'>Stop Watchog
<br><input type='submit'>
</FORM>
</BODY>
</HTML>
