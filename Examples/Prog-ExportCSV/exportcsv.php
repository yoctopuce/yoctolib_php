<?php
    include('../../Sources/yocto_api.php');

    // Setup the API to use the VirtualHub on local machine
    if(YAPI::RegisterHub('http://127.0.0.1:4444/',$errmsg) != YAPI::SUCCESS) {
        die("Cannot contact VirtualHub on 127.0.0.1");
    }

    // Enumerate all connected sensors
    $sensorList = [];
    $sensor = YSensor::FirstSensor();
    while(!is_null($sensor)) {
        $sensorList[] = $sensor;
        $sensor = $sensor->nextSensor();
    }
    if(sizeof($sensorList) == 0) {
        die("No Yoctopuce sensor connected (check USB cable and firmware version)");
    }

    // Generate consolidated CSV output for all sensors
    $data = new YConsolidatedDataSet(0, 0, $sensorList);
    $record = [];
    while($data->nextRecord($record) < 100) {
        $line = date("c", $record[0]);
        for($idx = 1; $idx < sizeof($record); $idx++) {
            $line .= ";".$record[$idx];
        }
        Printf("%s\n", $line);
    }

