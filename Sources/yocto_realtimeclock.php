<?php
/*********************************************************************
 *
 * $Id: yocto_realtimeclock.php 12324 2013-08-13 15:10:31Z mvuilleu $
 *
 * Implements yFindRealTimeClock(), the high-level API for RealTimeClock functions
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
//--- (YRealTimeClock definitions)
if(!defined('Y_TIMESET_FALSE')) define('Y_TIMESET_FALSE', 0);
if(!defined('Y_TIMESET_TRUE')) define('Y_TIMESET_TRUE', 1);
if(!defined('Y_TIMESET_INVALID')) define('Y_TIMESET_INVALID', -1);
if(!defined('Y_LOGICALNAME_INVALID')) define('Y_LOGICALNAME_INVALID', Y_INVALID_STRING);
if(!defined('Y_ADVERTISEDVALUE_INVALID')) define('Y_ADVERTISEDVALUE_INVALID', Y_INVALID_STRING);
if(!defined('Y_UNIXTIME_INVALID')) define('Y_UNIXTIME_INVALID', Y_INVALID_UNSIGNED);
if(!defined('Y_DATETIME_INVALID')) define('Y_DATETIME_INVALID', Y_INVALID_STRING);
if(!defined('Y_UTCOFFSET_INVALID')) define('Y_UTCOFFSET_INVALID', Y_INVALID_SIGNED);
//--- (end of YRealTimeClock definitions)

/**
 * YRealTimeClock Class: Real Time Clock function interface
 * 
 * The RealTimeClock function maintains and provides current date and time, even accross power cut
 * lasting several days. It is the base for automated wake-up functions provided by the WakeUpScheduler.
 * The current time may represent a local time as well as an UTC time, but no automatic time change
 * will occur to account for daylight saving time.
 */
class YRealTimeClock extends YFunction
{
    //--- (YRealTimeClock implementation)
    const LOGICALNAME_INVALID = Y_INVALID_STRING;
    const ADVERTISEDVALUE_INVALID = Y_INVALID_STRING;
    const UNIXTIME_INVALID = Y_INVALID_UNSIGNED;
    const DATETIME_INVALID = Y_INVALID_STRING;
    const UTCOFFSET_INVALID = Y_INVALID_SIGNED;
    const TIMESET_FALSE = 0;
    const TIMESET_TRUE = 1;
    const TIMESET_INVALID = -1;

    /**
     * Returns the logical name of the clock.
     * 
     * @return a string corresponding to the logical name of the clock
     * 
     * On failure, throws an exception or returns Y_LOGICALNAME_INVALID.
     */
    public function get_logicalName()
    {   $json_val = $this->_getAttr("logicalName");
        return (is_null($json_val) ? Y_LOGICALNAME_INVALID : $json_val);
    }

    /**
     * Changes the logical name of the clock. You can use yCheckLogicalName()
     * prior to this call to make sure that your parameter is valid.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     * 
     * @param newval : a string corresponding to the logical name of the clock
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
     * Returns the current value of the clock (no more than 6 characters).
     * 
     * @return a string corresponding to the current value of the clock (no more than 6 characters)
     * 
     * On failure, throws an exception or returns Y_ADVERTISEDVALUE_INVALID.
     */
    public function get_advertisedValue()
    {   $json_val = $this->_getAttr("advertisedValue");
        return (is_null($json_val) ? Y_ADVERTISEDVALUE_INVALID : $json_val);
    }

    /**
     * Returns the current time in Unix format (number of elapsed seconds since Jan 1st, 1970).
     * 
     * @return an integer corresponding to the current time in Unix format (number of elapsed seconds
     * since Jan 1st, 1970)
     * 
     * On failure, throws an exception or returns Y_UNIXTIME_INVALID.
     */
    public function get_unixTime()
    {   $json_val = $this->_getAttr("unixTime");
        return (is_null($json_val) ? Y_UNIXTIME_INVALID : intval($json_val));
    }

    /**
     * Changes the current time. Time is specifid in Unix format (number of elapsed seconds since Jan 1st, 1970).
     * If current UTC time is known, utcOffset will be automatically adjusted for the new specified time.
     * 
     * @param newval : an integer corresponding to the current time
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_unixTime($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("unixTime",$rest_val);
    }

    /**
     * Returns the current time in the form "YYYY/MM/DD hh:mm:ss"
     * 
     * @return a string corresponding to the current time in the form "YYYY/MM/DD hh:mm:ss"
     * 
     * On failure, throws an exception or returns Y_DATETIME_INVALID.
     */
    public function get_dateTime()
    {   $json_val = $this->_getAttr("dateTime");
        return (is_null($json_val) ? Y_DATETIME_INVALID : $json_val);
    }

