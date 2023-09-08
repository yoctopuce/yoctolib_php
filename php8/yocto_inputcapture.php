<?php
/*********************************************************************
 *
 *  $Id: yocto_i2cport.php 52998 2023-01-31 10:49:23Z seb $
 *
 *  Implements YInputCapture, the high-level API for YInputCapture functions
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

//--- (generated code: YInputCapture return codes)
//--- (end of generated code: YInputCapture return codes)
//--- (generated code: YInputCapture definitions)
if (!defined('Y_CAPTURETYPE_NONE')) {
    define('Y_CAPTURETYPE_NONE', 0);
}
if (!defined('Y_CAPTURETYPE_TIMED')) {
    define('Y_CAPTURETYPE_TIMED', 1);
}
if (!defined('Y_CAPTURETYPE_V_MAX')) {
    define('Y_CAPTURETYPE_V_MAX', 2);
}
if (!defined('Y_CAPTURETYPE_V_MIN')) {
    define('Y_CAPTURETYPE_V_MIN', 3);
}
if (!defined('Y_CAPTURETYPE_I_MAX')) {
    define('Y_CAPTURETYPE_I_MAX', 4);
}
if (!defined('Y_CAPTURETYPE_I_MIN')) {
    define('Y_CAPTURETYPE_I_MIN', 5);
}
if (!defined('Y_CAPTURETYPE_P_MAX')) {
    define('Y_CAPTURETYPE_P_MAX', 6);
}
if (!defined('Y_CAPTURETYPE_P_MIN')) {
    define('Y_CAPTURETYPE_P_MIN', 7);
}
if (!defined('Y_CAPTURETYPE_V_AVG_MAX')) {
    define('Y_CAPTURETYPE_V_AVG_MAX', 8);
}
if (!defined('Y_CAPTURETYPE_V_AVG_MIN')) {
    define('Y_CAPTURETYPE_V_AVG_MIN', 9);
}
if (!defined('Y_CAPTURETYPE_V_RMS_MAX')) {
    define('Y_CAPTURETYPE_V_RMS_MAX', 10);
}
if (!defined('Y_CAPTURETYPE_V_RMS_MIN')) {
    define('Y_CAPTURETYPE_V_RMS_MIN', 11);
}
if (!defined('Y_CAPTURETYPE_I_AVG_MAX')) {
    define('Y_CAPTURETYPE_I_AVG_MAX', 12);
}
if (!defined('Y_CAPTURETYPE_I_AVG_MIN')) {
    define('Y_CAPTURETYPE_I_AVG_MIN', 13);
}
if (!defined('Y_CAPTURETYPE_I_RMS_MAX')) {
    define('Y_CAPTURETYPE_I_RMS_MAX', 14);
}
if (!defined('Y_CAPTURETYPE_I_RMS_MIN')) {
    define('Y_CAPTURETYPE_I_RMS_MIN', 15);
}
if (!defined('Y_CAPTURETYPE_P_AVG_MAX')) {
    define('Y_CAPTURETYPE_P_AVG_MAX', 16);
}
if (!defined('Y_CAPTURETYPE_P_AVG_MIN')) {
    define('Y_CAPTURETYPE_P_AVG_MIN', 17);
}
if (!defined('Y_CAPTURETYPE_PF_MIN')) {
    define('Y_CAPTURETYPE_PF_MIN', 18);
}
if (!defined('Y_CAPTURETYPE_DPF_MIN')) {
    define('Y_CAPTURETYPE_DPF_MIN', 19);
}
if (!defined('Y_CAPTURETYPE_INVALID')) {
    define('Y_CAPTURETYPE_INVALID', -1);
}
if (!defined('Y_CAPTURETYPEATSTARTUP_NONE')) {
    define('Y_CAPTURETYPEATSTARTUP_NONE', 0);
}
if (!defined('Y_CAPTURETYPEATSTARTUP_TIMED')) {
    define('Y_CAPTURETYPEATSTARTUP_TIMED', 1);
}
if (!defined('Y_CAPTURETYPEATSTARTUP_V_MAX')) {
    define('Y_CAPTURETYPEATSTARTUP_V_MAX', 2);
}
if (!defined('Y_CAPTURETYPEATSTARTUP_V_MIN')) {
    define('Y_CAPTURETYPEATSTARTUP_V_MIN', 3);
}
if (!defined('Y_CAPTURETYPEATSTARTUP_I_MAX')) {
    define('Y_CAPTURETYPEATSTARTUP_I_MAX', 4);
}
if (!defined('Y_CAPTURETYPEATSTARTUP_I_MIN')) {
    define('Y_CAPTURETYPEATSTARTUP_I_MIN', 5);
}
if (!defined('Y_CAPTURETYPEATSTARTUP_P_MAX')) {
    define('Y_CAPTURETYPEATSTARTUP_P_MAX', 6);
}
if (!defined('Y_CAPTURETYPEATSTARTUP_P_MIN')) {
    define('Y_CAPTURETYPEATSTARTUP_P_MIN', 7);
}
if (!defined('Y_CAPTURETYPEATSTARTUP_V_AVG_MAX')) {
    define('Y_CAPTURETYPEATSTARTUP_V_AVG_MAX', 8);
}
if (!defined('Y_CAPTURETYPEATSTARTUP_V_AVG_MIN')) {
    define('Y_CAPTURETYPEATSTARTUP_V_AVG_MIN', 9);
}
if (!defined('Y_CAPTURETYPEATSTARTUP_V_RMS_MAX')) {
    define('Y_CAPTURETYPEATSTARTUP_V_RMS_MAX', 10);
}
if (!defined('Y_CAPTURETYPEATSTARTUP_V_RMS_MIN')) {
    define('Y_CAPTURETYPEATSTARTUP_V_RMS_MIN', 11);
}
if (!defined('Y_CAPTURETYPEATSTARTUP_I_AVG_MAX')) {
    define('Y_CAPTURETYPEATSTARTUP_I_AVG_MAX', 12);
}
if (!defined('Y_CAPTURETYPEATSTARTUP_I_AVG_MIN')) {
    define('Y_CAPTURETYPEATSTARTUP_I_AVG_MIN', 13);
}
if (!defined('Y_CAPTURETYPEATSTARTUP_I_RMS_MAX')) {
    define('Y_CAPTURETYPEATSTARTUP_I_RMS_MAX', 14);
}
if (!defined('Y_CAPTURETYPEATSTARTUP_I_RMS_MIN')) {
    define('Y_CAPTURETYPEATSTARTUP_I_RMS_MIN', 15);
}
if (!defined('Y_CAPTURETYPEATSTARTUP_P_AVG_MAX')) {
    define('Y_CAPTURETYPEATSTARTUP_P_AVG_MAX', 16);
}
if (!defined('Y_CAPTURETYPEATSTARTUP_P_AVG_MIN')) {
    define('Y_CAPTURETYPEATSTARTUP_P_AVG_MIN', 17);
}
if (!defined('Y_CAPTURETYPEATSTARTUP_PF_MIN')) {
    define('Y_CAPTURETYPEATSTARTUP_PF_MIN', 18);
}
if (!defined('Y_CAPTURETYPEATSTARTUP_DPF_MIN')) {
    define('Y_CAPTURETYPEATSTARTUP_DPF_MIN', 19);
}
if (!defined('Y_CAPTURETYPEATSTARTUP_INVALID')) {
    define('Y_CAPTURETYPEATSTARTUP_INVALID', -1);
}
if (!defined('Y_LASTCAPTURETIME_INVALID')) {
    define('Y_LASTCAPTURETIME_INVALID', YAPI_INVALID_LONG);
}
if (!defined('Y_NSAMPLES_INVALID')) {
    define('Y_NSAMPLES_INVALID', YAPI_INVALID_UINT);
}
if (!defined('Y_SAMPLINGRATE_INVALID')) {
    define('Y_SAMPLINGRATE_INVALID', YAPI_INVALID_UINT);
}
if (!defined('Y_CONDVALUE_INVALID')) {
    define('Y_CONDVALUE_INVALID', YAPI_INVALID_DOUBLE);
}
if (!defined('Y_CONDALIGN_INVALID')) {
    define('Y_CONDALIGN_INVALID', YAPI_INVALID_UINT);
}
if (!defined('Y_CONDVALUEATSTARTUP_INVALID')) {
    define('Y_CONDVALUEATSTARTUP_INVALID', YAPI_INVALID_DOUBLE);
}
//--- (end of generated code: YInputCapture definitions)

//--- (generated code: YInputCaptureData definitions)
//--- (end of generated code: YInputCaptureData definitions)

//--- (generated code: YInputCaptureData declaration)
//vvvv YInputCaptureData.php

/**
 * YInputCaptureData Class: Sampled data from a Yoctopuce electrical sensor
 *
 * InputCaptureData objects represent raw data
 * sampled by the analog/digital converter present in
 * a Yoctopuce electrical sensor. When several inputs
 * are samples simultaneously, their data are provided
 * as distinct series.
 */
