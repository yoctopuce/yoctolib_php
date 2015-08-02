<HTML>
<HEAD>
 <TITLE>Hello World</TITLE>
</HEAD>  
<BODY>
<FORM method='get'>
<?php
  include('../../Sources/yocto_api.php');
  include('../../Sources/yocto_servo.php');

  // Use explicit error handling rather than exceptions
  yDisableExceptions();

  // Setup the API to use the VirtualHub on local machine
  if(yRegisterHub('http://127.0.0.1:4444/',$errmsg) != YAPI_SUCCESS) {
      die("Cannot contact VirtualHub on 127.0.0.1");
  }

  @$serial = $_GET['serial'];
  if ($serial != '') {
      // Check if a specified module is available online
      $servo1 = yFindServo("$serial.servo1");
      $servo5 = yFindServo("$serial.servo5");
      if (!$servo1->isOnline()) { 
          die("Module not connected (check serial and USB cable)");
      }
  } else {
      // or use any connected module suitable for the demo
      $servo1 = yFirstServo();
      if(is_null($servo1)) {
          die("No module connected (check USB cable)");
      } else {
          $serial = $servo1->module()->get_serialnumber();
          $servo1 = yFindServo("$serial.servo1");
          $servo5 = yFindServo("$serial.servo5");
      }
  }
  Print("Module to use: <input name='serial' value='$serial'><br>");

  if(isset($_GET['pos'])) {
      $pos = $_GET['pos'];
      $servo1->set_position($pos); // move as fast as possible
      $servo5->move($pos,3000);    // move in 3 seconds
   }      
?>  
<input type='radio' name='pos' value='-1000'>Move to -1000<br>
<input type='radio' name='pos' value='-500'>Move to -500<br>
<input type='radio' name='pos' value='0'>Move to center<br>
<input type='radio' name='pos' value='500'>Move to 500<br>
<input type='radio' name='pos' value='1000'>Move to 1000<br>
<input type='submit'>
</FORM>
</BODY>
</HTML> 
