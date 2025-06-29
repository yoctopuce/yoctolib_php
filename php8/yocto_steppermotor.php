<?php
/*********************************************************************
 *
 *  $Id: svn_id $
 *
 *  Implements YStepperMotor, the high-level API for StepperMotor functions
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

//--- (YStepperMotor return codes)
//--- (end of YStepperMotor return codes)
//--- (YStepperMotor definitions)
if (!defined('Y_MOTORSTATE_ABSENT')) {
    define('Y_MOTORSTATE_ABSENT', 0);
}
if (!defined('Y_MOTORSTATE_ALERT')) {
    define('Y_MOTORSTATE_ALERT', 1);
}
if (!defined('Y_MOTORSTATE_HI_Z')) {
    define('Y_MOTORSTATE_HI_Z', 2);
}
if (!defined('Y_MOTORSTATE_STOP')) {
    define('Y_MOTORSTATE_STOP', 3);
}
if (!defined('Y_MOTORSTATE_RUN')) {
    define('Y_MOTORSTATE_RUN', 4);
}
if (!defined('Y_MOTORSTATE_BATCH')) {
    define('Y_MOTORSTATE_BATCH', 5);
}
if (!defined('Y_MOTORSTATE_INVALID')) {
    define('Y_MOTORSTATE_INVALID', -1);
}
if (!defined('Y_STEPPING_MICROSTEP16')) {
    define('Y_STEPPING_MICROSTEP16', 0);
}
if (!defined('Y_STEPPING_MICROSTEP8')) {
    define('Y_STEPPING_MICROSTEP8', 1);
}
if (!defined('Y_STEPPING_MICROSTEP4')) {
    define('Y_STEPPING_MICROSTEP4', 2);
}
if (!defined('Y_STEPPING_HALFSTEP')) {
    define('Y_STEPPING_HALFSTEP', 3);
}
if (!defined('Y_STEPPING_FULLSTEP')) {
    define('Y_STEPPING_FULLSTEP', 4);
}
if (!defined('Y_STEPPING_INVALID')) {
    define('Y_STEPPING_INVALID', -1);
}
if (!defined('Y_DIAGS_INVALID')) {
    define('Y_DIAGS_INVALID', YAPI_INVALID_UINT);
}
if (!defined('Y_STEPPOS_INVALID')) {
    define('Y_STEPPOS_INVALID', YAPI_INVALID_DOUBLE);
}
if (!defined('Y_SPEED_INVALID')) {
    define('Y_SPEED_INVALID', YAPI_INVALID_DOUBLE);
}
if (!defined('Y_PULLINSPEED_INVALID')) {
    define('Y_PULLINSPEED_INVALID', YAPI_INVALID_DOUBLE);
}
if (!defined('Y_MAXACCEL_INVALID')) {
    define('Y_MAXACCEL_INVALID', YAPI_INVALID_DOUBLE);
}
if (!defined('Y_MAXSPEED_INVALID')) {
    define('Y_MAXSPEED_INVALID', YAPI_INVALID_DOUBLE);
}
if (!defined('Y_OVERCURRENT_INVALID')) {
    define('Y_OVERCURRENT_INVALID', YAPI_INVALID_UINT);
}
if (!defined('Y_TCURRSTOP_INVALID')) {
    define('Y_TCURRSTOP_INVALID', YAPI_INVALID_UINT);
}
if (!defined('Y_TCURRRUN_INVALID')) {
    define('Y_TCURRRUN_INVALID', YAPI_INVALID_UINT);
}
if (!defined('Y_ALERTMODE_INVALID')) {
    define('Y_ALERTMODE_INVALID', YAPI_INVALID_STRING);
}
if (!defined('Y_AUXMODE_INVALID')) {
    define('Y_AUXMODE_INVALID', YAPI_INVALID_STRING);
}
if (!defined('Y_AUXSIGNAL_INVALID')) {
    define('Y_AUXSIGNAL_INVALID', YAPI_INVALID_INT);
}
if (!defined('Y_COMMAND_INVALID')) {
    define('Y_COMMAND_INVALID', YAPI_INVALID_STRING);
}
//--- (end of YStepperMotor definitions)
    #--- (YStepperMotor yapiwrapper)

   #--- (end of YStepperMotor yapiwrapper)

//--- (YStepperMotor declaration)
//vvvv YStepperMotor.php

/**
 * YStepperMotor Class: stepper motor control interface
 *
 * The YStepperMotor class allows you to drive a stepper motor.
 */
