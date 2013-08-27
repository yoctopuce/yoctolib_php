<?php
/*********************************************************************
 *
 * $Id: yocto_watchdog.php 12324 2013-08-13 15:10:31Z mvuilleu $
 *
 * Implements yFindWatchdog(), the high-level API for Watchdog functions
 *
 * - - - - - - - - - License information: - - - - - - - - - 
 *
 *  Copyright (C) 2011 and beyond by Yoctopuce Sarl, Switzerland.
 *
 *  Yoctopuce Sarl (hereafter Licensor) grants to you a perpetual
 *  non-exclusive license to use, modify, copy and integrate this
 *  file into your software for the sole purpose of interfacing 
 *  with Yoctopuce products. 
 *
 *  You may reproduce and distribute copies of this file in 
 *  source or object form, as long as the sole purpose of this
 *  code is to interface with Yoctopuce products. You must retain 
 *  this notice in the distributed source file.
 *
 *  You should refer to Yoctopuce General Terms and Conditions
 *  for additional information regarding your rights and 
 *  obligations.
 *
 *  THE SOFTWARE AND DOCUMENTATION ARE PROVIDED 'AS IS' WITHOUT
 *  WARRANTY OF ANY KIND, EITHER EXPRESS OR IMPLIED, INCLUDING 
 *  WITHOUT LIMITATION, ANY WARRANTY OF MERCHANTABILITY, FITNESS 
 *  FOR A PARTICULAR PURPOSE, TITLE AND NON-INFRINGEMENT. IN NO
 *  EVENT SHALL LICENSOR BE LIABLE FOR ANY INCIDENTAL, SPECIAL,
 *  INDIRECT OR CONSEQUENTIAL DAMAGES, LOST PROFITS OR LOST DATA, 
 *  COST OF PROCUREMENT OF SUBSTITUTE GOODS, TECHNOLOGY OR 
 *  SERVICES, ANY CLAIMS BY THIRD PARTIES (INCLUDING BUT NOT 
 *  LIMITED TO ANY DEFENSE THEREOF), ANY CLAIMS FOR INDEMNITY OR
 *  CONTRIBUTION, OR OTHER SIMILAR COSTS, WHETHER ASSERTED ON THE
 *  BASIS OF CONTRACT, TORT (INCLUDING NEGLIGENCE), BREACH OF
 *  WARRANTY, OR OTHERWISE.
 *
 *********************************************************************/


//--- (return codes)
//--- (end of return codes)
//--- (YWatchdog definitions)
if(!defined('Y_STATE_A')) define('Y_STATE_A', 0);
if(!defined('Y_STATE_B')) define('Y_STATE_B', 1);
if(!defined('Y_STATE_INVALID')) define('Y_STATE_INVALID', -1);
if(!defined('Y_OUTPUT_OFF')) define('Y_OUTPUT_OFF', 0);
if(!defined('Y_OUTPUT_ON')) define('Y_OUTPUT_ON', 1);
if(!defined('Y_OUTPUT_INVALID')) define('Y_OUTPUT_INVALID', -1);
if(!defined('Y_AUTOSTART_OFF')) define('Y_AUTOSTART_OFF', 0);
if(!defined('Y_AUTOSTART_ON')) define('Y_AUTOSTART_ON', 1);
if(!defined('Y_AUTOSTART_INVALID')) define('Y_AUTOSTART_INVALID', -1);
if(!defined('Y_RUNNING_OFF')) define('Y_RUNNING_OFF', 0);
if(!defined('Y_RUNNING_ON')) define('Y_RUNNING_ON', 1);
if(!defined('Y_RUNNING_INVALID')) define('Y_RUNNING_INVALID', -1);
if(!defined('Y_LOGICALNAME_INVALID')) define('Y_LOGICALNAME_INVALID', Y_INVALID_STRING);
if(!defined('Y_ADVERTISEDVALUE_INVALID')) define('Y_ADVERTISEDVALUE_INVALID', Y_INVALID_STRING);
if(!defined('Y_PULSETIMER_INVALID')) define('Y_PULSETIMER_INVALID', Y_INVALID_UNSIGNED);
if(!defined('Y_DELAYEDPULSETIMER_INVALID')) define('Y_DELAYEDPULSETIMER_INVALID', null);
if(!defined('Y_COUNTDOWN_INVALID')) define('Y_COUNTDOWN_INVALID', Y_INVALID_UNSIGNED);
if(!defined('Y_TRIGGERDELAY_INVALID')) define('Y_TRIGGERDELAY_INVALID', Y_INVALID_UNSIGNED);
if(!defined('Y_TRIGGERDURATION_INVALID')) define('Y_TRIGGERDURATION_INVALID', Y_INVALID_UNSIGNED);

