<?php
/*********************************************************************
 *
 * $Id: yocto_dualpower.php 12324 2013-08-13 15:10:31Z mvuilleu $
 *
 * Implements yFindDualPower(), the high-level API for DualPower functions
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
//--- (YDualPower definitions)
if(!defined('Y_POWERSTATE_OFF')) define('Y_POWERSTATE_OFF', 0);
if(!defined('Y_POWERSTATE_FROM_USB')) define('Y_POWERSTATE_FROM_USB', 1);
if(!defined('Y_POWERSTATE_FROM_EXT')) define('Y_POWERSTATE_FROM_EXT', 2);
if(!defined('Y_POWERSTATE_INVALID')) define('Y_POWERSTATE_INVALID', -1);
if(!defined('Y_POWERCONTROL_AUTO')) define('Y_POWERCONTROL_AUTO', 0);
if(!defined('Y_POWERCONTROL_FROM_USB')) define('Y_POWERCONTROL_FROM_USB', 1);
if(!defined('Y_POWERCONTROL_FROM_EXT')) define('Y_POWERCONTROL_FROM_EXT', 2);
if(!defined('Y_POWERCONTROL_OFF')) define('Y_POWERCONTROL_OFF', 3);
if(!defined('Y_POWERCONTROL_INVALID')) define('Y_POWERCONTROL_INVALID', -1);
if(!defined('Y_LOGICALNAME_INVALID')) define('Y_LOGICALNAME_INVALID', Y_INVALID_STRING);
if(!defined('Y_ADVERTISEDVALUE_INVALID')) define('Y_ADVERTISEDVALUE_INVALID', Y_INVALID_STRING);
if(!defined('Y_EXTVOLTAGE_INVALID')) define('Y_EXTVOLTAGE_INVALID', Y_INVALID_UNSIGNED);
//--- (end of YDualPower definitions)

/**
 * YDualPower Class: External power supply control interface
 * 
 * Yoctopuce application programming interface allows you to control
 * the power source to use for module functions that require high current.
 * The module can also automatically disconnect the external power
 * when a voltage drop is observed on the external power source
 * (external battery running out of power).
 */
class YDualPower extends YFunction
{
    //--- (YDualPower implementation)
    const LOGICALNAME_INVALID = Y_INVALID_STRING;
    const ADVERTISEDVALUE_INVALID = Y_INVALID_STRING;
    const POWERSTATE_OFF = 0;
    const POWERSTATE_FROM_USB = 1;
    const POWERSTATE_FROM_EXT = 2;
    const POWERSTATE_INVALID = -1;
    const POWERCONTROL_AUTO = 0;
    const POWERCONTROL_FROM_USB = 1;
    const POWERCONTROL_FROM_EXT = 2;
    const POWERCONTROL_OFF = 3;
    const POWERCONTROL_INVALID = -1;
    const EXTVOLTAGE_INVALID = Y_INVALID_UNSIGNED;

    /**
     * Returns the logical name of the power control.
     * 
     * @return a string corresponding to the logical name of the power control
     * 
     * On failure, throws an exception or returns Y_LOGICALNAME_INVALID.
     */
    public function get_logicalName()
    {   $json_val = $this->_getAttr("logicalName");
        return (is_null($json_val) ? Y_LOGICALNAME_INVALID : $json_val);
    }

    /**
     * Changes the logical name of the power control. You can use yCheckLogicalName()
     * prior to this call to make sure that your parameter is valid.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     * 
     * @param newval : a string corresponding to the logical name of the power control
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
     * Returns the current value of the power control (no more than 6 characters).
     * 
     * @return a string corresponding to the current value of the power control (no more than 6 characters)
     * 
     * On failure, throws an exception or returns Y_ADVERTISEDVALUE_INVALID.
     */
    public function get_advertisedValue()
    {   $json_val = $this->_getAttr("advertisedValue");
        return (is_null($json_val) ? Y_ADVERTISEDVALUE_INVALID : $json_val);
    }

    /**
     * Returns the current power source for module functions that require lots of current.
     * 
     * @return a value among Y_POWERSTATE_OFF, Y_POWERSTATE_FROM_USB and Y_POWERSTATE_FROM_EXT
     * corresponding to the current power source for module functions that require lots of current
     * 
     * On failure, throws an exception or returns Y_POWERSTATE_INVALID.
     */
    public function get_powerState()
    {   $json_val = $this->_getAttr("powerState");
        return (is_null($json_val) ? Y_POWERSTATE_INVALID : intval($json_val));
    }

