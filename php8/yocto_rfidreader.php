<?php
/*********************************************************************
 *
 *  $Id: svn_id $
 *
 *  Implements YRfidReader, the high-level API for RfidReader functions
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

//--- (generated code: YRfidTagInfo definitions)
//--- (end of generated code: YRfidTagInfo definitions)
    #--- (generated code: YRfidTagInfo yapiwrapper)

   #--- (end of generated code: YRfidTagInfo yapiwrapper)

//--- (generated code: YRfidTagInfo declaration)
//vvvv YRfidTagInfo.php

/**
 * YRfidTagInfo Class: RFID tag description, used by class YRfidReader
 *
 * YRfidTagInfo objects are used to describe RFID tag attributes,
 * such as the tag type and its storage size. These objects are returned by
 * method get_tagInfo() of class YRfidReader.
 */
class YRfidTagInfo
{
    const IEC_15693                      = 1;
    const IEC_14443                      = 2;
    const IEC_14443_MIFARE_ULTRALIGHT    = 3;
    const IEC_14443_MIFARE_CLASSIC1K     = 4;
    const IEC_14443_MIFARE_CLASSIC4K     = 5;
    const IEC_14443_MIFARE_DESFIRE       = 6;
    const IEC_14443_NTAG_213             = 7;
    const IEC_14443_NTAG_215             = 8;
    const IEC_14443_NTAG_216             = 9;
    const IEC_14443_NTAG_424_DNA         = 10;
    //--- (end of generated code: YRfidTagInfo declaration)

    //--- (generated code: YRfidTagInfo attributes)
    protected string $_tagId = "";                           // str
    protected int $_tagType = 0;                            // int
    protected string $_typeStr = "";                           // str
    protected int $_size = 0;                            // int
    protected int $_usable = 0;                            // int
    protected int $_blksize = 0;                            // int
    protected int $_fblk = 0;                            // int
    protected int $_lblk = 0;                            // int

    //--- (end of generated code: YRfidTagInfo attributes)

    function __construct()
    {
        //--- (generated code: YRfidTagInfo constructor)
        //--- (end of generated code: YRfidTagInfo constructor)
    }

    //--- (generated code: YRfidTagInfo implementation)

    /**
     * Returns the RFID tag identifier.
     *
     * @return string  a string with the RFID tag identifier.
     */
    public function get_tagId(): string
    {
        return $this->_tagId;
    }

    /**
     * Returns the type of the RFID tag, as a numeric constant.
     * (IEC_14443_MIFARE_CLASSIC1K, ...).
     *
     * @return int  an integer corresponding to the RFID tag type
     */
    public function get_tagType(): int
    {
        return $this->_tagType;
    }

    /**
     * Returns the type of the RFID tag, as a string.
     *
     * @return string  a string corresponding to the RFID tag type
     */
    public function get_tagTypeStr(): string
    {
        return $this->_typeStr;
    }

    /**
     * Returns the total memory size of the RFID tag, in bytes.
     *
     * @return int  the total memory size of the RFID tag
     */
    public function get_tagMemorySize(): int
    {
        return $this->_size;
    }

    /**
     * Returns the usable storage size of the RFID tag, in bytes.
     *
     * @return int  the usable storage size of the RFID tag
     */
    public function get_tagUsableSize(): int
    {
        return $this->_usable;
    }

    /**
     * Returns the block size of the RFID tag, in bytes.
     *
     * @return int  the block size of the RFID tag
     */
    public function get_tagBlockSize(): int
    {
        return $this->_blksize;
    }

    /**
     * Returns the index of the block available for data storage on the RFID tag.
     * Some tags have special block used to configure the tag behavior, these
     * blocks must be handled with precaution. However, the  block return by
     * get_tagFirstBlock() can be locked, use get_tagLockState()
     * to find out  which block are locked.
     *
     * @return int  the index of the first usable storage block on the RFID tag
     */
    public function get_tagFirstBlock(): int
    {
        return $this->_fblk;
    }

    /**
     * Returns the index of the last last black available for data storage on the RFID tag,
     * However, this block can be locked, use get_tagLockState() to find out
     * which block are locked.
     *
     * @return int  the index of the last usable storage block on the RFID tag
     */
    public function get_tagLastBlock(): int
    {
        return $this->_lblk;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function imm_init(string $tagId, int $tagType, int $size, int $usable, int $blksize, int $fblk, int $lblk): void
    {
        // $typeStr                is a str;
        $typeStr = 'unknown';
        if ($tagType == self::IEC_15693) {
            $typeStr = 'IEC 15693';
        }
        if ($tagType == self::IEC_14443) {
            $typeStr = 'IEC 14443';
        }
        if ($tagType == self::IEC_14443_MIFARE_ULTRALIGHT) {
            $typeStr = 'MIFARE Ultralight';
        }
        if ($tagType == self::IEC_14443_MIFARE_CLASSIC1K) {
            $typeStr = 'MIFARE Classic 1K';
        }
        if ($tagType == self::IEC_14443_MIFARE_CLASSIC4K) {
            $typeStr = 'MIFARE Classic 4K';
        }
        if ($tagType == self::IEC_14443_MIFARE_DESFIRE) {
            $typeStr = 'MIFARE DESFire';
        }
        if ($tagType == self::IEC_14443_NTAG_213) {
            $typeStr = 'NTAG 213';
        }
        if ($tagType == self::IEC_14443_NTAG_215) {
            $typeStr = 'NTAG 215';
        }
        if ($tagType == self::IEC_14443_NTAG_216) {
            $typeStr = 'NTAG 216';
        }
        if ($tagType == self::IEC_14443_NTAG_424_DNA) {
            $typeStr = 'NTAG 424 DNA';
        }
        $this->_tagId = $tagId;
        $this->_tagType = $tagType;
        $this->_typeStr = $typeStr;
        $this->_size = $size;
        $this->_usable = $usable;
        $this->_blksize = $blksize;
        $this->_fblk = $fblk;
        $this->_lblk = $lblk;
    }

    //--- (end of generated code: YRfidTagInfo implementation)

}
//^^^^ YRfidTagInfo.php

//--- (end of generated code: YRfidTagInfo functions)


//--- (generated code: YRfidStatus definitions)
//--- (end of generated code: YRfidStatus definitions)
    #--- (generated code: YRfidStatus yapiwrapper)

