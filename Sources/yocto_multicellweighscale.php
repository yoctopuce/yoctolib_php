<?php
/*********************************************************************
 *
 *  $Id: yocto_multicellweighscale.php 43580 2021-01-26 17:46:01Z mvuilleu $
 *
 *  Implements YMultiCellWeighScale, the high-level API for MultiCellWeighScale functions
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

//--- (YMultiCellWeighScale return codes)
//--- (end of YMultiCellWeighScale return codes)
//--- (YMultiCellWeighScale definitions)
if(!defined('Y_EXTERNALSENSE_FALSE'))        define('Y_EXTERNALSENSE_FALSE',       0);
if(!defined('Y_EXTERNALSENSE_TRUE'))         define('Y_EXTERNALSENSE_TRUE',        1);
if(!defined('Y_EXTERNALSENSE_INVALID'))      define('Y_EXTERNALSENSE_INVALID',     -1);
if(!defined('Y_EXCITATION_OFF'))             define('Y_EXCITATION_OFF',            0);
if(!defined('Y_EXCITATION_DC'))              define('Y_EXCITATION_DC',             1);
if(!defined('Y_EXCITATION_AC'))              define('Y_EXCITATION_AC',             2);
if(!defined('Y_EXCITATION_INVALID'))         define('Y_EXCITATION_INVALID',        -1);
if(!defined('Y_CELLCOUNT_INVALID'))          define('Y_CELLCOUNT_INVALID',         YAPI_INVALID_UINT);
if(!defined('Y_TEMPAVGADAPTRATIO_INVALID'))  define('Y_TEMPAVGADAPTRATIO_INVALID', YAPI_INVALID_DOUBLE);
if(!defined('Y_TEMPCHGADAPTRATIO_INVALID'))  define('Y_TEMPCHGADAPTRATIO_INVALID', YAPI_INVALID_DOUBLE);
if(!defined('Y_COMPTEMPAVG_INVALID'))        define('Y_COMPTEMPAVG_INVALID',       YAPI_INVALID_DOUBLE);
if(!defined('Y_COMPTEMPCHG_INVALID'))        define('Y_COMPTEMPCHG_INVALID',       YAPI_INVALID_DOUBLE);
if(!defined('Y_COMPENSATION_INVALID'))       define('Y_COMPENSATION_INVALID',      YAPI_INVALID_DOUBLE);
if(!defined('Y_ZEROTRACKING_INVALID'))       define('Y_ZEROTRACKING_INVALID',      YAPI_INVALID_DOUBLE);
if(!defined('Y_COMMAND_INVALID'))            define('Y_COMMAND_INVALID',           YAPI_INVALID_STRING);
//--- (end of YMultiCellWeighScale definitions)
    #--- (YMultiCellWeighScale yapiwrapper)
   #--- (end of YMultiCellWeighScale yapiwrapper)

//--- (YMultiCellWeighScale declaration)
/**
 * YMultiCellWeighScale Class: multi-cell weighing scale sensor control interface, available for
 * instance in the Yocto-MaxiBridge
 *
 * The YMultiCellWeighScale class provides a weight measurement from a set of ratiometric
 * sensors. It can be used to control the bridge excitation parameters, in order to avoid
 * measure shifts caused by temperature variation in the electronics, and can also
 * automatically apply an additional correction factor based on temperature to
 * compensate for offsets in the load cells themselves.
 */
class YMultiCellWeighScale extends YSensor
{
    const CELLCOUNT_INVALID              = YAPI_INVALID_UINT;
    const EXTERNALSENSE_FALSE            = 0;
    const EXTERNALSENSE_TRUE             = 1;
    const EXTERNALSENSE_INVALID          = -1;
    const EXCITATION_OFF                 = 0;
    const EXCITATION_DC                  = 1;
    const EXCITATION_AC                  = 2;
    const EXCITATION_INVALID             = -1;
    const TEMPAVGADAPTRATIO_INVALID      = YAPI_INVALID_DOUBLE;
    const TEMPCHGADAPTRATIO_INVALID      = YAPI_INVALID_DOUBLE;
    const COMPTEMPAVG_INVALID            = YAPI_INVALID_DOUBLE;
    const COMPTEMPCHG_INVALID            = YAPI_INVALID_DOUBLE;
    const COMPENSATION_INVALID           = YAPI_INVALID_DOUBLE;
    const ZEROTRACKING_INVALID           = YAPI_INVALID_DOUBLE;
    const COMMAND_INVALID                = YAPI_INVALID_STRING;
    //--- (end of YMultiCellWeighScale declaration)

