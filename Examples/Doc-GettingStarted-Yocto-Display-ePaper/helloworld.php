<HTML>
<HEAD>
 <TITLE>Hello World</TITLE>
</HEAD>
<BODY>
<FORM method='get'>
<?php
  include('../../php8/yocto_api.php');
  include('../../php8/yocto_display.php');

  // Use explicit error handling rather than exceptions
  YAPI::DisableExceptions();
  $errmsg ="";
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

  $colors = [ 0xFFFFFF, 0x000000, 0xFF0000, 0xFFFF00 ];

   // Makes sure the Panel type is set
   $paneltype = $disp->get_displayPanel();
   if ($paneltype== "NOT_SET")
     {  die(" Use the virtual to configure the panel first");

     }
   // retrieve the display size
   $w = $disp->get_displayWidth();
   $h = $disp->get_displayHeight();
   $middleX = (int)($w / 2);
   $middleY = (int)($h / 2);
   Print(" Using device {$disp->get_serialNumber()}  (panel: $paneltype $w x $h pixels)");
   $disp->resetAll();

   // retrieve the first layer
   $l0 = $disp->get_displayLayer(0);
   $l0->selectFont("medium.yfm");
   $disp->regenerateDisplay(); // kaes sure next refres will be a full one
    // prevent refreshing for 2 sec
   $disp->postponeRefresh(2000);
   $l0->clear();
   // draw a few circles
   for ($i = 0; $i < 15; $i++)
    {
      $cx = rand(0,$w) ;
      $cy = rand(0,$h) ;
      $r  = rand( ($h / 20) ,  ($h / 10) );
      $l0->selectFillColor($colors[rand() % 4]);
      $l0->drawDisc($cx, $cy, $r);
      $l0->drawCircle($cx, $cy, $r);
  }
  // draw a rectangle with panel type in it
  $l0->selectFillColor(0xffffff);
  $l0->drawBar($middleX - 75,  $middleY - 10, $middleX + 75, $middleY + 12);
  $l0->drawRect($middleX - 75, $middleY - 10, $middleX + 75, $middleY + 12);
  $l0->drawText($middleX, $middleY, YDisplayLayer::ALIGN_CENTER, $paneltype);
  // forces a full refresh only the 1rst time
  $disp->triggerRefresh(); // display is allowed to refresh  again
  YAPI::FreeAPI();

?>
<br><input type='submit' value="Refresh">
</FORM>
</BODY>
</HTML>
