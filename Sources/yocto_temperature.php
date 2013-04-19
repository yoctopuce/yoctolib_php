<?php
/*********************************************************************
 *
 * $Id: yocto_temperature.php 11112 2013-04-16 14:51:20Z mvuilleu $
 *
 * Implements yFindTemperature(), the high-level API for Temperature functions
 *
 * - - - - - - - - - License information: - - - - - - - - - 
 *
 * Copyright (C) 2011 and beyond by Yoctopuce Sarl, Switzerland.
 *
 * 1) If you have obtained this file from www.yoctopuce.com,
 *    Yoctopuce Sarl licenses to you (hereafter Licensee) the
 *    right to use, modify, copy, and integrate this source file
 *    into your own solution for the sole purpose of interfacing
 *    a Yoctopuce product with Licensee's solution.
 *
 *    The use of this file and all relationship between Yoctopuce 
 *    and Licensee are governed by Yoctopuce General Terms and 
 *    Conditions.
 *
 *    THE SOFTWARE AND DOCUMENTATION ARE PROVIDED 'AS IS' WITHOUT
 *    WARRANTY OF ANY KIND, EITHER EXPRESS OR IMPLIED, INCLUDING 
 *    WITHOUT LIMITATION, ANY WARRANTY OF MERCHANTABILITY, FITNESS 
 *    FOR A PARTICULAR PURPOSE, TITLE AND NON-INFRINGEMENT. IN NO
 *    EVENT SHALL LICENSOR BE LIABLE FOR ANY INCIDENTAL, SPECIAL,
 *    INDIRECT OR CONSEQUENTIAL DAMAGES, LOST PROFITS OR LOST DATA, 
 *    COST OF PROCUREMENT OF SUBSTITUTE GOODS, TECHNOLOGY OR 
 *    SERVICES, ANY CLAIMS BY THIRD PARTIES (INCLUDING BUT NOT 
 *    LIMITED TO ANY DEFENSE THEREOF), ANY CLAIMS FOR INDEMNITY OR
 *    CONTRIBUTION, OR OTHER SIMILAR COSTS, WHETHER ASSERTED ON THE
 *    BASIS OF CONTRACT, TORT (INCLUDING NEGLIGENCE), BREACH OF
 *    WARRANTY, OR OTHERWISE.
 *
 * 2) If your intent is not to interface with Yoctopuce products,
 *    you are not entitled to use, read or create any derived
 *    material from this source file.
 *
 *********************************************************************/


//--- (return codes)
//--- (end of return codes)
//--- (YTemperature definitions)
if(!defined('Y_SENSORTYPE_DIGITAL')) define('Y_SENSORTYPE_DIGITAL', 0);
if(!defined('Y_SENSORTYPE_TYPE_K')) define('Y_SENSORTYPE_TYPE_K', 1);
if(!defined('Y_SENSORTYPE_TYPE_E')) define('Y_SENSORTYPE_TYPE_E', 2);
if(!defined('Y_SENSORTYPE_TYPE_J')) define('Y_SENSORTYPE_TYPE_J', 3);
if(!defined('Y_SENSORTYPE_TYPE_N')) define('Y_SENSORTYPE_TYPE_N', 4);
if(!defined('Y_SENSORTYPE_TYPE_R')) define('Y_SENSORTYPE_TYPE_R', 5);
if(!defined('Y_SENSORTYPE_TYPE_S')) define('Y_SENSORTYPE_TYPE_S', 6);
if(!defined('Y_SENSORTYPE_TYPE_T')) define('Y_SENSORTYPE_TYPE_T', 7);
if(!defined('Y_SENSORTYPE_INVALID')) define('Y_SENSORTYPE_INVALID', -1);
if(!defined('Y_LOGICALNAME_INVALID')) define('Y_LOGICALNAME_INVALID', Y_INVALID_STRING);
if(!defined('Y_ADVERTISEDVALUE_INVALID')) define('Y_ADVERTISEDVALUE_INVALID', Y_INVALID_STRING);
if(!defined('Y_UNIT_INVALID')) define('Y_UNIT_INVALID', Y_INVALID_STRING);
if(!defined('Y_CURRENTVALUE_INVALID')) define('Y_CURRENTVALUE_INVALID', Y_INVALID_FLOAT);
if(!defined('Y_LOWESTVALUE_INVALID')) define('Y_LOWESTVALUE_INVALID', Y_INVALID_FLOAT);
if(!defined('Y_HIGHESTVALUE_INVALID')) define('Y_HIGHESTVALUE_INVALID', Y_INVALID_FLOAT);
if(!defined('Y_CURRENTRAWVALUE_INVALID')) define('Y_CURRENTRAWVALUE_INVALID', Y_INVALID_FLOAT);
if(!defined('Y_RESOLUTION_INVALID')) define('Y_RESOLUTION_INVALID', Y_INVALID_FLOAT);
if(!defined('Y_CALIBRATIONPARAM_INVALID')) define('Y_CALIBRATIONPARAM_INVALID', Y_INVALID_STRING);
//--- (end of YTemperature definitions)

