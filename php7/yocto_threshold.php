<?php
/*********************************************************************
 *
 *  $Id: svn_id $
 *
 *  Implements YThreshold, the high-level API for Threshold functions
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

//--- (YThreshold return codes)
//--- (end of YThreshold return codes)
//--- (YThreshold definitions)
if (!defined('Y_THRESHOLDSTATE_SAFE')) {
    define('Y_THRESHOLDSTATE_SAFE', 0);
}
if (!defined('Y_THRESHOLDSTATE_ALERT')) {
    define('Y_THRESHOLDSTATE_ALERT', 1);
}
if (!defined('Y_THRESHOLDSTATE_INVALID')) {
    define('Y_THRESHOLDSTATE_INVALID', -1);
}
if (!defined('Y_TARGETSENSOR_INVALID')) {
    define('Y_TARGETSENSOR_INVALID', YAPI_INVALID_STRING);
}
if (!defined('Y_ALERTLEVEL_INVALID')) {
    define('Y_ALERTLEVEL_INVALID', YAPI_INVALID_DOUBLE);
}
if (!defined('Y_SAFELEVEL_INVALID')) {
    define('Y_SAFELEVEL_INVALID', YAPI_INVALID_DOUBLE);
}
//--- (end of YThreshold definitions)
    #--- (YThreshold yapiwrapper)

   #--- (end of YThreshold yapiwrapper)

//--- (YThreshold declaration)
//vvvv YThreshold.php

/**
 * YThreshold Class: Control interface to define a threshold
 *
 * The Threshold class allows you define a threshold on a Yoctopuce sensor
 * to trigger a predefined action, on specific devices where this is implemented.
 */
class YThreshold extends YFunction
{
    const THRESHOLDSTATE_SAFE = 0;
    const THRESHOLDSTATE_ALERT = 1;
    const THRESHOLDSTATE_INVALID = -1;
    const TARGETSENSOR_INVALID = YAPI::INVALID_STRING;
    const ALERTLEVEL_INVALID = YAPI::INVALID_DOUBLE;
    const SAFELEVEL_INVALID = YAPI::INVALID_DOUBLE;
    //--- (end of YThreshold declaration)

    //--- (YThreshold attributes)
    protected $_thresholdState = self::THRESHOLDSTATE_INVALID; // ThresholdState
    protected $_targetSensor = self::TARGETSENSOR_INVALID;   // Text
    protected $_alertLevel = self::ALERTLEVEL_INVALID;     // MeasureVal
    protected $_safeLevel = self::SAFELEVEL_INVALID;      // MeasureVal

    //--- (end of YThreshold attributes)

    function __construct(string $str_func)
    {
        //--- (YThreshold constructor)
        parent::__construct($str_func);
        $this->_className = 'Threshold';

        //--- (end of YThreshold constructor)
    }

    //--- (YThreshold implementation)

    function _parseAttr(string $name,  $val): int
    {
        switch ($name) {
        case 'thresholdState':
            $this->_thresholdState = intval($val);
            return 1;
        case 'targetSensor':
            $this->_targetSensor = $val;
            return 1;
        case 'alertLevel':
            $this->_alertLevel = round($val / 65.536) / 1000.0;
            return 1;
        case 'safeLevel':
            $this->_safeLevel = round($val / 65.536) / 1000.0;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns current state of the threshold function.
     *
     * @return int  either YThreshold::THRESHOLDSTATE_SAFE or YThreshold::THRESHOLDSTATE_ALERT, according to
     * current state of the threshold function
     *
     * On failure, throws an exception or returns YThreshold::THRESHOLDSTATE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_thresholdState(): int
    {
        // $res                    is a enumTHRESHOLDSTATE;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::THRESHOLDSTATE_INVALID;
            }
        }
        $res = $this->_thresholdState;
        return $res;
    }

