<?php
/*********************************************************************
 *
 *  $Id: yocto_realtimeclock.php 43580 2021-01-26 17:46:01Z mvuilleu $
 *
 *  Implements YRealTimeClock, the high-level API for RealTimeClock functions
 *
 *  - - - - - - - - - License information: - - - - - - - - -
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

//--- (YRealTimeClock return codes)
//--- (end of YRealTimeClock return codes)
//--- (YRealTimeClock definitions)
if(!defined('Y_TIMESET_FALSE'))              define('Y_TIMESET_FALSE',             0);
if(!defined('Y_TIMESET_TRUE'))               define('Y_TIMESET_TRUE',              1);
if(!defined('Y_TIMESET_INVALID'))            define('Y_TIMESET_INVALID',           -1);
if(!defined('Y_UNIXTIME_INVALID'))           define('Y_UNIXTIME_INVALID',          YAPI_INVALID_LONG);
if(!defined('Y_DATETIME_INVALID'))           define('Y_DATETIME_INVALID',          YAPI_INVALID_STRING);
if(!defined('Y_UTCOFFSET_INVALID'))          define('Y_UTCOFFSET_INVALID',         YAPI_INVALID_INT);
//--- (end of YRealTimeClock definitions)
    #--- (YRealTimeClock yapiwrapper)
   #--- (end of YRealTimeClock yapiwrapper)

//--- (YRealTimeClock declaration)
/**
 * YRealTimeClock Class: real-time clock control interface, available for instance in the
 * YoctoHub-GSM-3G-EU, the YoctoHub-GSM-3G-NA, the YoctoHub-GSM-4G or the YoctoHub-Wireless-n
 *
 * The YRealTimeClock class provide access to the embedded real-time clock available on some Yoctopuce
 * devices. It can provide current date and time, even after a power outage
 * lasting several days. It is the base for automated wake-up functions provided by the WakeUpScheduler.
 * The current time may represent a local time as well as an UTC time, but no automatic time change
 * will occur to account for daylight saving time.
 */
class YRealTimeClock extends YFunction
{
    const UNIXTIME_INVALID               = YAPI_INVALID_LONG;
    const DATETIME_INVALID               = YAPI_INVALID_STRING;
    const UTCOFFSET_INVALID              = YAPI_INVALID_INT;
    const TIMESET_FALSE                  = 0;
    const TIMESET_TRUE                   = 1;
    const TIMESET_INVALID                = -1;
    //--- (end of YRealTimeClock declaration)

    //--- (YRealTimeClock attributes)
    protected $_unixTime                 = Y_UNIXTIME_INVALID;           // UTCTime
    protected $_dateTime                 = Y_DATETIME_INVALID;           // Text
    protected $_utcOffset                = Y_UTCOFFSET_INVALID;          // Int
    protected $_timeSet                  = Y_TIMESET_INVALID;            // Bool
    //--- (end of YRealTimeClock attributes)

    function __construct($str_func)
    {
        //--- (YRealTimeClock constructor)
        parent::__construct($str_func);
        $this->_className = 'RealTimeClock';

        //--- (end of YRealTimeClock constructor)
    }

    //--- (YRealTimeClock implementation)

    function _parseAttr($name, $val)
    {
        switch($name) {
        case 'unixTime':
            $this->_unixTime = intval($val);
            return 1;
        case 'dateTime':
            $this->_dateTime = $val;
            return 1;
        case 'utcOffset':
            $this->_utcOffset = intval($val);
            return 1;
        case 'timeSet':
            $this->_timeSet = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the current time in Unix format (number of elapsed seconds since Jan 1st, 1970).
     *
     * @return integer : an integer corresponding to the current time in Unix format (number of elapsed
     * seconds since Jan 1st, 1970)
     *
     * On failure, throws an exception or returns YRealTimeClock::UNIXTIME_INVALID.
     */
    public function get_unixTime()
    {
        // $res                    is a long;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_UNIXTIME_INVALID;
            }
        }
        $res = $this->_unixTime;
        return $res;
    }

