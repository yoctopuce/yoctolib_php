<?php
/*********************************************************************
 *
 * $Id: yocto_anbutton.php 9979 2013-02-22 13:45:33Z seb $
 *
 * Implements yFindAnButton(), the high-level API for AnButton functions
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
//--- (YAnButton definitions)
if(!defined('Y_ANALOGCALIBRATION_OFF')) define('Y_ANALOGCALIBRATION_OFF', 0);
if(!defined('Y_ANALOGCALIBRATION_ON')) define('Y_ANALOGCALIBRATION_ON', 1);
if(!defined('Y_ANALOGCALIBRATION_INVALID')) define('Y_ANALOGCALIBRATION_INVALID', -1);
if(!defined('Y_ISPRESSED_FALSE')) define('Y_ISPRESSED_FALSE', 0);
if(!defined('Y_ISPRESSED_TRUE')) define('Y_ISPRESSED_TRUE', 1);
if(!defined('Y_ISPRESSED_INVALID')) define('Y_ISPRESSED_INVALID', -1);
if(!defined('Y_LOGICALNAME_INVALID')) define('Y_LOGICALNAME_INVALID', Y_INVALID_STRING);
if(!defined('Y_ADVERTISEDVALUE_INVALID')) define('Y_ADVERTISEDVALUE_INVALID', Y_INVALID_STRING);
if(!defined('Y_CALIBRATEDVALUE_INVALID')) define('Y_CALIBRATEDVALUE_INVALID', Y_INVALID_UNSIGNED);
if(!defined('Y_RAWVALUE_INVALID')) define('Y_RAWVALUE_INVALID', Y_INVALID_UNSIGNED);
if(!defined('Y_CALIBRATIONMAX_INVALID')) define('Y_CALIBRATIONMAX_INVALID', Y_INVALID_UNSIGNED);
if(!defined('Y_CALIBRATIONMIN_INVALID')) define('Y_CALIBRATIONMIN_INVALID', Y_INVALID_UNSIGNED);
if(!defined('Y_SENSITIVITY_INVALID')) define('Y_SENSITIVITY_INVALID', Y_INVALID_UNSIGNED);
if(!defined('Y_LASTTIMEPRESSED_INVALID')) define('Y_LASTTIMEPRESSED_INVALID', Y_INVALID_UNSIGNED);
if(!defined('Y_LASTTIMERELEASED_INVALID')) define('Y_LASTTIMERELEASED_INVALID', Y_INVALID_UNSIGNED);
if(!defined('Y_PULSECOUNTER_INVALID')) define('Y_PULSECOUNTER_INVALID', Y_INVALID_UNSIGNED);
if(!defined('Y_PULSETIMER_INVALID')) define('Y_PULSETIMER_INVALID', Y_INVALID_UNSIGNED);
//--- (end of YAnButton definitions)

/**
 * YAnButton Class: AnButton function interface
 * 
 * Yoctopuce application programming interface allows you to measure the state
 * of a simple button as well as to read an analog potentiometer (variable resistance).
 * This can be use for instance with a continuous rotating knob, a throttle grip
 * or a joystick. The module is capable to calibrate itself on min and max values,
 * in order to compute a calibrated value that varies proportionally with the
 * potentiometer position, regardless of its total resistance.
 */
class YAnButton extends YFunction
{
    //--- (YAnButton implementation)
    const LOGICALNAME_INVALID = Y_INVALID_STRING;
    const ADVERTISEDVALUE_INVALID = Y_INVALID_STRING;
    const CALIBRATEDVALUE_INVALID = Y_INVALID_UNSIGNED;
    const RAWVALUE_INVALID = Y_INVALID_UNSIGNED;
    const ANALOGCALIBRATION_OFF = 0;
    const ANALOGCALIBRATION_ON = 1;
    const ANALOGCALIBRATION_INVALID = -1;
    const CALIBRATIONMAX_INVALID = Y_INVALID_UNSIGNED;
    const CALIBRATIONMIN_INVALID = Y_INVALID_UNSIGNED;
    const SENSITIVITY_INVALID = Y_INVALID_UNSIGNED;
    const ISPRESSED_FALSE = 0;
    const ISPRESSED_TRUE = 1;
    const ISPRESSED_INVALID = -1;
    const LASTTIMEPRESSED_INVALID = Y_INVALID_UNSIGNED;
    const LASTTIMERELEASED_INVALID = Y_INVALID_UNSIGNED;
    const PULSECOUNTER_INVALID = Y_INVALID_UNSIGNED;
    const PULSETIMER_INVALID = Y_INVALID_UNSIGNED;

