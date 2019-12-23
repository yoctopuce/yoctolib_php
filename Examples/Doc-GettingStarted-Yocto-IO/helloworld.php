<HTML>
<HEAD>
 <TITLE>Hello World</TITLE>
</HEAD>
<BODY>
<FORM  name='myform' method='get'>
<?php
  include('../../Sources/yocto_api.php');
  include('../../Sources/yocto_digitalio.php');

  // Use explicit error handling rather than exceptions
  YAPI::DisableExceptions();

  // Setup the API to use the VirtualHub on local machine
  if(YAPI::RegisterHub('http://127.0.0.1:4444/',$errmsg) != YAPI::SUCCESS) {
      die("Cannot contact VirtualHub on 127.0.0.1");
  }

  @$serial = $_GET['serial'];
  if ($serial != '')
   {  // Check if a specified module is available online
      $io = YDigitalIO::FindDigitalIO("$serial.digitalIO");
      if (!$io->isOnline()) {
          die("Module not connected (check serial and USB cable)");
      }
  } else
  {
      // or use any connected module suitable for the demo
      // (note that the order of enumeration may vary)
      $io = YDigitalIO::FirstDigitalIO();
      if(is_null($io)) {
          die("No module connected (check USB cable)");
      }  $serial = $io->module()->get_serialnumber();
  }

  // make sure the device is here
  if (!$io->isOnline())
    die("Module not connected (check identification and USB cable)");

  // lets configure the channels direction
  // bits 0..1 as output
  // bits 2..3 as input
  $io->set_portDirection(0x03);
  $io->set_portPolarity(0); // polarity set to regular
  $io->set_portOpenDrain(0); // No open drain

  @$outputdata = intVal($_GET['outputdata']);
  $outputdata = ($outputdata + 1) % 4; // cycle ouput 0..3
  $io->set_portState($outputdata); // We could have used set_bitState as well
  ySleep(50, $errmsg); // make sure the set is  processed before the get
  $inputdata = $io->get_portState(); // read port values
  $line = "";  // display port value as binary
  for ($i = 0; $i < 4; $i++)
    if (($inputdata & (8 >> $i))>0) $line = $line . '1'; else $line = $line . '0';

  Print("Module to use: <input name='serial' value='$serial'><br>");
  Print("<input type='hidden' name='outputdata' value='$outputdata'><br>");
  YAPI::FreeAPI();

  // trigger auto-refresh after one second
  Print("<script language='javascript1.5' type='text/JavaScript'>\n");
  Print("setTimeout('window.myform.submit()',1000);");
  Print("</script>\n");

?>

<p>
Channels 0..1 are configured as outputs and channels 2..3
are configred as inputs, you can connect some inputs to
ouputs and see what happens
</p>
<p>Port value: <?php Print($line);?></p>

<input type='submit'>
</FORM>


</BODY>
</HTML>
