
<HTML>
<HEAD>
 <TITLE>Hello World</TITLE>
</HEAD>
<BODY>
<FORM method='get'>
<?php
  include('../../Sources/yocto_api.php');
  include('../../Sources/yocto_display.php');



  // Use explicit error handling rather than exceptions
  YAPI::DisableExceptions();

  // Setup the API to use the VirtualHub on local machine
  if(YAPI::RegisterHub('http://127.0.0.1:4444/',$errmsg) != YAPI::SUCCESS) {
      die("Cannot contact VirtualHub on 127.0.0.1");
  }

  @$serial = $_GET['serial'];
  if ($serial != '') {
      // Check if a specified module is available online
      $disp = YDisplay::FindDisplay("$serial.display");
      if (!$disp->isOnline()) {
          die("Module not connected (check serial and USB cable)");
      }
  } else {
      // or use any connected module suitable for the demo
      $disp = YDisplay::FirstDisplay();
      if(is_null($disp)) {
          die("No module connected (check USB cable)");
      }
   }
  $serial = $disp->get_module()->get_serialNumber();
  Print("Module to use: <input name='serial' value='$serial'><br>");


  $disp->resetAll();
  // retreive the display size

  $w=$disp->get_displayWidth();
  $h=$disp->get_displayHeight();

  //reteive the first layer
  $l0 = $disp->get_displayLayer(0);
 $count =8 ;
  $coord = array(2*$count);

  // precompute the "leds" position

  $ledwidth = intVal($w / $count);
  for ($i=0 ; $i<$count ;$i++)
  {  $coord[$i] = $i *$ledwidth;
     $coord[2*$count-$i-2] = $coord[$i] ;
  }

  $framesCount =  2*$count-2;

  // start recording
  $disp->newSequence();

  // build one loop for recording
  for ($i=0;$i<$framesCount;$i++)
    {  $l0->selectColorPen(0);
       $l0->drawBar($coord[($i+$framesCount-1) % $framesCount], $h-1,$coord[($i+$framesCount-1) % $framesCount]+$ledwidth, $h-4);
       $l0->selectColorPen(0xffffff);
       $l0->drawBar($coord[$i], $h-1, $coord[$i]+$ledwidth, $h-4);
       $disp->pauseSequence(50);  // records a 50ms pause.
    }
  // self-call : causes an endless looop
  $disp->playSequence("K2000.seq");
  // stop recording and save to device filesystem
  $disp->saveSequence("K2000.seq");

  // play the sequence
  $disp->playSequence("K2000.seq");


?>
<br><input type='submit'>
</FORM>
This animation is running in background
</BODY>
</HTML>

