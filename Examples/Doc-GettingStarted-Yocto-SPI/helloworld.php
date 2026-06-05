<HTML>
<HEAD>
    <TITLE>Hello World</TITLE>
</HEAD>
<BODY>

 Yocto-SPI & SPI7SEGDISP8.56 7-segments display<br><br>
 

 
<FORM method='get'>
    <?php
    include('../../php8/yocto_api.php');
    include('../../php8/yocto_spiport.php');

    // Use explicit error handling rather than exceptions
    YAPI::DisableExceptions();

    $address = '127.0.0.1';

    // Setup the API to use the VirtualHub on local machine,
    if(YAPI::RegisterHub($address, $errmsg) != YAPI::SUCCESS) {
        die("Cannot contact $address");
    }

    $spiPort = YSpiPort::FirstSpiPort();
    if($spiPort == null)
        die("No module found on $address (check USB cable)");
    print('Make sure voltage levels are properly configured <br>');
    print('Type a number to show on the SPI7SEGDISP8.56 module<br>');
    print("<input name='tosend'><br>");
    
    if(isset($_GET["tosend"])) 
     { $value = intval($_GET["tosend"]);
       
       if ($spiPort->isOnline()) {
        $spiPort->set_spiMode("250000,3,msb");
        $spiPort->set_ssPolarity(YSpiPort::SSPOLARITY_ACTIVE_LOW);
        $spiPort->set_protocol("Frame:2ms");
        $spiPort->reset();
        // do not forget to configure the powerOutput of the Yocto-SPI
        // ( for SPI7SEGDISP8.56 powerOutput need to be set at 5v )
      

        $spiPort->writeHex("0c01"); // Exit from shutdown state
        $spiPort->writeHex("09ff"); // Enable BCD for all digits
        $spiPort->writeHex("0b07"); // Enable digits 0-7 (=8 in total)
        $spiPort->writeHex("0a0a"); // Set medium brightness
        
        for ($i = 1; $i <= 8; $i++) {
          $digit = $value % 10; // digit value
          $spiPort->writeArray(array( $i, $digit ));
          $value = intdiv($value, 10);
        }
      } 
      else 
      {
        print("Module not connected");
        print("check identification and USB cable");
      }
    }   
    YAPI::FreeAPI();    
    ?>
    <input type='submit'>

</FORM>
</BODY>
</HTML>
