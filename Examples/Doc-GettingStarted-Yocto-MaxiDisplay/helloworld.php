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

  // reteive the first layer
  $l0=$disp->get_displayLayer(0);
  $l0->clear();

  // display a text in the middle of the screen
  $l0->drawText($w / 2, $h / 2, YDisplayLayer::ALIGN_CENTER, "Hello world!" );

  // visualize each corner
  $l0->moveTo(0,5);      $l0->lineTo(0,0);      $l0->lineTo(5,0);
  $l0->moveTo(0,$h-6);   $l0->lineTo(0,$h-1);   $l0->lineTo(5,$h-1);
  $l0->moveTo($w-1,$h-6);$l0->lineTo($w-1,$h-1);$l0->lineTo($w-6,$h-1);
  $l0->moveTo($w-1,5);   $l0->lineTo($w-1,0);   $l0->lineTo($w-6,0);
  YAPI::FreeAPI();

?>
<br><input type='submit' value="Refresh">
</FORM>
</BODY>
</HTML>
