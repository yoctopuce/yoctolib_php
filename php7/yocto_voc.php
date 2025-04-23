<?php
/*********************************************************************
 *
 *  $Id: svn_id $
 *
 *  Implements YVoc, the high-level API for Voc functions
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

//--- (YVoc return codes)
//--- (end of YVoc return codes)
//--- (YVoc definitions)
//--- (end of YVoc definitions)
    #--- (YVoc yapiwrapper)

   #--- (end of YVoc yapiwrapper)

//--- (YVoc declaration)
//vvvv YVoc.php

/**
 * YVoc Class: Volatile Organic Compound sensor control interface, available for instance in the Yocto-VOC-V3
 *
 * The YVoc class allows you to read and configure Yoctopuce Volatile Organic Compound sensors.
 * It inherits from YSensor class the core functions to read measures,
 * to register callback functions, and to access the autonomous datalogger.
 */
class YVoc extends YSensor
{
    //--- (end of YVoc declaration)

    //--- (YVoc attributes)

    //--- (end of YVoc attributes)

    function __construct(string $str_func)
    {
        //--- (YVoc constructor)
        parent::__construct($str_func);
        $this->_className = 'Voc';

        //--- (end of YVoc constructor)
    }

    //--- (YVoc implementation)

    /**
     * Retrieves a Volatile Organic Compound sensor for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the Volatile Organic Compound sensor is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the Volatile Organic Compound sensor is
     * indeed online at a given time. In case of ambiguity when looking for
     * a Volatile Organic Compound sensor by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the Volatile Organic Compound sensor, for instance
     *         YVOCMK03.voc.
     *
     * @return YVoc  a YVoc object allowing you to drive the Volatile Organic Compound sensor.
     */
    public static function FindVoc(string $func): YVoc
    {
        // $obj                    is a YVoc;
        $obj = YFunction::_FindFromCache('Voc', $func);
        if ($obj == null) {
            $obj = new YVoc($func);
            YFunction::_AddToCache('Voc', $func, $obj);
        }
        return $obj;
    }

    /**
     * Continues the enumeration of Volatile Organic Compound sensors started using yFirstVoc().
     * Caution: You can't make any assumption about the returned Volatile Organic Compound sensors order.
     * If you want to find a specific a Volatile Organic Compound sensor, use Voc.findVoc()
     * and a hardwareID or a logical name.
     *
     * @return ?YVoc  a pointer to a YVoc object, corresponding to
     *         a Volatile Organic Compound sensor currently online, or a null pointer
     *         if there are no more Volatile Organic Compound sensors to enumerate.
     */
    public function nextVoc(): ?YVoc
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindVoc($next_hwid);
    }

    /**
     * Starts the enumeration of Volatile Organic Compound sensors currently accessible.
     * Use the method YVoc::nextVoc() to iterate on
     * next Volatile Organic Compound sensors.
     *
     * @return ?YVoc  a pointer to a YVoc object, corresponding to
     *         the first Volatile Organic Compound sensor currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstVoc(): ?YVoc
    {
        $next_hwid = YAPI::getFirstHardwareId('Voc');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindVoc($next_hwid);
    }

    //--- (end of YVoc implementation)

}
//^^^^ YVoc.php

//--- (YVoc functions)

/**
 * Retrieves a Volatile Organic Compound sensor for a given identifier.
 * The identifier can be specified using several formats:
 *
 * - FunctionLogicalName
 * - ModuleSerialNumber.FunctionIdentifier
 * - ModuleSerialNumber.FunctionLogicalName
 * - ModuleLogicalName.FunctionIdentifier
 * - ModuleLogicalName.FunctionLogicalName
 *
 *
 * This function does not require that the Volatile Organic Compound sensor is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method isOnline() to test if the Volatile Organic Compound sensor is
 * indeed online at a given time. In case of ambiguity when looking for
 * a Volatile Organic Compound sensor by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 *
 * If a call to this object's is_online() method returns FALSE although
 * you are certain that the matching device is plugged, make sure that you did
 * call registerHub() at application initialization time.
 *
 * @param string $func : a string that uniquely characterizes the Volatile Organic Compound sensor, for instance
 *         YVOCMK03.voc.
 *
 * @return YVoc  a YVoc object allowing you to drive the Volatile Organic Compound sensor.
 */
function yFindVoc(string $func): YVoc
{
    return YVoc::FindVoc($func);
}

/**
 * Starts the enumeration of Volatile Organic Compound sensors currently accessible.
 * Use the method YVoc::nextVoc() to iterate on
 * next Volatile Organic Compound sensors.
 *
 * @return ?YVoc  a pointer to a YVoc object, corresponding to
 *         the first Volatile Organic Compound sensor currently online, or a null pointer
 *         if there are none.
 */
function yFirstVoc(): ?YVoc
{
    return YVoc::FirstVoc();
}

//--- (end of YVoc functions)

