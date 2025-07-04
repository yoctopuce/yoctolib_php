<?php
/*********************************************************************
 *
 *  $Id: svn_id $
 *
 *  Implements YColorLed, the high-level API for ColorLed functions
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

//--- (YColorLed return codes)
//--- (end of YColorLed return codes)
//--- (YColorLed definitions)
if (!defined('Y_RGBCOLOR_INVALID')) {
    define('Y_RGBCOLOR_INVALID', YAPI_INVALID_UINT);
}
if (!defined('Y_HSLCOLOR_INVALID')) {
    define('Y_HSLCOLOR_INVALID', YAPI_INVALID_UINT);
}
if(!defined('Y_RGBMOVE_INVALID'))            define('Y_RGBMOVE_INVALID',           null);
if(!defined('Y_HSLMOVE_INVALID'))            define('Y_HSLMOVE_INVALID',           null);
if (!defined('Y_RGBCOLORATPOWERON_INVALID')) {
    define('Y_RGBCOLORATPOWERON_INVALID', YAPI_INVALID_UINT);
}
if (!defined('Y_BLINKSEQSIZE_INVALID')) {
    define('Y_BLINKSEQSIZE_INVALID', YAPI_INVALID_UINT);
}
if (!defined('Y_BLINKSEQMAXSIZE_INVALID')) {
    define('Y_BLINKSEQMAXSIZE_INVALID', YAPI_INVALID_UINT);
}
if (!defined('Y_BLINKSEQSIGNATURE_INVALID')) {
    define('Y_BLINKSEQSIGNATURE_INVALID', YAPI_INVALID_UINT);
}
if (!defined('Y_COMMAND_INVALID')) {
    define('Y_COMMAND_INVALID', YAPI_INVALID_STRING);
}
//--- (end of YColorLed definitions)
    #--- (YColorLed yapiwrapper)

   #--- (end of YColorLed yapiwrapper)

//--- (YColorLed declaration)
//vvvv YColorLed.php

/**
 * YColorLed Class: RGB LED control interface, available for instance in the Yocto-Color-V2, the
 * Yocto-MaxiBuzzer or the Yocto-PowerColor
 *
 * The ColorLed class allows you to drive a color LED.
 * The color can be specified using RGB coordinates as well as HSL coordinates.
 * The module performs all conversions form RGB to HSL automatically. It is then
 * self-evident to turn on a LED with a given hue and to progressively vary its
 * saturation or lightness. If needed, you can find more information on the
 * difference between RGB and HSL in the section following this one.
 */
class YColorLed extends YFunction
{
    const RGBCOLOR_INVALID = YAPI::INVALID_UINT;
    const HSLCOLOR_INVALID = YAPI::INVALID_UINT;
    const RGBMOVE_INVALID = null;
    const HSLMOVE_INVALID = null;
    const RGBCOLORATPOWERON_INVALID = YAPI::INVALID_UINT;
    const BLINKSEQSIZE_INVALID = YAPI::INVALID_UINT;
    const BLINKSEQMAXSIZE_INVALID = YAPI::INVALID_UINT;
    const BLINKSEQSIGNATURE_INVALID = YAPI::INVALID_UINT;
    const COMMAND_INVALID = YAPI::INVALID_STRING;
    //--- (end of YColorLed declaration)

    //--- (YColorLed attributes)
    protected $_rgbColor = self::RGBCOLOR_INVALID;       // U24Color
    protected $_hslColor = self::HSLCOLOR_INVALID;       // U24Color
    protected  $_rgbMove = self::RGBMOVE_INVALID;        // Move
    protected  $_hslMove = self::HSLMOVE_INVALID;        // Move
    protected $_rgbColorAtPowerOn = self::RGBCOLORATPOWERON_INVALID; // U24Color
    protected $_blinkSeqSize = self::BLINKSEQSIZE_INVALID;   // UInt31
    protected $_blinkSeqMaxSize = self::BLINKSEQMAXSIZE_INVALID; // UInt31
    protected $_blinkSeqSignature = self::BLINKSEQSIGNATURE_INVALID; // UInt31
    protected $_command = self::COMMAND_INVALID;        // Text

    //--- (end of YColorLed attributes)

    function __construct(string $str_func)
    {
        //--- (YColorLed constructor)
        parent::__construct($str_func);
        $this->_className = 'ColorLed';

        //--- (end of YColorLed constructor)
    }