class YStepperMotor extends YFunction
{
    const MOTORSTATE_ABSENT = 0;
    const MOTORSTATE_ALERT = 1;
    const MOTORSTATE_HI_Z = 2;
    const MOTORSTATE_STOP = 3;
    const MOTORSTATE_RUN = 4;
    const MOTORSTATE_BATCH = 5;
    const MOTORSTATE_INVALID = -1;
    const DIAGS_INVALID = YAPI::INVALID_UINT;
    const STEPPOS_INVALID = YAPI::INVALID_DOUBLE;
    const SPEED_INVALID = YAPI::INVALID_DOUBLE;
    const PULLINSPEED_INVALID = YAPI::INVALID_DOUBLE;
    const MAXACCEL_INVALID = YAPI::INVALID_DOUBLE;
    const MAXSPEED_INVALID = YAPI::INVALID_DOUBLE;
    const STEPPING_MICROSTEP16 = 0;
    const STEPPING_MICROSTEP8 = 1;
    const STEPPING_MICROSTEP4 = 2;
    const STEPPING_HALFSTEP = 3;
    const STEPPING_FULLSTEP = 4;
    const STEPPING_INVALID = -1;
    const OVERCURRENT_INVALID = YAPI::INVALID_UINT;
    const TCURRSTOP_INVALID = YAPI::INVALID_UINT;
    const TCURRRUN_INVALID = YAPI::INVALID_UINT;
    const ALERTMODE_INVALID = YAPI::INVALID_STRING;
    const AUXMODE_INVALID = YAPI::INVALID_STRING;
    const AUXSIGNAL_INVALID = YAPI::INVALID_INT;
    const COMMAND_INVALID = YAPI::INVALID_STRING;
    //--- (end of YStepperMotor declaration)

    //--- (YStepperMotor attributes)
    protected int $_motorState = self::MOTORSTATE_INVALID;     // StepperState
    protected int $_diags = self::DIAGS_INVALID;          // StepperDiags
    protected float $_stepPos = self::STEPPOS_INVALID;        // StepPos
    protected float $_speed = self::SPEED_INVALID;          // MeasureVal
    protected float $_pullinSpeed = self::PULLINSPEED_INVALID;    // MeasureVal
    protected float $_maxAccel = self::MAXACCEL_INVALID;       // MeasureVal
    protected float $_maxSpeed = self::MAXSPEED_INVALID;       // MeasureVal
    protected int $_stepping = self::STEPPING_INVALID;       // SteppingMode
    protected int $_overcurrent = self::OVERCURRENT_INVALID;    // UInt31
    protected int $_tCurrStop = self::TCURRSTOP_INVALID;      // UInt31
    protected int $_tCurrRun = self::TCURRRUN_INVALID;       // UInt31
    protected string $_alertMode = self::ALERTMODE_INVALID;      // AlertMode
    protected string $_auxMode = self::AUXMODE_INVALID;        // AuxMode
    protected int $_auxSignal = self::AUXSIGNAL_INVALID;      // Int
    protected string $_command = self::COMMAND_INVALID;        // Text

    //--- (end of YStepperMotor attributes)

    function __construct(string $str_func)
    {
        //--- (YStepperMotor constructor)
        parent::__construct($str_func);
        $this->_className = 'StepperMotor';

        //--- (end of YStepperMotor constructor)
    }

