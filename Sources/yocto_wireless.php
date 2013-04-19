<?php
/*********************************************************************
 *
 * $Id: yocto_wireless.php 9979 2013-02-22 13:45:33Z seb $
 *
 * Implements yFindWireless(), the high-level API for Wireless functions
 *
 * - - - - - - - - - License information: - - - - - - - - - 
 *
 * Copyright (C) 2011 and beyond by Yoctopuce Sarl, Switzerland.
 *
 * 1) If you have obtained this file from www.yoctopuce.com,
 *    Yoctopuce Sarl licenses to you (hereafter Licensee) the
 *    right to use, modify, copy, and integrate this source file
 *    into your own solution for the sole purpose of interfacing
 *    a Yoctopuce product with Licensee's solution.
 *
 *    The use of this file and all relationship between Yoctopuce 
 *    and Licensee are governed by Yoctopuce General Terms and 
 *    Conditions.
 *
 *    THE SOFTWARE AND DOCUMENTATION ARE PROVIDED 'AS IS' WITHOUT
 *    WARRANTY OF ANY KIND, EITHER EXPRESS OR IMPLIED, INCLUDING 
 *    WITHOUT LIMITATION, ANY WARRANTY OF MERCHANTABILITY, FITNESS 
 *    FOR A PARTICULAR PURPOSE, TITLE AND NON-INFRINGEMENT. IN NO
 *    EVENT SHALL LICENSOR BE LIABLE FOR ANY INCIDENTAL, SPECIAL,
 *    INDIRECT OR CONSEQUENTIAL DAMAGES, LOST PROFITS OR LOST DATA, 
 *    COST OF PROCUREMENT OF SUBSTITUTE GOODS, TECHNOLOGY OR 
 *    SERVICES, ANY CLAIMS BY THIRD PARTIES (INCLUDING BUT NOT 
 *    LIMITED TO ANY DEFENSE THEREOF), ANY CLAIMS FOR INDEMNITY OR
 *    CONTRIBUTION, OR OTHER SIMILAR COSTS, WHETHER ASSERTED ON THE
 *    BASIS OF CONTRACT, TORT (INCLUDING NEGLIGENCE), BREACH OF
 *    WARRANTY, OR OTHERWISE.
 *
 * 2) If your intent is not to interface with Yoctopuce products,
 *    you are not entitled to use, read or create any derived
 *    material from this source file.
 *
 *********************************************************************/


//--- (return codes)
//--- (end of return codes)
//--- (YWireless definitions)
if(!defined('Y_SECURITY_UNKNOWN')) define('Y_SECURITY_UNKNOWN', 0);
if(!defined('Y_SECURITY_OPEN')) define('Y_SECURITY_OPEN', 1);
if(!defined('Y_SECURITY_WEP')) define('Y_SECURITY_WEP', 2);
if(!defined('Y_SECURITY_WPA')) define('Y_SECURITY_WPA', 3);
if(!defined('Y_SECURITY_WPA2')) define('Y_SECURITY_WPA2', 4);
if(!defined('Y_SECURITY_INVALID')) define('Y_SECURITY_INVALID', -1);
if(!defined('Y_LOGICALNAME_INVALID')) define('Y_LOGICALNAME_INVALID', Y_INVALID_STRING);
if(!defined('Y_ADVERTISEDVALUE_INVALID')) define('Y_ADVERTISEDVALUE_INVALID', Y_INVALID_STRING);
if(!defined('Y_LINKQUALITY_INVALID')) define('Y_LINKQUALITY_INVALID', Y_INVALID_UNSIGNED);
if(!defined('Y_SSID_INVALID')) define('Y_SSID_INVALID', Y_INVALID_STRING);
if(!defined('Y_CHANNEL_INVALID')) define('Y_CHANNEL_INVALID', Y_INVALID_UNSIGNED);
if(!defined('Y_MESSAGE_INVALID')) define('Y_MESSAGE_INVALID', Y_INVALID_STRING);
if(!defined('Y_WLANCONFIG_INVALID')) define('Y_WLANCONFIG_INVALID', Y_INVALID_STRING);
//--- (end of YWireless definitions)

/**
 * YWireless Class: Wireless function interface
 * 
 * 
 */
