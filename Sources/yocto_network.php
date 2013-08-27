<?php
/*********************************************************************
 *
 * $Id: yocto_network.php 12337 2013-08-14 15:22:22Z mvuilleu $
 *
 * Implements yFindNetwork(), the high-level API for Network functions
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
//--- (YNetwork definitions)
if(!defined('Y_READINESS_DOWN')) define('Y_READINESS_DOWN', 0);
if(!defined('Y_READINESS_EXISTS')) define('Y_READINESS_EXISTS', 1);
if(!defined('Y_READINESS_LINKED')) define('Y_READINESS_LINKED', 2);
if(!defined('Y_READINESS_LAN_OK')) define('Y_READINESS_LAN_OK', 3);
if(!defined('Y_READINESS_WWW_OK')) define('Y_READINESS_WWW_OK', 4);
if(!defined('Y_READINESS_INVALID')) define('Y_READINESS_INVALID', -1);
if(!defined('Y_DISCOVERABLE_FALSE')) define('Y_DISCOVERABLE_FALSE', 0);
if(!defined('Y_DISCOVERABLE_TRUE')) define('Y_DISCOVERABLE_TRUE', 1);
if(!defined('Y_DISCOVERABLE_INVALID')) define('Y_DISCOVERABLE_INVALID', -1);
if(!defined('Y_CALLBACKMETHOD_POST')) define('Y_CALLBACKMETHOD_POST', 0);
if(!defined('Y_CALLBACKMETHOD_GET')) define('Y_CALLBACKMETHOD_GET', 1);
if(!defined('Y_CALLBACKMETHOD_PUT')) define('Y_CALLBACKMETHOD_PUT', 2);
if(!defined('Y_CALLBACKMETHOD_INVALID')) define('Y_CALLBACKMETHOD_INVALID', -1);
if(!defined('Y_CALLBACKENCODING_FORM')) define('Y_CALLBACKENCODING_FORM', 0);
if(!defined('Y_CALLBACKENCODING_JSON')) define('Y_CALLBACKENCODING_JSON', 1);
if(!defined('Y_CALLBACKENCODING_JSON_ARRAY')) define('Y_CALLBACKENCODING_JSON_ARRAY', 2);
if(!defined('Y_CALLBACKENCODING_CSV')) define('Y_CALLBACKENCODING_CSV', 3);
if(!defined('Y_CALLBACKENCODING_YOCTO_API')) define('Y_CALLBACKENCODING_YOCTO_API', 4);
if(!defined('Y_CALLBACKENCODING_INVALID')) define('Y_CALLBACKENCODING_INVALID', -1);
if(!defined('Y_LOGICALNAME_INVALID')) define('Y_LOGICALNAME_INVALID', Y_INVALID_STRING);
if(!defined('Y_ADVERTISEDVALUE_INVALID')) define('Y_ADVERTISEDVALUE_INVALID', Y_INVALID_STRING);
if(!defined('Y_MACADDRESS_INVALID')) define('Y_MACADDRESS_INVALID', Y_INVALID_STRING);
if(!defined('Y_IPADDRESS_INVALID')) define('Y_IPADDRESS_INVALID', Y_INVALID_STRING);
if(!defined('Y_SUBNETMASK_INVALID')) define('Y_SUBNETMASK_INVALID', Y_INVALID_STRING);
if(!defined('Y_ROUTER_INVALID')) define('Y_ROUTER_INVALID', Y_INVALID_STRING);
if(!defined('Y_IPCONFIG_INVALID')) define('Y_IPCONFIG_INVALID', Y_INVALID_STRING);
if(!defined('Y_PRIMARYDNS_INVALID')) define('Y_PRIMARYDNS_INVALID', Y_INVALID_STRING);
if(!defined('Y_SECONDARYDNS_INVALID')) define('Y_SECONDARYDNS_INVALID', Y_INVALID_STRING);
if(!defined('Y_USERPASSWORD_INVALID')) define('Y_USERPASSWORD_INVALID', Y_INVALID_STRING);
if(!defined('Y_ADMINPASSWORD_INVALID')) define('Y_ADMINPASSWORD_INVALID', Y_INVALID_STRING);
if(!defined('Y_WWWWATCHDOGDELAY_INVALID')) define('Y_WWWWATCHDOGDELAY_INVALID', Y_INVALID_UNSIGNED);
if(!defined('Y_CALLBACKURL_INVALID')) define('Y_CALLBACKURL_INVALID', Y_INVALID_STRING);
if(!defined('Y_CALLBACKCREDENTIALS_INVALID')) define('Y_CALLBACKCREDENTIALS_INVALID', Y_INVALID_STRING);
if(!defined('Y_CALLBACKMINDELAY_INVALID')) define('Y_CALLBACKMINDELAY_INVALID', Y_INVALID_UNSIGNED);
if(!defined('Y_CALLBACKMAXDELAY_INVALID')) define('Y_CALLBACKMAXDELAY_INVALID', Y_INVALID_UNSIGNED);
if(!defined('Y_POECURRENT_INVALID')) define('Y_POECURRENT_INVALID', Y_INVALID_UNSIGNED);
//--- (end of YNetwork definitions)

/**
 * YNetwork Class: Network function interface
 * 
 * YNetwork objects provide access to TCP/IP parameters of Yoctopuce
 * modules that include a built-in network interface.
 */
