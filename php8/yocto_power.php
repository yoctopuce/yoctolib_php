<?php
/*********************************************************************
 *
 *  $Id: yocto_power.php 56082 2023-08-15 14:57:14Z mvuilleu $
 *
 *  Implements YPower, the high-level API for Power functions
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

//--- (YPower return codes)
//--- (end of YPower return codes)
//--- (YPower definitions)
if (!defined('Y_POWERFACTOR_INVALID')) {
    define('Y_POWERFACTOR_INVALID', YAPI_INVALID_DOUBLE);
}
if (!defined('Y_COSPHI_INVALID')) {
    define('Y_COSPHI_INVALID', YAPI_INVALID_DOUBLE);
}
if (!defined('Y_METER_INVALID')) {
    define('Y_METER_INVALID', YAPI_INVALID_DOUBLE);
}
if (!defined('Y_DELIVEREDENERGYMETER_INVALID')) {
    define('Y_DELIVEREDENERGYMETER_INVALID', YAPI_INVALID_DOUBLE);
}
if (!defined('Y_RECEIVEDENERGYMETER_INVALID')) {
    define('Y_RECEIVEDENERGYMETER_INVALID', YAPI_INVALID_DOUBLE);
}
if (!defined('Y_METERTIMER_INVALID')) {
    define('Y_METERTIMER_INVALID', YAPI_INVALID_UINT);
}
//--- (end of YPower definitions)
    #--- (YPower yapiwrapper)

   #--- (end of YPower yapiwrapper)

//--- (YPower declaration)
//vvvv YPower.php

/**
 * YPower Class: electrical power sensor control interface, available for instance in the Yocto-Watt
 *
 * The YPower class allows you to read and configure Yoctopuce electrical power sensors.
 * It inherits from YSensor class the core functions to read measurements,
 * to register callback functions, and to access the autonomous datalogger.
 * This class adds the ability to access the energy counter and the power factor.
 */
class YPower extends YSensor
{
    const POWERFACTOR_INVALID = YAPI::INVALID_DOUBLE;
    const COSPHI_INVALID = YAPI::INVALID_DOUBLE;
    const METER_INVALID = YAPI::INVALID_DOUBLE;
    const DELIVEREDENERGYMETER_INVALID = YAPI::INVALID_DOUBLE;
    const RECEIVEDENERGYMETER_INVALID = YAPI::INVALID_DOUBLE;
    const METERTIMER_INVALID = YAPI::INVALID_UINT;
    //--- (end of YPower declaration)

    //--- (YPower attributes)
    protected float $_powerFactor = self::POWERFACTOR_INVALID;    // MeasureVal
    protected float $_cosPhi = self::COSPHI_INVALID;         // MeasureVal
    protected float $_meter = self::METER_INVALID;          // MeasureVal
    protected float $_deliveredEnergyMeter = self::DELIVEREDENERGYMETER_INVALID; // MeasureVal
    protected float $_receivedEnergyMeter = self::RECEIVEDENERGYMETER_INVALID; // MeasureVal
    protected int $_meterTimer = self::METERTIMER_INVALID;     // UInt31

    //--- (end of YPower attributes)

    function __construct(string $str_func)
    {
        //--- (YPower constructor)
        parent::__construct($str_func);
        $this->_className = 'Power';

        //--- (end of YPower constructor)
    }

