<?php
/*********************************************************************
 *
 * $Id: yocto_wakeupschedule.php 12469 2013-08-22 10:11:58Z seb $
 *
 * Implements yFindWakeUpSchedule(), the high-level API for WakeUpSchedule functions
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
//--- (YWakeUpSchedule definitions)
if(!defined('Y_LOGICALNAME_INVALID')) define('Y_LOGICALNAME_INVALID', Y_INVALID_STRING);
if(!defined('Y_ADVERTISEDVALUE_INVALID')) define('Y_ADVERTISEDVALUE_INVALID', Y_INVALID_STRING);
if(!defined('Y_MINUTESA_INVALID')) define('Y_MINUTESA_INVALID', Y_INVALID_UNSIGNED);
if(!defined('Y_MINUTESB_INVALID')) define('Y_MINUTESB_INVALID', Y_INVALID_UNSIGNED);
if(!defined('Y_HOURS_INVALID')) define('Y_HOURS_INVALID', Y_INVALID_UNSIGNED);
if(!defined('Y_WEEKDAYS_INVALID')) define('Y_WEEKDAYS_INVALID', Y_INVALID_UNSIGNED);
if(!defined('Y_MONTHDAYS_INVALID')) define('Y_MONTHDAYS_INVALID', Y_INVALID_UNSIGNED);
if(!defined('Y_MONTHS_INVALID')) define('Y_MONTHS_INVALID', Y_INVALID_UNSIGNED);
if(!defined('Y_NEXTOCCURENCE_INVALID')) define('Y_NEXTOCCURENCE_INVALID', Y_INVALID_UNSIGNED);
//--- (end of YWakeUpSchedule definitions)

/**
 * YWakeUpSchedule Class: WakeUpSchedule function interface
 * 
 * The WakeUpSchedule function implements a wake-up condition. The wake-up time is
 * specified as a set of months and/or days and/or hours and/or minutes where the
 * wake-up should happen.
 */
class YWakeUpSchedule extends YFunction
{
    //--- (YWakeUpSchedule implementation)
    const LOGICALNAME_INVALID = Y_INVALID_STRING;
    const ADVERTISEDVALUE_INVALID = Y_INVALID_STRING;
    const MINUTESA_INVALID = Y_INVALID_UNSIGNED;
    const MINUTESB_INVALID = Y_INVALID_UNSIGNED;
    const HOURS_INVALID = Y_INVALID_UNSIGNED;
    const WEEKDAYS_INVALID = Y_INVALID_UNSIGNED;
    const MONTHDAYS_INVALID = Y_INVALID_UNSIGNED;
    const MONTHS_INVALID = Y_INVALID_UNSIGNED;
    const NEXTOCCURENCE_INVALID = Y_INVALID_UNSIGNED;

    /**
     * Returns the logical name of the wake-up schedule.
     * 
     * @return a string corresponding to the logical name of the wake-up schedule
     * 
     * On failure, throws an exception or returns Y_LOGICALNAME_INVALID.
     */
    public function get_logicalName()
    {   $json_val = $this->_getAttr("logicalName");
        return (is_null($json_val) ? Y_LOGICALNAME_INVALID : $json_val);
    }

    /**
     * Changes the logical name of the wake-up schedule. You can use yCheckLogicalName()
     * prior to this call to make sure that your parameter is valid.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     * 
     * @param newval : a string corresponding to the logical name of the wake-up schedule
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
     * Returns the current value of the wake-up schedule (no more than 6 characters).
     * 
     * @return a string corresponding to the current value of the wake-up schedule (no more than 6 characters)
     * 
     * On failure, throws an exception or returns Y_ADVERTISEDVALUE_INVALID.
     */
    public function get_advertisedValue()
    {   $json_val = $this->_getAttr("advertisedValue");
        return (is_null($json_val) ? Y_ADVERTISEDVALUE_INVALID : $json_val);
    }

    /**
     * Returns the minutes 00-29 of each hour scheduled for wake-up.
     * 
     * @return an integer corresponding to the minutes 00-29 of each hour scheduled for wake-up
     * 
     * On failure, throws an exception or returns Y_MINUTESA_INVALID.
     */
    public function get_minutesA()
    {   $json_val = $this->_getAttr("minutesA");
        return (is_null($json_val) ? Y_MINUTESA_INVALID : intval($json_val));
    }

