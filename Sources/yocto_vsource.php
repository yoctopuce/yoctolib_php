<?php
/*********************************************************************
 *
 * $Id: yocto_vsource.php 10263 2013-03-11 17:25:38Z seb $
 *
 * Implements yFindVSource(), the high-level API for VSource functions
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
//--- (YVSource definitions)
if(!defined('Y_FAILURE_FALSE')) define('Y_FAILURE_FALSE', 0);
if(!defined('Y_FAILURE_TRUE')) define('Y_FAILURE_TRUE', 1);
if(!defined('Y_FAILURE_INVALID')) define('Y_FAILURE_INVALID', -1);
if(!defined('Y_OVERHEAT_FALSE')) define('Y_OVERHEAT_FALSE', 0);
if(!defined('Y_OVERHEAT_TRUE')) define('Y_OVERHEAT_TRUE', 1);
if(!defined('Y_OVERHEAT_INVALID')) define('Y_OVERHEAT_INVALID', -1);
if(!defined('Y_OVERCURRENT_FALSE')) define('Y_OVERCURRENT_FALSE', 0);
if(!defined('Y_OVERCURRENT_TRUE')) define('Y_OVERCURRENT_TRUE', 1);
if(!defined('Y_OVERCURRENT_INVALID')) define('Y_OVERCURRENT_INVALID', -1);
if(!defined('Y_OVERLOAD_FALSE')) define('Y_OVERLOAD_FALSE', 0);
if(!defined('Y_OVERLOAD_TRUE')) define('Y_OVERLOAD_TRUE', 1);
if(!defined('Y_OVERLOAD_INVALID')) define('Y_OVERLOAD_INVALID', -1);
if(!defined('Y_REGULATIONFAILURE_FALSE')) define('Y_REGULATIONFAILURE_FALSE', 0);
if(!defined('Y_REGULATIONFAILURE_TRUE')) define('Y_REGULATIONFAILURE_TRUE', 1);
if(!defined('Y_REGULATIONFAILURE_INVALID')) define('Y_REGULATIONFAILURE_INVALID', -1);
if(!defined('Y_EXTPOWERFAILURE_FALSE')) define('Y_EXTPOWERFAILURE_FALSE', 0);
if(!defined('Y_EXTPOWERFAILURE_TRUE')) define('Y_EXTPOWERFAILURE_TRUE', 1);
if(!defined('Y_EXTPOWERFAILURE_INVALID')) define('Y_EXTPOWERFAILURE_INVALID', -1);
if(!defined('Y_LOGICALNAME_INVALID')) define('Y_LOGICALNAME_INVALID', Y_INVALID_STRING);
if(!defined('Y_ADVERTISEDVALUE_INVALID')) define('Y_ADVERTISEDVALUE_INVALID', Y_INVALID_STRING);
if(!defined('Y_UNIT_INVALID')) define('Y_UNIT_INVALID', Y_INVALID_STRING);
if(!defined('Y_VOLTAGE_INVALID')) define('Y_VOLTAGE_INVALID', Y_INVALID_SIGNED);
if(!defined('Y_MOVE_INVALID')) define('Y_MOVE_INVALID', null);
if(!defined('Y_PULSETIMER_INVALID')) define('Y_PULSETIMER_INVALID', null);

if(!defined('CLASS_YMOVE')) {
    define('CLASS_YMOVE',true);
    class YMove extends YAggregate {
        public $target = 0;
        public $ms = 0;
        public $moving = 0;
    };
}

if(!defined('CLASS_YPULSE')) {
    define('CLASS_YPULSE',true);
    class YPulse extends YAggregate {
        public $target = 0;
        public $ms = 0;
        public $moving = 0;
    };
}
//--- (end of YVSource definitions)

/**
 * YVSource Class: Voltage source function interface
 * 
 * Yoctopuce application programming interface allows you to control
 * the module voltage output. You affect absolute output values or make
 * transitions
 */