    /**
     * Changes the current time. Time is specifid in Unix format (number of elapsed seconds since Jan 1st, 1970).
     *
     * @param integer $newval : an integer corresponding to the current time
     *
     * @return integer : YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_unixTime($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("unixTime",$rest_val);
    }

    /**
     * Returns the current time in the form "YYYY/MM/DD hh:mm:ss".
     *
     * @return string : a string corresponding to the current time in the form "YYYY/MM/DD hh:mm:ss"
     *
     * On failure, throws an exception or returns YRealTimeClock::DATETIME_INVALID.
     */
    public function get_dateTime()
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_DATETIME_INVALID;
            }
        }
        $res = $this->_dateTime;
        return $res;
    }

    /**
     * Returns the number of seconds between current time and UTC time (time zone).
     *
     * @return integer : an integer corresponding to the number of seconds between current time and UTC
     * time (time zone)
     *
     * On failure, throws an exception or returns YRealTimeClock::UTCOFFSET_INVALID.
     */
    public function get_utcOffset()
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_UTCOFFSET_INVALID;
            }
        }
        $res = $this->_utcOffset;
        return $res;
    }

    /**
     * Changes the number of seconds between current time and UTC time (time zone).
     * The timezone is automatically rounded to the nearest multiple of 15 minutes.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param integer $newval : an integer corresponding to the number of seconds between current time and
     * UTC time (time zone)
     *
     * @return integer : YAPI::SUCCESS if the call succeeds.
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
     * @return integer : either YRealTimeClock::TIMESET_FALSE or YRealTimeClock::TIMESET_TRUE, according to
     * true if the clock has been set, and false otherwise
     *
     * On failure, throws an exception or returns YRealTimeClock::TIMESET_INVALID.
     */
    public function get_timeSet()
    {
        // $res                    is a enumBOOL;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_TIMESET_INVALID;
            }
        }
        $res = $this->_timeSet;
        return $res;
    }

    /**
     * Retrieves a real-time clock for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the real-time clock is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the real-time clock is
     * indeed online at a given time. In case of ambiguity when looking for
     * a real-time clock by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the real-time clock, for instance
     *         YHUBGSM3.realTimeClock.
     *
     * @return YRealTimeClock : a YRealTimeClock object allowing you to drive the real-time clock.
     */
    public static function FindRealTimeClock($func)
    {
        // $obj                    is a YRealTimeClock;
        $obj = YFunction::_FindFromCache('RealTimeClock', $func);
        if ($obj == null) {
            $obj = new YRealTimeClock($func);
            YFunction::_AddToCache('RealTimeClock', $func, $obj);
        }
        return $obj;
    }

    public function unixTime()
    { return $this->get_unixTime(); }

    public function setUnixTime($newval)
    { return $this->set_unixTime($newval); }

    public function dateTime()
    { return $this->get_dateTime(); }

    public function utcOffset()
    { return $this->get_utcOffset(); }

    public function setUtcOffset($newval)
    { return $this->set_utcOffset($newval); }

    public function timeSet()
    { return $this->get_timeSet(); }

    /**
     * Continues the enumeration of real-time clocks started using yFirstRealTimeClock().
     * Caution: You can't make any assumption about the returned real-time clocks order.
     * If you want to find a specific a real-time clock, use RealTimeClock.findRealTimeClock()
     * and a hardwareID or a logical name.
     *
     * @return YRealTimeClock : a pointer to a YRealTimeClock object, corresponding to
     *         a real-time clock currently online, or a null pointer
     *         if there are no more real-time clocks to enumerate.
     */
    public function nextRealTimeClock()
    {   $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) return null;
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if($next_hwid == null) return null;
        return self::FindRealTimeClock($next_hwid);
    }

    /**
     * Starts the enumeration of real-time clocks currently accessible.
     * Use the method YRealTimeClock::nextRealTimeClock() to iterate on
     * next real-time clocks.
     *
     * @return YRealTimeClock : a pointer to a YRealTimeClock object, corresponding to
     *         the first real-time clock currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstRealTimeClock()
    {   $next_hwid = YAPI::getFirstHardwareId('RealTimeClock');
        if($next_hwid == null) return null;
        return self::FindRealTimeClock($next_hwid);
    }

    //--- (end of YRealTimeClock implementation)

};

//--- (YRealTimeClock functions)

/**
 * Retrieves a real-time clock for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 *
 * This function does not require that the real-time clock is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method isOnline() to test if the real-time clock is
 * indeed online at a given time. In case of ambiguity when looking for
 * a real-time clock by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 *
 * If a call to this object's is_online() method returns FALSE although
 * you are certain that the matching device is plugged, make sure that you did
 * call registerHub() at application initialization time.
 *
 * @param string $func : a string that uniquely characterizes the real-time clock, for instance
 *         YHUBGSM3.realTimeClock.
 *
 * @return YRealTimeClock : a YRealTimeClock object allowing you to drive the real-time clock.
 */
function yFindRealTimeClock($func)
{
    return YRealTimeClock::FindRealTimeClock($func);
}

/**
 * Starts the enumeration of real-time clocks currently accessible.
 * Use the method YRealTimeClock::nextRealTimeClock() to iterate on
 * next real-time clocks.
 *
 * @return YRealTimeClock : a pointer to a YRealTimeClock object, corresponding to
 *         the first real-time clock currently online, or a null pointer
 *         if there are none.
 */
function yFirstRealTimeClock()
{
    return YRealTimeClock::FirstRealTimeClock();
}

//--- (end of YRealTimeClock functions)
?>