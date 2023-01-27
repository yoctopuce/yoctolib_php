<HTML>
<HEAD>
    <TITLE>Hello World</TITLE>
</HEAD>
<BODY>
<FORM method='get'>
    <?php
    include('../../php8/yocto_api.php');
    include('../../php8/yocto_buzzer.php');
    include('../../php8/yocto_led.php');
    include('../../php8/yocto_anbutton.php');
    // Use explicit error handling rather than exceptions
    YAPI::DisableExceptions();

    // Setup the API to use the VirtualHub on local machine
    if(YAPI::RegisterHub('http://127.0.0.1:4444/', $errmsg) != YAPI::SUCCESS) {
        die("Cannot contact VirtualHub on 127.0.0.1");
    }

    @$serial = $_GET['serial'];
    if($serial != '') {
        // Check if a specified module is available online
        $buz = YBuzzer::FindBuzzer("$serial.buzzer");
        if(!$buz->isOnline()) {
            die("Module not connected (check serial and USB cable)");
        }
    } else {
        // or use any connected module suitable for the demo
        $buz = YBuzzer::FirstBuzzer();
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

            $led1 = YLed::FindLed($serial . ".led1");
            $led1->set_power(YLed::POWER_ON);
            $led1->set_luminosity(100);
            $led1->set_blinking(YLed::BLINKING_PANIC);
            $led2 = YLed::FindLed($serial . ".led2");
            $led2->set_power(YLed::POWER_ON);
            $led2->set_luminosity(100);
            $led2->set_blinking(YLed::BLINKING_PANIC);
            for ($i = 0; $i < 5; $i++) {
                // this can be done using sequence as well
                $buz->set_frequency($freq);
                $buz->freqMove(2 * $freq, 250);
                YAPI::Sleep(250, $errmsg);
            }
            $buz->set_frequency(0);
            $led1->set_power(YLed::POWER_OFF);
            $led2->set_power(YLed::POWER_OFF);
        }
    } else {
        print ("Module offline");
    }
    YAPI::FreeAPI();

    ?>
    Frequency: <input name='freq' value='1000'>
    <br><input type='submit'>
</FORM>
</BODY>
</HTML>
