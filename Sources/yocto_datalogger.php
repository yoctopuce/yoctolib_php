<?php
/*********************************************************************
 *
 * $Id: yocto_datalogger.php 12326 2013-08-13 15:52:20Z mvuilleu $
 *
 * Implements yFindDataLogger(), the high-level API for DataLogger functions
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
 *  THE SOFTWARE AND DOCUMENTATION ARE PROVIDED "AS IS" WITHOUT
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

//--- (generated code: YDataLogger definitions)
if(!defined('Y_RECORDING_OFF')) define('Y_RECORDING_OFF', 0);
if(!defined('Y_RECORDING_ON')) define('Y_RECORDING_ON', 1);
if(!defined('Y_RECORDING_INVALID')) define('Y_RECORDING_INVALID', -1);
if(!defined('Y_AUTOSTART_OFF')) define('Y_AUTOSTART_OFF', 0);
if(!defined('Y_AUTOSTART_ON')) define('Y_AUTOSTART_ON', 1);
if(!defined('Y_AUTOSTART_INVALID')) define('Y_AUTOSTART_INVALID', -1);
if(!defined('Y_CLEARHISTORY_FALSE')) define('Y_CLEARHISTORY_FALSE', 0);
if(!defined('Y_CLEARHISTORY_TRUE')) define('Y_CLEARHISTORY_TRUE', 1);
if(!defined('Y_CLEARHISTORY_INVALID')) define('Y_CLEARHISTORY_INVALID', -1);
if(!defined('Y_LOGICALNAME_INVALID')) define('Y_LOGICALNAME_INVALID', Y_INVALID_STRING);
if(!defined('Y_ADVERTISEDVALUE_INVALID')) define('Y_ADVERTISEDVALUE_INVALID', Y_INVALID_STRING);
if(!defined('Y_OLDESTRUNINDEX_INVALID')) define('Y_OLDESTRUNINDEX_INVALID', Y_INVALID_UNSIGNED);
if(!defined('Y_CURRENTRUNINDEX_INVALID')) define('Y_CURRENTRUNINDEX_INVALID', Y_INVALID_UNSIGNED);
if(!defined('Y_SAMPLINGINTERVAL_INVALID')) define('Y_SAMPLINGINTERVAL_INVALID', Y_INVALID_UNSIGNED);
if(!defined('Y_TIMEUTC_INVALID')) define('Y_TIMEUTC_INVALID', Y_INVALID_UNSIGNED);
//--- (end of generated code: YDataLogger definitions)

if(!defined('Y_DATA_INVALID'))         define('Y_DATA_INVALID', -66666666.66666666);
if(!defined('Y_MINVALUE_INVALID'))     define('Y_MINVALUE_INVALID', -66666666.66666666);
if(!defined('Y_AVERAGEVALUE_INVALID')) define('Y_AVERAGEVALUE_INVALID', -66666666.66666666);
if(!defined('Y_MAXVALUE_INVALID'))     define('Y_MAXVALUE_INVALID', -66666666.66666666);

/**
 * YDataStream Class: Sequence of measured data, stored by the data logger
 * 
 * A data stream is a small collection of consecutive measures for a set
 * of sensors. A few properties are available directly from the object itself
 * (they are preloaded at instantiation time), while most other properties and
 * the actual data are loaded on demand when accessed for the first time.
 */
class YDataStream {
    const DATA_INVALID = Y_INVALID_FLOAT;

    // Data preloaded on object instantiation
    protected       $dataLogger;
    protected       $runNo, $timeStamp, $interval;
    protected       $utcStamp;
    
    // Data loaded using a specific connection
    protected       $nRows, $nCols;
    protected       $columnNames;
    protected       $values;

    function __construct($parent, $run, $stamp, $utc=-1, $itv=0)
    {
        $this->dataLogger = $parent;
        $this->runNo      = $run;
        $this->timeStamp  = $stamp;
        $this->utcStamp   = $utc;
        $this->interval   = $itv;
        $this->nRows      = 0;
        $this->nCols      = 0;
        $this->columnNames = Array();
        $this->values      = Array();
    }
    
