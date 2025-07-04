<?php
/*********************************************************************
 *
 *  $Id: svn_id $
 *
 *  Implements YMultiSensController, the high-level API for MultiSensController functions
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

//--- (YMultiSensController return codes)
//--- (end of YMultiSensController return codes)
//--- (YMultiSensController definitions)
if (!defined('Y_MAINTENANCEMODE_FALSE')) {
    define('Y_MAINTENANCEMODE_FALSE', 0);
}
if (!defined('Y_MAINTENANCEMODE_TRUE')) {
    define('Y_MAINTENANCEMODE_TRUE', 1);
}
if (!defined('Y_MAINTENANCEMODE_INVALID')) {
    define('Y_MAINTENANCEMODE_INVALID', -1);
}
if (!defined('Y_NSENSORS_INVALID')) {
    define('Y_NSENSORS_INVALID', YAPI_INVALID_UINT);
}
if (!defined('Y_MAXSENSORS_INVALID')) {
    define('Y_MAXSENSORS_INVALID', YAPI_INVALID_UINT);
}
if (!defined('Y_LASTADDRESSDETECTED_INVALID')) {
    define('Y_LASTADDRESSDETECTED_INVALID', YAPI_INVALID_UINT);
}
if (!defined('Y_COMMAND_INVALID')) {
    define('Y_COMMAND_INVALID', YAPI_INVALID_STRING);
}
//--- (end of YMultiSensController definitions)
    #--- (YMultiSensController yapiwrapper)

   #--- (end of YMultiSensController yapiwrapper)

//--- (YMultiSensController declaration)
//vvvv YMultiSensController.php

/**
 * YMultiSensController Class: Sensor chain configuration interface, available for instance in the
 * Yocto-Temperature-IR
 *
 * The YMultiSensController class allows you to set up a customized
 * sensor chain on devices featuring that functionality.
 */
class YMultiSensController extends YFunction
{
    const NSENSORS_INVALID = YAPI::INVALID_UINT;
    const MAXSENSORS_INVALID = YAPI::INVALID_UINT;
    const MAINTENANCEMODE_FALSE = 0;
    const MAINTENANCEMODE_TRUE = 1;
    const MAINTENANCEMODE_INVALID = -1;
    const LASTADDRESSDETECTED_INVALID = YAPI::INVALID_UINT;
    const COMMAND_INVALID = YAPI::INVALID_STRING;
    //--- (end of YMultiSensController declaration)

    //--- (YMultiSensController attributes)
    protected int $_nSensors = self::NSENSORS_INVALID;       // UInt31
    protected int $_maxSensors = self::MAXSENSORS_INVALID;     // UInt31
    protected int $_maintenanceMode = self::MAINTENANCEMODE_INVALID; // Bool
    protected int $_lastAddressDetected = self::LASTADDRESSDETECTED_INVALID; // UInt31
    protected string $_command = self::COMMAND_INVALID;        // Text

    //--- (end of YMultiSensController attributes)

    function __construct(string $str_func)
    {
        //--- (YMultiSensController constructor)
        parent::__construct($str_func);
        $this->_className = 'MultiSensController';

        //--- (end of YMultiSensController constructor)
    }

