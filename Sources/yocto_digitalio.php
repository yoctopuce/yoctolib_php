<?php
/*********************************************************************
 *
 * $Id: pic24config.php 12323 2013-08-13 15:09:18Z mvuilleu $
 *
 * Implements yFindDigitalIO(), the high-level API for DigitalIO functions
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


//--- (return codes)
//--- (end of return codes)
//--- (YDigitalIO definitions)
if(!defined('Y_OUTPUTVOLTAGE_USB_5V')) define('Y_OUTPUTVOLTAGE_USB_5V', 0);
if(!defined('Y_OUTPUTVOLTAGE_USB_3V3')) define('Y_OUTPUTVOLTAGE_USB_3V3', 1);
if(!defined('Y_OUTPUTVOLTAGE_EXT_V')) define('Y_OUTPUTVOLTAGE_EXT_V', 2);
if(!defined('Y_OUTPUTVOLTAGE_INVALID')) define('Y_OUTPUTVOLTAGE_INVALID', -1);
if(!defined('Y_LOGICALNAME_INVALID')) define('Y_LOGICALNAME_INVALID', Y_INVALID_STRING);
if(!defined('Y_ADVERTISEDVALUE_INVALID')) define('Y_ADVERTISEDVALUE_INVALID', Y_INVALID_STRING);
if(!defined('Y_PORTSTATE_INVALID')) define('Y_PORTSTATE_INVALID', Y_INVALID_UNSIGNED);
if(!defined('Y_PORTDIRECTION_INVALID')) define('Y_PORTDIRECTION_INVALID', Y_INVALID_UNSIGNED);
if(!defined('Y_PORTOPENDRAIN_INVALID')) define('Y_PORTOPENDRAIN_INVALID', Y_INVALID_UNSIGNED);
if(!defined('Y_PORTSIZE_INVALID')) define('Y_PORTSIZE_INVALID', Y_INVALID_UNSIGNED);
if(!defined('Y_COMMAND_INVALID')) define('Y_COMMAND_INVALID', Y_INVALID_STRING);
//--- (end of YDigitalIO definitions)

/**
 * YDigitalIO Class: Digital IO function interface
 * 
 * ....
 */
class YDigitalIO extends YFunction
{
    //--- (YDigitalIO implementation)
    const LOGICALNAME_INVALID = Y_INVALID_STRING;
    const ADVERTISEDVALUE_INVALID = Y_INVALID_STRING;
    const PORTSTATE_INVALID = Y_INVALID_UNSIGNED;
    const PORTDIRECTION_INVALID = Y_INVALID_UNSIGNED;
    const PORTOPENDRAIN_INVALID = Y_INVALID_UNSIGNED;
    const PORTSIZE_INVALID = Y_INVALID_UNSIGNED;
    const OUTPUTVOLTAGE_USB_5V = 0;
    const OUTPUTVOLTAGE_USB_3V3 = 1;
    const OUTPUTVOLTAGE_EXT_V = 2;
    const OUTPUTVOLTAGE_INVALID = -1;
    const COMMAND_INVALID = Y_INVALID_STRING;

    /**
     * Returns the logical name of the digital IO port.
     * 
     * @return a string corresponding to the logical name of the digital IO port
     * 
     * On failure, throws an exception or returns Y_LOGICALNAME_INVALID.
     */
    public function get_logicalName()
    {   $json_val = $this->_getAttr("logicalName");
        return (is_null($json_val) ? Y_LOGICALNAME_INVALID : $json_val);
    }

    /**
     * Changes the logical name of the digital IO port. You can use yCheckLogicalName()
     * prior to this call to make sure that your parameter is valid.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     * 
     * @param newval : a string corresponding to the logical name of the digital IO port
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_logicalName($newval)
    {
        $rest_val = $newval;
        return $this->_setAttr("logicalName",$rest_val);
    }

    /**
     * Returns the current value of the digital IO port (no more than 6 characters).
     * 
     * @return a string corresponding to the current value of the digital IO port (no more than 6 characters)
     * 
     * On failure, throws an exception or returns Y_ADVERTISEDVALUE_INVALID.
     */
    public function get_advertisedValue()
    {   $json_val = $this->_getAttr("advertisedValue");
        return (is_null($json_val) ? Y_ADVERTISEDVALUE_INVALID : $json_val);
    }

