<?php
/*********************************************************************
 *
 *  $Id: svn_id $
 *
 *  Implements YSpectralChannel, the high-level API for SpectralChannel functions
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

//--- (YSpectralChannel return codes)
//--- (end of YSpectralChannel return codes)
//--- (YSpectralChannel definitions)
if (!defined('Y_RAWCOUNT_INVALID')) {
    define('Y_RAWCOUNT_INVALID', YAPI_INVALID_INT);
}
if (!defined('Y_CHANNELNAME_INVALID')) {
    define('Y_CHANNELNAME_INVALID', YAPI_INVALID_STRING);
}
if (!defined('Y_PEAKWAVELENGTH_INVALID')) {
    define('Y_PEAKWAVELENGTH_INVALID', YAPI_INVALID_INT);
}
//--- (end of YSpectralChannel definitions)
    #--- (YSpectralChannel yapiwrapper)

   #--- (end of YSpectralChannel yapiwrapper)

//--- (YSpectralChannel declaration)
//vvvv YSpectralChannel.php

/**
 * YSpectralChannel Class: spectral analysis channel control interface
 *
 * The YSpectralChannel class allows you to read and configure Yoctopuce spectral analysis channels.
 * It inherits from YSensor class the core functions to read measures,
 * to register callback functions, and to access the autonomous datalogger.
 */
class YSpectralChannel extends YSensor
{
    const RAWCOUNT_INVALID = YAPI::INVALID_INT;
    const CHANNELNAME_INVALID = YAPI::INVALID_STRING;
    const PEAKWAVELENGTH_INVALID = YAPI::INVALID_INT;
    //--- (end of YSpectralChannel declaration)

    //--- (YSpectralChannel attributes)
    protected $_rawCount = self::RAWCOUNT_INVALID;       // Int
    protected $_channelName = self::CHANNELNAME_INVALID;    // Text
    protected $_peakWavelength = self::PEAKWAVELENGTH_INVALID; // Int

    //--- (end of YSpectralChannel attributes)

    function __construct(string $str_func)
    {
        //--- (YSpectralChannel constructor)
        parent::__construct($str_func);
        $this->_className = 'SpectralChannel';

        //--- (end of YSpectralChannel constructor)
    }

    //--- (YSpectralChannel implementation)

    function _parseAttr(string $name,  $val): int
    {
        switch ($name) {
        case 'rawCount':
            $this->_rawCount = intval($val);
            return 1;
        case 'channelName':
            $this->_channelName = $val;
            return 1;
        case 'peakWavelength':
            $this->_peakWavelength = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Retrieves the raw spectral intensity value as measured by the sensor, without any scaling or calibration.
     *
     * @return int  an integer
     *
     * On failure, throws an exception or returns YSpectralChannel::RAWCOUNT_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_rawCount(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::RAWCOUNT_INVALID;
            }
        }
        $res = $this->_rawCount;
        return $res;
    }

    /**
     * Returns the target spectral band name.
     *
     * @return string  a string corresponding to the target spectral band name
     *
     * On failure, throws an exception or returns YSpectralChannel::CHANNELNAME_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_channelName(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::CHANNELNAME_INVALID;
            }
        }
        $res = $this->_channelName;
        return $res;
    }

    /**
     * Returns the target spectral band peak wavelenght, in nm.
     *
     * @return int  an integer corresponding to the target spectral band peak wavelenght, in nm
     *
     * On failure, throws an exception or returns YSpectralChannel::PEAKWAVELENGTH_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_peakWavelength(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::PEAKWAVELENGTH_INVALID;
            }
        }
        $res = $this->_peakWavelength;
        return $res;
    }

    /**
     * Retrieves a spectral analysis channel for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the spectral analysis channel is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the spectral analysis channel is
     * indeed online at a given time. In case of ambiguity when looking for
     * a spectral analysis channel by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the spectral analysis channel, for instance
     *         MyDevice.spectralChannel1.
     *
     * @return YSpectralChannel  a YSpectralChannel object allowing you to drive the spectral analysis channel.
     */
    public static function FindSpectralChannel(string $func): YSpectralChannel
    {
        // $obj                    is a YSpectralChannel;
        $obj = YFunction::_FindFromCache('SpectralChannel', $func);
        if ($obj == null) {
            $obj = new YSpectralChannel($func);
            YFunction::_AddToCache('SpectralChannel', $func, $obj);
        }
        return $obj;
    }

