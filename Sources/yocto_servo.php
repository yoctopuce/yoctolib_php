<?php
/*********************************************************************
 *
 * $Id: yocto_servo.php 9979 2013-02-22 13:45:33Z seb $
 *
 * Implements yFindServo(), the high-level API for Servo functions
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
//--- (YServo definitions)
if(!defined('Y_LOGICALNAME_INVALID')) define('Y_LOGICALNAME_INVALID', Y_INVALID_STRING);
if(!defined('Y_ADVERTISEDVALUE_INVALID')) define('Y_ADVERTISEDVALUE_INVALID', Y_INVALID_STRING);
if(!defined('Y_POSITION_INVALID')) define('Y_POSITION_INVALID', Y_INVALID_SIGNED);
if(!defined('Y_RANGE_INVALID')) define('Y_RANGE_INVALID', Y_INVALID_UNSIGNED);
if(!defined('Y_NEUTRAL_INVALID')) define('Y_NEUTRAL_INVALID', Y_INVALID_UNSIGNED);
if(!defined('Y_MOVE_INVALID')) define('Y_MOVE_INVALID', null);

if(!defined('CLASS_YMOVE')) {
    define('CLASS_YMOVE',true);
    class YMove extends YAggregate {
        public $target = 0;
        public $ms = 0;
        public $moving = 0;
    };
}
//--- (end of YServo definitions)

/**
 * YServo Class: Servo function interface
 * 
 * Yoctopuce application programming interface allows you not only to move
 * a servo to a given position, but also to specify the time interval
 * in which the move should be performed. This makes it possible to
 * synchronize two servos involved in a same move.
 */
class YServo extends YFunction
{
    //--- (YServo implementation)
    const LOGICALNAME_INVALID = Y_INVALID_STRING;
    const ADVERTISEDVALUE_INVALID = Y_INVALID_STRING;
    const POSITION_INVALID = Y_INVALID_SIGNED;
    const RANGE_INVALID = Y_INVALID_UNSIGNED;
    const NEUTRAL_INVALID = Y_INVALID_UNSIGNED;

    /**
     * Returns the logical name of the servo.
     * 
     * @return a string corresponding to the logical name of the servo
     * 
     * On failure, throws an exception or returns Y_LOGICALNAME_INVALID.
     */
    public function get_logicalName()
    {   $json_val = $this->_getAttr("logicalName");
        return (is_null($json_val) ? Y_LOGICALNAME_INVALID : $json_val);
    }

    /**
     * Changes the logical name of the servo. You can use yCheckLogicalName()
     * prior to this call to make sure that your parameter is valid.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     * 
     * @param newval : a string corresponding to the logical name of the servo
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
     * Returns the current value of the servo (no more than 6 characters).
     * 
     * @return a string corresponding to the current value of the servo (no more than 6 characters)
     * 
     * On failure, throws an exception or returns Y_ADVERTISEDVALUE_INVALID.
     */
    public function get_advertisedValue()
    {   $json_val = $this->_getAttr("advertisedValue");
        return (is_null($json_val) ? Y_ADVERTISEDVALUE_INVALID : $json_val);
    }

    /**
     * Returns the current servo position.
     * 
     * @return an integer corresponding to the current servo position
     * 
     * On failure, throws an exception or returns Y_POSITION_INVALID.
     */
    public function get_position()
    {   $json_val = $this->_getAttr("position");
        return (is_null($json_val) ? Y_POSITION_INVALID : intval($json_val));
    }

    /**
     * Changes immediately the servo driving position.
     * 
     * @param newval : an integer corresponding to immediately the servo driving position
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_position($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("position",$rest_val);
    }

    /**
     * Returns the current range of use of the servo.
     * 
     * @return an integer corresponding to the current range of use of the servo
     * 
     * On failure, throws an exception or returns Y_RANGE_INVALID.
     */
    public function get_range()
    {   $json_val = $this->_getAttr("range");
        return (is_null($json_val) ? Y_RANGE_INVALID : intval($json_val));
    }

