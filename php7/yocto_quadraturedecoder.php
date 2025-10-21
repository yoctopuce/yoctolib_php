<?php
/*********************************************************************
 *
 *  $Id: svn_id $
 *
 *  Implements YQuadratureDecoder, the high-level API for QuadratureDecoder functions
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

//--- (YQuadratureDecoder return codes)
//--- (end of YQuadratureDecoder return codes)
//--- (YQuadratureDecoder definitions)
if (!defined('Y_DECODING_OFF')) {
    define('Y_DECODING_OFF', 0);
}
if (!defined('Y_DECODING_ON')) {
    define('Y_DECODING_ON', 1);
}
if (!defined('Y_DECODING_INVALID')) {
    define('Y_DECODING_INVALID', -1);
}
if (!defined('Y_SPEED_INVALID')) {
    define('Y_SPEED_INVALID', YAPI_INVALID_DOUBLE);
}
if (!defined('Y_EDGESPERCYCLE_INVALID')) {
    define('Y_EDGESPERCYCLE_INVALID', YAPI_INVALID_UINT);
}
//--- (end of YQuadratureDecoder definitions)
    #--- (YQuadratureDecoder yapiwrapper)

   #--- (end of YQuadratureDecoder yapiwrapper)

//--- (YQuadratureDecoder declaration)
//vvvv YQuadratureDecoder.php

/**
 * YQuadratureDecoder Class: quadrature decoder control interface, available for instance in the
 * Yocto-MaxiKnob or the Yocto-PWM-Rx
 *
 * The YQuadratureDecoder class allows you to read and configure Yoctopuce quadrature decoders.
 * It inherits from YSensor class the core functions to read measurements,
 * to register callback functions, and to access the autonomous datalogger.
 */
class YQuadratureDecoder extends YSensor
{
    const SPEED_INVALID = YAPI::INVALID_DOUBLE;
    const DECODING_OFF = 0;
    const DECODING_ON = 1;
    const DECODING_INVALID = -1;
    const EDGESPERCYCLE_INVALID = YAPI::INVALID_UINT;
    //--- (end of YQuadratureDecoder declaration)

    //--- (YQuadratureDecoder attributes)
    protected $_speed = self::SPEED_INVALID;          // MeasureVal
    protected $_decoding = self::DECODING_INVALID;       // OnOff
    protected $_edgesPerCycle = self::EDGESPERCYCLE_INVALID;  // UInt31

    //--- (end of YQuadratureDecoder attributes)

    function __construct(string $str_func)
    {
        //--- (YQuadratureDecoder constructor)
        parent::__construct($str_func);
        $this->_className = 'QuadratureDecoder';

        //--- (end of YQuadratureDecoder constructor)
    }

    //--- (YQuadratureDecoder implementation)

