<?php
/*********************************************************************
 *
 *  $Id: svn_id $
 *
 *  Implements YInputChain, the high-level API for InputChain functions
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

//--- (YInputChain return codes)
//--- (end of YInputChain return codes)
//--- (YInputChain definitions)
if(!defined('Y_LOOPBACKTEST_OFF'))           define('Y_LOOPBACKTEST_OFF',          0);
if(!defined('Y_LOOPBACKTEST_ON'))            define('Y_LOOPBACKTEST_ON',           1);
if(!defined('Y_LOOPBACKTEST_INVALID'))       define('Y_LOOPBACKTEST_INVALID',      -1);
if(!defined('Y_EXPECTEDNODES_INVALID'))      define('Y_EXPECTEDNODES_INVALID',     YAPI_INVALID_UINT);
if(!defined('Y_DETECTEDNODES_INVALID'))      define('Y_DETECTEDNODES_INVALID',     YAPI_INVALID_UINT);
if(!defined('Y_REFRESHRATE_INVALID'))        define('Y_REFRESHRATE_INVALID',       YAPI_INVALID_UINT);
if(!defined('Y_BITCHAIN1_INVALID'))          define('Y_BITCHAIN1_INVALID',         YAPI_INVALID_STRING);
if(!defined('Y_BITCHAIN2_INVALID'))          define('Y_BITCHAIN2_INVALID',         YAPI_INVALID_STRING);
if(!defined('Y_BITCHAIN3_INVALID'))          define('Y_BITCHAIN3_INVALID',         YAPI_INVALID_STRING);
if(!defined('Y_BITCHAIN4_INVALID'))          define('Y_BITCHAIN4_INVALID',         YAPI_INVALID_STRING);
if(!defined('Y_BITCHAIN5_INVALID'))          define('Y_BITCHAIN5_INVALID',         YAPI_INVALID_STRING);
if(!defined('Y_BITCHAIN6_INVALID'))          define('Y_BITCHAIN6_INVALID',         YAPI_INVALID_STRING);
if(!defined('Y_BITCHAIN7_INVALID'))          define('Y_BITCHAIN7_INVALID',         YAPI_INVALID_STRING);
if(!defined('Y_WATCHDOGPERIOD_INVALID'))     define('Y_WATCHDOGPERIOD_INVALID',    YAPI_INVALID_UINT);
if(!defined('Y_CHAINDIAGS_INVALID'))         define('Y_CHAINDIAGS_INVALID',        YAPI_INVALID_UINT);
//--- (end of YInputChain definitions)
    #--- (YInputChain yapiwrapper)
   #--- (end of YInputChain yapiwrapper)

function yInternalEventCallback($obj, $value)
{
    $obj->_internalEventHandler($value);
}

//--- (YInputChain declaration)
/**
 * YInputChain Class: InputChain function interface
 *
 * The YInputChain class provides access to separate
 * digital inputs connected in a chain.
 */
class YInputChain extends YFunction
{
    const EXPECTEDNODES_INVALID          = YAPI_INVALID_UINT;
    const DETECTEDNODES_INVALID          = YAPI_INVALID_UINT;
    const LOOPBACKTEST_OFF               = 0;
    const LOOPBACKTEST_ON                = 1;
    const LOOPBACKTEST_INVALID           = -1;
    const REFRESHRATE_INVALID            = YAPI_INVALID_UINT;
    const BITCHAIN1_INVALID              = YAPI_INVALID_STRING;
    const BITCHAIN2_INVALID              = YAPI_INVALID_STRING;
    const BITCHAIN3_INVALID              = YAPI_INVALID_STRING;
    const BITCHAIN4_INVALID              = YAPI_INVALID_STRING;
    const BITCHAIN5_INVALID              = YAPI_INVALID_STRING;
    const BITCHAIN6_INVALID              = YAPI_INVALID_STRING;
    const BITCHAIN7_INVALID              = YAPI_INVALID_STRING;
    const WATCHDOGPERIOD_INVALID         = YAPI_INVALID_UINT;
    const CHAINDIAGS_INVALID             = YAPI_INVALID_UINT;
    //--- (end of YInputChain declaration)

