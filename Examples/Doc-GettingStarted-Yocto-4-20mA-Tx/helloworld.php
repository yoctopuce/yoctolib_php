<HTML>
<HEAD>
 <TITLE>Hello World</TITLE>
</HEAD>
<BODY>
<FORM method='get'>
<?php
  include('../../Sources/yocto_api.php');
  include('../../Sources/yocto_currentLoopOutput.php');

  // Use explicit error handling rather than exceptions
  YAPI::DisableExceptions();

  // Setup the API to use the VirtualHub on local machine
  if(YAPI::RegisterHub('http://127.0.0.1:4444/',$errmsg) != YAPI::SUCCESS) {
      die("Cannot contact VirtualHub on 127.0.0.1");
  }

  @$serial = $_GET['serial'];
  if ($serial != '') {
      // Check if a specified module is available online
      $loop = YCurrentLoopOutput::FindCurrentLoopOutput("$serial.currentLoopOutput");
      if (!$loop->isOnline()) {
          die("Module not connected (check serial and USB cable)");
      }
  } else {
      // or use any connected module suitable for the demo
      $loop = YCurrentLoopOutput::FirstCurrentLoopOutput();
      if(is_null($loop)) {
          die("No module connected (check USB cable)");
      } else {
          $serial = $loop->module()->get_serialnumber();
          $loop = YCurrentLoopOutput::FindCurrentLoopOutput("$serial.currentLoopOutput");
      }
  }

  Print("Module to use: <input name='serial' value='$serial'><br>");
  if(isset($_GET['value'])) {
      $value = floatval($_GET['value']);
      $loop->set_current($value);      // immediate change
      Printf("Current loop set to $value mA<br>");

   }

   switch ($loop->get_loopPower()) {
    case Y_LOOPPOWER_POWEROK:
        print('Loop is powered<br>');
        break;
    case Y_LOOPPOWER_LOWPWR:
        print('Insufficient loop Voltage<br>');
        break;
    default  :
        print('Loop is not Powered<br>');
        break;
    }
  YAPI::FreeAPI();

?>
<input type='radio' name='value' value='4'>Change current loop to 4mA<br>
<input type='radio' name='value' value='8'>Change current loop to 8mA<br>
<input type='radio' name='value' value='12'>Change current loop to 12mA<br>
<input type='radio' name='value' value='16'>Change current loop to 16mA<br>
<input type='radio' name='value' value='20'>Change current loop to 20mA<br>
<input type='submit'>
</FORM>
</BODY>
</HTML>