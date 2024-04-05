<?php
/*********************************************************************
 *
 *  $Id: svn_id $
 *
 *  Implements YSdi12Port, the high-level API for Sdi12Port functions
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

//--- (generated code: YSdi12SnoopingRecord definitions)
//--- (end of generated code: YSdi12SnoopingRecord definitions)
    #--- (generated code: YSdi12SnoopingRecord yapiwrapper)

   #--- (end of generated code: YSdi12SnoopingRecord yapiwrapper)

//--- (generated code: YSdi12SnoopingRecord declaration)
//vvvv YSdi12SnoopingRecord.php

/**
 * YSdi12SnoopingRecord Class: Intercepted SDI12 message description, returned by sdi12Port.snoopMessages method
 *
 *
 */
class YSdi12SnoopingRecord
{
    //--- (end of generated code: YSdi12SnoopingRecord declaration)

    //--- (generated code: YSdi12SnoopingRecord attributes)
    protected $_tim = 0;                            // int
    protected $_pos = 0;                            // int
    protected $_dir = 0;                            // int
    protected $_msg = "";                           // str

    //--- (end of generated code: YSdi12SnoopingRecord attributes)

    function __construct(string $str_func)
    {
        //--- (generated code: YSdi12SnoopingRecord constructor)
        //--- (end of generated code: YSdi12SnoopingRecord constructor)

        $loadval = json_decode($str_json, true);
        if (array_key_exists('t', $loadval)) {
            $this->_tim = $loadval['t'];
        }
        if (array_key_exists('p', $loadval)) {
            $this->_pos = $loadval['p'];
        }
        if (array_key_exists('m', $loadval)) {
            $this->_dir = $loadval['m'][0] == '<' ? 1 : 0;
            $this->_msg = substr($loadval['m'], 1);
        }
    }

    //--- (generated code: YSdi12SnoopingRecord implementation)

    /**
     * Returns the elapsed time, in ms, since the beginning of the preceding message.
     *
     * @return int  the elapsed time, in ms, since the beginning of the preceding message.
     */
    public function get_time(): int
    {
        return $this->_tim;
    }

    /**
     * Returns the absolute position of the message end.
     *
     * @return int  the absolute position of the message end.
     */
    public function get_pos(): int
    {
        return $this->_pos;
    }

    /**
     * Returns the message direction (RX=0, TX=1).
     *
     * @return int  the message direction (RX=0, TX=1).
     */
    public function get_direction(): int
    {
        return $this->_dir;
    }

    /**
     * Returns the message content.
     *
     * @return string  the message content.
     */
    public function get_message(): string
    {
        return $this->_msg;
    }

    //--- (end of generated code: YSdi12SnoopingRecord implementation)

//--- (generated code: YSdi12SensorInfo definitions)
//--- (end of generated code: YSdi12SensorInfo definitions)
    #--- (generated code: YSdi12SensorInfo yapiwrapper)

   #--- (end of generated code: YSdi12SensorInfo yapiwrapper)

//--- (generated code: YSdi12SensorInfo declaration)
//vvvv YSdi12SensorInfo.php

/**
 * YSdi12SensorInfo Class: Description of a discovered SDI12 sensor, returned by
 * sdi12Port.discoverSingleSensor and sdi12Port.discoverAllSensors methods
 *
 *
 */
class YSdi12SensorInfo
{
    //--- (end of generated code: YSdi12SensorInfo declaration)

    //--- (generated code: YSdi12SensorInfo attributes)
    protected $_sdi12Port = null;                         // YSdi12Port
    protected $_isValid = false;                        // bool
    protected $_addr = "";                           // str
    protected $_proto = "";                           // str
    protected $_mfg = "";                           // str
    protected $_model = "";                           // str
    protected $_ver = "";                           // str
    protected $_sn = "";                           // str
    protected $_valuesDesc = [];                           // strArrArr

    //--- (end of generated code: YSdi12SensorInfo attributes)