    // Internal function to preload all values into object
    //
    public function loadStream()
    {
        $coldiv = null;
        $coltyp = null;
        $colscl = null;
        $colofs = null;
        $calhdl = null;
        $caltyp = null;
        $calpar = null;
        $calraw = null;
        $calref = null;

        $retcode = $this->dataLogger->getData($this->runNo, $this->timeStamp, $loadval);
        if($retcode != YAPI_SUCCESS) {
            return $retcode;
        }
        if(isset($loadval['time']))     $this->timeStamp = $loadval['time'];
        if(isset($loadval['UTC']))      $this->utcStamp  = $loadval['UTC'];
        if(isset($loadval['interval'])) $this->interval  = $loadval['interval'];
        if(isset($loadval['nRows']))    $this->nRows     = $loadval['nRows'];
        if(isset($loadval['keys'])) {
            $this->columnNames = $loadval['keys'];
            if($this->nCols == 0) {
                $this->nCols = sizeof($this->columnNames);
            } else if($this->nCols != sizeof($this->columnNames)) {
                $this->nCols = 0;
                return YAPI_IO_ERROR;
            }
        }
        if(isset($loadval['div'])) {
            $coldiv = $loadval['div'];
            if($this->nCols == 0) {
                $this->nCols = sizeof($coldiv);
            } else if($this->nCols != sizeof($coldiv)) {
                $this->nCols = 0;
                return YAPI_IO_ERROR;
            }
        }
        if(isset($loadval['type'])) {
            $coltyp = $loadval['type'];
            if($this->nCols == 0) {
                $this->nCols = sizeof($coltyp);
            } else if($this->nCols != sizeof($coltyp)) {
                $this->nCols = 0;
                return YAPI_IO_ERROR;
            }
        }
        if(isset($loadval['scal'])) {
            $colscl = $loadval['scal'];
            $colofs = Array();
            if($this->nCols == 0) {
                $this->nCols = sizeof($colscl);
            } else if($this->nCols != sizeof($colscl)) {
                $this->nCols = 0;
                return YAPI_IO_ERROR;
            }
            for($i = 0; $i < sizeof($colscl); $i++) {
                $colscl[$i] /= 65536.0;
                $colofs[$i] = ($coltyp[$i] != 0 ? -32767 : 0);
            }
        } else {
            $colscl = Array();
            $colofs = Array();
            for($i = 0; $i < sizeof($coldiv); $i++) {
                $colscl[$i] = 1.0 / $coldiv[$i];
                $colofs[$i] = ($coltyp[$i] != 0 ? -32767 : 0);
            }
        }
        if(isset($loadval['cal'])) {
            $calhdl = Array();
            $caltyp = Array();
            $calpar = Array();
            $calraw = Array();
            $calref = Array();
            for($c = 0; $c < $this->nCols; $c++) {
                $params = $loadval['cal'][$c];
                if(!$params) continue;
                $params = explode(',', $params);
                if(sizeof($params) < 11) continue;
                $calhdl[$c] = YAPI::getCalibrationHandler($params[0]);
                if(is_null($calhdl[$c])) continue;
                $caltyp[$c] = intVal($params[0]);
                $calpar[$c] = Array();
                $calraw[$c] = Array();
                $calref[$c] = Array();
                for($i = 1; $i < sizeof($params); $i += 2) {
                    $calpar[$c][$i-1] = intVal($params[$i]);
                    $calpar[$c][$i]   = intVal($params[$i+1]);
                    if($caltyp[$c] <= 10) {
                        $calraw[$c][$i>>1] = ($calpar[$c][$i-1] + $colofs[$c]) / $coldiv[$c];
                        $calref[$c][$i>>1] = ($calpar[$c][$i]   + $colofs[$c]) / $coldiv[$c];
                    } else {
                        $calraw[$c][$i>>1] = YAPI::decimalToDouble($calpar[$c][$i-1]);
                        $calref[$c][$i>>1] = YAPI::decimalToDouble($calpar[$c][$i]);
                    }
                }
            }
        }
        if(isset($loadval['data'])) {
            if($this->nCols == 0 || is_null($coldiv) || is_null($coltyp)) {
                return YAPI_IO_ERROR;
            }
            if(is_string($loadval['data'])) {
                $data = $loadval['data'];
                $datalen = strlen($data);
                $udata = Array();
                for($i = 0; $i < $datalen;) {
                    if($data[$i] >= 'a') {
                        $srcpos = sizeof($udata)-1-(ord($data[$i++])-97);
                        if($srcpos < 0) return YAPI_IO_ERROR;
                        $udata[] = $udata[$srcpos];
                    } else {
                        if($i+2 > $datalen) return YAPI_IO_ERROR;
                        $val = ord($data[$i++]) - 48;
                        $val += (ord($data[$i++]) - 48) << 5;
                        if($data[$i] == 'z') $data[$i] = '\\';
                        $val += (ord($data[$i++]) - 48) << 10;
                        $udata[] = $val;
                    }
                }
                $loadval['data'] = $udata;
            }
            $this->values = Array();
            $dat = Array();
            $c = 0;
            foreach($loadval['data'] as $val) {
                if($coltyp[$c] < 2) {
                    $val = ($val + $colofs[$c]) * $colscl[$c];
                } else {
                    $val = YAPI::decimalToDouble($val-32767);
                }
                if(!is_null($calhdl) && isset($calhdl[$c])) {                    
                    // use post-calibration function                    
                    if($caltyp[$c] <= 10) {
                        $val = call_user_func($calhdl[$c], ($val+$colofs[$c])/$coldiv[$c], $caltyp[$c], 
                                              $calpar[$c], $calraw[$c], $calref[$c]);
                    } else if($caltyp[$c] > 20) {
                        $val = call_user_func($calhdl[$c], $val, $caltyp[$c], 
                                              $calpar[$c], $calraw[$c], $calref[$c]);                        
                    }
                }
                $dat[] = $val;
                if(++$c == $this->nCols) {
                    $this->values[] = $dat;
                    $dat = Array();
                    $c = 0;
                }
            }
        }
        return YAPI_SUCCESS;
    }

    /**
     * Returns the run index of the data stream. A run can be made of
     * multiple datastreams, for different time intervals.
     * 
     * This method does not cause any access to the device, as the value
     * is preloaded in the object at instantiation time.
     * 
     * @return an unsigned number corresponding to the run index.
     */
    public function get_runIndex()
    {
        return $this->runNo;
    }
    public function runIndex()
    {
        return $this->runNo;
    }
    
    /**
     * Returns the start time of the data stream, relative to the beginning
     * of the run. If you need an absolute time, use get_startTimeUTC().
     * 
     * This method does not cause any access to the device, as the value
     * is preloaded in the object at instantiation time.
     * 
     * @return an unsigned number corresponding to the number of seconds
     *         between the start of the run and the beginning of this data
     *         stream.
     */
    public function get_startTime()
    {
        return $this->timeStamp;
    }
    public function startTime()
    {
        return $this->timeStamp;
    }

    /**
     * Returns the start time of the data stream, relative to the Jan 1, 1970.
     * If the UTC time was not set in the datalogger at the time of the recording
     * of this data stream, this method returns 0.
     * 
     * This method does not cause any access to the device, as the value
     * is preloaded in the object at instantiation time.
     * 
     * @return an unsigned number corresponding to the number of seconds
     *         between the Jan 1, 1970 and the beginning of this data
     *         stream (i.e. Unix time representation of the absolute time).
     */
    public function get_startTimeUTC()
    {
        if($this->utcStamp == -1) $this->loadStream();
        return $this->utcStamp;
    }
    public function startTimeUTC()
    {
        if($this->utcStamp == -1) $this->loadStream();
        return $this->utcStamp;
    }

