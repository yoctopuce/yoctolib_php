<HTML>
<HEAD>
 <TITLE>Hello World</TITLE>
</HEAD>  
<BODY>
<FORM method='get'>
<?php
  include('../../Sources/yocto_api.php');
  include('../../Sources/yocto_colorled.php');

  // Use explicit error handling rather than exceptions
  yDisableExceptions();

  // Setup the API to use the VirtualHub on local machine
  if(yRegisterHub('http://127.0.0.1:4444/',$errmsg) != YAPI_SUCCESS) {
      die("Cannot contact VirtualHub on 127.0.0.1");
  }

  @$serial = $_GET['serial'];
  if ($serial != '') {
      // Check if a specified module is available online
      $led1 = yFindColorLed("$serial.colorLed1");   
      $led2 = yFindColorLed("$serial.colorLed2"); 
      if (!$led1->isOnline()) { 
          die("Module not connected (check serial and USB cable)");
      }
  } else {
      // or use any connected module suitable for the demo
      $led1 = yFirstColorLed();
      if(is_null($led1)) {
          die("No module connected (check USB cable)");
      } else {
          $led2   = $led1->nextColorLed();
          $serial = $led1->module()->get_serialnumber();
      }
  }
  Print("Module to use: <input name='serial' value='$serial'><br>");

  // Drive the selected module
  if (isset($_GET['color'])) {
      // Change the color in two different ways
      $color = hexdec($_GET['color']);
      $led1->set_rgbColor($color);  // immediate switch
      $led2->rgbMove($color,1000);  // smooth transition  
  } 
?>
<input type='radio' name='color' value='0xFF0000'>Red
<input type='radio' name='color' value='0x00FF00'>Green
<input type='radio' name='color' value='0x0000FF'>Blue
<br><input type='submit'>
</FORM>
</BODY>
</HTML> 