    //--- (YColorLed implementation)

    function _parseAttr(string $name,  $val): int
    {
        switch ($name) {
        case 'rgbColor':
            $this->_rgbColor = intval($val);
            return 1;
        case 'hslColor':
            $this->_hslColor = intval($val);
            return 1;
        case 'rgbMove':
            $this->_rgbMove = $val;
            return 1;
        case 'hslMove':
            $this->_hslMove = $val;
            return 1;
        case 'rgbColorAtPowerOn':
            $this->_rgbColorAtPowerOn = intval($val);
            return 1;
        case 'blinkSeqSize':
            $this->_blinkSeqSize = intval($val);
            return 1;
        case 'blinkSeqMaxSize':
            $this->_blinkSeqMaxSize = intval($val);
            return 1;
        case 'blinkSeqSignature':
            $this->_blinkSeqSignature = intval($val);
            return 1;
        case 'command':
            $this->_command = $val;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the current RGB color of the LED.
     *
     * @return int  an integer corresponding to the current RGB color of the LED
     *
     * On failure, throws an exception or returns YColorLed::RGBCOLOR_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_rgbColor(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::RGBCOLOR_INVALID;
            }
        }
        $res = $this->_rgbColor;
        return $res;
    }

    /**
     * Changes the current color of the LED, using an RGB color. Encoding is done as follows: 0xRRGGBB.
     *
     * @param int $newval : an integer corresponding to the current color of the LED, using an RGB color
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_rgbColor(int $newval): int
    {
        $rest_val = sprintf("0x%06x", $newval);
        return $this->_setAttr("rgbColor", $rest_val);
    }

    /**
     * Returns the current HSL color of the LED.
     *
     * @return int  an integer corresponding to the current HSL color of the LED
     *
     * On failure, throws an exception or returns YColorLed::HSLCOLOR_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_hslColor(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::HSLCOLOR_INVALID;
            }
        }
        $res = $this->_hslColor;
        return $res;
    }

    /**
     * Changes the current color of the LED, using a specific HSL color. Encoding is done as follows: 0xHHSSLL.
     *
     * @param int $newval : an integer corresponding to the current color of the LED, using a specific HSL color
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_hslColor(int $newval): int
    {
        $rest_val = sprintf("0x%06x", $newval);
        return $this->_setAttr("hslColor", $rest_val);
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_rgbMove()
    {
        // $res                    is a YMove;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::RGBMOVE_INVALID;
            }
        }
        $res = $this->_rgbMove;
        return $res;
    }

    /**
     * @throws YAPI_Exception
     */
    public function set_rgbMove( $newval): int
    {
        $rest_val = $newval["target"].':'.$newval["ms"];
        return $this->_setAttr("rgbMove", $rest_val);
    }

    /**
     * Performs a smooth transition in the RGB color space between the current color and a target color.
     *
     * @param int $rgb_target  : desired RGB color at the end of the transition
     * @param int $ms_duration : duration of the transition, in millisecond
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function rgbMove(int $rgb_target,int $ms_duration): int
    {
        $rest_val = $rgb_target.':'.$ms_duration;
        return $this->_setAttr("rgbMove",$rest_val);
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_hslMove()
    {
        // $res                    is a YMove;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::HSLMOVE_INVALID;
            }
        }
        $res = $this->_hslMove;
        return $res;
    }

    /**
     * @throws YAPI_Exception
     */
    public function set_hslMove( $newval): int
    {
        $rest_val = $newval["target"].':'.$newval["ms"];
        return $this->_setAttr("hslMove", $rest_val);
    }

