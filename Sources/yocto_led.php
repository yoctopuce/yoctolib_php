<?php
/*********************************************************************
 *
 * $Id: yocto_led.php 12324 2013-08-13 15:10:31Z mvuilleu $
 *
 * Implements yFindLed(), the high-level API for Led functions
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
//--- (YLed definitions)
if(!defined('Y_POWER_OFF')) define('Y_POWER_OFF', 0);
if(!defined('Y_POWER_ON')) define('Y_POWER_ON', 1);
if(!defined('Y_POWER_INVALID')) define('Y_POWER_INVALID', -1);
if(!defined('Y_BLINKING_STILL')) define('Y_BLINKING_STILL', 0);
if(!defined('Y_BLINKING_RELAX')) define('Y_BLINKING_RELAX', 1);
if(!defined('Y_BLINKING_AWARE')) define('Y_BLINKING_AWARE', 2);
if(!defined('Y_BLINKING_RUN')) define('Y_BLINKING_RUN', 3);
if(!defined('Y_BLINKING_CALL')) define('Y_BLINKING_CALL', 4);
if(!defined('Y_BLINKING_PANIC')) define('Y_BLINKING_PANIC', 5);
if(!defined('Y_BLINKING_INVALID')) define('Y_BLINKING_INVALID', -1);
if(!defined('Y_LOGICALNAME_INVALID')) define('Y_LOGICALNAME_INVALID', Y_INVALID_STRING);
if(!defined('Y_ADVERTISEDVALUE_INVALID')) define('Y_ADVERTISEDVALUE_INVALID', Y_INVALID_STRING);
if(!defined('Y_LUMINOSITY_INVALID')) define('Y_LUMINOSITY_INVALID', Y_INVALID_UNSIGNED);
//--- (end of YLed definitions)

/**
 * YLed Class: Led function interface
 * 
 * Yoctopuce application programming interface
 * allows you not only to drive the intensity of the led, but also to
 * have it blink at various preset frequencies.
 */
class YLed extends YFunction
{
    //--- (YLed implementation)
    const LOGICALNAME_INVALID = Y_INVALID_STRING;
    const ADVERTISEDVALUE_INVALID = Y_INVALID_STRING;
    const POWER_OFF = 0;
    const POWER_ON = 1;
    const POWER_INVALID = -1;
    const LUMINOSITY_INVALID = Y_INVALID_UNSIGNED;
    const BLINKING_STILL = 0;
    const BLINKING_RELAX = 1;
    const BLINKING_AWARE = 2;
    const BLINKING_RUN = 3;
    const BLINKING_CALL = 4;
    const BLINKING_PANIC = 5;
    const BLINKING_INVALID = -1;

    /**
     * Returns the logical name of the led.
     * 
     * @return a string corresponding to the logical name of the led
     * 
     * On failure, throws an exception or returns Y_LOGICALNAME_INVALID.
     */
    public function get_logicalName()
    {   $json_val = $this->_getAttr("logicalName");
        return (is_null($json_val) ? Y_LOGICALNAME_INVALID : $json_val);
    }

    /**
     * Changes the logical name of the led. You can use yCheckLogicalName()
     * prior to this call to make sure that your parameter is valid.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     * 
     * @param newval : a string corresponding to the logical name of the led
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
     * Returns the current value of the led (no more than 6 characters).
     * 
     * @return a string corresponding to the current value of the led (no more than 6 characters)
     * 
     * On failure, throws an exception or returns Y_ADVERTISEDVALUE_INVALID.
     */
    public function get_advertisedValue()
    {   $json_val = $this->_getAttr("advertisedValue");
        return (is_null($json_val) ? Y_ADVERTISEDVALUE_INVALID : $json_val);
    }

    /**
     * Returns the current led state.
     * 
     * @return either Y_POWER_OFF or Y_POWER_ON, according to the current led state
     * 
     * On failure, throws an exception or returns Y_POWER_INVALID.
     */
    public function get_power()
    {   $json_val = $this->_getAttr("power");
        return (is_null($json_val) ? Y_POWER_INVALID : intval($json_val));
    }