    /**
     * Returns the digital IO port state: bit 0 represents input 0, and so on.
     * 
     * @return an integer corresponding to the digital IO port state: bit 0 represents input 0, and so on
     * 
     * On failure, throws an exception or returns Y_PORTSTATE_INVALID.
     */
    public function get_portState()
    {   $json_val = $this->_getAttr("portState");
        return (is_null($json_val) ? Y_PORTSTATE_INVALID : intval($json_val));
    }

    /**
     * Changes the digital IO port state: bit 0 represents input 0, and so on. This function has no effect
     * on bits configured as input in portDirection.
     * 
     * @param newval : an integer corresponding to the digital IO port state: bit 0 represents input 0, and so on
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_portState($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("portState",$rest_val);
    }

    /**
     * Returns the IO direction of all bits of the port: 0 makes a bit an input, 1 makes it an output.
     * 
     * @return an integer corresponding to the IO direction of all bits of the port: 0 makes a bit an
     * input, 1 makes it an output
     * 
     * On failure, throws an exception or returns Y_PORTDIRECTION_INVALID.
     */
    public function get_portDirection()
    {   $json_val = $this->_getAttr("portDirection");
        return (is_null($json_val) ? Y_PORTDIRECTION_INVALID : intval($json_val));
    }

    /**
     * Changes the IO direction of all bits of the port: 0 makes a bit an input, 1 makes it an output.
     * Remember to call the saveToFlash() method  to make sure the setting will be kept after a reboot.
     * 
     * @param newval : an integer corresponding to the IO direction of all bits of the port: 0 makes a bit
     * an input, 1 makes it an output
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_portDirection($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("portDirection",$rest_val);
    }

    /**
     * Returns the electrical interface for each bit of the port. 0 makes a bit a regular input/output, 1 makes
     * it an open-drain (open-collector) input/output.
     * 
     * @return an integer corresponding to the electrical interface for each bit of the port
     * 
     * On failure, throws an exception or returns Y_PORTOPENDRAIN_INVALID.
     */
    public function get_portOpenDrain()
    {   $json_val = $this->_getAttr("portOpenDrain");
        return (is_null($json_val) ? Y_PORTOPENDRAIN_INVALID : intval($json_val));
    }

    /**
     * Changes the electrical interface for each bit of the port. 0 makes a bit a regular input/output, 1 makes
     * it an open-drain (open-collector) input/output. Remember to call the
     * saveToFlash() method  to make sure the setting will be kept after a reboot.
     * 
     * @param newval : an integer corresponding to the electrical interface for each bit of the port
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_portOpenDrain($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("portOpenDrain",$rest_val);
    }

    /**
     * Returns the number of bits implemented in the I/O port.
     * 
     * @return an integer corresponding to the number of bits implemented in the I/O port
     * 
     * On failure, throws an exception or returns Y_PORTSIZE_INVALID.
     */
    public function get_portSize()
    {   $json_val = $this->_getAttr("portSize");
        return (is_null($json_val) ? Y_PORTSIZE_INVALID : intval($json_val));
    }

    /**
     * Returns the voltage source used to drive output bits.
     * 
     * @return a value among Y_OUTPUTVOLTAGE_USB_5V, Y_OUTPUTVOLTAGE_USB_3V3 and Y_OUTPUTVOLTAGE_EXT_V
     * corresponding to the voltage source used to drive output bits
     * 
     * On failure, throws an exception or returns Y_OUTPUTVOLTAGE_INVALID.
     */
    public function get_outputVoltage()
    {   $json_val = $this->_getAttr("outputVoltage");
        return (is_null($json_val) ? Y_OUTPUTVOLTAGE_INVALID : intval($json_val));
    }

