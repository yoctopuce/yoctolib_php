<?php
/*********************************************************************
 *
 * $Id: yocto_files.php 63695 2024-12-13 11:06:34Z seb $
 *
 * Implements yFindFiles(), the high-level API for Files functions
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


//--- (generated code: YFiles return codes)
//--- (end of generated code: YFiles return codes)
//--- (generated code: YFiles definitions)
if (!defined('Y_FILESCOUNT_INVALID')) {
    define('Y_FILESCOUNT_INVALID', YAPI_INVALID_UINT);
}
if (!defined('Y_FREESPACE_INVALID')) {
    define('Y_FREESPACE_INVALID', YAPI_INVALID_UINT);
}
//--- (end of generated code: YFiles definitions)

//--- (generated code: YFileRecord definitions)
//--- (end of generated code: YFileRecord definitions)

//--- (generated code: YFileRecord declaration)
//vvvv YFileRecord.php

/**
 * YFileRecord Class: Description of a file on the device filesystem, returned by files.get_list
 *
 * YFileRecord objects are used to describe a file that is stored on a Yoctopuce device.
 * These objects are used in particular in conjunction with the YFiles class.
 */
class YFileRecord
{
    //--- (end of generated code: YFileRecord declaration)

    //--- (generated code: YFileRecord attributes)
    protected $_name = "";                           // str
    protected $_size = 0;                            // int
    protected $_crc = 0;                            // int

    //--- (end of generated code: YFileRecord attributes)

    function __construct(string $str_json)
    {
        //--- (generated code: YFileRecord constructor)
        //--- (end of generated code: YFileRecord constructor)

        $loadval = json_decode($str_json, true);
        $this->_name = $loadval['name'];
        $this->_size = $loadval['size'];
        $this->_crc = $loadval['crc'];
    }

    //--- (generated code: YFileRecord implementation)

    /**
     * Returns the name of the file.
     *
     * @return string  a string with the name of the file.
     */
    public function get_name(): string
    {
        return $this->_name;
    }

    /**
     * Returns the size of the file in bytes.
     *
     * @return int  the size of the file.
     */
    public function get_size(): int
    {
        return $this->_size;
    }

    /**
     * Returns the 32-bit CRC of the file content.
     *
     * @return int  the 32-bit CRC of the file content.
     */
    public function get_crc(): int
    {
        return $this->_crc;
    }

    //--- (end of generated code: YFileRecord implementation)

    function contentEquals(string $bin_content): bool
    {
        return ($this->_size == strlen($bin_content) &&
            $this->_crc == crc32($bin_content));
    }
}

//^^^^ YFileRecord.php

//--- (generated code: YFiles declaration)
//vvvv YFiles.php

/**
 * YFiles Class: filesystem control interface, available for instance in the Yocto-Color-V2, the
 * Yocto-SPI, the YoctoHub-Ethernet or the YoctoHub-GSM-4G
 *
 * The YFiles class is used to access the filesystem embedded on
 * some Yoctopuce devices. This filesystem makes it
 * possible for instance to design a custom web UI
 * (for networked devices) or to add fonts (on display devices).
 */
class YFiles extends YFunction
{
    const FILESCOUNT_INVALID = YAPI::INVALID_UINT;
    const FREESPACE_INVALID = YAPI::INVALID_UINT;
    //--- (end of generated code: YFiles declaration)

    //--- (generated code: YFiles attributes)
    protected $_filesCount = self::FILESCOUNT_INVALID;     // UInt31
    protected $_freeSpace = self::FREESPACE_INVALID;      // UInt31

    //--- (end of generated code: YFiles attributes)

    function __construct(string $str_func)
    {
        //--- (generated code: YFiles constructor)
        parent::__construct($str_func);
        $this->_className = 'Files';

        //--- (end of generated code: YFiles constructor)
    }

    //--- (generated code: YFiles implementation)

