<?php
include('../../Sources/yocto_api.php');
include('../../Sources/yocto_buzzer.php');
include('../../Sources/yocto_colorledcluster.php');
include('../../Sources/yocto_anbutton.php');
include('../../Sources/yocto_quadratureDecoder.php');

function notefreq($note)
{
    return intval(220.0 * exp($note * log(2) / 12));
}

// Use explicit error handling rather than exceptions
YAPI::DisableExceptions();

// Setup the API to use the VirtualHub on local machine
if (YAPI::RegisterHub('http://127.0.0.1:4444/', $errmsg) != YAPI_SUCCESS) {
    die("Cannot contact VirtualHub on 127.0.0.1");
}

@$serial = $_GET['serial'];
if ($serial != '') {
    // Check if a specified module is available online
    $buz = YBuzzer::FindBuzzer("$serial.buzzer");
    if (!$buz->isOnline()) {
        die("Module not connected (check serial and USB cable)");
    }
} else {
    // or use any connected module suitable for the demo
    $buz = YBuzzer::Firstbuzzer();
    if (is_null($buz)) {
        die("No module connected (check USB cable)");
    } else {
        $serial = $buz->module()->get_serialnumber();
    }
}

print("Module in use: $serial\n");

// Drive the selected module
if ($buz->isOnline()) {
    $button = YAnButton::FindAnButton($serial . ".anButton1");
    $qd = YQuadratureDecoder::FindQuadratureDecoder($serial . ".quadratureDecoder1");
    $leds = YColorLedCluster::FindColorLedCluster($serial . ".colorLedCluster");

    if ((!$button->isOnline()) || (!$qd->isOnline())) {
        die("Make sure the Yocto-MaxiBuzzer is configured with at least one anButton and one quadrature Decoder\n");
    }
    $lastPos = intval($qd->get_currentValue());
    $buz->set_volume(75);

    print("press anbutton #1,  turn the encoder #1 or hit Ctrl-C\n");
    while ($button->isOnline()) {
        if (($button->get_isPressed() == YAnButton::ISPRESSED_TRUE) && ($lastPos != 0)) {
            $lastPos = 0;
            $qd->set_currentValue(0);
            $buz->playNotes("'E32 C8");
            $leds->set_rgbColor(0, 1, 0x000000);
        } else {
            $p = intval($qd->get_currentValue());
            if ($lastPos != $p) {
                $lastPos = $p;
                $buz->pulse(notefreq($p), 500);
                $leds->set_hslColor(0, 1, 0x00FF7f | ($p % 255) << 16);
            }
        }
    }
}
YAPI::FreeAPI();
?>