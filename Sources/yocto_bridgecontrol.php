<?php
/*********************************************************************
 *
 * $Id: yocto_bridgecontrol.php 27709 2017-06-01 12:37:26Z seb $
 *
 * Implements YBridgeControl, the high-level API for BridgeControl functions
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

//--- (YBridgeControl return codes)
//--- (end of YBridgeControl return codes)
//--- (YBridgeControl definitions)
if(!defined('Y_EXCITATIONMODE_INTERNAL_AC')) define('Y_EXCITATIONMODE_INTERNAL_AC', 0);
if(!defined('Y_EXCITATIONMODE_INTERNAL_DC')) define('Y_EXCITATIONMODE_INTERNAL_DC', 1);
if(!defined('Y_EXCITATIONMODE_EXTERNAL_DC')) define('Y_EXCITATIONMODE_EXTERNAL_DC', 2);
if(!defined('Y_EXCITATIONMODE_INVALID'))     define('Y_EXCITATIONMODE_INVALID',    -1);
if(!defined('Y_BRIDGELATENCY_INVALID'))      define('Y_BRIDGELATENCY_INVALID',     YAPI_INVALID_UINT);
if(!defined('Y_ADVALUE_INVALID'))            define('Y_ADVALUE_INVALID',           YAPI_INVALID_INT);
if(!defined('Y_ADGAIN_INVALID'))             define('Y_ADGAIN_INVALID',            YAPI_INVALID_UINT);
//--- (end of YBridgeControl definitions)

//--- (YBridgeControl declaration)
/**
 * YBridgeControl Class: BridgeControl function interface
 *
 * The Yoctopuce class YBridgeControl allows you to control bridge excitation parameters
 * and measure parameters for a Wheatstone bridge sensor. To read the measurements, it
 * is best to use the GenericSensor calss, which will compute the measured value
 * in the optimal way.
 */
class YBridgeControl extends YFunction
{
    const EXCITATIONMODE_INTERNAL_AC     = 0;
    const EXCITATIONMODE_INTERNAL_DC     = 1;
    const EXCITATIONMODE_EXTERNAL_DC     = 2;
    const EXCITATIONMODE_INVALID         = -1;
    const BRIDGELATENCY_INVALID          = YAPI_INVALID_UINT;
    const ADVALUE_INVALID                = YAPI_INVALID_INT;
    const ADGAIN_INVALID                 = YAPI_INVALID_UINT;
    //--- (end of YBridgeControl declaration)

    //--- (YBridgeControl attributes)
    protected $_excitationMode           = Y_EXCITATIONMODE_INVALID;     // ExcitationMode
    protected $_bridgeLatency            = Y_BRIDGELATENCY_INVALID;      // UInt31
    protected $_adValue                  = Y_ADVALUE_INVALID;            // Int
    protected $_adGain                   = Y_ADGAIN_INVALID;             // UInt31
    //--- (end of YBridgeControl attributes)

    function __construct($str_func)
    {
        //--- (YBridgeControl constructor)
        parent::__construct($str_func);
        $this->_className = 'BridgeControl';

        //--- (end of YBridgeControl constructor)
    }

    //--- (YBridgeControl implementation)

    function _parseAttr($name, $val)
    {
        switch($name) {
        case 'excitationMode':
            $this->_excitationMode = intval($val);
            return 1;
        case 'bridgeLatency':
            $this->_bridgeLatency = intval($val);
            return 1;
        case 'adValue':
            $this->_adValue = intval($val);
            return 1;
        case 'adGain':
            $this->_adGain = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the current Wheatstone bridge excitation method.
     *
     * @return a value among Y_EXCITATIONMODE_INTERNAL_AC, Y_EXCITATIONMODE_INTERNAL_DC and
     * Y_EXCITATIONMODE_EXTERNAL_DC corresponding to the current Wheatstone bridge excitation method
     *
     * On failure, throws an exception or returns Y_EXCITATIONMODE_INVALID.
     */
    public function get_excitationMode()
    {
        // $res                    is a enumEXCITATIONMODE;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_EXCITATIONMODE_INVALID;
            }
        }
        $res = $this->_excitationMode;
        return $res;
    }

