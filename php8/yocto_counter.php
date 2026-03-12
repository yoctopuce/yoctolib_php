<?php
/*********************************************************************
 *
 *  $Id: svn_id $
 *
 *  Implements YCounter, the high-level API for Counter functions
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

//--- (YCounter return codes)
//--- (end of YCounter return codes)
//--- (YCounter definitions)
if (!defined('Y_COMMAND_INVALID')) {
    define('Y_COMMAND_INVALID', YAPI_INVALID_STRING);
}
//--- (end of YCounter definitions)
    #--- (YCounter yapiwrapper)

   #--- (end of YCounter yapiwrapper)

//--- (YCounter declaration)
//vvvv YCounter.php

/**
 * YCounter Class: counter control interface
 *
 * The YCounter class allows you to read and configure Yoctopuce gcounters.
 * It inherits from YSensor class the core functions to read measurements,
 * to register callback functions, and to access the autonomous datalogger.
 */
class YCounter extends YSensor
{
    const COMMAND_INVALID = YAPI::INVALID_STRING;
    //--- (end of YCounter declaration)

    //--- (YCounter attributes)
    protected string $_command = self::COMMAND_INVALID;        // Text

    //--- (end of YCounter attributes)

    function __construct(string $str_func)
    {
        //--- (YCounter constructor)
        parent::__construct($str_func);
        $this->_className = 'Counter';

        //--- (end of YCounter constructor)
    }

    //--- (YCounter implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'command':
            $this->_command = $val;
            return 1;
        }
        return parent::_parseAttr($name, $val);
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
     * Retrieves a counter for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the counter is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the counter is
     * indeed online at a given time. In case of ambiguity when looking for
     * a counter by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the counter, for instance
     *         MyDevice.counter.
     *
     * @return YCounter  a YCounter object allowing you to drive the counter.
     */
    public static function FindCounter(string $func): YCounter
    {
        // $obj                    is a YCounter;
        $obj = YFunction::_FindFromCache('Counter', $func);
        if ($obj == null) {
            $obj = new YCounter($func);
            YFunction::_AddToCache('Counter', $func, $obj);
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
     * Reset the counter to zero.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function zero(): int
    {
        return $this->sendCommand('Z');
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
     * Continues the enumeration of gcounters started using yFirstCounter().
     * Caution: You can't make any assumption about the returned gcounters order.
     * If you want to find a specific a counter, use Counter.findCounter()
     * and a hardwareID or a logical name.
     *
     * @return ?YCounter  a pointer to a YCounter object, corresponding to
     *         a counter currently online, or a null pointer
     *         if there are no more gcounters to enumerate.
     */
    public function nextCounter(): ?YCounter
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindCounter($next_hwid);
    }

    /**
     * Starts the enumeration of gcounters currently accessible.
     * Use the method YCounter::nextCounter() to iterate on
     * next gcounters.
     *
     * @return ?YCounter  a pointer to a YCounter object, corresponding to
     *         the first counter currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstCounter(): ?YCounter
    {
        $next_hwid = YAPI::getFirstHardwareId('Counter');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindCounter($next_hwid);
    }

    //--- (end of YCounter implementation)

}
//^^^^ YCounter.php

//--- (YCounter functions)

/**
 * Retrieves a counter for a given identifier.
 * The identifier can be specified using several formats:
 *
 * - FunctionLogicalName
 * - ModuleSerialNumber.FunctionIdentifier
 * - ModuleSerialNumber.FunctionLogicalName
 * - ModuleLogicalName.FunctionIdentifier
 * - ModuleLogicalName.FunctionLogicalName
 *
 *
 * This function does not require that the counter is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method isOnline() to test if the counter is
 * indeed online at a given time. In case of ambiguity when looking for
 * a counter by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 *
 * If a call to this object's is_online() method returns FALSE although
 * you are certain that the matching device is plugged, make sure that you did
 * call registerHub() at application initialization time.
 *
 * @param string $func : a string that uniquely characterizes the counter, for instance
 *         MyDevice.counter.
 *
 * @return YCounter  a YCounter object allowing you to drive the counter.
 */
function yFindCounter(string $func): YCounter
{
    return YCounter::FindCounter($func);
}

/**
 * Starts the enumeration of gcounters currently accessible.
 * Use the method YCounter::nextCounter() to iterate on
 * next gcounters.
 *
 * @return ?YCounter  a pointer to a YCounter object, corresponding to
 *         the first counter currently online, or a null pointer
 *         if there are none.
 */
function yFirstCounter(): ?YCounter
{
    return YCounter::FirstCounter();
}

//--- (end of YCounter functions)

