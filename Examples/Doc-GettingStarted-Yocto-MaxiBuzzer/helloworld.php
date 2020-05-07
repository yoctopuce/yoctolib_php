<HTML>
<HEAD>
    <TITLE>Hello World</TITLE>
</HEAD>
<BODY>
<FORM method='get'>
    <?php
    include('../../Sources/yocto_api.php');
    include('../../Sources/yocto_buzzer.php');
    include('../../Sources/yocto_colorled.php');
    include('../../Sources/yocto_anbutton.php');
    // Use explicit error handling rather than exceptions
    yDisableExceptions();

    // Setup the API to use the VirtualHub on local machine
    if(yRegisterHub('http://127.0.0.1:4444/', $errmsg) != YAPI_SUCCESS) {
        die("Cannot contact VirtualHub on 127.0.0.1");
    }

    @$serial = $_GET['serial'];
    if($serial != '') {
        // Check if a specified module is available online
        $buz = yFindBuzzer("$serial.buzzer");
        if(!$buz->isOnline()) {
            die("Module not connected (check serial and USB cable)");
        }
    } else {
        // or use any connected module suitable for the demo
        $buz = yFirstbuzzer();
        if(is_null($buz)) {
            die("No module connected (check USB cable)");
        } else {
            $serial = $buz->module()->get_serialnumber();
        }
    }

    Print("Module to use: <input name='serial' value='$serial'><br>");

    // Drive the selected module
    if($buz->isOnline()) {
        $button1 = YAnButton::FindAnButton($serial . ".anButton1");
        $button2 = YAnButton::FindAnButton($serial . ".anButton2");
        Printf("Button1 is " . (($button1->get_isPressed()) ? "pressed" : "released") . '<br>');
        Printf("Button2 is " . (($button2->get_isPressed()) ? "pressed" : "released") . '<br>');
        if(isset($_GET['freq'])) {
            $freq = intVal($_GET['freq']);
            $volume = intVal($_GET['volume']);
            $led = YColorLed::FindColorLed($serial . ".colorLed");
            $led->resetBlinkSeq();
            $led->addRgbMoveToBlinkSeq(0xff0000, 250);
            $led->addRgbMoveToBlinkSeq(0xff00, 250);
            $led->addRgbMoveToBlinkSeq(0xff, 250);
            $led->startBlinkSeq();
            $buz->set_volume($volume);
            for ($i = 0; $i < 5; $i++) {
                // this can be done using sequence as well
                $buz->set_frequency($freq);
                $buz->freqMove(2 * $freq, 250);
                YAPI::Sleep(250, $errmsg);
            }
            $buz->set_frequency(0);
            $led->stopBlinkSeq();
            $led->set_rgbColor(0);
        }
    } else {
        print ("Module offline");
    }
    yFreeAPI();
    ?>
    Frequency: <input name='freq' value='1000'>
    Volume (in %): <input name='volume' value='30'>
    <br><input type='submit'>
</FORM>
</BODY>
</HTML>