   #--- (end of generated code: YRfidStatus yapiwrapper)

//--- (generated code: YRfidStatus declaration)
//vvvv YRfidStatus.php

/**
 * YRfidStatus Class: Detailled information about the result of RFID tag operations, allowing to find
 * out what happened exactly after a tag operation failure.
 *
 * YRfidStatus objects provide additional information about
 * operations on RFID tags, including the range of blocks affected
 * by read/write operations and possible errors when communicating
 * with RFID tags.
 * This makes it possible, for example, to distinguish communication
 * errors that can be recovered by an additional attempt, from
 * security or other errors on the tag.
 * Combined with the EnableDryRun option in RfidOptions,
 * this structure can be used to predict which blocks will be affected
 * by a write operation.
 */
class YRfidStatus
{
    const SUCCESS                        = 0;
    const COMMAND_NOT_SUPPORTED          = 1;
    const COMMAND_NOT_RECOGNIZED         = 2;
    const COMMAND_OPTION_NOT_RECOGNIZED  = 3;
    const COMMAND_CANNOT_BE_PROCESSED_IN_TIME = 4;
    const UNDOCUMENTED_ERROR             = 15;
    const BLOCK_NOT_AVAILABLE            = 16;
    const BLOCK_ALREADY_LOCKED           = 17;
    const BLOCK_LOCKED                   = 18;
    const BLOCK_NOT_SUCESSFULLY_PROGRAMMED = 19;
    const BLOCK_NOT_SUCESSFULLY_LOCKED   = 20;
    const BLOCK_IS_PROTECTED             = 21;
    const CRYPTOGRAPHIC_ERROR            = 64;
    const READER_BUSY                    = 1000;
    const TAG_NOTFOUND                   = 1001;
    const TAG_LEFT                       = 1002;
    const TAG_JUSTLEFT                   = 1003;
    const TAG_COMMUNICATION_ERROR        = 1004;
    const TAG_NOT_RESPONDING             = 1005;
    const TIMEOUT_ERROR                  = 1006;
    const COLLISION_DETECTED             = 1007;
    const INVALID_CMD_ARGUMENTS          = -66;
    const UNKNOWN_CAPABILITIES           = -67;
    const MEMORY_NOT_SUPPORTED           = -68;
    const INVALID_BLOCK_INDEX            = -69;
    const MEM_SPACE_UNVERRUN_ATTEMPT     = -70;
    const BROWNOUT_DETECTED              = -71     ;
    const BUFFER_OVERFLOW                = -72;
    const CRC_ERROR                      = -73;
    const COMMAND_RECEIVE_TIMEOUT        = -75;
    const DID_NOT_SLEEP                  = -76;
    const ERROR_DECIMAL_EXPECTED         = -77;
    const HARDWARE_FAILURE               = -78;
    const ERROR_HEX_EXPECTED             = -79;
    const FIFO_LENGTH_ERROR              = -80;
    const FRAMING_ERROR                  = -81;
    const NOT_IN_CNR_MODE                = -82;
    const NUMBER_OU_OF_RANGE             = -83;
    const NOT_SUPPORTED                  = -84;
    const NO_RF_FIELD_ACTIVE             = -85;
    const READ_DATA_LENGTH_ERROR         = -86;
    const WATCHDOG_RESET                 = -87;
    const UNKNOW_COMMAND                 = -91;
    const UNKNOW_ERROR                   = -92;
    const UNKNOW_PARAMETER               = -93;
    const UART_RECEIVE_ERROR             = -94;
    const WRONG_DATA_LENGTH              = -95;
    const WRONG_MODE                     = -96;
    const UNKNOWN_DWARFxx_ERROR_CODE     = -97;
    const RESPONSE_SHORT                 = -98;
    const UNEXPECTED_TAG_ID_IN_RESPONSE  = -99;
    const UNEXPECTED_TAG_INDEX           = -100;
    const READ_EOF                       = -101;
    const READ_OK_SOFAR                  = -102;
    const WRITE_DATA_MISSING             = -103;
    const WRITE_TOO_MUCH_DATA            = -104;
    const TRANSFER_CLOSED                = -105;
    const COULD_NOT_BUILD_REQUEST        = -106;
    const INVALID_OPTIONS                = -107;
    const UNEXPECTED_RESPONSE            = -108;
    const AFI_NOT_AVAILABLE              = -109;
    const DSFID_NOT_AVAILABLE            = -110;
    const TAG_RESPONSE_TOO_SHORT         = -111;
    const DEC_EXPECTED                   = -112 ;
    const HEX_EXPECTED                   = -113;
    const NOT_SAME_SECOR                 = -114;
    const MIFARE_AUTHENTICATED           = -115;
    const NO_DATABLOCK                   = -116;
    const KEYB_IS_READABLE               = -117;
    const OPERATION_NOT_EXECUTED         = -118;
    const BLOK_MODE_ERROR                = -119;
    const BLOCK_NOT_WRITABLE             = -120;
    const BLOCK_ACCESS_ERROR             = -121;
    const BLOCK_NOT_AUTHENTICATED        = -122;
    const ACCESS_KEY_BIT_NOT_WRITABLE    = -123;
    const USE_KEYA_FOR_AUTH              = -124;
    const USE_KEYB_FOR_AUTH              = -125;
    const KEY_NOT_CHANGEABLE             = -126;
    const BLOCK_TOO_HIGH                 = -127;
    const AUTH_ERR                       = -128;
    const NOKEY_SELECT                   = -129;
    const CARD_NOT_SELECTED              = -130;
    const BLOCK_TO_READ_NONE             = -131;
    const NO_TAG                         = -132;
    const TOO_MUCH_DATA                  = -133;
    const CON_NOT_SATISFIED              = -134;
    const BLOCK_IS_SPECIAL               = -135;
    const READ_BEYOND_ANNOUNCED_SIZE     = -136;
    const BLOCK_ZERO_IS_RESERVED         = -137;
    const VALUE_BLOCK_BAD_FORMAT         = -138;
    const ISO15693_ONLY_FEATURE          = -139;
    const ISO14443_ONLY_FEATURE          = -140;
    const MIFARE_CLASSIC_ONLY_FEATURE    = -141;
    const BLOCK_MIGHT_BE_PROTECTED       = -142;
    const NO_SUCH_BLOCK                  = -143;
    const COUNT_TOO_BIG                  = -144;
    const UNKNOWN_MEM_SIZE               = -145;
    const MORE_THAN_2BLOCKS_MIGHT_NOT_WORK = -146;
    const READWRITE_NOT_SUPPORTED        = -147;
    const UNEXPECTED_VICC_ID_IN_RESPONSE = -148;
    const LOCKBLOCK_NOT_SUPPORTED        = -150;
    const INTERNAL_ERROR_SHOULD_NEVER_HAPPEN = -151;
    const INVLD_BLOCK_MODE_COMBINATION   = -152;
    const INVLD_ACCESS_MODE_COMBINATION  = -153;
    const INVALID_SIZE                   = -154;
    const BAD_PASSWORD_FORMAT            = -155;
    const RADIO_IS_OFF                   = -156;
    //--- (end of generated code: YRfidStatus declaration)

    //--- (generated code: YRfidStatus attributes)
    protected string $_tagId = "";                           // str
    protected int $_errCode = 0;                            // int
    protected int $_errBlk = 0;                            // int
    protected string $_errMsg = "";                           // str
    protected int $_yapierr = 0;                            // int
    protected int $_fab = 0;                            // int
    protected int $_lab = 0;                            // int

    //--- (end of generated code: YRfidStatus attributes)

    function __construct()
    {
        //--- (generated code: YRfidStatus constructor)
        //--- (end of generated code: YRfidStatus constructor)
    }

    //--- (generated code: YRfidStatus implementation)

    /**
     * Returns RFID tag identifier related to the status.
     *
     * @return string  a string with the RFID tag identifier.
     */
    public function get_tagId(): string
    {
        return $this->_tagId;
    }

    /**
     * Returns the detailled error code, or 0 if no error happened.
     *
     * @return int  a numeric error code
     */
    public function get_errorCode(): int
    {
        return $this->_errCode;
    }

    /**
     * Returns the RFID tag memory block number where the error was encountered, or -1 if the
     * error is not specific to a memory block.
     *
     * @return int  an RFID tag block number
     */
    public function get_errorBlock(): int
    {
        return $this->_errBlk;
    }

