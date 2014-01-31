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
    include('../../Sources/yocto_datalogger.php');

    // Use explicit error handling rather than exceptions
    yDisableExceptions();

    // Setup the API to use the VirtualHub on local machine
    if(yRegisterHub('http://127.0.0.1:4444/',$errmsg) != YAPI_SUCCESS) {
        die("Cannot contact VirtualHub on 127.0.0.1");
    }

    @$serial = $_GET['serial'];
    if ($serial != '') {
        // Check if a specified module is available online
        $logger = yFindDataLogger("$serial.dataLogger");   
        if (!$logger->isOnline()) { 
            die("Module not connected (check serial and USB cable)");
        }
    } else {
        // or use any connected module suitable for the demo
        $logger = yFirstDataLogger();
        if(is_null($logger)) {
            die("No data logger connected (check USB cable)");
        } else {
            $serial = $logger->module()->get_serialnumber();
        }
    }

    Print("<H1>Data Logger demo</H1>");
    Print("Module to use: <input name='serial' value='$serial'><br><br>");

    // Handle recorder on/off state
    @$state = $_GET['state'];
    if($state != '') {
        $logger->set_timeUTC(time());
        $logger->set_recording($state == '1' ? Y_RECORDING_ON : Y_RECORDING_OFF);
    }
    $isOn = ($logger->get_recording() ? 'checked' : '');
    $isOff = ($logger->get_recording() ? '' : 'checked');
    Print("Data logger recording state: ".
          "<input type='radio' name='state' value='1' $isOn>On ".
          "<input type='radio' name='state' value='0' $isOff>Off<br><br>\n");
    Print("\n<br><br><input type='submit' value='Submit and reload'><br><br>\n");

    // Dump list of available streams
    Print("Loading available data streams from the data logger...<br>\n");
    if(ob_get_level()) ob_flush();
    flush();
    $streams = Array();
    if($logger->get_dataStreams($streams) != YAPI_SUCCESS) {
        Print("Failed to load streams !");
    }    
    Print("<table border=1>\n<tr><th>Run</th><th>Relative time</th>".
          "<th>UTC time</th><th>Measures interval</th></tr>\n");
    for($idx = 0; $idx < sizeof($streams); $idx++) {
        $stream = $streams[$idx];
        $run  = $stream->get_runIndex();
        $time = $stream->get_startTime();
        $utc  = $stream->get_startTimeUTC();
        $utc  = ($utc == 0 ? '' : date("Y-m-d H:i:s", $utc));
        $itv  = $stream->get_dataSamplesInterval();
        Print("<tr><td>#$run</td><td>$time [s]</td><td>$utc</td><td>$itv [s]</td>".
              "<td><a href='javascript:show($idx)'>view</a></td></tr>\n");
    }
    Print("</table><br>\n");
    Print("<script language='javascript1.5' type='text/JavaScript'>\n");
    Print("function show(idx)\n");
    Print("{ document.location = document.location.pathname +\n");
    Print("                      '?serial=$serial&idx='+idx,1000; }\n");
    Print("</script>\n");
    if(ob_get_level()) ob_flush();
    flush();

    @$idx = $_GET['idx'];
    if($idx != '') {
        // Dump selected stream
        $stream = $streams[$idx];
        $utc    = $stream->get_startTimeUTC();
        $itv    = $stream->get_dataSamplesInterval();
        $names  = $stream->get_columnNames();
        $values = $stream->get_dataRows();
        if(sizeof($names) > 0) {
            Print("<table border=1>\n<tr><th>time</th>");
            foreach($names as $name) Print("<th>$name</th>");
            foreach($values as $row) {
                $when = ($utc > $time ? date("Y-m-d H:i:s", $utc) : "+$time [s]");
                Print("</tr>\n<tr><td>$when</td>");
                foreach($row as $val) Print("<td>$val</td>");
                $time += $itv; 
                $utc += $itv;
            }
            Print("</tr>\n</table>\n");
        }
    }
?>  
</FORM>
</BODY>
</HTML> 