    function _parseAttr(string $name,  $val): int
    {
        switch ($name) {
        case 'filesCount':
            $this->_filesCount = intval($val);
            return 1;
        case 'freeSpace':
            $this->_freeSpace = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the number of files currently loaded in the filesystem.
     *
     * @return int  an integer corresponding to the number of files currently loaded in the filesystem
     *
     * On failure, throws an exception or returns YFiles::FILESCOUNT_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_filesCount(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::FILESCOUNT_INVALID;
            }
        }
        $res = $this->_filesCount;
        return $res;
    }

    /**
     * Returns the free space for uploading new files to the filesystem, in bytes.
     *
     * @return int  an integer corresponding to the free space for uploading new files to the filesystem, in bytes
     *
     * On failure, throws an exception or returns YFiles::FREESPACE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_freeSpace(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::FREESPACE_INVALID;
            }
        }
        $res = $this->_freeSpace;
        return $res;
    }

    /**
     * Retrieves a filesystem for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the filesystem is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the filesystem is
     * indeed online at a given time. In case of ambiguity when looking for
     * a filesystem by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the filesystem, for instance
     *         YRGBLED2.files.
     *
     * @return YFiles  a YFiles object allowing you to drive the filesystem.
     */
    public static function FindFiles(string $func): YFiles
    {
        // $obj                    is a YFiles;
        $obj = YFunction::_FindFromCache('Files', $func);
        if ($obj == null) {
            $obj = new YFiles($func);
            YFunction::_AddToCache('Files', $func, $obj);
        }
        return $obj;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function sendCommand(string $command): string
    {
        // $url                    is a str;
        $url = sprintf('files.json?a=%s',$command);

        return $this->_download($url);
    }

    /**
     * Reinitialize the filesystem to its clean, unfragmented, empty state.
     * All files previously uploaded are permanently lost.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function format_fs(): int
    {
        // $json                   is a bin;
        // $res                    is a str;
        $json = $this->sendCommand('format');
        $res = $this->_json_get_key($json, 'res');
        if (!($res == 'ok')) return $this->_throw(YAPI::IO_ERROR,'format failed',YAPI::IO_ERROR);
        return YAPI::SUCCESS;
    }

    /**
     * Returns a list of YFileRecord objects that describe files currently loaded
     * in the filesystem.
     *
     * @param string $pattern : an optional filter pattern, using star and question marks
     *         as wild cards. When an empty pattern is provided, all file records
     *         are returned.
     *
     * @return YFileRecord[]  a list of YFileRecord objects, containing the file path
     *         and name, byte size and 32-bit CRC of the file content.
     *
     * On failure, throws an exception or returns an empty list.
     * @throws YAPI_Exception on error
     */
    public function get_list(string $pattern): array
    {
        // $json                   is a bin;
        $filelist = [];         // binArr;
        $res = [];              // YFileRecordArr;
        $json = $this->sendCommand(sprintf('dir&f=%s',$pattern));
        $filelist = $this->_json_get_array($json);
        while (sizeof($res) > 0) {
            array_pop($res);
        };
        foreach ($filelist as $each) {
            $res[] = new YFileRecord(YAPI::Ybin2str($each));
        }
        return $res;
    }

    /**
     * Test if a file exist on the filesystem of the module.
     *
     * @param string $filename : the file name to test.
     *
     * @return boolean  a true if the file exist, false otherwise.
     *
     * On failure, throws an exception.
     * @throws YAPI_Exception on error
     */
    public function fileExist(string $filename): bool
    {
        // $json                   is a bin;
        $filelist = [];         // binArr;
        if (mb_strlen($filename) == 0) {
            return false;
        }
        $json = $this->sendCommand(sprintf('dir&f=%s',$filename));
        $filelist = $this->_json_get_array($json);
        if (sizeof($filelist) > 0) {
            return true;
        }
        return false;
    }

    /**
     * Downloads the requested file and returns a binary buffer with its content.
     *
     * @param string $pathname : path and name of the file to download
     *
     * @return string  a binary buffer with the file content
     *
     * On failure, throws an exception or returns an empty content.
     * @throws YAPI_Exception on error
     */
    public function download(string $pathname): string
    {
        return $this->_download($pathname);
    }

    /**
     * Uploads a file to the filesystem, to the specified full path name.
     * If a file already exists with the same path name, its content is overwritten.
     *
     * @param string $pathname : path and name of the new file to create
     * @param string $content : binary buffer with the content to set
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function upload(string $pathname, string $content): int
    {
        return $this->_upload($pathname, $content);
    }

    /**
     * Deletes a file, given by its full path name, from the filesystem.
     * Because of filesystem fragmentation, deleting a file may not always
     * free up the whole space used by the file. However, rewriting a file
     * with the same path name will always reuse any space not freed previously.
     * If you need to ensure that no space is taken by previously deleted files,
     * you can use format_fs to fully reinitialize the filesystem.
     *
     * @param string $pathname : path and name of the file to remove.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function remove(string $pathname): int
    {
        // $json                   is a bin;
        // $res                    is a str;
        $json = $this->sendCommand(sprintf('del&f=%s',$pathname));
        $res  = $this->_json_get_key($json, 'res');
        if (!($res == 'ok')) return $this->_throw(YAPI::IO_ERROR,'unable to remove file',YAPI::IO_ERROR);
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception
     */
    public function filesCount(): int
{
    return $this->get_filesCount();
}

    /**
     * @throws YAPI_Exception
     */
    public function freeSpace(): int
{
    return $this->get_freeSpace();
}

    /**
     * Continues the enumeration of filesystems started using yFirstFiles().
     * Caution: You can't make any assumption about the returned filesystems order.
     * If you want to find a specific a filesystem, use Files.findFiles()
     * and a hardwareID or a logical name.
     *
     * @return ?YFiles  a pointer to a YFiles object, corresponding to
     *         a filesystem currently online, or a null pointer
     *         if there are no more filesystems to enumerate.
     */
    public function nextFiles(): ?YFiles
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindFiles($next_hwid);
    }