class YVSource extends YFunction
{
    //--- (YVSource implementation)
    const LOGICALNAME_INVALID = Y_INVALID_STRING;
    const ADVERTISEDVALUE_INVALID = Y_INVALID_STRING;
    const UNIT_INVALID = Y_INVALID_STRING;
    const VOLTAGE_INVALID = Y_INVALID_SIGNED;
    const FAILURE_FALSE = 0;
    const FAILURE_TRUE = 1;
    const FAILURE_INVALID = -1;
    const OVERHEAT_FALSE = 0;
    const OVERHEAT_TRUE = 1;
    const OVERHEAT_INVALID = -1;
    const OVERCURRENT_FALSE = 0;
    const OVERCURRENT_TRUE = 1;
    const OVERCURRENT_INVALID = -1;
    const OVERLOAD_FALSE = 0;
    const OVERLOAD_TRUE = 1;
    const OVERLOAD_INVALID = -1;
    const REGULATIONFAILURE_FALSE = 0;
    const REGULATIONFAILURE_TRUE = 1;
    const REGULATIONFAILURE_INVALID = -1;
    const EXTPOWERFAILURE_FALSE = 0;
    const EXTPOWERFAILURE_TRUE = 1;
    const EXTPOWERFAILURE_INVALID = -1;

    /**
     * Returns the logical name of the voltage source.
     * 
     * @return a string corresponding to the logical name of the voltage source
     * 
     * On failure, throws an exception or returns Y_LOGICALNAME_INVALID.
     */
    public function get_logicalName()
    {   $json_val = $this->_getAttr("logicalName");
        return (is_null($json_val) ? Y_LOGICALNAME_INVALID : $json_val);
    }

    /**
     * Changes the logical name of the voltage source. You can use yCheckLogicalName()
     * prior to this call to make sure that your parameter is valid.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     * 
     * @param newval : a string corresponding to the logical name of the voltage source
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
     * Returns the current value of the voltage source (no more than 6 characters).
     * 
     * @return a string corresponding to the current value of the voltage source (no more than 6 characters)
     * 
     * On failure, throws an exception or returns Y_ADVERTISEDVALUE_INVALID.
     */
    public function get_advertisedValue()
    {   $json_val = $this->_getAttr("advertisedValue");
        return (is_null($json_val) ? Y_ADVERTISEDVALUE_INVALID : $json_val);
    }

    /**
     * Returns the measuring unit for the voltage.
     * 
     * @return a string corresponding to the measuring unit for the voltage
     * 
     * On failure, throws an exception or returns Y_UNIT_INVALID.
     */
    public function get_unit()
    {   $json_val = $this->_getAttr("unit");
        return (is_null($json_val) ? Y_UNIT_INVALID : $json_val);
    }

    /**
     * Returns the voltage output command (mV)
     * 
     * @return an integer corresponding to the voltage output command (mV)
     * 
     * On failure, throws an exception or returns Y_VOLTAGE_INVALID.
     */
    public function get_voltage()
    {   $json_val = $this->_getAttr("voltage");
        return (is_null($json_val) ? Y_VOLTAGE_INVALID : intval($json_val));
    }

    /**
     * Tunes the device output voltage (milliVolts).
     * 
     * @param newval : an integer
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_voltage($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("voltage",$rest_val);
    }

    /**
     * Returns true if the  module is in failure mode. More information can be obtained by testing
     * get_overheat, get_overcurrent etc... When a error condition is met, the output voltage is
     * set to zéro and cannot be changed until the reset() function is called.
     * 
     * @return either Y_FAILURE_FALSE or Y_FAILURE_TRUE, according to true if the  module is in failure mode
     * 
     * On failure, throws an exception or returns Y_FAILURE_INVALID.
     */
    public function get_failure()
    {   $json_val = $this->_getAttr("failure");
        return (is_null($json_val) ? Y_FAILURE_INVALID : intval($json_val));
    }

