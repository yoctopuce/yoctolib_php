<?php
/*********************************************************************
 *
 *  $Id: yocto_altitude.php 43580 2021-01-26 17:46:01Z mvuilleu $
 *
 *  Implements YAltitude, the high-level API for Altitude functions
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

//--- (YAltitude return codes)
//--- (end of YAltitude return codes)
//--- (YAltitude definitions)
if(!defined('Y_QNH_INVALID'))                define('Y_QNH_INVALID',               YAPI_INVALID_DOUBLE);
if(!defined('Y_TECHNOLOGY_INVALID'))         define('Y_TECHNOLOGY_INVALID',        YAPI_INVALID_STRING);
//--- (end of YAltitude definitions)
    #--- (YAltitude yapiwrapper)
   #--- (end of YAltitude yapiwrapper)

//--- (YAltitude declaration)
/**
 * YAltitude Class: altimeter control interface, available for instance in the Yocto-Altimeter-V2 or
 * the Yocto-GPS-V2
 *
 * The YAltitude class allows you to read and configure Yoctopuce altimeters.
 * It inherits from YSensor class the core functions to read measurements,
 * to register callback functions, and to access the autonomous datalogger.
 * This class adds the ability to configure the barometric pressure adjusted to
 * sea level (QNH) for barometric sensors.
 */
class YAltitude extends YSensor
{
    const QNH_INVALID                    = YAPI_INVALID_DOUBLE;
    const TECHNOLOGY_INVALID             = YAPI_INVALID_STRING;
    //--- (end of YAltitude declaration)

    //--- (YAltitude attributes)
    protected $_qnh                      = Y_QNH_INVALID;                // MeasureVal
    protected $_technology               = Y_TECHNOLOGY_INVALID;         // Text
    //--- (end of YAltitude attributes)

    function __construct($str_func)
    {
        //--- (YAltitude constructor)
        parent::__construct($str_func);
        $this->_className = 'Altitude';

        //--- (end of YAltitude constructor)
    }

    //--- (YAltitude implementation)

    function _parseAttr($name, $val)
    {
        switch($name) {
        case 'qnh':
            $this->_qnh = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        case 'technology':
            $this->_technology = $val;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Changes the current estimated altitude. This allows one to compensate for
     * ambient pressure variations and to work in relative mode.
     * Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     *
     * @param double $newval : a floating point number corresponding to the current estimated altitude
     *
     * @return integer : YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_currentValue($newval)
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("currentValue",$rest_val);
    }

    /**
     * Changes the barometric pressure adjusted to sea level used to compute
     * the altitude (QNH). This enables you to compensate for atmospheric pressure
     * changes due to weather conditions. Applicable to barometric altimeters only.
     * Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     *
     * @param double $newval : a floating point number corresponding to the barometric pressure adjusted
     * to sea level used to compute
     *         the altitude (QNH)
     *
     * @return integer : YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_qnh($newval)
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("qnh",$rest_val);
    }

    /**
     * Returns the barometric pressure adjusted to sea level used to compute
     * the altitude (QNH). Applicable to barometric altimeters only.
     *
     * @return double : a floating point number corresponding to the barometric pressure adjusted to sea
     * level used to compute
     *         the altitude (QNH)
     *
     * On failure, throws an exception or returns YAltitude::QNH_INVALID.
     */
    public function get_qnh()
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_QNH_INVALID;
            }
        }
        $res = $this->_qnh;
        return $res;
    }

    /**
     * Returns the technology used by the sesnor to compute
     * altitude. Possibles values are  "barometric" and "gps"
     *
     * @return string : a string corresponding to the technology used by the sesnor to compute
     *         altitude
     *
     * On failure, throws an exception or returns YAltitude::TECHNOLOGY_INVALID.
     */
    public function get_technology()
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_TECHNOLOGY_INVALID;
            }
        }
        $res = $this->_technology;
        return $res;
    }

    /**
     * Retrieves an altimeter for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the altimeter is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the altimeter is
     * indeed online at a given time. In case of ambiguity when looking for
     * an altimeter by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the altimeter, for instance
     *         YALTIMK2.altitude.
     *
     * @return YAltitude : a YAltitude object allowing you to drive the altimeter.
     */
    public static function FindAltitude($func)
    {
        // $obj                    is a YAltitude;
        $obj = YFunction::_FindFromCache('Altitude', $func);
        if ($obj == null) {
            $obj = new YAltitude($func);
            YFunction::_AddToCache('Altitude', $func, $obj);
        }
        return $obj;
    }

    public function setCurrentValue($newval)
    { return $this->set_currentValue($newval); }

    public function setQnh($newval)
    { return $this->set_qnh($newval); }

    public function qnh()
    { return $this->get_qnh(); }

    public function technology()
    { return $this->get_technology(); }

    /**
     * Continues the enumeration of altimeters started using yFirstAltitude().
     * Caution: You can't make any assumption about the returned altimeters order.
     * If you want to find a specific an altimeter, use Altitude.findAltitude()
     * and a hardwareID or a logical name.
     *
     * @return YAltitude : a pointer to a YAltitude object, corresponding to
     *         an altimeter currently online, or a null pointer
     *         if there are no more altimeters to enumerate.
     */
    public function nextAltitude()
    {   $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) return null;
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if($next_hwid == null) return null;
        return self::FindAltitude($next_hwid);
    }

    /**
     * Starts the enumeration of altimeters currently accessible.
     * Use the method YAltitude::nextAltitude() to iterate on
     * next altimeters.
     *
     * @return YAltitude : a pointer to a YAltitude object, corresponding to
     *         the first altimeter currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstAltitude()
    {   $next_hwid = YAPI::getFirstHardwareId('Altitude');
        if($next_hwid == null) return null;
        return self::FindAltitude($next_hwid);
    }

    //--- (end of YAltitude implementation)

};

//--- (YAltitude functions)

/**
 * Retrieves an altimeter for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 *
 * This function does not require that the altimeter is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method isOnline() to test if the altimeter is
 * indeed online at a given time. In case of ambiguity when looking for
 * an altimeter by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 *
 * If a call to this object's is_online() method returns FALSE although
 * you are certain that the matching device is plugged, make sure that you did
 * call registerHub() at application initialization time.
 *
 * @param string $func : a string that uniquely characterizes the altimeter, for instance
 *         YALTIMK2.altitude.
 *
 * @return YAltitude : a YAltitude object allowing you to drive the altimeter.
 */
function yFindAltitude($func)
{
    return YAltitude::FindAltitude($func);
}

/**
 * Starts the enumeration of altimeters currently accessible.
 * Use the method YAltitude::nextAltitude() to iterate on
 * next altimeters.
 *
 * @return YAltitude : a pointer to a YAltitude object, corresponding to
 *         the first altimeter currently online, or a null pointer
 *         if there are none.
 */
function yFirstAltitude()
{
    return YAltitude::FirstAltitude();
}

//--- (end of YAltitude functions)
?>