class YNetwork extends YFunction
{
    //--- (YNetwork implementation)
    const LOGICALNAME_INVALID = Y_INVALID_STRING;
    const ADVERTISEDVALUE_INVALID = Y_INVALID_STRING;
    const READINESS_DOWN = 0;
    const READINESS_EXISTS = 1;
    const READINESS_LINKED = 2;
    const READINESS_LAN_OK = 3;
    const READINESS_WWW_OK = 4;
    const READINESS_INVALID = -1;
    const MACADDRESS_INVALID = Y_INVALID_STRING;
    const IPADDRESS_INVALID = Y_INVALID_STRING;
    const SUBNETMASK_INVALID = Y_INVALID_STRING;
    const ROUTER_INVALID = Y_INVALID_STRING;
    const IPCONFIG_INVALID = Y_INVALID_STRING;
    const PRIMARYDNS_INVALID = Y_INVALID_STRING;
    const SECONDARYDNS_INVALID = Y_INVALID_STRING;
    const USERPASSWORD_INVALID = Y_INVALID_STRING;
    const ADMINPASSWORD_INVALID = Y_INVALID_STRING;
    const DISCOVERABLE_FALSE = 0;
    const DISCOVERABLE_TRUE = 1;
    const DISCOVERABLE_INVALID = -1;
    const WWWWATCHDOGDELAY_INVALID = Y_INVALID_UNSIGNED;
    const CALLBACKURL_INVALID = Y_INVALID_STRING;
    const CALLBACKMETHOD_POST = 0;
    const CALLBACKMETHOD_GET = 1;
    const CALLBACKMETHOD_PUT = 2;
    const CALLBACKMETHOD_INVALID = -1;
    const CALLBACKENCODING_FORM = 0;
    const CALLBACKENCODING_JSON = 1;
    const CALLBACKENCODING_JSON_ARRAY = 2;
    const CALLBACKENCODING_CSV = 3;
    const CALLBACKENCODING_YOCTO_API = 4;
    const CALLBACKENCODING_INVALID = -1;
    const CALLBACKCREDENTIALS_INVALID = Y_INVALID_STRING;
    const CALLBACKMINDELAY_INVALID = Y_INVALID_UNSIGNED;
    const CALLBACKMAXDELAY_INVALID = Y_INVALID_UNSIGNED;
    const POECURRENT_INVALID = Y_INVALID_UNSIGNED;

    /**
     * Returns the logical name of the network interface, corresponding to the network name of the module.
     * 
     * @return a string corresponding to the logical name of the network interface, corresponding to the
     * network name of the module
     * 
     * On failure, throws an exception or returns Y_LOGICALNAME_INVALID.
     */
    public function get_logicalName()
    {   $json_val = $this->_getAttr("logicalName");
        return (is_null($json_val) ? Y_LOGICALNAME_INVALID : $json_val);
    }

