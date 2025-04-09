<?php
/*********************************************************************
 *
 *  $Id: svn_id $
 *
 *  Implements YWakeUpMonitor, the high-level API for WakeUpMonitor functions
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

//--- (YWakeUpMonitor return codes)
//--- (end of YWakeUpMonitor return codes)
//--- (YWakeUpMonitor definitions)
if (!defined('Y_WAKEUPREASON_USBPOWER')) {
    define('Y_WAKEUPREASON_USBPOWER', 0);
}
if (!defined('Y_WAKEUPREASON_EXTPOWER')) {
    define('Y_WAKEUPREASON_EXTPOWER', 1);
}
if (!defined('Y_WAKEUPREASON_ENDOFSLEEP')) {
    define('Y_WAKEUPREASON_ENDOFSLEEP', 2);
}
if (!defined('Y_WAKEUPREASON_EXTSIG1')) {
    define('Y_WAKEUPREASON_EXTSIG1', 3);
}
if (!defined('Y_WAKEUPREASON_SCHEDULE1')) {
    define('Y_WAKEUPREASON_SCHEDULE1', 4);
}
if (!defined('Y_WAKEUPREASON_SCHEDULE2')) {
    define('Y_WAKEUPREASON_SCHEDULE2', 5);
}
if (!defined('Y_WAKEUPREASON_SCHEDULE3')) {
    define('Y_WAKEUPREASON_SCHEDULE3', 6);
}
if (!defined('Y_WAKEUPREASON_INVALID')) {
    define('Y_WAKEUPREASON_INVALID', -1);
}
if (!defined('Y_WAKEUPSTATE_SLEEPING')) {
    define('Y_WAKEUPSTATE_SLEEPING', 0);
}
if (!defined('Y_WAKEUPSTATE_AWAKE')) {
    define('Y_WAKEUPSTATE_AWAKE', 1);
}
if (!defined('Y_WAKEUPSTATE_INVALID')) {
    define('Y_WAKEUPSTATE_INVALID', -1);
}
if (!defined('Y_POWERDURATION_INVALID')) {
    define('Y_POWERDURATION_INVALID', YAPI_INVALID_UINT);
}
if (!defined('Y_SLEEPCOUNTDOWN_INVALID')) {
    define('Y_SLEEPCOUNTDOWN_INVALID', YAPI_INVALID_UINT);
}
if (!defined('Y_NEXTWAKEUP_INVALID')) {
    define('Y_NEXTWAKEUP_INVALID', YAPI_INVALID_LONG);
}
if (!defined('Y_RTCTIME_INVALID')) {
    define('Y_RTCTIME_INVALID', YAPI_INVALID_LONG);
}
//--- (end of YWakeUpMonitor definitions)
    #--- (YWakeUpMonitor yapiwrapper)

   #--- (end of YWakeUpMonitor yapiwrapper)

//--- (YWakeUpMonitor declaration)
//vvvv YWakeUpMonitor.php

/**
 * YWakeUpMonitor Class: wake-up monitor control interface, available for instance in the
 * YoctoHub-GSM-4G, the YoctoHub-Wireless-SR, the YoctoHub-Wireless-g or the YoctoHub-Wireless-n
 *
 * The YWakeUpMonitor class handles globally all wake-up sources, as well
 * as automated sleep mode.
 */
class YWakeUpMonitor extends YFunction
{
    const POWERDURATION_INVALID = YAPI::INVALID_UINT;
    const SLEEPCOUNTDOWN_INVALID = YAPI::INVALID_UINT;
    const NEXTWAKEUP_INVALID = YAPI::INVALID_LONG;
    const WAKEUPREASON_USBPOWER = 0;
    const WAKEUPREASON_EXTPOWER = 1;
    const WAKEUPREASON_ENDOFSLEEP = 2;
    const WAKEUPREASON_EXTSIG1 = 3;
    const WAKEUPREASON_SCHEDULE1 = 4;
    const WAKEUPREASON_SCHEDULE2 = 5;
    const WAKEUPREASON_SCHEDULE3 = 6;
    const WAKEUPREASON_INVALID = -1;
    const WAKEUPSTATE_SLEEPING = 0;
    const WAKEUPSTATE_AWAKE = 1;
    const WAKEUPSTATE_INVALID = -1;
    const RTCTIME_INVALID = YAPI::INVALID_LONG;
    //--- (end of YWakeUpMonitor declaration)

