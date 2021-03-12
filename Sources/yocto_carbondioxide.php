<?php
/*********************************************************************
 *
 *  $Id: yocto_carbondioxide.php 44175 2021-03-11 11:27:12Z mvuilleu $
 *
 *  Implements YCarbonDioxide, the high-level API for CarbonDioxide functions
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

//--- (YCarbonDioxide return codes)
//--- (end of YCarbonDioxide return codes)
//--- (YCarbonDioxide definitions)
if(!defined('Y_ABCPERIOD_INVALID'))          define('Y_ABCPERIOD_INVALID',         YAPI_INVALID_UINT);
if(!defined('Y_COMMAND_INVALID'))            define('Y_COMMAND_INVALID',           YAPI_INVALID_STRING);
//--- (end of YCarbonDioxide definitions)
    #--- (YCarbonDioxide yapiwrapper)
   #--- (end of YCarbonDioxide yapiwrapper)

//--- (YCarbonDioxide declaration)
/**
 * YCarbonDioxide Class: CO2 sensor control interface, available for instance in the Yocto-CO2-V2
 *
 * The YCarbonDioxide class allows you to read and configure Yoctopuce CO2 sensors.
 * It inherits from YSensor class the core functions to read measurements,
 * to register callback functions, and to access the autonomous datalogger.
 * This class adds the ability to perform manual calibration if required.
 */
class YCarbonDioxide extends YSensor
{
    const ABCPERIOD_INVALID              = YAPI_INVALID_UINT;
    const COMMAND_INVALID                = YAPI_INVALID_STRING;
    //--- (end of YCarbonDioxide declaration)

    //--- (YCarbonDioxide attributes)
    protected $_abcPeriod                = Y_ABCPERIOD_INVALID;          // UInt31
    protected $_command                  = Y_COMMAND_INVALID;            // Text
    //--- (end of YCarbonDioxide attributes)

    function __construct($str_func)
    {
        //--- (YCarbonDioxide constructor)
        parent::__construct($str_func);
        $this->_className = 'CarbonDioxide';

        //--- (end of YCarbonDioxide constructor)
    }

    //--- (YCarbonDioxide implementation)