    /**
     * Changes the logical name of the network interface, corresponding to the network name of the module.
     * You can use yCheckLogicalName()
     * prior to this call to make sure that your parameter is valid.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     * 
     * @param newval : a string corresponding to the logical name of the network interface, corresponding
     * to the network name of the module
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
     * Returns the current value of the network interface (no more than 6 characters).
     * 
     * @return a string corresponding to the current value of the network interface (no more than 6 characters)
     * 
     * On failure, throws an exception or returns Y_ADVERTISEDVALUE_INVALID.
     */
    public function get_advertisedValue()
    {   $json_val = $this->_getAttr("advertisedValue");
        return (is_null($json_val) ? Y_ADVERTISEDVALUE_INVALID : $json_val);
    }

    /**
     * Returns the current established working mode of the network interface.
     * Level zero (DOWN_0) means that no hardware link has been detected. Either there is no signal
     * on the network cable, or the selected wireless access point cannot be detected.
     * Level 1 (LIVE_1) is reached when the network is detected, but is not yet connected,
     * For a wireless network, this shows that the requested SSID is present.
     * Level 2 (LINK_2) is reached when the hardware connection is established.
     * For a wired network connection, level 2 means that the cable is attached at both ends.
     * For a connection to a wireless access point, it shows that the security parameters
     * are properly configured. For an ad-hoc wireless connection, it means that there is
     * at least one other device connected on the ad-hoc network.
     * Level 3 (DHCP_3) is reached when an IP address has been obtained using DHCP.
     * Level 4 (DNS_4) is reached when the DNS server is reachable on the network.
     * Level 5 (WWW_5) is reached when global connectivity is demonstrated by properly loading the
     * current time from an NTP server.
     * 
     * @return a value among Y_READINESS_DOWN, Y_READINESS_EXISTS, Y_READINESS_LINKED, Y_READINESS_LAN_OK
     * and Y_READINESS_WWW_OK corresponding to the current established working mode of the network interface
     * 
     * On failure, throws an exception or returns Y_READINESS_INVALID.
     */
    public function get_readiness()
    {   $json_val = $this->_getAttr("readiness");
        return (is_null($json_val) ? Y_READINESS_INVALID : intval($json_val));
    }

    /**
     * Returns the MAC address of the network interface. The MAC address is also available on a sticker
     * on the module, in both numeric and barcode forms.
     * 
     * @return a string corresponding to the MAC address of the network interface
     * 
     * On failure, throws an exception or returns Y_MACADDRESS_INVALID.
     */
    public function get_macAddress()
    {   $json_val = $this->_getFixedAttr("macAddress");
        return (is_null($json_val) ? Y_MACADDRESS_INVALID : $json_val);
    }

    /**
     * Returns the IP address currently in use by the device. The adress may have been configured
     * statically, or provided by a DHCP server.
     * 
     * @return a string corresponding to the IP address currently in use by the device
     * 
     * On failure, throws an exception or returns Y_IPADDRESS_INVALID.
     */
    public function get_ipAddress()
    {   $json_val = $this->_getAttr("ipAddress");
        return (is_null($json_val) ? Y_IPADDRESS_INVALID : $json_val);
    }

    /**
     * Returns the subnet mask currently used by the device.
     * 
     * @return a string corresponding to the subnet mask currently used by the device
     * 
     * On failure, throws an exception or returns Y_SUBNETMASK_INVALID.
     */
    public function get_subnetMask()
    {   $json_val = $this->_getAttr("subnetMask");
        return (is_null($json_val) ? Y_SUBNETMASK_INVALID : $json_val);
    }

    /**
     * Returns the IP address of the router on the device subnet (default gateway).
     * 
     * @return a string corresponding to the IP address of the router on the device subnet (default gateway)
     * 
     * On failure, throws an exception or returns Y_ROUTER_INVALID.
     */
    public function get_router()
    {   $json_val = $this->_getAttr("router");
        return (is_null($json_val) ? Y_ROUTER_INVALID : $json_val);
    }