if(!defined('CLASS_YDELAYEDPULSE')) {
    define('CLASS_YDELAYEDPULSE',true);
    class YDelayedPulse extends YAggregate {
        public $target = 0;
        public $ms = 0;
        public $moving = 0;
    };
}
//--- (end of YWatchdog definitions)

/**
 * YWatchdog Class: Watchdog function interface
 * 
 * The watchog function works like a relay and can cause a brief power cut
 * to an appliance after a preset delay to force this appliance to
 * reset. The Watchdog must be called from time to time to reset the
 * timer and prevent the appliance reset.
 * The watchdog can be driven direcly with <i>pulse</i> and <i>delayedpulse</i> methods to switch
 * off an appliance for a given duration.
 */
class YWatchdog extends YFunction
{
    //--- (YWatchdog implementation)
    const LOGICALNAME_INVALID = Y_INVALID_STRING;
    const ADVERTISEDVALUE_INVALID = Y_INVALID_STRING;
    const STATE_A = 0;
    const STATE_B = 1;
    const STATE_INVALID = -1;
    const OUTPUT_OFF = 0;
    const OUTPUT_ON = 1;
    const OUTPUT_INVALID = -1;
    const PULSETIMER_INVALID = Y_INVALID_UNSIGNED;
    const COUNTDOWN_INVALID = Y_INVALID_UNSIGNED;
    const AUTOSTART_OFF = 0;
    const AUTOSTART_ON = 1;
    const AUTOSTART_INVALID = -1;
    const RUNNING_OFF = 0;
    const RUNNING_ON = 1;
    const RUNNING_INVALID = -1;
    const TRIGGERDELAY_INVALID = Y_INVALID_UNSIGNED;
    const TRIGGERDURATION_INVALID = Y_INVALID_UNSIGNED;

    /**
     * Returns the logical name of the watchdog.
     * 
     * @return a string corresponding to the logical name of the watchdog
     * 
     * On failure, throws an exception or returns Y_LOGICALNAME_INVALID.
     */
    public function get_logicalName()
    {   $json_val = $this->_getAttr("logicalName");
        return (is_null($json_val) ? Y_LOGICALNAME_INVALID : $json_val);
    }

    /**
     * Changes the logical name of the watchdog. You can use yCheckLogicalName()
     * prior to this call to make sure that your parameter is valid.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     * 
     * @param newval : a string corresponding to the logical name of the watchdog
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_logicalName($newval)
    {
        $rest_val = $newval;
        return $this->_setAttr("logicalName",$rest_val);
    }

    /**
     * Returns the current value of the watchdog (no more than 6 characters).
     * 
     * @return a string corresponding to the current value of the watchdog (no more than 6 characters)
     * 
     * On failure, throws an exception or returns Y_ADVERTISEDVALUE_INVALID.
     */
    public function get_advertisedValue()
    {   $json_val = $this->_getAttr("advertisedValue");
        return (is_null($json_val) ? Y_ADVERTISEDVALUE_INVALID : $json_val);
    }

    /**
     * Returns the state of the watchdog (A for the idle position, B for the active position).
     * 
     * @return either Y_STATE_A or Y_STATE_B, according to the state of the watchdog (A for the idle
     * position, B for the active position)
     * 
     * On failure, throws an exception or returns Y_STATE_INVALID.
     */
    public function get_state()
    {   $json_val = $this->_getAttr("state");
        return (is_null($json_val) ? Y_STATE_INVALID : intval($json_val));
    }

    /**
     * Changes the state of the watchdog (A for the idle position, B for the active position).
     * 
     * @param newval : either Y_STATE_A or Y_STATE_B, according to the state of the watchdog (A for the
     * idle position, B for the active position)
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_state($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("state",$rest_val);
    }

    /**
     * Returns the output state of the watchdog, when used as a simple switch (single throw).
     * 
     * @return either Y_OUTPUT_OFF or Y_OUTPUT_ON, according to the output state of the watchdog, when
     * used as a simple switch (single throw)
     * 
     * On failure, throws an exception or returns Y_OUTPUT_INVALID.
     */
    public function get_output()
    {   $json_val = $this->_getAttr("output");
        return (is_null($json_val) ? Y_OUTPUT_INVALID : intval($json_val));
    }

    /**
     * Changes the output state of the watchdog, when used as a simple switch (single throw).
     * 
     * @param newval : either Y_OUTPUT_OFF or Y_OUTPUT_ON, according to the output state of the watchdog,
     * when used as a simple switch (single throw)
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_output($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("output",$rest_val);
    }

    /**
     * Returns the number of milliseconds remaining before the watchdog is returned to idle position
     * (state A), during a measured pulse generation. When there is no ongoing pulse, returns zero.
     * 
     * @return an integer corresponding to the number of milliseconds remaining before the watchdog is
     * returned to idle position
     *         (state A), during a measured pulse generation
     * 
     * On failure, throws an exception or returns Y_PULSETIMER_INVALID.
     */
    public function get_pulseTimer()
    {   $json_val = $this->_getAttr("pulseTimer");
        return (is_null($json_val) ? Y_PULSETIMER_INVALID : intval($json_val));
    }