class YInputCaptureData
{
    //--- (end of generated code: YInputCaptureData declaration)

    //--- (generated code: YInputCaptureData attributes)
    protected int $_fmt = 0;                            // int
    protected int $_var1size = 0;                            // int
    protected int $_var2size = 0;                            // int
    protected int $_var3size = 0;                            // int
    protected int $_nVars = 0;                            // int
    protected int $_recOfs = 0;                            // int
    protected int $_nRecs = 0;                            // int
    protected int $_samplesPerSec = 0;                            // int
    protected int $_trigType = 0;                            // int
    protected float $_trigVal = 0;                            // float
    protected int $_trigPos = 0;                            // int
    protected float $_trigUTC = 0;                            // float
    protected string $_var1unit = "";                           // string
    protected string $_var2unit = "";                           // string
    protected string $_var3unit = "";                           // string
    protected array $_var1samples = [];                           // floatArr
    protected array $_var2samples = [];                           // floatArr
    protected array $_var3samples = [];                           // floatArr

    //--- (end of generated code: YInputCaptureData attributes)

    function __construct(YFunction $yfun, string $sdata)
    {
        //--- (generated code: YInputCaptureData constructor)
        //--- (end of generated code: YInputCaptureData constructor)
        $this->_decodeSnapBin($sdata);
    }

    /**
     * @param int $int_errType
     * @param string $str_errMsg
     * @param mixed $obj_retVal
     * @return mixed
     * @throws YAPI_Exception
     */
    protected function _throw(int $int_errType, string $str_errMsg, mixed $obj_retVal): mixed
    {
        if (YAPI::$exceptionsDisabled) {
            return $obj_retVal;
        }
        // throw an exception
        throw new YAPI_Exception($str_errMsg, $int_errType);
    }

    //--- (generated code: YInputCaptureData implementation)