    public function get_ipConfig()
    {   $json_val = $this->_getAttr("ipConfig");
        return (is_null($json_val) ? Y_IPCONFIG_INVALID : $json_val);
    }

    public function set_ipConfig($newval)
    {
        $rest_val = $newval;
        return $this->_setAttr("ipConfig",$rest_val);
    }

    /**
     * Changes the configuration of the network interface to enable the use of an
     * IP address received from a DHCP server. Until an address is received from a DHCP
     * server, the module uses the IP parameters specified to this function.
     * Remember to call the saveToFlash() method and then to reboot the module to apply this setting.
     * 
     * @param fallbackIpAddr : fallback IP address, to be used when no DHCP reply is received
     * @param fallbackSubnetMaskLen : fallback subnet mask length when no DHCP reply is received, as an
     *         integer (eg. 24 means 255.255.255.0)
     * @param fallbackRouter : fallback router IP address, to be used when no DHCP reply is received
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function useDHCP($str_fallbackIpAddr,$int_fallbackSubnetMaskLen,$str_fallbackRouter)
    {
        $rest_val = sprintf("DHCP:%s/%d/%s", $str_fallbackIpAddr, $int_fallbackSubnetMaskLen, $str_fallbackRouter);
        return $this->_setAttr("ipConfig",$rest_val);
    }

    /**
     * Changes the configuration of the network interface to use a static IP address.
     * Remember to call the saveToFlash() method and then to reboot the module to apply this setting.
     * 
     * @param ipAddress : device IP address
     * @param subnetMaskLen : subnet mask length, as an integer (eg. 24 means 255.255.255.0)
     * @param router : router IP address (default gateway)
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function useStaticIP($str_ipAddress,$int_subnetMaskLen,$str_router)
    {
        $rest_val = sprintf("STATIC:%s/%d/%s", $str_ipAddress, $int_subnetMaskLen, $str_router);
        return $this->_setAttr("ipConfig",$rest_val);
    }

    /**
     * Returns the IP address of the primary name server to be used by the module.
     * 
     * @return a string corresponding to the IP address of the primary name server to be used by the module
     * 
     * On failure, throws an exception or returns Y_PRIMARYDNS_INVALID.
     */
    public function get_primaryDNS()
    {   $json_val = $this->_getAttr("primaryDNS");
        return (is_null($json_val) ? Y_PRIMARYDNS_INVALID : $json_val);
    }

    /**
     * Changes the IP address of the primary name server to be used by the module.
     * When using DHCP, if a value is specified, it overrides the value received from the DHCP server.
     * Remember to call the saveToFlash() method and then to reboot the module to apply this setting.
     * 
     * @param newval : a string corresponding to the IP address of the primary name server to be used by the module
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_primaryDNS($newval)
    {
        $rest_val = $newval;
        return $this->_setAttr("primaryDNS",$rest_val);
    }

    /**
     * Returns the IP address of the secondary name server to be used by the module.
     * 
     * @return a string corresponding to the IP address of the secondary name server to be used by the module
     * 
     * On failure, throws an exception or returns Y_SECONDARYDNS_INVALID.
     */
    public function get_secondaryDNS()
    {   $json_val = $this->_getAttr("secondaryDNS");
        return (is_null($json_val) ? Y_SECONDARYDNS_INVALID : $json_val);
    }

    /**
     * Changes the IP address of the secondarz name server to be used by the module.
     * When using DHCP, if a value is specified, it overrides the value received from the DHCP server.
     * Remember to call the saveToFlash() method and then to reboot the module to apply this setting.
     * 
     * @param newval : a string corresponding to the IP address of the secondarz name server to be used by the module
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_secondaryDNS($newval)
    {
        $rest_val = $newval;
        return $this->_setAttr("secondaryDNS",$rest_val);
    }

    /**
     * Returns a hash string if a password has been set for "user" user,
     * or an empty string otherwise.
     * 
     * @return a string corresponding to a hash string if a password has been set for "user" user,
     *         or an empty string otherwise
     * 
     * On failure, throws an exception or returns Y_USERPASSWORD_INVALID.
     */
    public function get_userPassword()
    {   $json_val = $this->_getAttr("userPassword");
        return (is_null($json_val) ? Y_USERPASSWORD_INVALID : $json_val);
    }