    //--- (YInputChain attributes)
    protected $_expectedNodes            = Y_EXPECTEDNODES_INVALID;      // UInt31
    protected $_detectedNodes            = Y_DETECTEDNODES_INVALID;      // UInt31
    protected $_loopbackTest             = Y_LOOPBACKTEST_INVALID;       // OnOff
    protected $_refreshRate              = Y_REFRESHRATE_INVALID;        // UInt31
    protected $_bitChain1                = Y_BITCHAIN1_INVALID;          // Text
    protected $_bitChain2                = Y_BITCHAIN2_INVALID;          // Text
    protected $_bitChain3                = Y_BITCHAIN3_INVALID;          // Text
    protected $_bitChain4                = Y_BITCHAIN4_INVALID;          // Text
    protected $_bitChain5                = Y_BITCHAIN5_INVALID;          // Text
    protected $_bitChain6                = Y_BITCHAIN6_INVALID;          // Text
    protected $_bitChain7                = Y_BITCHAIN7_INVALID;          // Text
    protected $_watchdogPeriod           = Y_WATCHDOGPERIOD_INVALID;     // UInt31
    protected $_chainDiags               = Y_CHAINDIAGS_INVALID;         // InputChainDiags
    protected $_eventCallback            = null;                         // YEventCallback
    protected $_prevPos                  = 0;                            // int
    protected $_eventPos                 = 0;                            // int
    protected $_eventStamp               = 0;                            // int
    protected $_eventChains              = Array();                      // strArr
    //--- (end of YInputChain attributes)

    function __construct($str_func)
    {
        //--- (YInputChain constructor)
        parent::__construct($str_func);
        $this->_className = 'InputChain';

        //--- (end of YInputChain constructor)
    }

    //--- (YInputChain implementation)