    public function set_pulseTimer($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("pulseTimer",$rest_val);
    }

    /**
     * Sets the relay to output B (active) for a specified duration, then brings it
     * automatically back to output A (idle state).
     * 
     * @param ms_duration : pulse duration, in millisecondes
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function pulse($int_ms_duration)
    {
        $rest_val = strval($int_ms_duration);
        return $this->_setAttr("pulseTimer",$rest_val);
    }

    public function get_delayedPulseTimer()
    {   $json_val = $this->_getAttr("delayedPulseTimer");
        return (is_null($json_val) ? Y_DELAYEDPULSETIMER_INVALID : new YDelayedPulse($json_val));
    }

    public function set_delayedPulseTimer($newval)
    {
        $rest_val = strval($newval["target"]).":".strval($newval["ms"]);
        return $this->_setAttr("delayedPulseTimer",$rest_val);
    }

    /**
     * Schedules a pulse.
     * 
     * @param ms_delay : waiting time before the pulse, in millisecondes
     * @param ms_duration : pulse duration, in millisecondes
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function delayedPulse($int_ms_delay,$int_ms_duration)
    {
        $rest_val = strval($int_ms_delay).":".strval($int_ms_duration);
        return $this->_setAttr("delayedPulseTimer",$rest_val);
    }

    /**
     * Returns the number of milliseconds remaining before a pulse (delayedPulse() call)
     * When there is no scheduled pulse, returns zero.
     * 
     * @return an integer corresponding to the number of milliseconds remaining before a pulse (delayedPulse() call)
     *         When there is no scheduled pulse, returns zero
     * 
     * On failure, throws an exception or returns Y_COUNTDOWN_INVALID.
     */
    public function get_countdown()
    {   $json_val = $this->_getAttr("countdown");
        return (is_null($json_val) ? Y_COUNTDOWN_INVALID : intval($json_val));
    }

    /**
     * Returns the watchdog runing state at module power up.
     * 
     * @return either Y_AUTOSTART_OFF or Y_AUTOSTART_ON, according to the watchdog runing state at module power up
     * 
     * On failure, throws an exception or returns Y_AUTOSTART_INVALID.
     */
    public function get_autoStart()
    {   $json_val = $this->_getAttr("autoStart");
        return (is_null($json_val) ? Y_AUTOSTART_INVALID : intval($json_val));
    }

    /**
     * Changes the watchdog runningsttae at module power up. Remember to call the
     * saveToFlash() method and then to reboot the module to apply this setting.
     * 
     * @param newval : either Y_AUTOSTART_OFF or Y_AUTOSTART_ON, according to the watchdog runningsttae at
     * module power up
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_autoStart($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("autoStart",$rest_val);
    }

    /**
     * Returns the watchdog running state.
     * 
     * @return either Y_RUNNING_OFF or Y_RUNNING_ON, according to the watchdog running state
     * 
     * On failure, throws an exception or returns Y_RUNNING_INVALID.
     */
    public function get_running()
    {   $json_val = $this->_getAttr("running");
        return (is_null($json_val) ? Y_RUNNING_INVALID : intval($json_val));
    }

    /**
     * Changes the running state of the watchdog.
     * 
     * @param newval : either Y_RUNNING_OFF or Y_RUNNING_ON, according to the running state of the watchdog
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_running($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("running",$rest_val);
    }

    /**
     * Resets the watchdog. When the watchdog is running, this function
     * must be called on a regular basis to prevent the watchog to
     * trigger
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function resetWatchdog()
    {
        $rest_val = '1';
        return $this->_setAttr("running",$rest_val);
    }

    /**
     * Returns  the waiting duration before a reset is automatically triggered by the watchdog, in milliseconds.
     * 
     * @return an integer corresponding to  the waiting duration before a reset is automatically triggered
     * by the watchdog, in milliseconds
     * 
     * On failure, throws an exception or returns Y_TRIGGERDELAY_INVALID.
     */
    public function get_triggerDelay()
    {   $json_val = $this->_getAttr("triggerDelay");
        return (is_null($json_val) ? Y_TRIGGERDELAY_INVALID : intval($json_val));
    }