class YWireless extends YFunction
{
    //--- (YWireless implementation)
    const LOGICALNAME_INVALID = Y_INVALID_STRING;
    const ADVERTISEDVALUE_INVALID = Y_INVALID_STRING;
    const LINKQUALITY_INVALID = Y_INVALID_UNSIGNED;
    const SSID_INVALID = Y_INVALID_STRING;
    const CHANNEL_INVALID = Y_INVALID_UNSIGNED;
    const SECURITY_UNKNOWN = 0;
    const SECURITY_OPEN = 1;
    const SECURITY_WEP = 2;
    const SECURITY_WPA = 3;
    const SECURITY_WPA2 = 4;
    const SECURITY_INVALID = -1;
    const MESSAGE_INVALID = Y_INVALID_STRING;
    const WLANCONFIG_INVALID = Y_INVALID_STRING;

    /**
     * Returns the logical name of the wireless lan interface.
     * 
     * @return a string corresponding to the logical name of the wireless lan interface
     * 
     * On failure, throws an exception or returns Y_LOGICALNAME_INVALID.
     */
    public function get_logicalName()
    {   $json_val = $this->_getAttr("logicalName");
        return (is_null($json_val) ? Y_LOGICALNAME_INVALID : $json_val);
    }

    /**
     * Changes the logical name of the wireless lan interface. You can use yCheckLogicalName()
     * prior to this call to make sure that your parameter is valid.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     * 
     * @param newval : a string corresponding to the logical name of the wireless lan interface
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
     * Returns the current value of the wireless lan interface (no more than 6 characters).
     * 
     * @return a string corresponding to the current value of the wireless lan interface (no more than 6 characters)
     * 
     * On failure, throws an exception or returns Y_ADVERTISEDVALUE_INVALID.
     */
    public function get_advertisedValue()
    {   $json_val = $this->_getAttr("advertisedValue");
        return (is_null($json_val) ? Y_ADVERTISEDVALUE_INVALID : $json_val);
    }

    /**
     * Returns the link quality, expressed in per cents.
     * 
     * @return an integer corresponding to the link quality, expressed in per cents
     * 
     * On failure, throws an exception or returns Y_LINKQUALITY_INVALID.
     */
    public function get_linkQuality()
    {   $json_val = $this->_getAttr("linkQuality");
        return (is_null($json_val) ? Y_LINKQUALITY_INVALID : intval($json_val));
    }

    /**
     * Returns the wireless network name (SSID).
     * 
     * @return a string corresponding to the wireless network name (SSID)
     * 
     * On failure, throws an exception or returns Y_SSID_INVALID.
     */
    public function get_ssid()
    {   $json_val = $this->_getAttr("ssid");
        return (is_null($json_val) ? Y_SSID_INVALID : $json_val);
    }

    /**
     * Returns the 802.11 channel currently used, or 0 when the selected network has not been found.
     * 
     * @return an integer corresponding to the 802
     * 
     * On failure, throws an exception or returns Y_CHANNEL_INVALID.
     */
    public function get_channel()
    {   $json_val = $this->_getAttr("channel");
        return (is_null($json_val) ? Y_CHANNEL_INVALID : intval($json_val));
    }

    /**
     * Returns the security algorithm used by the selected wireless network.
     * 
     * @return a value among Y_SECURITY_UNKNOWN, Y_SECURITY_OPEN, Y_SECURITY_WEP, Y_SECURITY_WPA and
     * Y_SECURITY_WPA2 corresponding to the security algorithm used by the selected wireless network
     * 
     * On failure, throws an exception or returns Y_SECURITY_INVALID.
     */
    public function get_security()
    {   $json_val = $this->_getAttr("security");
        return (is_null($json_val) ? Y_SECURITY_INVALID : intval($json_val));
    }

    /**
     * Returns the last status message from the wireless interface.
     * 
     * @return a string corresponding to the last status message from the wireless interface
     * 
     * On failure, throws an exception or returns Y_MESSAGE_INVALID.
     */
    public function get_message()
    {   $json_val = $this->_getAttr("message");
        return (is_null($json_val) ? Y_MESSAGE_INVALID : $json_val);
    }

    public function get_wlanConfig()
    {   $json_val = $this->_getAttr("wlanConfig");
        return (is_null($json_val) ? Y_WLANCONFIG_INVALID : $json_val);
    }

    public function set_wlanConfig($newval)
    {
        $rest_val = $newval;
        return $this->_setAttr("wlanConfig",$rest_val);
    }