    function _parseAttr($name, $val)
    {
        switch($name) {
        case 'abcPeriod':
            $this->_abcPeriod = intval($val);
            return 1;
        case 'command':
            $this->_command = $val;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the Automatic Baseline Calibration period, in hours. A negative value
     * means that automatic baseline calibration is disabled.
     *
     * @return integer : an integer corresponding to the Automatic Baseline Calibration period, in hours
     *
     * On failure, throws an exception or returns YCarbonDioxide::ABCPERIOD_INVALID.
     */
    public function get_abcPeriod()
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_ABCPERIOD_INVALID;
            }
        }
        $res = $this->_abcPeriod;
        return $res;
    }

    /**
     * Changes Automatic Baseline Calibration period, in hours. If you need
     * to disable automatic baseline calibration (for instance when using the
     * sensor in an environment that is constantly above 400 ppm CO2), set the
     * period to -1. For the Yocto-CO2-V2, the only possible values are 24 and -1.
     * Remember to call the saveToFlash() method of the
     * module if the modification must be kept.
     *
     * @param integer $newval : an integer corresponding to Automatic Baseline Calibration period, in hours
     *
     * @return integer : YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_abcPeriod($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("abcPeriod",$rest_val);
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
     * Retrieves a CO2 sensor for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the CO2 sensor is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the CO2 sensor is
     * indeed online at a given time. In case of ambiguity when looking for
     * a CO2 sensor by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the CO2 sensor, for instance
     *         YCO2MK02.carbonDioxide.
     *
     * @return YCarbonDioxide : a YCarbonDioxide object allowing you to drive the CO2 sensor.
     */
    public static function FindCarbonDioxide($func)
    {
        // $obj                    is a YCarbonDioxide;
        $obj = YFunction::_FindFromCache('CarbonDioxide', $func);
        if ($obj == null) {
            $obj = new YCarbonDioxide($func);
            YFunction::_AddToCache('CarbonDioxide', $func, $obj);
        }
        return $obj;
    }

    /**
     * Triggers a forced calibration of the sensor at a given CO2 level, specified
     * between 400ppm and 2000ppm. Before invoking this command, the sensor must
     * have been maintained within the specified CO2 density during at least two
     * minutes.
     *
     * @param double $refVal : reference CO2 density for the calibration
     *
     * @return integer : YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function triggerForcedCalibration($refVal)
    {
        return $this->set_command(sprintf('F%dC', round(1000*$refVal)));
    }

    /**
     * Triggers a baseline calibration at standard CO2 ambiant level (400ppm).
     * It is normally not necessary to manually calibrate the sensor, because
     * the built-in automatic baseline calibration procedure will automatically
     * fix any long-term drift based on the lowest level of CO2 observed over the
     * automatic calibration period. However, if automatic baseline calibration
     * is disabled, you may want to manually trigger a calibration from time to
     * time. Before starting a baseline calibration, make sure to put the sensor
     * in a standard environment (e.g. outside in fresh air) at around 400 ppm
     * for at least two minutes.
     *
     * @return integer : YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function triggerBaselineCalibration()
    {
        return $this->set_command('BC');
    }

    public function triggetBaselineCalibration()
    {
        return $this->triggerBaselineCalibration();
    }

    /**
     * Triggers a zero calibration of the sensor on carbon dioxide-free air -
     * for use with first generation Yocto-CO2 only.
     * It is normally not necessary to manually calibrate the sensor, because
     * the built-in automatic baseline calibration procedure will automatically
     * fix any long-term drift based on the lowest level of CO2 observed over the
     * automatic calibration period. However, if you disable automatic baseline
     * calibration, you may want to manually trigger a calibration from time to
     * time. Before starting a zero calibration, you should circulate carbon
     * dioxide-free air within the sensor for a minute or two, using a small pipe
     * connected to the sensor. Please contact support@yoctopuce.com for more details
     * on the zero calibration procedure.
     *
     * @return integer : YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function triggerZeroCalibration()
    {
        return $this->set_command('ZC');
    }

    public function triggetZeroCalibration()
    {
        return $this->triggerZeroCalibration();
    }

    public function abcPeriod()
    { return $this->get_abcPeriod(); }

    public function setAbcPeriod($newval)
    { return $this->set_abcPeriod($newval); }

    public function command()
    { return $this->get_command(); }

    public function setCommand($newval)
    { return $this->set_command($newval); }

    /**
     * Continues the enumeration of CO2 sensors started using yFirstCarbonDioxide().
     * Caution: You can't make any assumption about the returned CO2 sensors order.
     * If you want to find a specific a CO2 sensor, use CarbonDioxide.findCarbonDioxide()
     * and a hardwareID or a logical name.
     *
     * @return YCarbonDioxide : a pointer to a YCarbonDioxide object, corresponding to
     *         a CO2 sensor currently online, or a null pointer
     *         if there are no more CO2 sensors to enumerate.
     */
    public function nextCarbonDioxide()
    {   $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) return null;
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if($next_hwid == null) return null;
        return self::FindCarbonDioxide($next_hwid);
    }

    /**
     * Starts the enumeration of CO2 sensors currently accessible.
     * Use the method YCarbonDioxide::nextCarbonDioxide() to iterate on
     * next CO2 sensors.
     *
     * @return YCarbonDioxide : a pointer to a YCarbonDioxide object, corresponding to
     *         the first CO2 sensor currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstCarbonDioxide()
    {   $next_hwid = YAPI::getFirstHardwareId('CarbonDioxide');
        if($next_hwid == null) return null;
        return self::FindCarbonDioxide($next_hwid);
    }

    //--- (end of YCarbonDioxide implementation)

};

//--- (YCarbonDioxide functions)

/**
 * Retrieves a CO2 sensor for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 *
 * This function does not require that the CO2 sensor is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method isOnline() to test if the CO2 sensor is
 * indeed online at a given time. In case of ambiguity when looking for
 * a CO2 sensor by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 *
 * If a call to this object's is_online() method returns FALSE although
 * you are certain that the matching device is plugged, make sure that you did
 * call registerHub() at application initialization time.
 *
 * @param string $func : a string that uniquely characterizes the CO2 sensor, for instance
 *         YCO2MK02.carbonDioxide.
 *
 * @return YCarbonDioxide : a YCarbonDioxide object allowing you to drive the CO2 sensor.
 */
function yFindCarbonDioxide($func)
{
    return YCarbonDioxide::FindCarbonDioxide($func);
}

/**
 * Starts the enumeration of CO2 sensors currently accessible.
 * Use the method YCarbonDioxide::nextCarbonDioxide() to iterate on
 * next CO2 sensors.
 *
 * @return YCarbonDioxide : a pointer to a YCarbonDioxide object, corresponding to
 *         the first CO2 sensor currently online, or a null pointer
 *         if there are none.
 */
function yFirstCarbonDioxide()
{
    return YCarbonDioxide::FirstCarbonDioxide();
}

//--- (end of YCarbonDioxide functions)
?>