    /**
     * Changes the password for the "user" user. This password becomes instantly required
     * to perform any use of the module. If the specified value is an
     * empty string, a password is not required anymore.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     * 
     * @param newval : a string corresponding to the password for the "user" user
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_userPassword($newval)
    {
        $rest_val = $newval;
        return $this->_setAttr("userPassword",$rest_val);
    }

    /**
     * Returns a hash string if a password has been set for user "admin",
     * or an empty string otherwise.
     * 
     * @return a string corresponding to a hash string if a password has been set for user "admin",
     *         or an empty string otherwise
     * 
     * On failure, throws an exception or returns Y_ADMINPASSWORD_INVALID.
     */
    public function get_adminPassword()
    {   $json_val = $this->_getAttr("adminPassword");
        return (is_null($json_val) ? Y_ADMINPASSWORD_INVALID : $json_val);
    }

    /**
     * Changes the password for the "admin" user. This password becomes instantly required
     * to perform any change of the module state. If the specified value is an
     * empty string, a password is not required anymore.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     * 
     * @param newval : a string corresponding to the password for the "admin" user
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_adminPassword($newval)
    {
        $rest_val = $newval;
        return $this->_setAttr("adminPassword",$rest_val);
    }

    /**
     * Returns the activation state of the multicast announce protocols to allow easy
     * discovery of the module in the network neighborhood (uPnP/Bonjour protocol).
     * 
     * @return either Y_DISCOVERABLE_FALSE or Y_DISCOVERABLE_TRUE, according to the activation state of
     * the multicast announce protocols to allow easy
     *         discovery of the module in the network neighborhood (uPnP/Bonjour protocol)
     * 
     * On failure, throws an exception or returns Y_DISCOVERABLE_INVALID.
     */
    public function get_discoverable()
    {   $json_val = $this->_getAttr("discoverable");
        return (is_null($json_val) ? Y_DISCOVERABLE_INVALID : intval($json_val));
    }

    /**
     * Changes the activation state of the multicast announce protocols to allow easy
     * discovery of the module in the network neighborhood (uPnP/Bonjour protocol).
     * 
     * @param newval : either Y_DISCOVERABLE_FALSE or Y_DISCOVERABLE_TRUE, according to the activation
     * state of the multicast announce protocols to allow easy
     *         discovery of the module in the network neighborhood (uPnP/Bonjour protocol)
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_discoverable($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("discoverable",$rest_val);
    }

    /**
     * Returns the allowed downtime of the WWW link (in seconds) before triggering an automated
     * reboot to try to recover Internet connectivity. A zero value disables automated reboot
     * in case of Internet connectivity loss.
     * 
     * @return an integer corresponding to the allowed downtime of the WWW link (in seconds) before
     * triggering an automated
     *         reboot to try to recover Internet connectivity
     * 
     * On failure, throws an exception or returns Y_WWWWATCHDOGDELAY_INVALID.
     */
    public function get_wwwWatchdogDelay()
    {   $json_val = $this->_getAttr("wwwWatchdogDelay");
        return (is_null($json_val) ? Y_WWWWATCHDOGDELAY_INVALID : intval($json_val));
    }

    /**
     * Changes the allowed downtime of the WWW link (in seconds) before triggering an automated
     * reboot to try to recover Internet connectivity. A zero value disable automated reboot
     * in case of Internet connectivity loss. The smallest valid non-zero timeout is
     * 90 seconds.
     * 
     * @param newval : an integer corresponding to the allowed downtime of the WWW link (in seconds)
     * before triggering an automated
     *         reboot to try to recover Internet connectivity
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_wwwWatchdogDelay($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("wwwWatchdogDelay",$rest_val);
    }

    /**
     * Returns the callback URL to notify of significant state changes.
     * 
     * @return a string corresponding to the callback URL to notify of significant state changes
     * 
     * On failure, throws an exception or returns Y_CALLBACKURL_INVALID.
     */
    public function get_callbackUrl()
    {   $json_val = $this->_getAttr("callbackUrl");
        return (is_null($json_val) ? Y_CALLBACKURL_INVALID : $json_val);
    }