    /**
     * Changes the state of the led.
     * 
     * @param newval : either Y_POWER_OFF or Y_POWER_ON, according to the state of the led
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_power($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("power",$rest_val);
    }

    /**
     * Returns the current led intensity (in per cent).
     * 
     * @return an integer corresponding to the current led intensity (in per cent)
     * 
     * On failure, throws an exception or returns Y_LUMINOSITY_INVALID.
     */
    public function get_luminosity()
    {   $json_val = $this->_getAttr("luminosity");
        return (is_null($json_val) ? Y_LUMINOSITY_INVALID : intval($json_val));
    }

    /**
     * Changes the current led intensity (in per cent).
     * 
     * @param newval : an integer corresponding to the current led intensity (in per cent)
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_luminosity($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("luminosity",$rest_val);
    }

    /**
     * Returns the current led signaling mode.
     * 
     * @return a value among Y_BLINKING_STILL, Y_BLINKING_RELAX, Y_BLINKING_AWARE, Y_BLINKING_RUN,
     * Y_BLINKING_CALL and Y_BLINKING_PANIC corresponding to the current led signaling mode
     * 
     * On failure, throws an exception or returns Y_BLINKING_INVALID.
     */
    public function get_blinking()
    {   $json_val = $this->_getAttr("blinking");
        return (is_null($json_val) ? Y_BLINKING_INVALID : intval($json_val));
    }

    /**
     * Changes the current led signaling mode.
     * 
     * @param newval : a value among Y_BLINKING_STILL, Y_BLINKING_RELAX, Y_BLINKING_AWARE, Y_BLINKING_RUN,
     * Y_BLINKING_CALL and Y_BLINKING_PANIC corresponding to the current led signaling mode
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_blinking($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("blinking",$rest_val);
    }

    public function logicalName()
    { return get_logicalName(); }

    public function setLogicalName($newval)
    { return set_logicalName($newval); }

    public function advertisedValue()
    { return get_advertisedValue(); }

    public function power()
    { return get_power(); }

    public function setPower($newval)
    { return set_power($newval); }

    public function luminosity()
    { return get_luminosity(); }

    public function setLuminosity($newval)
    { return set_luminosity($newval); }

    public function blinking()
    { return get_blinking(); }

    public function setBlinking($newval)
    { return set_blinking($newval); }

    /**
     * Continues the enumeration of leds started using yFirstLed().
     * 
     * @return a pointer to a YLed object, corresponding to
     *         a led currently online, or a null pointer
     *         if there are no more leds to enumerate.
     */
    public function nextLed()
    {   $next_hwid = YAPI::getNextHardwareId($this->_className, $this->_func);
        if($next_hwid == null) return null;
        return yFindLed($next_hwid);
    }

    /**
     * Retrieves a led for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     * 
     * This function does not require that the led is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YLed.isOnline() to test if the led is
     * indeed online at a given time. In case of ambiguity when looking for
     * a led by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     * 
     * @param func : a string that uniquely characterizes the led
     * 
     * @return a YLed object allowing you to drive the led.
     */
    public static function FindLed($str_func)
    {   $obj_func = YAPI::getFunction('Led', $str_func);
        if($obj_func) return $obj_func;
        return new YLed($str_func);
    }

    /**
     * Starts the enumeration of leds currently accessible.
     * Use the method YLed.nextLed() to iterate on
     * next leds.
     * 
     * @return a pointer to a YLed object, corresponding to
     *         the first led currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstLed()
    {   $next_hwid = YAPI::getFirstHardwareId('Led');
        if($next_hwid == null) return null;
        return self::FindLed($next_hwid);
    }

    //--- (end of YLed implementation)

    function __construct($str_func)
    {
        //--- (YLed constructor)
        parent::__construct('Led', $str_func);
        //--- (end of YLed constructor)
    }
};

//--- (Led functions)

/**
 * Retrieves a led for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 * 
 * This function does not require that the led is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YLed.isOnline() to test if the led is
 * indeed online at a given time. In case of ambiguity when looking for
 * a led by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 * 
 * @param func : a string that uniquely characterizes the led
 * 
 * @return a YLed object allowing you to drive the led.
 */
function yFindLed($str_func)
{
    return YLed::FindLed($str_func);
}

/**
 * Starts the enumeration of leds currently accessible.
 * Use the method YLed.nextLed() to iterate on
 * next leds.
 * 
 * @return a pointer to a YLed object, corresponding to
 *         the first led currently online, or a null pointer
 *         if there are none.
 */
function yFirstLed()
{
    return YLed::FirstLed();
}

//--- (end of Led functions)
?>