    //--- (YMultiSensController implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'nSensors':
            $this->_nSensors = intval($val);
            return 1;
        case 'maxSensors':
            $this->_maxSensors = intval($val);
            return 1;
        case 'maintenanceMode':
            $this->_maintenanceMode = intval($val);
            return 1;
        case 'lastAddressDetected':
            $this->_lastAddressDetected = intval($val);
            return 1;
        case 'command':
            $this->_command = $val;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the number of sensors to poll.
     *
     * @return int  an integer corresponding to the number of sensors to poll
     *
     * On failure, throws an exception or returns YMultiSensController::NSENSORS_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_nSensors(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::NSENSORS_INVALID;
            }
        }
        $res = $this->_nSensors;
        return $res;
    }

    /**
     * Changes the number of sensors to poll. Remember to call the
     * saveToFlash() method of the module if the
     * modification must be kept. It is recommended to restart the
     * device with  module->reboot() after modifying
     * (and saving) this settings.
     *
     * @param int $newval : an integer corresponding to the number of sensors to poll
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_nSensors(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("nSensors", $rest_val);
    }

    /**
     * Returns the maximum configurable sensor count allowed on this device.
     *
     * @return int  an integer corresponding to the maximum configurable sensor count allowed on this device
     *
     * On failure, throws an exception or returns YMultiSensController::MAXSENSORS_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_maxSensors(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::MAXSENSORS_INVALID;
            }
        }
        $res = $this->_maxSensors;
        return $res;
    }

    /**
     * Returns true when the device is in maintenance mode.
     *
     * @return int  either YMultiSensController::MAINTENANCEMODE_FALSE or
     * YMultiSensController::MAINTENANCEMODE_TRUE, according to true when the device is in maintenance mode
     *
     * On failure, throws an exception or returns YMultiSensController::MAINTENANCEMODE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_maintenanceMode(): int
    {
        // $res                    is a enumBOOL;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::MAINTENANCEMODE_INVALID;
            }
        }
        $res = $this->_maintenanceMode;
        return $res;
    }

    /**
     * Changes the device mode to enable maintenance and to stop sensor polling.
     * This way, the device does not automatically restart when it cannot
     * communicate with one of the sensors.
     *
     * @param int $newval : either YMultiSensController::MAINTENANCEMODE_FALSE or
     * YMultiSensController::MAINTENANCEMODE_TRUE, according to the device mode to enable maintenance and
     * to stop sensor polling
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_maintenanceMode(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("maintenanceMode", $rest_val);
    }

    /**
     * Returns the I2C address of the most recently detected sensor. This method can
     * be used to in case of I2C communication error to determine what is the
     * last sensor that can be reached, or after a call to setupAddress
     * to make sure that the address change was properly processed.
     *
     * @return int  an integer corresponding to the I2C address of the most recently detected sensor
     *
     * On failure, throws an exception or returns YMultiSensController::LASTADDRESSDETECTED_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_lastAddressDetected(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::LASTADDRESSDETECTED_INVALID;
            }
        }
        $res = $this->_lastAddressDetected;
        return $res;
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
     * Retrieves a multi-sensor controller for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the multi-sensor controller is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the multi-sensor controller is
     * indeed online at a given time. In case of ambiguity when looking for
     * a multi-sensor controller by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the multi-sensor controller, for instance
     *         YTEMPIR1.multiSensController.
     *
     * @return YMultiSensController  a YMultiSensController object allowing you to drive the multi-sensor controller.
     */
    public static function FindMultiSensController(string $func): YMultiSensController
    {
        // $obj                    is a YMultiSensController;
        $obj = YFunction::_FindFromCache('MultiSensController', $func);
        if ($obj == null) {
            $obj = new YMultiSensController($func);
            YFunction::_AddToCache('MultiSensController', $func, $obj);
        }
        return $obj;
    }

    /**
     * Configures the I2C address of the only sensor connected to the device.
     * It is recommended to put the the device in maintenance mode before
     * changing sensor addresses.  This method is only intended to work with a single
     * sensor connected to the device. If several sensors are connected, the result
     * is unpredictable.
     *
     * Note that the device is expecting to find a sensor or a string of sensors with specific
     * addresses. Check the device documentation to find out which addresses should be used.
     *
     * @param int $addr : new address of the connected sensor
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function setupAddress(int $addr): int
    {
        // $cmd                    is a str;
        // $res                    is a int;
        $cmd = sprintf('A%d', $addr);
        $res = $this->set_command($cmd);
        if (!($res == YAPI::SUCCESS)) return $this->_throw(YAPI::IO_ERROR,'unable to trigger address change',YAPI::IO_ERROR);
        YAPI::Sleep(1500);
        $res = $this->get_lastAddressDetected();
        if (!($res > 0)) return $this->_throw(YAPI::IO_ERROR,'IR sensor not found',YAPI::IO_ERROR);
        if (!($res == $addr)) return $this->_throw(YAPI::IO_ERROR,'address change failed',YAPI::IO_ERROR);
        return YAPI::SUCCESS;
    }

    /**
     * Triggers the I2C address detection procedure for the only sensor connected to the device.
     * This method is only intended to work with a single sensor connected to the device.
     * If several sensors are connected, the result is unpredictable.
     *
     * @return int  the I2C address of the detected sensor, or 0 if none is found
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function get_sensorAddress(): int
    {
        // $res                    is a int;
        $res = $this->set_command('a');
        if (!($res == YAPI::SUCCESS)) return $this->_throw(YAPI::IO_ERROR,'unable to trigger address detection',$res);
        YAPI::Sleep(1000);
        $res = $this->get_lastAddressDetected();
        return $res;
    }

    /**
     * @throws YAPI_Exception
     */
    public function nSensors(): int
{
    return $this->get_nSensors();
}

    /**
     * @throws YAPI_Exception
     */
    public function setNSensors(int $newval): int
{
    return $this->set_nSensors($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function maxSensors(): int
{
    return $this->get_maxSensors();
}

    /**
     * @throws YAPI_Exception
     */
    public function maintenanceMode(): int
{
    return $this->get_maintenanceMode();
}

    /**
     * @throws YAPI_Exception
     */
    public function setMaintenanceMode(int $newval): int
{
    return $this->set_maintenanceMode($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function lastAddressDetected(): int
{
    return $this->get_lastAddressDetected();
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
     * Continues the enumeration of multi-sensor controllers started using yFirstMultiSensController().
     * Caution: You can't make any assumption about the returned multi-sensor controllers order.
     * If you want to find a specific a multi-sensor controller, use MultiSensController.findMultiSensController()
     * and a hardwareID or a logical name.
     *
     * @return ?YMultiSensController  a pointer to a YMultiSensController object, corresponding to
     *         a multi-sensor controller currently online, or a null pointer
     *         if there are no more multi-sensor controllers to enumerate.
     */
    public function nextMultiSensController(): ?YMultiSensController
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindMultiSensController($next_hwid);
    }

    /**
     * Starts the enumeration of multi-sensor controllers currently accessible.
     * Use the method YMultiSensController::nextMultiSensController() to iterate on
     * next multi-sensor controllers.
     *
     * @return ?YMultiSensController  a pointer to a YMultiSensController object, corresponding to
     *         the first multi-sensor controller currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstMultiSensController(): ?YMultiSensController
    {
        $next_hwid = YAPI::getFirstHardwareId('MultiSensController');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindMultiSensController($next_hwid);
    }

    //--- (end of YMultiSensController implementation)

}
//^^^^ YMultiSensController.php

//--- (YMultiSensController functions)

/**
 * Retrieves a multi-sensor controller for a given identifier.
 * The identifier can be specified using several formats:
 *
 * - FunctionLogicalName
 * - ModuleSerialNumber.FunctionIdentifier
 * - ModuleSerialNumber.FunctionLogicalName
 * - ModuleLogicalName.FunctionIdentifier
 * - ModuleLogicalName.FunctionLogicalName
 *
 *
 * This function does not require that the multi-sensor controller is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method isOnline() to test if the multi-sensor controller is
 * indeed online at a given time. In case of ambiguity when looking for
 * a multi-sensor controller by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 *
 * If a call to this object's is_online() method returns FALSE although
 * you are certain that the matching device is plugged, make sure that you did
 * call registerHub() at application initialization time.
 *
 * @param string $func : a string that uniquely characterizes the multi-sensor controller, for instance
 *         YTEMPIR1.multiSensController.
 *
 * @return YMultiSensController  a YMultiSensController object allowing you to drive the multi-sensor controller.
 */
function yFindMultiSensController(string $func): YMultiSensController
{
    return YMultiSensController::FindMultiSensController($func);
}

/**
 * Starts the enumeration of multi-sensor controllers currently accessible.
 * Use the method YMultiSensController::nextMultiSensController() to iterate on
 * next multi-sensor controllers.
 *
 * @return ?YMultiSensController  a pointer to a YMultiSensController object, corresponding to
 *         the first multi-sensor controller currently online, or a null pointer
 *         if there are none.
 */
function yFirstMultiSensController(): ?YMultiSensController
{
    return YMultiSensController::FirstMultiSensController();
}

//--- (end of YMultiSensController functions)