    /**
     * Returns the number of seconds elapsed between  two consecutive
     * rows of this data stream. By default, the data logger records one row
     * per second, but there might be alternative streams at lower resolution
     * created by summarizing the original stream for archiving purposes.
     * 
     * This method does not cause any access to the device, as the value
     * is preloaded in the object at instantiation time.
     * 
     * @return an unsigned number corresponding to a number of seconds.
     */
    public function get_dataSamplesInterval()
    {
        if($this->interval == 0) $this->loadStream();
        return $this->interval;
    }
    public function dataSamplesInterval()
    {
        if($this->interval == 0) $this->loadStream();
        return $this->interval;
    }

    /**
     * Returns the number of data rows present in this stream.
     * 
     * This method fetches the whole data stream from the device,
     * if not yet done.
     * 
     * @return an unsigned number corresponding to the number of rows.
     * 
     * On failure, throws an exception or returns zero.
     */
    public function get_rowCount()
    {
        if($this->nRows == 0) $this->loadStream();
        return $this->nRows;
    }
    public function rowCount()
    {
        if($this->nRows == 0) $this->loadStream();
        return $this->nRows;
    }
    
    /**
     * Returns the number of data columns present in this stream.
     * The meaning of the values present in each column can be obtained
     * using the method get_columnNames().
     * 
     * This method fetches the whole data stream from the device,
     * if not yet done.
     * 
     * @return an unsigned number corresponding to the number of rows.
     * 
     * On failure, throws an exception or returns zero.
     */
    public function get_columnCount()
    {
        if($this->nCols == 0) $this->loadStream();
        return $this->nCols;
    }
    public function columnCount()
    {
        if($this->nCols == 0) $this->loadStream();
        return $this->nCols;
    }

    /**
     * Returns the title (or meaning) of each data column present in this stream.
     * In most case, the title of the data column is the hardware identifier
     * of the sensor that produced the data. For archived streams created by
     * summarizing a high-resolution data stream, there can be a suffix appended
     * to the sensor identifier, such as _min for the minimum value, _avg for the
     * average value and _max for the maximal value.
     * 
     * This method fetches the whole data stream from the device,
     * if not yet done.
     * 
     * @return a list containing as many strings as there are columns in the
     *         data stream.
     * 
     * On failure, throws an exception or returns an empty array.
     */
    public function get_columnNames()
    {
        if(sizeof($this->columnNames) == 0) $this->loadStream();
        return $this->columnNames;
    }
    public function columnNames()
    {
        if(sizeof($this->columnNames) == 0) $this->loadStream();
        return $this->columnNames;
    }

    /**
     * Returns the whole data set contained in the stream, as a bidimensional
     * table of numbers.
     * The meaning of the values present in each column can be obtained
     * using the method get_columnNames().
     * 
     * This method fetches the whole data stream from the device,
     * if not yet done.
     * 
     * @return a list containing as many elements as there are rows in the
     *         data stream. Each row itself is a list of floating-point
     *         numbers.
     * 
     * On failure, throws an exception or returns an empty array.
     */
    public function get_dataRows()
    {
        if(sizeof($this->values) == 0) $this->loadStream();
        return $this->values;
    }
    public function dataRows()
    {
        if(sizeof($this->values) == 0) $this->loadStream();
        return $this->values;
    }
    
    /**
     * Returns a single measure from the data stream, specified by its
     * row and column index.
     * The meaning of the values present in each column can be obtained
     * using the method get_columnNames().
     * 
     * This method fetches the whole data stream from the device,
     * if not yet done.
     * 
     * @param row : row index
     * @param col : column index
     * 
     * @return a floating-point number
     * 
     * On failure, throws an exception or returns Y_DATA_INVALID.
     */
    public function get_data($row, $col)
    {
        if(sizeof($this->values) == 0) $this->loadStream();
        if($row >= sizeof($this->values)) return Y_DATA_INVALID;
        if($col >= sizeof($this->values[$row])) return Y_DATA_INVALID;
        return $this->values[$row][$col];
    }
    public function data($row, $col)
    {
        if(sizeof($this->values) == 0) $this->loadStream();
        if($row >= sizeof($this->values)) return Y_DATA_INVALID;
        if($col >= sizeof($this->values[$row])) return Y_DATA_INVALID;
        return $this->values[$row][$col];
    }
};

/**
 * YDataRun Class: Sequence of measured data, stored by the data logger
 * 
 * A run is a continuous interval of time during which a module was powered on.
 * A data run provides easy access to all data collected during a given run,
 * providing on-the-fly resampling at the desired reporting rate.
 */
class YDataRun
{
    const MINVALUE_INVALID     = -66666666.66666666;
    const AVERAGEVALUE_INVALID = -66666666.66666666;
    const MAXVALUE_INVALID     = -66666666.66666666;

    protected       $dataLogger;
    protected       $runNo;
    protected       $streams;
    protected       $measureNames;
    protected       $browseInterval;
    protected       $startTimeUTC;
    protected       $duration;
    protected       $isLive;
    protected       $minValues;
    protected       $avgValues;
    protected       $maxValues;

    function __construct($parent, $run)
    {
        $this->dataLogger    = $parent;
        $this->runNo         = $run;
        $this->streams       = Array();
        $this->browseInterval = 60;
        $this->startTimeUTC  = 0;
        $this->duration      = 0;
        $this->isLive        = false;
    }

    // Internal: Append a stream to the run
    //
    public function addStream($stream)
    {
        $this->streams[] = $stream;
        if($this->startTimeUTC == 0) {
            if($stream->get_startTimeUTC() > 0) {
                $this->startTimeUTC = $stream->get_startTimeUTC() - $stream->get_startTime();
            }
        }
    }

    // Internal: Compute the total duration of the run, once all streams have been added
    //
    public function finalize()
    {
        $last = end($this->streams);
        $this->duration = $last->get_startTime() + $last->get_rowCount() * $last->get_dataSamplesInterval();
        $this->isLive = ($this->dataLogger->get_currentRunIndex() == $this->runNo &&
                         $this->dataLogger->get_recording() == Y_RECORDING_ON);
        if($this->isLive && $this->startTimeUTC == 0) {
            $this->startTimeUTC = yGetTickCount() - $this->duration;
        }
        $this->measureNames = $this->dataLogger->get_measureNames();
        if(sizeof($this->streams) > 0) {
            $this->set_valueInterval($this->streams[0]->get_dataSamplesInterval());
        } else {
            $this->set_valueInterval(60);
        }
    }

