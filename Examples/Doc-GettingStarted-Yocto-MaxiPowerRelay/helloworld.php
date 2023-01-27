<HTML>
<HEAD>
    <TITLE>Hello World</TITLE>
</HEAD>
<BODY>
<FORM method='get'>
    <?php
    include('../../php8/yocto_api.php');
    include('../../php8/yocto_relay.php');

    // Use explicit error handling rather than exceptions
    YAPI::DisableExceptions();

    // Setup the API to use the VirtualHub on local machine
    if (YAPI::RegisterHub('http://127.0.0.1:4444/', $errmsg) != YAPI::SUCCESS)
        die("Cannot contact VirtualHub on 127.0.0.1");

    @$serial = $_GET['serial'];
    $relay = Array();

    if ($serial == '') { //  use any connected module suitable for the demo
        $relay[1] = YRelay::FirstRelay();
        if (is_null($relay[1])) die("No module connected (check USB cable)");
        $serial = $relay[1]->module()->get_serialnumber();
    }

    for ($i = 1; $i <= 5; $i++)
        $relay[$i] = YRelay::FindRelay("$serial.relay$i");

    if (!$relay[1]->isOnline())
        die("Module not connected (check serial and USB cable)");

    Print("Module to use: <input name='serial' value='$serial'><br>");

    // Drive the selected module
    for ($i = 1; $i <= 5; $i++)
        if (isset($_GET["state$i"])) {
            $state = $_GET["state$i"];
            if ($state == 'ON') $relay[$i]->set_output(Y_OUTPUT_ON);
            else $relay[$i]->set_output(Y_OUTPUT_OFF);
        }

    // display very primitive UI
    for ($i = 1; $i <= 5; $i++) {
        $state = $relay[$i]->get_output();
        $ON = '';
        $OFF = '';
        if ($relay[$i]->get_output() == Y_OUTPUT_ON) $ON = 'checked'; else  $OFF = 'checked';
        Print("Relay $i: <input type='radio' $ON name='state$i' value='ON'>ON");
        Print ("<input type='radio' $OFF name='state$i' value='OFF'>OFF<br>\n");
    }
    YAPI::FreeAPI();
    ?>

    <input type='submit'>
</FORM>
</BODY>
</HTML>