    function __construct(string $str_func)
    {
        //--- (generated code: YSdi12SensorInfo constructor)
        //--- (end of generated code: YSdi12SensorInfo constructor)
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function _throw(YRETCODE $errcode, string $msg,  $retVal)
    {
        return $this->_sdi12Port->_throw($errcode,$msg,$retVal);
    }

    //--- (generated code: YSdi12SensorInfo implementation)

    /**
     * Returns the sensor state.
     *
     * @return boolean  the sensor state.
     */
    public function isValid(): bool
    {
        return $this->_isValid;
    }

    /**
     * Returns the sensor address.
     *
     * @return string  the sensor address.
     */
    public function get_sensorAddress(): string
    {
        return $this->_addr;
    }

    /**
     * Returns the compatible SDI-12 version of the sensor.
     *
     * @return string  the compatible SDI-12 version of the sensor.
     */
    public function get_sensorProtocol(): string
    {
        return $this->_proto;
    }

    /**
     * Returns the sensor vendor identification.
     *
     * @return string  the sensor vendor identification.
     */
    public function get_sensorVendor(): string
    {
        return $this->_mfg;
    }

    /**
     * Returns the sensor model number.
     *
     * @return string  the sensor model number.
     */
    public function get_sensorModel(): string
    {
        return $this->_model;
    }

    /**
     * Returns the sensor version.
     *
     * @return string  the sensor version.
     */
    public function get_sensorVersion(): string
    {
        return $this->_ver;
    }

    /**
     * Returns the sensor serial number.
     *
     * @return string  the sensor serial number.
     */
    public function get_sensorSerial(): string
    {
        return $this->_sn;
    }

    /**
     * Returns the number of sensor measurements.
     * This function only works if the sensor is in version 1.4 SDI-12
     * and supports metadata commands.
     *
     * @return int  the number of sensor measurements.
     */
    public function get_measureCount(): int
    {
        return sizeof($this->_valuesDesc);
    }

    /**
     * Returns the sensor measurement command.
     * This function only works if the sensor is in version 1.4 SDI-12
     * and supports metadata commands.
     *
     * @param int $measureIndex : measurement index
     *
     * @return string  the sensor measurement command.
     *         On failure, throws an exception or returns an empty string.
     * @throws YAPI_Exception on error
     */
    public function get_measureCommand(int $measureIndex): string
    {
        if (!($measureIndex < sizeof($this->_valuesDesc))) return $this->_throw( YAPI::INVALID_ARGUMENT, 'Invalid measure index','');
        return $this->_valuesDesc[$measureIndex][0];
    }

    /**
     * Returns sensor measurement position.
     * This function only works if the sensor is in version 1.4 SDI-12
     * and supports metadata commands.
     *
     * @param int $measureIndex : measurement index
     *
     * @return int  the sensor measurement command.
     *         On failure, throws an exception or returns 0.
     * @throws YAPI_Exception on error
     */
    public function get_measurePosition(int $measureIndex): int
    {
        if (!($measureIndex < sizeof($this->_valuesDesc))) return $this->_throw( YAPI::INVALID_ARGUMENT, 'Invalid measure index',0);
        return intVal($this->_valuesDesc[$measureIndex][2]);
    }

    /**
     * Returns the measured value symbol.
     * This function only works if the sensor is in version 1.4 SDI-12
     * and supports metadata commands.
     *
     * @param int $measureIndex : measurement index
     *
     * @return string  the sensor measurement command.
     *         On failure, throws an exception or returns an empty string.
     * @throws YAPI_Exception on error
     */
    public function get_measureSymbol(int $measureIndex): string
    {
        if (!($measureIndex < sizeof($this->_valuesDesc))) return $this->_throw( YAPI::INVALID_ARGUMENT, 'Invalid measure index','');
        return $this->_valuesDesc[$measureIndex][3];
    }

    /**
     * Returns the unit of the measured value.
     * This function only works if the sensor is in version 1.4 SDI-12
     * and supports metadata commands.
     *
     * @param int $measureIndex : measurement index
     *
     * @return string  the sensor measurement command.
     *         On failure, throws an exception or returns an empty string.
     * @throws YAPI_Exception on error
     */
    public function get_measureUnit(int $measureIndex): string
    {
        if (!($measureIndex < sizeof($this->_valuesDesc))) return $this->_throw( YAPI::INVALID_ARGUMENT, 'Invalid measure index','');
        return $this->_valuesDesc[$measureIndex][4];
    }

    /**
     * Returns the description of the measured value.
     * This function only works if the sensor is in version 1.4 SDI-12
     * and supports metadata commands.
     *
     * @param int $measureIndex : measurement index
     *
     * @return string  the sensor measurement command.
     *         On failure, throws an exception or returns an empty string.
     * @throws YAPI_Exception on error
     */
    public function get_measureDescription(int $measureIndex): string
    {
        if (!($measureIndex < sizeof($this->_valuesDesc))) return $this->_throw( YAPI::INVALID_ARGUMENT, 'Invalid measure index','');
        return $this->_valuesDesc[$measureIndex][5];
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_typeMeasure(): array
    {
        return $this->_valuesDesc;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function _parseInfoStr(string $infoStr)
    {
        // $errmsg                 is a str;

        if (strlen($infoStr) > 1) {
            if (substr($infoStr,  0, 2) == 'ER') {
                $errmsg = substr($infoStr,  2, strlen($infoStr)-2);
                $this->_addr = $errmsg;
                $this->_proto = $errmsg;
                $this->_mfg = $errmsg;
                $this->_model = $errmsg;
                $this->_ver = $errmsg;
                $this->_sn = $errmsg;
                $this->_isValid = false;
            } else {
                $this->_addr = substr($infoStr,  0, 1);
                $this->_proto = substr($infoStr,  1, 2);
                $this->_mfg = substr($infoStr,  3, 8);
                $this->_model = substr($infoStr,  11, 6);
                $this->_ver = substr($infoStr,  17, 3);
                $this->_sn = substr($infoStr,  20, strlen($infoStr)-20);
                $this->_isValid = true;
            }
        }
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function _queryValueInfo()
    {
        $val = [];              // strArrArr;
        $data = [];             // strArr;
        // $infoNbVal              is a str;
        // $cmd                    is a str;
        // $infoVal                is a str;
        // $value                  is a str;
        // $nbVal                  is a int;
        // $k                      is a int;
        // $i                      is a int;
        // $j                      is a int;
        $listVal = [];          // strArr;
        // $size                   is a int;

        $k = 0;
        $size = 4;
        while ($k < 10) {
            $infoNbVal = $this->_sdi12Port->querySdi12($this->_addr, sprintf('IM%d', $k), 5000);
            if (strlen($infoNbVal) > 1) {
                $value = substr($infoNbVal,  4, strlen($infoNbVal)-4);
                $nbVal = intVal($value);
                if ($nbVal != 0) {
                    while (sizeof($val) > 0) {
                        array_pop($val);
                    };
                    $i = 0;
                    while ($i < $nbVal) {
                        $cmd = sprintf('IM%d_00%d', $k, $i+1);
                        $infoVal = $this->_sdi12Port->querySdi12($this->_addr, $cmd, 5000);
                        $data = explode(';', $infoVal);
                        $data = explode(',', $data[0]);
                        while (sizeof($listVal) > 0) {
                            array_pop($listVal);
                        };
                        $listVal[] = sprintf('M%d', $k);
                        $listVal[] = $i+1;
                        $j = 0;
                        while (sizeof($data) < $size) {
                            $data[] = '';
                        }
                        while ($j < sizeof($data)) {
                            $listVal[] = $data[$j];
                            $j = $j + 1;
                        }
                        $val[] = $listVal;
                        $i = $i + 1;
                    }
                }
            }
            $k = $k + 1;
        }
        $this->_valuesDesc = $val;
    }

    //--- (end of generated code: YSdi12SensorInfo implementation)

//--- (generated code: YSdi12Port return codes)
//--- (end of generated code: YSdi12Port return codes)
//--- (generated code: YSdi12Port definitions)
if (!defined('Y_VOLTAGELEVEL_OFF')) {
    define('Y_VOLTAGELEVEL_OFF', 0);
}
if (!defined('Y_VOLTAGELEVEL_TTL3V')) {
    define('Y_VOLTAGELEVEL_TTL3V', 1);
}
if (!defined('Y_VOLTAGELEVEL_TTL3VR')) {
    define('Y_VOLTAGELEVEL_TTL3VR', 2);
}
if (!defined('Y_VOLTAGELEVEL_TTL5V')) {
    define('Y_VOLTAGELEVEL_TTL5V', 3);
}
if (!defined('Y_VOLTAGELEVEL_TTL5VR')) {
    define('Y_VOLTAGELEVEL_TTL5VR', 4);
}
if (!defined('Y_VOLTAGELEVEL_RS232')) {
    define('Y_VOLTAGELEVEL_RS232', 5);
}
if (!defined('Y_VOLTAGELEVEL_RS485')) {
    define('Y_VOLTAGELEVEL_RS485', 6);
}
if (!defined('Y_VOLTAGELEVEL_TTL1V8')) {
    define('Y_VOLTAGELEVEL_TTL1V8', 7);
}
if (!defined('Y_VOLTAGELEVEL_SDI12')) {
    define('Y_VOLTAGELEVEL_SDI12', 8);
}
if (!defined('Y_VOLTAGELEVEL_INVALID')) {
    define('Y_VOLTAGELEVEL_INVALID', -1);
}
if (!defined('Y_RXCOUNT_INVALID')) {
    define('Y_RXCOUNT_INVALID', YAPI_INVALID_UINT);
}
if (!defined('Y_TXCOUNT_INVALID')) {
    define('Y_TXCOUNT_INVALID', YAPI_INVALID_UINT);
}
if (!defined('Y_ERRCOUNT_INVALID')) {
    define('Y_ERRCOUNT_INVALID', YAPI_INVALID_UINT);
}
if (!defined('Y_RXMSGCOUNT_INVALID')) {
    define('Y_RXMSGCOUNT_INVALID', YAPI_INVALID_UINT);
}
if (!defined('Y_TXMSGCOUNT_INVALID')) {
    define('Y_TXMSGCOUNT_INVALID', YAPI_INVALID_UINT);
}
if (!defined('Y_LASTMSG_INVALID')) {
    define('Y_LASTMSG_INVALID', YAPI_INVALID_STRING);
}
if (!defined('Y_CURRENTJOB_INVALID')) {
    define('Y_CURRENTJOB_INVALID', YAPI_INVALID_STRING);
}
if (!defined('Y_STARTUPJOB_INVALID')) {
    define('Y_STARTUPJOB_INVALID', YAPI_INVALID_STRING);
}
if (!defined('Y_JOBMAXTASK_INVALID')) {
    define('Y_JOBMAXTASK_INVALID', YAPI_INVALID_UINT);
}
if (!defined('Y_JOBMAXSIZE_INVALID')) {
    define('Y_JOBMAXSIZE_INVALID', YAPI_INVALID_UINT);
}
if (!defined('Y_COMMAND_INVALID')) {
    define('Y_COMMAND_INVALID', YAPI_INVALID_STRING);
}
if (!defined('Y_PROTOCOL_INVALID')) {
    define('Y_PROTOCOL_INVALID', YAPI_INVALID_STRING);
}
if (!defined('Y_SERIALMODE_INVALID')) {
    define('Y_SERIALMODE_INVALID', YAPI_INVALID_STRING);
}
//--- (end of generated code: YSdi12Port definitions)
    #--- (generated code: YSdi12Port yapiwrapper)

   #--- (end of generated code: YSdi12Port yapiwrapper)

//--- (generated code: YSdi12Port declaration)
//vvvv YSdi12Port.php

/**
 * YSdi12Port Class: SDI12 port control interface
 *
 * The YSdi12Port class allows you to fully drive a Yoctopuce SDI12 port.
 * It can be used to send and receive data, and to configure communication
 * parameters (baud rate, bit count, parity, flow control and protocol).
 * Note that Yoctopuce SDI12 ports are not exposed as virtual COM ports.
 * They are meant to be used in the same way as all Yoctopuce devices.
 */
class YSdi12Port extends YFunction
{
    const RXCOUNT_INVALID = YAPI::INVALID_UINT;
    const TXCOUNT_INVALID = YAPI::INVALID_UINT;
    const ERRCOUNT_INVALID = YAPI::INVALID_UINT;
    const RXMSGCOUNT_INVALID = YAPI::INVALID_UINT;
    const TXMSGCOUNT_INVALID = YAPI::INVALID_UINT;
    const LASTMSG_INVALID = YAPI::INVALID_STRING;
    const CURRENTJOB_INVALID = YAPI::INVALID_STRING;
    const STARTUPJOB_INVALID = YAPI::INVALID_STRING;
    const JOBMAXTASK_INVALID = YAPI::INVALID_UINT;
    const JOBMAXSIZE_INVALID = YAPI::INVALID_UINT;
    const COMMAND_INVALID = YAPI::INVALID_STRING;
    const PROTOCOL_INVALID = YAPI::INVALID_STRING;
    const VOLTAGELEVEL_OFF = 0;
    const VOLTAGELEVEL_TTL3V = 1;
    const VOLTAGELEVEL_TTL3VR = 2;
    const VOLTAGELEVEL_TTL5V = 3;
    const VOLTAGELEVEL_TTL5VR = 4;
    const VOLTAGELEVEL_RS232 = 5;
    const VOLTAGELEVEL_RS485 = 6;
    const VOLTAGELEVEL_TTL1V8 = 7;
    const VOLTAGELEVEL_SDI12 = 8;
    const VOLTAGELEVEL_INVALID = -1;
    const SERIALMODE_INVALID = YAPI::INVALID_STRING;
    //--- (end of generated code: YSdi12Port declaration)

    //--- (generated code: YSdi12Port attributes)
    protected $_rxCount = self::RXCOUNT_INVALID;        // UInt31
    protected $_txCount = self::TXCOUNT_INVALID;        // UInt31
    protected $_errCount = self::ERRCOUNT_INVALID;       // UInt31
    protected $_rxMsgCount = self::RXMSGCOUNT_INVALID;     // UInt31
    protected $_txMsgCount = self::TXMSGCOUNT_INVALID;     // UInt31
    protected $_lastMsg = self::LASTMSG_INVALID;        // Text
    protected $_currentJob = self::CURRENTJOB_INVALID;     // Text
    protected $_startupJob = self::STARTUPJOB_INVALID;     // Text
    protected $_jobMaxTask = self::JOBMAXTASK_INVALID;     // UInt31
    protected $_jobMaxSize = self::JOBMAXSIZE_INVALID;     // UInt31
    protected $_command = self::COMMAND_INVALID;        // Text
    protected $_protocol = self::PROTOCOL_INVALID;       // Protocol
    protected $_voltageLevel = self::VOLTAGELEVEL_INVALID;   // SerialVoltageLevel
    protected $_serialMode = self::SERIALMODE_INVALID;     // SerialMode
    protected $_rxptr = 0;                            // int
    protected $_rxbuff = "";                           // bin
    protected $_rxbuffptr = 0;                            // int
    protected $_eventPos = 0;                            // int

    //--- (end of generated code: YSdi12Port attributes)

    function __construct(string $str_func)
    {
        //--- (generated code: YSdi12Port constructor)
        parent::__construct($str_func);
        $this->_className = 'Sdi12Port';

        //--- (end of generated code: YSdi12Port constructor)
    }

    //--- (generated code: YSdi12Port implementation)

    function _parseAttr(string $name,  $val): int
    {
        switch ($name) {
        case 'rxCount':
            $this->_rxCount = intval($val);
            return 1;
        case 'txCount':
            $this->_txCount = intval($val);
            return 1;
        case 'errCount':
            $this->_errCount = intval($val);
            return 1;
        case 'rxMsgCount':
            $this->_rxMsgCount = intval($val);
            return 1;
        case 'txMsgCount':
            $this->_txMsgCount = intval($val);
            return 1;
        case 'lastMsg':
            $this->_lastMsg = $val;
            return 1;
        case 'currentJob':
            $this->_currentJob = $val;
            return 1;
        case 'startupJob':
            $this->_startupJob = $val;
            return 1;
        case 'jobMaxTask':
            $this->_jobMaxTask = intval($val);
            return 1;
        case 'jobMaxSize':
            $this->_jobMaxSize = intval($val);
            return 1;
        case 'command':
            $this->_command = $val;
            return 1;
        case 'protocol':
            $this->_protocol = $val;
            return 1;
        case 'voltageLevel':
            $this->_voltageLevel = intval($val);
            return 1;
        case 'serialMode':
            $this->_serialMode = $val;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the total number of bytes received since last reset.
     *
     * @return int  an integer corresponding to the total number of bytes received since last reset
     *
     * On failure, throws an exception or returns YSdi12Port::RXCOUNT_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_rxCount(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::RXCOUNT_INVALID;
            }
        }
        $res = $this->_rxCount;
        return $res;
    }

    /**
     * Returns the total number of bytes transmitted since last reset.
     *
     * @return int  an integer corresponding to the total number of bytes transmitted since last reset
     *
     * On failure, throws an exception or returns YSdi12Port::TXCOUNT_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_txCount(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::TXCOUNT_INVALID;
            }
        }
        $res = $this->_txCount;
        return $res;
    }

    /**
     * Returns the total number of communication errors detected since last reset.
     *
     * @return int  an integer corresponding to the total number of communication errors detected since last reset
     *
     * On failure, throws an exception or returns YSdi12Port::ERRCOUNT_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_errCount(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::ERRCOUNT_INVALID;
            }
        }
        $res = $this->_errCount;
        return $res;
    }

    /**
     * Returns the total number of messages received since last reset.
     *
     * @return int  an integer corresponding to the total number of messages received since last reset
     *
     * On failure, throws an exception or returns YSdi12Port::RXMSGCOUNT_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_rxMsgCount(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::RXMSGCOUNT_INVALID;
            }
        }
        $res = $this->_rxMsgCount;
        return $res;
    }

    /**
     * Returns the total number of messages send since last reset.
     *
     * @return int  an integer corresponding to the total number of messages send since last reset
     *
     * On failure, throws an exception or returns YSdi12Port::TXMSGCOUNT_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_txMsgCount(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::TXMSGCOUNT_INVALID;
            }
        }
        $res = $this->_txMsgCount;
        return $res;
    }

    /**
     * Returns the latest message fully received.
     *
     * @return string  a string corresponding to the latest message fully received
     *
     * On failure, throws an exception or returns YSdi12Port::LASTMSG_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_lastMsg(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::LASTMSG_INVALID;
            }
        }
        $res = $this->_lastMsg;
        return $res;
    }

    /**
     * Returns the name of the job file currently in use.
     *
     * @return string  a string corresponding to the name of the job file currently in use
     *
     * On failure, throws an exception or returns YSdi12Port::CURRENTJOB_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_currentJob(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::CURRENTJOB_INVALID;
            }
        }
        $res = $this->_currentJob;
        return $res;
    }

    /**
     * Selects a job file to run immediately. If an empty string is
     * given as argument, stops running current job file.
     *
     * @param string $newval : a string
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_currentJob(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("currentJob", $rest_val);
    }

    /**
     * Returns the job file to use when the device is powered on.
     *
     * @return string  a string corresponding to the job file to use when the device is powered on
     *
     * On failure, throws an exception or returns YSdi12Port::STARTUPJOB_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_startupJob(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::STARTUPJOB_INVALID;
            }
        }
        $res = $this->_startupJob;
        return $res;
    }

    /**
     * Changes the job to use when the device is powered on.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param string $newval : a string corresponding to the job to use when the device is powered on
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_startupJob(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("startupJob", $rest_val);
    }

    /**
     * Returns the maximum number of tasks in a job that the device can handle.
     *
     * @return int  an integer corresponding to the maximum number of tasks in a job that the device can handle
     *
     * On failure, throws an exception or returns YSdi12Port::JOBMAXTASK_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_jobMaxTask(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration == 0) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::JOBMAXTASK_INVALID;
            }
        }
        $res = $this->_jobMaxTask;
        return $res;
    }

    /**
     * Returns maximum size allowed for job files.
     *
     * @return int  an integer corresponding to maximum size allowed for job files
     *
     * On failure, throws an exception or returns YSdi12Port::JOBMAXSIZE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_jobMaxSize(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration == 0) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::JOBMAXSIZE_INVALID;
            }
        }
        $res = $this->_jobMaxSize;
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
     * Returns the type of protocol used over the serial line, as a string.
     * Possible values are "Line" for ASCII messages separated by CR and/or LF,
     * "Frame:[timeout]ms" for binary messages separated by a delay time,
     * "Char" for a continuous ASCII stream or
     * "Byte" for a continuous binary stream.
     *
     * @return string  a string corresponding to the type of protocol used over the serial line, as a string
     *
     * On failure, throws an exception or returns YSdi12Port::PROTOCOL_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_protocol(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::PROTOCOL_INVALID;
            }
        }
        $res = $this->_protocol;
        return $res;
    }

    /**
     * Changes the type of protocol used over the serial line.
     * Possible values are "Line" for ASCII messages separated by CR and/or LF,
     * "Frame:[timeout]ms" for binary messages separated by a delay time,
     * "Char" for a continuous ASCII stream or
     * "Byte" for a continuous binary stream.
     * The suffix "/[wait]ms" can be added to reduce the transmit rate so that there
     * is always at lest the specified number of milliseconds between each bytes sent.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param string $newval : a string corresponding to the type of protocol used over the serial line
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_protocol(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("protocol", $rest_val);
    }

    /**
     * Returns the voltage level used on the serial line.
     *
     * @return int  a value among YSdi12Port::VOLTAGELEVEL_OFF, YSdi12Port::VOLTAGELEVEL_TTL3V,
     * YSdi12Port::VOLTAGELEVEL_TTL3VR, YSdi12Port::VOLTAGELEVEL_TTL5V, YSdi12Port::VOLTAGELEVEL_TTL5VR,
     * YSdi12Port::VOLTAGELEVEL_RS232, YSdi12Port::VOLTAGELEVEL_RS485, YSdi12Port::VOLTAGELEVEL_TTL1V8 and
     * YSdi12Port::VOLTAGELEVEL_SDI12 corresponding to the voltage level used on the serial line
     *
     * On failure, throws an exception or returns YSdi12Port::VOLTAGELEVEL_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_voltageLevel(): int
    {
        // $res                    is a enumSERIALVOLTAGELEVEL;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::VOLTAGELEVEL_INVALID;
            }
        }
        $res = $this->_voltageLevel;
        return $res;
    }

    /**
     * Changes the voltage type used on the serial line. Valid
     * values  will depend on the Yoctopuce device model featuring
     * the serial port feature.  Check your device documentation
     * to find out which values are valid for that specific model.
     * Trying to set an invalid value will have no effect.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param int $newval : a value among YSdi12Port::VOLTAGELEVEL_OFF, YSdi12Port::VOLTAGELEVEL_TTL3V,
     * YSdi12Port::VOLTAGELEVEL_TTL3VR, YSdi12Port::VOLTAGELEVEL_TTL5V, YSdi12Port::VOLTAGELEVEL_TTL5VR,
     * YSdi12Port::VOLTAGELEVEL_RS232, YSdi12Port::VOLTAGELEVEL_RS485, YSdi12Port::VOLTAGELEVEL_TTL1V8 and
     * YSdi12Port::VOLTAGELEVEL_SDI12 corresponding to the voltage type used on the serial line
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_voltageLevel(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("voltageLevel", $rest_val);
    }

    /**
     * Returns the serial port communication parameters, as a string such as
     * "1200,7E1,Simplex". The string includes the baud rate, the number of data bits,
     * the parity, and the number of stop bits. The suffix "Simplex" denotes
     * the fact that transmission in both directions is multiplexed on the
     * same transmission line.
     *
     * @return string  a string corresponding to the serial port communication parameters, as a string such as
     *         "1200,7E1,Simplex"
     *
     * On failure, throws an exception or returns YSdi12Port::SERIALMODE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_serialMode(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::SERIALMODE_INVALID;
            }
        }
        $res = $this->_serialMode;
        return $res;
    }

    /**
     * Changes the serial port communication parameters, with a string such as
     * "1200,7E1,Simplex". The string includes the baud rate, the number of data bits,
     * the parity, and the number of stop bits. The suffix "Simplex" denotes
     * the fact that transmission in both directions is multiplexed on the
     * same transmission line.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param string $newval : a string corresponding to the serial port communication parameters, with a
     * string such as
     *         "1200,7E1,Simplex"
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_serialMode(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("serialMode", $rest_val);
    }

    /**
     * Retrieves an SDI12 port for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the SDI12 port is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the SDI12 port is
     * indeed online at a given time. In case of ambiguity when looking for
     * an SDI12 port by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the SDI12 port, for instance
     *         MyDevice.sdi12Port.
     *
     * @return YSdi12Port  a YSdi12Port object allowing you to drive the SDI12 port.
     */
    public static function FindSdi12Port(string $func): YSdi12Port
    {
        // $obj                    is a YSdi12Port;
        $obj = YFunction::_FindFromCache('Sdi12Port', $func);
        if ($obj == null) {
            $obj = new YSdi12Port($func);
            YFunction::_AddToCache('Sdi12Port', $func, $obj);
        }
        return $obj;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function sendCommand(string $text): int
    {
        return $this->set_command($text);
    }

    /**
     * Reads a single line (or message) from the receive buffer, starting at current stream position.
     * This function is intended to be used when the serial port is configured for a message protocol,
     * such as 'Line' mode or frame protocols.
     *
     * If data at current stream position is not available anymore in the receive buffer,
     * the function returns the oldest available line and moves the stream position just after.
     * If no new full line is received, the function returns an empty line.
     *
     * @return string  a string with a single line of text
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function readLine(): string
    {
        // $url                    is a str;
        // $msgbin                 is a bin;
        $msgarr = [];           // strArr;
        // $msglen                 is a int;
        // $res                    is a str;

        $url = sprintf('rxmsg.json?pos=%d&len=1&maxw=1', $this->_rxptr);
        $msgbin = $this->_download($url);
        $msgarr = $this->_json_get_array($msgbin);
        $msglen = sizeof($msgarr);
        if ($msglen == 0) {
            return '';
        }
        // last element of array is the new position
        $msglen = $msglen - 1;
        $this->_rxptr = intVal($msgarr[$msglen]);
        if ($msglen == 0) {
            return '';
        }
        $res = $this->_json_get_string($msgarr[0]);
        return $res;
    }

    /**
     * Searches for incoming messages in the serial port receive buffer matching a given pattern,
     * starting at current position. This function will only compare and return printable characters
     * in the message strings. Binary protocols are handled as hexadecimal strings.
     *
     * The search returns all messages matching the expression provided as argument in the buffer.
     * If no matching message is found, the search waits for one up to the specified maximum timeout
     * (in milliseconds).
     *
     * @param string $pattern : a limited regular expression describing the expected message format,
     *         or an empty string if all messages should be returned (no filtering).
     *         When using binary protocols, the format applies to the hexadecimal
     *         representation of the message.
     * @param int $maxWait : the maximum number of milliseconds to wait for a message if none is found
     *         in the receive buffer.
     *
     * @return string[]  an array of strings containing the messages found, if any.
     *         Binary messages are converted to hexadecimal representation.
     *
     * On failure, throws an exception or returns an empty array.
     * @throws YAPI_Exception on error
     */
    public function readMessages(string $pattern, int $maxWait): array
    {
        // $url                    is a str;
        // $msgbin                 is a bin;
        $msgarr = [];           // strArr;
        // $msglen                 is a int;
        $res = [];              // strArr;
        // $idx                    is a int;

        $url = sprintf('rxmsg.json?pos=%d&maxw=%d&pat=%s', $this->_rxptr, $maxWait, $pattern);
        $msgbin = $this->_download($url);
        $msgarr = $this->_json_get_array($msgbin);
        $msglen = sizeof($msgarr);
        if ($msglen == 0) {
            return $res;
        }
        // last element of array is the new position
        $msglen = $msglen - 1;
        $this->_rxptr = intVal($msgarr[$msglen]);
        $idx = 0;
        while ($idx < $msglen) {
            $res[] = $this->_json_get_string($msgarr[$idx]);
            $idx = $idx + 1;
        }
        return $res;
    }

    /**
     * Changes the current internal stream position to the specified value. This function
     * does not affect the device, it only changes the value stored in the API object
     * for the next read operations.
     *
     * @param int $absPos : the absolute position index for next read operations.
     *
     * @return int  nothing.
     */
    public function read_seek(int $absPos): int
    {
        $this->_rxptr = $absPos;
        return YAPI::SUCCESS;
    }

    /**
     * Returns the current absolute stream position pointer of the API object.
     *
     * @return int  the absolute position index for next read operations.
     */
    public function read_tell(): int
    {
        return $this->_rxptr;
    }

    /**
     * Returns the number of bytes available to read in the input buffer starting from the
     * current absolute stream position pointer of the API object.
     *
     * @return int  the number of bytes available to read
     */
    public function read_avail(): int
    {
        // $availPosStr            is a str;
        // $atPos                  is a int;
        // $res                    is a int;
        // $databin                is a bin;

        $databin = $this->_download(sprintf('rxcnt.bin?pos=%d', $this->_rxptr));
        $availPosStr = $databin;
        $atPos = YAPI::Ystrpos($availPosStr,'@');
        $res = intVal(substr($availPosStr,  0, $atPos));
        return $res;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function end_tell(): int
    {
        // $availPosStr            is a str;
        // $atPos                  is a int;
        // $res                    is a int;
        // $databin                is a bin;

        $databin = $this->_download(sprintf('rxcnt.bin?pos=%d', $this->_rxptr));
        $availPosStr = $databin;
        $atPos = YAPI::Ystrpos($availPosStr,'@');
        $res = intVal(substr($availPosStr,  $atPos+1, strlen($availPosStr)-$atPos-1));
        return $res;
    }

    /**
     * Sends a text line query to the serial port, and reads the reply, if any.
     * This function is intended to be used when the serial port is configured for 'Line' protocol.
     *
     * @param string $query : the line query to send (without CR/LF)
     * @param int $maxWait : the maximum number of milliseconds to wait for a reply.
     *
     * @return string  the next text line received after sending the text query, as a string.
     *         Additional lines can be obtained by calling readLine or readMessages.
     *
     * On failure, throws an exception or returns an empty string.
     * @throws YAPI_Exception on error
     */
    public function queryLine(string $query, int $maxWait): string
    {
        // $prevpos                is a int;
        // $url                    is a str;
        // $msgbin                 is a bin;
        $msgarr = [];           // strArr;
        // $msglen                 is a int;
        // $res                    is a str;
        if (strlen($query) <= 80) {
            // fast query
            $url = sprintf('rxmsg.json?len=1&maxw=%d&cmd=!%s', $maxWait, $this->_escapeAttr($query));
        } else {
            // long query
            $prevpos = $this->end_tell();
            $this->_upload('txdata', $query . ''."\r".''."\n".'');
            $url = sprintf('rxmsg.json?len=1&maxw=%d&pos=%d', $maxWait, $prevpos);
        }

        $msgbin = $this->_download($url);
        $msgarr = $this->_json_get_array($msgbin);
        $msglen = sizeof($msgarr);
        if ($msglen == 0) {
            return '';
        }
        // last element of array is the new position
        $msglen = $msglen - 1;
        $this->_rxptr = intVal($msgarr[$msglen]);
        if ($msglen == 0) {
            return '';
        }
        $res = $this->_json_get_string($msgarr[0]);
        return $res;
    }

    /**
     * Sends a binary message to the serial port, and reads the reply, if any.
     * This function is intended to be used when the serial port is configured for
     * Frame-based protocol.
     *
     * @param string $hexString : the message to send, coded in hexadecimal
     * @param int $maxWait : the maximum number of milliseconds to wait for a reply.
     *
     * @return string  the next frame received after sending the message, as a hex string.
     *         Additional frames can be obtained by calling readHex or readMessages.
     *
     * On failure, throws an exception or returns an empty string.
     * @throws YAPI_Exception on error
     */
    public function queryHex(string $hexString, int $maxWait): string
    {
        // $prevpos                is a int;
        // $url                    is a str;
        // $msgbin                 is a bin;
        $msgarr = [];           // strArr;
        // $msglen                 is a int;
        // $res                    is a str;
        if (strlen($hexString) <= 80) {
            // fast query
            $url = sprintf('rxmsg.json?len=1&maxw=%d&cmd=$%s', $maxWait, $hexString);
        } else {
            // long query
            $prevpos = $this->end_tell();
            $this->_upload('txdata', YAPI::_hexStrToBin($hexString));
            $url = sprintf('rxmsg.json?len=1&maxw=%d&pos=%d', $maxWait, $prevpos);
        }

        $msgbin = $this->_download($url);
        $msgarr = $this->_json_get_array($msgbin);
        $msglen = sizeof($msgarr);
        if ($msglen == 0) {
            return '';
        }
        // last element of array is the new position
        $msglen = $msglen - 1;
        $this->_rxptr = intVal($msgarr[$msglen]);
        if ($msglen == 0) {
            return '';
        }
        $res = $this->_json_get_string($msgarr[0]);
        return $res;
    }

    /**
     * Saves the job definition string (JSON data) into a job file.
     * The job file can be later enabled using selectJob().
     *
     * @param string $jobfile : name of the job file to save on the device filesystem
     * @param string $jsonDef : a string containing a JSON definition of the job
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function uploadJob(string $jobfile, string $jsonDef): int
    {
        $this->_upload($jobfile, $jsonDef);
        return YAPI::SUCCESS;
    }

    /**
     * Load and start processing the specified job file. The file must have
     * been previously created using the user interface or uploaded on the
     * device filesystem using the uploadJob() function.
     *
     * @param string $jobfile : name of the job file (on the device filesystem)
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function selectJob(string $jobfile): int
    {
        return $this->set_currentJob($jobfile);
    }

    /**
     * Clears the serial port buffer and resets counters to zero.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function reset(): int
    {
        $this->_eventPos = 0;
        $this->_rxptr = 0;
        $this->_rxbuffptr = 0;
        $this->_rxbuff = '';

        return $this->sendCommand('Z');
    }

    /**
     * Sends a single byte to the serial port.
     *
     * @param int $code : the byte to send
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function writeByte(int $code): int
    {
        return $this->sendCommand(sprintf('$%02X', $code));
    }

    /**
     * Sends an ASCII string to the serial port, as is.
     *
     * @param string $text : the text string to send
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function writeStr(string $text): int
    {
        // $buff                   is a bin;
        // $bufflen                is a int;
        // $idx                    is a int;
        // $ch                     is a int;
        $buff = $text;
        $bufflen = strlen($buff);
        if ($bufflen < 100) {
            // if string is pure text, we can send it as a simple command (faster)
            $ch = 0x20;
            $idx = 0;
            while (($idx < $bufflen) && ($ch != 0)) {
                $ch = ord($buff[$idx]);
                if (($ch >= 0x20) && ($ch < 0x7f)) {
                    $idx = $idx + 1;
                } else {
                    $ch = 0;
                }
            }
            if ($idx >= $bufflen) {
                return $this->sendCommand(sprintf('+%s',$text));
            }
        }
        // send string using file upload
        return $this->_upload('txdata', $buff);
    }

    /**
     * Sends a binary buffer to the serial port, as is.
     *
     * @param string $buff : the binary buffer to send
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function writeBin(string $buff): int
    {
        return $this->_upload('txdata', $buff);
    }

    /**
     * Sends a byte sequence (provided as a list of bytes) to the serial port.
     *
     * @param Integer[] $byteList : a list of byte codes
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function writeArray(array $byteList): int
    {
        // $buff                   is a bin;
        // $bufflen                is a int;
        // $idx                    is a int;
        // $hexb                   is a int;
        // $res                    is a int;
        $bufflen = sizeof($byteList);
        $buff = ($bufflen > 0 ? pack('C',array_fill(0, $bufflen, 0)) : '');
        $idx = 0;
        while ($idx < $bufflen) {
            $hexb = $byteList[$idx];
            $buff[$idx] = pack('C', $hexb);
            $idx = $idx + 1;
        }

        $res = $this->_upload('txdata', $buff);
        return $res;
    }

    /**
     * Sends a byte sequence (provided as a hexadecimal string) to the serial port.
     *
     * @param string $hexString : a string of hexadecimal byte codes
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function writeHex(string $hexString): int
    {
        // $buff                   is a bin;
        // $bufflen                is a int;
        // $idx                    is a int;
        // $hexb                   is a int;
        // $res                    is a int;
        $bufflen = strlen($hexString);
        if ($bufflen < 100) {
            return $this->sendCommand(sprintf('$%s',$hexString));
        }
        $bufflen = (($bufflen) >> (1));
        $buff = ($bufflen > 0 ? pack('C',array_fill(0, $bufflen, 0)) : '');
        $idx = 0;
        while ($idx < $bufflen) {
            $hexb = hexdec(substr($hexString,  2 * $idx, 2));
            $buff[$idx] = pack('C', $hexb);
            $idx = $idx + 1;
        }

        $res = $this->_upload('txdata', $buff);
        return $res;
    }

    /**
     * Sends an ASCII string to the serial port, followed by a line break (CR LF).
     *
     * @param string $text : the text string to send
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function writeLine(string $text): int
    {
        // $buff                   is a bin;
        // $bufflen                is a int;
        // $idx                    is a int;
        // $ch                     is a int;
        $buff = sprintf('%s'."\r".''."\n".'', $text);
        $bufflen = strlen($buff)-2;
        if ($bufflen < 100) {
            // if string is pure text, we can send it as a simple command (faster)
            $ch = 0x20;
            $idx = 0;
            while (($idx < $bufflen) && ($ch != 0)) {
                $ch = ord($buff[$idx]);
                if (($ch >= 0x20) && ($ch < 0x7f)) {
                    $idx = $idx + 1;
                } else {
                    $ch = 0;
                }
            }
            if ($idx >= $bufflen) {
                return $this->sendCommand(sprintf('!%s',$text));
            }
        }
        // send string using file upload
        return $this->_upload('txdata', $buff);
    }

    /**
     * Reads one byte from the receive buffer, starting at current stream position.
     * If data at current stream position is not available anymore in the receive buffer,
     * or if there is no data available yet, the function returns YAPI::NO_MORE_DATA.
     *
     * @return int  the next byte
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function readByte(): int
    {
        // $currpos                is a int;
        // $reqlen                 is a int;
        // $buff                   is a bin;
        // $bufflen                is a int;
        // $mult                   is a int;
        // $endpos                 is a int;
        // $res                    is a int;
        // first check if we have the requested character in the look-ahead buffer
        $bufflen = strlen($this->_rxbuff);
        if (($this->_rxptr >= $this->_rxbuffptr) && ($this->_rxptr < $this->_rxbuffptr+$bufflen)) {
            $res = ord($this->_rxbuff[$this->_rxptr-$this->_rxbuffptr]);
            $this->_rxptr = $this->_rxptr + 1;
            return $res;
        }
        // try to preload more than one byte to speed-up byte-per-byte access
        $currpos = $this->_rxptr;
        $reqlen = 1024;
        $buff = $this->readBin($reqlen);
        $bufflen = strlen($buff);
        if ($this->_rxptr == $currpos+$bufflen) {
            $res = ord($buff[0]);
            $this->_rxptr = $currpos+1;
            $this->_rxbuffptr = $currpos;
            $this->_rxbuff = $buff;
            return $res;
        }
        //  bidirectional data, retry with a smaller block
        $this->_rxptr = $currpos;
        $reqlen = 16;
        $buff = $this->readBin($reqlen);
        $bufflen = strlen($buff);
        if ($this->_rxptr == $currpos+$bufflen) {
            $res = ord($buff[0]);
            $this->_rxptr = $currpos+1;
            $this->_rxbuffptr = $currpos;
            $this->_rxbuff = $buff;
            return $res;
        }
        // still , need to process character by character
        $this->_rxptr = $currpos;

        $buff = $this->_download(sprintf('rxdata.bin?pos=%d&len=1', $this->_rxptr));
        $bufflen = strlen($buff) - 1;
        $endpos = 0;
        $mult = 1;
        while (($bufflen > 0) && (ord($buff[$bufflen]) != 64)) {
            $endpos = $endpos + $mult * (ord($buff[$bufflen]) - 48);
            $mult = $mult * 10;
            $bufflen = $bufflen - 1;
        }
        $this->_rxptr = $endpos;
        if ($bufflen == 0) {
            return YAPI::NO_MORE_DATA;
        }
        $res = ord($buff[0]);
        return $res;
    }

    /**
     * Reads data from the receive buffer as a string, starting at current stream position.
     * If data at current stream position is not available anymore in the receive buffer, the
     * function performs a short read.
     *
     * @param int $nChars : the maximum number of characters to read
     *
     * @return string  a string with receive buffer contents
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function readStr(int $nChars): string
    {
        // $buff                   is a bin;
        // $bufflen                is a int;
        // $mult                   is a int;
        // $endpos                 is a int;
        // $res                    is a str;
        if ($nChars > 65535) {
            $nChars = 65535;
        }

        $buff = $this->_download(sprintf('rxdata.bin?pos=%d&len=%d', $this->_rxptr, $nChars));
        $bufflen = strlen($buff) - 1;
        $endpos = 0;
        $mult = 1;
        while (($bufflen > 0) && (ord($buff[$bufflen]) != 64)) {
            $endpos = $endpos + $mult * (ord($buff[$bufflen]) - 48);
            $mult = $mult * 10;
            $bufflen = $bufflen - 1;
        }
        $this->_rxptr = $endpos;
        $res = substr($buff,  0, $bufflen);
        return $res;
    }

    /**
     * Reads data from the receive buffer as a binary buffer, starting at current stream position.
     * If data at current stream position is not available anymore in the receive buffer, the
     * function performs a short read.
     *
     * @param int $nChars : the maximum number of bytes to read
     *
     * @return string  a binary object with receive buffer contents
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function readBin(int $nChars): string
    {
        // $buff                   is a bin;
        // $bufflen                is a int;
        // $mult                   is a int;
        // $endpos                 is a int;
        // $idx                    is a int;
        // $res                    is a bin;
        if ($nChars > 65535) {
            $nChars = 65535;
        }

        $buff = $this->_download(sprintf('rxdata.bin?pos=%d&len=%d', $this->_rxptr, $nChars));
        $bufflen = strlen($buff) - 1;
        $endpos = 0;
        $mult = 1;
        while (($bufflen > 0) && (ord($buff[$bufflen]) != 64)) {
            $endpos = $endpos + $mult * (ord($buff[$bufflen]) - 48);
            $mult = $mult * 10;
            $bufflen = $bufflen - 1;
        }
        $this->_rxptr = $endpos;
        $res = ($bufflen > 0 ? pack('C',array_fill(0, $bufflen, 0)) : '');
        $idx = 0;
        while ($idx < $bufflen) {
            $res[$idx] = pack('C', ord($buff[$idx]));
            $idx = $idx + 1;
        }
        return $res;
    }

    /**
     * Reads data from the receive buffer as a list of bytes, starting at current stream position.
     * If data at current stream position is not available anymore in the receive buffer, the
     * function performs a short read.
     *
     * @param int $nChars : the maximum number of bytes to read
     *
     * @return Integer[]  a sequence of bytes with receive buffer contents
     *
     * On failure, throws an exception or returns an empty array.
     * @throws YAPI_Exception on error
     */
    public function readArray(int $nChars): array
    {
        // $buff                   is a bin;
        // $bufflen                is a int;
        // $mult                   is a int;
        // $endpos                 is a int;
        // $idx                    is a int;
        // $b                      is a int;
        $res = [];              // intArr;
        if ($nChars > 65535) {
            $nChars = 65535;
        }

        $buff = $this->_download(sprintf('rxdata.bin?pos=%d&len=%d', $this->_rxptr, $nChars));
        $bufflen = strlen($buff) - 1;
        $endpos = 0;
        $mult = 1;
        while (($bufflen > 0) && (ord($buff[$bufflen]) != 64)) {
            $endpos = $endpos + $mult * (ord($buff[$bufflen]) - 48);
            $mult = $mult * 10;
            $bufflen = $bufflen - 1;
        }
        $this->_rxptr = $endpos;
        while (sizeof($res) > 0) {
            array_pop($res);
        };
        $idx = 0;
        while ($idx < $bufflen) {
            $b = ord($buff[$idx]);
            $res[] = $b;
            $idx = $idx + 1;
        }
        return $res;
    }

    /**
     * Reads data from the receive buffer as a hexadecimal string, starting at current stream position.
     * If data at current stream position is not available anymore in the receive buffer, the
     * function performs a short read.
     *
     * @param int $nBytes : the maximum number of bytes to read
     *
     * @return string  a string with receive buffer contents, encoded in hexadecimal
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function readHex(int $nBytes): string
    {
        // $buff                   is a bin;
        // $bufflen                is a int;
        // $mult                   is a int;
        // $endpos                 is a int;
        // $ofs                    is a int;
        // $res                    is a str;
        if ($nBytes > 65535) {
            $nBytes = 65535;
        }

        $buff = $this->_download(sprintf('rxdata.bin?pos=%d&len=%d', $this->_rxptr, $nBytes));
        $bufflen = strlen($buff) - 1;
        $endpos = 0;
        $mult = 1;
        while (($bufflen > 0) && (ord($buff[$bufflen]) != 64)) {
            $endpos = $endpos + $mult * (ord($buff[$bufflen]) - 48);
            $mult = $mult * 10;
            $bufflen = $bufflen - 1;
        }
        $this->_rxptr = $endpos;
        $res = '';
        $ofs = 0;
        while ($ofs + 3 < $bufflen) {
            $res = sprintf('%s%02X%02X%02X%02X', $res, ord($buff[$ofs]), ord($buff[$ofs + 1]), ord($buff[$ofs + 2]), ord($buff[$ofs + 3]));
            $ofs = $ofs + 4;
        }
        while ($ofs < $bufflen) {
            $res = sprintf('%s%02X', $res, ord($buff[$ofs]));
            $ofs = $ofs + 1;
        }
        return $res;
    }

    /**
     * Sends a SDI-12 query to the bus, and reads the sensor immediate reply.
     * This function is intended to be used when the serial port is configured for 'SDI-12' protocol.
     *
     * @param string $sensorAddr : the sensor address, as a string
     * @param string $cmd : the SDI12 query to send (without address and exclamation point)
     * @param int $maxWait : the maximum timeout to wait for a reply from sensor, in millisecond
     *
     * @return string  the reply returned by the sensor, without newline, as a string.
     *
     * On failure, throws an exception or returns an empty string.
     * @throws YAPI_Exception on error
     */
    public function querySdi12(string $sensorAddr, string $cmd, int $maxWait): string
    {
        // $fullCmd                is a str;
        // $cmdChar                is a str;
        // $pattern                is a str;
        // $url                    is a str;
        // $msgbin                 is a bin;
        $msgarr = [];           // strArr;
        // $msglen                 is a int;
        // $res                    is a str;
        $cmdChar  = '';

        $pattern = $sensorAddr;
        if (strlen($cmd) > 0) {
            $cmdChar = substr($cmd,  0, 1);
        }
        if ($sensorAddr == '?') {
            $pattern = '->*';
        } else {
            if ($cmdChar == 'M' || $cmdChar == 'D') {
                $pattern = sprintf('%s:.*', $sensorAddr);
            } else {
                $pattern = sprintf('%s.*', $sensorAddr);
            }
        }
        $pattern = $this->_escapeAttr($pattern);
        $fullCmd = $this->_escapeAttr(sprintf('+%s%s!', $sensorAddr, $cmd));
        $url = sprintf('rxmsg.json?len=1&maxw=%d&cmd=%s&pat=%s', $maxWait, $fullCmd, $pattern);

        $msgbin = $this->_download($url);
        if (strlen($msgbin)<2) {
            return '';
        }
        $msgarr = $this->_json_get_array($msgbin);
        $msglen = sizeof($msgarr);
        if ($msglen == 0) {
            return '';
        }
        // last element of array is the new position
        $msglen = $msglen - 1;
        $this->_rxptr = intVal($msgarr[$msglen]);
        if ($msglen == 0) {
            return '';
        }
        $res = $this->_json_get_string($msgarr[0]);
        return $res;
    }

    /**
     * Sends a discovery command to the bus, and reads the sensor information reply.
     * This function is intended to be used when the serial port is configured for 'SDI-12' protocol.
     * This function work when only one sensor is connected.
     *
     * @return ?YSdi12SensorInfo  the reply returned by the sensor, as a YSdi12SensorInfo object.
     *
     * On failure, throws an exception or returns an empty string.
     * @throws YAPI_Exception on error
     */
    public function discoverSingleSensor(): ?YSdi12SensorInfo
    {
        // $resStr                 is a str;

        $resStr = $this->querySdi12('?','',5000);
        if ($resStr == '') {
            return new YSdi12SensorInfo($this, 'ERSensor Not Found');
        }

        return $this->getSensorInformation($resStr);
    }

    /**
     * Sends a discovery command to the bus, and reads all sensors information reply.
     * This function is intended to be used when the serial port is configured for 'SDI-12' protocol.
     *
     * @return YSdi12SensorInfo[]  all the information from every connected sensor, as an array of
     * YSdi12SensorInfo object.
     *
     * On failure, throws an exception or returns an empty string.
     * @throws YAPI_Exception on error
     */
    public function discoverAllSensors(): array
    {
        $sensors = [];          // YSdi12SensorInfoArr;
        $idSens = [];           // strArr;
        // $res                    is a str;
        // $i                      is a int;
        // $lettreMin              is a str;
        // $lettreMaj              is a str;

        // 1. Search for sensors present
        while (sizeof($idSens) > 0) {
            array_pop($idSens);
        };
        $i = 0 ;
        while ($i < 10) {
            $res = $this->querySdi12($i,'!',500);
            if (strlen($res) >= 1) {
                $idSens[] = $res;
            }
            $i = $i+1;
        }
        $lettreMin = 'abcdefghijklmnopqrstuvwxyz';
        $lettreMaj = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $i = 0;
        while ($i<26) {
            $res = $this->querySdi12(substr($lettreMin, $i, 1),'!',500);
            if (strlen($res) >= 1) {
                $idSens[] = $res;
            }
            $i = $i +1;
        }
        while ($i<26) {
            $res = $this->querySdi12(substr($lettreMaj, $i, 1),'!',500);
            if (strlen($res) >= 1) {
                $idSens[] = $res;
            }
            $i = $i +1;
        }
        // 2. Query existing sensors information
        $i = 0;
        while (sizeof($sensors) > 0) {
            array_pop($sensors);
        };
        while ($i < sizeof($idSens)) {
            $sensors[] = $this->getSensorInformation($idSens[$i]);
            $i = $i + 1;
        }
        return $sensors;
    }

    /**
     * Sends a mesurement command to the SDI-12 bus, and reads the sensor immediate reply.
     * The supported commands are:
     * M: Measurement start control
     * M1...M9: Additional measurement start command
     * D: Measurement reading control
     * This function is intended to be used when the serial port is configured for 'SDI-12' protocol.
     *
     * @param string $sensorAddr : the sensor address, as a string
     * @param string $measCmd : the SDI12 query to send (without address and exclamation point)
     * @param int $maxWait : the maximum timeout to wait for a reply from sensor, in millisecond
     *
     * @return float[]  the reply returned by the sensor, without newline, as a list of float.
     *
     * On failure, throws an exception or returns an empty string.
     * @throws YAPI_Exception on error
     */
    public function readSensor(string $sensorAddr, string $measCmd, int $maxWait): array
    {
        // $resStr                 is a str;
        $res = [];              // floatArr;
        $tab = [];              // strArr;
        $split = [];            // strArr;
        // $i                      is a int;
        // $valdouble              is a float;

        $resStr = $this->querySdi12($sensorAddr,$measCmd,$maxWait);
        $tab = explode(',', $resStr);
        $split = explode(':', $tab[0]);
        if (sizeof($split) < 2) {
            return $res;
        }
        $valdouble = floatval($split[1]);
        $res[] = $valdouble;
        $i = 1;
        while ($i < sizeof($tab)) {
            $valdouble = floatval($tab[$i]);
            $res[] = $valdouble;
            $i = $i + 1;
        }
        return $res;
    }

    /**
     * Changes the address of the selected sensor, and returns the sensor information with the new address.
     * This function is intended to be used when the serial port is configured for 'SDI-12' protocol.
     *
     * @param string $oldAddress : Actual sensor address, as a string
     * @param string $newAddress : New sensor address, as a string
     *
     * @return ?YSdi12SensorInfo  the sensor address and information , as a YSdi12SensorInfo object.
     *
     * On failure, throws an exception or returns an empty string.
     * @throws YAPI_Exception on error
     */
    public function changeAddress(string $oldAddress, string $newAddress): ?YSdi12SensorInfo
    {
        // $addr                   is a YSdi12SensorInfo;

        $this->querySdi12($oldAddress, 'A' . $newAddress,1000);
        $addr = $this->getSensorInformation($newAddress);
        return $addr;
    }

    /**
     * Sends a information command to the bus, and reads sensors information selected.
     * This function is intended to be used when the serial port is configured for 'SDI-12' protocol.
     *
     * @param string $sensorAddr : Sensor address, as a string
     *
     * @return ?YSdi12SensorInfo  the reply returned by the sensor, as a YSdi12Port object.
     *
     * On failure, throws an exception or returns an empty string.
     * @throws YAPI_Exception on error
     */
    public function getSensorInformation(string $sensorAddr): ?YSdi12SensorInfo
    {
        // $res                    is a str;
        // $sensor                 is a YSdi12SensorInfo;

        $res = $this->querySdi12($sensorAddr,'I',1000);
        if ($res == '') {
            return new YSdi12SensorInfo($this, 'ERSensor Not Found');
        }
        $sensor = new YSdi12SensorInfo($this, $res);
        $sensor->_queryValueInfo();
        return $sensor;
    }

    /**
     * Sends a information command to the bus, and reads sensors information selected.
     * This function is intended to be used when the serial port is configured for 'SDI-12' protocol.
     *
     * @param string $sensorAddr : Sensor address, as a string
     *
     * @return float[]  the reply returned by the sensor, as a YSdi12Port object.
     *
     * On failure, throws an exception or returns an empty string.
     * @throws YAPI_Exception on error
     */
    public function readConcurrentMeasurements(string $sensorAddr): array
    {
        $res = [];              // floatArr;

        $res= $this->readSensor($sensorAddr,'D',1000);
        return $res;
    }

    /**
     * Sends a information command to the bus, and reads sensors information selected.
     * This function is intended to be used when the serial port is configured for 'SDI-12' protocol.
     *
     * @param string $sensorAddr : Sensor address, as a string
     *
     * @return int  the reply returned by the sensor, as a YSdi12Port object.
     *
     * On failure, throws an exception or returns an empty string.
     * @throws YAPI_Exception on error
     */
    public function requestConcurrentMeasurements(string $sensorAddr): int
    {
        // $timewait               is a int;
        // $wait                   is a str;

        $wait = $this->querySdi12($sensorAddr,'C',1000);
        $wait = substr($wait,  1, 3);
        $timewait = intVal($wait) * 1000;
        return $timewait;
    }

    /**
     * Retrieves messages (both direction) in the SDI12 port buffer, starting at current position.
     *
     * If no message is found, the search waits for one up to the specified maximum timeout
     * (in milliseconds).
     *
     * @param int $maxWait : the maximum number of milliseconds to wait for a message if none is found
     *         in the receive buffer.
     * @param int $maxMsg : the maximum number of messages to be returned by the function; up to 254.
     *
     * @return YSdi12SnoopingRecord[]  an array of YSdi12SnoopingRecord objects containing the messages found, if any.
     *
     * On failure, throws an exception or returns an empty array.
     * @throws YAPI_Exception on error
     */
    public function snoopMessagesEx(int $maxWait, int $maxMsg): array
    {
        // $url                    is a str;
        // $msgbin                 is a bin;
        $msgarr = [];           // strArr;
        // $msglen                 is a int;
        $res = [];              // YSdi12SnoopingRecordArr;
        // $idx                    is a int;

        $url = sprintf('rxmsg.json?pos=%d&maxw=%d&t=0&len=%d', $this->_rxptr, $maxWait, $maxMsg);
        $msgbin = $this->_download($url);
        $msgarr = $this->_json_get_array($msgbin);
        $msglen = sizeof($msgarr);
        if ($msglen == 0) {
            return $res;
        }
        // last element of array is the new position
        $msglen = $msglen - 1;
        $this->_rxptr = intVal($msgarr[$msglen]);
        $idx = 0;
        while ($idx < $msglen) {
            $res[] = new YSdi12SnoopingRecord($msgarr[$idx]);
            $idx = $idx + 1;
        }
        return $res;
    }

    /**
     * Retrieves messages (both direction) in the SDI12 port buffer, starting at current position.
     *
     * If no message is found, the search waits for one up to the specified maximum timeout
     * (in milliseconds).
     *
     * @param int $maxWait : the maximum number of milliseconds to wait for a message if none is found
     *         in the receive buffer.
     *
     * @return YSdi12SnoopingRecord[]  an array of YSdi12SnoopingRecord objects containing the messages found, if any.
     *
     * On failure, throws an exception or returns an empty array.
     * @throws YAPI_Exception on error
     */
    public function snoopMessages(int $maxWait): array
    {
        return $this->snoopMessagesEx($maxWait, 255);
    }

    /**
     * @throws YAPI_Exception
     */
    public function rxCount(): int
{
    return $this->get_rxCount();
}

    /**
     * @throws YAPI_Exception
     */
    public function txCount(): int
{
    return $this->get_txCount();
}

    /**
     * @throws YAPI_Exception
     */
    public function errCount(): int
{
    return $this->get_errCount();
}

    /**
     * @throws YAPI_Exception
     */
    public function rxMsgCount(): int
{
    return $this->get_rxMsgCount();
}

    /**
     * @throws YAPI_Exception
     */
    public function txMsgCount(): int
{
    return $this->get_txMsgCount();
}

    /**
     * @throws YAPI_Exception
     */
    public function lastMsg(): string
{
    return $this->get_lastMsg();
}

    /**
     * @throws YAPI_Exception
     */
    public function currentJob(): string
{
    return $this->get_currentJob();
}

    /**
     * @throws YAPI_Exception
     */
    public function setCurrentJob(string $newval): int
{
    return $this->set_currentJob($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function startupJob(): string
{
    return $this->get_startupJob();
}

    /**
     * @throws YAPI_Exception
     */
    public function setStartupJob(string $newval): int
{
    return $this->set_startupJob($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function jobMaxTask(): int
{
    return $this->get_jobMaxTask();
}

    /**
     * @throws YAPI_Exception
     */
    public function jobMaxSize(): int
{
    return $this->get_jobMaxSize();
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
     * @throws YAPI_Exception
     */
    public function protocol(): string
{
    return $this->get_protocol();
}

    /**
     * @throws YAPI_Exception
     */
    public function setProtocol(string $newval): int
{
    return $this->set_protocol($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function voltageLevel(): int
{
    return $this->get_voltageLevel();
}

    /**
     * @throws YAPI_Exception
     */
    public function setVoltageLevel(int $newval): int
{
    return $this->set_voltageLevel($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function serialMode(): string
{
    return $this->get_serialMode();
}

    /**
     * @throws YAPI_Exception
     */
    public function setSerialMode(string $newval): int
{
    return $this->set_serialMode($newval);
}

    /**
     * Continues the enumeration of SDI12 ports started using yFirstSdi12Port().
     * Caution: You can't make any assumption about the returned SDI12 ports order.
     * If you want to find a specific an SDI12 port, use Sdi12Port.findSdi12Port()
     * and a hardwareID or a logical name.
     *
     * @return ?YSdi12Port  a pointer to a YSdi12Port object, corresponding to
     *         an SDI12 port currently online, or a null pointer
     *         if there are no more SDI12 ports to enumerate.
     */
    public function nextSdi12Port(): ?YSdi12Port
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindSdi12Port($next_hwid);
    }

    /**
     * Starts the enumeration of SDI12 ports currently accessible.
     * Use the method YSdi12Port::nextSdi12Port() to iterate on
     * next SDI12 ports.
     *
     * @return ?YSdi12Port  a pointer to a YSdi12Port object, corresponding to
     *         the first SDI12 port currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstSdi12Port(): ?YSdi12Port
    {
        $next_hwid = YAPI::getFirstHardwareId('Sdi12Port');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindSdi12Port($next_hwid);
    }

    //--- (end of generated code: YSdi12Port implementation)

}
//^^^^ YSdi12Port.php

//--- (generated code: YSdi12Port functions)

/**
 * Retrieves an SDI12 port for a given identifier.
 * The identifier can be specified using several formats:
 *
 * - FunctionLogicalName
 * - ModuleSerialNumber.FunctionIdentifier
 * - ModuleSerialNumber.FunctionLogicalName
 * - ModuleLogicalName.FunctionIdentifier
 * - ModuleLogicalName.FunctionLogicalName
 *
 *
 * This function does not require that the SDI12 port is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method isOnline() to test if the SDI12 port is
 * indeed online at a given time. In case of ambiguity when looking for
 * an SDI12 port by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 *
 * If a call to this object's is_online() method returns FALSE although
 * you are certain that the matching device is plugged, make sure that you did
 * call registerHub() at application initialization time.
 *
 * @param string $func : a string that uniquely characterizes the SDI12 port, for instance
 *         MyDevice.sdi12Port.
 *
 * @return YSdi12Port  a YSdi12Port object allowing you to drive the SDI12 port.
 */
function yFindSdi12Port(string $func): YSdi12Port
{
    return YSdi12Port::FindSdi12Port($func);
}

/**
 * Starts the enumeration of SDI12 ports currently accessible.
 * Use the method YSdi12Port::nextSdi12Port() to iterate on
 * next SDI12 ports.
 *
 * @return ?YSdi12Port  a pointer to a YSdi12Port object, corresponding to
 *         the first SDI12 port currently online, or a null pointer
 *         if there are none.
 */
function yFirstSdi12Port(): ?YSdi12Port
{
    return YSdi12Port::FirstSdi12Port();
}

//--- (end of generated code: YSdi12Port functions)