    public function set_failure($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("failure",$rest_val);
    }

    /**
     * Returns TRUE if the  module is overheating.
     * 
     * @return either Y_OVERHEAT_FALSE or Y_OVERHEAT_TRUE, according to TRUE if the  module is overheating
     * 
     * On failure, throws an exception or returns Y_OVERHEAT_INVALID.
     */
    public function get_overHeat()
    {   $json_val = $this->_getAttr("overHeat");
        return (is_null($json_val) ? Y_OVERHEAT_INVALID : intval($json_val));
    }

    /**
     * Returns true if the appliance connected to the device is too greedy .
     * 
     * @return either Y_OVERCURRENT_FALSE or Y_OVERCURRENT_TRUE, according to true if the appliance
     * connected to the device is too greedy
     * 
     * On failure, throws an exception or returns Y_OVERCURRENT_INVALID.
     */
    public function get_overCurrent()
    {   $json_val = $this->_getAttr("overCurrent");
        return (is_null($json_val) ? Y_OVERCURRENT_INVALID : intval($json_val));
    }

    /**
     * Returns true if the device is not able to maintaint the requested voltage output  .
     * 
     * @return either Y_OVERLOAD_FALSE or Y_OVERLOAD_TRUE, according to true if the device is not able to
     * maintaint the requested voltage output
     * 
     * On failure, throws an exception or returns Y_OVERLOAD_INVALID.
     */
    public function get_overLoad()
    {   $json_val = $this->_getAttr("overLoad");
        return (is_null($json_val) ? Y_OVERLOAD_INVALID : intval($json_val));
    }

    /**
     * Returns true if the voltage output is too high regarding the requested voltage  .
     * 
     * @return either Y_REGULATIONFAILURE_FALSE or Y_REGULATIONFAILURE_TRUE, according to true if the
     * voltage output is too high regarding the requested voltage
     * 
     * On failure, throws an exception or returns Y_REGULATIONFAILURE_INVALID.
     */
    public function get_regulationFailure()
    {   $json_val = $this->_getAttr("regulationFailure");
        return (is_null($json_val) ? Y_REGULATIONFAILURE_INVALID : intval($json_val));
    }

    /**
     * Returns true if external power supply voltage is too low.
     * 
     * @return either Y_EXTPOWERFAILURE_FALSE or Y_EXTPOWERFAILURE_TRUE, according to true if external
     * power supply voltage is too low
     * 
     * On failure, throws an exception or returns Y_EXTPOWERFAILURE_INVALID.
     */
    public function get_extPowerFailure()
    {   $json_val = $this->_getAttr("extPowerFailure");
        return (is_null($json_val) ? Y_EXTPOWERFAILURE_INVALID : intval($json_val));
    }

    public function get_move()
    {   $json_val = $this->_getAttr("move");
        return (is_null($json_val) ? Y_MOVE_INVALID : new YMove($json_val));
    }

    public function set_move($newval)
    {
        $rest_val = strval($newval["target"]).":".strval($newval["ms"]);
        return $this->_setAttr("move",$rest_val);
    }