    /**
     * Returns the logical name of the analog input.
     * 
     * @return a string corresponding to the logical name of the analog input
     * 
     * On failure, throws an exception or returns Y_LOGICALNAME_INVALID.
     */
    public function get_logicalName()
    {   $json_val = $this->_getAttr("logicalName");
        return (is_null($json_val) ? Y_LOGICALNAME_INVALID : $json_val);
    }

    /**
     * Changes the logical name of the analog input. You can use yCheckLogicalName()
     * prior to this call to make sure that your parameter is valid.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     * 
     * @param newval : a string corresponding to the logical name of the analog input
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
     * Returns the current value of the analog input (no more than 6 characters).
     * 
     * @return a string corresponding to the current value of the analog input (no more than 6 characters)
     * 
     * On failure, throws an exception or returns Y_ADVERTISEDVALUE_INVALID.
     */
    public function get_advertisedValue()
    {   $json_val = $this->_getAttr("advertisedValue");
        return (is_null($json_val) ? Y_ADVERTISEDVALUE_INVALID : $json_val);
    }

    /**
     * Returns the current calibrated input value (between 0 and 1000, included).
     * 
     * @return an integer corresponding to the current calibrated input value (between 0 and 1000, included)
     * 
     * On failure, throws an exception or returns Y_CALIBRATEDVALUE_INVALID.
     */
    public function get_calibratedValue()
    {   $json_val = $this->_getAttr("calibratedValue");
        return (is_null($json_val) ? Y_CALIBRATEDVALUE_INVALID : intval($json_val));
    }

    /**
     * Returns the current measured input value as-is (between 0 and 4095, included).
     * 
     * @return an integer corresponding to the current measured input value as-is (between 0 and 4095, included)
     * 
     * On failure, throws an exception or returns Y_RAWVALUE_INVALID.
     */
    public function get_rawValue()
    {   $json_val = $this->_getAttr("rawValue");
        return (is_null($json_val) ? Y_RAWVALUE_INVALID : intval($json_val));
    }

    /**
     * Tells if a calibration process is currently ongoing.
     * 
     * @return either Y_ANALOGCALIBRATION_OFF or Y_ANALOGCALIBRATION_ON
     * 
     * On failure, throws an exception or returns Y_ANALOGCALIBRATION_INVALID.
     */
    public function get_analogCalibration()
    {   $json_val = $this->_getAttr("analogCalibration");
        return (is_null($json_val) ? Y_ANALOGCALIBRATION_INVALID : intval($json_val));
    }

    /**
     * Starts or stops the calibration process. Remember to call the saveToFlash()
     * method of the module at the end of the calibration if the modification must be kept.
     * 
     * @param newval : either Y_ANALOGCALIBRATION_OFF or Y_ANALOGCALIBRATION_ON
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_analogCalibration($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("analogCalibration",$rest_val);
    }

    /**
     * Returns the maximal value measured during the calibration (between 0 and 4095, included).
     * 
     * @return an integer corresponding to the maximal value measured during the calibration (between 0
     * and 4095, included)
     * 
     * On failure, throws an exception or returns Y_CALIBRATIONMAX_INVALID.
     */
    public function get_calibrationMax()
    {   $json_val = $this->_getAttr("calibrationMax");
        return (is_null($json_val) ? Y_CALIBRATIONMAX_INVALID : intval($json_val));
    }

    /**
     * Changes the maximal calibration value for the input (between 0 and 4095, included), without actually
     * starting the automated calibration.  Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     * 
     * @param newval : an integer corresponding to the maximal calibration value for the input (between 0
     * and 4095, included), without actually
     *         starting the automated calibration
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_calibrationMax($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("calibrationMax",$rest_val);
    }

    /**
     * Returns the minimal value measured during the calibration (between 0 and 4095, included).
     * 
     * @return an integer corresponding to the minimal value measured during the calibration (between 0
     * and 4095, included)
     * 
     * On failure, throws an exception or returns Y_CALIBRATIONMIN_INVALID.
     */
    public function get_calibrationMin()
    {   $json_val = $this->_getAttr("calibrationMin");
        return (is_null($json_val) ? Y_CALIBRATIONMIN_INVALID : intval($json_val));
    }

