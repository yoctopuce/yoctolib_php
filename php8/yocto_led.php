<?php
/*********************************************************************
 *
 *  $Id: svn_id $
 *
 *  Implements YLed, the high-level API for Led functions
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

//--- (YLed return codes)
//--- (end of YLed return codes)
//--- (YLed definitions)
if (!defined('Y_POWER_OFF')) {
    define('Y_POWER_OFF', 0);
}
if (!defined('Y_POWER_ON')) {
    define('Y_POWER_ON', 1);
}
if (!defined('Y_POWER_INVALID')) {
    define('Y_POWER_INVALID', -1);
}
if (!defined('Y_BLINKING_STILL')) {
    define('Y_BLINKING_STILL', 0);
}
if (!defined('Y_BLINKING_RELAX')) {
    define('Y_BLINKING_RELAX', 1);
}
if (!defined('Y_BLINKING_AWARE')) {
    define('Y_BLINKING_AWARE', 2);
}
if (!defined('Y_BLINKING_RUN')) {
    define('Y_BLINKING_RUN', 3);
}
if (!defined('Y_BLINKING_CALL')) {
    define('Y_BLINKING_CALL', 4);
}
if (!defined('Y_BLINKING_PANIC')) {
    define('Y_BLINKING_PANIC', 5);
}
if (!defined('Y_BLINKING_INVALID')) {
    define('Y_BLINKING_INVALID', -1);
}
if (!defined('Y_LUMINOSITY_INVALID')) {
    define('Y_LUMINOSITY_INVALID', YAPI_INVALID_UINT);
}
//--- (end of YLed definitions)
    #--- (YLed yapiwrapper)

   #--- (end of YLed yapiwrapper)

//--- (YLed declaration)
//vvvv YLed.php

/**
 * YLed Class: monochrome LED control interface, available for instance in the Yocto-Buzzer, the
 * YoctoBox-Short-Thin-Black-Prox, the YoctoBox-Short-Thin-Transp or the YoctoBox-Short-Thin-Transp-Prox
 *
 * The YLed class allows you to drive a monocolor LED.
 * You can not only to drive the intensity of the LED, but also to
 * have it blink at various preset frequencies.
 */
class YLed extends YFunction
{
    const POWER_OFF = 0;
    const POWER_ON = 1;
    const POWER_INVALID = -1;
    const LUMINOSITY_INVALID = YAPI::INVALID_UINT;
    const BLINKING_STILL = 0;
    const BLINKING_RELAX = 1;
    const BLINKING_AWARE = 2;
    const BLINKING_RUN = 3;
    const BLINKING_CALL = 4;
    const BLINKING_PANIC = 5;
    const BLINKING_INVALID = -1;
    //--- (end of YLed declaration)

    //--- (YLed attributes)
    protected int $_power = self::POWER_INVALID;          // OnOff
    protected int $_luminosity = self::LUMINOSITY_INVALID;     // Percent
    protected int $_blinking = self::BLINKING_INVALID;       // Blink

    //--- (end of YLed attributes)

    function __construct(string $str_func)
    {
        //--- (YLed constructor)
        parent::__construct($str_func);
        $this->_className = 'Led';

        //--- (end of YLed constructor)
    }