    /**
     * Changes the callback URL to notify significant state changes. Remember to call the
     * saveToFlash() method of the module if the modification must be kept.
     * 
     * @param newval : a string corresponding to the callback URL to notify significant state changes
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_callbackUrl($newval)
    {
        $rest_val = $newval;
        return $this->_setAttr("callbackUrl",$rest_val);
    }

    /**
     * Returns the HTTP method used to notify callbacks for significant state changes.
     * 
     * @return a value among Y_CALLBACKMETHOD_POST, Y_CALLBACKMETHOD_GET and Y_CALLBACKMETHOD_PUT
     * corresponding to the HTTP method used to notify callbacks for significant state changes
     * 
     * On failure, throws an exception or returns Y_CALLBACKMETHOD_INVALID.
     */
    public function get_callbackMethod()
    {   $json_val = $this->_getAttr("callbackMethod");
        return (is_null($json_val) ? Y_CALLBACKMETHOD_INVALID : intval($json_val));
    }

    /**
     * Changes the HTTP method used to notify callbacks for significant state changes.
     * 
     * @param newval : a value among Y_CALLBACKMETHOD_POST, Y_CALLBACKMETHOD_GET and Y_CALLBACKMETHOD_PUT
     * corresponding to the HTTP method used to notify callbacks for significant state changes
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_callbackMethod($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("callbackMethod",$rest_val);
    }

    /**
     * Returns the encoding standard to use for representing notification values.
     * 
     * @return a value among Y_CALLBACKENCODING_FORM, Y_CALLBACKENCODING_JSON,
     * Y_CALLBACKENCODING_JSON_ARRAY, Y_CALLBACKENCODING_CSV and Y_CALLBACKENCODING_YOCTO_API
     * corresponding to the encoding standard to use for representing notification values
     * 
     * On failure, throws an exception or returns Y_CALLBACKENCODING_INVALID.
     */
    public function get_callbackEncoding()
    {   $json_val = $this->_getAttr("callbackEncoding");
        return (is_null($json_val) ? Y_CALLBACKENCODING_INVALID : intval($json_val));
    }

    /**
     * Changes the encoding standard to use for representing notification values.
     * 
     * @param newval : a value among Y_CALLBACKENCODING_FORM, Y_CALLBACKENCODING_JSON,
     * Y_CALLBACKENCODING_JSON_ARRAY, Y_CALLBACKENCODING_CSV and Y_CALLBACKENCODING_YOCTO_API
     * corresponding to the encoding standard to use for representing notification values
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_callbackEncoding($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("callbackEncoding",$rest_val);
    }

    /**
     * Returns a hashed version of the notification callback credentials if set,
     * or an empty string otherwise.
     * 
     * @return a string corresponding to a hashed version of the notification callback credentials if set,
     *         or an empty string otherwise
     * 
     * On failure, throws an exception or returns Y_CALLBACKCREDENTIALS_INVALID.
     */
    public function get_callbackCredentials()
    {   $json_val = $this->_getAttr("callbackCredentials");
        return (is_null($json_val) ? Y_CALLBACKCREDENTIALS_INVALID : $json_val);
    }