    /**
     * Changes the minimal calibration value for the input (between 0 and 4095, included), without actually
     * starting the automated calibration.  Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     * 
     * @param newval : an integer corresponding to the minimal calibration value for the input (between 0
     * and 4095, included), without actually
     *         starting the automated calibration
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_calibrationMin($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("calibrationMin",$rest_val);
    }

    /**
     * Returns the sensibility for the input (between 1 and 255, included) for triggering user callbacks.
     * 
     * @return an integer corresponding to the sensibility for the input (between 1 and 255, included) for
     * triggering user callbacks
     * 
     * On failure, throws an exception or returns Y_SENSITIVITY_INVALID.
     */
    public function get_sensitivity()
    {   $json_val = $this->_getAttr("sensitivity");
        return (is_null($json_val) ? Y_SENSITIVITY_INVALID : intval($json_val));
    }

    /**
     * Changes the sensibility for the input (between 1 and 255, included) for triggering user callbacks.
     * Remember to call the saveToFlash() method of the module if the modification must be kept.
     * 
     * @param newval : an integer corresponding to the sensibility for the input (between 1 and 255,
     * included) for triggering user callbacks
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_sensitivity($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("sensitivity",$rest_val);
    }

    /**
     * Returns true if the input (considered as binary) is active (closed contact), and false otherwise.
     * 
     * @return either Y_ISPRESSED_FALSE or Y_ISPRESSED_TRUE, according to true if the input (considered as
     * binary) is active (closed contact), and false otherwise
     * 
     * On failure, throws an exception or returns Y_ISPRESSED_INVALID.
     */
    public function get_isPressed()
    {   $json_val = $this->_getAttr("isPressed");
        return (is_null($json_val) ? Y_ISPRESSED_INVALID : intval($json_val));
    }

    /**
     * Returns the number of elapsed milliseconds between the module power on and the last time
     * the input button was pressed (the input contact transitionned from open to closed).
     * 
     * @return an integer corresponding to the number of elapsed milliseconds between the module power on
     * and the last time
     *         the input button was pressed (the input contact transitionned from open to closed)
     * 
     * On failure, throws an exception or returns Y_LASTTIMEPRESSED_INVALID.
     */
    public function get_lastTimePressed()
    {   $json_val = $this->_getAttr("lastTimePressed");
        return (is_null($json_val) ? Y_LASTTIMEPRESSED_INVALID : intval($json_val));
    }

    /**
     * Returns the number of elapsed milliseconds between the module power on and the last time
     * the input button was released (the input contact transitionned from closed to open).
     * 
     * @return an integer corresponding to the number of elapsed milliseconds between the module power on
     * and the last time
     *         the input button was released (the input contact transitionned from closed to open)
     * 
     * On failure, throws an exception or returns Y_LASTTIMERELEASED_INVALID.
     */
    public function get_lastTimeReleased()
    {   $json_val = $this->_getAttr("lastTimeReleased");
        return (is_null($json_val) ? Y_LASTTIMERELEASED_INVALID : intval($json_val));
    }

    /**
     * Returns the pulse counter value
     * 
     * @return an integer corresponding to the pulse counter value
     * 
     * On failure, throws an exception or returns Y_PULSECOUNTER_INVALID.
     */
    public function get_pulseCounter()
    {   $json_val = $this->_getAttr("pulseCounter");
        return (is_null($json_val) ? Y_PULSECOUNTER_INVALID : intval($json_val));
    }

    public function set_pulseCounter($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("pulseCounter",$rest_val);
    }