    function _parseAttr(string $name,  $val): int
    {
        switch ($name) {
        case 'speed':
            $this->_speed = round($val / 65.536) / 1000.0;
            return 1;
        case 'decoding':
            $this->_decoding = intval($val);
            return 1;
        case 'edgesPerCycle':
            $this->_edgesPerCycle = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Changes the current expected position of the quadrature decoder.
     * Invoking this function implicitly activates the quadrature decoder.
     *
     * @param float $newval : a floating point number corresponding to the current expected position of
     * the quadrature decoder
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_currentValue(float $newval): int
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("currentValue", $rest_val);
    }

    /**
     * Returns the cycle frequency, in Hz.
     *
     * @return float  a floating point number corresponding to the cycle frequency, in Hz
     *
     * On failure, throws an exception or returns YQuadratureDecoder::SPEED_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_speed(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::SPEED_INVALID;
            }
        }
        $res = $this->_speed;
        return $res;
    }

    /**
     * Returns the current activation state of the quadrature decoder.
     *
     * @return int  either YQuadratureDecoder::DECODING_OFF or YQuadratureDecoder::DECODING_ON, according to
     * the current activation state of the quadrature decoder
     *
     * On failure, throws an exception or returns YQuadratureDecoder::DECODING_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_decoding(): int
    {
        // $res                    is a enumONOFF;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::DECODING_INVALID;
            }
        }
        $res = $this->_decoding;
        return $res;
    }

    /**
     * Changes the activation state of the quadrature decoder.
     * Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     *
     * @param int $newval : either YQuadratureDecoder::DECODING_OFF or YQuadratureDecoder::DECODING_ON,
     * according to the activation state of the quadrature decoder
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_decoding(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("decoding", $rest_val);
    }

    /**
     * Returns the edge count per full cycle configuration setting.
     *
     * @return int  an integer corresponding to the edge count per full cycle configuration setting
     *
     * On failure, throws an exception or returns YQuadratureDecoder::EDGESPERCYCLE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_edgesPerCycle(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::EDGESPERCYCLE_INVALID;
            }
        }
        $res = $this->_edgesPerCycle;
        return $res;
    }

    /**
     * Changes the edge count per full cycle configuration setting.
     * Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     *
     * @param int $newval : an integer corresponding to the edge count per full cycle configuration setting
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_edgesPerCycle(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("edgesPerCycle", $rest_val);
    }

    /**
     * Retrieves a quadrature decoder for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the quadrature decoder is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the quadrature decoder is
     * indeed online at a given time. In case of ambiguity when looking for
     * a quadrature decoder by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the quadrature decoder, for instance
     *         YMXBTN01.quadratureDecoder1.
     *
     * @return YQuadratureDecoder  a YQuadratureDecoder object allowing you to drive the quadrature decoder.
     */
    public static function FindQuadratureDecoder(string $func): YQuadratureDecoder
    {
        // $obj                    is a YQuadratureDecoder;
        $obj = YFunction::_FindFromCache('QuadratureDecoder', $func);
        if ($obj == null) {
            $obj = new YQuadratureDecoder($func);
            YFunction::_AddToCache('QuadratureDecoder', $func, $obj);
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
    public function speed(): float
{
    return $this->get_speed();
}

    /**
     * @throws YAPI_Exception
     */
    public function decoding(): int
{
    return $this->get_decoding();
}

    /**
     * @throws YAPI_Exception
     */
    public function setDecoding(int $newval): int
{
    return $this->set_decoding($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function edgesPerCycle(): int
{
    return $this->get_edgesPerCycle();
}

    /**
     * @throws YAPI_Exception
     */
    public function setEdgesPerCycle(int $newval): int
{
    return $this->set_edgesPerCycle($newval);
}

    /**
     * Continues the enumeration of quadrature decoders started using yFirstQuadratureDecoder().
     * Caution: You can't make any assumption about the returned quadrature decoders order.
     * If you want to find a specific a quadrature decoder, use QuadratureDecoder.findQuadratureDecoder()
     * and a hardwareID or a logical name.
     *
     * @return ?YQuadratureDecoder  a pointer to a YQuadratureDecoder object, corresponding to
     *         a quadrature decoder currently online, or a null pointer
     *         if there are no more quadrature decoders to enumerate.
     */
    public function nextQuadratureDecoder(): ?YQuadratureDecoder
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindQuadratureDecoder($next_hwid);
    }

    /**
     * Starts the enumeration of quadrature decoders currently accessible.
     * Use the method YQuadratureDecoder::nextQuadratureDecoder() to iterate on
     * next quadrature decoders.
     *
     * @return ?YQuadratureDecoder  a pointer to a YQuadratureDecoder object, corresponding to
     *         the first quadrature decoder currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstQuadratureDecoder(): ?YQuadratureDecoder
    {
        $next_hwid = YAPI::getFirstHardwareId('QuadratureDecoder');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindQuadratureDecoder($next_hwid);
    }

    //--- (end of YQuadratureDecoder implementation)

}
//^^^^ YQuadratureDecoder.php

//--- (YQuadratureDecoder functions)

/**
 * Retrieves a quadrature decoder for a given identifier.
 * The identifier can be specified using several formats:
 *
 * - FunctionLogicalName
 * - ModuleSerialNumber.FunctionIdentifier
 * - ModuleSerialNumber.FunctionLogicalName
 * - ModuleLogicalName.FunctionIdentifier
 * - ModuleLogicalName.FunctionLogicalName
 *
 *
 * This function does not require that the quadrature decoder is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method isOnline() to test if the quadrature decoder is
 * indeed online at a given time. In case of ambiguity when looking for
 * a quadrature decoder by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 *
 * If a call to this object's is_online() method returns FALSE although
 * you are certain that the matching device is plugged, make sure that you did
 * call registerHub() at application initialization time.
 *
 * @param string $func : a string that uniquely characterizes the quadrature decoder, for instance
 *         YMXBTN01.quadratureDecoder1.
 *
 * @return YQuadratureDecoder  a YQuadratureDecoder object allowing you to drive the quadrature decoder.
 */
function yFindQuadratureDecoder(string $func): YQuadratureDecoder
{
    return YQuadratureDecoder::FindQuadratureDecoder($func);
}

/**
 * Starts the enumeration of quadrature decoders currently accessible.
 * Use the method YQuadratureDecoder::nextQuadratureDecoder() to iterate on
 * next quadrature decoders.
 *
 * @return ?YQuadratureDecoder  a pointer to a YQuadratureDecoder object, corresponding to
 *         the first quadrature decoder currently online, or a null pointer
 *         if there are none.
 */
function yFirstQuadratureDecoder(): ?YQuadratureDecoder
{
    return YQuadratureDecoder::FirstQuadratureDecoder();
}

//--- (end of YQuadratureDecoder functions)

