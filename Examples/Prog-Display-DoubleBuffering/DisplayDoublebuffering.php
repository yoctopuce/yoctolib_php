
<HTML>
<HEAD>
 <TITLE>Hello World</TITLE>
</HEAD>
<BODY>
<FORM method='get'>
<?php
  include('../../Sources/yocto_api.php');
  include('../../Sources/yocto_display.php');

  function recursiveLine($layer,$x0,$y0,$x1,$y1,$deep)
     { if ($deep<=0)
        { $layer->moveto(round($x0),round($y0));
          $layer->lineto(round($x1),round($y1));
        }
       else
        { $dx = ($x1-$x0) /3;
          $dy = ($y1-$y0) /3;
          $mx =  (($x0+$x1) / 2) +  (0.87 *($y1-$y0) / 3);
          $my =  (($y0+$y1) / 2) -  (0.87 *($x1-$x0) / 3);
          recursiveLine($layer,$x0,$y0,$x0+$dx,$y0+$dy,$deep-1);
          recursiveLine($layer,$x0+$dx,$y0+$dy,$mx,$my,$deep-1);
          recursiveLine($layer,$mx,$my,$x1-$dx,$y1-$dy,$deep-1);
          recursiveLine($layer,$x1-$dx,$y1-$dy,$x1,$y1,$deep-1);
        }
     }

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
  $l1 = $disp->get_displayLayer(1);
  $l2 = $disp->get_displayLayer(2);
  $l2->drawBar(0,0,1,1);
  $l1->hide();
  $centerX = $disp->get_displayWidth() / 2;
  $centerY = $disp->get_displayHeight() / 2;
  $radius  = $disp->get_displayHeight() / 2;
  $a=0;

  while (true)
    { $l1->clear();
      for ($i=0 ; $i <3 ; $i++)
        recursiveLine($l1,$centerX + $radius*cos($a+$i*2.094),
                   $centerY + $radius*sin($a+$i*2.094) ,
                   $centerX + $radius*cos($a+($i+1)*2.094),
                   $centerY + $radius*sin($a+($i+1)*2.094), 2);
      $l1->flush_now();
      $disp->copyLayerContent(1,2);
      $a=$a+0.1257;
   }

?>
<br><input type='submit'>
</FORM>
</BODY>
</HTML>