/**
 * YTemperature Class: Temperature function interface
 * 
 * The Yoctopuce application programming interface allows you to read an instant
 * measure of the sensor, as well as the minimal and maximal values observed.
 */
class YTemperature extends YFunction
{
    //--- (YTemperature implementation)
    const LOGICALNAME_INVALID = Y_INVALID_STRING;
    const ADVERTISEDVALUE_INVALID = Y_INVALID_STRING;
    const UNIT_INVALID = Y_INVALID_STRING;
    const CURRENTVALUE_INVALID = Y_INVALID_FLOAT;
    const LOWESTVALUE_INVALID = Y_INVALID_FLOAT;
    const HIGHESTVALUE_INVALID = Y_INVALID_FLOAT;
    const CURRENTRAWVALUE_INVALID = Y_INVALID_FLOAT;
    const RESOLUTION_INVALID = Y_INVALID_FLOAT;
    const CALIBRATIONPARAM_INVALID = Y_INVALID_STRING;
    const SENSORTYPE_DIGITAL = 0;
    const SENSORTYPE_TYPE_K = 1;
    const SENSORTYPE_TYPE_E = 2;
    const SENSORTYPE_TYPE_J = 3;
    const SENSORTYPE_TYPE_N = 4;
    const SENSORTYPE_TYPE_R = 5;
    const SENSORTYPE_TYPE_S = 6;
    const SENSORTYPE_TYPE_T = 7;
    const SENSORTYPE_INVALID = -1;
    public  $_calibrationOffset = -32767;

    /**
     * Returns the logical name of the temperature sensor.
     * 
     * @return a string corresponding to the logical name of the temperature sensor
     * 
     * On failure, throws an exception or returns Y_LOGICALNAME_INVALID.
     */
    public function get_logicalName()
    {   $json_val = $this->_getAttr("logicalName");
        return (is_null($json_val) ? Y_LOGICALNAME_INVALID : $json_val);
    }

    /**
     * Changes the logical name of the temperature sensor. You can use yCheckLogicalName()
     * prior to this call to make sure that your parameter is valid.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     * 
     * @param newval : a string corresponding to the logical name of the temperature sensor
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
     * Returns the current value of the temperature sensor (no more than 6 characters).
     * 
     * @return a string corresponding to the current value of the temperature sensor (no more than 6 characters)
     * 
     * On failure, throws an exception or returns Y_ADVERTISEDVALUE_INVALID.
     */
    public function get_advertisedValue()
    {   $json_val = $this->_getAttr("advertisedValue");
        return (is_null($json_val) ? Y_ADVERTISEDVALUE_INVALID : $json_val);
    }

    /**
     * Returns the measuring unit for the measured value.
     * 
     * @return a string corresponding to the measuring unit for the measured value
     * 
     * On failure, throws an exception or returns Y_UNIT_INVALID.
     */
    public function get_unit()
    {   $json_val = $this->_getFixedAttr("unit");
        return (is_null($json_val) ? Y_UNIT_INVALID : $json_val);
    }

    /**
     * Returns the current measured value.
     * 
     * @return a floating point number corresponding to the current measured value
     * 
     * On failure, throws an exception or returns Y_CURRENTVALUE_INVALID.
     */
    public function get_currentValue()
    {   $json_val = $this->_getAttr("currentValue");
        if(isset($this->_cache['calibrationParam'])) {
            $res = YAPI::applyCalibration($this);
            if($res != Y_CURRENTVALUE_INVALID) return $res;
        }
        return (is_null($json_val) ? Y_CURRENTVALUE_INVALID : round($json_val/6553.6) / 10);
    }

