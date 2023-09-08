<HTML>
<HEAD>
 <TITLE>Hello World</TITLE>
</HEAD>
<BODY>
<?php
  include('../../php8/yocto_api.php');
  include('../../php8/yocto_sdi12port.php');

  // Use explicit error handling rather than exceptions
  YAPI::DisableExceptions();

  // Setup the API to use the VirtualHub on local machine
  $errmsg = '';
  if(YAPI::RegisterHub('127.0.0.1',$errmsg) != YAPI::SUCCESS) {
      die("Cannot contact VirtualHub on 127.0.0.1");
  }

  @$serial = $_GET['serial'];
  if ($serial != '') {
      // Check if a specified module is available online
      $sdi12port = YSdi12Port::FindSdi12Port("$serial.sdi12Port");
      if (!$sdi12port->isOnline()) {
          die("Module not connected (check serial and USB cable)");
      }
  } else {
      // or use any connected module suitable for the demo
      $sdi12port = YSdi12Port::FirstSdi12Port();
      if(is_null($sdi12port)) {
          die("No module connected (check USB cable)");
      } else {
          $serial = $sdi12port->module()->get_serialnumber();
      }
  }
  Print("Module to use: <input name='serial' value='$serial'><br>\n");

  

  $singleSensor = $sdi12port->discoverSingleSensor();
  Printf("Sensor address : %s <br>\n", $singleSensor->get_sensorAddress());
  Printf("Sensor SDI-12 compatibility : %s <br>\n", $singleSensor->get_sensorProtocol());
  Printf("Sensor company name : %s <br>\n", $singleSensor->get_sensorVendor());
  Printf("Sensor model number : %s <br>\n", $singleSensor->get_sensorModel());
  Printf("Sensor version : %s <br>\n", $singleSensor->get_sensorVersion());
  Printf("Sensor serial number : %s <br>\n", $singleSensor->get_sensorSerial());
  $valSensor = $sdi12port->readSensor($singleSensor->get_sensorAddress(),"M",5000);

  for ($i = 0; $i < sizeof($valSensor); $i++) {
    if ($singleSensor->get_measureCount() > 1) {
       Printf("%s %-8.2f %s %s <br>\n", $singleSensor->get_measureSymbol($i), $valSensor[$i],
        $singleSensor->get_measureUnit($i), $singleSensor->get_measureDescription($i));
    }
    else{  Printf("%.2f <br>\n", $valSensor[$i]);}
    
  }
  YAPI::FreeAPI();

  // trigger auto-refresh after one second
  Print("<script language='javascript1.5' type='text/JavaScript'>\n");
  Print("setTimeout('window.location.reload()',1000);");
  Print("</script>\n");
?>
</BODY>
</HTML>