    //--- (YMultiCellWeighScale attributes)
    protected $_cellCount                = Y_CELLCOUNT_INVALID;          // UInt31
    protected $_externalSense            = Y_EXTERNALSENSE_INVALID;      // Bool
    protected $_excitation               = Y_EXCITATION_INVALID;         // ExcitationMode
    protected $_tempAvgAdaptRatio        = Y_TEMPAVGADAPTRATIO_INVALID;  // MeasureVal
    protected $_tempChgAdaptRatio        = Y_TEMPCHGADAPTRATIO_INVALID;  // MeasureVal
    protected $_compTempAvg              = Y_COMPTEMPAVG_INVALID;        // MeasureVal
    protected $_compTempChg              = Y_COMPTEMPCHG_INVALID;        // MeasureVal
    protected $_compensation             = Y_COMPENSATION_INVALID;       // MeasureVal
    protected $_zeroTracking             = Y_ZEROTRACKING_INVALID;       // MeasureVal
    protected $_command                  = Y_COMMAND_INVALID;            // Text
    //--- (end of YMultiCellWeighScale attributes)

    function __construct($str_func)
    {
        //--- (YMultiCellWeighScale constructor)
        parent::__construct($str_func);
        $this->_className = 'MultiCellWeighScale';

        //--- (end of YMultiCellWeighScale constructor)
    }

    //--- (YMultiCellWeighScale implementation)