    // Internal: Update the run with any new data that may have appeared since the run was initially loaded
    //
    public function refresh()
    {
        if($this->isLive) {
            $last = end($this->streams);
            $last->loadStream();
            $this->duration = $last->get_startTime() + $last->get_rowCount() * $last->get_dataSamplesInterval();
            if(yGetTickCount() > $this->startTimeUTC + $this->duration) {
                // check if new streams have appeared in between
                $newStreams = false;
                $streams = Array();
                $this->dataLogger->get_dataStreams($streams);
                foreach($streams as $stream) {
                    if($stream->get_runIndex() == $this->runNo && $stream->get_startTime() > $last->get_startTime()) {
                        $this->addStream($stream);
                        $newStreams = true;
                    }
                }
                if($newStreams) $this->finalize();
            }
            $this->isLive = ($this->dataLogger->get_recording() == Y_RECORDING_ON);
        }
    }

    // Internal: Mark a measure as unavailable
    //
    public function invalidValue($pos)
    {
        foreach($this->measureNames as $key) {
            $this->minValues[$key][$pos] = Y_MINVALUE_INVALID;
            $this->avgValues[$key][$pos] = Y_AVERAGEVALUE_INVALID;
            $this->maxValues[$key][$pos] = Y_MAXVALUE_INVALID;
        }
    }

    // Internal: Compute the resampled measure values for a required position in run
    //
    public function computeValues($pos)
    {
        // if there is no data stream, exit immediately
        if(sizeof($this->streams) == 0) {
            $this->invalidValue($pos);
            return;
        }

        // search for the earliest stream with useful data for requested measure
        $time = $pos * $this->browseInterval;
        $endtime = $time + $this->browseInterval;
        $prevMissing = $pos + 1;
        $si = sizeof($this->streams)-1;
        $stream = $this->streams[$si];
        while($stream->get_startTime() > $time && $si > 0) {
            $si--;
            $stream = $this->streams[$si];
        }
        $streamInterval = $stream->get_dataSamplesInterval();
        $thisAvail = floor($stream->get_startTime() / $this->browseInterval);
        $nextMissing = ceil(($stream->get_startTime() + $stream->get_rowCount() * $streamInterval) / $this->browseInterval);
        if($nextMissing * $this->browseInterval <= $time && $si < sizeof($this->streams)-1) {
            // we went back one step to much
            $prevMissing = $nextMissing;
            $si++;
            $stream = $this->streams[$si];
            $streamInterval = $stream->get_dataSamplesInterval();
            $thisAvail = floor($stream->get_startTime() / $this->browseInterval);
            $nextMissing = ceil(($stream->get_startTime() + $stream->get_rowCount() * $streamInterval) / $this->browseInterval);
        } else {
            // nothing interesting before this stream
            if ($stream->get_startTime() > $time)
                $prevMissing=0;
            else
                $prevMissing = $thisAvail-1;
        }
        if($si+1 >= sizeof($this->streams)) {
            $nextAvail = $pos+1;
        } else {
            $nextStream = $this->streams[$si+1];
            $nextAvail = floor($nextStream->get_startTime() / $this->browseInterval);
        }
        // Check if we are looking for a missing measure
        if($pos >= $prevMissing && $pos < $thisAvail) {
            for($pos = $prevMissing; $pos < $thisAvail; $pos++) $this->invalidValue($pos);
            return;
        }
        if($pos >= $nextMissing && $pos < $nextAvail) {
            for($pos = $nextMissing; $pos < $nextAvail; $pos++) $this->invalidValue($pos);
            return;
        }
        // process all useful rows from the stream containing requested position, until completely processed
        if($prevMissing < $thisAvail) {
            // stream is not a continuation, start with very beginning of stream
            $row = 0;
            $pos = $thisAvail;
            $startTime = $stream->get_startTime();
        } else {
            // stream is a continuation, start at next interval boundary
            $pos = ceil($stream->get_startTime() / $this->browseInterval);
            $row = round(($pos * $this->browseInterval - $stream->get_startTime()) / $streamInterval);
            $startTime = $stream->get_startTime() + $row * $streamInterval;
        }
        $stopAsap = false;
        $minCol = Array();
        $avgCol = Array();
        $maxCol = Array();
        $minVal = Array();
        $avgVal = Array();
        $maxVal = Array();
        $divisor = 0;
        $boundary = ($pos+1) * $this->browseInterval;
        $stopTime = ceil(($stream->get_startTime() + $stream->get_rowCount() * $stream->get_dataSamplesInterval()) / $this->browseInterval) * $this->browseInterval;
        while($startTime < $stopTime) {
            $nextTime = $startTime + $streamInterval;
            //Print("startTime=$startTime -- nextTime=$nextTime -- stopTime=$stopTime -- boundary=$boundary -- row=$row -- pos=$pos\n");
            if(sizeof($avgCol) == 0) {
                $streamsCols = $stream->get_columnNames();
                foreach($streamsCols as $idx => $colname) {
                    if(substr($colname, -4, 1) == '_') {
                        $name = substr($colname, 0, -4);
                        $suffix = substr($colname, -3);
                        if($suffix == 'min') $minCol[$name] = $idx;
                        else if($suffix == 'avg') $avgCol[$name] = $idx;
                        else if($suffix == 'max') $maxCol[$name] = $idx;
                    } else {
                        $minCol[$colname] = $idx;
                        $avgCol[$colname] = $idx;
                        $maxCol[$colname] = $idx;
                    }
                }
            }
            if($divisor == 0) {
                if($boundary <= $nextTime) {
                    while($boundary <= $nextTime) {
                        foreach($this->measureNames as $key) {
                            $this->minValues[$key][$pos] = $stream->get_data($row, $minCol[$key]);
                            $this->avgValues[$key][$pos] = $stream->get_data($row, $avgCol[$key]);
                            $this->maxValues[$key][$pos] = $stream->get_data($row, $maxCol[$key]);
                        }
                        $pos++;
                        $boundary = ($pos+1) * $this->browseInterval;
                    }
                } else {
                    $divisor = $streamInterval;
                    foreach($this->measureNames as $key) {
                        $minVal[$key] = $stream->get_data($row, $minCol[$key]);
                        $avgVal[$key] = $stream->get_data($row, $avgCol[$key]) * $streamInterval;
                        $maxVal[$key] = $stream->get_data($row, $maxCol[$key]);
                    }
                }
            } else {
                $divisor += $streamInterval;
                foreach($this->measureNames as $key) {
                    $minVal[$key] = min($minVal[$key], $stream->get_data($row, $minCol[$key]));
                    $avgVal[$key] += $streamInterval * $stream->get_data($row, $avgCol[$key]);
                    $maxVal[$key] = max($maxVal[$key], $stream->get_data($row, $maxCol[$key]));
                }
                if(2*abs($nextTime - $boundary) <= $streamInterval) {
                    foreach($this->measureNames as $key) {
                        $this->minValues[$key][$pos] = $minVal[$key];
                        $this->avgValues[$key][$pos] = $avgVal[$key] / $divisor;
                        $this->maxValues[$key][$pos] = $maxVal[$key];
                    }
                    $divisor = 0;
                    $pos++;
                    $boundary = ($pos+1) * $this->browseInterval;
                    if($stopAsap) break;
                }
            }
            $row++;
            if($row < $stream->get_rowCount()) {
                $startTime = $nextTime;                
            } else {
                $si++;
                if($si >= sizeof($this->streams)) break;
                $stream = $this->streams[$si];
                $startTime = $stream->get_startTime();
                $streamInterval = $stream->get_dataSamplesInterval();
                $row = 0;
                $avgCol = Array();
                $stopAsap = true;
            }
        }
        if($divisor > 0) {
            // save partially computed value anyway
            foreach($this->measureNames as $key) {
                $this->minValues[$key][$pos] = $minVal[$key];
                $this->avgValues[$key][$pos] = $avgVal[$key] / $divisor;
                $this->maxValues[$key][$pos] = $maxVal[$key];
            }
        }
    }