    /**
     * Starts the enumeration of filesystems currently accessible.
     * Use the method YFiles::nextFiles() to iterate on
     * next filesystems.
     *
     * @return ?YFiles  a pointer to a YFiles object, corresponding to
     *         the first filesystem currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstFiles(): ?YFiles
    {
        $next_hwid = YAPI::getFirstHardwareId('Files');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindFiles($next_hwid);
    }

    //--- (end of generated code: YFiles implementation)
}

//^^^^ YFiles.php
//--- (generated code: YFiles functions)

/**
 * Retrieves a filesystem for a given identifier.
 * The identifier can be specified using several formats:
 *
 * - FunctionLogicalName
 * - ModuleSerialNumber.FunctionIdentifier
 * - ModuleSerialNumber.FunctionLogicalName
 * - ModuleLogicalName.FunctionIdentifier
 * - ModuleLogicalName.FunctionLogicalName
 *
 *
 * This function does not require that the filesystem is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method isOnline() to test if the filesystem is
 * indeed online at a given time. In case of ambiguity when looking for
 * a filesystem by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 *
 * If a call to this object's is_online() method returns FALSE although
 * you are certain that the matching device is plugged, make sure that you did
 * call registerHub() at application initialization time.
 *
 * @param string $func : a string that uniquely characterizes the filesystem, for instance
 *         YRGBLED2.files.
 *
 * @return YFiles  a YFiles object allowing you to drive the filesystem.
 */
function yFindFiles(string $func): YFiles
{
    return YFiles::FindFiles($func);
}

/**
 * Starts the enumeration of filesystems currently accessible.
 * Use the method YFiles::nextFiles() to iterate on
 * next filesystems.
 *
 * @return ?YFiles  a pointer to a YFiles object, corresponding to
 *         the first filesystem currently online, or a null pointer
 *         if there are none.
 */
function yFirstFiles(): ?YFiles
{
    return YFiles::FirstFiles();
}

//--- (end of generated code: YFiles functions)
