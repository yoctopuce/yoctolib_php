<HTML>
<HEAD>
 <TITLE>Hello World</TITLE>
</HEAD>
<BODY>
<FORM method='get'>
<?php

  include('../../Sources/yocto_api.php');
  include('../../Sources/yocto_motor.php');
  include('../../Sources/yocto_current.php');
  include('../../Sources/yocto_voltage.php');
  include('../../Sources/yocto_temperature.php');

  // Use explicit error handling rather than exceptions
  YAPI::DisableExceptions();

  // Setup the API to use the VirtualHub on local machine
  if(YAPI::RegisterHub('http://127.0.0.1:4444/',$errmsg) != YAPI::SUCCESS) {
      die("Cannot contact VirtualHub on 127.0.0.1");
  }
  @$power = $_GET['power'];
  @$serial = $_GET['serial'];
  if ($serial == '') {
    $motor = YMotor::FirstMotor();
    if(is_null($motor)) {
      die("No module connected (check USB cable)");
    }
    $serial = $motor->get_module()->get_serialNumber();
  }

  $motor    = YMotor::FindMotor($serial.".motor");
  $current  = YCurrent::FindCurrent($serial.".current");
  $voltage  = YVoltage::FindVoltage($serial.".voltage");
  $temperature = YTemperature::FindTemperature($serial.".temperature");
  Print("Serial:<input name='serial' value='$serial'><br>");
  // lets start the motor
  if ($motor->isOnline()) {
    // if the motor is in error state, reset it.
    if ($motor->get_motorStatus()>=YMotor::MOTORSTATUS_LOVOLT)
      $motor->resetStatus();
    $motor->drivingForceMove($power,2000);  // ramp up to power in 2 seconds
    Printf("status=".$motor->get_advertisedValue().'<br>');
    Printf("current=".($current->get_currentValue()/1000).'A<br>');
    Printf("voltage=".$voltage->get_currentValue().'V<br>');
    Printf("temperature=".$temperature->get_currentValue().'&deg;C<br>');
    Print("Power:<input name='power' value='$power'><br>");
  } else {
    Printf("Module is not connected, check cable.<br>");
  }
  YAPI::FreeAPI();

?>

<input type='submit'>
</FORM>
</BODY>
</HTML>
