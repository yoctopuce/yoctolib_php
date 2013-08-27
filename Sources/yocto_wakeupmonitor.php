<?php
/*********************************************************************
 *
 * $Id: yocto_wakeupmonitor.php 12324 2013-08-13 15:10:31Z mvuilleu $
 *
 * Implements yFindWakeUpMonitor(), the high-level API for WakeUpMonitor functions
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
//--- (YWakeUpMonitor definitions)
if(!defined('Y_WAKEUPREASON_USBPOWER')) define('Y_WAKEUPREASON_USBPOWER', 0);
if(!defined('Y_WAKEUPREASON_EXTPOWER')) define('Y_WAKEUPREASON_EXTPOWER', 1);
if(!defined('Y_WAKEUPREASON_ENDOFSLEEP')) define('Y_WAKEUPREASON_ENDOFSLEEP', 2);
if(!defined('Y_WAKEUPREASON_EXTSIG1')) define('Y_WAKEUPREASON_EXTSIG1', 3);
if(!defined('Y_WAKEUPREASON_EXTSIG2')) define('Y_WAKEUPREASON_EXTSIG2', 4);
if(!defined('Y_WAKEUPREASON_EXTSIG3')) define('Y_WAKEUPREASON_EXTSIG3', 5);
if(!defined('Y_WAKEUPREASON_EXTSIG4')) define('Y_WAKEUPREASON_EXTSIG4', 6);
if(!defined('Y_WAKEUPREASON_SCHEDULE1')) define('Y_WAKEUPREASON_SCHEDULE1', 7);
if(!defined('Y_WAKEUPREASON_SCHEDULE2')) define('Y_WAKEUPREASON_SCHEDULE2', 8);
if(!defined('Y_WAKEUPREASON_SCHEDULE3')) define('Y_WAKEUPREASON_SCHEDULE3', 9);
if(!defined('Y_WAKEUPREASON_SCHEDULE4')) define('Y_WAKEUPREASON_SCHEDULE4', 10);
if(!defined('Y_WAKEUPREASON_SCHEDULE5')) define('Y_WAKEUPREASON_SCHEDULE5', 11);
if(!defined('Y_WAKEUPREASON_SCHEDULE6')) define('Y_WAKEUPREASON_SCHEDULE6', 12);
if(!defined('Y_WAKEUPREASON_INVALID')) define('Y_WAKEUPREASON_INVALID', -1);
if(!defined('Y_WAKEUPSTATE_SLEEPING')) define('Y_WAKEUPSTATE_SLEEPING', 0);
if(!defined('Y_WAKEUPSTATE_AWAKE')) define('Y_WAKEUPSTATE_AWAKE', 1);
if(!defined('Y_WAKEUPSTATE_INVALID')) define('Y_WAKEUPSTATE_INVALID', -1);
if(!defined('Y_LOGICALNAME_INVALID')) define('Y_LOGICALNAME_INVALID', Y_INVALID_STRING);
if(!defined('Y_ADVERTISEDVALUE_INVALID')) define('Y_ADVERTISEDVALUE_INVALID', Y_INVALID_STRING);
if(!defined('Y_POWERDURATION_INVALID')) define('Y_POWERDURATION_INVALID', Y_INVALID_SIGNED);
if(!defined('Y_SLEEPCOUNTDOWN_INVALID')) define('Y_SLEEPCOUNTDOWN_INVALID', Y_INVALID_SIGNED);
if(!defined('Y_NEXTWAKEUP_INVALID')) define('Y_NEXTWAKEUP_INVALID', Y_INVALID_UNSIGNED);
if(!defined('Y_RTCTIME_INVALID')) define('Y_RTCTIME_INVALID', Y_INVALID_UNSIGNED);
//--- (end of YWakeUpMonitor definitions)

/**
 * YWakeUpMonitor Class: WakeUpMonitor function interface
 * 
 * 
 */
