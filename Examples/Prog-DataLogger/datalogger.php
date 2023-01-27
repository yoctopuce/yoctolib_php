<?php
include('../../php8/yocto_api.php');

// Use explicit error handling rather than exceptions
YAPI::DisableExceptions();

// Setup the API to use the VirtualHub on local machine
if (YAPI::RegisterHub('http://127.0.0.1:4444/', $errmsg) != YAPI::SUCCESS) {
    die("Cannot contact VirtualHub on 127.0.0.1");
}

function dumpSensor($sensor)
{
    $dataset = $sensor->get_recordedData(0, 0);
    $progress = 0;
    Printf("Using DataLogger of %s\n", $sensor->get_friendlyName());
    print("loading summary...\n");
    if (ob_get_level()) ob_flush();
    flush();
    $dataset->loadMore();
    $summary = $dataset->get_summary();
    Printf("%s | %s | %.3f | %.3f | %.3f\n",
        date("Y-m-d H:i:s", $summary->get_startTimeUTC()),
        date("Y-m-d H:i:s", $summary->get_endTimeUTC()),
        $summary->get_minValue(), $summary->get_averageValue(), $summary->get_maxValue());

    while ($progress < 100) {
        if (ob_get_level()) ob_flush();
        flush();
        $progress = $dataset->loadMore();
    }
    // load completed: show all results
    $details = $dataset->get_measures();
    print("from |   to   |  min |  avg | max\n");
    foreach ($details as $measure) {
        Printf("%s | %s | %.3f | %.3f | %.3f\n",
            date("Y-m-d H:i:s", $measure->get_startTimeUTC()),
            date("Y-m-d H:i:s", $measure->get_endTimeUTC()),
            $measure->get_minValue(), $measure->get_averageValue(), $measure->get_maxValue());
    }

}

// or use any connected module suitable for the demo
$sensor = YSensor::FirstSensor();
dumpSensor($sensor);
?>