    /**
     * Performs a smooth transition in the HSL color space between the current color and a target color.
     *
     * @param int $hsl_target  : desired HSL color at the end of the transition
     * @param int $ms_duration : duration of the transition, in millisecond
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function hslMove(int $hsl_target,int $ms_duration): int
    {
        $rest_val = $hsl_target.':'.$ms_duration;
        return $this->_setAttr("hslMove",$rest_val);
    }

    /**
     * Returns the configured color to be displayed when the module is turned on.
     *
     * @return int  an integer corresponding to the configured color to be displayed when the module is turned on
     *
     * On failure, throws an exception or returns YColorLed::RGBCOLORATPOWERON_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_rgbColorAtPowerOn(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::RGBCOLORATPOWERON_INVALID;
            }
        }
        $res = $this->_rgbColorAtPowerOn;
        return $res;
    }

    /**
     * Changes the color that the LED displays by default when the module is turned on.
     * Remember to call the saveLedsConfigAtPowerOn() method of the module if the modification must be kept.
     * Note: for the original modules Yocto-Color (version 1) et Yocto-PowerColor, the  saveToFlash()
     * method must be used instead.
     *
     * @param int $newval : an integer corresponding to the color that the LED displays by default when
     * the module is turned on
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_rgbColorAtPowerOn(int $newval): int
    {
        $rest_val = sprintf("0x%06x", $newval);
        return $this->_setAttr("rgbColorAtPowerOn", $rest_val);
    }

    /**
     * Returns the current length of the blinking sequence.
     *
     * @return int  an integer corresponding to the current length of the blinking sequence
     *
     * On failure, throws an exception or returns YColorLed::BLINKSEQSIZE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_blinkSeqSize(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::BLINKSEQSIZE_INVALID;
            }
        }
        $res = $this->_blinkSeqSize;
        return $res;
    }

    /**
     * Returns the maximum length of the blinking sequence.
     *
     * @return int  an integer corresponding to the maximum length of the blinking sequence
     *
     * On failure, throws an exception or returns YColorLed::BLINKSEQMAXSIZE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_blinkSeqMaxSize(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration == 0) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::BLINKSEQMAXSIZE_INVALID;
            }
        }
        $res = $this->_blinkSeqMaxSize;
        return $res;
    }

    /**
     * Returns the blinking sequence signature. Since blinking
     * sequences cannot be read from the device, this can be used
     * to detect if a specific blinking sequence is already
     * programmed.
     *
     * @return int  an integer corresponding to the blinking sequence signature
     *
     * On failure, throws an exception or returns YColorLed::BLINKSEQSIGNATURE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_blinkSeqSignature(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::BLINKSEQSIGNATURE_INVALID;
            }
        }
        $res = $this->_blinkSeqSignature;
        return $res;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_command(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::COMMAND_INVALID;
            }
        }
        $res = $this->_command;
        return $res;
    }

    /**
     * @throws YAPI_Exception
     */
    public function set_command(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("command", $rest_val);
    }

