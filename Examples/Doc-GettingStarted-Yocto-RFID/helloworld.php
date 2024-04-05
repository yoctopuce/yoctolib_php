<?php
include('../../php8/yocto_api.php');
include('../../php8/yocto_buzzer.php');
include('../../php8/yocto_colorledcluster.php');
include('../../php8/yocto_anbutton.php');
include('../../php8/yocto_rfidreader.php');

function notefreq($note)
{
    return intval(220.0 * exp($note * log(2) / 12));
}

// Use explicit error handling rather than exceptions
YAPI::DisableExceptions();
$errmsg = "";

// Setup the API to use the VirtualHub on local machine
if (YAPI::RegisterHub('http://127.0.0.1:4444/', $errmsg) != YAPI_SUCCESS)
{   die("Cannot contact VirtualHub on 127.0.0.1");
}

@$serial = $_GET['serial'];
if ($serial != '') {
    // Check if a specified module is available online
    $reader = YRfidReader::FindRfidReader("$serial.rfidReader");
    if (!$reader->isOnline()) {
        die("Module not connected (check serial and USB cable)");
    }
} else {
    // or use any connected module suitable for the demo
    $reader = YRfidReader::FirstRfidReader();
    if (is_null($reader)) {
        die("No module connected (check USB cable)");
    } else {
        $serial = $reader->module()->get_serialnumber();
    }
}

print("Module in use: $serial\n");

// Drive the selected module
if ($reader->isOnline())
 {  $button = YAnButton::FindAnButton($serial . ".anButton1");
    $buzzer = YBuzzer::FindBuzzer($serial . ".buzzer");
    $leds = YColorLedCluster::FindColorLedCluster($serial . ".colorLedCluster");

    $buzzer->set_volume(75);
    $leds->set_rgbColor(0,1,0x000000);

    print("Place a RFID tag near the Antenna\n");

    $tagList = [];
    do
    { $tagList = $reader->get_tagIdList();
    } while (sizeof($tagList)<=0);


    $tagId      = $tagList[0];
    $opStatus   = new YRfidStatus();
    $options    = new YRfidOptions();
    $taginfo    = $reader->get_tagInfo($tagId,$opStatus);
    $blocksize  = $taginfo->get_tagBlockSize();
    $firstBlock = $taginfo->get_tagFirstBlock();
    print("Tag ID          = ".$taginfo->get_tagId()."\n");
    print("Tag Memory size = ".$taginfo->get_tagMemorySize()." bytes"."\n");
    print("Tag Block  size = ".$taginfo->get_tagBlockSize()." bytes"."\n");

    $data = $reader->tagReadHex($tagId, $firstBlock, 3*$blocksize, $options, $opStatus);
    if ($opStatus->get_errorCode()==YRfidStatus::SUCCESS)
    { print ("First 3 blocks  = ".$data."\n");
      $leds->set_rgbColor(0,1,0x00FF00);
      $buzzer->pulse(1000,100);
    }
   else
   { print("Cannot read tag contents ("+$opStatus->get_errorMessage()+")");
     $leds->set_rgbColor(0, 1, 0xFF0000);
   }
   $leds->rgb_move(0, 1, 0x000000, 200);

}
YAPI::FreeAPI();
?>