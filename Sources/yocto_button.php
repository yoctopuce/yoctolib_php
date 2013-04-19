<?php
/*********************************************************************
 *
 * yocto_button.php
 *
 * Implements yButton(), the high-level API for Button functions
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
 * 2) If you have obtained this file from any other source, you
 *    are not entitled to use it, read it or create any derived 
 *    material. You should delete this file immediately.
 *
 *********************************************************************/

if(!$yAPI) throw '$yAPI is not defined, please include yocto_api.php first';

//--- Constants
// enumerated values: Y_ISPRESSED_enum
if(!defined('Y_ISPRESSED_FALSE')) define('Y_ISPRESSED_FALSE', 0);
if(!defined('Y_ISPRESSED_TRUE')) define('Y_ISPRESSED_TRUE', 1);
if(!defined('Y_ISPRESSED_INVALID')) define('Y_ISPRESSED_INVALID', -1);

if(!defined('Y_LOGICALNAME_INVALID')) define('Y_LOGICALNAME_INVALID', '!INVALID!');
if(!defined('Y_ADVERTISEDVALUE_INVALID')) define('Y_ADVERTISEDVALUE_INVALID', '!INVALID!');
if(!defined('Y_LASTTIMEPRESSED_INVALID')) define('Y_LASTTIMEPRESSED_INVALID', -1);
if(!defined('Y_LASTTIMERELEASED_INVALID')) define('Y_LASTTIMERELEASED_INVALID', -1);

//--- yButton
//
// YButton Class: Button Interface
//
class YButton extends YFunction
{
    public function get_logicalName()
    {   $json_val = $this->_getAttr("logicalName");
        return ($json_val == null ? Y_LOGICALNAME_INVALID : $json_val); 
    }

    public function set_logicalName($newval)
    {
        $rest_val = $newval; 
        $json_val = $this->_setAttr("logicalName",$rest_val);
        return ($json_val == null ? Y_LOGICALNAME_INVALID : $json_val); 
    }

    public function get_advertisedValue()
    {   $json_val = $this->_getAttr("advertisedValue");
        return ($json_val == null ? Y_ADVERTISEDVALUE_INVALID : $json_val); 
    }

    public function get_isPressed()
    {   $json_val = $this->_getAttr("isPressed");
        return ($json_val == null ? Y_ISPRESSED_INVALID : intval($json_val)>0); 
    }

    public function get_lastTimePressed()
    {   $json_val = $this->_getAttr("lastTimePressed");
        return ($json_val == null ? Y_LASTTIMEPRESSED_INVALID : intval($json_val)); 
    }

    public function get_lastTimeReleased()
    {   $json_val = $this->_getAttr("lastTimeReleased");
        return ($json_val == null ? Y_LASTTIMERELEASED_INVALID : intval($json_val)); 
    }

    public function nextButton()
    {   global $yAPI;
        $next_hwid = $yAPI->getNextHardwareId($this->_className, $this->_func);
        if($next_hwid == null) return null;
        return yButton($next_hwid);
    }

    function __construct($str_func)
    {
        parent::__construct('Button', $str_func);
    }
};

function yButton($str_func)
{   global $yAPI;
    $obj_func = $yAPI->getFunction('Button', $str_func);
    if($obj_func) return $obj_func;
    return new YButton($str_func);
}

function yFirstButton()
{   global $yAPI;
    return yButton($yAPI->getFirstHardwareId('Button'));
}

//--- end of yButton
?>