    /**
     * Changes the minutes 00-29 where a wake up must take place.
     * 
     * @param newval : an integer corresponding to the minutes 00-29 where a wake up must take place
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_minutesA($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("minutesA",$rest_val);
    }

    /**
     * Returns the minutes 30-59 of each hour scheduled for wake-up.
     * 
     * @return an integer corresponding to the minutes 30-59 of each hour scheduled for wake-up
     * 
     * On failure, throws an exception or returns Y_MINUTESB_INVALID.
     */
    public function get_minutesB()
    {   $json_val = $this->_getAttr("minutesB");
        return (is_null($json_val) ? Y_MINUTESB_INVALID : intval($json_val));
    }

    /**
     * Changes the minutes 30-59 where a wake up must take place.
     * 
     * @param newval : an integer corresponding to the minutes 30-59 where a wake up must take place
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_minutesB($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("minutesB",$rest_val);
    }

    /**
     * Returns the hours  scheduled for wake-up.
     * 
     * @return an integer corresponding to the hours  scheduled for wake-up
     * 
     * On failure, throws an exception or returns Y_HOURS_INVALID.
     */
    public function get_hours()
    {   $json_val = $this->_getAttr("hours");
        return (is_null($json_val) ? Y_HOURS_INVALID : intval($json_val));
    }

    /**
     * Changes the hours where a wake up must take place.
     * 
     * @param newval : an integer corresponding to the hours where a wake up must take place
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_hours($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("hours",$rest_val);
    }

    /**
     * Returns the days of week scheduled for wake-up.
     * 
     * @return an integer corresponding to the days of week scheduled for wake-up
     * 
     * On failure, throws an exception or returns Y_WEEKDAYS_INVALID.
     */
    public function get_weekDays()
    {   $json_val = $this->_getAttr("weekDays");
        return (is_null($json_val) ? Y_WEEKDAYS_INVALID : intval($json_val));
    }

    /**
     * Changes the days of the week where a wake up must take place.
     * 
     * @param newval : an integer corresponding to the days of the week where a wake up must take place
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_weekDays($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("weekDays",$rest_val);
    }

    /**
     * Returns the days of week scheduled for wake-up.
     * 
     * @return an integer corresponding to the days of week scheduled for wake-up
     * 
     * On failure, throws an exception or returns Y_MONTHDAYS_INVALID.
     */
    public function get_monthDays()
    {   $json_val = $this->_getAttr("monthDays");
        return (is_null($json_val) ? Y_MONTHDAYS_INVALID : intval($json_val));
    }

    /**
     * Changes the days of the week where a wake up must take place.
     * 
     * @param newval : an integer corresponding to the days of the week where a wake up must take place
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_monthDays($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("monthDays",$rest_val);
    }

    /**
     * Returns the days of week scheduled for wake-up.
     * 
     * @return an integer corresponding to the days of week scheduled for wake-up
     * 
     * On failure, throws an exception or returns Y_MONTHS_INVALID.
     */
    public function get_months()
    {   $json_val = $this->_getAttr("months");
        return (is_null($json_val) ? Y_MONTHS_INVALID : intval($json_val));
    }

    /**
     * Changes the days of the week where a wake up must take place.
     * 
     * @param newval : an integer corresponding to the days of the week where a wake up must take place
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_months($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("months",$rest_val);
    }

    /**
     * Returns the  nextwake up date/time (seconds) wake up occurence
     * 
     * @return an integer corresponding to the  nextwake up date/time (seconds) wake up occurence
     * 
     * On failure, throws an exception or returns Y_NEXTOCCURENCE_INVALID.
     */
    public function get_nextOccurence()
    {   $json_val = $this->_getAttr("nextOccurence");
        return (is_null($json_val) ? Y_NEXTOCCURENCE_INVALID : intval($json_val));
    }

    /**
     * Returns every the minutes of each hour scheduled for wake-up.
     */
    public function get_minutes()
    {
        // $res is a long;
        $res = $this->get_minutesB();
        $res = $res << 30;
        $res = $res + $this->get_minutesA();
        return $res;
        
    }