    /**
     * Changes the current Wheatstone bridge excitation method.
     *
     * @param newval : a value among Y_EXCITATIONMODE_INTERNAL_AC, Y_EXCITATIONMODE_INTERNAL_DC and
     * Y_EXCITATIONMODE_EXTERNAL_DC corresponding to the current Wheatstone bridge excitation method
     *
     * @return YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_excitationMode($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("excitationMode",$rest_val);
    }

    /**
     * Returns the current Wheatstone bridge excitation method.
     *
     * @return an integer corresponding to the current Wheatstone bridge excitation method
     *
     * On failure, throws an exception or returns Y_BRIDGELATENCY_INVALID.
     */
    public function get_bridgeLatency()
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_BRIDGELATENCY_INVALID;
            }
        }
        $res = $this->_bridgeLatency;
        return $res;
    }

    /**
     * Changes the current Wheatstone bridge excitation method.
     *
     * @param newval : an integer corresponding to the current Wheatstone bridge excitation method
     *
     * @return YAPI_SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_bridgeLatency($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("bridgeLatency",$rest_val);
    }

    /**
     * Returns the raw value returned by the ratiometric A/D converter
     * during last read.
     *
     * @return an integer corresponding to the raw value returned by the ratiometric A/D converter
     *         during last read
     *
     * On failure, throws an exception or returns Y_ADVALUE_INVALID.
     */
    public function get_adValue()
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_ADVALUE_INVALID;
            }
        }
        $res = $this->_adValue;
        return $res;
    }

    /**
     * Returns the current ratiometric A/D converter gain. The gain is automatically
     * configured according to the signalRange set in the corresponding genericSensor.
     *
     * @return an integer corresponding to the current ratiometric A/D converter gain
     *
     * On failure, throws an exception or returns Y_ADGAIN_INVALID.
     */
    public function get_adGain()
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_ADGAIN_INVALID;
            }
        }
        $res = $this->_adGain;
        return $res;
    }

    /**
     * Retrieves a Wheatstone bridge controller for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the Wheatstone bridge controller is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YBridgeControl.isOnline() to test if the Wheatstone bridge controller is
     * indeed online at a given time. In case of ambiguity when looking for
     * a Wheatstone bridge controller by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param func : a string that uniquely characterizes the Wheatstone bridge controller
     *
     * @return a YBridgeControl object allowing you to drive the Wheatstone bridge controller.
     */
    public static function FindBridgeControl($func)
    {
        // $obj                    is a YBridgeControl;
        $obj = YFunction::_FindFromCache('BridgeControl', $func);
        if ($obj == null) {
            $obj = new YBridgeControl($func);
            YFunction::_AddToCache('BridgeControl', $func, $obj);
        }
        return $obj;
    }

    public function excitationMode()
    { return $this->get_excitationMode(); }

    public function setExcitationMode($newval)
    { return $this->set_excitationMode($newval); }

    public function bridgeLatency()
    { return $this->get_bridgeLatency(); }

    public function setBridgeLatency($newval)
    { return $this->set_bridgeLatency($newval); }

    public function adValue()
    { return $this->get_adValue(); }

    public function adGain()
    { return $this->get_adGain(); }

    /**
     * Continues the enumeration of Wheatstone bridge controllers started using yFirstBridgeControl().
     *
     * @return a pointer to a YBridgeControl object, corresponding to
     *         a Wheatstone bridge controller currently online, or a null pointer
     *         if there are no more Wheatstone bridge controllers to enumerate.
     */
    public function nextBridgeControl()
    {   $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) return null;
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if($next_hwid == null) return null;
        return self::FindBridgeControl($next_hwid);
    }

    /**
     * Starts the enumeration of Wheatstone bridge controllers currently accessible.
     * Use the method YBridgeControl.nextBridgeControl() to iterate on
     * next Wheatstone bridge controllers.
     *
     * @return a pointer to a YBridgeControl object, corresponding to
     *         the first Wheatstone bridge controller currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstBridgeControl()
    {   $next_hwid = YAPI::getFirstHardwareId('BridgeControl');
        if($next_hwid == null) return null;
        return self::FindBridgeControl($next_hwid);
    }

    //--- (end of YBridgeControl implementation)

};

//--- (BridgeControl functions)

/**
 * Retrieves a Wheatstone bridge controller for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 *
 * This function does not require that the Wheatstone bridge controller is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YBridgeControl.isOnline() to test if the Wheatstone bridge controller is
 * indeed online at a given time. In case of ambiguity when looking for
 * a Wheatstone bridge controller by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 *
 * If a call to this object's is_online() method returns FALSE although
 * you are certain that the matching device is plugged, make sure that you did
 * call registerHub() at application initialization time.
 *
 * @param func : a string that uniquely characterizes the Wheatstone bridge controller
 *
 * @return a YBridgeControl object allowing you to drive the Wheatstone bridge controller.
 */
function yFindBridgeControl($func)
{
    return YBridgeControl::FindBridgeControl($func);
}

/**
 * Starts the enumeration of Wheatstone bridge controllers currently accessible.
 * Use the method YBridgeControl.nextBridgeControl() to iterate on
 * next Wheatstone bridge controllers.
 *
 * @return a pointer to a YBridgeControl object, corresponding to
 *         the first Wheatstone bridge controller currently online, or a null pointer
 *         if there are none.
 */
function yFirstBridgeControl()
{
    return YBridgeControl::FirstBridgeControl();
}

//--- (end of BridgeControl functions)
?>