    /**
     * Returns the number of seconds between current time and UTC time (time zone).
     * 
     * @return an integer corresponding to the number of seconds between current time and UTC time (time zone)
     * 
     * On failure, throws an exception or returns Y_UTCOFFSET_INVALID.
     */
    public function get_utcOffset()
    {   $json_val = $this->_getAttr("utcOffset");
        return (is_null($json_val) ? Y_UTCOFFSET_INVALID : intval($json_val));
    }

    /**
     * Changes the number of seconds between current time and UTC time (time zone).
     * The timezone is automatically rounded to the nearest multiple of 15 minutes.
     * If current UTC time is known, the current time will automatically be updated according to the
     * selected time zone.
     * 
     * @param newval : an integer corresponding to the number of seconds between current time and UTC time (time zone)
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_utcOffset($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("utcOffset",$rest_val);
    }

    /**
     * Returns true if the clock has been set, and false otherwise.
     * 
     * @return either Y_TIMESET_FALSE or Y_TIMESET_TRUE, according to true if the clock has been set, and
     * false otherwise
     * 
     * On failure, throws an exception or returns Y_TIMESET_INVALID.
     */
    public function get_timeSet()
    {   $json_val = $this->_getAttr("timeSet");
        return (is_null($json_val) ? Y_TIMESET_INVALID : intval($json_val));
    }

    public function logicalName()
    { return get_logicalName(); }

    public function setLogicalName($newval)
    { return set_logicalName($newval); }

    public function advertisedValue()
    { return get_advertisedValue(); }

    public function unixTime()
    { return get_unixTime(); }

    public function setUnixTime($newval)
    { return set_unixTime($newval); }

    public function dateTime()
    { return get_dateTime(); }

    public function utcOffset()
    { return get_utcOffset(); }

    public function setUtcOffset($newval)
    { return set_utcOffset($newval); }

    public function timeSet()
    { return get_timeSet(); }

    /**
     * Continues the enumeration of clocks started using yFirstRealTimeClock().
     * 
     * @return a pointer to a YRealTimeClock object, corresponding to
     *         a clock currently online, or a null pointer
     *         if there are no more clocks to enumerate.
     */
    public function nextRealTimeClock()
    {   $next_hwid = YAPI::getNextHardwareId($this->_className, $this->_func);
        if($next_hwid == null) return null;
        return yFindRealTimeClock($next_hwid);
    }

    /**
     * Retrieves a clock for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     * 
     * This function does not require that the clock is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YRealTimeClock.isOnline() to test if the clock is
     * indeed online at a given time. In case of ambiguity when looking for
     * a clock by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     * 
     * @param func : a string that uniquely characterizes the clock
     * 
     * @return a YRealTimeClock object allowing you to drive the clock.
     */
    public static function FindRealTimeClock($str_func)
    {   $obj_func = YAPI::getFunction('RealTimeClock', $str_func);
        if($obj_func) return $obj_func;
        return new YRealTimeClock($str_func);
    }

    /**
     * Starts the enumeration of clocks currently accessible.
     * Use the method YRealTimeClock.nextRealTimeClock() to iterate on
     * next clocks.
     * 
     * @return a pointer to a YRealTimeClock object, corresponding to
     *         the first clock currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstRealTimeClock()
    {   $next_hwid = YAPI::getFirstHardwareId('RealTimeClock');
        if($next_hwid == null) return null;
        return self::FindRealTimeClock($next_hwid);
    }

    //--- (end of YRealTimeClock implementation)

    function __construct($str_func)
    {
        //--- (YRealTimeClock constructor)
        parent::__construct('RealTimeClock', $str_func);
        //--- (end of YRealTimeClock constructor)
    }
};

//--- (RealTimeClock functions)

/**
 * Retrieves a clock for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 * 
 * This function does not require that the clock is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YRealTimeClock.isOnline() to test if the clock is
 * indeed online at a given time. In case of ambiguity when looking for
 * a clock by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 * 
 * @param func : a string that uniquely characterizes the clock
 * 
 * @return a YRealTimeClock object allowing you to drive the clock.
 */
function yFindRealTimeClock($str_func)
{
    return YRealTimeClock::FindRealTimeClock($str_func);
}

/**
 * Starts the enumeration of clocks currently accessible.
 * Use the method YRealTimeClock.nextRealTimeClock() to iterate on
 * next clocks.
 * 
 * @return a pointer to a YRealTimeClock object, corresponding to
 *         the first clock currently online, or a null pointer
 *         if there are none.
 */
function yFirstRealTimeClock()
{
    return YRealTimeClock::FirstRealTimeClock();
}

//--- (end of RealTimeClock functions)
?>