    /**
     * Changes the credentials required to connect to the callback address. The credentials
     * must be provided as returned by function get_callbackCredentials,
     * in the form username:hash. The method used to compute the hash varies according
     * to the the authentication scheme implemented by the callback, For Basic authentication,
     * the hash is the MD5 of the string username:password. For Digest authentication,
     * the hash is the MD5 of the string username:realm:password. For a simpler
     * way to configure callback credentials, use function callbackLogin instead.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     * 
     * @param newval : a string corresponding to the credentials required to connect to the callback address
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_callbackCredentials($newval)
    {
        $rest_val = $newval;
        return $this->_setAttr("callbackCredentials",$rest_val);
    }

    /**
     * Connects to the notification callback and saves the credentials required to
     * log into it. The password is not stored into the module, only a hashed
     * copy of the credentials are saved. Remember to call the
     * saveToFlash() method of the module if the modification must be kept.
     * 
     * @param username : username required to log to the callback
     * @param password : password required to log to the callback
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function callbackLogin($str_username,$str_password)
    {
        $rest_val = sprintf("%s:%s", $str_username, $str_password);
        return $this->_setAttr("callbackCredentials",$rest_val);
    }

    /**
     * Returns the minimum waiting time between two callback notifications, in seconds.
     * 
     * @return an integer corresponding to the minimum waiting time between two callback notifications, in seconds
     * 
     * On failure, throws an exception or returns Y_CALLBACKMINDELAY_INVALID.
     */
    public function get_callbackMinDelay()
    {   $json_val = $this->_getAttr("callbackMinDelay");
        return (is_null($json_val) ? Y_CALLBACKMINDELAY_INVALID : intval($json_val));
    }

    /**
     * Changes the minimum waiting time between two callback notifications, in seconds.
     * 
     * @param newval : an integer corresponding to the minimum waiting time between two callback
     * notifications, in seconds
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_callbackMinDelay($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("callbackMinDelay",$rest_val);
    }

    /**
     * Returns the maximum waiting time between two callback notifications, in seconds.
     * 
     * @return an integer corresponding to the maximum waiting time between two callback notifications, in seconds
     * 
     * On failure, throws an exception or returns Y_CALLBACKMAXDELAY_INVALID.
     */
    public function get_callbackMaxDelay()
    {   $json_val = $this->_getAttr("callbackMaxDelay");
        return (is_null($json_val) ? Y_CALLBACKMAXDELAY_INVALID : intval($json_val));
    }

    /**
     * Changes the maximum waiting time between two callback notifications, in seconds.
     * 
     * @param newval : an integer corresponding to the maximum waiting time between two callback
     * notifications, in seconds
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_callbackMaxDelay($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("callbackMaxDelay",$rest_val);
    }

    /**
     * Returns the current consumed by the module from Power-over-Ethernet (PoE), in milli-amps.
     * The current consumption is measured after converting PoE source to 5 Volt, and should
     * never exceed 1800 mA.
     * 
     * @return an integer corresponding to the current consumed by the module from Power-over-Ethernet
     * (PoE), in milli-amps
     * 
     * On failure, throws an exception or returns Y_POECURRENT_INVALID.
     */
    public function get_poeCurrent()
    {   $json_val = $this->_getAttr("poeCurrent");
        return (is_null($json_val) ? Y_POECURRENT_INVALID : intval($json_val));
    }

    /**
     * Pings str_host to test the network connectivity. Sends four requests ICMP ECHO_REQUEST from the
     * module to the target str_host. This method returns a string with the result of the
     * 4 ICMP ECHO_REQUEST result.
     * 
     * @param host : the hostname or the IP address of the target
     * 
     * @return a string with the result of the ping.
     */
    public function ping($str_host)
    {
        // $content is a bin;
        $content = $this->_download(sprintf('ping.txt?host=%s',$str_host));
        return $content;
        
    }

    public function logicalName()
    { return get_logicalName(); }

    public function setLogicalName($newval)
    { return set_logicalName($newval); }

    public function advertisedValue()
    { return get_advertisedValue(); }

    public function readiness()
    { return get_readiness(); }

    public function macAddress()
    { return get_macAddress(); }

    public function ipAddress()
    { return get_ipAddress(); }

    public function subnetMask()
    { return get_subnetMask(); }

    public function router()
    { return get_router(); }

    public function ipConfig()
    { return get_ipConfig(); }

    public function setIpConfig($newval)
    { return set_ipConfig($newval); }

    public function primaryDNS()
    { return get_primaryDNS(); }

    public function setPrimaryDNS($newval)
    { return set_primaryDNS($newval); }

    public function secondaryDNS()
    { return get_secondaryDNS(); }

    public function setSecondaryDNS($newval)
    { return set_secondaryDNS($newval); }

    public function userPassword()
    { return get_userPassword(); }

    public function setUserPassword($newval)
    { return set_userPassword($newval); }