    //--- (YPower implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'powerFactor':
            $this->_powerFactor = round($val / 65.536) / 1000.0;
            return 1;
        case 'cosPhi':
            $this->_cosPhi = round($val / 65.536) / 1000.0;
            return 1;
        case 'meter':
            $this->_meter = round($val / 65.536) / 1000.0;
            return 1;
        case 'deliveredEnergyMeter':
            $this->_deliveredEnergyMeter = round($val / 65.536) / 1000.0;
            return 1;
        case 'receivedEnergyMeter':
            $this->_receivedEnergyMeter = round($val / 65.536) / 1000.0;
            return 1;
        case 'meterTimer':
            $this->_meterTimer = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the power factor (PF), i.e. ratio between the active power consumed (in W)
     * and the apparent power provided (VA).
     *
     * @return float  a floating point number corresponding to the power factor (PF), i.e
     *
     * On failure, throws an exception or returns YPower::POWERFACTOR_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_powerFactor(): float
    {
        // $res                    is a float;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::POWERFACTOR_INVALID;
            }
        }
        $res = $this->_powerFactor;
        if ($res == self::POWERFACTOR_INVALID) {
            $res = $this->_cosPhi;
        }
        $res = round($res * 1000) / 1000;
        return $res;
    }

    /**
     * Returns the Displacement Power factor (DPF), i.e. cosine of the phase shift between
     * the voltage and current fundamentals.
     * On the Yocto-Watt (V1), the value returned by this method correponds to the
     * power factor as this device is cannot estimate the true DPF.
     *
     * @return float  a floating point number corresponding to the Displacement Power factor (DPF), i.e
     *
     * On failure, throws an exception or returns YPower::COSPHI_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_cosPhi(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::COSPHI_INVALID;
            }
        }
        $res = $this->_cosPhi;
        return $res;
    }

    /**
     * @throws YAPI_Exception
     */
    public function set_meter(float $newval): int
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("meter", $rest_val);
    }

    /**
     * Returns the energy counter, maintained by the wattmeter by integrating the
     * power consumption over time. This is the sum of forward and backwad energy transfers,
     * if you are insterested in only one direction, use  get_receivedEnergyMeter() or
     * get_deliveredEnergyMeter(). Note that this counter is reset at each start of the device.
     *
     * @return float  a floating point number corresponding to the energy counter, maintained by the
     * wattmeter by integrating the
     *         power consumption over time
     *
     * On failure, throws an exception or returns YPower::METER_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_meter(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::METER_INVALID;
            }
        }
        $res = $this->_meter;
        return $res;
    }

    /**
     * Returns the energy counter, maintained by the wattmeter by integrating the power consumption over time,
     * but only when positive. Note that this counter is reset at each start of the device.
     *
     * @return float  a floating point number corresponding to the energy counter, maintained by the
     * wattmeter by integrating the power consumption over time,
     *         but only when positive
     *
     * On failure, throws an exception or returns YPower::DELIVEREDENERGYMETER_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_deliveredEnergyMeter(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::DELIVEREDENERGYMETER_INVALID;
            }
        }
        $res = $this->_deliveredEnergyMeter;
        return $res;
    }

    /**
     * Returns the energy counter, maintained by the wattmeter by integrating the power consumption over time,
     * but only when negative. Note that this counter is reset at each start of the device.
     *
     * @return float  a floating point number corresponding to the energy counter, maintained by the
     * wattmeter by integrating the power consumption over time,
     *         but only when negative
     *
     * On failure, throws an exception or returns YPower::RECEIVEDENERGYMETER_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_receivedEnergyMeter(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::RECEIVEDENERGYMETER_INVALID;
            }
        }
        $res = $this->_receivedEnergyMeter;
        return $res;
    }

    /**
     * Returns the elapsed time since last energy counter reset, in seconds.
     *
     * @return int  an integer corresponding to the elapsed time since last energy counter reset, in seconds
     *
     * On failure, throws an exception or returns YPower::METERTIMER_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_meterTimer(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::METERTIMER_INVALID;
            }
        }
        $res = $this->_meterTimer;
        return $res;
    }

    /**
     * Retrieves a electrical power sensor for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the electrical power sensor is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the electrical power sensor is
     * indeed online at a given time. In case of ambiguity when looking for
     * a electrical power sensor by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the electrical power sensor, for instance
     *         YWATTMK1.power.
     *
     * @return YPower  a YPower object allowing you to drive the electrical power sensor.
     */
    public static function FindPower(string $func): YPower
    {
        // $obj                    is a YPower;
        $obj = YFunction::_FindFromCache('Power', $func);
        if ($obj == null) {
            $obj = new YPower($func);
            YFunction::_AddToCache('Power', $func, $obj);
        }
        return $obj;
    }

    /**
     * Resets the energy counters.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function reset(): int
    {
        return $this->set_meter(0);
    }

    /**
     * @throws YAPI_Exception
     */
    public function powerFactor(): float
{
    return $this->get_powerFactor();
}

    /**
     * @throws YAPI_Exception
     */
    public function cosPhi(): float
{
    return $this->get_cosPhi();
}

    /**
     * @throws YAPI_Exception
     */
    public function setMeter(float $newval): int
{
    return $this->set_meter($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function meter(): float
{
    return $this->get_meter();
}

    /**
     * @throws YAPI_Exception
     */
    public function deliveredEnergyMeter(): float
{
    return $this->get_deliveredEnergyMeter();
}

    /**
     * @throws YAPI_Exception
     */
    public function receivedEnergyMeter(): float
{
    return $this->get_receivedEnergyMeter();
}

    /**
     * @throws YAPI_Exception
     */
    public function meterTimer(): int
{
    return $this->get_meterTimer();
}

    /**
     * Continues the enumeration of electrical power sensors started using yFirstPower().
     * Caution: You can't make any assumption about the returned electrical power sensors order.
     * If you want to find a specific a electrical power sensor, use Power.findPower()
     * and a hardwareID or a logical name.
     *
     * @return ?YPower  a pointer to a YPower object, corresponding to
     *         a electrical power sensor currently online, or a null pointer
     *         if there are no more electrical power sensors to enumerate.
     */
    public function nextPower(): ?YPower
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindPower($next_hwid);
    }

    /**
     * Starts the enumeration of electrical power sensors currently accessible.
     * Use the method YPower::nextPower() to iterate on
     * next electrical power sensors.
     *
     * @return ?YPower  a pointer to a YPower object, corresponding to
     *         the first electrical power sensor currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstPower(): ?YPower
    {
        $next_hwid = YAPI::getFirstHardwareId('Power');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindPower($next_hwid);
    }

    //--- (end of YPower implementation)

}
//^^^^ YPower.php

//--- (YPower functions)

/**
 * Retrieves a electrical power sensor for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 *
 * This function does not require that the electrical power sensor is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method isOnline() to test if the electrical power sensor is
 * indeed online at a given time. In case of ambiguity when looking for
 * a electrical power sensor by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 *
 * If a call to this object's is_online() method returns FALSE although
 * you are certain that the matching device is plugged, make sure that you did
 * call registerHub() at application initialization time.
 *
 * @param string $func : a string that uniquely characterizes the electrical power sensor, for instance
 *         YWATTMK1.power.
 *
 * @return YPower  a YPower object allowing you to drive the electrical power sensor.
 */
function yFindPower(string $func): YPower
{
    return YPower::FindPower($func);
}

/**
 * Starts the enumeration of electrical power sensors currently accessible.
 * Use the method YPower::nextPower() to iterate on
 * next electrical power sensors.
 *
 * @return ?YPower  a pointer to a YPower object, corresponding to
 *         the first electrical power sensor currently online, or a null pointer
 *         if there are none.
 */
function yFirstPower(): ?YPower
{
    return YPower::FirstPower();
}

//--- (end of YPower functions)

