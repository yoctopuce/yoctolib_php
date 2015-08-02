<HTML>
<HEAD>
    <TITLE>Hello World</TITLE>
</HEAD>
<BODY>
<FORM method='get'>
    <?php

    function readModBus($serialPort, $slave, $reg)
    {
        if($reg >= 40001) $res = $serialPort->modbusReadInputRegisters($slave, $reg - 40001, 1);
        else if($reg >= 30001) $res = $serialPort->modbusReadRegisters($slave, $reg - 30001, 1);
        else if($reg >= 10001) $res = $serialPort->modbusReadInputBits($slave, $reg - 10001, 1);
        else $res = $serialPort->modbusReadBits($slave, $reg - 1, 1);
        return $res[0];
    }

    include('../../../Sources/yocto_api.php');
    include('../../../Sources/yocto_serialport.php');

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

    $slave = "";
    if(isset($_GET["slave"])) $slave = $_GET["slave"];
    print('Please enter the MODBUS slave address (1...255)<br>');
    Print("slave:");
    if($slave == '') {
        Printf("<input name='slave'>");
    } else {
        print("<b>$slave</b><input name='slave' value='$slave' type='hidden'><br>");
        $reg = "";
        if(isset($_GET["reg"])) $reg = $_GET["reg"];
        print("Please select a Coil No (>=1), Input Bit No (>=10001+),<br>");
        print("       Register No (>=30001) or Input Register No (>=40001)<br>");
        Print("No:");
        if($reg == '') Printf("<input name='reg'>");
        else {
            print("<b>$reg</b><input name='reg' value='$reg' type='hidden'><br>");
            $reg = intVal($reg);
            $v = readModBus($serialPort, $slave, $reg);
            print("Current value: <b><span id='value'>$v</span></b><br>");

            if(($reg % 30000) < 10000) {
                printf(" Enter a new value: <input name='value'><br>");
                $value = '';
                if(isset($_GET["value"])) $value = $_GET["value"];
                if($value != '') {
                    if($reg >= 30001)
                        $serialPort->modbusWriteRegister($slave, $reg - 30001, intval($value));
                    else
                        $serialPort->modbusWriteBit($slave, $reg - 1, intval($value));
                    $v = readModBus($serialPort, $slave, $reg);
                    Print("<script>document.getElementById('value').innerHTML='$v'</SCRIPT>");
                }
            }
        }
    }
    ?>
    <input type='submit'>
</FORM>
</BODY>
</HTML> 