    public function adminPassword()
    { return get_adminPassword(); }

    public function setAdminPassword($newval)
    { return set_adminPassword($newval); }

    public function discoverable()
    { return get_discoverable(); }

    public function setDiscoverable($newval)
    { return set_discoverable($newval); }

    public function wwwWatchdogDelay()
    { return get_wwwWatchdogDelay(); }

    public function setWwwWatchdogDelay($newval)
    { return set_wwwWatchdogDelay($newval); }

    public function callbackUrl()
    { return get_callbackUrl(); }

    public function setCallbackUrl($newval)
    { return set_callbackUrl($newval); }

    public function callbackMethod()
    { return get_callbackMethod(); }

    public function setCallbackMethod($newval)
    { return set_callbackMethod($newval); }

    public function callbackEncoding()
    { return get_callbackEncoding(); }

    public function setCallbackEncoding($newval)
    { return set_callbackEncoding($newval); }

    public function callbackCredentials()
    { return get_callbackCredentials(); }

    public function setCallbackCredentials($newval)
    { return set_callbackCredentials($newval); }

    public function callbackMinDelay()
    { return get_callbackMinDelay(); }

    public function setCallbackMinDelay($newval)
    { return set_callbackMinDelay($newval); }

    public function callbackMaxDelay()
    { return get_callbackMaxDelay(); }

    public function setCallbackMaxDelay($newval)
    { return set_callbackMaxDelay($newval); }

    public function poeCurrent()
    { return get_poeCurrent(); }

    /**
     * Continues the enumeration of network interfaces started using yFirstNetwork().
     * 
     * @return a pointer to a YNetwork object, corresponding to
     *         a network interface currently online, or a null pointer
     *         if there are no more network interfaces to enumerate.
     */
    public function nextNetwork()
    {   $next_hwid = YAPI::getNextHardwareId($this->_className, $this->_func);
        if($next_hwid == null) return null;
        return yFindNetwork($next_hwid);
    }

    /**
     * Retrieves a network interface for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     * 
     * This function does not require that the network interface is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YNetwork.isOnline() to test if the network interface is
     * indeed online at a given time. In case of ambiguity when looking for
     * a network interface by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     * 
     * @param func : a string that uniquely characterizes the network interface
     * 
     * @return a YNetwork object allowing you to drive the network interface.
     */
    public static function FindNetwork($str_func)
    {   $obj_func = YAPI::getFunction('Network', $str_func);
        if($obj_func) return $obj_func;
        return new YNetwork($str_func);
    }

    /**
     * Starts the enumeration of network interfaces currently accessible.
     * Use the method YNetwork.nextNetwork() to iterate on
     * next network interfaces.
     * 
     * @return a pointer to a YNetwork object, corresponding to
     *         the first network interface currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstNetwork()
    {   $next_hwid = YAPI::getFirstHardwareId('Network');
        if($next_hwid == null) return null;
        return self::FindNetwork($next_hwid);
    }

    //--- (end of YNetwork implementation)

    function __construct($str_func)
    {
        //--- (YNetwork constructor)
        parent::__construct('Network', $str_func);
        //--- (end of YNetwork constructor)
    }
};

//--- (Network functions)

/**
 * Retrieves a network interface for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 * 
 * This function does not require that the network interface is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YNetwork.isOnline() to test if the network interface is
 * indeed online at a given time. In case of ambiguity when looking for
 * a network interface by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 * 
 * @param func : a string that uniquely characterizes the network interface
 * 
 * @return a YNetwork object allowing you to drive the network interface.
 */
function yFindNetwork($str_func)
{
    return YNetwork::FindNetwork($str_func);
}

/**
 * Starts the enumeration of network interfaces currently accessible.
 * Use the method YNetwork.nextNetwork() to iterate on
 * next network interfaces.
 * 
 * @return a pointer to a YNetwork object, corresponding to
 *         the first network interface currently online, or a null pointer
 *         if there are none.
 */
function yFirstNetwork()
{
    return YNetwork::FirstNetwork();
}

//--- (end of Network functions)
?>