class YWakeUpMonitor extends YFunction
{
    //--- (YWakeUpMonitor implementation)
    const LOGICALNAME_INVALID = Y_INVALID_STRING;
    const ADVERTISEDVALUE_INVALID = Y_INVALID_STRING;
    const POWERDURATION_INVALID = Y_INVALID_SIGNED;
    const SLEEPCOUNTDOWN_INVALID = Y_INVALID_SIGNED;
    const NEXTWAKEUP_INVALID = Y_INVALID_UNSIGNED;
    const WAKEUPREASON_USBPOWER = 0;
    const WAKEUPREASON_EXTPOWER = 1;
    const WAKEUPREASON_ENDOFSLEEP = 2;
    const WAKEUPREASON_EXTSIG1 = 3;
    const WAKEUPREASON_EXTSIG2 = 4;
    const WAKEUPREASON_EXTSIG3 = 5;
    const WAKEUPREASON_EXTSIG4 = 6;
    const WAKEUPREASON_SCHEDULE1 = 7;
    const WAKEUPREASON_SCHEDULE2 = 8;
    const WAKEUPREASON_SCHEDULE3 = 9;
    const WAKEUPREASON_SCHEDULE4 = 10;
    const WAKEUPREASON_SCHEDULE5 = 11;
    const WAKEUPREASON_SCHEDULE6 = 12;
    const WAKEUPREASON_INVALID = -1;
    const WAKEUPSTATE_SLEEPING = 0;
    const WAKEUPSTATE_AWAKE = 1;
    const WAKEUPSTATE_INVALID = -1;
    const RTCTIME_INVALID = Y_INVALID_UNSIGNED;
    public  $_endOfTime = 2145960000;

    /**
     * Returns the logical name of the monitor.
     * 
     * @return a string corresponding to the logical name of the monitor
     * 
     * On failure, throws an exception or returns Y_LOGICALNAME_INVALID.
     */
    public function get_logicalName()
    {   $json_val = $this->_getAttr("logicalName");
        return (is_null($json_val) ? Y_LOGICALNAME_INVALID : $json_val);
    }

    /**
     * Changes the logical name of the monitor. You can use yCheckLogicalName()
     * prior to this call to make sure that your parameter is valid.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     * 
     * @param newval : a string corresponding to the logical name of the monitor
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
     * Returns the current value of the monitor (no more than 6 characters).
     * 
     * @return a string corresponding to the current value of the monitor (no more than 6 characters)
     * 
     * On failure, throws an exception or returns Y_ADVERTISEDVALUE_INVALID.
     */
    public function get_advertisedValue()
    {   $json_val = $this->_getAttr("advertisedValue");
        return (is_null($json_val) ? Y_ADVERTISEDVALUE_INVALID : $json_val);
    }

    /**
     * Returns the maximal wake up time (seconds) before going to sleep automatically.
     * 
     * @return an integer corresponding to the maximal wake up time (seconds) before going to sleep automatically
     * 
     * On failure, throws an exception or returns Y_POWERDURATION_INVALID.
     */
    public function get_powerDuration()
    {   $json_val = $this->_getAttr("powerDuration");
        return (is_null($json_val) ? Y_POWERDURATION_INVALID : intval($json_val));
    }

    /**
     * Changes the maximal wake up time (seconds) before going to sleep automatically.
     * 
     * @param newval : an integer corresponding to the maximal wake up time (seconds) before going to
     * sleep automatically
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_powerDuration($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("powerDuration",$rest_val);
    }

    /**
     * Returns the delay before next sleep.
     * 
     * @return an integer corresponding to the delay before next sleep
     * 
     * On failure, throws an exception or returns Y_SLEEPCOUNTDOWN_INVALID.
     */
    public function get_sleepCountdown()
    {   $json_val = $this->_getAttr("sleepCountdown");
        return (is_null($json_val) ? Y_SLEEPCOUNTDOWN_INVALID : intval($json_val));
    }

    /**
     * Changes the delay before next sleep.
     * 
     * @param newval : an integer corresponding to the delay before next sleep
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_sleepCountdown($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("sleepCountdown",$rest_val);
    }

    /**
     * Returns the next scheduled wake-up date/time (UNIX format)
     * 
     * @return an integer corresponding to the next scheduled wake-up date/time (UNIX format)
     * 
     * On failure, throws an exception or returns Y_NEXTWAKEUP_INVALID.
     */
    public function get_nextWakeUp()
    {   $json_val = $this->_getAttr("nextWakeUp");
        return (is_null($json_val) ? Y_NEXTWAKEUP_INVALID : intval($json_val));
    }