    /**
     * Changes all the minutes where a wake up must take place.
     * 
     * @param bitmap : Minutes 00-59 of each hour scheduled for wake-up.,
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_minutes($long_bitmap)
    {
        $this->set_minutesA($long_bitmap & 0x3fffffff);
        $long_bitmap = $long_bitmap >> 30;
        return $this->set_minutesB($long_bitmap & 0x3fffffff);
        
    }

    public function logicalName()
    { return get_logicalName(); }

    public function setLogicalName($newval)
    { return set_logicalName($newval); }

    public function advertisedValue()
    { return get_advertisedValue(); }

    public function minutesA()
    { return get_minutesA(); }

    public function setMinutesA($newval)
    { return set_minutesA($newval); }

    public function minutesB()
    { return get_minutesB(); }

    public function setMinutesB($newval)
    { return set_minutesB($newval); }

    public function hours()
    { return get_hours(); }

    public function setHours($newval)
    { return set_hours($newval); }

    public function weekDays()
    { return get_weekDays(); }

    public function setWeekDays($newval)
    { return set_weekDays($newval); }

    public function monthDays()
    { return get_monthDays(); }

    public function setMonthDays($newval)
    { return set_monthDays($newval); }

    public function months()
    { return get_months(); }

    public function setMonths($newval)
    { return set_months($newval); }

    public function nextOccurence()
    { return get_nextOccurence(); }

    /**
     * Continues the enumeration of wake-up schedules started using yFirstWakeUpSchedule().
     * 
     * @return a pointer to a YWakeUpSchedule object, corresponding to
     *         a wake-up schedule currently online, or a null pointer
     *         if there are no more wake-up schedules to enumerate.
     */
    public function nextWakeUpSchedule()
    {   $next_hwid = YAPI::getNextHardwareId($this->_className, $this->_func);
        if($next_hwid == null) return null;
        return yFindWakeUpSchedule($next_hwid);
    }

    /**
     * Retrieves a wake-up schedule for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     * 
     * This function does not require that the wake-up schedule is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YWakeUpSchedule.isOnline() to test if the wake-up schedule is
     * indeed online at a given time. In case of ambiguity when looking for
     * a wake-up schedule by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     * 
     * @param func : a string that uniquely characterizes the wake-up schedule
     * 
     * @return a YWakeUpSchedule object allowing you to drive the wake-up schedule.
     */
    public static function FindWakeUpSchedule($str_func)
    {   $obj_func = YAPI::getFunction('WakeUpSchedule', $str_func);
        if($obj_func) return $obj_func;
        return new YWakeUpSchedule($str_func);
    }

    /**
     * Starts the enumeration of wake-up schedules currently accessible.
     * Use the method YWakeUpSchedule.nextWakeUpSchedule() to iterate on
     * next wake-up schedules.
     * 
     * @return a pointer to a YWakeUpSchedule object, corresponding to
     *         the first wake-up schedule currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstWakeUpSchedule()
    {   $next_hwid = YAPI::getFirstHardwareId('WakeUpSchedule');
        if($next_hwid == null) return null;
        return self::FindWakeUpSchedule($next_hwid);
    }

    //--- (end of YWakeUpSchedule implementation)

    function __construct($str_func)
    {
        //--- (YWakeUpSchedule constructor)
        parent::__construct('WakeUpSchedule', $str_func);
        //--- (end of YWakeUpSchedule constructor)
    }
};

//--- (WakeUpSchedule functions)

/**
 * Retrieves a wake-up schedule for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 * 
 * This function does not require that the wake-up schedule is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YWakeUpSchedule.isOnline() to test if the wake-up schedule is
 * indeed online at a given time. In case of ambiguity when looking for
 * a wake-up schedule by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 * 
 * @param func : a string that uniquely characterizes the wake-up schedule
 * 
 * @return a YWakeUpSchedule object allowing you to drive the wake-up schedule.
 */
function yFindWakeUpSchedule($str_func)
{
    return YWakeUpSchedule::FindWakeUpSchedule($str_func);
}

/**
 * Starts the enumeration of wake-up schedules currently accessible.
 * Use the method YWakeUpSchedule.nextWakeUpSchedule() to iterate on
 * next wake-up schedules.
 * 
 * @return a pointer to a YWakeUpSchedule object, corresponding to
 *         the first wake-up schedule currently online, or a null pointer
 *         if there are none.
 */
function yFirstWakeUpSchedule()
{
    return YWakeUpSchedule::FirstWakeUpSchedule();
}

//--- (end of WakeUpSchedule functions)
?>