    /**
     * Returns the pulse counter value as well as his timer
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function resetCounter()
    {
        $rest_val = '0';
        return $this->_setAttr("pulseCounter",$rest_val);
    }

    /**
     * Returns the timer of the pulses counter (ms)
     * 
     * @return an integer corresponding to the timer of the pulses counter (ms)
     * 
     * On failure, throws an exception or returns Y_PULSETIMER_INVALID.
     */
    public function get_pulseTimer()
    {   $json_val = $this->_getAttr("pulseTimer");
        return (is_null($json_val) ? Y_PULSETIMER_INVALID : intval($json_val));
    }

    public function logicalName()
    { return get_logicalName(); }

    public function setLogicalName($newval)
    { return set_logicalName($newval); }

    public function advertisedValue()
    { return get_advertisedValue(); }

    public function calibratedValue()
    { return get_calibratedValue(); }

    public function rawValue()
    { return get_rawValue(); }

    public function analogCalibration()
    { return get_analogCalibration(); }

    public function setAnalogCalibration($newval)
    { return set_analogCalibration($newval); }

    public function calibrationMax()
    { return get_calibrationMax(); }

    public function setCalibrationMax($newval)
    { return set_calibrationMax($newval); }

    public function calibrationMin()
    { return get_calibrationMin(); }

    public function setCalibrationMin($newval)
    { return set_calibrationMin($newval); }

    public function sensitivity()
    { return get_sensitivity(); }

    public function setSensitivity($newval)
    { return set_sensitivity($newval); }

    public function isPressed()
    { return get_isPressed(); }

    public function lastTimePressed()
    { return get_lastTimePressed(); }

    public function lastTimeReleased()
    { return get_lastTimeReleased(); }

    public function pulseCounter()
    { return get_pulseCounter(); }

    public function setPulseCounter($newval)
    { return set_pulseCounter($newval); }

    public function pulseTimer()
    { return get_pulseTimer(); }

    /**
     * Continues the enumeration of analog inputs started using yFirstAnButton().
     * 
     * @return a pointer to a YAnButton object, corresponding to
     *         an analog input currently online, or a null pointer
     *         if there are no more analog inputs to enumerate.
     */
    public function nextAnButton()
    {   $next_hwid = YAPI::getNextHardwareId($this->_className, $this->_func);
        if($next_hwid == null) return null;
        return yFindAnButton($next_hwid);
    }

    /**
     * Retrieves an analog input for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     * 
     * This function does not require that the analog input is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YAnButton.isOnline() to test if the analog input is
     * indeed online at a given time. In case of ambiguity when looking for
     * an analog input by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     * 
     * @param func : a string that uniquely characterizes the analog input
     * 
     * @return a YAnButton object allowing you to drive the analog input.
     */
    public static function FindAnButton($str_func)
    {   $obj_func = YAPI::getFunction('AnButton', $str_func);
        if($obj_func) return $obj_func;
        return new YAnButton($str_func);
    }

    /**
     * Starts the enumeration of analog inputs currently accessible.
     * Use the method YAnButton.nextAnButton() to iterate on
     * next analog inputs.
     * 
     * @return a pointer to a YAnButton object, corresponding to
     *         the first analog input currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstAnButton()
    {   $next_hwid = YAPI::getFirstHardwareId('AnButton');
        if($next_hwid == null) return null;
        return self::FindAnButton($next_hwid);
    }

    //--- (end of YAnButton implementation)

    function __construct($str_func)
    {
        //--- (YAnButton constructor)
        parent::__construct('AnButton', $str_func);
        //--- (end of YAnButton constructor)
    }
};

//--- (AnButton functions)

/**
 * Retrieves an analog input for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 * 
 * This function does not require that the analog input is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YAnButton.isOnline() to test if the analog input is
 * indeed online at a given time. In case of ambiguity when looking for
 * an analog input by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 * 
 * @param func : a string that uniquely characterizes the analog input
 * 
 * @return a YAnButton object allowing you to drive the analog input.
 */
function yFindAnButton($str_func)
{
    return YAnButton::FindAnButton($str_func);
}

/**
 * Starts the enumeration of analog inputs currently accessible.
 * Use the method YAnButton.nextAnButton() to iterate on
 * next analog inputs.
 * 
 * @return a pointer to a YAnButton object, corresponding to
 *         the first analog input currently online, or a null pointer
 *         if there are none.
 */
function yFirstAnButton()
{
    return YAnButton::FirstAnButton();
}

//--- (end of AnButton functions)
?>