    /**
     * Returns the names of the measures recorded by the data logger.
     * In most case, the measure names match the hardware identifier
     * of the sensor that produced the data.
     * 
     * @return a list of strings (the measure names)
     * 
     * On failure, throws an exception or returns an empty array.
     */
    public function get_measureNames()
    {
        return $this->measureNames;
    }
    public function measureNames()
    {
        return $this->measureNames;
    }

    /**
     * Returns the start time of the data stream, relative to the Jan 1, 1970.
     * If the UTC time was not set in the datalogger at the time of the recording
     * of this data stream, this method returns 0.
     * 
     * This method does not cause any access to the device, as the value
     * is preloaded in the object at instantiation time.
     * 
     * @return an unsigned number corresponding to the number of seconds
     *         between the Jan 1, 1970 and the beginning of this data
     *         stream (i.e. Unix time representation of the absolute time).
     */
    public function get_startTimeUTC()
    {
        return $this->startTimeUTC;
    }
    public function startTimeUTC()
    {
        return $this->startTimeUTC;
    }

    /**
     * Returns the duration (in seconds) of the data run.
     * When the datalogger is actively recording and the specified run is the current
     * run, calling this method reloads last sequence(s) from device to make sure
     * it includes the latest recorded data.
     * 
     * @return an unsigned number corresponding to the number of seconds
     *         between the beginning of the run (when the module was powered up)
     *         and the last recorded measure.
     */
    public function get_duration()
    {
        if($this->isLive) $this->refresh();
        return $this->duration;
    }
    public function duration()
    {
        if($this->isLive) $this->refresh();
        return $this->duration;
    }

    /**
     * Returns the number of seconds covered by each value in this run.
     * By default, the value interval is set to the coarsest data rate
     * archived in the data logger flash for this run. The value interval
     * can however be configured at will to a different rate when desired.
     * 
     * @return an unsigned number corresponding to a number of seconds covered
     *         by each data sample in the Run.
     */
    public function get_valueInterval()
    {
        return $this->browseInterval;
    }
    public function valueInterval()
    {
        return $this->browseInterval;
    }

    /**
     * Changes the number of seconds covered by each value in this run.
     * By default, the value interval is set to the coarsest data rate
     * archived in the data logger flash for this run. The value interval
     * can however be configured at will to a different rate when desired.
     * 
     * @param valueInterval : an integer number of seconds.
     * 
     * @return nothing
     */
    public function set_valueInterval($valueInterval)
    {
        $last = end($this->streams);
        $names = $last->get_columnNames();
        $this->minValues = Array();
        $this->avgValues = Array();
        $this->maxValues = Array();
        foreach($names as $name) {
            if(substr($name, -4, 1) == '_') {
                $name = substr($name, 0, -4);
            }
            if(!isset($this->minValues[$name])) {
                $this->minValues[$name] = Array();
                $this->avgValues[$name] = Array();
                $this->maxValues[$name] = Array();
            }
        }
        $this->browseInterval = $valueInterval;
    }
    public function setValueInterval($valueInterval)
    { return set_valueInterval($valueInterval); }

    /**
     * Returns the number of values accessible in this run, given the selected data
     * samples interval.
     * When the datalogger is actively recording and the specified run is the current
     * run, calling this method reloads last sequence(s) from device to make sure
     * it includes the latest recorded data.
     * 
     * @return an unsigned number corresponding to the run duration divided by the
     *         samples interval.
     */
    public function get_valueCount()
    {
        if($this->isLive) $this->refresh();
        return ceil($this->duration / $this->browseInterval);
    }
    public function valueCount()
    {
        if($this->isLive) $this->refresh();
        return ceil($this->duration / $this->browseInterval);
    }
    
