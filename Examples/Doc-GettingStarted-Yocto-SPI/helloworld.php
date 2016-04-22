<HTML>
<HEAD>
 <TITLE>Hello World</TITLE>
</HEAD>  
<BODY>
<FORM method='get'>
<?php
  include('../../Sources/yocto_api.php');
  include('../../Sources/yocto_spiport.php');

  // Use explicit error handling rather than exceptions
  yDisableExceptions();

  // Setup the API to use the VirtualHub on local machine
  if(yRegisterHub('http://127.0.0.1:4444/',$errmsg) != YAPI_SUCCESS) {
      die("Cannot contact VirtualHub on 127.0.0.1");
  }

  @$serial = $_GET['serial'];
  if ($serial != '') {
      // Check if a specified module is available online
      $spiport = yFindSpiPort("$serial.spiPort");
      if (!$spiport->isOnline()) { 
          die("Module not connected (check serial and USB cable)");
      }
  } else {
      // or use any connected module suitable for the demo
      $spiport = yFirstSpiPort();
      if(is_null($spiport)) {
          die("No module connected (check USB cable)");
      } else {
          $serial = $spiport->module()->get_serialnumber();
      }
  }
  Print("Module to use: <input name='serial' value='$serial'><br>");
  
  $spiport->set_spiMode("250000,2,msb");
  $spiport->set_ssPolarity(Y_SSPOLARITY_ACTIVE_LOW);
  $spiport->set_protocol("Frame:5ms");
  $spiport->reset();
  Print("****************************<br>");
  Print("* make sure voltage levels *<br>");
  Print("* are properly configured  *<br>");
  Print("****************************<br>");
  // initialize MAX7219
  $spiport->writeHex('0c01'); // Exit from shutdown state
  $spiport->writeHex('09ff'); // Enable BCD for all digits
  $spiport->writeHex('0b07'); // Enable digits 0-7 (=8 in total)
  $spiport->writeHex('0a0a'); // Set medium brightness
  if(isset($_GET['value'])) {
      $value = intVal($_GET['value']);
      for($i = 1; $i <= 8; $i++) {
          $digit = $value % 10;
          $spiport->writeArray(Array($i, $digit));
          $value = intVal($value / 10);
      }  
  }
?>  
Value to display: <input name='value' value='1234'><br>
<input type='submit'>
</FORM>
</BODY>
</HTML> 
