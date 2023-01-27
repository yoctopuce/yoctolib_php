<HTML>
<HEAD>
    <TITLE>Hello World</TITLE>
</HEAD>
<BODY>
<FORM method='get'>
    <?php
    include('../../../php8/yocto_api.php');
    include('../../../php8/yocto_serialport.php');

    // Use explicit error handling rather than exceptions
    YAPI::DisableExceptions();

    $address = '127.0.0.1';

    // Setup the API to use the VirtualHub on local machine,
    if(YAPI::RegisterHub($address, $errmsg) != YAPI::SUCCESS) {
        die("Cannot contact $address");
    }

    $serialPort = YSerialPort::FirstSerialPort();
    if($serialPort == null)
        die("No module found on $address (check USB cable)");
    print('<b>** make sure voltage levels are properly configured **</b>');
    print('Type line to send<br>');
    print("<input name='tosend'>");
    if(isset($_GET["tosend"])) {
        $tosend = $_GET["tosend"];
        $serialPort->writeLine($tosend);
        YAPI::Sleep(500);
        do {
            $line = $serialPort->readLine();
            if($line != "") {
               print("Received: " . $line . "<br/>");
            }
        } while ($line != '');
    } else {
        $serialPort->set_serialMode("9600,8N1");
        $serialPort->set_protocol("Line");
        $serialPort->reset();
    }
    YAPI::FreeAPI();
    ?>
    <input type='submit'>

</FORM>
</BODY>
</HTML>