    /**
     * Changes the days of the week where a wake up must take place.
     * 
     * @param newval : an integer corresponding to the days of the week where a wake up must take place
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_nextWakeUp($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("nextWakeUp",$rest_val);
    }

    /**
     * Return the last wake up reason.
     * 
     * @return a value among Y_WAKEUPREASON_USBPOWER, Y_WAKEUPREASON_EXTPOWER, Y_WAKEUPREASON_ENDOFSLEEP,
     * Y_WAKEUPREASON_EXTSIG1, Y_WAKEUPREASON_EXTSIG2, Y_WAKEUPREASON_EXTSIG3, Y_WAKEUPREASON_EXTSIG4,
     * Y_WAKEUPREASON_SCHEDULE1, Y_WAKEUPREASON_SCHEDULE2, Y_WAKEUPREASON_SCHEDULE3,
     * Y_WAKEUPREASON_SCHEDULE4, Y_WAKEUPREASON_SCHEDULE5 and Y_WAKEUPREASON_SCHEDULE6
     * 
     * On failure, throws an exception or returns Y_WAKEUPREASON_INVALID.
     */
    public function get_wakeUpReason()
    {   $json_val = $this->_getAttr("wakeUpReason");
        return (is_null($json_val) ? Y_WAKEUPREASON_INVALID : intval($json_val));
    }

    /**
     * Returns  the current state of the monitor
     * 
     * @return either Y_WAKEUPSTATE_SLEEPING or Y_WAKEUPSTATE_AWAKE, according to  the current state of the monitor
     * 
     * On failure, throws an exception or returns Y_WAKEUPSTATE_INVALID.
     */
    public function get_wakeUpState()
    {   $json_val = $this->_getAttr("wakeUpState");
        return (is_null($json_val) ? Y_WAKEUPSTATE_INVALID : intval($json_val));
    }

    public function set_wakeUpState($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("wakeUpState",$rest_val);
    }

    public function get_rtcTime()
    {   $json_val = $this->_getAttr("rtcTime");
        return (is_null($json_val) ? Y_RTCTIME_INVALID : intval($json_val));
    }

    /**
     * Forces a wakeup.
     */
    public function wakeUp()
    {
        return $this->set_wakeUpState(Y_WAKEUPSTATE_AWAKE);
        
    }

    /**
     * Go to sleep until the next wakeup condition is met,  the
     * RTC time must have been set before calling this function.
     * 
     * @param secBeforeSleep : number of seconds before going into sleep mode,
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function sleep($int_secBeforeSleep)
    {
        // $currTime is a int;
        $currTime = $this->get_rtcTime();
        if (!($currTime != 0)) return $this->_throw( YAPI_RTC_NOT_READY, 'RTC time not set', YAPI_RTC_NOT_READY);
        $this->set_nextWakeUp($this->_endOfTime);
        $this->set_sleepCountdown($int_secBeforeSleep);
        return YAPI_SUCCESS; 
        
    }

    /**
     * Go to sleep for a specific time or until the next wakeup condition is met, the
     * RTC time must have been set before calling this function. The count down before sleep
     * can be canceled with resetSleepCountDown.
     * 
     * @param secUntilWakeUp : sleep duration, in secondes
     * @param secBeforeSleep : number of seconds before going into sleep mode
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function sleepFor($int_secUntilWakeUp,$int_secBeforeSleep)
    {
        // $currTime is a int;
        $currTime = $this->get_rtcTime();
        if (!($currTime != 0)) return $this->_throw( YAPI_RTC_NOT_READY, 'RTC time not set', YAPI_RTC_NOT_READY);
        $this->set_nextWakeUp($currTime+$int_secUntilWakeUp);
        $this->set_sleepCountdown($int_secBeforeSleep);
        return YAPI_SUCCESS; 
        
    }

    /**
     * Go to sleep until a specific date is reached or until the next wakeup condition is met, the
     * RTC time must have been set before calling this function. The count down before sleep
     * can be canceled with resetSleepCountDown.
     * 
     * @param wakeUpTime : wake-up datetime (UNIX format)
     * @param secBeforeSleep : number of seconds before going into sleep mode
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function sleepUntil($int_wakeUpTime,$int_secBeforeSleep)
    {
        // $currTime is a int;
        $currTime = $this->get_rtcTime();
        if (!($currTime != 0)) return $this->_throw( YAPI_RTC_NOT_READY, 'RTC time not set', YAPI_RTC_NOT_READY);
        $this->set_nextWakeUp($int_wakeUpTime);
        $this->set_sleepCountdown($int_secBeforeSleep);
        return YAPI_SUCCESS; 
        
    }

    /**
     * Reset the sleep countdown.
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     */
    public function resetSleepCountDown()
    {
        $this->set_sleepCountdown(0);
        $this->set_nextWakeUp(0);
        return YAPI_SUCCESS; 
        
    }