    /**
     * Returns the name of the sensor monitored by the threshold function.
     *
     * @return string  a string corresponding to the name of the sensor monitored by the threshold function
     *
     * On failure, throws an exception or returns YThreshold::TARGETSENSOR_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_targetSensor(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::TARGETSENSOR_INVALID;
            }
        }
        $res = $this->_targetSensor;
        return $res;
    }

    /**
     * Changes the sensor alert level triggering the threshold function.
     * Remember to call the matching module saveToFlash()
     * method if you want to preserve the setting after reboot.
     *
     * @param float $newval : a floating point number corresponding to the sensor alert level triggering
     * the threshold function
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_alertLevel(float $newval): int
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("alertLevel", $rest_val);
    }

    /**
     * Returns the sensor alert level, triggering the threshold function.
     *
     * @return float  a floating point number corresponding to the sensor alert level, triggering the
     * threshold function
     *
     * On failure, throws an exception or returns YThreshold::ALERTLEVEL_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_alertLevel(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::ALERTLEVEL_INVALID;
            }
        }
        $res = $this->_alertLevel;
        return $res;
    }

    /**
     * Changes the sensor acceptable level for disabling the threshold function.
     * Remember to call the matching module saveToFlash()
     * method if you want to preserve the setting after reboot.
     *
     * @param float $newval : a floating point number corresponding to the sensor acceptable level for
     * disabling the threshold function
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_safeLevel(float $newval): int
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("safeLevel", $rest_val);
    }

    /**
     * Returns the sensor acceptable level for disabling the threshold function.
     *
     * @return float  a floating point number corresponding to the sensor acceptable level for disabling
     * the threshold function
     *
     * On failure, throws an exception or returns YThreshold::SAFELEVEL_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_safeLevel(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::SAFELEVEL_INVALID;
            }
        }
        $res = $this->_safeLevel;
        return $res;
    }

    /**
     * Retrieves a threshold function for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the threshold function is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the threshold function is
     * indeed online at a given time. In case of ambiguity when looking for
     * a threshold function by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the threshold function, for instance
     *         MyDevice.threshold1.
     *
     * @return YThreshold  a YThreshold object allowing you to drive the threshold function.
     */
    public static function FindThreshold(string $func): YThreshold
    {
        // $obj                    is a YThreshold;
        $obj = YFunction::_FindFromCache('Threshold', $func);
        if ($obj == null) {
            $obj = new YThreshold($func);
            YFunction::_AddToCache('Threshold', $func, $obj);
        }
        return $obj;
    }

    /**
     * @throws YAPI_Exception
     */
    public function thresholdState(): int
{
    return $this->get_thresholdState();
}

    /**
     * @throws YAPI_Exception
     */
    public function targetSensor(): string
{
    return $this->get_targetSensor();
}

    /**
     * @throws YAPI_Exception
     */
    public function setAlertLevel(float $newval): int
{
    return $this->set_alertLevel($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function alertLevel(): float
{
    return $this->get_alertLevel();
}

    /**
     * @throws YAPI_Exception
     */
    public function setSafeLevel(float $newval): int
{
    return $this->set_safeLevel($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function safeLevel(): float
{
    return $this->get_safeLevel();
}

    /**
     * Continues the enumeration of threshold functions started using yFirstThreshold().
     * Caution: You can't make any assumption about the returned threshold functions order.
     * If you want to find a specific a threshold function, use Threshold.findThreshold()
     * and a hardwareID or a logical name.
     *
     * @return ?YThreshold  a pointer to a YThreshold object, corresponding to
     *         a threshold function currently online, or a null pointer
     *         if there are no more threshold functions to enumerate.
     */
    public function nextThreshold(): ?YThreshold
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindThreshold($next_hwid);
    }

    /**
     * Starts the enumeration of threshold functions currently accessible.
     * Use the method YThreshold::nextThreshold() to iterate on
     * next threshold functions.
     *
     * @return ?YThreshold  a pointer to a YThreshold object, corresponding to
     *         the first threshold function currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstThreshold(): ?YThreshold
    {
        $next_hwid = YAPI::getFirstHardwareId('Threshold');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindThreshold($next_hwid);
    }

    //--- (end of YThreshold implementation)

}
//^^^^ YThreshold.php

//--- (YThreshold functions)

/**
 * Retrieves a threshold function for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 *
 * This function does not require that the threshold function is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method isOnline() to test if the threshold function is
 * indeed online at a given time. In case of ambiguity when looking for
 * a threshold function by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 *
 * If a call to this object's is_online() method returns FALSE although
 * you are certain that the matching device is plugged, make sure that you did
 * call registerHub() at application initialization time.
 *
 * @param string $func : a string that uniquely characterizes the threshold function, for instance
 *         MyDevice.threshold1.
 *
 * @return YThreshold  a YThreshold object allowing you to drive the threshold function.
 */
function yFindThreshold(string $func): YThreshold
{
    return YThreshold::FindThreshold($func);
}

/**
 * Starts the enumeration of threshold functions currently accessible.
 * Use the method YThreshold::nextThreshold() to iterate on
 * next threshold functions.
 *
 * @return ?YThreshold  a pointer to a YThreshold object, corresponding to
 *         the first threshold function currently online, or a null pointer
 *         if there are none.
 */
function yFirstThreshold(): ?YThreshold
{
    return YThreshold::FirstThreshold();
}

//--- (end of YThreshold functions)

