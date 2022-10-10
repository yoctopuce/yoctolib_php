<?php
include('../../Sources/yocto_api.php');
include('../../Sources/yocto_network.php');
include('../../Sources/yocto_files.php');
include('../../Sources/yocto_display.php');

$error = "";
//YAPI::DisableExceptions();
function saveLog2DB($serial, $logs)
{
    print("Logs of $serial\n");
    //print($logs);
}


if (YAPI::TestHub("callback", 10, $error) == YAPI::SUCCESS) {
    YAPI::SetHTTPCallbackCacheDir("cache_dir");

    try {
        YAPI::RegisterHub("callback");
        $debug_msg = sprintf("\ncallback time is %s \n", date("h:i:sa"));
        $module = YModule::FirstModule();
        while (!is_null($module)) {
            $debug_msg .= " - " . $module->get_serialNumber() . " " . $module->get_logicalName() . "\n";
            $module->clearCache();
            $module = $module->nextModule();
        }

        $module = YModule::FirstModule();
        while (!is_null($module)) {
            $debug_msg .= " - " . $module->get_serialNumber() . " " . $module->get_upTime() . "\n";
            $module = $module->nextModule();
        }

        file_put_contents("debug.txt", $debug_msg, FILE_APPEND);
        print($debug_msg);
    } catch (YAPI_Exception $ex) {
        $message = "Exeption:" . $ex->getMessage() . "\n";
        $message .= $ex->getTraceAsString();
        print($message);
        file_put_contents("debug.txt", $message, FILE_APPEND);
    }
    die();

    /*
    $YFiles = YFiles::FirstFiles();
    $YFiles->get_module()->addFileToHTTPCallback("myconfig.txt");

        $download = $YFiles->download("myconfig.txt");
        print($download);

        $display = YDisplay::FirstDisplay();
        $YModule = $display->get_module();
        $YModule->addFileToHTTPCallback("display.gif");

        $gif_preview = $YModule->download("display.gif");
        file_put_contents("last_preview.gif", $gif_preview);

    $module = YModule::FirstModule();
    while (!is_null($module)) {
        $module->addFileToHTTPCallback("logs.txt");
        $logs = $module->get_lastLogs();
        saveLog2DB($module->get_serialNumber(), $logs);
        $module = $module->nextModule();
    }


    //$network = YNetwork::FirstNetwork();
    //$yhub = $network->get_module();
    //$yhub->download("")
    // or use any connected module suitable for the demo
    //$sensor = YSensor::FirstSensor();
    //$sensor->get_module()->addFileToHTTPCallback("logger.json?id=genericSensor2");
    //dumpSensor($sensor);
    */


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

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Yoctopuce HTTP Callback</title>
</head>
<body>
<b>This example need to be run by a VirtualHub or a YoctoHub.</b><br/>
<ol>
    <li>Connect to the web interface of the VirtualHub or YoctoHub that will run this script.</li>
    <li>Click on the <em>configure</em> button of the VirtualHub or YoctoHub.</li>
    <li>Click on the <em>edit</em> button of "Callback URL" settings.</li>
    <li>Set the <em>type of Callback</em> to <b>Yocto-API Callback</b>.</li>
    <li>Set the <em>callback URL</em> to
        http://<b><?php print($_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . $_SERVER['SCRIPT_NAME']); ?></b>.
    </li>
    <li>Click on the <em>test</em> button.</li>
</ol>
</body>
</html>