    function _parseAttr($name, $val)
    {
        switch($name) {
        case 'expectedNodes':
            $this->_expectedNodes = intval($val);
            return 1;
        case 'detectedNodes':
            $this->_detectedNodes = intval($val);
            return 1;
        case 'loopbackTest':
            $this->_loopbackTest = intval($val);
            return 1;
        case 'refreshRate':
            $this->_refreshRate = intval($val);
            return 1;
        case 'bitChain1':
            $this->_bitChain1 = $val;
            return 1;
        case 'bitChain2':
            $this->_bitChain2 = $val;
            return 1;
        case 'bitChain3':
            $this->_bitChain3 = $val;
            return 1;
        case 'bitChain4':
            $this->_bitChain4 = $val;
            return 1;
        case 'bitChain5':
            $this->_bitChain5 = $val;
            return 1;
        case 'bitChain6':
            $this->_bitChain6 = $val;
            return 1;
        case 'bitChain7':
            $this->_bitChain7 = $val;
            return 1;
        case 'watchdogPeriod':
            $this->_watchdogPeriod = intval($val);
            return 1;
        case 'chainDiags':
            $this->_chainDiags = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the number of nodes expected in the chain.
     *
     * @return integer : an integer corresponding to the number of nodes expected in the chain
     *
     * On failure, throws an exception or returns YInputChain::EXPECTEDNODES_INVALID.
     */
    public function get_expectedNodes()
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_EXPECTEDNODES_INVALID;
            }
        }
        $res = $this->_expectedNodes;
        return $res;
    }

    /**
     * Changes the number of nodes expected in the chain.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param integer $newval : an integer corresponding to the number of nodes expected in the chain
     *
     * @return integer : YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_expectedNodes($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("expectedNodes",$rest_val);
    }

    /**
     * Returns the number of nodes detected in the chain.
     *
     * @return integer : an integer corresponding to the number of nodes detected in the chain
     *
     * On failure, throws an exception or returns YInputChain::DETECTEDNODES_INVALID.
     */
    public function get_detectedNodes()
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_DETECTEDNODES_INVALID;
            }
        }
        $res = $this->_detectedNodes;
        return $res;
    }

    /**
     * Returns the activation state of the exhaustive chain connectivity test.
     * The connectivity test requires a cable connecting the end of the chain
     * to the loopback test connector.
     *
     * @return integer : either YInputChain::LOOPBACKTEST_OFF or YInputChain::LOOPBACKTEST_ON, according to
     * the activation state of the exhaustive chain connectivity test
     *
     * On failure, throws an exception or returns YInputChain::LOOPBACKTEST_INVALID.
     */
    public function get_loopbackTest()
    {
        // $res                    is a enumONOFF;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_LOOPBACKTEST_INVALID;
            }
        }
        $res = $this->_loopbackTest;
        return $res;
    }

    /**
     * Changes the activation state of the exhaustive chain connectivity test.
     * The connectivity test requires a cable connecting the end of the chain
     * to the loopback test connector.
     *
     * @param integer $newval : either YInputChain::LOOPBACKTEST_OFF or YInputChain::LOOPBACKTEST_ON,
     * according to the activation state of the exhaustive chain connectivity test
     *
     * @return integer : YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_loopbackTest($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("loopbackTest",$rest_val);
    }

    /**
     * Returns the desired refresh rate, measured in Hz.
     * The higher the refresh rate is set, the higher the
     * communication speed on the chain will be.
     *
     * @return integer : an integer corresponding to the desired refresh rate, measured in Hz
     *
     * On failure, throws an exception or returns YInputChain::REFRESHRATE_INVALID.
     */
    public function get_refreshRate()
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_REFRESHRATE_INVALID;
            }
        }
        $res = $this->_refreshRate;
        return $res;
    }

    /**
     * Changes the desired refresh rate, measured in Hz.
     * The higher the refresh rate is set, the higher the
     * communication speed on the chain will be.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param integer $newval : an integer corresponding to the desired refresh rate, measured in Hz
     *
     * @return integer : YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_refreshRate($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("refreshRate",$rest_val);
    }

    /**
     * Returns the state of input 1 for all nodes of the input chain,
     * as a hexadecimal string. The node nearest to the controller
     * is the lowest bit of the result.
     *
     * @return string : a string corresponding to the state of input 1 for all nodes of the input chain,
     *         as a hexadecimal string
     *
     * On failure, throws an exception or returns YInputChain::BITCHAIN1_INVALID.
     */
    public function get_bitChain1()
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_BITCHAIN1_INVALID;
            }
        }
        $res = $this->_bitChain1;
        return $res;
    }

    /**
     * Returns the state of input 2 for all nodes of the input chain,
     * as a hexadecimal string. The node nearest to the controller
     * is the lowest bit of the result.
     *
     * @return string : a string corresponding to the state of input 2 for all nodes of the input chain,
     *         as a hexadecimal string
     *
     * On failure, throws an exception or returns YInputChain::BITCHAIN2_INVALID.
     */
    public function get_bitChain2()
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_BITCHAIN2_INVALID;
            }
        }
        $res = $this->_bitChain2;
        return $res;
    }

    /**
     * Returns the state of input 3 for all nodes of the input chain,
     * as a hexadecimal string. The node nearest to the controller
     * is the lowest bit of the result.
     *
     * @return string : a string corresponding to the state of input 3 for all nodes of the input chain,
     *         as a hexadecimal string
     *
     * On failure, throws an exception or returns YInputChain::BITCHAIN3_INVALID.
     */
    public function get_bitChain3()
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_BITCHAIN3_INVALID;
            }
        }
        $res = $this->_bitChain3;
        return $res;
    }

    /**
     * Returns the state of input 4 for all nodes of the input chain,
     * as a hexadecimal string. The node nearest to the controller
     * is the lowest bit of the result.
     *
     * @return string : a string corresponding to the state of input 4 for all nodes of the input chain,
     *         as a hexadecimal string
     *
     * On failure, throws an exception or returns YInputChain::BITCHAIN4_INVALID.
     */
    public function get_bitChain4()
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_BITCHAIN4_INVALID;
            }
        }
        $res = $this->_bitChain4;
        return $res;
    }

    /**
     * Returns the state of input 5 for all nodes of the input chain,
     * as a hexadecimal string. The node nearest to the controller
     * is the lowest bit of the result.
     *
     * @return string : a string corresponding to the state of input 5 for all nodes of the input chain,
     *         as a hexadecimal string
     *
     * On failure, throws an exception or returns YInputChain::BITCHAIN5_INVALID.
     */
    public function get_bitChain5()
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_BITCHAIN5_INVALID;
            }
        }
        $res = $this->_bitChain5;
        return $res;
    }

    /**
     * Returns the state of input 6 for all nodes of the input chain,
     * as a hexadecimal string. The node nearest to the controller
     * is the lowest bit of the result.
     *
     * @return string : a string corresponding to the state of input 6 for all nodes of the input chain,
     *         as a hexadecimal string
     *
     * On failure, throws an exception or returns YInputChain::BITCHAIN6_INVALID.
     */
    public function get_bitChain6()
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_BITCHAIN6_INVALID;
            }
        }
        $res = $this->_bitChain6;
        return $res;
    }

    /**
     * Returns the state of input 7 for all nodes of the input chain,
     * as a hexadecimal string. The node nearest to the controller
     * is the lowest bit of the result.
     *
     * @return string : a string corresponding to the state of input 7 for all nodes of the input chain,
     *         as a hexadecimal string
     *
     * On failure, throws an exception or returns YInputChain::BITCHAIN7_INVALID.
     */
    public function get_bitChain7()
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_BITCHAIN7_INVALID;
            }
        }
        $res = $this->_bitChain7;
        return $res;
    }

    /**
     * Returns the wait time in seconds before triggering an inactivity
     * timeout error.
     *
     * @return integer : an integer corresponding to the wait time in seconds before triggering an inactivity
     *         timeout error
     *
     * On failure, throws an exception or returns YInputChain::WATCHDOGPERIOD_INVALID.
     */
    public function get_watchdogPeriod()
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_WATCHDOGPERIOD_INVALID;
            }
        }
        $res = $this->_watchdogPeriod;
        return $res;
    }

    /**
     * Changes the wait time in seconds before triggering an inactivity
     * timeout error. Remember to call the saveToFlash() method
     * of the module if the modification must be kept.
     *
     * @param integer $newval : an integer corresponding to the wait time in seconds before triggering an inactivity
     *         timeout error
     *
     * @return integer : YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_watchdogPeriod($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("watchdogPeriod",$rest_val);
    }

    /**
     * Returns the controller state diagnostics. Bit 0 indicates a chain length
     * error, bit 1 indicates an inactivity timeout and bit 2 indicates
     * a loopback test failure.
     *
     * @return integer : an integer corresponding to the controller state diagnostics
     *
     * On failure, throws an exception or returns YInputChain::CHAINDIAGS_INVALID.
     */
    public function get_chainDiags()
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI_SUCCESS) {
                return Y_CHAINDIAGS_INVALID;
            }
        }
        $res = $this->_chainDiags;
        return $res;
    }

    /**
     * Retrieves a digital input chain for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the digital input chain is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the digital input chain is
     * indeed online at a given time. In case of ambiguity when looking for
     * a digital input chain by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the digital input chain, for instance
     *         MyDevice.inputChain.
     *
     * @return YInputChain : a YInputChain object allowing you to drive the digital input chain.
     */
    public static function FindInputChain($func)
    {
        // $obj                    is a YInputChain;
        $obj = YFunction::_FindFromCache('InputChain', $func);
        if ($obj == null) {
            $obj = new YInputChain($func);
            YFunction::_AddToCache('InputChain', $func, $obj);
        }
        return $obj;
    }

    /**
     * Resets the application watchdog countdown.
     * If you have setup a non-zero watchdogPeriod, you should
     * call this function on a regular basis to prevent the application
     * inactivity error to be triggered.
     *
     * @return integer : YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function resetWatchdog()
    {
        return $this->set_watchdogPeriod(-1);
    }

    /**
     * Returns a string with last events observed on the digital input chain.
     * This method return only events that are still buffered in the device memory.
     *
     * @return string : a string with last events observed (one per line).
     *
     * On failure, throws an exception or returns  YAPI::INVALID_STRING.
     */
    public function get_lastEvents()
    {
        // $content                is a bin;

        $content = $this->_download('events.txt');
        return $content;
    }

    /**
     * Registers a callback function to be called each time that an event is detected on the
     * input chain.
     *
     * @param function $callback : the callback function to call, or a null pointer.
     *         The callback function should take four arguments:
     *         the YInputChain object that emitted the event, the
     *         UTC timestamp of the event, a character string describing
     *         the type of event and a character string with the event data.
     *         On failure, throws an exception or returns a negative error code.
     */
    public function registerEventCallback($callback)
    {
        if (!is_null($callback)) {
            $this->registerValueCallback('yInternalEventCallback');
        } else {
            $this->registerValueCallback(null);
        }
        // register user callback AFTER the internal pseudo-event,
        // to make sure we start with future events only
        $this->_eventCallback = $callback;
        return 0;
    }

    public function _internalEventHandler($cbpos)
    {
        // $newPos                 is a int;
        // $url                    is a str;
        // $content                is a bin;
        // $contentStr             is a str;
        $eventArr = Array();    // strArr;
        // $arrLen                 is a int;
        // $lenStr                 is a str;
        // $arrPos                 is a int;
        // $eventStr               is a str;
        // $eventLen               is a int;
        // $hexStamp               is a str;
        // $typePos                is a int;
        // $dataPos                is a int;
        // $evtStamp               is a int;
        // $evtType                is a str;
        // $evtData                is a str;
        // $evtChange              is a str;
        // $chainIdx               is a int;
        $newPos = intVal($cbpos);
        if ($newPos < $this->_prevPos) {
            $this->_eventPos = 0;
        }
        $this->_prevPos = $newPos;
        if ($newPos < $this->_eventPos) {
            return YAPI_SUCCESS;
        }
        if (!(!is_null($this->_eventCallback))) {
            // first simulated event, use it to initialize reference values
            $this->_eventPos = $newPos;
            while(sizeof($this->_eventChains) > 0) { array_pop($this->_eventChains); };
            $this->_eventChains[] = $this->get_bitChain1();
            $this->_eventChains[] = $this->get_bitChain2();
            $this->_eventChains[] = $this->get_bitChain3();
            $this->_eventChains[] = $this->get_bitChain4();
            $this->_eventChains[] = $this->get_bitChain5();
            $this->_eventChains[] = $this->get_bitChain6();
            $this->_eventChains[] = $this->get_bitChain7();
            return YAPI_SUCCESS;
        }
        $url = sprintf('events.txt?pos=%d', $this->_eventPos);

        $content = $this->_download($url);
        $contentStr = $content;
        $eventArr = explode(''."\n".'', $contentStr);
        $arrLen = sizeof($eventArr);
        if (!($arrLen > 0)) return $this->_throw( YAPI_IO_ERROR, 'fail to download events',YAPI_IO_ERROR);
        // last element of array is the new position preceeded by '@'
        $arrLen = $arrLen - 1;
        $lenStr = $eventArr[$arrLen];
        $lenStr = substr($lenStr,  1, strlen($lenStr)-1);
        // update processed event position pointer
        $this->_eventPos = intVal($lenStr);
        // now generate callbacks for each event received
        $arrPos = 0;
        while ($arrPos < $arrLen) {
            $eventStr = $eventArr[$arrPos];
            $eventLen = strlen($eventStr);
            if ($eventLen >= 1) {
                $hexStamp = substr($eventStr,  0, 8);
                $evtStamp = hexdec($hexStamp);
                $typePos = Ystrpos($eventStr,':')+1;
                if (($evtStamp >= $this->_eventStamp) && ($typePos > 8)) {
                    $this->_eventStamp = $evtStamp;
                    $dataPos = Ystrpos($eventStr,'=')+1;
                    $evtType = substr($eventStr,  $typePos, 1);
                    $evtData = '';
                    $evtChange = '';
                    if ($dataPos > 10) {
                        $evtData = substr($eventStr,  $dataPos, strlen($eventStr)-$dataPos);
                        if (Ystrpos('1234567',$evtType) >= 0) {
                            $chainIdx = intVal($evtType) - 1;
                            $evtChange = $this->_strXor($evtData, $this->_eventChains[$chainIdx]);
                            $this->_eventChains[$chainIdx] = $evtData;
                        }
                    }
                    call_user_func($this->_eventCallback, $this, $evtStamp, $evtType, $evtData, $evtChange);
                }
            }
            $arrPos = $arrPos + 1;
        }
        return YAPI_SUCCESS;
    }

    public function _strXor($a,$b)
    {
        // $lenA                   is a int;
        // $lenB                   is a int;
        // $res                    is a str;
        // $idx                    is a int;
        // $digitA                 is a int;
        // $digitB                 is a int;
        // make sure the result has the same length as first argument
        $lenA = strlen($a);
        $lenB = strlen($b);
        if ($lenA > $lenB) {
            $res = substr($a,  0, $lenA-$lenB);
            $a = substr($a,  $lenA-$lenB, $lenB);
            $lenA = $lenB;
        } else {
            $res = '';
            $b = substr($b,  $lenA-$lenB, $lenA);
        }
        // scan strings and compare digit by digit
        $idx = 0;
        while ($idx < $lenA) {
            $digitA = hexdec(substr($a,  $idx, 1));
            $digitB = hexdec(substr($b,  $idx, 1));
            $res = sprintf('%s%x', $res, (($digitA) ^ ($digitB)));
            $idx = $idx + 1;
        }
        return $res;
    }

    public function hex2array($hexstr)
    {
        // $hexlen                 is a int;
        $res = Array();         // intArr;
        // $idx                    is a int;
        // $digit                  is a int;
        $hexlen = strlen($hexstr);
        while(sizeof($res) > 0) { array_pop($res); };
        $idx = $hexlen;
        while ($idx > 0) {
            $idx = $idx - 1;
            $digit = hexdec(substr($hexstr,  $idx, 1));
            $res[] = (($digit) & (1));
            $res[] = (((($digit) >> (1))) & (1));
            $res[] = (((($digit) >> (2))) & (1));
            $res[] = (((($digit) >> (3))) & (1));
        }
        return $res;
    }

    public function expectedNodes()
    { return $this->get_expectedNodes(); }

    public function setExpectedNodes($newval)
    { return $this->set_expectedNodes($newval); }

    public function detectedNodes()
    { return $this->get_detectedNodes(); }

    public function loopbackTest()
    { return $this->get_loopbackTest(); }

    public function setLoopbackTest($newval)
    { return $this->set_loopbackTest($newval); }

    public function refreshRate()
    { return $this->get_refreshRate(); }

    public function setRefreshRate($newval)
    { return $this->set_refreshRate($newval); }

    public function bitChain1()
    { return $this->get_bitChain1(); }

    public function bitChain2()
    { return $this->get_bitChain2(); }

    public function bitChain3()
    { return $this->get_bitChain3(); }

    public function bitChain4()
    { return $this->get_bitChain4(); }

    public function bitChain5()
    { return $this->get_bitChain5(); }

    public function bitChain6()
    { return $this->get_bitChain6(); }

    public function bitChain7()
    { return $this->get_bitChain7(); }

    public function watchdogPeriod()
    { return $this->get_watchdogPeriod(); }

    public function setWatchdogPeriod($newval)
    { return $this->set_watchdogPeriod($newval); }

    public function chainDiags()
    { return $this->get_chainDiags(); }

    /**
     * Continues the enumeration of digital input chains started using yFirstInputChain().
     * Caution: You can't make any assumption about the returned digital input chains order.
     * If you want to find a specific a digital input chain, use InputChain.findInputChain()
     * and a hardwareID or a logical name.
     *
     * @return YInputChain : a pointer to a YInputChain object, corresponding to
     *         a digital input chain currently online, or a null pointer
     *         if there are no more digital input chains to enumerate.
     */
    public function nextInputChain()
    {   $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) return null;
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if($next_hwid == null) return null;
        return self::FindInputChain($next_hwid);
    }

    /**
     * Starts the enumeration of digital input chains currently accessible.
     * Use the method YInputChain::nextInputChain() to iterate on
     * next digital input chains.
     *
     * @return YInputChain : a pointer to a YInputChain object, corresponding to
     *         the first digital input chain currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstInputChain()
    {   $next_hwid = YAPI::getFirstHardwareId('InputChain');
        if($next_hwid == null) return null;
        return self::FindInputChain($next_hwid);
    }

    //--- (end of YInputChain implementation)

};

//--- (YInputChain functions)

/**
 * Retrieves a digital input chain for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 *
 * This function does not require that the digital input chain is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method isOnline() to test if the digital input chain is
 * indeed online at a given time. In case of ambiguity when looking for
 * a digital input chain by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 *
 * If a call to this object's is_online() method returns FALSE although
 * you are certain that the matching device is plugged, make sure that you did
 * call registerHub() at application initialization time.
 *
 * @param string $func : a string that uniquely characterizes the digital input chain, for instance
 *         MyDevice.inputChain.
 *
 * @return YInputChain : a YInputChain object allowing you to drive the digital input chain.
 */
function yFindInputChain($func)
{
    return YInputChain::FindInputChain($func);
}

/**
 * Starts the enumeration of digital input chains currently accessible.
 * Use the method YInputChain::nextInputChain() to iterate on
 * next digital input chains.
 *
 * @return YInputChain : a pointer to a YInputChain object, corresponding to
 *         the first digital input chain currently online, or a null pointer
 *         if there are none.
 */
function yFirstInputChain()
{
    return YInputChain::FirstInputChain();
}

//--- (end of YInputChain functions)
?>