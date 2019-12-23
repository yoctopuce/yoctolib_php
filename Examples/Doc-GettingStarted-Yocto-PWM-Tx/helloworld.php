<HTML>
<HEAD>
 <TITLE>Hello World</TITLE>
</HEAD>
<BODY>
<FORM method='get'>
<?php
  include('../../Sources/yocto_api.php');
  include('../../Sources/yocto_pwmoutput.php');

  // Use explicit error handling rather than exceptions
  YAPI::DisableExceptions();

  // Setup the API to use the VirtualHub on local machine
  if(YAPI::RegisterHub('http://127.0.0.1:4444/',$errmsg) != YAPI::SUCCESS) {
      die("Cannot contact VirtualHub on 127.0.0.1");
  }

  @$serial = $_GET['serial'];
  if ($serial != '') {
      // Check if a specified module is available online
      $pwmoutput1 = YPwmOutput::FindPwmOutput("$serial.pwmOutput1");
      $pwmoutput2 = YPwmOutput::FindPwmOutput("$serial.pwmOutput2");
      if (!$pwmoutput1->isOnline()) {
          die("Module not connected (check serial and USB cable)");
      }
  } else {
      // or use any connected module suitable for the demo
      $pwmoutput1 = YPwmOutput::FirstPwmOutput();
      if(is_null($pwmoutput1)) {
          die("No module connected (check USB cable)");
      } else {
          $serial = $pwmoutput1->module()->get_serialnumber();
          $pwmoutput1 = YPwmOutput::FindPwmOutput("$serial.pwmOutput1");
          $pwmoutput2 = YPwmOutput::FindPwmOutput("$serial.pwmOutput2");
      }
  }
  $pwmoutput1->set_frequency(1000);
  $pwmoutput1->set_enabled(Y_ENABLED_TRUE);
  $pwmoutput2->set_frequency(1000);
  $pwmoutput2->set_enabled(Y_ENABLED_TRUE);

  Print("Module to use: <input name='serial' value='$serial'><br>");
  if(isset($_GET['dutycycle'])) {
      $dutyCycle = $_GET['dutycycle'];
      $pwmoutput1->set_dutyCycle($dutyCycle);      // immediate change
      $pwmoutput2->dutyCycleMove($dutyCycle,3000); // smooth change
   }
  YAPI::FreeAPI();
?>
<input type='radio' name='dutycycle' value='0'>Change Duty Cycle to 0 %<br>
<input type='radio' name='dutycycle' value='25'>Change Duty Cycle to 25 %<br>
<input type='radio' name='dutycycle' value='50'>Change Duty Cycle to 50 %<br>
<input type='radio' name='dutycycle' value='75'>Change Duty Cycle to 75 %<br>
<input type='radio' name='dutycycle' value='100'>Change Duty Cycle to 100 %<br>
<input type='submit'>
</FORM>
</BODY>
</HTML>