    //--- (YStepperMotor implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'motorState':
            $this->_motorState = intval($val);
            return 1;
        case 'diags':
            $this->_diags = intval($val);
            return 1;
        case 'stepPos':
            $this->_stepPos = $val / 16.0;
            return 1;
        case 'speed':
            $this->_speed = round($val / 65.536) / 1000.0;
            return 1;
        case 'pullinSpeed':
            $this->_pullinSpeed = round($val / 65.536) / 1000.0;
            return 1;
        case 'maxAccel':
            $this->_maxAccel = round($val / 65.536) / 1000.0;
            return 1;
        case 'maxSpeed':
            $this->_maxSpeed = round($val / 65.536) / 1000.0;
            return 1;
        case 'stepping':
            $this->_stepping = intval($val);
            return 1;
        case 'overcurrent':
            $this->_overcurrent = intval($val);
            return 1;
        case 'tCurrStop':
            $this->_tCurrStop = intval($val);
            return 1;
        case 'tCurrRun':
            $this->_tCurrRun = intval($val);
            return 1;
        case 'alertMode':
            $this->_alertMode = $val;
            return 1;
        case 'auxMode':
            $this->_auxMode = $val;
            return 1;
        case 'auxSignal':
            $this->_auxSignal = intval($val);
            return 1;
        case 'command':
            $this->_command = $val;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the motor working state.
     *
     * @return int  a value among YStepperMotor::MOTORSTATE_ABSENT, YStepperMotor::MOTORSTATE_ALERT,
     * YStepperMotor::MOTORSTATE_HI_Z, YStepperMotor::MOTORSTATE_STOP, YStepperMotor::MOTORSTATE_RUN and
     * YStepperMotor::MOTORSTATE_BATCH corresponding to the motor working state
     *
     * On failure, throws an exception or returns YStepperMotor::MOTORSTATE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_motorState(): int
    {
        // $res                    is a enumSTEPPERSTATE;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::MOTORSTATE_INVALID;
            }
        }
        $res = $this->_motorState;
        return $res;
    }

    /**
     * Returns the stepper motor controller diagnostics, as a bitmap.
     *
     * @return int  an integer corresponding to the stepper motor controller diagnostics, as a bitmap
     *
     * On failure, throws an exception or returns YStepperMotor::DIAGS_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_diags(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::DIAGS_INVALID;
            }
        }
        $res = $this->_diags;
        return $res;
    }

    /**
     * Changes the current logical motor position, measured in steps.
     * This command does not cause any motor move, as its purpose is only to set up
     * the origin of the position counter. The fractional part of the position,
     * that corresponds to the physical position of the rotor, is not changed.
     * To trigger a motor move, use methods moveTo() or moveRel()
     * instead.
     *
     * @param float $newval : a floating point number corresponding to the current logical motor position,
     * measured in steps
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_stepPos(float $newval): int
    {
        $rest_val = strval(round($newval * 100.0)/100.0);
        return $this->_setAttr("stepPos", $rest_val);
    }

    /**
     * Returns the current logical motor position, measured in steps.
     * The value may include a fractional part when micro-stepping is in use.
     *
     * @return float  a floating point number corresponding to the current logical motor position, measured in steps
     *
     * On failure, throws an exception or returns YStepperMotor::STEPPOS_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_stepPos(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::STEPPOS_INVALID;
            }
        }
        $res = $this->_stepPos;
        return $res;
    }

    /**
     * Returns current motor speed, measured in steps per second.
     * To change speed, use method changeSpeed().
     *
     * @return float  a floating point number corresponding to current motor speed, measured in steps per second
     *
     * On failure, throws an exception or returns YStepperMotor::SPEED_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_speed(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::SPEED_INVALID;
            }
        }
        $res = $this->_speed;
        return $res;
    }

    /**
     * Changes the motor speed immediately reachable from stop state, measured in steps per second.
     *
     * @param float $newval : a floating point number corresponding to the motor speed immediately
     * reachable from stop state, measured in steps per second
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_pullinSpeed(float $newval): int
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("pullinSpeed", $rest_val);
    }

    /**
     * Returns the motor speed immediately reachable from stop state, measured in steps per second.
     *
     * @return float  a floating point number corresponding to the motor speed immediately reachable from
     * stop state, measured in steps per second
     *
     * On failure, throws an exception or returns YStepperMotor::PULLINSPEED_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_pullinSpeed(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::PULLINSPEED_INVALID;
            }
        }
        $res = $this->_pullinSpeed;
        return $res;
    }

    /**
     * Changes the maximal motor acceleration, measured in steps per second^2.
     *
     * @param float $newval : a floating point number corresponding to the maximal motor acceleration,
     * measured in steps per second^2
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_maxAccel(float $newval): int
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("maxAccel", $rest_val);
    }

    /**
     * Returns the maximal motor acceleration, measured in steps per second^2.
     *
     * @return float  a floating point number corresponding to the maximal motor acceleration, measured in
     * steps per second^2
     *
     * On failure, throws an exception or returns YStepperMotor::MAXACCEL_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_maxAccel(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::MAXACCEL_INVALID;
            }
        }
        $res = $this->_maxAccel;
        return $res;
    }

    /**
     * Changes the maximal motor speed, measured in steps per second.
     *
     * @param float $newval : a floating point number corresponding to the maximal motor speed, measured
     * in steps per second
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_maxSpeed(float $newval): int
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("maxSpeed", $rest_val);
    }

    /**
     * Returns the maximal motor speed, measured in steps per second.
     *
     * @return float  a floating point number corresponding to the maximal motor speed, measured in steps per second
     *
     * On failure, throws an exception or returns YStepperMotor::MAXSPEED_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_maxSpeed(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::MAXSPEED_INVALID;
            }
        }
        $res = $this->_maxSpeed;
        return $res;
    }

    /**
     * Returns the stepping mode used to drive the motor.
     *
     * @return int  a value among YStepperMotor::STEPPING_MICROSTEP16, YStepperMotor::STEPPING_MICROSTEP8,
     * YStepperMotor::STEPPING_MICROSTEP4, YStepperMotor::STEPPING_HALFSTEP and
     * YStepperMotor::STEPPING_FULLSTEP corresponding to the stepping mode used to drive the motor
     *
     * On failure, throws an exception or returns YStepperMotor::STEPPING_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_stepping(): int
    {
        // $res                    is a enumSTEPPINGMODE;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::STEPPING_INVALID;
            }
        }
        $res = $this->_stepping;
        return $res;
    }

    /**
     * Changes the stepping mode used to drive the motor.
     *
     * @param int $newval : a value among YStepperMotor::STEPPING_MICROSTEP16,
     * YStepperMotor::STEPPING_MICROSTEP8, YStepperMotor::STEPPING_MICROSTEP4,
     * YStepperMotor::STEPPING_HALFSTEP and YStepperMotor::STEPPING_FULLSTEP corresponding to the stepping
     * mode used to drive the motor
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_stepping(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("stepping", $rest_val);
    }

    /**
     * Returns the overcurrent alert and emergency stop threshold, measured in mA.
     *
     * @return int  an integer corresponding to the overcurrent alert and emergency stop threshold, measured in mA
     *
     * On failure, throws an exception or returns YStepperMotor::OVERCURRENT_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_overcurrent(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::OVERCURRENT_INVALID;
            }
        }
        $res = $this->_overcurrent;
        return $res;
    }

    /**
     * Changes the overcurrent alert and emergency stop threshold, measured in mA.
     *
     * @param int $newval : an integer corresponding to the overcurrent alert and emergency stop
     * threshold, measured in mA
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_overcurrent(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("overcurrent", $rest_val);
    }

    /**
     * Returns the torque regulation current when the motor is stopped, measured in mA.
     *
     * @return int  an integer corresponding to the torque regulation current when the motor is stopped, measured in mA
     *
     * On failure, throws an exception or returns YStepperMotor::TCURRSTOP_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_tCurrStop(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::TCURRSTOP_INVALID;
            }
        }
        $res = $this->_tCurrStop;
        return $res;
    }

    /**
     * Changes the torque regulation current when the motor is stopped, measured in mA.
     *
     * @param int $newval : an integer corresponding to the torque regulation current when the motor is
     * stopped, measured in mA
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_tCurrStop(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("tCurrStop", $rest_val);
    }

    /**
     * Returns the torque regulation current when the motor is running, measured in mA.
     *
     * @return int  an integer corresponding to the torque regulation current when the motor is running, measured in mA
     *
     * On failure, throws an exception or returns YStepperMotor::TCURRRUN_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_tCurrRun(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::TCURRRUN_INVALID;
            }
        }
        $res = $this->_tCurrRun;
        return $res;
    }

    /**
     * Changes the torque regulation current when the motor is running, measured in mA.
     *
     * @param int $newval : an integer corresponding to the torque regulation current when the motor is
     * running, measured in mA
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_tCurrRun(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("tCurrRun", $rest_val);
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_alertMode(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::ALERTMODE_INVALID;
            }
        }
        $res = $this->_alertMode;
        return $res;
    }

    /**
     * @throws YAPI_Exception
     */
    public function set_alertMode(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("alertMode", $rest_val);
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_auxMode(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::AUXMODE_INVALID;
            }
        }
        $res = $this->_auxMode;
        return $res;
    }

    /**
     * @throws YAPI_Exception
     */
    public function set_auxMode(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("auxMode", $rest_val);
    }

    /**
     * Returns the current value of the signal generated on the auxiliary output.
     *
     * @return int  an integer corresponding to the current value of the signal generated on the auxiliary output
     *
     * On failure, throws an exception or returns YStepperMotor::AUXSIGNAL_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_auxSignal(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::AUXSIGNAL_INVALID;
            }
        }
        $res = $this->_auxSignal;
        return $res;
    }

    /**
     * Changes the value of the signal generated on the auxiliary output.
     * Acceptable values depend on the auxiliary output signal type configured.
     *
     * @param int $newval : an integer corresponding to the value of the signal generated on the auxiliary output
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_auxSignal(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("auxSignal", $rest_val);
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
     * Retrieves a stepper motor for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the stepper motor is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the stepper motor is
     * indeed online at a given time. In case of ambiguity when looking for
     * a stepper motor by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the stepper motor, for instance
     *         MyDevice.stepperMotor1.
     *
     * @return YStepperMotor  a YStepperMotor object allowing you to drive the stepper motor.
     */
    public static function FindStepperMotor(string $func): YStepperMotor
    {
        // $obj                    is a YStepperMotor;
        $obj = YFunction::_FindFromCache('StepperMotor', $func);
        if ($obj == null) {
            $obj = new YStepperMotor($func);
            YFunction::_AddToCache('StepperMotor', $func, $obj);
        }
        return $obj;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function sendCommand(string $command): int
    {
        // $id                     is a str;
        // $url                    is a str;
        // $retBin                 is a bin;
        // $res                    is a int;
        $id = $this->get_functionId();
        $id = substr($id, 12, 1);
        $url = sprintf('cmd.txt?%s=%s', $id, $command);
        //may throw an exception
        $retBin = $this->_download($url);
        $res = ord($retBin[0]);
        if ($res < 58) {
            if (!($res == 48)) return $this->_throw(YAPI::DEVICE_BUSY,'Motor command pipeline is full, try again later',YAPI::DEVICE_BUSY);
        } else {
            if (!($res == 48)) return $this->_throw(YAPI::IO_ERROR,'Motor command failed permanently',YAPI::IO_ERROR);
        }
        return YAPI::SUCCESS;
    }

    /**
     * Reinitialize the controller and clear all alert flags.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function reset(): int
    {
        return $this->set_command('Z');
    }

    /**
     * Starts the motor backward at the specified speed, to search for the motor home position.
     *
     * @param float $speed : desired speed, in steps per second.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function findHomePosition(float $speed): int
    {
        return $this->sendCommand(sprintf('H%d',intval(round(1000*$speed))));
    }

    /**
     * Starts the motor at a given speed. The time needed to reach the requested speed
     * will depend on the acceleration parameters configured for the motor.
     *
     * @param float $speed : desired speed, in steps per second. The minimal non-zero speed
     *         is 0.001 pulse per second.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function changeSpeed(float $speed): int
    {
        return $this->sendCommand(sprintf('R%d',intval(round(1000*$speed))));
    }

    /**
     * Starts the motor to reach a given absolute position. The time needed to reach the requested
     * position will depend on the acceleration and max speed parameters configured for
     * the motor.
     *
     * @param float $absPos : absolute position, measured in steps from the origin.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function moveTo(float $absPos): int
    {
        return $this->sendCommand(sprintf('M%d',intval(round(16*$absPos))));
    }

    /**
     * Starts the motor to reach a given relative position. The time needed to reach the requested
     * position will depend on the acceleration and max speed parameters configured for
     * the motor.
     *
     * @param float $relPos : relative position, measured in steps from the current position.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function moveRel(float $relPos): int
    {
        return $this->sendCommand(sprintf('m%d',intval(round(16*$relPos))));
    }

    /**
     * Starts the motor to reach a given relative position, keeping the speed under the
     * specified limit. The time needed to reach the requested position will depend on
     * the acceleration parameters configured for the motor.
     *
     * @param float $relPos : relative position, measured in steps from the current position.
     * @param float $maxSpeed : limit speed, in steps per second.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function moveRelSlow(float $relPos, float $maxSpeed): int
    {
        return $this->sendCommand(sprintf('m%d@%d',intval(round(16*$relPos)),intval(round(1000*$maxSpeed))));
    }

    /**
     * Keep the motor in the same state for the specified amount of time, before processing next command.
     *
     * @param int $waitMs : wait time, specified in milliseconds.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function pause(int $waitMs): int
    {
        return $this->sendCommand(sprintf('_%d',$waitMs));
    }

    /**
     * Stops the motor with an emergency alert, without taking any additional precaution.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function emergencyStop(): int
    {
        return $this->set_command('!');
    }

    /**
     * Move one step in the direction opposite the direction set when the most recent alert was raised.
     * The move occurs even if the system is still in alert mode (end switch depressed). Caution.
     * use this function with great care as it may cause mechanical damages !
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function alertStepOut(): int
    {
        return $this->set_command('.');
    }

    /**
     * Move one single step in the selected direction without regards to end switches.
     * The move occurs even if the system is still in alert mode (end switch depressed). Caution.
     * use this function with great care as it may cause mechanical damages !
     *
     * @param int $dir : Value +1 or -1, according to the desired direction of the move
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function alertStepDir(int $dir): int
    {
        if (!($dir != 0)) return $this->_throw(YAPI::INVALID_ARGUMENT,'direction must be +1 or -1',YAPI::INVALID_ARGUMENT);
        if ($dir > 0) {
            return $this->set_command('.+');
        }
        return $this->set_command('.-');
    }

    /**
     * Stops the motor smoothly as soon as possible, without waiting for ongoing move completion.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function abortAndBrake(): int
    {
        return $this->set_command('B');
    }

    /**
     * Turn the controller into Hi-Z mode immediately, without waiting for ongoing move completion.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function abortAndHiZ(): int
    {
        return $this->set_command('z');
    }

    /**
     * @throws YAPI_Exception
     */
    public function motorState(): int
{
    return $this->get_motorState();
}

    /**
     * @throws YAPI_Exception
     */
    public function diags(): int
{
    return $this->get_diags();
}

    /**
     * @throws YAPI_Exception
     */
    public function setStepPos(float $newval): int
{
    return $this->set_stepPos($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function stepPos(): float
{
    return $this->get_stepPos();
}

    /**
     * @throws YAPI_Exception
     */
    public function speed(): float
{
    return $this->get_speed();
}

    /**
     * @throws YAPI_Exception
     */
    public function setPullinSpeed(float $newval): int
{
    return $this->set_pullinSpeed($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function pullinSpeed(): float
{
    return $this->get_pullinSpeed();
}

    /**
     * @throws YAPI_Exception
     */
    public function setMaxAccel(float $newval): int
{
    return $this->set_maxAccel($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function maxAccel(): float
{
    return $this->get_maxAccel();
}

    /**
     * @throws YAPI_Exception
     */
    public function setMaxSpeed(float $newval): int
{
    return $this->set_maxSpeed($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function maxSpeed(): float
{
    return $this->get_maxSpeed();
}

    /**
     * @throws YAPI_Exception
     */
    public function stepping(): int
{
    return $this->get_stepping();
}

    /**
     * @throws YAPI_Exception
     */
    public function setStepping(int $newval): int
{
    return $this->set_stepping($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function overcurrent(): int
{
    return $this->get_overcurrent();
}

    /**
     * @throws YAPI_Exception
     */
    public function setOvercurrent(int $newval): int
{
    return $this->set_overcurrent($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function tCurrStop(): int
{
    return $this->get_tCurrStop();
}

    /**
     * @throws YAPI_Exception
     */
    public function setTCurrStop(int $newval): int
{
    return $this->set_tCurrStop($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function tCurrRun(): int
{
    return $this->get_tCurrRun();
}

    /**
     * @throws YAPI_Exception
     */
    public function setTCurrRun(int $newval): int
{
    return $this->set_tCurrRun($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function alertMode(): string
{
    return $this->get_alertMode();
}

    /**
     * @throws YAPI_Exception
     */
    public function setAlertMode(string $newval): int
{
    return $this->set_alertMode($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function auxMode(): string
{
    return $this->get_auxMode();
}

    /**
     * @throws YAPI_Exception
     */
    public function setAuxMode(string $newval): int
{
    return $this->set_auxMode($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function auxSignal(): int
{
    return $this->get_auxSignal();
}

    /**
     * @throws YAPI_Exception
     */
    public function setAuxSignal(int $newval): int
{
    return $this->set_auxSignal($newval);
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
     * Continues the enumeration of stepper motors started using yFirstStepperMotor().
     * Caution: You can't make any assumption about the returned stepper motors order.
     * If you want to find a specific a stepper motor, use StepperMotor.findStepperMotor()
     * and a hardwareID or a logical name.
     *
     * @return ?YStepperMotor  a pointer to a YStepperMotor object, corresponding to
     *         a stepper motor currently online, or a null pointer
     *         if there are no more stepper motors to enumerate.
     */
    public function nextStepperMotor(): ?YStepperMotor
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindStepperMotor($next_hwid);
    }

    /**
     * Starts the enumeration of stepper motors currently accessible.
     * Use the method YStepperMotor::nextStepperMotor() to iterate on
     * next stepper motors.
     *
     * @return ?YStepperMotor  a pointer to a YStepperMotor object, corresponding to
     *         the first stepper motor currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstStepperMotor(): ?YStepperMotor
    {
        $next_hwid = YAPI::getFirstHardwareId('StepperMotor');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindStepperMotor($next_hwid);
    }

    //--- (end of YStepperMotor implementation)

}
//^^^^ YStepperMotor.php

//--- (YStepperMotor functions)

/**
 * Retrieves a stepper motor for a given identifier.
 * The identifier can be specified using several formats:
 *
 * - FunctionLogicalName
 * - ModuleSerialNumber.FunctionIdentifier
 * - ModuleSerialNumber.FunctionLogicalName
 * - ModuleLogicalName.FunctionIdentifier
 * - ModuleLogicalName.FunctionLogicalName
 *
 *
 * This function does not require that the stepper motor is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method isOnline() to test if the stepper motor is
 * indeed online at a given time. In case of ambiguity when looking for
 * a stepper motor by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 *
 * If a call to this object's is_online() method returns FALSE although
 * you are certain that the matching device is plugged, make sure that you did
 * call registerHub() at application initialization time.
 *
 * @param string $func : a string that uniquely characterizes the stepper motor, for instance
 *         MyDevice.stepperMotor1.
 *
 * @return YStepperMotor  a YStepperMotor object allowing you to drive the stepper motor.
 */
function yFindStepperMotor(string $func): YStepperMotor
{
    return YStepperMotor::FindStepperMotor($func);
}

/**
 * Starts the enumeration of stepper motors currently accessible.
 * Use the method YStepperMotor::nextStepperMotor() to iterate on
 * next stepper motors.
 *
 * @return ?YStepperMotor  a pointer to a YStepperMotor object, corresponding to
 *         the first stepper motor currently online, or a null pointer
 *         if there are none.
 */
function yFirstStepperMotor(): ?YStepperMotor
{
    return YStepperMotor::FirstStepperMotor();
}

//--- (end of YStepperMotor functions)

