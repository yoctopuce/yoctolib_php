<HTML>
<HEAD>
 <TITLE>Hello World</TITLE>
</HEAD>
<BODY>
<FORM method='get'>
<?php
  include('../../Sources/yocto_api.php');
  include('../../Sources/yocto_voltageoutput.php');

  // Use explicit error handling rather than exceptions
  YAPI::DisableExceptions();

  // Setup the API to use the VirtualHub on local machine
  if(YAPI::RegisterHub('http://127.0.0.1:4444/',$errmsg) != YAPI::SUCCESS) {
      die("Cannot contact VirtualHub on 127.0.0.1");
  }

  @$serial = $_GET['serial'];
  if ($serial != '') {
      // Check if a specified module is available online
      $vout1 = YVoltageOutput::FindVoltageOutput("$serial.voltageOutput1");
      $vout2 = YVoltageOutput::FindVoltageOutput("$serial.voltageOutput2");
      if (!$vout1->isOnline()) {
          die("Module not connected (check serial and USB cable)");
      }
  } else {
      // or use any connected module suitable for the demo
      $vout1 = YVoltageOutput::FirstVoltageOutput();
      if(is_null($vout1)) {
          die("No module connected (check USB cable)");
      } else {
          $serial = $vout1->module()->get_serialnumber();
          $vout1 = YVoltageOutput::FindVoltageOutput("$serial.voltageOutput1");
          $vout2 = YVoltageOutput::FindVoltageOutput("$serial.voltageOutput2");
      }
  }
  Print("Module to use: <input name='serial' value='$serial'><br>");
  if(isset($_GET['voltage'])) {
      $voltage = $_GET['voltage'];
      $vout1->set_dutyCycle($voltage);      // immediate change
      $vout2->dutyCycleMove($voltage,3000); // smooth change
   }
  YAPI::FreeAPI();
?>
<input type='radio' name='voltage' value='0'>Change Duty Cycle to 0 V<br>
<input type='radio' name='voltage' value='3.333'>Change Duty Cycle to 3.333 V<br>
<input type='radio' name='voltage' value='5.0'>Change Duty Cycle to 5.0 V<br>
<input type='radio' name='voltage' value='7.5'>Change Duty Cycle to 7.5 V<br>
<input type='radio' name='voltage' value='10.0'>Change Duty Cycle to 10.0 V<br>
<input type='submit'>
</FORM>
</BODY>
</HTML>