    /**
     * @throws YAPI_Exception on error
     */
    public function _decodeU16(string $sdata, int $ofs): int
    {
        // $v                      is a int;
        $v = ord($sdata[$ofs]);
        $v = $v + 256 * ord($sdata[$ofs+1]);
        return $v;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function _decodeU32(string $sdata, int $ofs): float
    {
        // $v                      is a float;
        $v = $this->_decodeU16($sdata, $ofs);
        $v = $v + 65536.0 * $this->_decodeU16($sdata, $ofs+2);
        return $v;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function _decodeVal(string $sdata, int $ofs, int $len): float
    {
        // $v                      is a float;
        // $b                      is a float;
        $v = $this->_decodeU16($sdata, $ofs);
        $b = 65536.0;
        $ofs = $ofs + 2;
        $len = $len - 2;
        while ($len > 0) {
            $v = $v + $b * ord($sdata[$ofs]);
            $b = $b * 256;
            $ofs = $ofs + 1;
            $len = $len - 1;
        }
        if ($v > ($b/2)) {
            // negative number
            $v = $v - $b;
        }
        return $v;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function _decodeSnapBin(string $sdata): int
    {
        // $buffSize               is a int;
        // $recOfs                 is a int;
        // $ms                     is a int;
        // $recSize                is a int;
        // $count                  is a int;
        // $mult1                  is a int;
        // $mult2                  is a int;
        // $mult3                  is a int;
        // $v                      is a float;

        $buffSize = strlen($sdata);
        if (!($buffSize >= 24)) return $this->_throw( YAPI::INVALID_ARGUMENT, 'Invalid snapshot data (too short)',YAPI::INVALID_ARGUMENT);
        $this->_fmt = ord($sdata[0]);
        $this->_var1size = ord($sdata[1]) - 48;
        $this->_var2size = ord($sdata[2]) - 48;
        $this->_var3size = ord($sdata[3]) - 48;
        if (!($this->_fmt == 83)) return $this->_throw( YAPI::INVALID_ARGUMENT, 'Unsupported snapshot format',YAPI::INVALID_ARGUMENT);
        if (!(($this->_var1size >= 2) && ($this->_var1size <= 4))) return $this->_throw( YAPI::INVALID_ARGUMENT, 'Invalid sample size',YAPI::INVALID_ARGUMENT);
        if (!(($this->_var2size >= 0) && ($this->_var1size <= 4))) return $this->_throw( YAPI::INVALID_ARGUMENT, 'Invalid sample size',YAPI::INVALID_ARGUMENT);
        if (!(($this->_var3size >= 0) && ($this->_var1size <= 4))) return $this->_throw( YAPI::INVALID_ARGUMENT, 'Invalid sample size',YAPI::INVALID_ARGUMENT);
        if ($this->_var2size == 0) {
            $this->_nVars = 1;
        } else {
            if ($this->_var3size == 0) {
                $this->_nVars = 2;
            } else {
                $this->_nVars = 3;
            }
        }
        $recSize = $this->_var1size + $this->_var2size + $this->_var3size;
        $this->_recOfs = $this->_decodeU16($sdata, 4);
        $this->_nRecs = $this->_decodeU16($sdata, 6);
        $this->_samplesPerSec = $this->_decodeU16($sdata, 8);
        $this->_trigType = $this->_decodeU16($sdata, 10);
        $this->_trigVal = $this->_decodeVal($sdata, 12, 4) / 1000;
        $this->_trigPos = $this->_decodeU16($sdata, 16);
        $ms = $this->_decodeU16($sdata, 18);
        $this->_trigUTC = $this->_decodeVal($sdata, 20, 4);
        $this->_trigUTC = $this->_trigUTC + ($ms / 1000.0);
        $recOfs = 24;
        while (ord($sdata[$recOfs]) >= 32) {
            $this->_var1unit = sprintf('%s%c', $this->_var1unit, ord($sdata[$recOfs]));
            $recOfs = $recOfs + 1;
        }
        if ($this->_var2size > 0) {
            $recOfs = $recOfs + 1;
            while (ord($sdata[$recOfs]) >= 32) {
                $this->_var2unit = sprintf('%s%c', $this->_var2unit, ord($sdata[$recOfs]));
                $recOfs = $recOfs + 1;
            }
        }
        if ($this->_var3size > 0) {
            $recOfs = $recOfs + 1;
            while (ord($sdata[$recOfs]) >= 32) {
                $this->_var3unit = sprintf('%s%c', $this->_var3unit, ord($sdata[$recOfs]));
                $recOfs = $recOfs + 1;
            }
        }
        if ((($recOfs) & (1)) == 1) {
            // align to next word
            $recOfs = $recOfs + 1;
        }
        $mult1 = 1;
        $mult2 = 1;
        $mult3 = 1;
        if ($recOfs < $this->_recOfs) {
            // load optional value multiplier
            $mult1 = $this->_decodeU16($sdata, $this->_recOfs);
            $recOfs = $recOfs + 2;
            if ($this->_var2size > 0) {
                $mult2 = $this->_decodeU16($sdata, $this->_recOfs);
                $recOfs = $recOfs + 2;
            }
            if ($this->_var3size > 0) {
                $mult3 = $this->_decodeU16($sdata, $this->_recOfs);
                $recOfs = $recOfs + 2;
            }
        }
        $recOfs = $this->_recOfs;
        $count = $this->_nRecs;
        while (($count > 0) && ($recOfs + $this->_var1size <= $buffSize)) {
            $v = $this->_decodeVal($sdata, $recOfs, $this->_var1size) / 1000.0;
            $this->_var1samples[] = $v*$mult1;
            $recOfs = $recOfs + $recSize;
        }
        if ($this->_var2size > 0) {
            $recOfs = $this->_recOfs + $this->_var1size;
            $count = $this->_nRecs;
            while (($count > 0) && ($recOfs + $this->_var2size <= $buffSize)) {
                $v = $this->_decodeVal($sdata, $recOfs, $this->_var2size) / 1000.0;
                $this->_var2samples[] = $v*$mult2;
                $recOfs = $recOfs + $recSize;
            }
        }
        if ($this->_var3size > 0) {
            $recOfs = $this->_recOfs + $this->_var1size + $this->_var2size;
            $count = $this->_nRecs;
            while (($count > 0) && ($recOfs + $this->_var3size <= $buffSize)) {
                $v = $this->_decodeVal($sdata, $recOfs, $this->_var3size) / 1000.0;
                $this->_var3samples[] = $v*$mult3;
                $recOfs = $recOfs + $recSize;
            }
        }
        return YAPI::SUCCESS;
    }

    /**
     * Returns the number of series available in the capture.
     *
     * @return int  an integer corresponding to the number of
     *         simultaneous data series available.
     */
    public function get_serieCount(): int
    {
        return $this->_nVars;
    }

    /**
     * Returns the number of records captured (in a serie).
     * In the exceptional case where it was not possible
     * to transfer all data in time, the number of records
     * actually present in the series might be lower than
     * the number of records captured
     *
     * @return int  an integer corresponding to the number of
     *         records expected in each serie.
     */
    public function get_recordCount(): int
    {
        return $this->_nRecs;
    }

    /**
     * Returns the effective sampling rate of the device.
     *
     * @return int  an integer corresponding to the number of
     *         samples taken each second.
     */
    public function get_samplingRate(): int
    {
        return $this->_samplesPerSec;
    }

    /**
     * Returns the type of automatic conditional capture
     * that triggered the capture of this data sequence.
     *
     * @return int  the type of conditional capture.
     */
    public function get_captureType(): int
    {
        return $this->_trigType;
    }

    /**
     * Returns the threshold value that triggered
     * this automatic conditional capture, if it was
     * not an instant captured triggered manually.
     *
     * @return float  the conditional threshold value
     *         at the time of capture.
     */
    public function get_triggerValue(): float
    {
        return $this->_trigVal;
    }

    /**
     * Returns the index in the series of the sample
     * corresponding to the exact time when the capture
     * was triggered. In case of trigger based on average
     * or RMS value, the trigger index corresponds to
     * the end of the averaging period.
     *
     * @return int  an integer corresponding to a position
     *         in the data serie.
     */
    public function get_triggerPosition(): int
    {
        return $this->_trigPos;
    }

    /**
     * Returns the absolute time when the capture was
     * triggered, as a Unix timestamp. Milliseconds are
     * included in this timestamp (floating-point number).
     *
     * @return float  a floating-point number corresponding to
     *         the number of seconds between the Jan 1,
     *         1970 and the moment where the capture
     *         was triggered.
     */
    public function get_triggerRealTimeUTC(): float
    {
        return $this->_trigUTC;
    }

    /**
     * Returns the unit of measurement for data points in
     * the first serie.
     *
     * @return string  a string containing to a physical unit of
     *         measurement.
     */
    public function get_serie1Unit(): string
    {
        return $this->_var1unit;
    }

    /**
     * Returns the unit of measurement for data points in
     * the second serie.
     *
     * @return string  a string containing to a physical unit of
     *         measurement.
     */
    public function get_serie2Unit(): string
    {
        if (!($this->_nVars >= 2)) return $this->_throw( YAPI::INVALID_ARGUMENT, 'There is no serie 2 in $this capture data','');
        return $this->_var2unit;
    }

    /**
     * Returns the unit of measurement for data points in
     * the third serie.
     *
     * @return string  a string containing to a physical unit of
     *         measurement.
     */
    public function get_serie3Unit(): string
    {
        if (!($this->_nVars >= 3)) return $this->_throw( YAPI::INVALID_ARGUMENT, 'There is no serie 3 in $this capture data','');
        return $this->_var3unit;
    }

    /**
     * Returns the sampled data corresponding to the first serie.
     * The corresponding physical unit can be obtained
     * using the method get_serie1Unit().
     *
     * @return float[]  a list of real numbers corresponding to all
     *         samples received for serie 1.
     *
     * On failure, throws an exception or returns an empty array.
     * @throws YAPI_Exception on error
     */
    public function get_serie1Values(): array
    {
        return $this->_var1samples;
    }

    /**
     * Returns the sampled data corresponding to the second serie.
     * The corresponding physical unit can be obtained
     * using the method get_serie2Unit().
     *
     * @return float[]  a list of real numbers corresponding to all
     *         samples received for serie 2.
     *
     * On failure, throws an exception or returns an empty array.
     * @throws YAPI_Exception on error
     */
    public function get_serie2Values(): array
    {
        if (!($this->_nVars >= 2)) return $this->_throw( YAPI::INVALID_ARGUMENT, 'There is no serie 2 in $this capture data',$this->_var2samples);
        return $this->_var2samples;
    }

    /**
     * Returns the sampled data corresponding to the third serie.
     * The corresponding physical unit can be obtained
     * using the method get_serie3Unit().
     *
     * @return float[]  a list of real numbers corresponding to all
     *         samples received for serie 3.
     *
     * On failure, throws an exception or returns an empty array.
     * @throws YAPI_Exception on error
     */
    public function get_serie3Values(): array
    {
        if (!($this->_nVars >= 3)) return $this->_throw( YAPI::INVALID_ARGUMENT, 'There is no serie 3 in $this capture data',$this->_var3samples);
        return $this->_var3samples;
    }

    //--- (end of generated code: YInputCaptureData implementation)
}

//^^^^ YInputCaptureData.php


//--- (generated code: YInputCapture declaration)
//vvvv YInputCapture.php

/**
 * YInputCapture Class: instant snapshot trigger control interface
 *
 * The YInputCapture class allows you to access data samples
 * measured by a Yoctopuce electrical sensor. The data capture can be
 * triggered manually, or be configured to detect specific events.
 */
class YInputCapture extends YFunction
{
    const LASTCAPTURETIME_INVALID = YAPI::INVALID_LONG;
    const NSAMPLES_INVALID = YAPI::INVALID_UINT;
    const SAMPLINGRATE_INVALID = YAPI::INVALID_UINT;
    const CAPTURETYPE_NONE = 0;
    const CAPTURETYPE_TIMED = 1;
    const CAPTURETYPE_V_MAX = 2;
    const CAPTURETYPE_V_MIN = 3;
    const CAPTURETYPE_I_MAX = 4;
    const CAPTURETYPE_I_MIN = 5;
    const CAPTURETYPE_P_MAX = 6;
    const CAPTURETYPE_P_MIN = 7;
    const CAPTURETYPE_V_AVG_MAX = 8;
    const CAPTURETYPE_V_AVG_MIN = 9;
    const CAPTURETYPE_V_RMS_MAX = 10;
    const CAPTURETYPE_V_RMS_MIN = 11;
    const CAPTURETYPE_I_AVG_MAX = 12;
    const CAPTURETYPE_I_AVG_MIN = 13;
    const CAPTURETYPE_I_RMS_MAX = 14;
    const CAPTURETYPE_I_RMS_MIN = 15;
    const CAPTURETYPE_P_AVG_MAX = 16;
    const CAPTURETYPE_P_AVG_MIN = 17;
    const CAPTURETYPE_PF_MIN = 18;
    const CAPTURETYPE_DPF_MIN = 19;
    const CAPTURETYPE_INVALID = -1;
    const CONDVALUE_INVALID = YAPI::INVALID_DOUBLE;
    const CONDALIGN_INVALID = YAPI::INVALID_UINT;
    const CAPTURETYPEATSTARTUP_NONE = 0;
    const CAPTURETYPEATSTARTUP_TIMED = 1;
    const CAPTURETYPEATSTARTUP_V_MAX = 2;
    const CAPTURETYPEATSTARTUP_V_MIN = 3;
    const CAPTURETYPEATSTARTUP_I_MAX = 4;
    const CAPTURETYPEATSTARTUP_I_MIN = 5;
    const CAPTURETYPEATSTARTUP_P_MAX = 6;
    const CAPTURETYPEATSTARTUP_P_MIN = 7;
    const CAPTURETYPEATSTARTUP_V_AVG_MAX = 8;
    const CAPTURETYPEATSTARTUP_V_AVG_MIN = 9;
    const CAPTURETYPEATSTARTUP_V_RMS_MAX = 10;
    const CAPTURETYPEATSTARTUP_V_RMS_MIN = 11;
    const CAPTURETYPEATSTARTUP_I_AVG_MAX = 12;
    const CAPTURETYPEATSTARTUP_I_AVG_MIN = 13;
    const CAPTURETYPEATSTARTUP_I_RMS_MAX = 14;
    const CAPTURETYPEATSTARTUP_I_RMS_MIN = 15;
    const CAPTURETYPEATSTARTUP_P_AVG_MAX = 16;
    const CAPTURETYPEATSTARTUP_P_AVG_MIN = 17;
    const CAPTURETYPEATSTARTUP_PF_MIN = 18;
    const CAPTURETYPEATSTARTUP_DPF_MIN = 19;
    const CAPTURETYPEATSTARTUP_INVALID = -1;
    const CONDVALUEATSTARTUP_INVALID = YAPI::INVALID_DOUBLE;
    //--- (end of generated code: YInputCapture declaration)

    //--- (generated code: YInputCapture attributes)
    protected float $_lastCaptureTime = self::LASTCAPTURETIME_INVALID; // Time
    protected int $_nSamples = self::NSAMPLES_INVALID;       // UInt31
    protected int $_samplingRate = self::SAMPLINGRATE_INVALID;   // UInt31
    protected int $_captureType = self::CAPTURETYPE_INVALID;    // CaptureTypeAll
    protected float $_condValue = self::CONDVALUE_INVALID;      // MeasureVal
    protected int $_condAlign = self::CONDALIGN_INVALID;      // Percent
    protected int $_captureTypeAtStartup = self::CAPTURETYPEATSTARTUP_INVALID; // CaptureTypeAll
    protected float $_condValueAtStartup = self::CONDVALUEATSTARTUP_INVALID; // MeasureVal

    //--- (end of generated code: YInputCapture attributes)

    function __construct(string $str_func)
    {
        //--- (generated code: YInputCapture constructor)
        parent::__construct($str_func);
        $this->_className = 'InputCapture';

        //--- (end of generated code: YInputCapture constructor)
    }

    //--- (generated code: YInputCapture implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'lastCaptureTime':
            $this->_lastCaptureTime = intval($val);
            return 1;
        case 'nSamples':
            $this->_nSamples = intval($val);
            return 1;
        case 'samplingRate':
            $this->_samplingRate = intval($val);
            return 1;
        case 'captureType':
            $this->_captureType = intval($val);
            return 1;
        case 'condValue':
            $this->_condValue = round($val / 65.536) / 1000.0;
            return 1;
        case 'condAlign':
            $this->_condAlign = intval($val);
            return 1;
        case 'captureTypeAtStartup':
            $this->_captureTypeAtStartup = intval($val);
            return 1;
        case 'condValueAtStartup':
            $this->_condValueAtStartup = round($val / 65.536) / 1000.0;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the number of elapsed milliseconds between the module power on
     * and the last capture (time of trigger), or zero if no capture has been done.
     *
     * @return float  an integer corresponding to the number of elapsed milliseconds between the module power on
     *         and the last capture (time of trigger), or zero if no capture has been done
     *
     * On failure, throws an exception or returns YInputCapture::LASTCAPTURETIME_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_lastCaptureTime(): float
    {
        // $res                    is a long;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::LASTCAPTURETIME_INVALID;
            }
        }
        $res = $this->_lastCaptureTime;
        return $res;
    }

    /**
     * Returns the number of samples that will be captured.
     *
     * @return int  an integer corresponding to the number of samples that will be captured
     *
     * On failure, throws an exception or returns YInputCapture::NSAMPLES_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_nSamples(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::NSAMPLES_INVALID;
            }
        }
        $res = $this->_nSamples;
        return $res;
    }

    /**
     * Changes the type of automatic conditional capture.
     * The maximum number of samples depends on the device memory.
     *
     * If you want the change to be kept after a device reboot,
     * make sure  to call the matching module saveToFlash().
     *
     * @param int $newval : an integer corresponding to the type of automatic conditional capture
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_nSamples(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("nSamples", $rest_val);
    }

    /**
     * Returns the sampling frequency, in Hz.
     *
     * @return int  an integer corresponding to the sampling frequency, in Hz
     *
     * On failure, throws an exception or returns YInputCapture::SAMPLINGRATE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_samplingRate(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::SAMPLINGRATE_INVALID;
            }
        }
        $res = $this->_samplingRate;
        return $res;
    }

    /**
     * Returns the type of automatic conditional capture.
     *
     * @return int  a value among YInputCapture::CAPTURETYPE_NONE, YInputCapture::CAPTURETYPE_TIMED,
     * YInputCapture::CAPTURETYPE_V_MAX, YInputCapture::CAPTURETYPE_V_MIN, YInputCapture::CAPTURETYPE_I_MAX,
     * YInputCapture::CAPTURETYPE_I_MIN, YInputCapture::CAPTURETYPE_P_MAX, YInputCapture::CAPTURETYPE_P_MIN,
     * YInputCapture::CAPTURETYPE_V_AVG_MAX, YInputCapture::CAPTURETYPE_V_AVG_MIN,
     * YInputCapture::CAPTURETYPE_V_RMS_MAX, YInputCapture::CAPTURETYPE_V_RMS_MIN,
     * YInputCapture::CAPTURETYPE_I_AVG_MAX, YInputCapture::CAPTURETYPE_I_AVG_MIN,
     * YInputCapture::CAPTURETYPE_I_RMS_MAX, YInputCapture::CAPTURETYPE_I_RMS_MIN,
     * YInputCapture::CAPTURETYPE_P_AVG_MAX, YInputCapture::CAPTURETYPE_P_AVG_MIN,
     * YInputCapture::CAPTURETYPE_PF_MIN and YInputCapture::CAPTURETYPE_DPF_MIN corresponding to the type of
     * automatic conditional capture
     *
     * On failure, throws an exception or returns YInputCapture::CAPTURETYPE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_captureType(): int
    {
        // $res                    is a enumCAPTURETYPEALL;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::CAPTURETYPE_INVALID;
            }
        }
        $res = $this->_captureType;
        return $res;
    }

    /**
     * Changes the type of automatic conditional capture.
     *
     * @param int $newval : a value among YInputCapture::CAPTURETYPE_NONE, YInputCapture::CAPTURETYPE_TIMED,
     * YInputCapture::CAPTURETYPE_V_MAX, YInputCapture::CAPTURETYPE_V_MIN, YInputCapture::CAPTURETYPE_I_MAX,
     * YInputCapture::CAPTURETYPE_I_MIN, YInputCapture::CAPTURETYPE_P_MAX, YInputCapture::CAPTURETYPE_P_MIN,
     * YInputCapture::CAPTURETYPE_V_AVG_MAX, YInputCapture::CAPTURETYPE_V_AVG_MIN,
     * YInputCapture::CAPTURETYPE_V_RMS_MAX, YInputCapture::CAPTURETYPE_V_RMS_MIN,
     * YInputCapture::CAPTURETYPE_I_AVG_MAX, YInputCapture::CAPTURETYPE_I_AVG_MIN,
     * YInputCapture::CAPTURETYPE_I_RMS_MAX, YInputCapture::CAPTURETYPE_I_RMS_MIN,
     * YInputCapture::CAPTURETYPE_P_AVG_MAX, YInputCapture::CAPTURETYPE_P_AVG_MIN,
     * YInputCapture::CAPTURETYPE_PF_MIN and YInputCapture::CAPTURETYPE_DPF_MIN corresponding to the type of
     * automatic conditional capture
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_captureType(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("captureType", $rest_val);
    }

    /**
     * Changes current threshold value for automatic conditional capture.
     *
     * @param float $newval : a floating point number corresponding to current threshold value for
     * automatic conditional capture
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_condValue(float $newval): int
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("condValue", $rest_val);
    }

    /**
     * Returns current threshold value for automatic conditional capture.
     *
     * @return float  a floating point number corresponding to current threshold value for automatic
     * conditional capture
     *
     * On failure, throws an exception or returns YInputCapture::CONDVALUE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_condValue(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::CONDVALUE_INVALID;
            }
        }
        $res = $this->_condValue;
        return $res;
    }

    /**
     * Returns the relative position of the trigger event within the capture window.
     * When the value is 50%, the capture is centered on the event.
     *
     * @return int  an integer corresponding to the relative position of the trigger event within the capture window
     *
     * On failure, throws an exception or returns YInputCapture::CONDALIGN_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_condAlign(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::CONDALIGN_INVALID;
            }
        }
        $res = $this->_condAlign;
        return $res;
    }

    /**
     * Changes the relative position of the trigger event within the capture window.
     * The new value must be between 10% (on the left) and 90% (on the right).
     * When the value is 50%, the capture is centered on the event.
     *
     * If you want the change to be kept after a device reboot,
     * make sure  to call the matching module saveToFlash().
     *
     * @param int $newval : an integer corresponding to the relative position of the trigger event within
     * the capture window
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_condAlign(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("condAlign", $rest_val);
    }

    /**
     * Returns the type of automatic conditional capture
     * applied at device power on.
     *
     * @return int  a value among YInputCapture::CAPTURETYPEATSTARTUP_NONE,
     * YInputCapture::CAPTURETYPEATSTARTUP_TIMED, YInputCapture::CAPTURETYPEATSTARTUP_V_MAX,
     * YInputCapture::CAPTURETYPEATSTARTUP_V_MIN, YInputCapture::CAPTURETYPEATSTARTUP_I_MAX,
     * YInputCapture::CAPTURETYPEATSTARTUP_I_MIN, YInputCapture::CAPTURETYPEATSTARTUP_P_MAX,
     * YInputCapture::CAPTURETYPEATSTARTUP_P_MIN, YInputCapture::CAPTURETYPEATSTARTUP_V_AVG_MAX,
     * YInputCapture::CAPTURETYPEATSTARTUP_V_AVG_MIN, YInputCapture::CAPTURETYPEATSTARTUP_V_RMS_MAX,
     * YInputCapture::CAPTURETYPEATSTARTUP_V_RMS_MIN, YInputCapture::CAPTURETYPEATSTARTUP_I_AVG_MAX,
     * YInputCapture::CAPTURETYPEATSTARTUP_I_AVG_MIN, YInputCapture::CAPTURETYPEATSTARTUP_I_RMS_MAX,
     * YInputCapture::CAPTURETYPEATSTARTUP_I_RMS_MIN, YInputCapture::CAPTURETYPEATSTARTUP_P_AVG_MAX,
     * YInputCapture::CAPTURETYPEATSTARTUP_P_AVG_MIN, YInputCapture::CAPTURETYPEATSTARTUP_PF_MIN and
     * YInputCapture::CAPTURETYPEATSTARTUP_DPF_MIN corresponding to the type of automatic conditional capture
     *         applied at device power on
     *
     * On failure, throws an exception or returns YInputCapture::CAPTURETYPEATSTARTUP_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_captureTypeAtStartup(): int
    {
        // $res                    is a enumCAPTURETYPEALL;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::CAPTURETYPEATSTARTUP_INVALID;
            }
        }
        $res = $this->_captureTypeAtStartup;
        return $res;
    }

    /**
     * Changes the type of automatic conditional capture
     * applied at device power on.
     *
     * If you want the change to be kept after a device reboot,
     * make sure  to call the matching module saveToFlash().
     *
     * @param int $newval : a value among YInputCapture::CAPTURETYPEATSTARTUP_NONE,
     * YInputCapture::CAPTURETYPEATSTARTUP_TIMED, YInputCapture::CAPTURETYPEATSTARTUP_V_MAX,
     * YInputCapture::CAPTURETYPEATSTARTUP_V_MIN, YInputCapture::CAPTURETYPEATSTARTUP_I_MAX,
     * YInputCapture::CAPTURETYPEATSTARTUP_I_MIN, YInputCapture::CAPTURETYPEATSTARTUP_P_MAX,
     * YInputCapture::CAPTURETYPEATSTARTUP_P_MIN, YInputCapture::CAPTURETYPEATSTARTUP_V_AVG_MAX,
     * YInputCapture::CAPTURETYPEATSTARTUP_V_AVG_MIN, YInputCapture::CAPTURETYPEATSTARTUP_V_RMS_MAX,
     * YInputCapture::CAPTURETYPEATSTARTUP_V_RMS_MIN, YInputCapture::CAPTURETYPEATSTARTUP_I_AVG_MAX,
     * YInputCapture::CAPTURETYPEATSTARTUP_I_AVG_MIN, YInputCapture::CAPTURETYPEATSTARTUP_I_RMS_MAX,
     * YInputCapture::CAPTURETYPEATSTARTUP_I_RMS_MIN, YInputCapture::CAPTURETYPEATSTARTUP_P_AVG_MAX,
     * YInputCapture::CAPTURETYPEATSTARTUP_P_AVG_MIN, YInputCapture::CAPTURETYPEATSTARTUP_PF_MIN and
     * YInputCapture::CAPTURETYPEATSTARTUP_DPF_MIN corresponding to the type of automatic conditional capture
     *         applied at device power on
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_captureTypeAtStartup(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("captureTypeAtStartup", $rest_val);
    }

    /**
     * Changes current threshold value for automatic conditional
     * capture applied at device power on.
     *
     * If you want the change to be kept after a device reboot,
     * make sure  to call the matching module saveToFlash().
     *
     * @param float $newval : a floating point number corresponding to current threshold value for
     * automatic conditional
     *         capture applied at device power on
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_condValueAtStartup(float $newval): int
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("condValueAtStartup", $rest_val);
    }

    /**
     * Returns the threshold value for automatic conditional
     * capture applied at device power on.
     *
     * @return float  a floating point number corresponding to the threshold value for automatic conditional
     *         capture applied at device power on
     *
     * On failure, throws an exception or returns YInputCapture::CONDVALUEATSTARTUP_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_condValueAtStartup(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::CONDVALUEATSTARTUP_INVALID;
            }
        }
        $res = $this->_condValueAtStartup;
        return $res;
    }

    /**
     * Retrieves an instant snapshot trigger for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the instant snapshot trigger is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the instant snapshot trigger is
     * indeed online at a given time. In case of ambiguity when looking for
     * an instant snapshot trigger by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the instant snapshot trigger, for instance
     *         MyDevice.inputCapture.
     *
     * @return YInputCapture  a YInputCapture object allowing you to drive the instant snapshot trigger.
     */
    public static function FindInputCapture(string $func): YInputCapture
    {
        // $obj                    is a YInputCapture;
        $obj = YFunction::_FindFromCache('InputCapture', $func);
        if ($obj == null) {
            $obj = new YInputCapture($func);
            YFunction::_AddToCache('InputCapture', $func, $obj);
        }
        return $obj;
    }

    /**
     * Returns all details about the last automatic input capture.
     *
     * @return ?YInputCaptureData  an YInputCaptureData object including
     *         data series and all related meta-information.
     *         On failure, throws an exception or returns an capture object.
     * @throws YAPI_Exception on error
     */
    public function get_lastCapture(): ?YInputCaptureData
    {
        // $snapData               is a bin;

        $snapData = $this->_download('snap.bin');
        return new YInputCaptureData($this, $snapData);
    }

    /**
     * Returns a new immediate capture of the device inputs.
     *
     * @param int $msDuration : duration of the capture window,
     *         in milliseconds (eg. between 20 and 1000).
     *
     * @return ?YInputCaptureData  an YInputCaptureData object including
     *         data series for the specified duration.
     *         On failure, throws an exception or returns an capture object.
     * @throws YAPI_Exception on error
     */
    public function get_immediateCapture(int $msDuration): ?YInputCaptureData
    {
        // $snapUrl                is a str;
        // $snapData               is a bin;
        // $snapStart              is a int;
        if ($msDuration < 1) {
            $msDuration = 20;
        }
        if ($msDuration > 1000) {
            $msDuration = 1000;
        }
        $snapStart = intVal((-$msDuration) / (2));
        $snapUrl = sprintf('snap.bin?t=%d&d=%d', $snapStart, $msDuration);

        $snapData = $this->_download($snapUrl);
        return new YInputCaptureData($this, $snapData);
    }

    /**
     * @throws YAPI_Exception
     */
    public function lastCaptureTime(): float
{
    return $this->get_lastCaptureTime();
}

    /**
     * @throws YAPI_Exception
     */
    public function nSamples(): int
{
    return $this->get_nSamples();
}

    /**
     * @throws YAPI_Exception
     */
    public function setNSamples(int $newval): int
{
    return $this->set_nSamples($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function samplingRate(): int
{
    return $this->get_samplingRate();
}

    /**
     * @throws YAPI_Exception
     */
    public function captureType(): int
{
    return $this->get_captureType();
}

    /**
     * @throws YAPI_Exception
     */
    public function setCaptureType(int $newval): int
{
    return $this->set_captureType($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function setCondValue(float $newval): int
{
    return $this->set_condValue($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function condValue(): float
{
    return $this->get_condValue();
}

    /**
     * @throws YAPI_Exception
     */
    public function condAlign(): int
{
    return $this->get_condAlign();
}

    /**
     * @throws YAPI_Exception
     */
    public function setCondAlign(int $newval): int
{
    return $this->set_condAlign($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function captureTypeAtStartup(): int
{
    return $this->get_captureTypeAtStartup();
}

    /**
     * @throws YAPI_Exception
     */
    public function setCaptureTypeAtStartup(int $newval): int
{
    return $this->set_captureTypeAtStartup($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function setCondValueAtStartup(float $newval): int
{
    return $this->set_condValueAtStartup($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function condValueAtStartup(): float
{
    return $this->get_condValueAtStartup();
}

    /**
     * comment from .yc definition
     */
    public function nextInputCapture(): ?YInputCapture
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindInputCapture($next_hwid);
    }

    /**
     * comment from .yc definition
     */
    public static function FirstInputCapture(): ?YInputCapture
    {
        $next_hwid = YAPI::getFirstHardwareId('InputCapture');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindInputCapture($next_hwid);
    }

    //--- (end of generated code: YInputCapture implementation)

}

;
//^^^^ YInputCapture.php

//--- (generated code: YInputCapture functions)

/**
 * Retrieves an instant snapshot trigger for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 *
 * This function does not require that the instant snapshot trigger is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method isOnline() to test if the instant snapshot trigger is
 * indeed online at a given time. In case of ambiguity when looking for
 * an instant snapshot trigger by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 *
 * If a call to this object's is_online() method returns FALSE although
 * you are certain that the matching device is plugged, make sure that you did
 * call registerHub() at application initialization time.
 *
 * @param string $func : a string that uniquely characterizes the instant snapshot trigger, for instance
 *         MyDevice.inputCapture.
 *
 * @return YInputCapture  a YInputCapture object allowing you to drive the instant snapshot trigger.
 */
function yFindInputCapture(string $func): YInputCapture
{
    return YInputCapture::FindInputCapture($func);
}

/**
 * comment from .yc definition
 */
function yFirstInputCapture(): ?YInputCapture
{
    return YInputCapture::FirstInputCapture();
}

//--- (end of generated code: YInputCapture functions)
?>