    /**
     * Returns a string describing precisely the RFID commande result.
     *
     * @return string  an error message string
     */
    public function get_errorMessage(): string
    {
        return $this->_errMsg;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_yapiError(): int
    {
        return $this->_yapierr;
    }

    /**
     * Returns the block number of the first RFID tag memory block affected
     * by the operation. Depending on the type of operation and on the tag
     * memory granularity, this number may be smaller than the requested
     * memory block index.
     *
     * @return int  an RFID tag block number
     */
    public function get_firstAffectedBlock(): int
    {
        return $this->_fab;
    }

    /**
     * Returns the block number of the last RFID tag memory block affected
     * by the operation. Depending on the type of operation and on the tag
     * memory granularity, this number may be bigger than the requested
     * memory block index.
     *
     * @return int  an RFID tag block number
     */
    public function get_lastAffectedBlock(): int
    {
        return $this->_lab;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function imm_init(string $tagId, int $errCode, int $errBlk, int $fab, int $lab): void
    {
        // $errMsg                 is a str;
        if ($errCode == 0) {
            $this->_yapierr = YAPI::SUCCESS;
            $errMsg = 'Success (no error)';
        } else {
            if ($errCode < 0) {
                if ($errCode > -50) {
                    $this->_yapierr = $errCode;
                    $errMsg = sprintf('YoctoLib error %d', $errCode);
                } else {
                    $this->_yapierr = YAPI::RFID_HARD_ERROR;
                    $errMsg = sprintf('Non-recoverable RFID error %d', $errCode);
                }
            } else {
                if ($errCode > 1000) {
                    $this->_yapierr = YAPI::RFID_SOFT_ERROR;
                    $errMsg = sprintf('Recoverable RFID error %d', $errCode);
                } else {
                    $this->_yapierr = YAPI::RFID_HARD_ERROR;
                    $errMsg = sprintf('Non-recoverable RFID error %d', $errCode);
                }
            }
            if ($errCode == self::TAG_NOTFOUND) {
                $errMsg = 'Tag not found';
            }
            if ($errCode == self::TAG_JUSTLEFT) {
                $errMsg = 'Tag left during operation';
            }
            if ($errCode == self::TAG_LEFT) {
                $errMsg = 'Tag not here anymore';
            }
            if ($errCode == self::READER_BUSY) {
                $errMsg = 'Reader is busy';
            }
            if ($errCode == self::INVALID_CMD_ARGUMENTS) {
                $errMsg = 'Invalid command arguments';
            }
            if ($errCode == self::UNKNOWN_CAPABILITIES) {
                $errMsg = 'Unknown capabilities';
            }
            if ($errCode == self::MEMORY_NOT_SUPPORTED) {
                $errMsg = 'Memory no present';
            }
            if ($errCode == self::INVALID_BLOCK_INDEX) {
                $errMsg = 'Invalid block index';
            }
            if ($errCode == self::MEM_SPACE_UNVERRUN_ATTEMPT) {
                $errMsg = 'Tag memory space overrun attempt';
            }
            if ($errCode == self::COMMAND_NOT_SUPPORTED) {
                $errMsg = 'The command is not supported';
            }
            if ($errCode == self::COMMAND_NOT_RECOGNIZED) {
                $errMsg = 'The command is not recognized';
            }
            if ($errCode == self::COMMAND_OPTION_NOT_RECOGNIZED) {
                $errMsg = 'The command option is not supported.';
            }
            if ($errCode == self::COMMAND_CANNOT_BE_PROCESSED_IN_TIME) {
                $errMsg = 'The command cannot be processed in time';
            }
            if ($errCode == self::UNDOCUMENTED_ERROR) {
                $errMsg = 'Error with no information given';
            }
            if ($errCode == self::BLOCK_NOT_AVAILABLE) {
                $errMsg = 'Block is not available';
            }
            if ($errCode == self::BLOCK_ALREADY_LOCKED) {
                $errMsg = 'Block / byte is already locked and thus cannot be locked again.';
            }
            if ($errCode == self::BLOCK_LOCKED) {
                $errMsg = 'Block / byte is locked and its content cannot be changed';
            }
            if ($errCode == self::BLOCK_NOT_SUCESSFULLY_PROGRAMMED) {
                $errMsg = 'Block was not successfully programmed';
            }
            if ($errCode == self::BLOCK_NOT_SUCESSFULLY_LOCKED) {
                $errMsg = 'Block was not successfully locked';
            }
            if ($errCode == self::BLOCK_IS_PROTECTED) {
                $errMsg = 'Block is protected';
            }
            if ($errCode == self::CRYPTOGRAPHIC_ERROR) {
                $errMsg = 'Generic cryptographic error';
            }
            if ($errCode == self::BROWNOUT_DETECTED) {
                $errMsg = 'BrownOut detected (BOD)';
            }
            if ($errCode == self::BUFFER_OVERFLOW) {
                $errMsg = 'Buffer Overflow (BOF)';
            }
            if ($errCode == self::CRC_ERROR) {
                $errMsg = 'Communication CRC Error (CCE)';
            }
            if ($errCode == self::COLLISION_DETECTED) {
                $errMsg = 'Collision Detected (CLD/CDT)';
            }
            if ($errCode == self::COMMAND_RECEIVE_TIMEOUT) {
                $errMsg = 'Command Receive Timeout (CRT)';
            }
            if ($errCode == self::DID_NOT_SLEEP) {
                $errMsg = 'Did Not Sleep (DNS)';
            }
            if ($errCode == self::ERROR_DECIMAL_EXPECTED) {
                $errMsg = 'Error Decimal Expected (EDX)';
            }
            if ($errCode == self::HARDWARE_FAILURE) {
                $errMsg = 'Error Hardware Failure (EHF)';
            }
            if ($errCode == self::ERROR_HEX_EXPECTED) {
                $errMsg = 'Error Hex Expected (EHX)';
            }
            if ($errCode == self::FIFO_LENGTH_ERROR) {
                $errMsg = 'FIFO length error (FLE)';
            }
            if ($errCode == self::FRAMING_ERROR) {
                $errMsg = 'Framing error (FER)';
            }
            if ($errCode == self::NOT_IN_CNR_MODE) {
                $errMsg = 'Not in CNR Mode (NCM)';
            }
            if ($errCode == self::NUMBER_OU_OF_RANGE) {
                $errMsg = 'Number Out of Range (NOR)';
            }
            if ($errCode == self::NOT_SUPPORTED) {
                $errMsg = 'Not Supported (NOS)';
            }
            if ($errCode == self::NO_RF_FIELD_ACTIVE) {
                $errMsg = 'No RF field active (NRF)';
            }
            if ($errCode == self::READ_DATA_LENGTH_ERROR) {
                $errMsg = 'Read data length error (RDL)';
            }
            if ($errCode == self::WATCHDOG_RESET) {
                $errMsg = 'Watchdog reset (SRT)';
            }
            if ($errCode == self::TAG_COMMUNICATION_ERROR) {
                $errMsg = 'Tag Communication Error (TCE)';
            }
            if ($errCode == self::TAG_NOT_RESPONDING) {
                $errMsg = 'Tag Not Responding (TNR)';
            }
            if ($errCode == self::TIMEOUT_ERROR) {
                $errMsg = 'TimeOut Error (TOE)';
            }
            if ($errCode == self::UNKNOW_COMMAND) {
                $errMsg = 'Unknown Command (UCO)';
            }
            if ($errCode == self::UNKNOW_ERROR) {
                $errMsg = 'Unknown error (UER)';
            }
            if ($errCode == self::UNKNOW_PARAMETER) {
                $errMsg = 'Unknown Parameter (UPA)';
            }
            if ($errCode == self::UART_RECEIVE_ERROR) {
                $errMsg = 'UART Receive Error (URE)';
            }
            if ($errCode == self::WRONG_DATA_LENGTH) {
                $errMsg = 'Wrong Data Length (WDL)';
            }
            if ($errCode == self::WRONG_MODE) {
                $errMsg = 'Wrong Mode (WMO)';
            }
            if ($errCode == self::UNKNOWN_DWARFxx_ERROR_CODE) {
                $errMsg = 'Unknown DWARF15 error code';
            }
            if ($errCode == self::UNEXPECTED_TAG_ID_IN_RESPONSE) {
                $errMsg = 'Unexpected Tag id in response';
            }
            if ($errCode == self::UNEXPECTED_TAG_INDEX) {
                $errMsg = 'internal error : unexpected TAG index';
            }
            if ($errCode == self::TRANSFER_CLOSED) {
                $errMsg = 'transfer closed';
            }
            if ($errCode == self::WRITE_DATA_MISSING) {
                $errMsg = 'Missing write data';
            }
            if ($errCode == self::WRITE_TOO_MUCH_DATA) {
                $errMsg = 'Attempt to write too much data';
            }
            if ($errCode == self::COULD_NOT_BUILD_REQUEST) {
                $errMsg = 'Could not not request';
            }
            if ($errCode == self::INVALID_OPTIONS) {
                $errMsg = 'Invalid transfer options';
            }
            if ($errCode == self::UNEXPECTED_RESPONSE) {
                $errMsg = 'Unexpected Tag response';
            }
            if ($errCode == self::AFI_NOT_AVAILABLE) {
                $errMsg = 'AFI not available';
            }
            if ($errCode == self::DSFID_NOT_AVAILABLE) {
                $errMsg = 'DSFID not available';
            }
            if ($errCode == self::TAG_RESPONSE_TOO_SHORT) {
                $errMsg = 'Tag\'s response too short';
            }
            if ($errCode == self::DEC_EXPECTED) {
                $errMsg = 'Error Decimal value Expected, or is missing';
            }
            if ($errCode == self::HEX_EXPECTED) {
                $errMsg = 'Error Hexadecimal value Expected, or is missing';
            }
            if ($errCode == self::NOT_SAME_SECOR) {
                $errMsg = 'Input and Output block are not in the same Sector';
            }
            if ($errCode == self::MIFARE_AUTHENTICATED) {
                $errMsg = 'No chip with MIFARE Classic technology Authenticated';
            }
            if ($errCode == self::NO_DATABLOCK) {
                $errMsg = 'No Data Block';
            }
            if ($errCode == self::KEYB_IS_READABLE) {
                $errMsg = 'Key B is Readable';
            }
            if ($errCode == self::OPERATION_NOT_EXECUTED) {
                $errMsg = 'Operation Not Executed, would have caused an overflow';
            }
            if ($errCode == self::BLOK_MODE_ERROR) {
                $errMsg = 'Block has not been initialized as a \'value block\'';
            }
            if ($errCode == self::BLOCK_NOT_WRITABLE) {
                $errMsg = 'Block Not Writable';
            }
            if ($errCode == self::BLOCK_ACCESS_ERROR) {
                $errMsg = 'Block Access Error';
            }
            if ($errCode == self::BLOCK_NOT_AUTHENTICATED) {
                $errMsg = 'Block Not Authenticated';
            }
            if ($errCode == self::ACCESS_KEY_BIT_NOT_WRITABLE) {
                $errMsg = 'Access bits or Keys not Writable';
            }
            if ($errCode == self::USE_KEYA_FOR_AUTH) {
                $errMsg = 'Use Key B for authentication';
            }
            if ($errCode == self::USE_KEYB_FOR_AUTH) {
                $errMsg = 'Use Key A for authentication';
            }
            if ($errCode == self::KEY_NOT_CHANGEABLE) {
                $errMsg = 'Key(s) not changeable';
            }
            if ($errCode == self::BLOCK_TOO_HIGH) {
                $errMsg = 'Block index is too high';
            }
            if ($errCode == self::AUTH_ERR) {
                $errMsg = 'Authentication Error (i.e. wrong key)';
            }
            if ($errCode == self::NOKEY_SELECT) {
                $errMsg = 'No Key Select, select a temporary or a static key';
            }
            if ($errCode == self::CARD_NOT_SELECTED) {
                $errMsg = ' Card is Not Selected';
            }
            if ($errCode == self::BLOCK_TO_READ_NONE) {
                $errMsg = 'Number of Blocks to Read is 0';
            }
            if ($errCode == self::NO_TAG) {
                $errMsg = 'No Tag detected';
            }
            if ($errCode == self::TOO_MUCH_DATA) {
                $errMsg = 'Too Much Data (i.e. Uart input buffer overflow)';
            }
            if ($errCode == self::CON_NOT_SATISFIED) {
                $errMsg = 'Conditions Not Satisfied';
            }
            if ($errCode == self::BLOCK_IS_SPECIAL) {
                $errMsg = 'Bad parameter: block is a special block';
            }
            if ($errCode == self::READ_BEYOND_ANNOUNCED_SIZE) {
                $errMsg = 'Attempt to read more than announced size.';
            }
            if ($errCode == self::BLOCK_ZERO_IS_RESERVED) {
                $errMsg = 'Block 0 is reserved and cannot be used';
            }
            if ($errCode == self::VALUE_BLOCK_BAD_FORMAT) {
                $errMsg = 'One value block is not properly initialized';
            }
            if ($errCode == self::ISO15693_ONLY_FEATURE) {
                $errMsg = 'Feature available on ISO 15693 only';
            }
            if ($errCode == self::ISO14443_ONLY_FEATURE) {
                $errMsg = 'Feature available on ISO 14443 only';
            }
            if ($errCode == self::MIFARE_CLASSIC_ONLY_FEATURE) {
                $errMsg = 'Feature available on ISO 14443 MIFARE Classic only';
            }
            if ($errCode == self::BLOCK_MIGHT_BE_PROTECTED) {
                $errMsg = 'Block might be protected';
            }
            if ($errCode == self::NO_SUCH_BLOCK) {
                $errMsg = 'No such block';
            }
            if ($errCode == self::COUNT_TOO_BIG) {
                $errMsg = 'Count parameter is too large';
            }
            if ($errCode == self::UNKNOWN_MEM_SIZE) {
                $errMsg = 'Tag memory size is unknown';
            }
            if ($errCode == self::MORE_THAN_2BLOCKS_MIGHT_NOT_WORK) {
                $errMsg = 'Writing more than two blocks at once might not be supported by $this tag';
            }
            if ($errCode == self::READWRITE_NOT_SUPPORTED) {
                $errMsg = 'Read/write operation not supported for $this tag';
            }
            if ($errCode == self::UNEXPECTED_VICC_ID_IN_RESPONSE) {
                $errMsg = 'Unexpected VICC ID in response';
            }
            if ($errCode == self::LOCKBLOCK_NOT_SUPPORTED) {
                $errMsg = 'This tag does not support the Lock block function';
            }
            if ($errCode == self::INTERNAL_ERROR_SHOULD_NEVER_HAPPEN) {
                $errMsg = 'Yoctopuce RFID code ran into an unexpected state, please contact support';
            }
            if ($errCode == self::INVLD_BLOCK_MODE_COMBINATION) {
                $errMsg = 'Invalid combination of block mode options';
            }
            if ($errCode == self::INVLD_ACCESS_MODE_COMBINATION) {
                $errMsg = 'Invalid combination of access mode options';
            }
            if ($errCode == self::INVALID_SIZE) {
                $errMsg = 'Invalid data size parameter';
            }
            if ($errCode == self::BAD_PASSWORD_FORMAT) {
                $errMsg = 'Bad password format or type';
            }
            if ($errCode == self::RADIO_IS_OFF) {
                $errMsg = 'Radio is OFF (refreshRate=0).';
            }
            if ($errBlk >= 0) {
                $errMsg = sprintf('%s (block %d)', $errMsg, $errBlk);
            }
        }
        $this->_tagId = $tagId;
        $this->_errCode = $errCode;
        $this->_errBlk = $errBlk;
        $this->_errMsg = $errMsg;
        $this->_fab = $fab;
        $this->_lab = $lab;
    }

    //--- (end of generated code: YRfidStatus implementation)

}
//^^^^ YRfidStatus.php

//--- (end of generated code: YRfidStatus functions)


//--- (generated code: YRfidOptions definitions)
//--- (end of generated code: YRfidOptions definitions)
    #--- (generated code: YRfidOptions yapiwrapper)

   #--- (end of generated code: YRfidOptions yapiwrapper)

//--- (generated code: YRfidOptions declaration)
//vvvv YRfidOptions.php

/**
 * YRfidOptions Class: Additional parameters for operations on RFID tags.
 *
 * The YRfidOptions objects are used to specify additional
 * optional parameters to RFID commands that interact with tags,
 * including security keys. When instantiated,the parameters of
 * this object are pre-initialized to a value  which corresponds
 * to the most common usage.
 */
class YRfidOptions
{
    const NO_RFID_KEY                    = 0;
    const MIFARE_KEY_A                   = 1;
    const MIFARE_KEY_B                   = 2;
    //--- (end of generated code: YRfidOptions declaration)

    //--- (generated code: YRfidOptions attributes)

    /**
     * Type of security key to be used to access the RFID tag.
     * For MIFARE Classic tags, allowed values are
     * Y_MIFARE_KEY_A or Y_MIFARE_KEY_B.
     * The default value is Y_NO_RFID_KEY, in that case
     * the reader will use the most common default key for the
     * tag type.
     * When a security key is required, it must be provided
     * using property HexKey.
     */
    public int $KeyType = 0;

    /**
     * Security key to be used to access the RFID tag, as an
     * hexadecimal string. The key will only be used if you
     * also specify which type of key it is, using property
     * KeyType.
     */
    public string $HexKey = "";

    /**
     * Forces the use of single-block commands to access RFID tag memory blocks.
     * By default, the Yoctopuce library uses the most efficient access strategy
     * generally available for each tag type, but you can force the use of
     * single-block commands if the RFID tags you are using do not support
     * multi-block commands. If opération speed is not a priority, choose
     * single-block mode as it will work with any mode.
     */
    public bool $ForceSingleBlockAccess = false;

    /**
     * Forces the use of multi-block commands to access RFID tag memory blocks.
     * By default, the Yoctopuce library uses the most efficient access strategy
     * generally available for each tag type, but you can force the use of
     * multi-block commands if you know for sure that the RFID tags you are using
     * do support multi-block commands. Be  aware that even if a tag allows multi-block
     * operations, the maximum number of blocks that can be written or read at the same
     * time can be (very) limited. If the tag does not support multi-block mode
     * for the wanted opération, the option will be ignored.
     */
    public bool $ForceMultiBlockAccess = false;

    /**
     * Enables direct access to RFID tag control blocks.
     * By default, Yoctopuce library read and write functions only work
     * on data blocks and automatically skip special blocks, as specific functions are provided
     * to configure security parameters found in control blocks.
     * If you need to access control blocks in your own way using
     * read/write functions, enable this option.  Use this option wisely,
     * as overwriting a special block migth very well irreversibly alter your
     * tag behavior.
     */
    public bool $EnableRawAccess = false;

    /**
     * Disables the tag memory overflow test. By default, the Yoctopuce
     * library's read/write functions detect overruns and do not run
     * commands that are likely to fail. If you nevertheless wish to
     * try to access more memory than the tag announces, you can try to use
     * this option.
     */
    public bool $DisableBoundaryChecks = false;

    /**
     * Enables simulation mode to check the affected block range as well
     * as access rights. When this option is active, the operation is
     * not fully applied to the RFID tag but the affected block range
     * is determined and the optional access key is tested on these blocks.
     * The access key rights are not tested though. This option applies to
     * write / configure operations only, it is ignored for read operations.
     */
    public bool $EnableDryRun = false;

    //--- (end of generated code: YRfidOptions attributes)

    function __construct()
    {
        //--- (generated code: YRfidOptions constructor)
        //--- (end of generated code: YRfidOptions constructor)
    }

    //--- (generated code: YRfidOptions implementation)

    /**
     * @throws YAPI_Exception on error
     */
    public function imm_getParams(): string
    {
        // $opt                    is a int;
        // $res                    is a str;
        if ($this->ForceSingleBlockAccess) {
            $opt = 1;
        } else {
            $opt = 0;
        }
        if ($this->ForceMultiBlockAccess) {
            $opt = (($opt) | (2));
        }
        if ($this->EnableRawAccess) {
            $opt = (($opt) | (4));
        }
        if ($this->DisableBoundaryChecks) {
            $opt = (($opt) | (8));
        }
        if ($this->EnableDryRun) {
            $opt = (($opt) | (16));
        }
        $res = sprintf('&o=%d', $opt);
        if ($this->KeyType != 0) {
            $res = sprintf('%s&k=%02x:%s', $res, $this->KeyType, $this->HexKey);
        }
        return $res;
    }

    //--- (end of generated code: YRfidOptions implementation)

}
//^^^^ YRfidOptions.php

//--- (end of generated code: YRfidOptions functions)


//--- (generated code: YRfidReader return codes)
//--- (end of generated code: YRfidReader return codes)
//--- (generated code: YRfidReader definitions)
if (!defined('Y_NTAGS_INVALID')) {
    define('Y_NTAGS_INVALID', YAPI_INVALID_UINT);
}
if (!defined('Y_REFRESHRATE_INVALID')) {
    define('Y_REFRESHRATE_INVALID', YAPI_INVALID_UINT);
}
//--- (end of generated code: YRfidReader definitions)
    #--- (generated code: YRfidReader yapiwrapper)

   #--- (end of generated code: YRfidReader yapiwrapper)

function yInternalEventCallback($obj, $value)
{
    $obj->_internalEventHandler($value);
}

//--- (generated code: YRfidReader declaration)
//vvvv YRfidReader.php

/**
 * YRfidReader Class: RfidReader function interface
 *
 * The YRfidReader class allows you to detect RFID tags, as well as
 * read and write on these tags if the security settings allow it.
 *
 * Short reminder:
 *
 * - A tag's memory is generally organized in fixed-size blocks.
 * - At tag level, each block must be read and written in its entirety.
 * - Some blocks are special configuration blocks, and may alter the tag's behavior
 * if they are rewritten with arbitrary data.
 * - Data blocks can be set to read-only mode, but on many tags, this operation is irreversible.
 *
 *
 * By default, the RfidReader class automatically manages these blocks so that
 * arbitrary size data  can be manipulated of  without risk and without knowledge of
 * tag architecture.
 */
class YRfidReader extends YFunction
{
    const NTAGS_INVALID = YAPI::INVALID_UINT;
    const REFRESHRATE_INVALID = YAPI::INVALID_UINT;
    //--- (end of generated code: YRfidReader declaration)

    //--- (generated code: YRfidReader attributes)
    protected int $_nTags = self::NTAGS_INVALID;          // UInt31
    protected int $_refreshRate = self::REFRESHRATE_INVALID;    // UInt31
    protected mixed $_eventCallback = null;                         // YEventCallback
    protected bool $_isFirstCb = false;                        // bool
    protected int $_prevCbPos = 0;                            // int
    protected int $_eventPos = 0;                            // int
    protected int $_eventStamp = 0;                            // int

    //--- (end of generated code: YRfidReader attributes)

    function __construct(string $str_func)
    {
        //--- (generated code: YRfidReader constructor)
        parent::__construct($str_func);
        $this->_className = 'RfidReader';

        //--- (end of generated code: YRfidReader constructor)
    }

    //--- (generated code: YRfidReader implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'nTags':
            $this->_nTags = intval($val);
            return 1;
        case 'refreshRate':
            $this->_refreshRate = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the number of RFID tags currently detected.
     *
     * @return int  an integer corresponding to the number of RFID tags currently detected
     *
     * On failure, throws an exception or returns YRfidReader::NTAGS_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_nTags(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::NTAGS_INVALID;
            }
        }
        $res = $this->_nTags;
        return $res;
    }