    /**
     * Returns the selected power source for module functions that require lots of current.
     * 
     * @return a value among Y_POWERCONTROL_AUTO, Y_POWERCONTROL_FROM_USB, Y_POWERCONTROL_FROM_EXT and
     * Y_POWERCONTROL_OFF corresponding to the selected power source for module functions that require lots of current
     * 
     * On failure, throws an exception or returns Y_POWERCONTROL_INVALID.
     */
    public function get_powerControl()
    {   $json_val = $this->_getAttr("powerControl");
        return (is_null($json_val) ? Y_POWERCONTROL_INVALID : intval($json_val));
    }

    /**
     * Changes the selected power source for module functions that require lots of current.
     * 
     * @param newval : a value among Y_POWERCONTROL_AUTO, Y_POWERCONTROL_FROM_USB, Y_POWERCONTROL_FROM_EXT
     * and Y_POWERCONTROL_OFF corresponding to the selected power source for module functions that require
     * lots of current
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_powerControl($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("powerControl",$rest_val);
    }

    /**
     * Returns the measured voltage on the external power source, in millivolts.
     * 
     * @return an integer corresponding to the measured voltage on the external power source, in millivolts
     * 
     * On failure, throws an exception or returns Y_EXTVOLTAGE_INVALID.
     */
    public function get_extVoltage()
    {   $json_val = $this->_getAttr("extVoltage");
        return (is_null($json_val) ? Y_EXTVOLTAGE_INVALID : intval($json_val));
    }

    public function logicalName()
    { return get_logicalName(); }

    public function setLogicalName($newval)
    { return set_logicalName($newval); }

    public function advertisedValue()
    { return get_advertisedValue(); }

    public function powerState()
    { return get_powerState(); }

    public function powerControl()
    { return get_powerControl(); }

    public function setPowerControl($newval)
    { return set_powerControl($newval); }

    public function extVoltage()
    { return get_extVoltage(); }

    /**
     * Continues the enumeration of dual power controls started using yFirstDualPower().
     * 
     * @return a pointer to a YDualPower object, corresponding to
     *         a dual power control currently online, or a null pointer
     *         if there are no more dual power controls to enumerate.
     */
    public function nextDualPower()
    {   $next_hwid = YAPI::getNextHardwareId($this->_className, $this->_func);
        if($next_hwid == null) return null;
        return yFindDualPower($next_hwid);
    }

    /**
     * Retrieves a dual power control for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     * 
     * This function does not require that the power control is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YDualPower.isOnline() to test if the power control is
     * indeed online at a given time. In case of ambiguity when looking for
     * a dual power control by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     * 
     * @param func : a string that uniquely characterizes the power control
     * 
     * @return a YDualPower object allowing you to drive the power control.
     */
    public static function FindDualPower($str_func)
    {   $obj_func = YAPI::getFunction('DualPower', $str_func);
        if($obj_func) return $obj_func;
        return new YDualPower($str_func);
    }

    /**
     * Starts the enumeration of dual power controls currently accessible.
     * Use the method YDualPower.nextDualPower() to iterate on
     * next dual power controls.
     * 
     * @return a pointer to a YDualPower object, corresponding to
     *         the first dual power control currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstDualPower()
    {   $next_hwid = YAPI::getFirstHardwareId('DualPower');
        if($next_hwid == null) return null;
        return self::FindDualPower($next_hwid);
    }

    //--- (end of YDualPower implementation)

    function __construct($str_func)
    {
        //--- (YDualPower constructor)
        parent::__construct('DualPower', $str_func);
        //--- (end of YDualPower constructor)
    }
};

//--- (DualPower functions)

/**
 * Retrieves a dual power control for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 * 
 * This function does not require that the power control is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YDualPower.isOnline() to test if the power control is
 * indeed online at a given time. In case of ambiguity when looking for
 * a dual power control by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 * 
 * @param func : a string that uniquely characterizes the power control
 * 
 * @return a YDualPower object allowing you to drive the power control.
 */
function yFindDualPower($str_func)
{
    return YDualPower::FindDualPower($str_func);
}

/**
 * Starts the enumeration of dual power controls currently accessible.
 * Use the method YDualPower.nextDualPower() to iterate on
 * next dual power controls.
 * 
 * @return a pointer to a YDualPower object, corresponding to
 *         the first dual power control currently online, or a null pointer
 *         if there are none.
 */
function yFirstDualPower()
{
    return YDualPower::FirstDualPower();
}

//--- (end of DualPower functions)
?>