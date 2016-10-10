<HTML>
<HEAD>
    <TITLE>Hello World</TITLE>
</HEAD>
<BODY>
<FORM method='get'>
    <?php
    include('../../Sources/yocto_api.php');
    include('../../Sources/yocto_serialport.php');

    // Use explicit error handling rather than exceptions
    yDisableExceptions();

    $address = '127.0.0.1';

    // Setup the API to use the VirtualHub on local machine,
    if(yRegisterHub($address, $errmsg) != YAPI_SUCCESS) {
        die("Cannot contact $address");
    }

    $serialPort = YSerialPort::FirstSerialPort();
    if($serialPort == null)
        die("No module found on $address (check USB cable)");
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
    yFreeAPI();
    ?>
    <input type='submit'>

</FORM>
</BODY>
</HTML>