    /**
     * Returns the minimal value of the measure observed at the specified time
     * period.
     * 
     * @param measureName : the name of the desired measure (one of the names
     *         returned by get_measureNames)
     * @param pos : the position index, between 0 and the value returned by
     *         get_valueCount
     * 
     * @return a floating point number (the minimal value)
     * 
     * On failure, throws an exception or returns Y_MINVALUE_INVALID.
     */
    public function get_minValue($measureName, $pos)
    {
        if(!isset($this->minValues[$measureName][$pos])) $this->computeValues($pos);
        if(!isset($this->minValues[$measureName][$pos])) return Y_MINVALUE_INVALID;
        return $this->minValues[$measureName][$pos];
    }
    public function minValue($measureName, $pos)
    {
        if(!isset($this->minValues[$measureName][$pos])) $this->computeValues($pos);
        if(!isset($this->minValues[$measureName][$pos])) return Y_MINVALUE_INVALID;
        return $this->minValues[$measureName][$pos];
    }

    /**
     * Returns the average value of the measure observed at the specified time
     * period.
     * 
     * @param measureName : the name of the desired measure (one of the names
     *         returned by get_measureNames)
     * @param pos : the position index, between 0 and the value returned by
     *         get_valueCount
     * 
     * @return a floating point number (the average value)
     * 
     * On failure, throws an exception or returns Y_AVERAGEVALUE_INVALID.
     */
    public function get_averageValue($measureName, $pos)
    {
        if(!isset($this->avgValues[$measureName][$pos])) $this->computeValues($pos);
        if(!isset($this->minValues[$measureName][$pos])) return Y_AVERAGEVALUE_INVALID;
        return $this->avgValues[$measureName][$pos];
    }
    public function averageValue($measureName, $pos)
    {
        if(!isset($this->avgValues[$measureName][$pos])) $this->computeValues($pos);
        if(!isset($this->minValues[$measureName][$pos])) return Y_AVERAGEVALUE_INVALID;
        return $this->avgValues[$measureName][$pos];
    }

    /**
     * Returns the maximal value of the measure observed at the specified time
     * period.
     * 
     * @param measureName : the name of the desired measure (one of the names
     *         returned by get_measureNames)
     * @param pos : the position index, between 0 and the value returned by
     *         get_valueCount
     * 
     * @return a floating point number (the maximal value)
     * 
     * On failure, throws an exception or returns Y_MAXVALUE_INVALID.
     */
    public function get_maxValue($measureName, $pos)
    {
        if(!isset($this->maxValues[$measureName][$pos])) $this->computeValues($pos);
        if(!isset($this->minValues[$measureName][$pos])) return Y_MAXVALUE_INVALID;
        return $this->maxValues[$measureName][$pos];
    }
    public function maxValue($measureName, $pos)
    {
        if(!isset($this->maxValues[$measureName][$pos])) $this->computeValues($pos);
        if(!isset($this->minValues[$measureName][$pos])) return Y_MAXVALUE_INVALID;
        return $this->maxValues[$measureName][$pos];
    }
}

/**
 * YDataLogger Class: DataLogger function interface
 * 
 * Yoctopuce sensors include a non-volatile memory capable of storing ongoing measured
 * data automatically, without requiring a permanent connection to a computer.
 * The Yoctopuce application programming interface includes fonctions to control
 * the functioning of this internal data logger.
 * Since the sensors do not include a battery, they don't have an absolute time
 * reference. Therefore, measures are simply indexed by the absolute run number
 * and time relative to the start of the run. Every new power up starts a new run.
 * It is however possible to setup an absolute UTC time by software at a given time,
 * so that the data logger keeps track of it until next time it is powered off.
 */
class YDataLogger extends YFunction
{
    protected       $dataLoggerURL = null;
    protected       $measureNames = null;
    protected       $dataRuns = null;
    protected       $liveRun = 0;

    // Internal function to retrieve datalogger memory
    //
    public function getData($runIdx, $timeIdx, &$loadval)
    {
        if(is_null($this->dataLoggerURL)) {
            $this->dataLoggerURL = "/logger.json";
        }

        // get the device serial number
        $devid = $this->module()->get_serialNumber();
        if($devid == Y_SERIALNUMBER_INVALID) {
            return $this->get_errorType();
        }
        $httpreq = "GET ".$this->dataLoggerURL;
        if(!is_null($timeIdx)) {
            $httpreq .= "?run={$runIdx}&time={$timeIdx}";
        }
        $yreq = YAPI::devRequest($devid, $httpreq);
        if($yreq->errorType != YAPI_SUCCESS) {
            if(strpos($yreq->errorMsg, 'HTTP status 404') !== false && $this->dataLoggerURL != "/dataLogger.json") {
                $this->dataLoggerURL = "/dataLogger.json";
                return $this->getData($runIdx, $timeIdx, $loadval);
            }
            return $yreq->errorType;
        }
        $loadval = json_decode($yreq->result, true);

        return YAPI_SUCCESS;
    }

    // Internal function to preload the list of all runs, for high-level functions
    //
    public function loadRuns()
    {
        $this->measureNames = Array();
        $this->dataRuns = Array();
        $this->liveRun = $this->get_currentRunIndex();

        // preload stream list
        $streams = Array();
        $res = $this->get_dataStreams($streams);
        if($res != YAPI_SUCCESS) return $res;

        // sort streams into runs
        foreach($streams as $stream) {
            $runIdx = $stream->get_runIndex();
            if(!isset($this->dataRuns[$runIdx])) {
                $this->dataRuns[$runIdx] = new YDataRun($this, $runIdx);
            }
            $this->dataRuns[$runIdx]->addStream($stream);
        }

        // finalize computation of data in each run
        $names = $stream->get_columnNames();
        $this->measureNames = Array();
        foreach($names as $name) {
            if(substr($name, -4, 1) != '_') {
                $this->measureNames[] = $name;
            } else if(substr($name, -4) == '_min') {
                $this->measureNames[] = substr($name, 0, -4);
            }
        }
        foreach($this->dataRuns as $run) {
            $run->finalize();
        }
        return YAPI_SUCCESS;
    }

