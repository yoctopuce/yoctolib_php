<?php
/*********************************************************************
 *
 *  $Id: svn_id $
 *
 *  Implements YLightSensor, the high-level API for LightSensor functions
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

//--- (YLightSensor return codes)
//--- (end of YLightSensor return codes)
//--- (YLightSensor definitions)
if (!defined('Y_MEASURETYPE_HUMAN_EYE')) {
    define('Y_MEASURETYPE_HUMAN_EYE', 0);
}
if (!defined('Y_MEASURETYPE_WIDE_SPECTRUM')) {
    define('Y_MEASURETYPE_WIDE_SPECTRUM', 1);
}
if (!defined('Y_MEASURETYPE_INFRARED')) {
    define('Y_MEASURETYPE_INFRARED', 2);
}
if (!defined('Y_MEASURETYPE_HIGH_RATE')) {
    define('Y_MEASURETYPE_HIGH_RATE', 3);
}
if (!defined('Y_MEASURETYPE_HIGH_ENERGY')) {
    define('Y_MEASURETYPE_HIGH_ENERGY', 4);
}
if (!defined('Y_MEASURETYPE_HIGH_RESOLUTION')) {
    define('Y_MEASURETYPE_HIGH_RESOLUTION', 5);
}
if (!defined('Y_MEASURETYPE_INVALID')) {
    define('Y_MEASURETYPE_INVALID', -1);
}
//--- (end of YLightSensor definitions)
    #--- (YLightSensor yapiwrapper)

   #--- (end of YLightSensor yapiwrapper)

//--- (YLightSensor declaration)
//vvvv YLightSensor.php

/**
 * YLightSensor Class: light sensor control interface, available for instance in the Yocto-Light-V4,
 * the Yocto-Proximity or the Yocto-RangeFinder
 *
 * The YLightSensor class allows you to read and configure Yoctopuce light sensors.
 * It inherits from YSensor class the core functions to read measures,
 * to register callback functions, and to access the autonomous datalogger.
 * This class adds the ability to easily perform a one-point linear calibration
 * to compensate the effect of a glass or filter placed in front of the sensor.
 * For some light sensors with several working modes, this class can select the
 * desired working mode.
 */
class YLightSensor extends YSensor
{
    const MEASURETYPE_HUMAN_EYE = 0;
    const MEASURETYPE_WIDE_SPECTRUM = 1;
    const MEASURETYPE_INFRARED = 2;
    const MEASURETYPE_HIGH_RATE = 3;
    const MEASURETYPE_HIGH_ENERGY = 4;
    const MEASURETYPE_HIGH_RESOLUTION = 5;
    const MEASURETYPE_INVALID = -1;
    //--- (end of YLightSensor declaration)

    //--- (YLightSensor attributes)
    protected $_measureType = self::MEASURETYPE_INVALID;    // LightSensorTypeAll

    //--- (end of YLightSensor attributes)

    function __construct(string $str_func)
    {
        //--- (YLightSensor constructor)
        parent::__construct($str_func);
        $this->_className = 'LightSensor';

        //--- (end of YLightSensor constructor)
    }

    //--- (YLightSensor implementation)