    /**
     * @throws YAPI_Exception
     */
    public function rawCount(): int
{
    return $this->get_rawCount();
}

    /**
     * @throws YAPI_Exception
     */
    public function channelName(): string
{
    return $this->get_channelName();
}

    /**
     * @throws YAPI_Exception
     */
    public function peakWavelength(): int
{
    return $this->get_peakWavelength();
}

    /**
     * Continues the enumeration of spectral analysis channels started using yFirstSpectralChannel().
     * Caution: You can't make any assumption about the returned spectral analysis channels order.
     * If you want to find a specific a spectral analysis channel, use SpectralChannel.findSpectralChannel()
     * and a hardwareID or a logical name.
     *
     * @return ?YSpectralChannel  a pointer to a YSpectralChannel object, corresponding to
     *         a spectral analysis channel currently online, or a null pointer
     *         if there are no more spectral analysis channels to enumerate.
     */
    public function nextSpectralChannel(): ?YSpectralChannel
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindSpectralChannel($next_hwid);
    }

    /**
     * Starts the enumeration of spectral analysis channels currently accessible.
     * Use the method YSpectralChannel::nextSpectralChannel() to iterate on
     * next spectral analysis channels.
     *
     * @return ?YSpectralChannel  a pointer to a YSpectralChannel object, corresponding to
     *         the first spectral analysis channel currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstSpectralChannel(): ?YSpectralChannel
    {
        $next_hwid = YAPI::getFirstHardwareId('SpectralChannel');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindSpectralChannel($next_hwid);
    }

    //--- (end of YSpectralChannel implementation)

}
//^^^^ YSpectralChannel.php

//--- (YSpectralChannel functions)

/**
 * Retrieves a spectral analysis channel for a given identifier.
 * The identifier can be specified using several formats:
 *
 * - FunctionLogicalName
 * - ModuleSerialNumber.FunctionIdentifier
 * - ModuleSerialNumber.FunctionLogicalName
 * - ModuleLogicalName.FunctionIdentifier
 * - ModuleLogicalName.FunctionLogicalName
 *
 *
 * This function does not require that the spectral analysis channel is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method isOnline() to test if the spectral analysis channel is
 * indeed online at a given time. In case of ambiguity when looking for
 * a spectral analysis channel by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 *
 * If a call to this object's is_online() method returns FALSE although
 * you are certain that the matching device is plugged, make sure that you did
 * call registerHub() at application initialization time.
 *
 * @param string $func : a string that uniquely characterizes the spectral analysis channel, for instance
 *         MyDevice.spectralChannel1.
 *
 * @return YSpectralChannel  a YSpectralChannel object allowing you to drive the spectral analysis channel.
 */
function yFindSpectralChannel(string $func): YSpectralChannel
{
    return YSpectralChannel::FindSpectralChannel($func);
}

/**
 * Starts the enumeration of spectral analysis channels currently accessible.
 * Use the method YSpectralChannel::nextSpectralChannel() to iterate on
 * next spectral analysis channels.
 *
 * @return ?YSpectralChannel  a pointer to a YSpectralChannel object, corresponding to
 *         the first spectral analysis channel currently online, or a null pointer
 *         if there are none.
 */
function yFirstSpectralChannel(): ?YSpectralChannel
{
    return YSpectralChannel::FirstSpectralChannel();
}

//--- (end of YSpectralChannel functions)