    /**
     * Changes the voltage source used to drive output bits.
     * Remember to call the saveToFlash() method  to make sure the setting will be kept after a reboot.
     * 
     * @param newval : a value among Y_OUTPUTVOLTAGE_USB_5V, Y_OUTPUTVOLTAGE_USB_3V3 and
     * Y_OUTPUTVOLTAGE_EXT_V corresponding to the voltage source used to drive output bits
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_outputVoltage($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("outputVoltage",$rest_val);
    }

    public function get_command()
    {   $json_val = $this->_getAttr("command");
        return (is_null($json_val) ? Y_COMMAND_INVALID : $json_val);
    }

    public function set_command($newval)
    {
        $rest_val = $newval;
        return $this->_setAttr("command",$rest_val);
    }

    /**
     * Set a single bit of the I/O port.
     * 
     * @param bitno: the bit number; lowest bit is index 0
     * @param bitval: the value of the bit (1 or 0)
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_bitState($int_bitno,$int_bitval)
    {
        if (!($int_bitval >= 0)) return $this->_throw( YAPI_INVALID_ARGUMENT, 'invalid bitval', YAPI_INVALID_ARGUMENT);
        if (!($int_bitval <= 1)) return $this->_throw( YAPI_INVALID_ARGUMENT, 'invalid bitval', YAPI_INVALID_ARGUMENT);
        return $this->set_command(sprintf('%c%d',82+bitval, bitno)); 
        
    }

    /**
     * Returns the value of a single bit of the I/O port.
     * 
     * @param bitno: the bit number; lowest bit is index 0
     * 
     * @return the bit value (0 or 1)
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function get_bitState($int_bitno)
    {
        // $portVal is a int;
        $portVal = $this->get_portState();
        return (((($portVal) >> ($int_bitno))) & (1));
        
    }

    /**
     * Revert a single bit of the I/O port.
     * 
     * @param bitno: the bit number; lowest bit is index 0
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function toggle_bitState($int_bitno)
    {
        return $this->set_command(sprintf('T%d', bitno)); 
        
    }

    /**
     * Change  the direction of a single bit from the I/O port.
     * 
     * @param bitno: the bit number; lowest bit is index 0
     * @param bitdirection: direction to set, 0 makes the bit an input, 1 makes it an output.
     *         Remember to call the   saveToFlash() method to make sure the setting will be kept after a reboot.
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_bitDirection($int_bitno,$int_bitdirection)
    {
        if (!($int_bitdirection >= 0)) return $this->_throw( YAPI_INVALID_ARGUMENT, 'invalid direction', YAPI_INVALID_ARGUMENT);
        if (!($int_bitdirection <= 1)) return $this->_throw( YAPI_INVALID_ARGUMENT, 'invalid direction', YAPI_INVALID_ARGUMENT);
        return $this->set_command(sprintf('%c%d',73+6*bitdirection, bitno)); 
        
    }

    /**
     * Change  the direction of a single bit from the I/O port (0 means the bit is an input, 1  an output).
     * 
     * @param bitno: the bit number; lowest bit is index 0
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function get_bitDirection($int_bitno)
    {
        // $portDir is a int;
        $portDir = $this->get_portDirection();
        return (((($portDir) >> ($int_bitno))) & (1));
        
    }

    /**
     * Change  the electrical interface of a single bit from the I/O port.
     * 
     * @param bitno: the bit number; lowest bit is index 0
     * @param opendrain: value to set, 0 makes a bit a regular input/output, 1 makes
     *         it an open-drain (open-collector) input/output. Remember to call the
     *         saveToFlash() method to make sure the setting will be kept after a reboot.
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_bitOpenDrain($int_bitno,$int_opendrain)
    {
        if (!($int_opendrain >= 0)) return $this->_throw( YAPI_INVALID_ARGUMENT, 'invalid state', YAPI_INVALID_ARGUMENT);
        if (!($int_opendrain <= 1)) return $this->_throw( YAPI_INVALID_ARGUMENT, 'invalid state', YAPI_INVALID_ARGUMENT);
        return $this->set_command(sprintf('%c%d',100-32*opendrain, bitno)); 
        
    }

    /**
     * Returns the type of electrical interface of a single bit from the I/O port. (0 means the bit is an
     * input, 1  an output).
     * 
     * @param bitno: the bit number; lowest bit is index 0
     * 
     * @return   0 means the a bit is a regular input/output, 1means the b it an open-drain
     * (open-collector) input/output.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function get_bitOpenDrain($int_bitno)
    {
        // $portOpenDrain is a int;
        $portOpenDrain = $this->get_portOpenDrain();
        return (((($portOpenDrain) >> ($int_bitno))) & (1));
        
    }

    public function logicalName()
    { return get_logicalName(); }

    public function setLogicalName($newval)
    { return set_logicalName($newval); }

    public function advertisedValue()
    { return get_advertisedValue(); }

    public function portState()
    { return get_portState(); }

    public function setPortState($newval)
    { return set_portState($newval); }

    public function portDirection()
    { return get_portDirection(); }

    public function setPortDirection($newval)
    { return set_portDirection($newval); }

    public function portOpenDrain()
    { return get_portOpenDrain(); }

    public function setPortOpenDrain($newval)
    { return set_portOpenDrain($newval); }

    public function portSize()
    { return get_portSize(); }

    public function outputVoltage()
    { return get_outputVoltage(); }

    public function setOutputVoltage($newval)
    { return set_outputVoltage($newval); }

    public function command()
    { return get_command(); }

    public function setCommand($newval)
    { return set_command($newval); }

    /**
     * Continues the enumeration of digital IO port started using yFirstDigitalIO().
     * 
     * @return a pointer to a YDigitalIO object, corresponding to
     *         a digital IO port currently online, or a null pointer
     *         if there are no more digital IO port to enumerate.
     */
    public function nextDigitalIO()
    {   $next_hwid = YAPI::getNextHardwareId($this->_className, $this->_func);
        if($next_hwid == null) return null;
        return yFindDigitalIO($next_hwid);
    }