    /**
     * Changes the recorded minimal value observed.
     * 
     * @param newval : a floating point number corresponding to the recorded minimal value observed
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_lowestValue($newval)
    {
        $rest_val = strval(round($newval*65536.0));
        return $this->_setAttr("lowestValue",$rest_val);
    }

    /**
     * Returns the minimal value observed.
     * 
     * @return a floating point number corresponding to the minimal value observed
     * 
     * On failure, throws an exception or returns Y_LOWESTVALUE_INVALID.
     */
    public function get_lowestValue()
    {   $json_val = $this->_getAttr("lowestValue");
        return (is_null($json_val) ? Y_LOWESTVALUE_INVALID : round($json_val/6553.6) / 10);
    }

    /**
     * Changes the recorded maximal value observed.
     * 
     * @param newval : a floating point number corresponding to the recorded maximal value observed
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_highestValue($newval)
    {
        $rest_val = strval(round($newval*65536.0));
        return $this->_setAttr("highestValue",$rest_val);
    }

    /**
     * Returns the maximal value observed.
     * 
     * @return a floating point number corresponding to the maximal value observed
     * 
     * On failure, throws an exception or returns Y_HIGHESTVALUE_INVALID.
     */
    public function get_highestValue()
    {   $json_val = $this->_getAttr("highestValue");
        return (is_null($json_val) ? Y_HIGHESTVALUE_INVALID : round($json_val/6553.6) / 10);
    }

    /**
     * Returns the uncalibrated, unrounded raw value returned by the sensor.
     * 
     * @return a floating point number corresponding to the uncalibrated, unrounded raw value returned by the sensor
     * 
     * On failure, throws an exception or returns Y_CURRENTRAWVALUE_INVALID.
     */
    public function get_currentRawValue()
    {   $json_val = $this->_getAttr("currentRawValue");
        return (is_null($json_val) ? Y_CURRENTRAWVALUE_INVALID : $json_val/65536.0);
    }

    public function set_resolution($newval)
    {
        $rest_val = strval(round($newval*65536.0));
        return $this->_setAttr("resolution",$rest_val);
    }

    /**
     * Returns the resolution of the measured values. The resolution corresponds to the numerical precision
     * of the values, which is not always the same as the actual precision of the sensor.
     * 
     * @return a floating point number corresponding to the resolution of the measured values
     * 
     * On failure, throws an exception or returns Y_RESOLUTION_INVALID.
     */
    public function get_resolution()
    {   $json_val = $this->_getAttr("resolution");
        return (is_null($json_val) ? Y_RESOLUTION_INVALID : 1.0 / round(65536.0/$json_val));
    }

    public function get_calibrationParam()
    {   $json_val = $this->_getAttr("calibrationParam");
        return (is_null($json_val) ? Y_CALIBRATIONPARAM_INVALID : $json_val);
    }

    public function set_calibrationParam($newval)
    {
        $rest_val = $newval;
        return $this->_setAttr("calibrationParam",$rest_val);
    }

    /**
     * Configures error correction data points, in particular to compensate for
     * a possible perturbation of the measure caused by an enclosure. It is possible
     * to configure up to five correction points. Correction points must be provided
     * in ascending order, and be in the range of the sensor. The device will automatically
     * perform a lineat interpolatation of the error correction between specified
     * points. Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     * 
     * For more information on advanced capabilities to refine the calibration of
     * sensors, please contact support@yoctopuce.com.
     * 
     * @param rawValues : array of floating point numbers, corresponding to the raw
     *         values returned by the sensor for the correction points.
     * @param refValues : array of floating point numbers, corresponding to the corrected
     *         values for the correction points.
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function calibrateFromPoints($floatArr_rawValues,$floatArr_refValues)
    {
        $rest_val = $this->_encodeCalibrationPoints($floatArr_rawValues,$floatArr_refValues);
        return $this->_setAttr("calibrationParam",$rest_val);
    }

    public function loadCalibrationPoints(&$floatArrRef_rawValues,&$floatArrRef_refValues)
    {
        return $this->_decodeCalibrationPoints($floatArrRef_rawValues,$floatArrRef_refValues);
    }

    /**
     * Returns the tempeture sensor type.
     * 
     * @return a value among Y_SENSORTYPE_DIGITAL, Y_SENSORTYPE_TYPE_K, Y_SENSORTYPE_TYPE_E,
     * Y_SENSORTYPE_TYPE_J, Y_SENSORTYPE_TYPE_N, Y_SENSORTYPE_TYPE_R, Y_SENSORTYPE_TYPE_S and
     * Y_SENSORTYPE_TYPE_T corresponding to the tempeture sensor type
     * 
     * On failure, throws an exception or returns Y_SENSORTYPE_INVALID.
     */
    public function get_sensorType()
    {   $json_val = $this->_getAttr("sensorType");
        return (is_null($json_val) ? Y_SENSORTYPE_INVALID : intval($json_val));
    }