    /**
     * Changes the waiting delay before a reset is triggered by the watchdog, in milliseconds.
     * 
     * @param newval : an integer corresponding to the waiting delay before a reset is triggered by the
     * watchdog, in milliseconds
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_triggerDelay($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("triggerDelay",$rest_val);
    }

    /**
     * Returns the duration of resets caused by the watchdog, in milliseconds.
     * 
     * @return an integer corresponding to the duration of resets caused by the watchdog, in milliseconds
     * 
     * On failure, throws an exception or returns Y_TRIGGERDURATION_INVALID.
     */
    public function get_triggerDuration()
    {   $json_val = $this->_getAttr("triggerDuration");
        return (is_null($json_val) ? Y_TRIGGERDURATION_INVALID : intval($json_val));
    }

    /**
     * Changes the duration of resets caused by the watchdog, in milliseconds.
     * 
     * @param newval : an integer corresponding to the duration of resets caused by the watchdog, in milliseconds
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_triggerDuration($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("triggerDuration",$rest_val);
    }

    public function logicalName()
    { return get_logicalName(); }

    public function setLogicalName($newval)
    { return set_logicalName($newval); }

    public function advertisedValue()
    { return get_advertisedValue(); }

    public function state()
    { return get_state(); }

    public function setState($newval)
    { return set_state($newval); }

    public function output()
    { return get_output(); }

    public function setOutput($newval)
    { return set_output($newval); }

    public function pulseTimer()
    { return get_pulseTimer(); }

    public function setPulseTimer($newval)
    { return set_pulseTimer($newval); }

    public function delayedPulseTimer()
    { return get_delayedPulseTimer(); }

    public function setDelayedPulseTimer($newval)
    { return set_delayedPulseTimer($newval); }

    public function countdown()
    { return get_countdown(); }

    public function autoStart()
    { return get_autoStart(); }

    public function setAutoStart($newval)
    { return set_autoStart($newval); }

    public function running()
    { return get_running(); }

    public function setRunning($newval)
    { return set_running($newval); }

    public function triggerDelay()
    { return get_triggerDelay(); }

    public function setTriggerDelay($newval)
    { return set_triggerDelay($newval); }

    public function triggerDuration()
    { return get_triggerDuration(); }

    public function setTriggerDuration($newval)
    { return set_triggerDuration($newval); }

    /**
     * Continues the enumeration of watchdog started using yFirstWatchdog().
     * 
     * @return a pointer to a YWatchdog object, corresponding to
     *         a watchdog currently online, or a null pointer
     *         if there are no more watchdog to enumerate.
     */
    public function nextWatchdog()
    {   $next_hwid = YAPI::getNextHardwareId($this->_className, $this->_func);
        if($next_hwid == null) return null;
        return yFindWatchdog($next_hwid);
    }

    /**
     * Retrieves a watchdog for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     * 
     * This function does not require that the watchdog is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YWatchdog.isOnline() to test if the watchdog is
     * indeed online at a given time. In case of ambiguity when looking for
     * a watchdog by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     * 
     * @param func : a string that uniquely characterizes the watchdog
     * 
     * @return a YWatchdog object allowing you to drive the watchdog.
     */
    public static function FindWatchdog($str_func)
    {   $obj_func = YAPI::getFunction('Watchdog', $str_func);
        if($obj_func) return $obj_func;
        return new YWatchdog($str_func);
    }

    /**
     * Starts the enumeration of watchdog currently accessible.
     * Use the method YWatchdog.nextWatchdog() to iterate on
     * next watchdog.
     * 
     * @return a pointer to a YWatchdog object, corresponding to
     *         the first watchdog currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstWatchdog()
    {   $next_hwid = YAPI::getFirstHardwareId('Watchdog');
        if($next_hwid == null) return null;
        return self::FindWatchdog($next_hwid);
    }

    //--- (end of YWatchdog implementation)

    function __construct($str_func)
    {
        //--- (YWatchdog constructor)
        parent::__construct('Watchdog', $str_func);
        //--- (end of YWatchdog constructor)
    }
};

//--- (Watchdog functions)

/**
 * Retrieves a watchdog for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 * 
 * This function does not require that the watchdog is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YWatchdog.isOnline() to test if the watchdog is
 * indeed online at a given time. In case of ambiguity when looking for
 * a watchdog by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 * 
 * @param func : a string that uniquely characterizes the watchdog
 * 
 * @return a YWatchdog object allowing you to drive the watchdog.
 */
function yFindWatchdog($str_func)
{
    return YWatchdog::FindWatchdog($str_func);
}

/**
 * Starts the enumeration of watchdog currently accessible.
 * Use the method YWatchdog.nextWatchdog() to iterate on
 * next watchdog.
 * 
 * @return a pointer to a YWatchdog object, corresponding to
 *         the first watchdog currently online, or a null pointer
 *         if there are none.
 */
function yFirstWatchdog()
{
    return YWatchdog::FirstWatchdog();
}

//--- (end of Watchdog functions)
?>