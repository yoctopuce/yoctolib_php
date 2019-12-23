<HTML>
<HEAD>
 <TITLE>Data Logger demo</TITLE>
 <STYLE type='text/css'>
  table td {white-space: nowrap;}
 </STYLE>
</HEAD>
<BODY>
<FORM method='get'>
<?php
    include('../../Sources/yocto_api.php');

    // Use explicit error handling rather than exceptions
    YAPI::DisableExceptions();

    // Setup the API to use the VirtualHub on local machine
    if(YAPI::RegisterHub('http://127.0.0.1:4444/',$errmsg) != YAPI::SUCCESS) {
        die("Cannot contact VirtualHub on 127.0.0.1");
    }

    function dumpSensor($sensor)
    {
        $dataset = $sensor->get_recordedData(0, 0);
        $progress = 0;
        Printf("Using DataLogger of %s<br>\n", $sensor->get_friendlyName());
        Print("loading summary...<br>\n");
        if(ob_get_level()) ob_flush();
        flush();
        $dataset->loadMore();
        $summary = $dataset->get_summary();
        Print("<table border=1>\n");
        Printf("<td>%s</td><td>%s</td><td>%.3f</td><td>%.3f</td><td>%.3f</td><br>\n",
                date("Y-m-d H:i:s", $summary->get_startTimeUTC()),
                date("Y-m-d H:i:s", $summary->get_endTimeUTC()),
                $summary->get_minValue(),$summary->get_averageValue(),$summary->get_maxValue());
        Print("</tr>\n</table>\n");

        Printf("loading details : <span id='prog'>0</span>%%<br>\n");
        while($progress < 100) {
            if(ob_get_level()) ob_flush();
            flush();
            $progress = $dataset->loadMore();
            Print("<script language='javascript1.5' type='text/JavaScript'>\n");
            Print("document.getElementById('prog').innerHTML = '$progress';\n");
            Print("</script>\n");
        }
        // load completed: show all results
        $details = $dataset->get_measures();
        Print("<table border=1>\n");
        Print("<tr><th>from</th><th>to</th><th>min</th><th>avg</th><th>max</th>\n");
        foreach($details as $measure) {
            Printf("<tr><td>%s</td><td>%s</td><td>%.3f</td><td>%.3f</td><td>%.3f</td></tr>",
                   date("Y-m-d H:i:s", $measure->get_startTimeUTC()),
                   date("Y-m-d H:i:s", $measure->get_endTimeUTC()),
                   $measure->get_minValue(),$measure->get_averageValue(),$measure->get_maxValue());
        }
        Print("</tr>\n</table>\n");
    }

    @$hwid = $_GET['hwid'];
    if ($hwid != '') {
        // Check if a specified module is available online
        $sensor = YSensor::FindSensor($hwid);
        if (!$sensor->isOnline()) {
            die("Module not connected (check serial and USB cable)");
        }
    } else {
        // or use any connected module suitable for the demo
        $sensor = YSensor::FirstSensor();
        if(is_null($sensor)) {
            die("No sensor connected (check USB cable and firmware version)");
        } else {
            $hwid = $sensor->get_hardwareId();
        }
    }

    Print("<H1>Data Logger demo</H1>");
    Print("Sensor to use: <input name='hwid' value='$hwid' size='32'><br><br>");

    dumpSensor($sensor);
?>
</FORM>
</BODY>
</HTML>