    function _parseAttr(string $name,  $val): int
    {
        switch ($name) {
        case 'measureType':
            $this->_measureType = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * @throws YAPI_Exception
     */
    public function set_currentValue(float $newval): int
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("currentValue", $rest_val);
    }

    /**
     * Changes the sensor-specific calibration parameter so that the current value
     * matches a desired target (linear scaling).
     *
     * @param float $calibratedVal : the desired target value.
     *
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function calibrate(float $calibratedVal): int
    {
        $rest_val = strval(round($calibratedVal * 65536.0));
        return $this->_setAttr("currentValue",$rest_val);
    }

    /**
     * Returns the type of light measure.
     *
     * @return int  a value among YLightSensor::MEASURETYPE_HUMAN_EYE,
     * YLightSensor::MEASURETYPE_WIDE_SPECTRUM, YLightSensor::MEASURETYPE_INFRARED,
     * YLightSensor::MEASURETYPE_HIGH_RATE, YLightSensor::MEASURETYPE_HIGH_ENERGY and
     * YLightSensor::MEASURETYPE_HIGH_RESOLUTION corresponding to the type of light measure
     *
     * On failure, throws an exception or returns YLightSensor::MEASURETYPE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_measureType(): int
    {
        // $res                    is a enumLIGHTSENSORTYPEALL;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::MEASURETYPE_INVALID;
            }
        }
        $res = $this->_measureType;
        return $res;
    }

    /**
     * Changes the light sensor type used in the device. The measure can either
     * approximate the response of the human eye, focus on a specific light
     * spectrum, depending on the capabilities of the light-sensitive cell.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param int $newval : a value among YLightSensor::MEASURETYPE_HUMAN_EYE,
     * YLightSensor::MEASURETYPE_WIDE_SPECTRUM, YLightSensor::MEASURETYPE_INFRARED,
     * YLightSensor::MEASURETYPE_HIGH_RATE, YLightSensor::MEASURETYPE_HIGH_ENERGY and
     * YLightSensor::MEASURETYPE_HIGH_RESOLUTION corresponding to the light sensor type used in the device
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_measureType(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("measureType", $rest_val);
    }

    /**
     * Retrieves a light sensor for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the light sensor is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the light sensor is
     * indeed online at a given time. In case of ambiguity when looking for
     * a light sensor by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the light sensor, for instance
     *         LIGHTMK4.lightSensor.
     *
     * @return YLightSensor  a YLightSensor object allowing you to drive the light sensor.
     */
    public static function FindLightSensor(string $func): YLightSensor
    {
        // $obj                    is a YLightSensor;
        $obj = YFunction::_FindFromCache('LightSensor', $func);
        if ($obj == null) {
            $obj = new YLightSensor($func);
            YFunction::_AddToCache('LightSensor', $func, $obj);
        }
        return $obj;
    }

    /**
     * @throws YAPI_Exception
     */
    public function setCurrentValue(float $newval): int
{
    return $this->set_currentValue($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function measureType(): int
{
    return $this->get_measureType();
}

    /**
     * @throws YAPI_Exception
     */
    public function setMeasureType(int $newval): int
{
    return $this->set_measureType($newval);
}

    /**
     * Continues the enumeration of light sensors started using yFirstLightSensor().
     * Caution: You can't make any assumption about the returned light sensors order.
     * If you want to find a specific a light sensor, use LightSensor.findLightSensor()
     * and a hardwareID or a logical name.
     *
     * @return ?YLightSensor  a pointer to a YLightSensor object, corresponding to
     *         a light sensor currently online, or a null pointer
     *         if there are no more light sensors to enumerate.
     */
    public function nextLightSensor(): ?YLightSensor
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindLightSensor($next_hwid);
    }

    /**
     * Starts the enumeration of light sensors currently accessible.
     * Use the method YLightSensor::nextLightSensor() to iterate on
     * next light sensors.
     *
     * @return ?YLightSensor  a pointer to a YLightSensor object, corresponding to
     *         the first light sensor currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstLightSensor(): ?YLightSensor
    {
        $next_hwid = YAPI::getFirstHardwareId('LightSensor');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindLightSensor($next_hwid);
    }

    //--- (end of YLightSensor implementation)

}
//^^^^ YLightSensor.php

//--- (YLightSensor functions)

/**
 * Retrieves a light sensor for a given identifier.
 * The identifier can be specified using several formats:
 *
 * - FunctionLogicalName
 * - ModuleSerialNumber.FunctionIdentifier
 * - ModuleSerialNumber.FunctionLogicalName
 * - ModuleLogicalName.FunctionIdentifier
 * - ModuleLogicalName.FunctionLogicalName
 *
 *
 * This function does not require that the light sensor is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method isOnline() to test if the light sensor is
 * indeed online at a given time. In case of ambiguity when looking for
 * a light sensor by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 *
 * If a call to this object's is_online() method returns FALSE although
 * you are certain that the matching device is plugged, make sure that you did
 * call registerHub() at application initialization time.
 *
 * @param string $func : a string that uniquely characterizes the light sensor, for instance
 *         LIGHTMK4.lightSensor.
 *
 * @return YLightSensor  a YLightSensor object allowing you to drive the light sensor.
 */
function yFindLightSensor(string $func): YLightSensor
{
    return YLightSensor::FindLightSensor($func);
}

/**
 * Starts the enumeration of light sensors currently accessible.
 * Use the method YLightSensor::nextLightSensor() to iterate on
 * next light sensors.
 *
 * @return ?YLightSensor  a pointer to a YLightSensor object, corresponding to
 *         the first light sensor currently online, or a null pointer
 *         if there are none.
 */
function yFirstLightSensor(): ?YLightSensor
{
    return YLightSensor::FirstLightSensor();
}

//--- (end of YLightSensor functions)