    /**
     * Modify the temperature sensor type.  This function is used to
     * to define the type of thermo couple (K,E...) used with the device.
     * This will have no effect if module is using a digital sensor.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     * 
     * @param newval : a value among Y_SENSORTYPE_DIGITAL, Y_SENSORTYPE_TYPE_K, Y_SENSORTYPE_TYPE_E,
     * Y_SENSORTYPE_TYPE_J, Y_SENSORTYPE_TYPE_N, Y_SENSORTYPE_TYPE_R, Y_SENSORTYPE_TYPE_S and Y_SENSORTYPE_TYPE_T
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_sensorType($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("sensorType",$rest_val);
    }

    public function logicalName()
    { return get_logicalName(); }

    public function setLogicalName($newval)
    { return set_logicalName($newval); }

    public function advertisedValue()
    { return get_advertisedValue(); }

    public function unit()
    { return get_unit(); }

    public function currentValue()
    { return get_currentValue(); }

    public function setLowestValue($newval)
    { return set_lowestValue($newval); }

    public function lowestValue()
    { return get_lowestValue(); }

    public function setHighestValue($newval)
    { return set_highestValue($newval); }

    public function highestValue()
    { return get_highestValue(); }

    public function currentRawValue()
    { return get_currentRawValue(); }

    public function setResolution($newval)
    { return set_resolution($newval); }

    public function resolution()
    { return get_resolution(); }

    public function calibrationParam()
    { return get_calibrationParam(); }

    public function setCalibrationParam($newval)
    { return set_calibrationParam($newval); }

    public function sensorType()
    { return get_sensorType(); }

    public function setSensorType($newval)
    { return set_sensorType($newval); }

    /**
     * Continues the enumeration of temperature sensors started using yFirstTemperature().
     * 
     * @return a pointer to a YTemperature object, corresponding to
     *         a temperature sensor currently online, or a null pointer
     *         if there are no more temperature sensors to enumerate.
     */
    public function nextTemperature()
    {   $next_hwid = YAPI::getNextHardwareId($this->_className, $this->_func);
        if($next_hwid == null) return null;
        return yFindTemperature($next_hwid);
    }

    /**
     * Retrieves a temperature sensor for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     * 
     * This function does not require that the temperature sensor is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YTemperature.isOnline() to test if the temperature sensor is
     * indeed online at a given time. In case of ambiguity when looking for
     * a temperature sensor by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     * 
     * @param func : a string that uniquely characterizes the temperature sensor
     * 
     * @return a YTemperature object allowing you to drive the temperature sensor.
     */
    public static function FindTemperature($str_func)
    {   $obj_func = YAPI::getFunction('Temperature', $str_func);
        if($obj_func) return $obj_func;
        return new YTemperature($str_func);
    }

    /**
     * Starts the enumeration of temperature sensors currently accessible.
     * Use the method YTemperature.nextTemperature() to iterate on
     * next temperature sensors.
     * 
     * @return a pointer to a YTemperature object, corresponding to
     *         the first temperature sensor currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstTemperature()
    {   $next_hwid = YAPI::getFirstHardwareId('Temperature');
        if($next_hwid == null) return null;
        return self::FindTemperature($next_hwid);
    }

    //--- (end of YTemperature implementation)

    function __construct($str_func)
    {
        //--- (YTemperature constructor)
        parent::__construct('Temperature', $str_func);
        //--- (end of YTemperature constructor)
    }
};

//--- (Temperature functions)

/**
 * Retrieves a temperature sensor for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 * 
 * This function does not require that the temperature sensor is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YTemperature.isOnline() to test if the temperature sensor is
 * indeed online at a given time. In case of ambiguity when looking for
 * a temperature sensor by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 * 
 * @param func : a string that uniquely characterizes the temperature sensor
 * 
 * @return a YTemperature object allowing you to drive the temperature sensor.
 */
function yFindTemperature($str_func)
{
    return YTemperature::FindTemperature($str_func);
}

/**
 * Starts the enumeration of temperature sensors currently accessible.
 * Use the method YTemperature.nextTemperature() to iterate on
 * next temperature sensors.
 * 
 * @return a pointer to a YTemperature object, corresponding to
 *         the first temperature sensor currently online, or a null pointer
 *         if there are none.
 */
function yFirstTemperature()
{
    return YTemperature::FirstTemperature();
}

//--- (end of Temperature functions)
?>