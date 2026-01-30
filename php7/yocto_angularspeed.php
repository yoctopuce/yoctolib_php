<?php
/*********************************************************************
 *
 *  $Id: svn_id $
 *
 *  Implements YAngularSpeed, the high-level API for AngularSpeed functions
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

//--- (YAngularSpeed return codes)
//--- (end of YAngularSpeed return codes)
//--- (YAngularSpeed definitions)
//--- (end of YAngularSpeed definitions)
    #--- (YAngularSpeed yapiwrapper)

   #--- (end of YAngularSpeed yapiwrapper)

//--- (YAngularSpeed declaration)
//vvvv YAngularSpeed.php

/**
 * YAngularSpeed Class: tachometer control interface
 *
 * The YAngularSpeed class allows you to read and configure Yoctopuce tachometers.
 * It inherits from YSensor class the core functions to read measurements,
 * to register callback functions, and to access the autonomous datalogger.
 */
class YAngularSpeed extends YSensor
{
    //--- (end of YAngularSpeed declaration)

    //--- (YAngularSpeed attributes)

    //--- (end of YAngularSpeed attributes)

    function __construct(string $str_func)
    {
        //--- (YAngularSpeed constructor)
        parent::__construct($str_func);
        $this->_className = 'AngularSpeed';

        //--- (end of YAngularSpeed constructor)
    }

    //--- (YAngularSpeed implementation)

    /**
     * Retrieves a tachometer for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the rtachometer is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the rtachometer is
     * indeed online at a given time. In case of ambiguity when looking for
     * a tachometer by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the rtachometer, for instance
     *         MyDevice.angularSpeed.
     *
     * @return YAngularSpeed  a YAngularSpeed object allowing you to drive the rtachometer.
     */
    public static function FindAngularSpeed(string $func): YAngularSpeed
    {
        // $obj                    is a YAngularSpeed;
        $obj = YFunction::_FindFromCache('AngularSpeed', $func);
        if ($obj == null) {
            $obj = new YAngularSpeed($func);
            YFunction::_AddToCache('AngularSpeed', $func, $obj);
        }
        return $obj;
    }

    /**
     * Continues the enumeration of tachometers started using yFirstAngularSpeed().
     * Caution: You can't make any assumption about the returned tachometers order.
     * If you want to find a specific a tachometer, use AngularSpeed.findAngularSpeed()
     * and a hardwareID or a logical name.
     *
     * @return ?YAngularSpeed  a pointer to a YAngularSpeed object, corresponding to
     *         a tachometer currently online, or a null pointer
     *         if there are no more tachometers to enumerate.
     */
    public function nextAngularSpeed(): ?YAngularSpeed
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindAngularSpeed($next_hwid);
    }

    /**
     * Starts the enumeration of tachometers currently accessible.
     * Use the method YAngularSpeed::nextAngularSpeed() to iterate on
     * next tachometers.
     *
     * @return ?YAngularSpeed  a pointer to a YAngularSpeed object, corresponding to
     *         the first tachometer currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstAngularSpeed(): ?YAngularSpeed
    {
        $next_hwid = YAPI::getFirstHardwareId('AngularSpeed');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindAngularSpeed($next_hwid);
    }

    //--- (end of YAngularSpeed implementation)

}
//^^^^ YAngularSpeed.php

//--- (YAngularSpeed functions)

/**
 * Retrieves a tachometer for a given identifier.
 * The identifier can be specified using several formats:
 *
 * - FunctionLogicalName
 * - ModuleSerialNumber.FunctionIdentifier
 * - ModuleSerialNumber.FunctionLogicalName
 * - ModuleLogicalName.FunctionIdentifier
 * - ModuleLogicalName.FunctionLogicalName
 *
 *
 * This function does not require that the rtachometer is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method isOnline() to test if the rtachometer is
 * indeed online at a given time. In case of ambiguity when looking for
 * a tachometer by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 *
 * If a call to this object's is_online() method returns FALSE although
 * you are certain that the matching device is plugged, make sure that you did
 * call registerHub() at application initialization time.
 *
 * @param string $func : a string that uniquely characterizes the rtachometer, for instance
 *         MyDevice.angularSpeed.
 *
 * @return YAngularSpeed  a YAngularSpeed object allowing you to drive the rtachometer.
 */
function yFindAngularSpeed(string $func): YAngularSpeed
{
    return YAngularSpeed::FindAngularSpeed($func);
}

/**
 * Starts the enumeration of tachometers currently accessible.
 * Use the method YAngularSpeed::nextAngularSpeed() to iterate on
 * next tachometers.
 *
 * @return ?YAngularSpeed  a pointer to a YAngularSpeed object, corresponding to
 *         the first tachometer currently online, or a null pointer
 *         if there are none.
 */
function yFirstAngularSpeed(): ?YAngularSpeed
{
    return YAngularSpeed::FirstAngularSpeed();
}

//--- (end of YAngularSpeed functions)