    /**
     * Performs a smooth move at constant speed toward a given value.
     * 
     * @param target      : new output value at end of transition, in milliVolts.
     * @param ms_duration : transition duration, in milliseconds
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function voltageMove($int_target,$int_ms_duration)
    {
        $rest_val = strval($int_target).":".strval($int_ms_duration);
        return $this->_setAttr("move",$rest_val);
    }

    public function get_pulseTimer()
    {   $json_val = $this->_getAttr("pulseTimer");
        return (is_null($json_val) ? Y_PULSETIMER_INVALID : new YPulse($json_val));
    }

    public function set_pulseTimer($newval)
    {
        $rest_val = strval($newval["target"]).":".strval($newval["ms"]);
        return $this->_setAttr("pulseTimer",$rest_val);
    }

    /**
     * Sets device output to a specific volatage, for a specified duration, then brings it
     * automatically to 0V.
     * 
     * @param voltage : pulse voltage, in millivolts
     * @param ms_duration : pulse duration, in millisecondes
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function pulse($int_voltage,$int_ms_duration)
    {
        $rest_val = strval($int_voltage).":".strval($int_ms_duration);
        return $this->_setAttr("pulseTimer",$rest_val);
    }

    public function logicalName()
    { return get_logicalName(); }

    public function setLogicalName($newval)
    { return set_logicalName($newval); }

    public function advertisedValue()
    { return get_advertisedValue(); }

    public function unit()
    { return get_unit(); }

    public function voltage()
    { return get_voltage(); }

    public function setVoltage($newval)
    { return set_voltage($newval); }

    public function failure()
    { return get_failure(); }

    public function setFailure($newval)
    { return set_failure($newval); }

    public function overHeat()
    { return get_overHeat(); }

    public function overCurrent()
    { return get_overCurrent(); }

    public function overLoad()
    { return get_overLoad(); }

    public function regulationFailure()
    { return get_regulationFailure(); }

    public function extPowerFailure()
    { return get_extPowerFailure(); }

    public function move()
    { return get_move(); }

    public function setMove($newval)
    { return set_move($newval); }

    public function pulseTimer()
    { return get_pulseTimer(); }

    public function setPulseTimer($newval)
    { return set_pulseTimer($newval); }

    /**
     * Continues the enumeration of voltage sources started using yFirstVSource().
     * 
     * @return a pointer to a YVSource object, corresponding to
     *         a voltage source currently online, or a null pointer
     *         if there are no more voltage sources to enumerate.
     */
    public function nextVSource()
    {   $next_hwid = YAPI::getNextHardwareId($this->_className, $this->_func);
        if($next_hwid == null) return null;
        return yFindVSource($next_hwid);
    }

    /**
     * Retrieves a voltage source for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     * 
     * This function does not require that the voltage source is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YVSource.isOnline() to test if the voltage source is
     * indeed online at a given time. In case of ambiguity when looking for
     * a voltage source by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     * 
     * @param func : a string that uniquely characterizes the voltage source
     * 
     * @return a YVSource object allowing you to drive the voltage source.
     */
    public static function FindVSource($str_func)
    {   $obj_func = YAPI::getFunction('VSource', $str_func);
        if($obj_func) return $obj_func;
        return new YVSource($str_func);
    }

    /**
     * Starts the enumeration of voltage sources currently accessible.
     * Use the method YVSource.nextVSource() to iterate on
     * next voltage sources.
     * 
     * @return a pointer to a YVSource object, corresponding to
     *         the first voltage source currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstVSource()
    {   $next_hwid = YAPI::getFirstHardwareId('VSource');
        if($next_hwid == null) return null;
        return self::FindVSource($next_hwid);
    }

    //--- (end of YVSource implementation)

    function __construct($str_func)
    {
        //--- (YVSource constructor)
        parent::__construct('VSource', $str_func);
        //--- (end of YVSource constructor)
    }
};

//--- (VSource functions)

/**
 * Retrieves a voltage source for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 * 
 * This function does not require that the voltage source is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YVSource.isOnline() to test if the voltage source is
 * indeed online at a given time. In case of ambiguity when looking for
 * a voltage source by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 * 
 * @param func : a string that uniquely characterizes the voltage source
 * 
 * @return a YVSource object allowing you to drive the voltage source.
 */
function yFindVSource($str_func)
{
    return YVSource::FindVSource($str_func);
}

/**
 * Starts the enumeration of voltage sources currently accessible.
 * Use the method YVSource.nextVSource() to iterate on
 * next voltage sources.
 * 
 * @return a pointer to a YVSource object, corresponding to
 *         the first voltage source currently online, or a null pointer
 *         if there are none.
 */
function yFirstVSource()
{
    return YVSource::FirstVSource();
}

//--- (end of VSource functions)
?>