    //--- (YWakeUpMonitor attributes)
    protected int $_powerDuration = self::POWERDURATION_INVALID;  // UInt31
    protected int $_sleepCountdown = self::SLEEPCOUNTDOWN_INVALID; // UInt31
    protected float $_nextWakeUp = self::NEXTWAKEUP_INVALID;     // UTCTime
    protected int $_wakeUpReason = self::WAKEUPREASON_INVALID;   // WakeUpReason
    protected int $_wakeUpState = self::WAKEUPSTATE_INVALID;    // WakeUpState
    protected float $_rtcTime = self::RTCTIME_INVALID;        // UTCTime
    protected int $_endOfTime = 2145960000;                   // UInt31 (constant)

    //--- (end of YWakeUpMonitor attributes)

    function __construct(string $str_func)
    {
        //--- (YWakeUpMonitor constructor)
        parent::__construct($str_func);
        $this->_className = 'WakeUpMonitor';

        //--- (end of YWakeUpMonitor constructor)
    }

    //--- (YWakeUpMonitor implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'powerDuration':
            $this->_powerDuration = intval($val);
            return 1;
        case 'sleepCountdown':
            $this->_sleepCountdown = intval($val);
            return 1;
        case 'nextWakeUp':
            $this->_nextWakeUp = intval($val);
            return 1;
        case 'wakeUpReason':
            $this->_wakeUpReason = intval($val);
            return 1;
        case 'wakeUpState':
            $this->_wakeUpState = intval($val);
            return 1;
        case 'rtcTime':
            $this->_rtcTime = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the maximal wake up time (in seconds) before automatically going to sleep.
     *
     * @return int  an integer corresponding to the maximal wake up time (in seconds) before automatically
     * going to sleep
     *
     * On failure, throws an exception or returns YWakeUpMonitor::POWERDURATION_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_powerDuration(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::POWERDURATION_INVALID;
            }
        }
        $res = $this->_powerDuration;
        return $res;
    }

    /**
     * Changes the maximal wake up time (seconds) before automatically going to sleep.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param int $newval : an integer corresponding to the maximal wake up time (seconds) before
     * automatically going to sleep
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_powerDuration(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("powerDuration", $rest_val);
    }

    /**
     * Returns the delay before the  next sleep period.
     *
     * @return int  an integer corresponding to the delay before the  next sleep period
     *
     * On failure, throws an exception or returns YWakeUpMonitor::SLEEPCOUNTDOWN_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_sleepCountdown(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::SLEEPCOUNTDOWN_INVALID;
            }
        }
        $res = $this->_sleepCountdown;
        return $res;
    }

    /**
     * Changes the delay before the next sleep period.
     *
     * @param int $newval : an integer corresponding to the delay before the next sleep period
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_sleepCountdown(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("sleepCountdown", $rest_val);
    }

    /**
     * Returns the next scheduled wake up date/time (UNIX format).
     *
     * @return float  an integer corresponding to the next scheduled wake up date/time (UNIX format)
     *
     * On failure, throws an exception or returns YWakeUpMonitor::NEXTWAKEUP_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_nextWakeUp(): float
    {
        // $res                    is a long;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::NEXTWAKEUP_INVALID;
            }
        }
        $res = $this->_nextWakeUp;
        return $res;
    }

    /**
     * Changes the days of the week when a wake up must take place.
     *
     * @param float $newval : an integer corresponding to the days of the week when a wake up must take place
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_nextWakeUp(float $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("nextWakeUp", $rest_val);
    }

    /**
     * Returns the latest wake up reason.
     *
     * @return int  a value among YWakeUpMonitor::WAKEUPREASON_USBPOWER,
     * YWakeUpMonitor::WAKEUPREASON_EXTPOWER, YWakeUpMonitor::WAKEUPREASON_ENDOFSLEEP,
     * YWakeUpMonitor::WAKEUPREASON_EXTSIG1, YWakeUpMonitor::WAKEUPREASON_SCHEDULE1,
     * YWakeUpMonitor::WAKEUPREASON_SCHEDULE2 and YWakeUpMonitor::WAKEUPREASON_SCHEDULE3 corresponding to
     * the latest wake up reason
     *
     * On failure, throws an exception or returns YWakeUpMonitor::WAKEUPREASON_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_wakeUpReason(): int
    {
        // $res                    is a enumWAKEUPREASON;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::WAKEUPREASON_INVALID;
            }
        }
        $res = $this->_wakeUpReason;
        return $res;
    }

    /**
     * Returns  the current state of the monitor.
     *
     * @return int  either YWakeUpMonitor::WAKEUPSTATE_SLEEPING or YWakeUpMonitor::WAKEUPSTATE_AWAKE,
     * according to  the current state of the monitor
     *
     * On failure, throws an exception or returns YWakeUpMonitor::WAKEUPSTATE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_wakeUpState(): int
    {
        // $res                    is a enumWAKEUPSTATE;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::WAKEUPSTATE_INVALID;
            }
        }
        $res = $this->_wakeUpState;
        return $res;
    }

    /**
     * @throws YAPI_Exception
     */
    public function set_wakeUpState(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("wakeUpState", $rest_val);
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_rtcTime(): float
    {
        // $res                    is a long;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::RTCTIME_INVALID;
            }
        }
        $res = $this->_rtcTime;
        return $res;
    }

    /**
     * Retrieves a wake-up monitor for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the wake-up monitor is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the wake-up monitor is
     * indeed online at a given time. In case of ambiguity when looking for
     * a wake-up monitor by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the wake-up monitor, for instance
     *         YHUBGSM5.wakeUpMonitor.
     *
     * @return YWakeUpMonitor  a YWakeUpMonitor object allowing you to drive the wake-up monitor.
     */
    public static function FindWakeUpMonitor(string $func): YWakeUpMonitor
    {
        // $obj                    is a YWakeUpMonitor;
        $obj = YFunction::_FindFromCache('WakeUpMonitor', $func);
        if ($obj == null) {
            $obj = new YWakeUpMonitor($func);
            YFunction::_AddToCache('WakeUpMonitor', $func, $obj);
        }
        return $obj;
    }

    /**
     * Forces a wake up.
     */
    public function wakeUp(): int
    {
        return $this->set_wakeUpState(self::WAKEUPSTATE_AWAKE);
    }

    /**
     * Goes to sleep until the next wake up condition is met,  the
     * RTC time must have been set before calling this function.
     *
     * @param int $secBeforeSleep : number of seconds before going into sleep mode,
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function sleep(int $secBeforeSleep): int
    {
        // $currTime               is a int;
        $currTime = $this->get_rtcTime();
        if (!($currTime != 0)) return $this->_throw(YAPI::RTC_NOT_READY,'RTC time not set',YAPI::RTC_NOT_READY);
        $this->set_nextWakeUp($this->_endOfTime);
        $this->set_sleepCountdown($secBeforeSleep);
        return YAPI::SUCCESS;
    }

    /**
     * Goes to sleep for a specific duration or until the next wake up condition is met, the
     * RTC time must have been set before calling this function. The count down before sleep
     * can be canceled with resetSleepCountDown.
     *
     * @param int $secUntilWakeUp : number of seconds before next wake up
     * @param int $secBeforeSleep : number of seconds before going into sleep mode
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function sleepFor(int $secUntilWakeUp, int $secBeforeSleep): int
    {
        // $currTime               is a int;
        $currTime = $this->get_rtcTime();
        if (!($currTime != 0)) return $this->_throw(YAPI::RTC_NOT_READY,'RTC time not set',YAPI::RTC_NOT_READY);
        $this->set_nextWakeUp($currTime+$secUntilWakeUp);
        $this->set_sleepCountdown($secBeforeSleep);
        return YAPI::SUCCESS;
    }

    /**
     * Go to sleep until a specific date is reached or until the next wake up condition is met, the
     * RTC time must have been set before calling this function. The count down before sleep
     * can be canceled with resetSleepCountDown.
     *
     * @param int $wakeUpTime : wake-up datetime (UNIX format)
     * @param int $secBeforeSleep : number of seconds before going into sleep mode
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function sleepUntil(int $wakeUpTime, int $secBeforeSleep): int
    {
        // $currTime               is a int;
        $currTime = $this->get_rtcTime();
        if (!($currTime != 0)) return $this->_throw(YAPI::RTC_NOT_READY,'RTC time not set',YAPI::RTC_NOT_READY);
        $this->set_nextWakeUp($wakeUpTime);
        $this->set_sleepCountdown($secBeforeSleep);
        return YAPI::SUCCESS;
    }

    /**
     * Resets the sleep countdown.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function resetSleepCountDown(): int
    {
        $this->set_sleepCountdown(0);
        $this->set_nextWakeUp(0);
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception
     */
    public function powerDuration(): int
{
    return $this->get_powerDuration();
}

    /**
     * @throws YAPI_Exception
     */
    public function setPowerDuration(int $newval): int
{
    return $this->set_powerDuration($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function sleepCountdown(): int
{
    return $this->get_sleepCountdown();
}

    /**
     * @throws YAPI_Exception
     */
    public function setSleepCountdown(int $newval): int
{
    return $this->set_sleepCountdown($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function nextWakeUp(): float
{
    return $this->get_nextWakeUp();
}

    /**
     * @throws YAPI_Exception
     */
    public function setNextWakeUp(float $newval): int
{
    return $this->set_nextWakeUp($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function wakeUpReason(): int
{
    return $this->get_wakeUpReason();
}

    /**
     * @throws YAPI_Exception
     */
    public function wakeUpState(): int
{
    return $this->get_wakeUpState();
}

    /**
     * @throws YAPI_Exception
     */
    public function setWakeUpState(int $newval): int
{
    return $this->set_wakeUpState($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function rtcTime(): float
{
    return $this->get_rtcTime();
}

    /**
     * Continues the enumeration of wake-up monitors started using yFirstWakeUpMonitor().
     * Caution: You can't make any assumption about the returned wake-up monitors order.
     * If you want to find a specific a wake-up monitor, use WakeUpMonitor.findWakeUpMonitor()
     * and a hardwareID or a logical name.
     *
     * @return ?YWakeUpMonitor  a pointer to a YWakeUpMonitor object, corresponding to
     *         a wake-up monitor currently online, or a null pointer
     *         if there are no more wake-up monitors to enumerate.
     */
    public function nextWakeUpMonitor(): ?YWakeUpMonitor
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindWakeUpMonitor($next_hwid);
    }

    /**
     * Starts the enumeration of wake-up monitors currently accessible.
     * Use the method YWakeUpMonitor::nextWakeUpMonitor() to iterate on
     * next wake-up monitors.
     *
     * @return ?YWakeUpMonitor  a pointer to a YWakeUpMonitor object, corresponding to
     *         the first wake-up monitor currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstWakeUpMonitor(): ?YWakeUpMonitor
    {
        $next_hwid = YAPI::getFirstHardwareId('WakeUpMonitor');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindWakeUpMonitor($next_hwid);
    }

    //--- (end of YWakeUpMonitor implementation)

}
//^^^^ YWakeUpMonitor.php

//--- (YWakeUpMonitor functions)

/**
 * Retrieves a wake-up monitor for a given identifier.
 * The identifier can be specified using several formats:
 *
 * - FunctionLogicalName
 * - ModuleSerialNumber.FunctionIdentifier
 * - ModuleSerialNumber.FunctionLogicalName
 * - ModuleLogicalName.FunctionIdentifier
 * - ModuleLogicalName.FunctionLogicalName
 *
 *
 * This function does not require that the wake-up monitor is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method isOnline() to test if the wake-up monitor is
 * indeed online at a given time. In case of ambiguity when looking for
 * a wake-up monitor by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 *
 * If a call to this object's is_online() method returns FALSE although
 * you are certain that the matching device is plugged, make sure that you did
 * call registerHub() at application initialization time.
 *
 * @param string $func : a string that uniquely characterizes the wake-up monitor, for instance
 *         YHUBGSM5.wakeUpMonitor.
 *
 * @return YWakeUpMonitor  a YWakeUpMonitor object allowing you to drive the wake-up monitor.
 */
function yFindWakeUpMonitor(string $func): YWakeUpMonitor
{
    return YWakeUpMonitor::FindWakeUpMonitor($func);
}

/**
 * Starts the enumeration of wake-up monitors currently accessible.
 * Use the method YWakeUpMonitor::nextWakeUpMonitor() to iterate on
 * next wake-up monitors.
 *
 * @return ?YWakeUpMonitor  a pointer to a YWakeUpMonitor object, corresponding to
 *         the first wake-up monitor currently online, or a null pointer
 *         if there are none.
 */
function yFirstWakeUpMonitor(): ?YWakeUpMonitor
{
    return YWakeUpMonitor::FirstWakeUpMonitor();
}

//--- (end of YWakeUpMonitor functions)