    public function logicalName()
    { return get_logicalName(); }

    public function setLogicalName($newval)
    { return set_logicalName($newval); }

    public function advertisedValue()
    { return get_advertisedValue(); }

    public function powerDuration()
    { return get_powerDuration(); }

    public function setPowerDuration($newval)
    { return set_powerDuration($newval); }

    public function sleepCountdown()
    { return get_sleepCountdown(); }

    public function setSleepCountdown($newval)
    { return set_sleepCountdown($newval); }

    public function nextWakeUp()
    { return get_nextWakeUp(); }

    public function setNextWakeUp($newval)
    { return set_nextWakeUp($newval); }

    public function wakeUpReason()
    { return get_wakeUpReason(); }

    public function wakeUpState()
    { return get_wakeUpState(); }

    public function setWakeUpState($newval)
    { return set_wakeUpState($newval); }

    public function rtcTime()
    { return get_rtcTime(); }

    /**
     * Continues the enumeration of monitors started using yFirstWakeUpMonitor().
     * 
     * @return a pointer to a YWakeUpMonitor object, corresponding to
     *         a monitor currently online, or a null pointer
     *         if there are no more monitors to enumerate.
     */
    public function nextWakeUpMonitor()
    {   $next_hwid = YAPI::getNextHardwareId($this->_className, $this->_func);
        if($next_hwid == null) return null;
        return yFindWakeUpMonitor($next_hwid);
    }

    /**
     * Retrieves a monitor for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     * 
     * This function does not require that the monitor is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YWakeUpMonitor.isOnline() to test if the monitor is
     * indeed online at a given time. In case of ambiguity when looking for
     * a monitor by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     * 
     * @param func : a string that uniquely characterizes the monitor
     * 
     * @return a YWakeUpMonitor object allowing you to drive the monitor.
     */
    public static function FindWakeUpMonitor($str_func)
    {   $obj_func = YAPI::getFunction('WakeUpMonitor', $str_func);
        if($obj_func) return $obj_func;
        return new YWakeUpMonitor($str_func);
    }

    /**
     * Starts the enumeration of monitors currently accessible.
     * Use the method YWakeUpMonitor.nextWakeUpMonitor() to iterate on
     * next monitors.
     * 
     * @return a pointer to a YWakeUpMonitor object, corresponding to
     *         the first monitor currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstWakeUpMonitor()
    {   $next_hwid = YAPI::getFirstHardwareId('WakeUpMonitor');
        if($next_hwid == null) return null;
        return self::FindWakeUpMonitor($next_hwid);
    }

    //--- (end of YWakeUpMonitor implementation)

    function __construct($str_func)
    {
        //--- (YWakeUpMonitor constructor)
        parent::__construct('WakeUpMonitor', $str_func);
        //--- (end of YWakeUpMonitor constructor)
    }
};

//--- (WakeUpMonitor functions)

/**
 * Retrieves a monitor for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 * 
 * This function does not require that the monitor is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YWakeUpMonitor.isOnline() to test if the monitor is
 * indeed online at a given time. In case of ambiguity when looking for
 * a monitor by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 * 
 * @param func : a string that uniquely characterizes the monitor
 * 
 * @return a YWakeUpMonitor object allowing you to drive the monitor.
 */
function yFindWakeUpMonitor($str_func)
{
    return YWakeUpMonitor::FindWakeUpMonitor($str_func);
}

/**
 * Starts the enumeration of monitors currently accessible.
 * Use the method YWakeUpMonitor.nextWakeUpMonitor() to iterate on
 * next monitors.
 * 
 * @return a pointer to a YWakeUpMonitor object, corresponding to
 *         the first monitor currently online, or a null pointer
 *         if there are none.
 */
function yFirstWakeUpMonitor()
{
    return YWakeUpMonitor::FirstWakeUpMonitor();
}

//--- (end of WakeUpMonitor functions)
?>