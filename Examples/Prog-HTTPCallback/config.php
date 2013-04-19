<?php

/*
 * Object used to save desired state of remote control switches
 */
class VirtualSwitch {
    private $_name          = '';
    private $_state         = 'off';
    private $_yocto_relays_on   = Array();
    private $_yocto_relays_off  = Array();
    private $_modifed       = FALSE;

    function __construct($name,$yocto_relays_on,$yocto_relays_off)
    {
        $this->_name = $name;
        $this->_yocto_relays_on = $yocto_relays_on;
        $this->_yocto_relays_off = $yocto_relays_off;
    }

    public function setState($on)
    {
        $newstate = ($on==='on' || $on===TRUE ?'on':'off');
        if($newstate != $this->_state){
            $this->_state = $newstate;
            $this->_modifed = TRUE;
        }
    }

    //return on,off,auto,random
    public function getName()
    {
        return $this->_name;
    }

    //return on,off,auto,random
    public function getState()
    {
        return $this->_state;
    }

    public function isOnNow()
    {
        return $this->_state=='on';
    }

    public function getRelaysForState($state)
    {
      if ($state==='on' || $state===TRUE ) 
        return $this->_yocto_relays_on;
    else
        return $this->_yocto_relays_off;
    }

    public function needUpdate()
    {
        return $this->_modifed;
    }

    public function updateDone()
    {
        $this->_modifed = false;
    }
}

class Relay {
    private $_hwid;
    private $_logicalname;

    function __construct($yrelay_obj)
    {
      $this->_hwid = $yrelay_obj->get_hardwareId();
      $this->_logicalname = $yrelay_obj->get_logicalName();
    }

    public function getHwId()
    {
        return $this->_hwid;
    }

    public function getName()
    {
        $res = $this->_logicalname;
        if($res=="")
          $res =  $this->_hwid;
        return $res;
    }
}



define('VIRTUALSWITCHES_FILE_PATH',   'VirtualSwitches.dat');
define('RELAYS_FILE_PATH',            'Relays.dat');
define('LOG_FILE_PATH',               'log.txt');



function LoadArrayFromFile($file)
{   
  if(!file_exists($file)) {
      logtofile("file_exists of $file failed");
      return array(); // no state file so far
  }
  $data = file_get_contents($file);
  if($data === FALSE) {
      logtofile("file_get_contents of $file failed");
      return array(); // no state file so far
  }
  $arr = unserialize($data);
  if($arr === FALSE){
      return array(); // invalid state file
  }
    // array successfully reloaded
  return $arr;
}

function SaveArrayToFile($file, $arr)
{ 
  $data = serialize($arr);
  file_put_contents($file, $data);
}


function LoadVirtualSwitches()
{       
  return LoadArrayFromFile(VIRTUALSWITCHES_FILE_PATH);
}

function SaveVirtualSwitches($all_plugs)
{   
    SaveArrayToFile(VIRTUALSWITCHES_FILE_PATH,$all_plugs);
}



function LoadDetectedRelays()
{   
  return LoadArrayFromFile(RELAYS_FILE_PATH);
}

function SaveDetectedRelays($all_relays)
{ 
  SaveArrayToFile(RELAYS_FILE_PATH, $all_relays);
}


function LoadVirtualSwitchesToUpdate()
{       
    $all_switches = LoadVirtualSwitches();
    $to_apply  = Array();
    foreach ($all_switches as $name => $switch) {
        if($switch->needUpdate()){
            $to_apply[$name]=$switch;
            $switch->updateDone();
        }
    }
    if(sizeof($to_apply))
        SaveVirtualSwitches($all_switches);
    return $to_apply;
}


function logtofile($message)
{
    $lines=explode("\n", $message);
    foreach($lines as $l){
        // Write the contents to the file, 
        // using the FILE_APPEND flag to append the content to the end of the file
        // and the LOCK_EX flag to prevent anyone else writing to the file at the same time
        $towrite = "[".date("c",time())."]:$l\n";
        file_put_contents(LOG_FILE_PATH, $towrite, FILE_APPEND | LOCK_EX);
    }
}

?>