    /**
     * Retrieves a digital IO port for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     * 
     * This function does not require that the digital IO port is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YDigitalIO.isOnline() to test if the digital IO port is
     * indeed online at a given time. In case of ambiguity when looking for
     * a digital IO port by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     * 
     * @param func : a string that uniquely characterizes the digital IO port
     * 
     * @return a YDigitalIO object allowing you to drive the digital IO port.
     */
    public static function FindDigitalIO($str_func)
    {   $obj_func = YAPI::getFunction('DigitalIO', $str_func);
        if($obj_func) return $obj_func;
        return new YDigitalIO($str_func);
    }

    /**
     * Starts the enumeration of digital IO port currently accessible.
     * Use the method YDigitalIO.nextDigitalIO() to iterate on
     * next digital IO port.
     * 
     * @return a pointer to a YDigitalIO object, corresponding to
     *         the first digital IO port currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstDigitalIO()
    {   $next_hwid = YAPI::getFirstHardwareId('DigitalIO');
        if($next_hwid == null) return null;
        return self::FindDigitalIO($next_hwid);
    }

    //--- (end of YDigitalIO implementation)

    function __construct($str_func)
    {
        //--- (YDigitalIO constructor)
        parent::__construct('DigitalIO', $str_func);
        //--- (end of YDigitalIO constructor)
    }
};

//--- (DigitalIO functions)

/**
 * Retrieves a digital IO port for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 * 
 * This function does not require that the digital IO port is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YDigitalIO.isOnline() to test if the digital IO port is
 * indeed online at a given time. In case of ambiguity when looking for
 * a digital IO port by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 * 
 * @param func : a string that uniquely characterizes the digital IO port
 * 
 * @return a YDigitalIO object allowing you to drive the digital IO port.
 */
function yFindDigitalIO($str_func)
{
    return YDigitalIO::FindDigitalIO($str_func);
}

/**
 * Starts the enumeration of digital IO port currently accessible.
 * Use the method YDigitalIO.nextDigitalIO() to iterate on
 * next digital IO port.
 * 
 * @return a pointer to a YDigitalIO object, corresponding to
 *         the first digital IO port currently online, or a null pointer
 *         if there are none.
 */
function yFirstDigitalIO()
{
    return YDigitalIO::FirstDigitalIO();
}

//--- (end of DigitalIO functions)
?>