    /**
     * Changes the range of use of the servo, specified in per cents.
     * A range of 100% corresponds to a standard control signal, that varies
     * from 1 [ms] to 2 [ms], When using a servo that supports a double range,
     * from 0.5 [ms] to 2.5 [ms], you can select a range of 200%.
     * Be aware that using a range higher than what is supported by the servo
     * is likely to damage the servo.
     * 
     * @param newval : an integer corresponding to the range of use of the servo, specified in per cents
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_range($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("range",$rest_val);
    }

    /**
     * Returns the duration in microseconds of a neutral pulse for the servo.
     * 
     * @return an integer corresponding to the duration in microseconds of a neutral pulse for the servo
     * 
     * On failure, throws an exception or returns Y_NEUTRAL_INVALID.
     */
    public function get_neutral()
    {   $json_val = $this->_getAttr("neutral");
        return (is_null($json_val) ? Y_NEUTRAL_INVALID : intval($json_val));
    }

    /**
     * Changes the duration of the pulse corresponding to the neutral position of the servo.
     * The duration is specified in microseconds, and the standard value is 1500 [us].
     * This setting makes it possible to shift the range of use of the servo.
     * Be aware that using a range higher than what is supported by the servo is
     * likely to damage the servo.
     * 
     * @param newval : an integer corresponding to the duration of the pulse corresponding to the neutral
     * position of the servo
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_neutral($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("neutral",$rest_val);
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
     * Performs a smooth move at constant speed toward a given position.
     * 
     * @param target      : new position at the end of the move
     * @param ms_duration : total duration of the move, in milliseconds
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function move($int_target,$int_ms_duration)
    {
        $rest_val = strval($int_target).":".strval($int_ms_duration);
        return $this->_setAttr("move",$rest_val);
    }

    public function logicalName()
    { return get_logicalName(); }

    public function setLogicalName($newval)
    { return set_logicalName($newval); }

    public function advertisedValue()
    { return get_advertisedValue(); }

    public function position()
    { return get_position(); }

    public function setPosition($newval)
    { return set_position($newval); }

    public function range()
    { return get_range(); }

    public function setRange($newval)
    { return set_range($newval); }

    public function neutral()
    { return get_neutral(); }

    public function setNeutral($newval)
    { return set_neutral($newval); }

    public function setMove($newval)
    { return set_move($newval); }

    /**
     * Continues the enumeration of servos started using yFirstServo().
     * 
     * @return a pointer to a YServo object, corresponding to
     *         a servo currently online, or a null pointer
     *         if there are no more servos to enumerate.
     */
    public function nextServo()
    {   $next_hwid = YAPI::getNextHardwareId($this->_className, $this->_func);
        if($next_hwid == null) return null;
        return yFindServo($next_hwid);
    }

    /**
     * Retrieves a servo for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     * 
     * This function does not require that the servo is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YServo.isOnline() to test if the servo is
     * indeed online at a given time. In case of ambiguity when looking for
     * a servo by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     * 
     * @param func : a string that uniquely characterizes the servo
     * 
     * @return a YServo object allowing you to drive the servo.
     */
    public static function FindServo($str_func)
    {   $obj_func = YAPI::getFunction('Servo', $str_func);
        if($obj_func) return $obj_func;
        return new YServo($str_func);
    }

    /**
     * Starts the enumeration of servos currently accessible.
     * Use the method YServo.nextServo() to iterate on
     * next servos.
     * 
     * @return a pointer to a YServo object, corresponding to
     *         the first servo currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstServo()
    {   $next_hwid = YAPI::getFirstHardwareId('Servo');
        if($next_hwid == null) return null;
        return self::FindServo($next_hwid);
    }

    //--- (end of YServo implementation)

    function __construct($str_func)
    {
        //--- (YServo constructor)
        parent::__construct('Servo', $str_func);
        //--- (end of YServo constructor)
    }
};

//--- (Servo functions)

/**
 * Retrieves a servo for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 * 
 * This function does not require that the servo is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YServo.isOnline() to test if the servo is
 * indeed online at a given time. In case of ambiguity when looking for
 * a servo by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 * 
 * @param func : a string that uniquely characterizes the servo
 * 
 * @return a YServo object allowing you to drive the servo.
 */
function yFindServo($str_func)
{
    return YServo::FindServo($str_func);
}

/**
 * Starts the enumeration of servos currently accessible.
 * Use the method YServo.nextServo() to iterate on
 * next servos.
 * 
 * @return a pointer to a YServo object, corresponding to
 *         the first servo currently online, or a null pointer
 *         if there are none.
 */
function yFirstServo()
{
    return YServo::FirstServo();
}

//--- (end of Servo functions)
?>