    /**
     * Retrieves an RGB LED for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the RGB LED is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the RGB LED is
     * indeed online at a given time. In case of ambiguity when looking for
     * an RGB LED by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the RGB LED, for instance
     *         YRGBLED2.colorLed1.
     *
     * @return YColorLed  a YColorLed object allowing you to drive the RGB LED.
     */
    public static function FindColorLed(string $func): YColorLed
    {
        // $obj                    is a YColorLed;
        $obj = YFunction::_FindFromCache('ColorLed', $func);
        if ($obj == null) {
            $obj = new YColorLed($func);
            YFunction::_AddToCache('ColorLed', $func, $obj);
        }
        return $obj;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function sendCommand(string $command): int
    {
        return $this->set_command($command);
    }

    /**
     * Add a new transition to the blinking sequence, the move will
     * be performed in the HSL space.
     *
     * @param int $HSLcolor : desired HSL color when the transition is completed
     * @param int $msDelay : duration of the color transition, in milliseconds.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function addHslMoveToBlinkSeq(int $HSLcolor, int $msDelay): int
    {
        return $this->sendCommand(sprintf('H%d,%d',$HSLcolor,$msDelay));
    }

    /**
     * Adds a new transition to the blinking sequence, the move is
     * performed in the RGB space.
     *
     * @param int $RGBcolor : desired RGB color when the transition is completed
     * @param int $msDelay : duration of the color transition, in milliseconds.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function addRgbMoveToBlinkSeq(int $RGBcolor, int $msDelay): int
    {
        return $this->sendCommand(sprintf('R%d,%d',$RGBcolor,$msDelay));
    }

    /**
     * Starts the preprogrammed blinking sequence. The sequence is
     * run in a loop until it is stopped by stopBlinkSeq or an explicit
     * change.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function startBlinkSeq(): int
    {
        return $this->sendCommand('S');
    }

    /**
     * Stops the preprogrammed blinking sequence.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function stopBlinkSeq(): int
    {
        return $this->sendCommand('X');
    }

    /**
     * Resets the preprogrammed blinking sequence.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function resetBlinkSeq(): int
    {
        return $this->sendCommand('Z');
    }

    /**
     * Saves the LEDs power-on configuration.  Warning: this method is not supported by
     * Yocto-Color (version 1) and Yocto-PowerColor modules. For these devices, the saveToFlash()
     * method of the module must be used instead.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function saveLedsConfigAtPowerOn(): int
    {
        return $this->sendCommand('W');
    }

    /**
     * @throws YAPI_Exception
     */
    public function rgbColor(): int
{
    return $this->get_rgbColor();
}

    /**
     * @throws YAPI_Exception
     */
    public function setRgbColor(int $newval): int
{
    return $this->set_rgbColor($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function hslColor(): int
{
    return $this->get_hslColor();
}

    /**
     * @throws YAPI_Exception
     */
    public function setHslColor(int $newval): int
{
    return $this->set_hslColor($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function setRgbMove( $newval): int
{
    return $this->set_rgbMove($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function setHslMove( $newval): int
{
    return $this->set_hslMove($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function rgbColorAtPowerOn(): int
{
    return $this->get_rgbColorAtPowerOn();
}

    /**
     * @throws YAPI_Exception
     */
    public function setRgbColorAtPowerOn(int $newval): int
{
    return $this->set_rgbColorAtPowerOn($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function blinkSeqSize(): int
{
    return $this->get_blinkSeqSize();
}

    /**
     * @throws YAPI_Exception
     */
    public function blinkSeqMaxSize(): int
{
    return $this->get_blinkSeqMaxSize();
}

    /**
     * @throws YAPI_Exception
     */
    public function blinkSeqSignature(): int
{
    return $this->get_blinkSeqSignature();
}

    /**
     * @throws YAPI_Exception
     */
    public function command(): string
{
    return $this->get_command();
}

    /**
     * @throws YAPI_Exception
     */
    public function setCommand(string $newval): int
{
    return $this->set_command($newval);
}

    /**
     * Continues the enumeration of RGB LEDs started using yFirstColorLed().
     * Caution: You can't make any assumption about the returned RGB LEDs order.
     * If you want to find a specific an RGB LED, use ColorLed.findColorLed()
     * and a hardwareID or a logical name.
     *
     * @return ?YColorLed  a pointer to a YColorLed object, corresponding to
     *         an RGB LED currently online, or a null pointer
     *         if there are no more RGB LEDs to enumerate.
     */
    public function nextColorLed(): ?YColorLed
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindColorLed($next_hwid);
    }

    /**
     * Starts the enumeration of RGB LEDs currently accessible.
     * Use the method YColorLed::nextColorLed() to iterate on
     * next RGB LEDs.
     *
     * @return ?YColorLed  a pointer to a YColorLed object, corresponding to
     *         the first RGB LED currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstColorLed(): ?YColorLed
    {
        $next_hwid = YAPI::getFirstHardwareId('ColorLed');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindColorLed($next_hwid);
    }

    //--- (end of YColorLed implementation)

}
//^^^^ YColorLed.php

//--- (YColorLed functions)

/**
 * Retrieves an RGB LED for a given identifier.
 * The identifier can be specified using several formats:
 *
 * - FunctionLogicalName
 * - ModuleSerialNumber.FunctionIdentifier
 * - ModuleSerialNumber.FunctionLogicalName
 * - ModuleLogicalName.FunctionIdentifier
 * - ModuleLogicalName.FunctionLogicalName
 *
 *
 * This function does not require that the RGB LED is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method isOnline() to test if the RGB LED is
 * indeed online at a given time. In case of ambiguity when looking for
 * an RGB LED by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 *
 * If a call to this object's is_online() method returns FALSE although
 * you are certain that the matching device is plugged, make sure that you did
 * call registerHub() at application initialization time.
 *
 * @param string $func : a string that uniquely characterizes the RGB LED, for instance
 *         YRGBLED2.colorLed1.
 *
 * @return YColorLed  a YColorLed object allowing you to drive the RGB LED.
 */
function yFindColorLed(string $func): YColorLed
{
    return YColorLed::FindColorLed($func);
}

/**
 * Starts the enumeration of RGB LEDs currently accessible.
 * Use the method YColorLed::nextColorLed() to iterate on
 * next RGB LEDs.
 *
 * @return ?YColorLed  a pointer to a YColorLed object, corresponding to
 *         the first RGB LED currently online, or a null pointer
 *         if there are none.
 */
function yFirstColorLed(): ?YColorLed
{
    return YColorLed::FirstColorLed();
}

//--- (end of YColorLed functions)