    function _parseAttr($name, $val)
    {
        switch($name) {
        case 'cellCount':
            $this->_cellCount = intval($val);
            return 1;
        case 'externalSense':
            $this->_externalSense = intval($val);
            return 1;
        case 'excitation':
            $this->_excitation = intval($val);
            return 1;
        case 'tempAvgAdaptRatio':
            $this->_tempAvgAdaptRatio = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        case 'tempChgAdaptRatio':
            $this->_tempChgAdaptRatio = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        case 'compTempAvg':
            $this->_compTempAvg = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        case 'compTempChg':
            $this->_compTempChg = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        case 'compensation':
            $this->_compensation = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        case 'zeroTracking':
            $this->_zeroTracking = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        case 'command':
            $this->_command = $val;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Changes the measuring unit for the weight.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param string $newval : a string corresponding to the measuring unit for the weight
     *
     * @return integer : YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_unit($newval)
    {
        $rest_val = $newval;
        return $this->_setAttr("unit",$rest_val);
    }

    /**
     * Returns the number of load cells in use.
     *
     * @return integer : an integer corresponding to the number of load cells in use
     *
     * On failure, throws an exception or returns YMultiCellWeighScale::CELLCOUNT_INVALID.
     */
    public function get_cellCount()
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_CELLCOUNT_INVALID;
            }
        }
        $res = $this->_cellCount;
        return $res;
    }

    /**
     * Changes the number of load cells in use. Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     *
     * @param integer $newval : an integer corresponding to the number of load cells in use
     *
     * @return integer : YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_cellCount($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("cellCount",$rest_val);
    }

    /**
     * Returns true if entry 4 is used as external sense for 6-wires load cells.
     *
     * @return integer : either YMultiCellWeighScale::EXTERNALSENSE_FALSE or
     * YMultiCellWeighScale::EXTERNALSENSE_TRUE, according to true if entry 4 is used as external sense for
     * 6-wires load cells
     *
     * On failure, throws an exception or returns YMultiCellWeighScale::EXTERNALSENSE_INVALID.
     */
    public function get_externalSense()
    {
        // $res                    is a enumBOOL;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_EXTERNALSENSE_INVALID;
            }
        }
        $res = $this->_externalSense;
        return $res;
    }

    /**
     * Changes the configuration to tell if entry 4 is used as external sense for
     * 6-wires load cells. Remember to call the saveToFlash() method of the
     * module if the modification must be kept.
     *
     * @param integer $newval : either YMultiCellWeighScale::EXTERNALSENSE_FALSE or
     * YMultiCellWeighScale::EXTERNALSENSE_TRUE, according to the configuration to tell if entry 4 is used
     * as external sense for
     *         6-wires load cells
     *
     * @return integer : YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_externalSense($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("externalSense",$rest_val);
    }

    /**
     * Returns the current load cell bridge excitation method.
     *
     * @return integer : a value among YMultiCellWeighScale::EXCITATION_OFF,
     * YMultiCellWeighScale::EXCITATION_DC and YMultiCellWeighScale::EXCITATION_AC corresponding to the
     * current load cell bridge excitation method
     *
     * On failure, throws an exception or returns YMultiCellWeighScale::EXCITATION_INVALID.
     */
    public function get_excitation()
    {
        // $res                    is a enumEXCITATIONMODE;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_EXCITATION_INVALID;
            }
        }
        $res = $this->_excitation;
        return $res;
    }

    /**
     * Changes the current load cell bridge excitation method.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param integer $newval : a value among YMultiCellWeighScale::EXCITATION_OFF,
     * YMultiCellWeighScale::EXCITATION_DC and YMultiCellWeighScale::EXCITATION_AC corresponding to the
     * current load cell bridge excitation method
     *
     * @return integer : YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_excitation($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("excitation",$rest_val);
    }

    /**
     * Changes the averaged temperature update rate, in per mille.
     * The purpose of this adaptation ratio is to model the thermal inertia of the load cell.
     * The averaged temperature is updated every 10 seconds, by applying this adaptation rate
     * to the difference between the measures ambient temperature and the current compensation
     * temperature. The standard rate is 0.2 per mille, and the maximal rate is 65 per mille.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param double $newval : a floating point number corresponding to the averaged temperature update
     * rate, in per mille
     *
     * @return integer : YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_tempAvgAdaptRatio($newval)
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("tempAvgAdaptRatio",$rest_val);
    }

    /**
     * Returns the averaged temperature update rate, in per mille.
     * The purpose of this adaptation ratio is to model the thermal inertia of the load cell.
     * The averaged temperature is updated every 10 seconds, by applying this adaptation rate
     * to the difference between the measures ambient temperature and the current compensation
     * temperature. The standard rate is 0.2 per mille, and the maximal rate is 65 per mille.
     *
     * @return double : a floating point number corresponding to the averaged temperature update rate, in per mille
     *
     * On failure, throws an exception or returns YMultiCellWeighScale::TEMPAVGADAPTRATIO_INVALID.
     */
    public function get_tempAvgAdaptRatio()
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_TEMPAVGADAPTRATIO_INVALID;
            }
        }
        $res = $this->_tempAvgAdaptRatio;
        return $res;
    }

    /**
     * Changes the temperature change update rate, in per mille.
     * The temperature change is updated every 10 seconds, by applying this adaptation rate
     * to the difference between the measures ambient temperature and the current temperature used for
     * change compensation. The standard rate is 0.6 per mille, and the maximal rate is 65 per mille.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param double $newval : a floating point number corresponding to the temperature change update
     * rate, in per mille
     *
     * @return integer : YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_tempChgAdaptRatio($newval)
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("tempChgAdaptRatio",$rest_val);
    }

    /**
     * Returns the temperature change update rate, in per mille.
     * The temperature change is updated every 10 seconds, by applying this adaptation rate
     * to the difference between the measures ambient temperature and the current temperature used for
     * change compensation. The standard rate is 0.6 per mille, and the maximal rate is 65 per mille.
     *
     * @return double : a floating point number corresponding to the temperature change update rate, in per mille
     *
     * On failure, throws an exception or returns YMultiCellWeighScale::TEMPCHGADAPTRATIO_INVALID.
     */
    public function get_tempChgAdaptRatio()
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_TEMPCHGADAPTRATIO_INVALID;
            }
        }
        $res = $this->_tempChgAdaptRatio;
        return $res;
    }

    /**
     * Returns the current averaged temperature, used for thermal compensation.
     *
     * @return double : a floating point number corresponding to the current averaged temperature, used
     * for thermal compensation
     *
     * On failure, throws an exception or returns YMultiCellWeighScale::COMPTEMPAVG_INVALID.
     */
    public function get_compTempAvg()
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_COMPTEMPAVG_INVALID;
            }
        }
        $res = $this->_compTempAvg;
        return $res;
    }

    /**
     * Returns the current temperature variation, used for thermal compensation.
     *
     * @return double : a floating point number corresponding to the current temperature variation, used
     * for thermal compensation
     *
     * On failure, throws an exception or returns YMultiCellWeighScale::COMPTEMPCHG_INVALID.
     */
    public function get_compTempChg()
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_COMPTEMPCHG_INVALID;
            }
        }
        $res = $this->_compTempChg;
        return $res;
    }

    /**
     * Returns the current current thermal compensation value.
     *
     * @return double : a floating point number corresponding to the current current thermal compensation value
     *
     * On failure, throws an exception or returns YMultiCellWeighScale::COMPENSATION_INVALID.
     */
    public function get_compensation()
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_COMPENSATION_INVALID;
            }
        }
        $res = $this->_compensation;
        return $res;
    }

    /**
     * Changes the zero tracking threshold value. When this threshold is larger than
     * zero, any measure under the threshold will automatically be ignored and the
     * zero compensation will be updated.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param double $newval : a floating point number corresponding to the zero tracking threshold value
     *
     * @return integer : YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_zeroTracking($newval)
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("zeroTracking",$rest_val);
    }

    /**
     * Returns the zero tracking threshold value. When this threshold is larger than
     * zero, any measure under the threshold will automatically be ignored and the
     * zero compensation will be updated.
     *
     * @return double : a floating point number corresponding to the zero tracking threshold value
     *
     * On failure, throws an exception or returns YMultiCellWeighScale::ZEROTRACKING_INVALID.
     */
    public function get_zeroTracking()
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_ZEROTRACKING_INVALID;
            }
        }
        $res = $this->_zeroTracking;
        return $res;
    }

    public function get_command()
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_COMMAND_INVALID;
            }
        }
        $res = $this->_command;
        return $res;
    }

    public function set_command($newval)
    {
        $rest_val = $newval;
        return $this->_setAttr("command",$rest_val);
    }

    /**
     * Retrieves a multi-cell weighing scale sensor for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the multi-cell weighing scale sensor is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the multi-cell weighing scale sensor is
     * indeed online at a given time. In case of ambiguity when looking for
     * a multi-cell weighing scale sensor by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the multi-cell weighing scale sensor, for instance
     *         YWMBRDG1.multiCellWeighScale.
     *
     * @return YMultiCellWeighScale : a YMultiCellWeighScale object allowing you to drive the multi-cell
     * weighing scale sensor.
     */
    public static function FindMultiCellWeighScale($func)
    {
        // $obj                    is a YMultiCellWeighScale;
        $obj = YFunction::_FindFromCache('MultiCellWeighScale', $func);
        if ($obj == null) {
            $obj = new YMultiCellWeighScale($func);
            YFunction::_AddToCache('MultiCellWeighScale', $func, $obj);
        }
        return $obj;
    }

    /**
     * Adapts the load cell signal bias (stored in the corresponding genericSensor)
     * so that the current signal corresponds to a zero weight. Remember to call the
     * saveToFlash() method of the module if the modification must be kept.
     *
     * @return integer : YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function tare()
    {
        return $this->set_command('T');
    }

    /**
     * Configures the load cells span parameters (stored in the corresponding genericSensors)
     * so that the current signal corresponds to the specified reference weight.
     *
     * @param double $currWeight : reference weight presently on the load cell.
     * @param double $maxWeight : maximum weight to be expected on the load cell.
     *
     * @return integer : YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function setupSpan($currWeight,$maxWeight)
    {
        return $this->set_command(sprintf('S%d:%d', round(1000*$currWeight), round(1000*$maxWeight)));
    }

    public function setUnit($newval)
    { return $this->set_unit($newval); }

    public function cellCount()
    { return $this->get_cellCount(); }

    public function setCellCount($newval)
    { return $this->set_cellCount($newval); }

    public function externalSense()
    { return $this->get_externalSense(); }

    public function setExternalSense($newval)
    { return $this->set_externalSense($newval); }

    public function excitation()
    { return $this->get_excitation(); }

    public function setExcitation($newval)
    { return $this->set_excitation($newval); }

    public function setTempAvgAdaptRatio($newval)
    { return $this->set_tempAvgAdaptRatio($newval); }

    public function tempAvgAdaptRatio()
    { return $this->get_tempAvgAdaptRatio(); }

    public function setTempChgAdaptRatio($newval)
    { return $this->set_tempChgAdaptRatio($newval); }

    public function tempChgAdaptRatio()
    { return $this->get_tempChgAdaptRatio(); }

    public function compTempAvg()
    { return $this->get_compTempAvg(); }

    public function compTempChg()
    { return $this->get_compTempChg(); }

    public function compensation()
    { return $this->get_compensation(); }

    public function setZeroTracking($newval)
    { return $this->set_zeroTracking($newval); }

    public function zeroTracking()
    { return $this->get_zeroTracking(); }

    public function command()
    { return $this->get_command(); }

    public function setCommand($newval)
    { return $this->set_command($newval); }

    /**
     * Continues the enumeration of multi-cell weighing scale sensors started using yFirstMultiCellWeighScale().
     * Caution: You can't make any assumption about the returned multi-cell weighing scale sensors order.
     * If you want to find a specific a multi-cell weighing scale sensor, use
     * MultiCellWeighScale.findMultiCellWeighScale()
     * and a hardwareID or a logical name.
     *
     * @return YMultiCellWeighScale : a pointer to a YMultiCellWeighScale object, corresponding to
     *         a multi-cell weighing scale sensor currently online, or a null pointer
     *         if there are no more multi-cell weighing scale sensors to enumerate.
     */
    public function nextMultiCellWeighScale()
    {   $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) return null;
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if($next_hwid == null) return null;
        return self::FindMultiCellWeighScale($next_hwid);
    }

    /**
     * Starts the enumeration of multi-cell weighing scale sensors currently accessible.
     * Use the method YMultiCellWeighScale::nextMultiCellWeighScale() to iterate on
     * next multi-cell weighing scale sensors.
     *
     * @return YMultiCellWeighScale : a pointer to a YMultiCellWeighScale object, corresponding to
     *         the first multi-cell weighing scale sensor currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstMultiCellWeighScale()
    {   $next_hwid = YAPI::getFirstHardwareId('MultiCellWeighScale');
        if($next_hwid == null) return null;
        return self::FindMultiCellWeighScale($next_hwid);
    }

    //--- (end of YMultiCellWeighScale implementation)

};

//--- (YMultiCellWeighScale functions)

/**
 * Retrieves a multi-cell weighing scale sensor for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 *
 * This function does not require that the multi-cell weighing scale sensor is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method isOnline() to test if the multi-cell weighing scale sensor is
 * indeed online at a given time. In case of ambiguity when looking for
 * a multi-cell weighing scale sensor by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 *
 * If a call to this object's is_online() method returns FALSE although
 * you are certain that the matching device is plugged, make sure that you did
 * call registerHub() at application initialization time.
 *
 * @param string $func : a string that uniquely characterizes the multi-cell weighing scale sensor, for instance
 *         YWMBRDG1.multiCellWeighScale.
 *
 * @return YMultiCellWeighScale : a YMultiCellWeighScale object allowing you to drive the multi-cell
 * weighing scale sensor.
 */
function yFindMultiCellWeighScale($func)
{
    return YMultiCellWeighScale::FindMultiCellWeighScale($func);
}

/**
 * Starts the enumeration of multi-cell weighing scale sensors currently accessible.
 * Use the method YMultiCellWeighScale::nextMultiCellWeighScale() to iterate on
 * next multi-cell weighing scale sensors.
 *
 * @return YMultiCellWeighScale : a pointer to a YMultiCellWeighScale object, corresponding to
 *         the first multi-cell weighing scale sensor currently online, or a null pointer
 *         if there are none.
 */
function yFirstMultiCellWeighScale()
{
    return YMultiCellWeighScale::FirstMultiCellWeighScale();
}

//--- (end of YMultiCellWeighScale functions)
?>