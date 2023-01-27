<HTML>
<HEAD>
 <TITLE>Hello World</TITLE>
</HEAD>
<BODY>
<?php
  include('../../php8/yocto_api.php');
  include('../../php8/yocto_pwminput.php');

  // Use explicit error handling rather than exceptions
  YAPI::DisableExceptions();

  // Setup the API to use the VirtualHub on local machine
  if(YAPI::RegisterHub('http://127.0.0.1:4444/',$errmsg) != YAPI::SUCCESS) {
      die("Cannot contact VirtualHub on 127.0.0.1");
  }

  @$serial = $_GET['serial'];
  if ($serial != '') {
      // Check if a specified module is available online
      $pwm= YPwmInput::FindPwmInput("$serial.pwmInput1");
      if (!$pwm->isOnline()) {
          die("Module not connected (check serial and USB cable)");
      }
  } else {
      // or use any connected module suitable for the demo
      $pwm = YPwmInput::FirstPwmInput();
      if(is_null($pwm)) {
          die("No module connected (check USB cable)");
      }
  }
  $serial = $pwm->module()->get_serialnumber();

  Print("Module to use: <input name='serial' value='$serial'><br>");

  if ($pwm->isOnline())
   {  $pwm1 = YPwmInput::FindPwmInput($serial.".pwmInput1");
      $pwm2 = YPwmInput::FindPwmInput($serial.".pwmInput2");
      $freq1   = $pwm1->get_frequency();
      $dcycle1 = $pwm1->get_dutyCycle();
      $count1  = $pwm1->get_pulseCounter();
      $freq2   = $pwm2->get_frequency();
      $dcycle2 = $pwm2->get_dutyCycle();
      $count2  = $pwm2->get_pulseCounter();

      Printf("PWM1: %.1fHz %.1f%% %d pulse edges<br>",$freq1,$dcycle1,$count1);
      Printf("PWM2: %.1fHz %.1f%% %d pulse edges<br>",$freq2,$dcycle2,$count2);
   }
  YAPI::FreeAPI();

  // trigger auto-refresh after one second
  Print("<script language='javascript1.5' type='text/JavaScript'>\n");
  Print("setTimeout('window.location.reload()',1000);");
  Print("</script>\n");
?>
</BODY>
</HTML>