    /**
     * Changes the configuration of the wireless lan interface to connect to an existing
     * access point (infrastructure mode).
     * Remember to call the saveToFlash() method and then to reboot the module to apply this setting.
     * 
     * @param ssid : the name of the network to connect to
     * @param securityKey : the network key, as a character string
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function joinNetwork($str_ssid,$str_securityKey)
    {
        $rest_val = sprintf("INFRA:%s\\%s", $str_ssid, $str_securityKey);
        return $this->_setAttr("wlanConfig",$rest_val);
    }

    /**
     * Changes the configuration of the wireless lan interface to create an ad-hoc
     * wireless network, without using an access point. If a security key is specified,
     * the network will be protected by WEP128, since WPA is not standardized for
     * ad-hoc networks.
     * Remember to call the saveToFlash() method and then to reboot the module to apply this setting.
     * 
     * @param ssid : the name of the network to connect to
     * @param securityKey : the network key, as a character string
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function adhocNetwork($str_ssid,$str_securityKey)
    {
        $rest_val = sprintf("ADHOC:%s\\%s", $str_ssid, $str_securityKey);
        return $this->_setAttr("wlanConfig",$rest_val);
    }

    public function logicalName()
    { return get_logicalName(); }

    public function setLogicalName($newval)
    { return set_logicalName($newval); }

    public function advertisedValue()
    { return get_advertisedValue(); }

    public function linkQuality()
    { return get_linkQuality(); }

    public function ssid()
    { return get_ssid(); }

    public function channel()
    { return get_channel(); }

    public function security()
    { return get_security(); }

    public function message()
    { return get_message(); }

    public function wlanConfig()
    { return get_wlanConfig(); }

    public function setWlanConfig($newval)
    { return set_wlanConfig($newval); }

    /**
     * Continues the enumeration of wireless lan interfaces started using yFirstWireless().
     * 
     * @return a pointer to a YWireless object, corresponding to
     *         a wireless lan interface currently online, or a null pointer
     *         if there are no more wireless lan interfaces to enumerate.
     */
    public function nextWireless()
    {   $next_hwid = YAPI::getNextHardwareId($this->_className, $this->_func);
        if($next_hwid == null) return null;
        return yFindWireless($next_hwid);
    }

    /**
     * Retrieves a wireless lan interface for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     * 
     * This function does not require that the wireless lan interface is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YWireless.isOnline() to test if the wireless lan interface is
     * indeed online at a given time. In case of ambiguity when looking for
     * a wireless lan interface by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     * 
     * @param func : a string that uniquely characterizes the wireless lan interface
     * 
     * @return a YWireless object allowing you to drive the wireless lan interface.
     */
    public static function FindWireless($str_func)
    {   $obj_func = YAPI::getFunction('Wireless', $str_func);
        if($obj_func) return $obj_func;
        return new YWireless($str_func);
    }

    /**
     * Starts the enumeration of wireless lan interfaces currently accessible.
     * Use the method YWireless.nextWireless() to iterate on
     * next wireless lan interfaces.
     * 
     * @return a pointer to a YWireless object, corresponding to
     *         the first wireless lan interface currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstWireless()
    {   $next_hwid = YAPI::getFirstHardwareId('Wireless');
        if($next_hwid == null) return null;
        return self::FindWireless($next_hwid);
    }

    //--- (end of YWireless implementation)

    function __construct($str_func)
    {
        //--- (YWireless constructor)
        parent::__construct('Wireless', $str_func);
        //--- (end of YWireless constructor)
    }
};

//--- (Wireless functions)

/**
 * Retrieves a wireless lan interface for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 * 
 * This function does not require that the wireless lan interface is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YWireless.isOnline() to test if the wireless lan interface is
 * indeed online at a given time. In case of ambiguity when looking for
 * a wireless lan interface by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 * 
 * @param func : a string that uniquely characterizes the wireless lan interface
 * 
 * @return a YWireless object allowing you to drive the wireless lan interface.
 */
function yFindWireless($str_func)
{
    return YWireless::FindWireless($str_func);
}

/**
 * Starts the enumeration of wireless lan interfaces currently accessible.
 * Use the method YWireless.nextWireless() to iterate on
 * next wireless lan interfaces.
 * 
 * @return a pointer to a YWireless object, corresponding to
 *         the first wireless lan interface currently online, or a null pointer
 *         if there are none.
 */
function yFirstWireless()
{
    return YWireless::FirstWireless();
}

//--- (end of Wireless functions)
?>