    /**
     * Returns the tag list refresh rate, measured in Hz.
     *
     * @return int  an integer corresponding to the tag list refresh rate, measured in Hz
     *
     * On failure, throws an exception or returns YRfidReader::REFRESHRATE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_refreshRate(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::REFRESHRATE_INVALID;
            }
        }
        $res = $this->_refreshRate;
        return $res;
    }

    /**
     * Changes the present tag list refresh rate, measured in Hz. The reader will do
     * its best to respect it. Note that the reader cannot detect tag arrival or removal
     * while it is  communicating with a tag.  Maximum frequency is limited to 100Hz,
     * but in real life it will be difficult to do better than 50Hz.  A zero value
     * will power off the device radio.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param int $newval : an integer corresponding to the present tag list refresh rate, measured in Hz
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_refreshRate(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("refreshRate", $rest_val);
    }

    /**
     * Retrieves a RFID reader for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the RFID reader is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the RFID reader is
     * indeed online at a given time. In case of ambiguity when looking for
     * a RFID reader by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the RFID reader, for instance
     *         MyDevice.rfidReader.
     *
     * @return YRfidReader  a YRfidReader object allowing you to drive the RFID reader.
     */
    public static function FindRfidReader(string $func): YRfidReader
    {
        // $obj                    is a YRfidReader;
        $obj = YFunction::_FindFromCache('RfidReader', $func);
        if ($obj == null) {
            $obj = new YRfidReader($func);
            YFunction::_AddToCache('RfidReader', $func, $obj);
        }
        return $obj;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function _chkerror(string $tagId, string $json, YRfidStatus &$status): int
    {
        // $jsonStr                is a str;
        // $errCode                is a int;
        // $errBlk                 is a int;
        // $fab                    is a int;
        // $lab                    is a int;
        // $retcode                is a int;

        if (strlen($json) == 0) {
            $errCode = $this->get_errorType();
            $errBlk = -1;
            $fab = -1;
            $lab = -1;
        } else {
            $jsonStr = $json;
            $errCode = intVal($this->_json_get_key($json, 'err'));
            $errBlk = intVal($this->_json_get_key($json, 'errBlk'))-1;
            if (YAPI::Ystrpos($jsonStr,'"fab":') >= 0) {
                $fab = intVal($this->_json_get_key($json, 'fab'))-1;
                $lab = intVal($this->_json_get_key($json, 'lab'))-1;
            } else {
                $fab = -1;
                $lab = -1;
            }
        }
        $status->imm_init($tagId, $errCode, $errBlk, $fab, $lab);
        $retcode = $status->get_yapiError();
        if (!($retcode == YAPI::SUCCESS)) return $this->_throw( $retcode, $status->get_errorMessage(),$retcode);
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function reset(): int
    {
        // $json                   is a bin;
        // $status                 is a YRfidStatus;
        $status = new YRfidStatus();

        $json = $this->_download('rfid.json?a=reset');
        return $this->_chkerror('', $json, $status);
    }

    /**
     * Returns the list of RFID tags currently detected by the reader.
     *
     * @return string[]  a list of strings, corresponding to each tag identifier (UID).
     *
     * On failure, throws an exception or returns an empty list.
     * @throws YAPI_Exception on error
     */
    public function get_tagIdList(): array
    {
        // $json                   is a bin;
        $jsonList = [];         // strArr;
        $taglist = [];          // strArr;

        $json = $this->_download('rfid.json?a=list');
        while (sizeof($taglist) > 0) {
            array_pop($taglist);
        };
        if (strlen($json) > 3) {
            $jsonList = $this->_json_get_array($json);
            foreach ($jsonList as $each) {
                $taglist[] = $this->_json_get_string($each);
            }
        }
        return $taglist;
    }

    /**
     * Returns a description of the properties of an existing RFID tag.
     * This function can cause communications with the tag.
     *
     * @param string $tagId : identifier of the tag to check
     * @param YRfidStatus $status : an RfidStatus object that will contain
     *         the detailled status of the operation
     *
     * @return ?YRfidTagInfo  a YRfidTagInfo object.
     *
     * On failure, throws an exception or returns an empty YRfidTagInfo objact.
     * When it happens, you can get more information from the status object.
     * @throws YAPI_Exception on error
     */
    public function get_tagInfo(string $tagId, YRfidStatus &$status): ?YRfidTagInfo
    {
        // $url                    is a str;
        // $json                   is a bin;
        // $tagType                is a int;
        // $size                   is a int;
        // $usable                 is a int;
        // $blksize                is a int;
        // $fblk                   is a int;
        // $lblk                   is a int;
        // $res                    is a YRfidTagInfo;
        $url = sprintf('rfid.json?a=info&t=%s',$tagId);

        $json = $this->_download($url);
        $this->_chkerror($tagId, $json, $status);
        $tagType = intVal($this->_json_get_key($json, 'type'));
        $size = intVal($this->_json_get_key($json, 'size'));
        $usable = intVal($this->_json_get_key($json, 'usable'));
        $blksize = intVal($this->_json_get_key($json, 'blksize'));
        $fblk = intVal($this->_json_get_key($json, 'fblk'));
        $lblk = intVal($this->_json_get_key($json, 'lblk'));
        $res = new YRfidTagInfo();
        $res->imm_init($tagId, $tagType, $size, $usable, $blksize, $fblk, $lblk);
        return $res;
    }

    /**
     * Changes an RFID tag configuration to prevents any further write to
     * the selected blocks. This operation is definitive and irreversible.
     * Depending on the tag type and block index, adjascent blocks may become
     * read-only as well, based on the locking granularity.
     *
     * @param string $tagId : identifier of the tag to use
     * @param int $firstBlock : first block to lock
     * @param int $nBlocks : number of blocks to lock
     * @param YRfidOptions $options : an YRfidOptions object with the optional
     *         command execution parameters, such as security key
     *         if required
     * @param YRfidStatus $status : an RfidStatus object that will contain
     *         the detailled status of the operation
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code. When it
     * happens, you can get more information from the status object.
     * @throws YAPI_Exception on error
     */
    public function tagLockBlocks(string $tagId, int $firstBlock, int $nBlocks, YRfidOptions $options, YRfidStatus &$status): int
    {
        // $optstr                 is a str;
        // $url                    is a str;
        // $json                   is a bin;
        $optstr = $options->imm_getParams();
        $url = sprintf('rfid.json?a=lock&t=%s&b=%d&n=%d%s',$tagId,$firstBlock,$nBlocks,$optstr);

        $json = $this->_download($url);
        return $this->_chkerror($tagId, $json, $status);
    }

    /**
     * Reads the locked state for RFID tag memory data blocks.
     * FirstBlock cannot be a special block, and any special
     * block encountered in the middle of the read operation will be
     * skipped automatically.
     *
     * @param string $tagId : identifier of the tag to use
     * @param int $firstBlock : number of the first block to check
     * @param int $nBlocks : number of blocks to check
     * @param YRfidOptions $options : an YRfidOptions object with the optional
     *         command execution parameters, such as security key
     *         if required
     * @param YRfidStatus $status : an RfidStatus object that will contain
     *         the detailled status of the operation
     *
     * @return Boolean[]  a list of booleans with the lock state of selected blocks
     *
     * On failure, throws an exception or returns an empty list. When it
     * happens, you can get more information from the status object.
     * @throws YAPI_Exception on error
     */
    public function get_tagLockState(string $tagId, int $firstBlock, int $nBlocks, YRfidOptions $options, YRfidStatus &$status): array
    {
        // $optstr                 is a str;
        // $url                    is a str;
        // $json                   is a bin;
        // $binRes                 is a bin;
        $res = [];              // boolArr;
        // $idx                    is a int;
        // $val                    is a int;
        // $isLocked               is a bool;
        $optstr = $options->imm_getParams();
        $url = sprintf('rfid.json?a=chkl&t=%s&b=%d&n=%d%s',$tagId,$firstBlock,$nBlocks,$optstr);

        $json = $this->_download($url);
        $this->_chkerror($tagId, $json, $status);
        if ($status->get_yapiError() != YAPI::SUCCESS) {
            return $res;
        }
        $binRes = YAPI::_hexStrToBin($this->_json_get_key($json, 'bitmap'));
        $idx = 0;
        while ($idx < $nBlocks) {
            $val = ord($binRes[(($idx) >> (3))]);
            $isLocked = ((($val) & (((1) << ((($idx) & (7)))))) != 0);
            $res[] = $isLocked;
            $idx = $idx + 1;
        }
        return $res;
    }

    /**
     * Tells which block of a RFID tag memory are special and cannot be used
     * to store user data. Mistakely writing a special block can lead to
     * an irreversible alteration of the tag.
     *
     * @param string $tagId : identifier of the tag to use
     * @param int $firstBlock : number of the first block to check
     * @param int $nBlocks : number of blocks to check
     * @param YRfidOptions $options : an YRfidOptions object with the optional
     *         command execution parameters, such as security key
     *         if required
     * @param YRfidStatus $status : an RfidStatus object that will contain
     *         the detailled status of the operation
     *
     * @return Boolean[]  a list of booleans with the lock state of selected blocks
     *
     * On failure, throws an exception or returns an empty list. When it
     * happens, you can get more information from the status object.
     * @throws YAPI_Exception on error
     */
    public function get_tagSpecialBlocks(string $tagId, int $firstBlock, int $nBlocks, YRfidOptions $options, YRfidStatus &$status): array
    {
        // $optstr                 is a str;
        // $url                    is a str;
        // $json                   is a bin;
        // $binRes                 is a bin;
        $res = [];              // boolArr;
        // $idx                    is a int;
        // $val                    is a int;
        // $isLocked               is a bool;
        $optstr = $options->imm_getParams();
        $url = sprintf('rfid.json?a=chks&t=%s&b=%d&n=%d%s',$tagId,$firstBlock,$nBlocks,$optstr);

        $json = $this->_download($url);
        $this->_chkerror($tagId, $json, $status);
        if ($status->get_yapiError() != YAPI::SUCCESS) {
            return $res;
        }
        $binRes = YAPI::_hexStrToBin($this->_json_get_key($json, 'bitmap'));
        $idx = 0;
        while ($idx < $nBlocks) {
            $val = ord($binRes[(($idx) >> (3))]);
            $isLocked = ((($val) & (((1) << ((($idx) & (7)))))) != 0);
            $res[] = $isLocked;
            $idx = $idx + 1;
        }
        return $res;
    }

    /**
     * Reads data from an RFID tag memory, as an hexadecimal string.
     * The read operation may span accross multiple blocks if the requested
     * number of bytes is larger than the RFID tag block size. By default
     * firstBlock cannot be a special block, and any special block encountered
     * in the middle of the read operation will be skipped automatically.
     * If you rather want to read special blocks, use the EnableRawAccess
     * field from the options parameter.
     *
     * @param string $tagId : identifier of the tag to use
     * @param int $firstBlock : block number where read should start
     * @param int $nBytes : total number of bytes to read
     * @param YRfidOptions $options : an YRfidOptions object with the optional
     *         command execution parameters, such as security key
     *         if required
     * @param YRfidStatus $status : an RfidStatus object that will contain
     *         the detailled status of the operation
     *
     * @return string  an hexadecimal string if the call succeeds.
     *
     * On failure, throws an exception or returns an empty binary buffer. When it
     * happens, you can get more information from the status object.
     * @throws YAPI_Exception on error
     */
    public function tagReadHex(string $tagId, int $firstBlock, int $nBytes, YRfidOptions $options, YRfidStatus &$status): string
    {
        // $optstr                 is a str;
        // $url                    is a str;
        // $json                   is a bin;
        // $hexbuf                 is a str;
        $optstr = $options->imm_getParams();
        $url = sprintf('rfid.json?a=read&t=%s&b=%d&n=%d%s',$tagId,$firstBlock,$nBytes,$optstr);

        $json = $this->_download($url);
        $this->_chkerror($tagId, $json, $status);
        if ($status->get_yapiError() == YAPI::SUCCESS) {
            $hexbuf = $this->_json_get_key($json, 'res');
        } else {
            $hexbuf = '';
        }
        return $hexbuf;
    }

    /**
     * Reads data from an RFID tag memory, as a binary buffer. The read operation
     * may span accross multiple blocks if the requested number of bytes
     * is larger than the RFID tag block size.  By default
     * firstBlock cannot be a special block, and any special block encountered
     * in the middle of the read operation will be skipped automatically.
     * If you rather want to read special blocks, use the EnableRawAccess
     * field frrm the options parameter.
     *
     * @param string $tagId : identifier of the tag to use
     * @param int $firstBlock : block number where read should start
     * @param int $nBytes : total number of bytes to read
     * @param YRfidOptions $options : an YRfidOptions object with the optional
     *         command execution parameters, such as security key
     *         if required
     * @param YRfidStatus $status : an RfidStatus object that will contain
     *         the detailled status of the operation
     *
     * @return string  a binary object with the data read if the call succeeds.
     *
     * On failure, throws an exception or returns an empty binary buffer. When it
     * happens, you can get more information from the status object.
     * @throws YAPI_Exception on error
     */
    public function tagReadBin(string $tagId, int $firstBlock, int $nBytes, YRfidOptions $options, YRfidStatus &$status): string
    {
        return YAPI::_hexStrToBin($this->tagReadHex($tagId, $firstBlock, $nBytes, $options, $status));
    }

    /**
     * Reads data from an RFID tag memory, as a byte list. The read operation
     * may span accross multiple blocks if the requested number of bytes
     * is larger than the RFID tag block size.  By default
     * firstBlock cannot be a special block, and any special block encountered
     * in the middle of the read operation will be skipped automatically.
     * If you rather want to read special blocks, use the EnableRawAccess
     * field from the options parameter.
     *
     * @param string $tagId : identifier of the tag to use
     * @param int $firstBlock : block number where read should start
     * @param int $nBytes : total number of bytes to read
     * @param YRfidOptions $options : an YRfidOptions object with the optional
     *         command execution parameters, such as security key
     *         if required
     * @param YRfidStatus $status : an RfidStatus object that will contain
     *         the detailled status of the operation
     *
     * @return Integer[]  a byte list with the data read if the call succeeds.
     *
     * On failure, throws an exception or returns an empty list. When it
     * happens, you can get more information from the status object.
     * @throws YAPI_Exception on error
     */
    public function tagReadArray(string $tagId, int $firstBlock, int $nBytes, YRfidOptions $options, YRfidStatus &$status): array
    {
        // $blk                    is a bin;
        // $idx                    is a int;
        // $endidx                 is a int;
        $res = [];              // intArr;
        $blk = $this->tagReadBin($tagId, $firstBlock, $nBytes, $options, $status);
        $endidx = strlen($blk);
        $idx = 0;
        while ($idx < $endidx) {
            $res[] = ord($blk[$idx]);
            $idx = $idx + 1;
        }
        return $res;
    }

    /**
     * Reads data from an RFID tag memory, as a text string. The read operation
     * may span accross multiple blocks if the requested number of bytes
     * is larger than the RFID tag block size.  By default
     * firstBlock cannot be a special block, and any special block encountered
     * in the middle of the read operation will be skipped automatically.
     * If you rather want to read special blocks, use the EnableRawAccess
     * field from the options parameter.
     *
     * @param string $tagId : identifier of the tag to use
     * @param int $firstBlock : block number where read should start
     * @param int $nChars : total number of characters to read
     * @param YRfidOptions $options : an YRfidOptions object with the optional
     *         command execution parameters, such as security key
     *         if required
     * @param YRfidStatus $status : an RfidStatus object that will contain
     *         the detailled status of the operation
     *
     * @return string  a text string with the data read if the call succeeds.
     *
     * On failure, throws an exception or returns an empty string. When it
     * happens, you can get more information from the status object.
     * @throws YAPI_Exception on error
     */
    public function tagReadStr(string $tagId, int $firstBlock, int $nChars, YRfidOptions $options, YRfidStatus &$status): string
    {
        return $this->tagReadBin($tagId, $firstBlock, $nChars, $options, $status);
    }

    /**
     * Writes data provided as a binary buffer to an RFID tag memory.
     * The write operation may span accross multiple blocks if the
     * number of bytes to write is larger than the RFID tag block size.
     * By default firstBlock cannot be a special block, and any special block
     * encountered in the middle of the write operation will be skipped
     * automatically. The last data block affected by the operation will
     * be automatically padded with zeros if neccessary.  If you rather want
     * to rewrite special blocks as well,
     * use the EnableRawAccess field from the options parameter.
     *
     * @param string $tagId : identifier of the tag to use
     * @param int $firstBlock : block number where write should start
     * @param string $buff : the binary buffer to write
     * @param YRfidOptions $options : an YRfidOptions object with the optional
     *         command execution parameters, such as security key
     *         if required
     * @param YRfidStatus $status : an RfidStatus object that will contain
     *         the detailled status of the operation
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code. When it
     * happens, you can get more information from the status object.
     * @throws YAPI_Exception on error
     */
    public function tagWriteBin(string $tagId, int $firstBlock, string $buff, YRfidOptions $options, YRfidStatus &$status): int
    {
        // $optstr                 is a str;
        // $hexstr                 is a str;
        // $buflen                 is a int;
        // $fname                  is a str;
        // $json                   is a bin;
        $buflen = strlen($buff);
        if ($buflen <= 16) {
            // short data, use an URL-based command
            $hexstr = YAPI::_bytesToHexStr($buff);
            return $this->tagWriteHex($tagId, $firstBlock, $hexstr, $options, $status);
        } else {
            // long data, use an upload command
            $optstr = $options->imm_getParams();
            $fname = sprintf('Rfid:t=%s&b=%d&n=%d%s',$tagId,$firstBlock,$buflen,$optstr);
            $json = $this->_uploadEx($fname, $buff);
            return $this->_chkerror($tagId, $json, $status);
        }
    }

    /**
     * Writes data provided as a list of bytes to an RFID tag memory.
     * The write operation may span accross multiple blocks if the
     * number of bytes to write is larger than the RFID tag block size.
     * By default firstBlock cannot be a special block, and any special block
     * encountered in the middle of the write operation will be skipped
     * automatically. The last data block affected by the operation will
     * be automatically padded with zeros if neccessary.
     * If you rather want to rewrite special blocks as well,
     * use the EnableRawAccess field from the options parameter.
     *
     * @param string $tagId : identifier of the tag to use
     * @param int $firstBlock : block number where write should start
     * @param Integer[] $byteList : a list of byte to write
     * @param YRfidOptions $options : an YRfidOptions object with the optional
     *         command execution parameters, such as security key
     *         if required
     * @param YRfidStatus $status : an RfidStatus object that will contain
     *         the detailled status of the operation
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code. When it
     * happens, you can get more information from the status object.
     * @throws YAPI_Exception on error
     */
    public function tagWriteArray(string $tagId, int $firstBlock, array $byteList, YRfidOptions $options, YRfidStatus &$status): int
    {
        // $bufflen                is a int;
        // $buff                   is a bin;
        // $idx                    is a int;
        // $hexb                   is a int;
        $bufflen = sizeof($byteList);
        $buff = ($bufflen > 0 ? pack('C',array_fill(0, $bufflen, 0)) : '');
        $idx = 0;
        while ($idx < $bufflen) {
            $hexb = $byteList[$idx];
            $buff[$idx] = pack('C', $hexb);
            $idx = $idx + 1;
        }

        return $this->tagWriteBin($tagId, $firstBlock, $buff, $options, $status);
    }

    /**
     * Writes data provided as an hexadecimal string to an RFID tag memory.
     * The write operation may span accross multiple blocks if the
     * number of bytes to write is larger than the RFID tag block size.
     * By default firstBlock cannot be a special block, and any special block
     * encountered in the middle of the write operation will be skipped
     * automatically. The last data block affected by the operation will
     * be automatically padded with zeros if neccessary.
     * If you rather want to rewrite special blocks as well,
     * use the EnableRawAccess field from the options parameter.
     *
     * @param string $tagId : identifier of the tag to use
     * @param int $firstBlock : block number where write should start
     * @param string $hexString : a string of hexadecimal byte codes to write
     * @param YRfidOptions $options : an YRfidOptions object with the optional
     *         command execution parameters, such as security key
     *         if required
     * @param YRfidStatus $status : an RfidStatus object that will contain
     *         the detailled status of the operation
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code. When it
     * happens, you can get more information from the status object.
     * @throws YAPI_Exception on error
     */
    public function tagWriteHex(string $tagId, int $firstBlock, string $hexString, YRfidOptions $options, YRfidStatus &$status): int
    {
        // $bufflen                is a int;
        // $optstr                 is a str;
        // $url                    is a str;
        // $json                   is a bin;
        // $buff                   is a bin;
        // $idx                    is a int;
        // $hexb                   is a int;
        $bufflen = strlen($hexString);
        $bufflen = (($bufflen) >> (1));
        if ($bufflen <= 16) {
            // short data, use an URL-based command
            $optstr = $options->imm_getParams();
            $url = sprintf('rfid.json?a=writ&t=%s&b=%d&w=%s%s',$tagId,$firstBlock,$hexString,$optstr);
            $json = $this->_download($url);
            return $this->_chkerror($tagId, $json, $status);
        } else {
            // long data, use an upload command
            $buff = ($bufflen > 0 ? pack('C',array_fill(0, $bufflen, 0)) : '');
            $idx = 0;
            while ($idx < $bufflen) {
                $hexb = hexdec(substr($hexString,  2 * $idx, 2));
                $buff[$idx] = pack('C', $hexb);
                $idx = $idx + 1;
            }
            return $this->tagWriteBin($tagId, $firstBlock, $buff, $options, $status);
        }
    }

    /**
     * Writes data provided as an ASCII string to an RFID tag memory.
     * The write operation may span accross multiple blocks if the
     * number of bytes to write is larger than the RFID tag block size.
     * Note that only the characters présent  in  the provided string
     * will be written, there is no notion of string length. If your
     * string data have variable length, you'll have to encode the
     * string length yourself, with a terminal zero for instannce.
     *
     * This function only works with ISO-latin characters, if you wish to
     * write strings encoded with alternate character sets, you'll have to
     * use tagWriteBin() function.
     *
     * By default firstBlock cannot be a special block, and any special block
     * encountered in the middle of the write operation will be skipped
     * automatically. The last data block affected by the operation will
     * be automatically padded with zeros if neccessary.
     * If you rather want to rewrite special blocks as well,
     * use the EnableRawAccess field from the options parameter
     * (definitely not recommanded).
     *
     * @param string $tagId : identifier of the tag to use
     * @param int $firstBlock : block number where write should start
     * @param string $text : the text string to write
     * @param YRfidOptions $options : an YRfidOptions object with the optional
     *         command execution parameters, such as security key
     *         if required
     * @param YRfidStatus $status : an RfidStatus object that will contain
     *         the detailled status of the operation
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code. When it
     * happens, you can get more information from the status object.
     * @throws YAPI_Exception on error
     */
    public function tagWriteStr(string $tagId, int $firstBlock, string $text, YRfidOptions $options, YRfidStatus &$status): int
    {
        // $buff                   is a bin;
        $buff = $text;

        return $this->tagWriteBin($tagId, $firstBlock, $buff, $options, $status);
    }

    /**
     * Reads an RFID tag AFI byte (ISO 15693 only).
     *
     * @param string $tagId : identifier of the tag to use
     * @param YRfidOptions $options : an YRfidOptions object with the optional
     *         command execution parameters, such as security key
     *         if required
     * @param YRfidStatus $status : an RfidStatus object that will contain
     *         the detailled status of the operation
     *
     * @return int  the AFI value (0...255)
     *
     * On failure, throws an exception or returns a negative error code. When it
     * happens, you can get more information from the status object.
     * @throws YAPI_Exception on error
     */
    public function tagGetAFI(string $tagId, YRfidOptions $options, YRfidStatus &$status): int
    {
        // $optstr                 is a str;
        // $url                    is a str;
        // $json                   is a bin;
        // $res                    is a int;
        $optstr = $options->imm_getParams();
        $url = sprintf('rfid.json?a=rdsf&t=%s&b=0%s',$tagId,$optstr);

        $json = $this->_download($url);
        $this->_chkerror($tagId, $json, $status);
        if ($status->get_yapiError() == YAPI::SUCCESS) {
            $res = intVal($this->_json_get_key($json, 'res'));
        } else {
            $res = $status->get_yapiError();
        }
        return $res;
    }

    /**
     * Changes an RFID tag AFI byte (ISO 15693 only).
     *
     * @param string $tagId : identifier of the tag to use
     * @param int $afi : the AFI value to write (0...255)
     * @param YRfidOptions $options : an YRfidOptions object with the optional
     *         command execution parameters, such as security key
     *         if required
     * @param YRfidStatus $status : an RfidStatus object that will contain
     *         the detailled status of the operation
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code. When it
     * happens, you can get more information from the status object.
     * @throws YAPI_Exception on error
     */
    public function tagSetAFI(string $tagId, int $afi, YRfidOptions $options, YRfidStatus &$status): int
    {
        // $optstr                 is a str;
        // $url                    is a str;
        // $json                   is a bin;
        $optstr = $options->imm_getParams();
        $url = sprintf('rfid.json?a=wrsf&t=%s&b=0&v=%d%s',$tagId,$afi,$optstr);

        $json = $this->_download($url);
        return $this->_chkerror($tagId, $json, $status);
    }

    /**
     * Locks the RFID tag AFI byte (ISO 15693 only).
     * This operation is definitive and irreversible.
     *
     * @param string $tagId : identifier of the tag to use
     * @param YRfidOptions $options : an YRfidOptions object with the optional
     *         command execution parameters, such as security key
     *         if required
     * @param YRfidStatus $status : an RfidStatus object that will contain
     *         the detailled status of the operation
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code. When it
     * happens, you can get more information from the status object.
     * @throws YAPI_Exception on error
     */
    public function tagLockAFI(string $tagId, YRfidOptions $options, YRfidStatus &$status): int
    {
        // $optstr                 is a str;
        // $url                    is a str;
        // $json                   is a bin;
        $optstr = $options->imm_getParams();
        $url = sprintf('rfid.json?a=lksf&t=%s&b=0%s',$tagId,$optstr);

        $json = $this->_download($url);
        return $this->_chkerror($tagId, $json, $status);
    }

    /**
     * Reads an RFID tag DSFID byte (ISO 15693 only).
     *
     * @param string $tagId : identifier of the tag to use
     * @param YRfidOptions $options : an YRfidOptions object with the optional
     *         command execution parameters, such as security key
     *         if required
     * @param YRfidStatus $status : an RfidStatus object that will contain
     *         the detailled status of the operation
     *
     * @return int  the DSFID value (0...255)
     *
     * On failure, throws an exception or returns a negative error code. When it
     * happens, you can get more information from the status object.
     * @throws YAPI_Exception on error
     */
    public function tagGetDSFID(string $tagId, YRfidOptions $options, YRfidStatus &$status): int
    {
        // $optstr                 is a str;
        // $url                    is a str;
        // $json                   is a bin;
        // $res                    is a int;
        $optstr = $options->imm_getParams();
        $url = sprintf('rfid.json?a=rdsf&t=%s&b=1%s',$tagId,$optstr);

        $json = $this->_download($url);
        $this->_chkerror($tagId, $json, $status);
        if ($status->get_yapiError() == YAPI::SUCCESS) {
            $res = intVal($this->_json_get_key($json, 'res'));
        } else {
            $res = $status->get_yapiError();
        }
        return $res;
    }

    /**
     * Changes an RFID tag DSFID byte (ISO 15693 only).
     *
     * @param string $tagId : identifier of the tag to use
     * @param int $dsfid : the DSFID value to write (0...255)
     * @param YRfidOptions $options : an YRfidOptions object with the optional
     *         command execution parameters, such as security key
     *         if required
     * @param YRfidStatus $status : an RfidStatus object that will contain
     *         the detailled status of the operation
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code. When it
     * happens, you can get more information from the status object.
     * @throws YAPI_Exception on error
     */
    public function tagSetDSFID(string $tagId, int $dsfid, YRfidOptions $options, YRfidStatus &$status): int
    {
        // $optstr                 is a str;
        // $url                    is a str;
        // $json                   is a bin;
        $optstr = $options->imm_getParams();
        $url = sprintf('rfid.json?a=wrsf&t=%s&b=1&v=%d%s',$tagId,$dsfid,$optstr);

        $json = $this->_download($url);
        return $this->_chkerror($tagId, $json, $status);
    }

    /**
     * Locks the RFID tag DSFID byte (ISO 15693 only).
     * This operation is definitive and irreversible.
     *
     * @param string $tagId : identifier of the tag to use
     * @param YRfidOptions $options : an YRfidOptions object with the optional
     *         command execution parameters, such as security key
     *         if required
     * @param YRfidStatus $status : an RfidStatus object that will contain
     *         the detailled status of the operation
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code. When it
     * happens, you can get more information from the status object.
     * @throws YAPI_Exception on error
     */
    public function tagLockDSFID(string $tagId, YRfidOptions $options, YRfidStatus &$status): int
    {
        // $optstr                 is a str;
        // $url                    is a str;
        // $json                   is a bin;
        $optstr = $options->imm_getParams();
        $url = sprintf('rfid.json?a=lksf&t=%s&b=1%s',$tagId,$optstr);

        $json = $this->_download($url);
        return $this->_chkerror($tagId, $json, $status);
    }

    /**
     * Returns a string with last tag arrival/removal events observed.
     * This method return only events that are still buffered in the device memory.
     *
     * @return string  a string with last events observed (one per line).
     *
     * On failure, throws an exception or returns  YAPI::INVALID_STRING.
     * @throws YAPI_Exception on error
     */
    public function get_lastEvents(): string
    {
        // $content                is a bin;

        $content = $this->_download('events.txt?pos=0');
        return $content;
    }

    /**
     * Registers a callback function to be called each time that an RFID tag appears or
     * disappears. The callback is invoked only during the execution of
     * ySleep or yHandleEvents. This provides control over the time when
     * the callback is triggered. For good responsiveness, remember to call one of these
     * two functions periodically. To unregister a callback, pass a null pointer as argument.
     *
     * @param callable $callback : the callback function to call, or a null pointer.
     *         The callback function should take four arguments:
     *         the YRfidReader object that emitted the event, the
     *         UTC timestamp of the event, a character string describing
     *         the type of event ("+" or "-") and a character string with the
     *         RFID tag identifier.
     *         On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function registerEventCallback(mixed $callback): int
    {
        $this->_eventCallback = $callback;
        $this->_isFirstCb = true;
        if (!is_null($callback)) {
            $this->registerValueCallback('yInternalEventCallback');
        } else {
            $this->registerValueCallback(null);
        }
        return 0;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function _internalEventHandler(string $cbVal): int
    {
        // $cbPos                  is a int;
        // $cbDPos                 is a int;
        // $url                    is a str;
        // $content                is a bin;
        // $contentStr             is a str;
        $eventArr = [];         // strArr;
        // $arrLen                 is a int;
        // $lenStr                 is a str;
        // $arrPos                 is a int;
        // $eventStr               is a str;
        // $eventLen               is a int;
        // $hexStamp               is a str;
        // $typePos                is a int;
        // $dataPos                is a int;
        // $intStamp               is a int;
        // $binMStamp              is a bin;
        // $msStamp                is a int;
        // $evtStamp               is a float;
        // $evtType                is a str;
        // $evtData                is a str;
        // detect possible power cycle of the reader to clear event pointer
        $cbPos = intVal($cbVal);
        $cbPos = intVal(($cbPos) / (1000));
        $cbDPos = (($cbPos - $this->_prevCbPos) & (0x7ffff));
        $this->_prevCbPos = $cbPos;
        if ($cbDPos > 16384) {
            $this->_eventPos = 0;
        }
        if (!(!is_null($this->_eventCallback))) {
            return YAPI::SUCCESS;
        }
        if ($this->_isFirstCb) {
            // first emulated value callback caused by registerValueCallback:
            // retrieve arrivals of all tags currently present to emulate arrival
            $this->_isFirstCb = false;
            $this->_eventStamp = 0;
            $content = $this->_download('events.txt');
            $contentStr = $content;
            $eventArr = explode(''."\n".'', $contentStr);
            $arrLen = sizeof($eventArr);
            if (!($arrLen > 0)) return $this->_throw( YAPI::IO_ERROR, 'fail to download events',YAPI::IO_ERROR);
            // first element of array is the new position preceeded by '@'
            $arrPos = 1;
            $lenStr = $eventArr[0];
            $lenStr = substr($lenStr,  1, strlen($lenStr)-1);
            // update processed event position pointer
            $this->_eventPos = intVal($lenStr);
        } else {
            // load all events since previous call
            $url = sprintf('events.txt?pos=%d', $this->_eventPos);
            $content = $this->_download($url);
            $contentStr = $content;
            $eventArr = explode(''."\n".'', $contentStr);
            $arrLen = sizeof($eventArr);
            if (!($arrLen > 0)) return $this->_throw( YAPI::IO_ERROR, 'fail to download events',YAPI::IO_ERROR);
            // last element of array is the new position preceeded by '@'
            $arrPos = 0;
            $arrLen = $arrLen - 1;
            $lenStr = $eventArr[$arrLen];
            $lenStr = substr($lenStr,  1, strlen($lenStr)-1);
            // update processed event position pointer
            $this->_eventPos = intVal($lenStr);
        }
        // now generate callbacks for each real event
        while ($arrPos < $arrLen) {
            $eventStr = $eventArr[$arrPos];
            $eventLen = strlen($eventStr);
            $typePos = YAPI::Ystrpos($eventStr,':')+1;
            if (($eventLen >= 14) && ($typePos > 10)) {
                $hexStamp = substr($eventStr,  0, 8);
                $intStamp = hexdec($hexStamp);
                if ($intStamp >= $this->_eventStamp) {
                    $this->_eventStamp = $intStamp;
                    $binMStamp = substr($eventStr,  8, 2);
                    $msStamp = (ord($binMStamp[0])-64) * 32 + ord($binMStamp[1]);
                    $evtStamp = $intStamp + (0.001 * $msStamp);
                    $dataPos = YAPI::Ystrpos($eventStr,'=')+1;
                    $evtType = substr($eventStr,  $typePos, 1);
                    $evtData = '';
                    if ($dataPos > 10) {
                        $evtData = substr($eventStr,  $dataPos, $eventLen-$dataPos);
                    }
                    if (!is_null($this->_eventCallback)) {
                        call_user_func($this->_eventCallback, $this, $evtStamp, $evtType, $evtData);
                    }
                }
            }
            $arrPos = $arrPos + 1;
        }
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception
     */
    public function nTags(): int
{
    return $this->get_nTags();
}

    /**
     * @throws YAPI_Exception
     */
    public function refreshRate(): int
{
    return $this->get_refreshRate();
}

    /**
     * @throws YAPI_Exception
     */
    public function setRefreshRate(int $newval): int
{
    return $this->set_refreshRate($newval);
}

    /**
     * Continues the enumeration of RFID readers started using yFirstRfidReader().
     * Caution: You can't make any assumption about the returned RFID readers order.
     * If you want to find a specific a RFID reader, use RfidReader.findRfidReader()
     * and a hardwareID or a logical name.
     *
     * @return ?YRfidReader  a pointer to a YRfidReader object, corresponding to
     *         a RFID reader currently online, or a null pointer
     *         if there are no more RFID readers to enumerate.
     */
    public function nextRfidReader(): ?YRfidReader
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindRfidReader($next_hwid);
    }

    /**
     * Starts the enumeration of RFID readers currently accessible.
     * Use the method YRfidReader::nextRfidReader() to iterate on
     * next RFID readers.
     *
     * @return ?YRfidReader  a pointer to a YRfidReader object, corresponding to
     *         the first RFID reader currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstRfidReader(): ?YRfidReader
    {
        $next_hwid = YAPI::getFirstHardwareId('RfidReader');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindRfidReader($next_hwid);
    }

    //--- (end of generated code: YRfidReader implementation)

}
//^^^^ YRfidReader.php

//--- (generated code: YRfidReader functions)

/**
 * Retrieves a RFID reader for a given identifier.
 * The identifier can be specified using several formats:
 *
 * - FunctionLogicalName
 * - ModuleSerialNumber.FunctionIdentifier
 * - ModuleSerialNumber.FunctionLogicalName
 * - ModuleLogicalName.FunctionIdentifier
 * - ModuleLogicalName.FunctionLogicalName
 *
 *
 * This function does not require that the RFID reader is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method isOnline() to test if the RFID reader is
 * indeed online at a given time. In case of ambiguity when looking for
 * a RFID reader by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 *
 * If a call to this object's is_online() method returns FALSE although
 * you are certain that the matching device is plugged, make sure that you did
 * call registerHub() at application initialization time.
 *
 * @param string $func : a string that uniquely characterizes the RFID reader, for instance
 *         MyDevice.rfidReader.
 *
 * @return YRfidReader  a YRfidReader object allowing you to drive the RFID reader.
 */
function yFindRfidReader(string $func): YRfidReader
{
    return YRfidReader::FindRfidReader($func);
}

/**
 * Starts the enumeration of RFID readers currently accessible.
 * Use the method YRfidReader::nextRfidReader() to iterate on
 * next RFID readers.
 *
 * @return ?YRfidReader  a pointer to a YRfidReader object, corresponding to
 *         the first RFID reader currently online, or a null pointer
 *         if there are none.
 */
function yFirstRfidReader(): ?YRfidReader
{
    return YRfidReader::FirstRfidReader();
}

//--- (end of generated code: YRfidReader functions)

