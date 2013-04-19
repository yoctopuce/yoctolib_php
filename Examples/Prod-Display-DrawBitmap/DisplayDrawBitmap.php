
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
  yDisableExceptions();

  // Setup the API to use the VirtualHub on local machine
  if(yRegisterHub('http://127.0.0.1:4444/',$errmsg) != YAPI_SUCCESS) {
      die("Cannot contact VirtualHub on 127.0.0.1");
  }

  @$serial = $_GET['serial'];
  if ($serial != '') {
      // Check if a specified module is available online
      $disp = yFindDisplay("$serial.display");   
      if (!$disp->isOnline()) { 
          die("Module not connected (check serial and USB cable)");
      }
  } else {
      // or use any connected module suitable for the demo
      $disp = yFirstDisplay();
      if(is_null($disp)) {
          die("No module connected (check USB cable)");
      }  
   }
  $serial = $disp->get_module()->get_serialNumber(); 
  Print("Module to use: <input name='serial' value='$serial'><br>");

  
    $l0 = $disp->get_displayLayer(0);
    $l1 = $disp->get_displayLayer(1);
  
    $disp->resetAll();
    $w = $disp->get_displayWidth();
    $h = $disp->get_displayHeight();
    $bytesPerLines = $w / 8;
    $data = Array( $h * $bytesPerLines);
    
    $max_iteration = 50;
    $centerX = 0;
    $centerY = 0;
    $targetX =  0.834555980181972;
    $targetY  = 0.204552998862566;
    $zoom    = 1;
    $distance = 1;
    while (true)
     { for ($i=0;$i<$h * $bytesPerLines ;$i++)
        { $data[$i] = 0;
        }
    
       $distance = $distance *0.95;
       $centerX =  $targetX * (1-$distance);
       $centerY =  $targetY * (1-$distance);
       $max_iteration = intVal(0.5+$max_iteration  + sqrt($zoom) );
       if ($max_iteration>1500)  $max_iteration = 1500;
          
       for ($j=0;$j<$h;$j++) 
         for ($i=0;$i<$w;$i++)
          {  
             
             $x0 = ((($i - $w/2) / ($w/8))/$zoom)-$centerX;
             $y0 = ((($j - $h/2) / ($w/8))/$zoom)-$centerY;
         
             $x = 0;
             $y = 0;

             $iteration = 0;
          
             while ( $x*$x + $y*$y < 2*2  AND  $iteration < $max_iteration )
              { $xtemp = $x*$x - $y*$y + $x0;
                $y = 2*$x*$y + $y0;
                $x = $xtemp;
                $iteration = $iteration + 1;
              }

             if ($iteration==$max_iteration)
              { $data[$j*$bytesPerLines + ($i>>3) ] |= 128 >> ($i%8);   
                //$l0->drawpixel($i,$j);
              }  
           } 
        $bin = "";
        for ($i=0;$i<$h * $bytesPerLines ;$i++)
          {
           $bin.= pack("C",$data[$i]);
        
          }  
        $l0->drawBitmap(0,0,$w,$bin,0); 
       
        $zoom =$zoom / 0.95;
    }
    

?>
<br><input type='submit'>
</FORM>
</BODY>
</HTML> 