    /**
     * Clears the data logger memory and discards all recorded data streams.
     * This method also resets the current run index to zero.
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function forgetAllDataStreams()
    {
        return $this->set_clearHistory(Y_CLEARHISTORY_TRUE);
    }

    /**
     * Returns the names of the measures recorded by the data logger.
     * In most case, the measure names match the hardware identifier
     * of the sensor that produced the data.
     * 
     * @return a list of strings (the measure names)
     * 
     * On failure, throws an exception or returns an empty array.
     */
    public function get_measureNames()
    {
        return $this->measureNames;
    }
    public function measureNames()
    {
        return $this->measureNames;
    }

    /**
     * Returns a data run object holding all measured data for a given
     * period during which the module was turned on (a run). This object can then
     * be used to retrieve measures (min, average and max) at a desired data rate.
     * 
     * @param runIdx : the index of the desired run
     * 
     * @return an YDataRun object
     * 
     * On failure, throws an exception or returns null.
     */
    public function get_dataRun($runIdx)
    {
        if(is_null($this->dataRuns) || $runIdx > $this->liveRun) $this->loadRuns();        
        if(!isset($this->dataRuns[$runIdx])) return null;
        return $this->dataRuns[$runIdx];
    }
    public function dataRun($runIdx)
    {
        if(is_null($this->dataRuns) || $runIdx > $this->liveRun) $this->loadRuns();        
        if(!isset($this->dataRuns[$runIdx])) return null;
        return $this->dataRuns[$runIdx];
    }

    /**
     * Builds a list of all data streams hold by the data logger.
     * The caller must pass by reference an empty array to hold YDataStream
     * objects, and the function fills it with objects describing available
     * data sequences.
     * 
     * @param v : an array of YDataStream objects to be filled in
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function get_dataStreams(&$v)
    {
        $v = Array();
        $retcode = $this->getData(null, null, $loadval);
        if($retcode != YAPI_SUCCESS) {
            return $retcode;
        }

        foreach($loadval as $arr) {
            if(sizeof($arr) < 4) {
                return $this->_throw(YAPI_IO_ERROR, "Unexpected JSON reply format", YAPI_IO_ERROR);
            }
            $v[] = new YDataStream($this,$arr[0],$arr[1],$arr[2],$arr[3]);
        }    
        return YAPI_SUCCESS;
    }
    public function getDataStreams(&$v)
    {
        return $this->get_dataStreams($v);
    }

    //--- (generated code: YDataLogger implementation)
    const LOGICALNAME_INVALID = Y_INVALID_STRING;
    const ADVERTISEDVALUE_INVALID = Y_INVALID_STRING;
    const OLDESTRUNINDEX_INVALID = Y_INVALID_UNSIGNED;
    const CURRENTRUNINDEX_INVALID = Y_INVALID_UNSIGNED;
    const SAMPLINGINTERVAL_INVALID = Y_INVALID_UNSIGNED;
    const TIMEUTC_INVALID = Y_INVALID_UNSIGNED;
    const RECORDING_OFF = 0;
    const RECORDING_ON = 1;
    const RECORDING_INVALID = -1;
    const AUTOSTART_OFF = 0;
    const AUTOSTART_ON = 1;
    const AUTOSTART_INVALID = -1;
    const CLEARHISTORY_FALSE = 0;
    const CLEARHISTORY_TRUE = 1;
    const CLEARHISTORY_INVALID = -1;

    /**
     * Returns the logical name of the data logger.
     * 
     * @return a string corresponding to the logical name of the data logger
     * 
     * On failure, throws an exception or returns Y_LOGICALNAME_INVALID.
     */
    public function get_logicalName()
    {   $json_val = $this->_getAttr("logicalName");
        return (is_null($json_val) ? Y_LOGICALNAME_INVALID : $json_val);
    }

    /**
     * Changes the logical name of the data logger. You can use yCheckLogicalName()
     * prior to this call to make sure that your parameter is valid.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     * 
     * @param newval : a string corresponding to the logical name of the data logger
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
     * Returns the current value of the data logger (no more than 6 characters).
     * 
     * @return a string corresponding to the current value of the data logger (no more than 6 characters)
     * 
     * On failure, throws an exception or returns Y_ADVERTISEDVALUE_INVALID.
     */
    public function get_advertisedValue()
    {   $json_val = $this->_getAttr("advertisedValue");
        return (is_null($json_val) ? Y_ADVERTISEDVALUE_INVALID : $json_val);
    }

    /**
     * Returns the index of the oldest run for which the non-volatile memory still holds recorded data.
     * 
     * @return an integer corresponding to the index of the oldest run for which the non-volatile memory
     * still holds recorded data
     * 
     * On failure, throws an exception or returns Y_OLDESTRUNINDEX_INVALID.
     */
    public function get_oldestRunIndex()
    {   $json_val = $this->_getAttr("oldestRunIndex");
        return (is_null($json_val) ? Y_OLDESTRUNINDEX_INVALID : intval($json_val));
    }

    /**
     * Returns the current run number, corresponding to the number of times the module was
     * powered on with the dataLogger enabled at some point.
     * 
     * @return an integer corresponding to the current run number, corresponding to the number of times the module was
     *         powered on with the dataLogger enabled at some point
     * 
     * On failure, throws an exception or returns Y_CURRENTRUNINDEX_INVALID.
     */
    public function get_currentRunIndex()
    {   $json_val = $this->_getAttr("currentRunIndex");
        return (is_null($json_val) ? Y_CURRENTRUNINDEX_INVALID : intval($json_val));
    }

    public function get_samplingInterval()
    {   $json_val = $this->_getAttr("samplingInterval");
        return (is_null($json_val) ? Y_SAMPLINGINTERVAL_INVALID : intval($json_val));
    }

    public function set_samplingInterval($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("samplingInterval",$rest_val);
    }

