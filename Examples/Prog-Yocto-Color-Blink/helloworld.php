<HTML>
<HEAD>
 <TITLE>Hello World</TITLE>
</HEAD>  
<BODY>
<?php
  include('../../Sources/yocto_api.php');
  include('../../Sources/yocto_colorLed.php');

  // Use explicit error handling rather than exceptions
  yDisableExceptions();

  // Setup the API to use the VirtualHub on local machine
  if(yRegisterHub('http://127.0.0.1:4444/',$errmsg) != YAPI_SUCCESS) {
      die("Cannot contact VirtualHub on 127.0.0.1");
  }

  $led = yFirstColorLed();
  if(is_null($led)) {
      die("No led connected (check USB cable and firmware version)");
  }
  $led->resetBlinkSeq();                       // cleans the sequence
  $led->addRgbMoveToBlinkSeq(0x00FF00,500);    // move to green in 500 ms
  $led->addRgbMoveToBlinkSeq(0x000000,   0);   // switch to black instantaneously
  $led->addRgbMoveToBlinkSeq(0x000000,  250);   // stays black for 250ms
  $led->addRgbMoveToBlinkSeq(0x0000FF,    0);  // switch to blue instantaneously
  $led->addRgbMoveToBlinkSeq(0x0000FF,  100);  // stays blue for 100ms
  $led->addRgbMoveToBlinkSeq(0x000000,   0);   // switch to black instantaneously
  $led->addRgbMoveToBlinkSeq(0x000000,  250);  // stays black for 250ms
  $led->addRgbMoveToBlinkSeq(0xFF0000,    0);  // switch to red instantaneously
  $led->addRgbMoveToBlinkSeq(0xFF0000,  100);  // stays red for 100ms
  $led->addRgbMoveToBlinkSeq(0x000000,    0);  // switch to black instantaneously
  $led->addRgbMoveToBlinkSeq(0x000000, 1000);  // stays black for 1s
  $led->startBlinkSeq();                       // starts sequence 
  
  Print("The Yocto-Color is now blinking autonomously");
?>  
</BODY>
</HTML> 