    //--- (YLed implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'power':
            $this->_power = intval($val);
            return 1;
        case 'luminosity':
            $this->_luminosity = intval($val);
            return 1;
        case 'blinking':
            $this->_blinking = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the current LED state.
     *
     * @return int  either YLed::POWER_OFF or YLed::POWER_ON, according to the current LED state
     *
     * On failure, throws an exception or returns YLed::POWER_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_power(): int
    {
        // $res                    is a enumONOFF;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::POWER_INVALID;
            }
        }
        $res = $this->_power;
        return $res;
    }

    /**
     * Changes the state of the LED.
     *
     * @param int $newval : either YLed::POWER_OFF or YLed::POWER_ON, according to the state of the LED
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_power(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("power", $rest_val);
    }

    /**
     * Returns the current LED intensity (in per cent).
     *
     * @return int  an integer corresponding to the current LED intensity (in per cent)
     *
     * On failure, throws an exception or returns YLed::LUMINOSITY_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_luminosity(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::LUMINOSITY_INVALID;
            }
        }
        $res = $this->_luminosity;
        return $res;
    }

    /**
     * Changes the current LED intensity (in per cent). Remember to call the
     * saveToFlash() method of the module if the modification must be kept.
     *
     * @param int $newval : an integer corresponding to the current LED intensity (in per cent)
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_luminosity(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("luminosity", $rest_val);
    }

    /**
     * Returns the current LED signaling mode.
     *
     * @return int  a value among YLed::BLINKING_STILL, YLed::BLINKING_RELAX, YLed::BLINKING_AWARE,
     * YLed::BLINKING_RUN, YLed::BLINKING_CALL and YLed::BLINKING_PANIC corresponding to the current LED signaling mode
     *
     * On failure, throws an exception or returns YLed::BLINKING_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_blinking(): int
    {
        // $res                    is a enumBLINK;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::BLINKING_INVALID;
            }
        }
        $res = $this->_blinking;
        return $res;
    }

    /**
     * Changes the current LED signaling mode.
     *
     * @param int $newval : a value among YLed::BLINKING_STILL, YLed::BLINKING_RELAX, YLed::BLINKING_AWARE,
     * YLed::BLINKING_RUN, YLed::BLINKING_CALL and YLed::BLINKING_PANIC corresponding to the current LED signaling mode
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_blinking(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("blinking", $rest_val);
    }

    /**
     * Retrieves a monochrome LED for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the monochrome LED is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the monochrome LED is
     * indeed online at a given time. In case of ambiguity when looking for
     * a monochrome LED by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the monochrome LED, for instance
     *         YBUZZER2.led1.
     *
     * @return YLed  a YLed object allowing you to drive the monochrome LED.
     */
    public static function FindLed(string $func): YLed
    {
        // $obj                    is a YLed;
        $obj = YFunction::_FindFromCache('Led', $func);
        if ($obj == null) {
            $obj = new YLed($func);
            YFunction::_AddToCache('Led', $func, $obj);
        }
        return $obj;
    }

    /**
     * @throws YAPI_Exception
     */
    public function power(): int
{
    return $this->get_power();
}

    /**
     * @throws YAPI_Exception
     */
    public function setPower(int $newval): int
{
    return $this->set_power($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function luminosity(): int
{
    return $this->get_luminosity();
}

    /**
     * @throws YAPI_Exception
     */
    public function setLuminosity(int $newval): int
{
    return $this->set_luminosity($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function blinking(): int
{
    return $this->get_blinking();
}

    /**
     * @throws YAPI_Exception
     */
    public function setBlinking(int $newval): int
{
    return $this->set_blinking($newval);
}

    /**
     * Continues the enumeration of monochrome LEDs started using yFirstLed().
     * Caution: You can't make any assumption about the returned monochrome LEDs order.
     * If you want to find a specific a monochrome LED, use Led.findLed()
     * and a hardwareID or a logical name.
     *
     * @return ?YLed  a pointer to a YLed object, corresponding to
     *         a monochrome LED currently online, or a null pointer
     *         if there are no more monochrome LEDs to enumerate.
     */
    public function nextLed(): ?YLed
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindLed($next_hwid);
    }

    /**
     * Starts the enumeration of monochrome LEDs currently accessible.
     * Use the method YLed::nextLed() to iterate on
     * next monochrome LEDs.
     *
     * @return ?YLed  a pointer to a YLed object, corresponding to
     *         the first monochrome LED currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstLed(): ?YLed
    {
        $next_hwid = YAPI::getFirstHardwareId('Led');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindLed($next_hwid);
    }

    //--- (end of YLed implementation)

}
//^^^^ YLed.php

//--- (YLed functions)

/**
 * Retrieves a monochrome LED for a given identifier.
 * The identifier can be specified using several formats:
 *
 * - FunctionLogicalName
 * - ModuleSerialNumber.FunctionIdentifier
 * - ModuleSerialNumber.FunctionLogicalName
 * - ModuleLogicalName.FunctionIdentifier
 * - ModuleLogicalName.FunctionLogicalName
 *
 *
 * This function does not require that the monochrome LED is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method isOnline() to test if the monochrome LED is
 * indeed online at a given time. In case of ambiguity when looking for
 * a monochrome LED by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 *
 * If a call to this object's is_online() method returns FALSE although
 * you are certain that the matching device is plugged, make sure that you did
 * call registerHub() at application initialization time.
 *
 * @param string $func : a string that uniquely characterizes the monochrome LED, for instance
 *         YBUZZER2.led1.
 *
 * @return YLed  a YLed object allowing you to drive the monochrome LED.
 */
function yFindLed(string $func): YLed
{
    return YLed::FindLed($func);
}

/**
 * Starts the enumeration of monochrome LEDs currently accessible.
 * Use the method YLed::nextLed() to iterate on
 * next monochrome LEDs.
 *
 * @return ?YLed  a pointer to a YLed object, corresponding to
 *         the first monochrome LED currently online, or a null pointer
 *         if there are none.
 */
function yFirstLed(): ?YLed
{
    return YLed::FirstLed();
}

//--- (end of YLed functions)