    /**
     * Returns the Unix timestamp for current UTC time, if known.
     * 
     * @return an integer corresponding to the Unix timestamp for current UTC time, if known
     * 
     * On failure, throws an exception or returns Y_TIMEUTC_INVALID.
     */
    public function get_timeUTC()
    {   $json_val = $this->_getAttr("timeUTC");
        return (is_null($json_val) ? Y_TIMEUTC_INVALID : intval($json_val));
    }

    /**
     * Changes the current UTC time reference used for recorded data.
     * 
     * @param newval : an integer corresponding to the current UTC time reference used for recorded data
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_timeUTC($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("timeUTC",$rest_val);
    }

    /**
     * Returns the current activation state of the data logger.
     * 
     * @return either Y_RECORDING_OFF or Y_RECORDING_ON, according to the current activation state of the data logger
     * 
     * On failure, throws an exception or returns Y_RECORDING_INVALID.
     */
    public function get_recording()
    {   $json_val = $this->_getAttr("recording");
        return (is_null($json_val) ? Y_RECORDING_INVALID : intval($json_val));
    }

    /**
     * Changes the activation state of the data logger to start/stop recording data.
     * 
     * @param newval : either Y_RECORDING_OFF or Y_RECORDING_ON, according to the activation state of the
     * data logger to start/stop recording data
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_recording($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("recording",$rest_val);
    }

    /**
     * Returns the default activation state of the data logger on power up.
     * 
     * @return either Y_AUTOSTART_OFF or Y_AUTOSTART_ON, according to the default activation state of the
     * data logger on power up
     * 
     * On failure, throws an exception or returns Y_AUTOSTART_INVALID.
     */
    public function get_autoStart()
    {   $json_val = $this->_getAttr("autoStart");
        return (is_null($json_val) ? Y_AUTOSTART_INVALID : intval($json_val));
    }

    /**
     * Changes the default activation state of the data logger on power up.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     * 
     * @param newval : either Y_AUTOSTART_OFF or Y_AUTOSTART_ON, according to the default activation state
     * of the data logger on power up
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_autoStart($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("autoStart",$rest_val);
    }

    public function get_clearHistory()
    {   $json_val = $this->_getAttr("clearHistory");
        return (is_null($json_val) ? Y_CLEARHISTORY_INVALID : intval($json_val));
    }

    public function set_clearHistory($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("clearHistory",$rest_val);
    }

    public function logicalName()
    { return get_logicalName(); }

    public function setLogicalName($newval)
    { return set_logicalName($newval); }

    public function advertisedValue()
    { return get_advertisedValue(); }

    public function oldestRunIndex()
    { return get_oldestRunIndex(); }

    public function currentRunIndex()
    { return get_currentRunIndex(); }

    public function samplingInterval()
    { return get_samplingInterval(); }

    public function setSamplingInterval($newval)
    { return set_samplingInterval($newval); }

    public function timeUTC()
    { return get_timeUTC(); }

    public function setTimeUTC($newval)
    { return set_timeUTC($newval); }

    public function recording()
    { return get_recording(); }

    public function setRecording($newval)
    { return set_recording($newval); }

    public function autoStart()
    { return get_autoStart(); }

    public function setAutoStart($newval)
    { return set_autoStart($newval); }

    public function clearHistory()
    { return get_clearHistory(); }

    public function setClearHistory($newval)
    { return set_clearHistory($newval); }

    /**
     * Continues the enumeration of data loggers started using yFirstDataLogger().
     * 
     * @return a pointer to a YDataLogger object, corresponding to
     *         a data logger currently online, or a null pointer
     *         if there are no more data loggers to enumerate.
     */
    public function nextDataLogger()
    {   $next_hwid = YAPI::getNextHardwareId($this->_className, $this->_func);
        if($next_hwid == null) return null;
        return yFindDataLogger($next_hwid);
    }

    /**
     * Retrieves a data logger for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     * 
     * This function does not require that the data logger is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YDataLogger.isOnline() to test if the data logger is
     * indeed online at a given time. In case of ambiguity when looking for
     * a data logger by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     * 
     * @param func : a string that uniquely characterizes the data logger
     * 
     * @return a YDataLogger object allowing you to drive the data logger.
     */
    public static function FindDataLogger($str_func)
    {   $obj_func = YAPI::getFunction('DataLogger', $str_func);
        if($obj_func) return $obj_func;
        return new YDataLogger($str_func);
    }

    /**
     * Starts the enumeration of data loggers currently accessible.
     * Use the method YDataLogger.nextDataLogger() to iterate on
     * next data loggers.
     * 
     * @return a pointer to a YDataLogger object, corresponding to
     *         the first data logger currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstDataLogger()
    {   $next_hwid = YAPI::getFirstHardwareId('DataLogger');
        if($next_hwid == null) return null;
        return self::FindDataLogger($next_hwid);
    }

    //--- (end of generated code: YDataLogger implementation)

    function __construct($str_func)
    {
        //--- (generated code: YDataLogger constructor)
        parent::__construct('DataLogger', $str_func);
        //--- (end of generated code: YDataLogger constructor)
    }
};

//--- (generated code: DataLogger functions)

/**
 * Retrieves a data logger for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 * 
 * This function does not require that the data logger is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YDataLogger.isOnline() to test if the data logger is
 * indeed online at a given time. In case of ambiguity when looking for
 * a data logger by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 * 
 * @param func : a string that uniquely characterizes the data logger
 * 
 * @return a YDataLogger object allowing you to drive the data logger.
 */
function yFindDataLogger($str_func)
{
    return YDataLogger::FindDataLogger($str_func);
}

/**
 * Starts the enumeration of data loggers currently accessible.
 * Use the method YDataLogger.nextDataLogger() to iterate on
 * next data loggers.
 * 
 * @return a pointer to a YDataLogger object, corresponding to
 *         the first data logger currently online, or a null pointer
 *         if there are none.
 */
function yFirstDataLogger()
{
    return YDataLogger::FirstDataLogger();
}

//--- (end of generated code: DataLogger functions)
?>