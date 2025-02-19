<?php
/*********************************************************************
 *
 * $Id: yocto_messagebox.php 63695 2024-12-13 11:06:34Z seb $
 *
 * Implements YMessageBox, the high-level API for MessageBox functions
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

//--- (generated code: YSms return codes)
//--- (end of generated code: YSms return codes)
//--- (generated code: YSms definitions)
//--- (end of generated code: YSms definitions)

//--- (generated code: YSms declaration)
//vvvv YSms.php

/**
 * YSms Class: SMS message sent or received, returned by messageBox.get_messages or messageBox.newMessage
 *
 * YSms objects are used to describe an SMS message, received or to be sent.
 * These objects are used in particular in conjunction with the YMessageBox class.
 */
class YSms
{
    //--- (end of generated code: YSms declaration)

    //--- (generated code: YSms attributes)
    protected ?YMessageBox $_mbox = null;                         // YMessageBox
    protected int $_slot = 0;                            // int
    protected bool $_deliv = false;                        // bool
    protected string $_smsc = '';                           // str
    protected int $_mref = 0;                            // int
    protected string $_orig = '';                           // str
    protected string $_dest = '';                           // str
    protected int $_pid = 0;                            // int
    protected int $_alphab = 0;                            // int
    protected int $_mclass = 0;                            // int
    protected string $_stamp = '';                           // str
    protected string $_udh = "";                           // bin
    protected string $_udata = "";                           // bin
    protected int $_npdu = 0;                            // int
    protected string $_pdu = "";                           // bin
    protected array $_parts = [];                           // YSmsArr
    protected string $_aggSig = '';                           // str
    protected int $_aggIdx = 0;                            // int
    protected int $_aggCnt = 0;                            // int

    //--- (end of generated code: YSms attributes)

    function __construct(YMessageBox $obj_mbox)
    {
        //--- (generated code: YSms constructor)
        //--- (end of generated code: YSms constructor)
        $this->_mbox = $obj_mbox;
    }

    //--- (generated code: YSms implementation)

    /**
     * @throws YAPI_Exception on error
     */
    public function get_slot(): int
    {
        return $this->_slot;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_smsc(): string
    {
        return $this->_smsc;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_msgRef(): int
    {
        return $this->_mref;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_sender(): string
    {
        return $this->_orig;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_recipient(): string
    {
        return $this->_dest;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_protocolId(): int
    {
        return $this->_pid;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function isReceived(): bool
    {
        return $this->_deliv;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_alphabet(): int
    {
        return $this->_alphab;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_msgClass(): int
    {
        if ((($this->_mclass) & 16) == 0) {
            return -1;
        }
        return (($this->_mclass) & 3);
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_dcs(): int
    {
        return (($this->_mclass) | ((($this->_alphab) << 2)));
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_timestamp(): string
    {
        return $this->_stamp;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_userDataHeader(): string
    {
        return $this->_udh;
    }

    /**
     * Returns the value of the userData attribute, as previously stored using method
     * set_userData.
     * This attribute is never touched directly by the API, and is at disposal of the caller to
     * store a context.
     *
     * @return the object stored previously by the caller.
     */
    public function get_userData(): string
    {
        return $this->_udata;
    }

    /**
     * Returns the content of the message.
     *
     * @return string   a string with the content of the message.
     */
    public function get_textData(): string
    {
        // $isolatin               is a bin;
        // $isosize                is a int;
        // $i                      is a int;
        if ($this->_alphab == 0) {
            // using GSM standard 7-bit alphabet
            return $this->_mbox->gsm2str($this->_udata);
        }
        if ($this->_alphab == 2) {
            // using UCS-2 alphabet
            $isosize = ((strlen($this->_udata)) >> 1);
            $isolatin = ($isosize > 0 ? pack('C',array_fill(0, $isosize, 0)) : '');
            $i = 0;
            while ($i < $isosize) {
                $isolatin[$i] = pack('C', ord($this->_udata[2*$i+1]));
                $i = $i + 1;
            }
            return YAPI::Ybin2str($isolatin);
        }
        // default: convert 8 bit to string as-is
        return YAPI::Ybin2str($this->_udata);
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_unicodeData(): array
    {
        $res = [];              // intArr;
        // $unisize                is a int;
        // $unival                 is a int;
        // $i                      is a int;
        if ($this->_alphab == 0) {
            // using GSM standard 7-bit alphabet
            return $this->_mbox->gsm2unicode($this->_udata);
        }
        if ($this->_alphab == 2) {
            // using UCS-2 alphabet
            $unisize = ((strlen($this->_udata)) >> 1);
            while (sizeof($res) > 0) {
                array_pop($res);
            };
            $i = 0;
            while ($i < $unisize) {
                $unival = 256*ord($this->_udata[2*$i])+ord($this->_udata[2*$i+1]);
                $res[] = $unival;
                $i = $i + 1;
            }
        } else {
            // return straight 8-bit values
            $unisize = strlen($this->_udata);
            while (sizeof($res) > 0) {
                array_pop($res);
            };
            $i = 0;
            while ($i < $unisize) {
                $res[] = ord($this->_udata[$i])+0;
                $i = $i + 1;
            }
        }
        return $res;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_partCount(): int
    {
        if ($this->_npdu == 0) {
            $this->generatePdu();
        }
        return $this->_npdu;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_pdu(): string
    {
        if ($this->_npdu == 0) {
            $this->generatePdu();
        }
        return $this->_pdu;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_parts(): array
    {
        if ($this->_npdu == 0) {
            $this->generatePdu();
        }
        return $this->_parts;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_concatSignature(): string
    {
        if ($this->_npdu == 0) {
            $this->generatePdu();
        }
        return $this->_aggSig;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_concatIndex(): int
    {
        if ($this->_npdu == 0) {
            $this->generatePdu();
        }
        return $this->_aggIdx;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_concatCount(): int
    {
        if ($this->_npdu == 0) {
            $this->generatePdu();
        }
        return $this->_aggCnt;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function set_slot(int $val): int
    {
        $this->_slot = $val;
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function set_received(bool $val): int
    {
        $this->_deliv = $val;
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function set_smsc(string $val): int
    {
        $this->_smsc = $val;
        $this->_npdu = 0;
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function set_msgRef(int $val): int
    {
        $this->_mref = $val;
        $this->_npdu = 0;
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function set_sender(string $val): int
    {
        $this->_orig = $val;
        $this->_npdu = 0;
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function set_recipient(string $val): int
    {
        $this->_dest = $val;
        $this->_npdu = 0;
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function set_protocolId(int $val): int
    {
        $this->_pid = $val;
        $this->_npdu = 0;
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function set_alphabet(int $val): int
    {
        $this->_alphab = $val;
        $this->_npdu = 0;
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function set_msgClass(int $val): int
    {
        if ($val == -1) {
            $this->_mclass = 0;
        } else {
            $this->_mclass = 16+$val;
        }
        $this->_npdu = 0;
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function set_dcs(int $val): int
    {
        $this->_alphab = (((($val) >> 2)) & 3);
        $this->_mclass = (($val) & (16+3));
        $this->_npdu = 0;
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function set_timestamp(string $val): int
    {
        $this->_stamp = $val;
        $this->_npdu = 0;
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function set_userDataHeader(string $val): int
    {
        $this->_udh = $val;
        $this->_npdu = 0;
        $this->parseUserDataHeader();
        return YAPI::SUCCESS;
    }

    /**
     * Stores a user context provided as argument in the userData attribute of the function.
     * This attribute is never touched by the API, and is at disposal of the caller to store a context.
     *
     * @param data : any kind of object to be stored
     * @noreturn
     */
    public function set_userData(string $val): int
    {
        $this->_udata = $val;
        $this->_npdu = 0;
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function convertToUnicode(): int
    {
        $ucs2 = [];             // intArr;
        // $udatalen               is a int;
        // $i                      is a int;
        // $uni                    is a int;
        if ($this->_alphab == 2) {
            return YAPI::SUCCESS;
        }
        if ($this->_alphab == 0) {
            $ucs2 = $this->_mbox->gsm2unicode($this->_udata);
        } else {
            $udatalen = strlen($this->_udata);
            while (sizeof($ucs2) > 0) {
                array_pop($ucs2);
            };
            $i = 0;
            while ($i < $udatalen) {
                $uni = ord($this->_udata[$i]);
                $ucs2[] = $uni;
                $i = $i + 1;
            }
        }
        $this->_alphab = 2;
        $this->_udata = '';
        $this->addUnicodeData($ucs2);
        return YAPI::SUCCESS;
    }

    /**
     * Add a regular text to the SMS. This function support messages
     * of more than 160 characters. ISO-latin accented characters
     * are supported. For messages with special unicode characters such as asian
     * characters and emoticons, use the  addUnicodeData method.
     *
     * @param string $val : the text to be sent in the message
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     */
    public function addText(string $val): int
    {
        // $udata                  is a bin;
        // $udatalen               is a int;
        // $newdata                is a bin;
        // $newdatalen             is a int;
        // $i                      is a int;
        if (mb_strlen($val) == 0) {
            return YAPI::SUCCESS;
        }
        if ($this->_alphab == 0) {
            // Try to append using GSM 7-bit alphabet
            $newdata = $this->_mbox->str2gsm($val);
            $newdatalen = strlen($newdata);
            if ($newdatalen == 0) {
                // 7-bit not possible, switch to unicode
                $this->convertToUnicode();
                $newdata = YAPI::Ystr2bin($val);
                $newdatalen = strlen($newdata);
            }
        } else {
            $newdata = YAPI::Ystr2bin($val);
            $newdatalen = strlen($newdata);
        }
        $udatalen = strlen($this->_udata);
        if ($this->_alphab == 2) {
            // Append in unicode directly
            $udata = ($udatalen + 2*$newdatalen > 0 ? pack('C',array_fill(0, $udatalen + 2*$newdatalen, 0)) : '');
            $i = 0;
            while ($i < $udatalen) {
                $udata[$i] = pack('C', ord($this->_udata[$i]));
                $i = $i + 1;
            }
            $i = 0;
            while ($i < $newdatalen) {
                $udata[$udatalen+1] = pack('C', ord($newdata[$i]));
                $udatalen = $udatalen + 2;
                $i = $i + 1;
            }
        } else {
            // Append binary buffers
            $udata = ($udatalen+$newdatalen > 0 ? pack('C',array_fill(0, $udatalen+$newdatalen, 0)) : '');
            $i = 0;
            while ($i < $udatalen) {
                $udata[$i] = pack('C', ord($this->_udata[$i]));
                $i = $i + 1;
            }
            $i = 0;
            while ($i < $newdatalen) {
                $udata[$udatalen] = pack('C', ord($newdata[$i]));
                $udatalen = $udatalen + 1;
                $i = $i + 1;
            }
        }
        return $this->set_userData($udata);
    }

    /**
     * Add a unicode text to the SMS. This function support messages
     * of more than 160 characters, using SMS concatenation.
     *
     * @param Integer[] $val : an array of special unicode characters
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     */
    public function addUnicodeData(array $val): int
    {
        // $arrlen                 is a int;
        // $newdatalen             is a int;
        // $i                      is a int;
        // $uni                    is a int;
        // $udata                  is a bin;
        // $udatalen               is a int;
        // $surrogate              is a int;
        if ($this->_alphab != 2) {
            $this->convertToUnicode();
        }
        // compute number of 16-bit code units
        $arrlen = sizeof($val);
        $newdatalen = $arrlen;
        $i = 0;
        while ($i < $arrlen) {
            $uni = $val[$i];
            if ($uni > 65535) {
                $newdatalen = $newdatalen + 1;
            }
            $i = $i + 1;
        }
        // now build utf-16 buffer
        $udatalen = strlen($this->_udata);
        $udata = ($udatalen+2*$newdatalen > 0 ? pack('C',array_fill(0, $udatalen+2*$newdatalen, 0)) : '');
        $i = 0;
        while ($i < $udatalen) {
            $udata[$i] = pack('C', ord($this->_udata[$i]));
            $i = $i + 1;
        }
        $i = 0;
        while ($i < $arrlen) {
            $uni = $val[$i];
            if ($uni >= 65536) {
                $surrogate = $uni - 65536;
                $uni = (((($surrogate) >> 10) & 1023)) + 55296;
                $udata[$udatalen] = pack('C', (($uni) >> 8));
                $udata[$udatalen+1] = pack('C', (($uni) & 255));
                $udatalen = $udatalen + 2;
                $uni = ((($surrogate) & 1023)) + 56320;
            }
            $udata[$udatalen] = pack('C', (($uni) >> 8));
            $udata[$udatalen+1] = pack('C', (($uni) & 255));
            $udatalen = $udatalen + 2;
            $i = $i + 1;
        }
        return $this->set_userData($udata);
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function set_pdu(string $pdu): int
    {
        $this->_pdu = $pdu;
        $this->_npdu = 1;
        return $this->parsePdu($pdu);
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function set_parts(array $parts): int
    {
        $sorted = [];           // YSmsArr;
        // $partno                 is a int;
        // $initpartno             is a int;
        // $i                      is a int;
        // $retcode                is a int;
        // $totsize                is a int;
        // $subsms                 is a YSms;
        // $subdata                is a bin;
        // $res                    is a bin;
        $this->_npdu = sizeof($parts);
        if ($this->_npdu == 0) {
            return YAPI::INVALID_ARGUMENT;
        }
        while (sizeof($sorted) > 0) {
            array_pop($sorted);
        };
        $partno = 0;
        while ($partno < $this->_npdu) {
            $initpartno = $partno;
            $i = 0;
            while ($i < $this->_npdu) {
                $subsms = $parts[$i];
                if ($subsms->get_concatIndex() == $partno) {
                    $sorted[] = $subsms;
                    $partno = $partno + 1;
                }
                $i = $i + 1;
            }
            if ($initpartno == $partno) {
                $partno = $partno + 1;
            }
        }
        $this->_parts = $sorted;
        // inherit header fields from first part
        $subsms = $this->_parts[0];
        $retcode = $this->parsePdu($subsms->get_pdu());
        if ($retcode != YAPI::SUCCESS) {
            return $retcode;
        }
        $this->_npdu = sizeof($sorted);
        // concatenate user data from all parts
        $totsize = 0;
        $partno = 0;
        while ($partno < sizeof($this->_parts)) {
            $subsms = $this->_parts[$partno];
            $subdata = $subsms->get_userData();
            $totsize = $totsize + strlen($subdata);
            $partno = $partno + 1;
        }
        $res = ($totsize > 0 ? pack('C',array_fill(0, $totsize, 0)) : '');
        $totsize = 0;
        $partno = 0;
        while ($partno < sizeof($this->_parts)) {
            $subsms = $this->_parts[$partno];
            $subdata = $subsms->get_userData();
            $i = 0;
            while ($i < strlen($subdata)) {
                $res[$totsize] = pack('C', ord($subdata[$i]));
                $totsize = $totsize + 1;
                $i = $i + 1;
            }
            $partno = $partno + 1;
        }
        $this->_udata = $res;
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function encodeAddress(string $addr): string
    {
        // $bytes                  is a bin;
        // $srclen                 is a int;
        // $numlen                 is a int;
        // $i                      is a int;
        // $val                    is a int;
        // $digit                  is a int;
        // $res                    is a bin;
        $bytes = YAPI::Ystr2bin($addr);
        $srclen = strlen($bytes);
        $numlen = 0;
        $i = 0;
        while ($i < $srclen) {
            $val = ord($bytes[$i]);
            if (($val >= 48) && ($val < 58)) {
                $numlen = $numlen + 1;
            }
            $i = $i + 1;
        }
        if ($numlen == 0) {
            $res = (1 > 0 ? pack('C',array_fill(0, 1, 0)) : '');
            $res[0] = pack('C', 0);
            return $res;
        }
        $res = (2+(($numlen+1) >> 1) > 0 ? pack('C',array_fill(0, 2+(($numlen+1) >> 1), 0)) : '');
        $res[0] = pack('C', $numlen);
        if (ord($bytes[0]) == 43) {
            $res[1] = pack('C', 145);
        } else {
            $res[1] = pack('C', 129);
        }
        $numlen = 4;
        $digit = 0;
        $i = 0;
        while ($i < $srclen) {
            $val = ord($bytes[$i]);
            if (($val >= 48) && ($val < 58)) {
                if ((($numlen) & 1) == 0) {
                    $digit = $val - 48;
                } else {
                    $res[(($numlen) >> 1)] = pack('C', $digit + 16*($val-48));
                }
                $numlen = $numlen + 1;
            }
            $i = $i + 1;
        }
        // pad with F if needed
        if ((($numlen) & 1) != 0) {
            $res[(($numlen) >> 1)] = pack('C', $digit + 240);
        }
        return $res;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function decodeAddress(string $addr, int $ofs, int $siz): string
    {
        // $addrType               is a int;
        // $gsm7                   is a bin;
        // $res                    is a str;
        // $i                      is a int;
        // $rpos                   is a int;
        // $carry                  is a int;
        // $nbits                  is a int;
        // $byt                    is a int;
        if ($siz == 0) {
            return '';
        }
        $res = '';
        $addrType = ((ord($addr[$ofs])) & 112);
        if ($addrType == 80) {
            // alphanumeric number
            $siz = intVal((4*$siz) / (7));
            $gsm7 = ($siz > 0 ? pack('C',array_fill(0, $siz, 0)) : '');
            $rpos = 1;
            $carry = 0;
            $nbits = 0;
            $i = 0;
            while ($i < $siz) {
                if ($nbits == 7) {
                    $gsm7[$i] = pack('C', $carry);
                    $carry = 0;
                    $nbits = 0;
                } else {
                    $byt = ord($addr[$ofs+$rpos]);
                    $rpos = $rpos + 1;
                    $gsm7[$i] = pack('C', (($carry) | (((($byt) << ($nbits))) & 127)));
                    $carry = (($byt) >> (7 - $nbits));
                    $nbits = $nbits + 1;
                }
                $i = $i + 1;
            }
            return $this->_mbox->gsm2str($gsm7);
        } else {
            // standard phone number
            if ($addrType == 16) {
                $res = '+';
            }
            $siz = (($siz+1) >> 1);
            $i = 0;
            while ($i < $siz) {
                $byt = ord($addr[$ofs+$i+1]);
                $res = sprintf('%s%x%x', $res, (($byt) & 15), (($byt) >> 4));
                $i = $i + 1;
            }
            // remove padding digit if needed
            if (((ord($addr[$ofs+$siz])) >> 4) == 15) {
                $res = substr($res, 0, mb_strlen($res)-1);
            }
            return $res;
        }
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function encodeTimeStamp(string $exp): string
    {
        // $explen                 is a int;
        // $i                      is a int;
        // $res                    is a bin;
        // $n                      is a int;
        // $expasc                 is a bin;
        // $v1                     is a int;
        // $v2                     is a int;
        $explen = mb_strlen($exp);
        if ($explen == 0) {
            $res = '';
            return $res;
        }
        if (substr($exp, 0, 1) == '+') {
            $n = intVal(substr($exp, 1, $explen-1));
            $res = (1 > 0 ? pack('C',array_fill(0, 1, 0)) : '');
            if ($n > 30*86400) {
                $n = 192+intVal((($n+6*86400)) / ((7*86400)));
            } else {
                if ($n > 86400) {
                    $n = 166+intVal((($n+86399)) / (86400));
                } else {
                    if ($n > 43200) {
                        $n = 143+intVal((($n-43200+1799)) / (1800));
                    } else {
                        $n = -1+intVal((($n+299)) / (300));
                    }
                }
            }
            if ($n < 0) {
                $n = 0;
            }
            $res[0] = pack('C', $n);
            return $res;
        }
        if (substr($exp, 4, 1) == '-' || substr($exp, 4, 1) == '/') {
            // ignore century
            $exp = substr($exp, 2, $explen-2);
            $explen = mb_strlen($exp);
        }
        $expasc = YAPI::Ystr2bin($exp);
        $res = (7 > 0 ? pack('C',array_fill(0, 7, 0)) : '');
        $n = 0;
        $i = 0;
        while (($i+1 < $explen) && ($n < 7)) {
            $v1 = ord($expasc[$i]);
            if (($v1 >= 48) && ($v1 < 58)) {
                $v2 = ord($expasc[$i+1]);
                if (($v2 >= 48) && ($v2 < 58)) {
                    $v1 = $v1 - 48;
                    $v2 = $v2 - 48;
                    $res[$n] = pack('C', ((($v2) << 4)) + $v1);
                    $n = $n + 1;
                    $i = $i + 1;
                }
            }
            $i = $i + 1;
        }
        while ($n < 7) {
            $res[$n] = pack('C', 0);
            $n = $n + 1;
        }
        if ($i+2 < $explen) {
            // convert for timezone in cleartext ISO format +/-nn:nn
            $v1 = ord($expasc[$i-3]);
            $v2 = ord($expasc[$i]);
            if ((($v1 == 43) || ($v1 == 45)) && ($v2 == 58)) {
                $v1 = ord($expasc[$i+1]);
                $v2 = ord($expasc[$i+2]);
                if (($v1 >= 48) && ($v1 < 58) && ($v1 >= 48) && ($v1 < 58)) {
                    $v1 = intVal(((10*($v1 - 48)+($v2 - 48))) / (15));
                    $n = $n - 1;
                    $v2 = 4 * ord($res[$n]) + $v1;
                    if (ord($expasc[$i-3]) == 45) {
                        $v2 = $v2 + 128;
                    }
                    $res[$n] = pack('C', $v2);
                }
            }
        }
        return $res;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function decodeTimeStamp(string $exp, int $ofs, int $siz): string
    {
        // $n                      is a int;
        // $res                    is a str;
        // $i                      is a int;
        // $byt                    is a int;
        // $sign                   is a str;
        // $hh                     is a str;
        // $ss                     is a str;
        if ($siz < 1) {
            return '';
        }
        if ($siz == 1) {
            $n = ord($exp[$ofs]);
            if ($n < 144) {
                $n = $n * 300;
            } else {
                if ($n < 168) {
                    $n = ($n-143) * 1800;
                } else {
                    if ($n < 197) {
                        $n = ($n-166) * 86400;
                    } else {
                        $n = ($n-192) * 7 * 86400;
                    }
                }
            }
            return sprintf('+%d',$n);
        }
        $res = '20';
        $i = 0;
        while (($i < $siz) && ($i < 6)) {
            $byt = ord($exp[$ofs+$i]);
            $res = sprintf('%s%x%x', $res, (($byt) & 15), (($byt) >> 4));
            if ($i < 3) {
                if ($i < 2) {
                    $res = sprintf('%s-', $res);
                } else {
                    $res = sprintf('%s ', $res);
                }
            } else {
                if ($i < 5) {
                    $res = sprintf('%s:', $res);
                }
            }
            $i = $i + 1;
        }
        if ($siz == 7) {
            $byt = ord($exp[$ofs+$i]);
            $sign = '+';
            if ((($byt) & 8) != 0) {
                $byt = $byt - 8;
                $sign = '-';
            }
            $byt = (10*((($byt) & 15))) + ((($byt) >> 4));
            $hh = sprintf('%d', (($byt) >> 2));
            $ss = sprintf('%d', 15*((($byt) & 3)));
            if (mb_strlen($hh)<2) {
                $hh = sprintf('0%s', $hh);
            }
            if (mb_strlen($ss)<2) {
                $ss = sprintf('0%s', $ss);
            }
            $res = sprintf('%s%s%s:%s', $res, $sign, $hh, $ss);
        }
        return $res;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function udataSize(): int
    {
        // $res                    is a int;
        // $udhsize                is a int;
        $udhsize = strlen($this->_udh);
        $res = strlen($this->_udata);
        if ($this->_alphab == 0) {
            if ($udhsize > 0) {
                $res = $res + intVal(((8 + 8*$udhsize + 6)) / (7));
            }
            $res = intVal((($res * 7 + 7)) / (8));
        } else {
            if ($udhsize > 0) {
                $res = $res + 1 + $udhsize;
            }
        }
        return $res;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function encodeUserData(): string
    {
        // $udsize                 is a int;
        // $udlen                  is a int;
        // $udhsize                is a int;
        // $udhlen                 is a int;
        // $res                    is a bin;
        // $i                      is a int;
        // $wpos                   is a int;
        // $carry                  is a int;
        // $nbits                  is a int;
        // $thi_b                  is a int;
        // nbits = number of bits in carry
        $udsize = $this->udataSize();
        $udhsize = strlen($this->_udh);
        $udlen = strlen($this->_udata);
        $res = (1+$udsize > 0 ? pack('C',array_fill(0, 1+$udsize, 0)) : '');
        $udhlen = 0;
        $nbits = 0;
        $carry = 0;
        // 1. Encode UDL
        if ($this->_alphab == 0) {
            // 7-bit encoding
            if ($udhsize > 0) {
                $udhlen = intVal(((8 + 8*$udhsize + 6)) / (7));
                $nbits = 7*$udhlen - 8 - 8*$udhsize;
            }
            $res[0] = pack('C', $udhlen+$udlen);
        } else {
            // 8-bit encoding
            $res[0] = pack('C', $udsize);
        }
        // 2. Encode UDHL and UDL
        $wpos = 1;
        if ($udhsize > 0) {
            $res[$wpos] = pack('C', $udhsize);
            $wpos = $wpos + 1;
            $i = 0;
            while ($i < $udhsize) {
                $res[$wpos] = pack('C', ord($this->_udh[$i]));
                $wpos = $wpos + 1;
                $i = $i + 1;
            }
        }
        // 3. Encode UD
        if ($this->_alphab == 0) {
            // 7-bit encoding
            $i = 0;
            while ($i < $udlen) {
                if ($nbits == 0) {
                    $carry = ord($this->_udata[$i]);
                    $nbits = 7;
                } else {
                    $thi_b = ord($this->_udata[$i]);
                    $res[$wpos] = pack('C', (($carry) | (((($thi_b) << ($nbits))) & 255)));
                    $wpos = $wpos + 1;
                    $nbits = $nbits - 1;
                    $carry = (($thi_b) >> (7 - $nbits));
                }
                $i = $i + 1;
            }
            if ($nbits > 0) {
                $res[$wpos] = pack('C', $carry);
            }
        } else {
            // 8-bit encoding
            $i = 0;
            while ($i < $udlen) {
                $res[$wpos] = pack('C', ord($this->_udata[$i]));
                $wpos = $wpos + 1;
                $i = $i + 1;
            }
        }
        return $res;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function generateParts(): int
    {
        // $udhsize                is a int;
        // $udlen                  is a int;
        // $mss                    is a int;
        // $partno                 is a int;
        // $partlen                is a int;
        // $newud                  is a bin;
        // $newudh                 is a bin;
        // $newpdu                 is a YSms;
        // $i                      is a int;
        // $wpos                   is a int;
        $udhsize = strlen($this->_udh);
        $udlen = strlen($this->_udata);
        $mss = 140 - 1 - 5 - $udhsize;
        if ($this->_alphab == 0) {
            $mss = intVal((($mss * 8 - 6)) / (7));
        }
        $this->_npdu = intVal((($udlen+$mss-1)) / ($mss));
        while (sizeof($this->_parts) > 0) {
            array_pop($this->_parts);
        };
        $partno = 0;
        $wpos = 0;
        while ($wpos < $udlen) {
            $partno = $partno + 1;
            $newudh = (5+$udhsize > 0 ? pack('C',array_fill(0, 5+$udhsize, 0)) : '');
            $newudh[0] = pack('C', 0);           // IEI: concatenated message
            $newudh[1] = pack('C', 3);           // IEDL: 3 bytes
            $newudh[2] = pack('C', $this->_mref);
            $newudh[3] = pack('C', $this->_npdu);
            $newudh[4] = pack('C', $partno);
            $i = 0;
            while ($i < $udhsize) {
                $newudh[5+$i] = pack('C', ord($this->_udh[$i]));
                $i = $i + 1;
            }
            if ($wpos+$mss < $udlen) {
                $partlen = $mss;
            } else {
                $partlen = $udlen-$wpos;
            }
            $newud = ($partlen > 0 ? pack('C',array_fill(0, $partlen, 0)) : '');
            $i = 0;
            while ($i < $partlen) {
                $newud[$i] = pack('C', ord($this->_udata[$wpos]));
                $wpos = $wpos + 1;
                $i = $i + 1;
            }
            $newpdu = new YSms($this->_mbox);
            $newpdu->set_received($this->isReceived());
            $newpdu->set_smsc($this->get_smsc());
            $newpdu->set_msgRef($this->get_msgRef());
            $newpdu->set_sender($this->get_sender());
            $newpdu->set_recipient($this->get_recipient());
            $newpdu->set_protocolId($this->get_protocolId());
            $newpdu->set_dcs($this->get_dcs());
            $newpdu->set_timestamp($this->get_timestamp());
            $newpdu->set_userDataHeader($newudh);
            $newpdu->set_userData($newud);
            $this->_parts[] = $newpdu;
        }
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function generatePdu(): int
    {
        // $sca                    is a bin;
        // $hdr                    is a bin;
        // $addr                   is a bin;
        // $stamp                  is a bin;
        // $udata                  is a bin;
        // $pdutyp                 is a int;
        // $pdulen                 is a int;
        // $i                      is a int;
        // Determine if the message can fit within a single PDU
        while (sizeof($this->_parts) > 0) {
            array_pop($this->_parts);
        };
        if ($this->udataSize() > 140) {
            // multiple PDU are needed
            $this->_pdu = '';
            return $this->generateParts();
        }
        $sca = $this->encodeAddress($this->_smsc);
        if (strlen($sca) > 0) {
            $sca[0] = pack('C', strlen($sca)-1);
        }
        $stamp = $this->encodeTimeStamp($this->_stamp);
        $udata = $this->encodeUserData();
        if ($this->_deliv) {
            $addr = $this->encodeAddress($this->_orig);
            $hdr = (1 > 0 ? pack('C',array_fill(0, 1, 0)) : '');
            $pdutyp = 0;
        } else {
            $addr = $this->encodeAddress($this->_dest);
            $this->_mref = $this->_mbox->nextMsgRef();
            $hdr = (2 > 0 ? pack('C',array_fill(0, 2, 0)) : '');
            $hdr[1] = pack('C', $this->_mref);
            $pdutyp = 1;
            if (strlen($stamp) > 0) {
                $pdutyp = $pdutyp + 16;
            }
            if (strlen($stamp) == 7) {
                $pdutyp = $pdutyp + 8;
            }
        }
        if (strlen($this->_udh) > 0) {
            $pdutyp = $pdutyp + 64;
        }
        $hdr[0] = pack('C', $pdutyp);
        $pdulen = strlen($sca)+strlen($hdr)+strlen($addr)+2+strlen($stamp)+strlen($udata);
        $this->_pdu = ($pdulen > 0 ? pack('C',array_fill(0, $pdulen, 0)) : '');
        $pdulen = 0;
        $i = 0;
        while ($i < strlen($sca)) {
            $this->_pdu[$pdulen] = pack('C', ord($sca[$i]));
            $pdulen = $pdulen + 1;
            $i = $i + 1;
        }
        $i = 0;
        while ($i < strlen($hdr)) {
            $this->_pdu[$pdulen] = pack('C', ord($hdr[$i]));
            $pdulen = $pdulen + 1;
            $i = $i + 1;
        }
        $i = 0;
        while ($i < strlen($addr)) {
            $this->_pdu[$pdulen] = pack('C', ord($addr[$i]));
            $pdulen = $pdulen + 1;
            $i = $i + 1;
        }
        $this->_pdu[$pdulen] = pack('C', $this->_pid);
        $pdulen = $pdulen + 1;
        $this->_pdu[$pdulen] = pack('C', $this->get_dcs());
        $pdulen = $pdulen + 1;
        $i = 0;
        while ($i < strlen($stamp)) {
            $this->_pdu[$pdulen] = pack('C', ord($stamp[$i]));
            $pdulen = $pdulen + 1;
            $i = $i + 1;
        }
        $i = 0;
        while ($i < strlen($udata)) {
            $this->_pdu[$pdulen] = pack('C', ord($udata[$i]));
            $pdulen = $pdulen + 1;
            $i = $i + 1;
        }
        $this->_npdu = 1;
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function parseUserDataHeader(): int
    {
        // $udhlen                 is a int;
        // $i                      is a int;
        // $iei                    is a int;
        // $ielen                  is a int;
        // $sig                    is a str;
        $this->_aggSig = '';
        $this->_aggIdx = 0;
        $this->_aggCnt = 0;
        $udhlen = strlen($this->_udh);
        $i = 0;
        while ($i+1 < $udhlen) {
            $iei = ord($this->_udh[$i]);
            $ielen = ord($this->_udh[$i+1]);
            $i = $i + 2;
            if ($i + $ielen <= $udhlen) {
                if (($iei == 0) && ($ielen == 3)) {
                    // concatenated SMS, 8-bit ref
                    $sig = sprintf('%s-%s-%02x-%02x', $this->_orig, $this->_dest,
                    $this->_mref, ord($this->_udh[$i]));
                    $this->_aggSig = $sig;
                    $this->_aggCnt = ord($this->_udh[$i+1]);
                    $this->_aggIdx = ord($this->_udh[$i+2]);
                }
                if (($iei == 8) && ($ielen == 4)) {
                    // concatenated SMS, 16-bit ref
                    $sig = sprintf('%s-%s-%02x-%02x%02x', $this->_orig, $this->_dest,
                    $this->_mref, ord($this->_udh[$i]), ord($this->_udh[$i+1]));
                    $this->_aggSig = $sig;
                    $this->_aggCnt = ord($this->_udh[$i+2]);
                    $this->_aggIdx = ord($this->_udh[$i+3]);
                }
            }
            $i = $i + $ielen;
        }
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function parsePdu(string $pdu): int
    {
        // $rpos                   is a int;
        // $addrlen                is a int;
        // $pdutyp                 is a int;
        // $tslen                  is a int;
        // $dcs                    is a int;
        // $udlen                  is a int;
        // $udhsize                is a int;
        // $udhlen                 is a int;
        // $i                      is a int;
        // $carry                  is a int;
        // $nbits                  is a int;
        // $thi_b                  is a int;
        $this->_pdu = $pdu;
        $this->_npdu = 1;
        // parse meta-data
        $this->_smsc = $this->decodeAddress($pdu, 1, 2*(ord($pdu[0])-1));
        $rpos = 1+ord($pdu[0]);
        $pdutyp = ord($pdu[$rpos]);
        $rpos = $rpos + 1;
        $this->_deliv = ((($pdutyp) & 3) == 0);
        if ($this->_deliv) {
            $addrlen = ord($pdu[$rpos]);
            $rpos = $rpos + 1;
            $this->_orig = $this->decodeAddress($pdu, $rpos, $addrlen);
            $this->_dest = '';
            $tslen = 7;
        } else {
            $this->_mref = ord($pdu[$rpos]);
            $rpos = $rpos + 1;
            $addrlen = ord($pdu[$rpos]);
            $rpos = $rpos + 1;
            $this->_dest = $this->decodeAddress($pdu, $rpos, $addrlen);
            $this->_orig = '';
            if (((($pdutyp) & 16)) != 0) {
                if (((($pdutyp) & 8)) != 0) {
                    $tslen = 7;
                } else {
                    $tslen= 1;
                }
            } else {
                $tslen = 0;
            }
        }
        $rpos = $rpos + ((($addrlen+3) >> 1));
        $this->_pid = ord($pdu[$rpos]);
        $rpos = $rpos + 1;
        $dcs = ord($pdu[$rpos]);
        $rpos = $rpos + 1;
        $this->_alphab = (((($dcs) >> 2)) & 3);
        $this->_mclass = (($dcs) & (16+3));
        $this->_stamp = $this->decodeTimeStamp($pdu, $rpos, $tslen);
        $rpos = $rpos + $tslen;
        // parse user data (including udh)
        $nbits = 0;
        $carry = 0;
        $udlen = ord($pdu[$rpos]);
        $rpos = $rpos + 1;
        if ((($pdutyp) & 64) != 0) {
            $udhsize = ord($pdu[$rpos]);
            $rpos = $rpos + 1;
            $this->_udh = ($udhsize > 0 ? pack('C',array_fill(0, $udhsize, 0)) : '');
            $i = 0;
            while ($i < $udhsize) {
                $this->_udh[$i] = pack('C', ord($pdu[$rpos]));
                $rpos = $rpos + 1;
                $i = $i + 1;
            }
            if ($this->_alphab == 0) {
                // 7-bit encoding
                $udhlen = intVal(((8 + 8*$udhsize + 6)) / (7));
                $nbits = 7*$udhlen - 8 - 8*$udhsize;
                if ($nbits > 0) {
                    $thi_b = ord($pdu[$rpos]);
                    $rpos = $rpos + 1;
                    $carry = (($thi_b) >> ($nbits));
                    $nbits = 8 - $nbits;
                }
            } else {
                // byte encoding
                $udhlen = 1+$udhsize;
            }
            $udlen = $udlen - $udhlen;
        } else {
            $udhsize = 0;
            $this->_udh = '';
        }
        $this->_udata = ($udlen > 0 ? pack('C',array_fill(0, $udlen, 0)) : '');
        if ($this->_alphab == 0) {
            // 7-bit encoding
            $i = 0;
            while ($i < $udlen) {
                if ($nbits == 7) {
                    $this->_udata[$i] = pack('C', $carry);
                    $carry = 0;
                    $nbits = 0;
                } else {
                    $thi_b = ord($pdu[$rpos]);
                    $rpos = $rpos + 1;
                    $this->_udata[$i] = pack('C', (($carry) | (((($thi_b) << ($nbits))) & 127)));
                    $carry = (($thi_b) >> (7 - $nbits));
                    $nbits = $nbits + 1;
                }
                $i = $i + 1;
            }
        } else {
            // 8-bit encoding
            $i = 0;
            while ($i < $udlen) {
                $this->_udata[$i] = pack('C', ord($pdu[$rpos]));
                $rpos = $rpos + 1;
                $i = $i + 1;
            }
        }
        $this->parseUserDataHeader();
        return YAPI::SUCCESS;
    }

    /**
     * Sends the SMS to the recipient. Messages of more than 160 characters are supported
     * using SMS concatenation.
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function send(): int
    {
        // $i                      is a int;
        // $retcode                is a int;
        // $pdu                    is a YSms;

        if ($this->_npdu == 0) {
            $this->generatePdu();
        }
        if ($this->_npdu == 1) {
            return $this->_mbox->_upload('sendSMS', $this->_pdu);
        }
        $retcode = YAPI::SUCCESS;
        $i = 0;
        while (($i < $this->_npdu) && ($retcode == YAPI::SUCCESS)) {
            $pdu = $this->_parts[$i];
            $retcode= $pdu->send();
            $i = $i + 1;
        }
        return $retcode;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function deleteFromSIM(): int
    {
        // $i                      is a int;
        // $retcode                is a int;
        // $pdu                    is a YSms;

        if ($this->_npdu < 2) {
            return $this->_mbox->clearSIMSlot($this->_slot);
        }
        $retcode = YAPI::SUCCESS;
        $i = 0;
        while (($i < $this->_npdu) && ($retcode == YAPI::SUCCESS)) {
            $pdu = $this->_parts[$i];
            $retcode= $pdu->deleteFromSIM();
            $i = $i + 1;
        }
        return $retcode;
    }

    //--- (end of generated code: YSms implementation)

}

//^^^^ YSms.php

//--- (generated code: YSms functions)

//--- (end of generated code: YSms functions)

//--- (generated code: YMessageBox return codes)
//--- (end of generated code: YMessageBox return codes)
//--- (generated code: YMessageBox definitions)
if (!defined('Y_SLOTSINUSE_INVALID')) {
    define('Y_SLOTSINUSE_INVALID', YAPI_INVALID_UINT);
}
if (!defined('Y_SLOTSCOUNT_INVALID')) {
    define('Y_SLOTSCOUNT_INVALID', YAPI_INVALID_UINT);
}
if (!defined('Y_SLOTSBITMAP_INVALID')) {
    define('Y_SLOTSBITMAP_INVALID', YAPI_INVALID_STRING);
}
if (!defined('Y_PDUSENT_INVALID')) {
    define('Y_PDUSENT_INVALID', YAPI_INVALID_UINT);
}
if (!defined('Y_PDURECEIVED_INVALID')) {
    define('Y_PDURECEIVED_INVALID', YAPI_INVALID_UINT);
}
if (!defined('Y_OBEY_INVALID')) {
    define('Y_OBEY_INVALID', YAPI_INVALID_STRING);
}
if (!defined('Y_COMMAND_INVALID')) {
    define('Y_COMMAND_INVALID', YAPI_INVALID_STRING);
}
//--- (end of generated code: YMessageBox definitions)

//--- (generated code: YMessageBox declaration)
//vvvv YMessageBox.php

/**
 * YMessageBox Class: SMS message box interface control interface, available for instance in the
 * YoctoHub-GSM-2G, the YoctoHub-GSM-3G-EU, the YoctoHub-GSM-3G-NA or the YoctoHub-GSM-4G
 *
 * The YMessageBox class provides SMS sending and receiving capability for
 * GSM-enabled Yoctopuce devices.
 */
class YMessageBox extends YFunction
{
    const SLOTSINUSE_INVALID = YAPI::INVALID_UINT;
    const SLOTSCOUNT_INVALID = YAPI::INVALID_UINT;
    const SLOTSBITMAP_INVALID = YAPI::INVALID_STRING;
    const PDUSENT_INVALID = YAPI::INVALID_UINT;
    const PDURECEIVED_INVALID = YAPI::INVALID_UINT;
    const OBEY_INVALID = YAPI::INVALID_STRING;
    const COMMAND_INVALID = YAPI::INVALID_STRING;
    //--- (end of generated code: YMessageBox declaration)

    //--- (generated code: YMessageBox attributes)
    protected int $_slotsInUse = self::SLOTSINUSE_INVALID;     // UInt31
    protected int $_slotsCount = self::SLOTSCOUNT_INVALID;     // UInt31
    protected string $_slotsBitmap = self::SLOTSBITMAP_INVALID;    // BinaryBuffer
    protected int $_pduSent = self::PDUSENT_INVALID;        // UInt31
    protected int $_pduReceived = self::PDURECEIVED_INVALID;    // UInt31
    protected string $_obey = self::OBEY_INVALID;           // Text
    protected string $_command = self::COMMAND_INVALID;        // Text
    protected int $_nextMsgRef = 0;                            // int
    protected string $_prevBitmapStr = '';                           // str
    protected array $_pdus = [];                           // YSmsArr
    protected array $_messages = [];                           // YSmsArr
    protected bool $_gsm2unicodeReady = false;                        // bool
    protected array $_gsm2unicode = [];                           // intArr
    protected string $_iso2gsm = "";                           // bin

    //--- (end of generated code: YMessageBox attributes)

    function __construct(string $str_func)
    {
        //--- (generated code: YMessageBox constructor)
        parent::__construct($str_func);
        $this->_className = 'MessageBox';

        //--- (end of generated code: YMessageBox constructor)
    }

    //--- (generated code: YMessageBox implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'slotsInUse':
            $this->_slotsInUse = intval($val);
            return 1;
        case 'slotsCount':
            $this->_slotsCount = intval($val);
            return 1;
        case 'slotsBitmap':
            $this->_slotsBitmap = $val;
            return 1;
        case 'pduSent':
            $this->_pduSent = intval($val);
            return 1;
        case 'pduReceived':
            $this->_pduReceived = intval($val);
            return 1;
        case 'obey':
            $this->_obey = $val;
            return 1;
        case 'command':
            $this->_command = $val;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the number of message storage slots currently in use.
     *
     * @return int  an integer corresponding to the number of message storage slots currently in use
     *
     * On failure, throws an exception or returns YMessageBox::SLOTSINUSE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_slotsInUse(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::SLOTSINUSE_INVALID;
            }
        }
        $res = $this->_slotsInUse;
        return $res;
    }

    /**
     * Returns the total number of message storage slots on the SIM card.
     *
     * @return int  an integer corresponding to the total number of message storage slots on the SIM card
     *
     * On failure, throws an exception or returns YMessageBox::SLOTSCOUNT_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_slotsCount(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::SLOTSCOUNT_INVALID;
            }
        }
        $res = $this->_slotsCount;
        return $res;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_slotsBitmap(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::SLOTSBITMAP_INVALID;
            }
        }
        $res = $this->_slotsBitmap;
        return $res;
    }

    /**
     * Returns the number of SMS units sent so far.
     *
     * @return int  an integer corresponding to the number of SMS units sent so far
     *
     * On failure, throws an exception or returns YMessageBox::PDUSENT_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_pduSent(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::PDUSENT_INVALID;
            }
        }
        $res = $this->_pduSent;
        return $res;
    }

    /**
     * Changes the value of the outgoing SMS units counter.
     *
     * @param int $newval : an integer corresponding to the value of the outgoing SMS units counter
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_pduSent(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("pduSent", $rest_val);
    }

    /**
     * Returns the number of SMS units received so far.
     *
     * @return int  an integer corresponding to the number of SMS units received so far
     *
     * On failure, throws an exception or returns YMessageBox::PDURECEIVED_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_pduReceived(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::PDURECEIVED_INVALID;
            }
        }
        $res = $this->_pduReceived;
        return $res;
    }

    /**
     * Changes the value of the incoming SMS units counter.
     *
     * @param int $newval : an integer corresponding to the value of the incoming SMS units counter
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_pduReceived(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("pduReceived", $rest_val);
    }

    /**
     * Returns the phone number authorized to send remote management commands.
     * When a phone number is specified, the hub will take contre of all incoming
     * SMS messages: it will execute commands coming from the authorized number,
     * and delete all messages once received (whether authorized or not).
     * If you need to receive SMS messages using your own software, leave this
     * attribute empty.
     *
     * @return string  a string corresponding to the phone number authorized to send remote management commands
     *
     * On failure, throws an exception or returns YMessageBox::OBEY_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_obey(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::OBEY_INVALID;
            }
        }
        $res = $this->_obey;
        return $res;
    }

    /**
     * Changes the phone number authorized to send remote management commands.
     * The phone number usually starts with a '+' and does not include spacers.
     * When a phone number is specified, the hub will take contre of all incoming
     * SMS messages: it will execute commands coming from the authorized number,
     * and delete all messages once received (whether authorized or not).
     * If you need to receive SMS messages using your own software, leave this
     * attribute empty. Remember to call the saveToFlash() method of the
     * module if the modification must be kept.
     *
     * This feature is only available since YoctoHub-GSM-4G.
     *
     * @param string $newval : a string corresponding to the phone number authorized to send remote management commands
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_obey(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("obey", $rest_val);
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_command(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::COMMAND_INVALID;
            }
        }
        $res = $this->_command;
        return $res;
    }

    /**
     * @throws YAPI_Exception
     */
    public function set_command(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("command", $rest_val);
    }

    /**
     * Retrieves a SMS message box interface for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the SMS message box interface is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the SMS message box interface is
     * indeed online at a given time. In case of ambiguity when looking for
     * a SMS message box interface by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the SMS message box interface, for instance
     *         YHUBGSM1.messageBox.
     *
     * @return YMessageBox  a YMessageBox object allowing you to drive the SMS message box interface.
     */
    public static function FindMessageBox(string $func): YMessageBox
    {
        // $obj                    is a YMessageBox;
        $obj = YFunction::_FindFromCache('MessageBox', $func);
        if ($obj == null) {
            $obj = new YMessageBox($func);
            YFunction::_AddToCache('MessageBox', $func, $obj);
        }
        return $obj;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function nextMsgRef(): int
    {
        $this->_nextMsgRef = $this->_nextMsgRef + 1;
        return $this->_nextMsgRef;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function clearSIMSlot(int $slot): int
    {
        // $retry                  is a int;
        // $idx                    is a int;
        // $res                    is a str;
        // $bitmapStr              is a str;
        // $int_res                is a int;
        // $newBitmap              is a bin;
        // $bitVal                 is a int;

        $retry = 5;
        while ($retry > 0) {
            $this->clearCache();
            $bitmapStr = $this->get_slotsBitmap();
            $newBitmap = YAPI::_hexStrToBin($bitmapStr);
            $idx = (($slot) >> 3);
            if ($idx < strlen($newBitmap)) {
                $bitVal = (1 << ((($slot) & 7)));
                if ((((ord($newBitmap[$idx])) & ($bitVal))) != 0) {
                    $this->_prevBitmapStr = '';
                    $int_res = $this->set_command(sprintf('DS%d',$slot));
                    if ($int_res < 0) {
                        return $int_res;
                    }
                } else {
                    return YAPI::SUCCESS;
                }
            } else {
                return YAPI::INVALID_ARGUMENT;
            }
            $res = $this->_AT('');
            $retry = $retry - 1;
        }
        return YAPI::IO_ERROR;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function _AT(string $cmd): string
    {
        // $chrPos                 is a int;
        // $cmdLen                 is a int;
        // $waitMore               is a int;
        // $res                    is a str;
        // $buff                   is a bin;
        // $bufflen                is a int;
        // $buffstr                is a str;
        // $buffstrlen             is a int;
        // $idx                    is a int;
        // $suffixlen              is a int;
        // copied form the YCellular class
        // quote dangerous characters used in AT commands
        $cmdLen = mb_strlen($cmd);
        $chrPos = YAPI::Ystrpos($cmd,'#');
        while ($chrPos >= 0) {
            $cmd = sprintf('%s%c23%s', substr($cmd, 0, $chrPos), 37,
            substr($cmd, $chrPos+1, $cmdLen-$chrPos-1));
            $cmdLen = $cmdLen + 2;
            $chrPos = YAPI::Ystrpos($cmd,'#');
        }
        $chrPos = YAPI::Ystrpos($cmd,'+');
        while ($chrPos >= 0) {
            $cmd = sprintf('%s%c2B%s', substr($cmd, 0, $chrPos), 37,
            substr($cmd, $chrPos+1, $cmdLen-$chrPos-1));
            $cmdLen = $cmdLen + 2;
            $chrPos = YAPI::Ystrpos($cmd,'+');
        }
        $chrPos = YAPI::Ystrpos($cmd,'=');
        while ($chrPos >= 0) {
            $cmd = sprintf('%s%c3D%s', substr($cmd, 0, $chrPos), 37,
            substr($cmd, $chrPos+1, $cmdLen-$chrPos-1));
            $cmdLen = $cmdLen + 2;
            $chrPos = YAPI::Ystrpos($cmd,'=');
        }
        $cmd = sprintf('at.txt?cmd=%s',$cmd);
        $res = sprintf('');
        // max 2 minutes (each iteration may take up to 5 seconds if waiting)
        $waitMore = 24;
        while ($waitMore > 0) {
            $buff = $this->_download($cmd);
            $bufflen = strlen($buff);
            $buffstr = YAPI::Ybin2str($buff);
            $buffstrlen = mb_strlen($buffstr);
            $idx = $bufflen - 1;
            while (($idx > 0) && (ord($buff[$idx]) != 64) && (ord($buff[$idx]) != 10) && (ord($buff[$idx]) != 13)) {
                $idx = $idx - 1;
            }
            if (ord($buff[$idx]) == 64) {
                // continuation detected
                $suffixlen = $bufflen - $idx;
                $cmd = sprintf('at.txt?cmd=%s', substr($buffstr, $buffstrlen - $suffixlen, $suffixlen));
                $buffstr = substr($buffstr, 0, $buffstrlen - $suffixlen);
                $waitMore = $waitMore - 1;
            } else {
                // request complete
                $waitMore = 0;
            }
            $res = sprintf('%s%s', $res, $buffstr);
        }
        return $res;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function fetchPdu(int $slot): ?YSms
    {
        // $binPdu                 is a bin;
        $arrPdu = [];           // binArr;
        // $hexPdu                 is a str;
        // $sms                    is a YSms;

        $binPdu = $this->_download(sprintf('sms.json?pos=%d&len=1', $slot));
        $arrPdu = $this->_json_get_array($binPdu);
        $hexPdu = $this->_decode_json_string($arrPdu[0]);
        $sms = new YSms($this);
        $sms->set_slot($slot);
        $sms->parsePdu(YAPI::_hexStrToBin($hexPdu));
        return $sms;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function initGsm2Unicode(): int
    {
        // $i                      is a int;
        // $uni                    is a int;
        while (sizeof($this->_gsm2unicode) > 0) {
            array_pop($this->_gsm2unicode);
        };
        // 00-07
        $this->_gsm2unicode[] = 64;
        $this->_gsm2unicode[] = 163;
        $this->_gsm2unicode[] = 36;
        $this->_gsm2unicode[] = 165;
        $this->_gsm2unicode[] = 232;
        $this->_gsm2unicode[] = 233;
        $this->_gsm2unicode[] = 249;
        $this->_gsm2unicode[] = 236;
        // 08-0F
        $this->_gsm2unicode[] = 242;
        $this->_gsm2unicode[] = 199;
        $this->_gsm2unicode[] = 10;
        $this->_gsm2unicode[] = 216;
        $this->_gsm2unicode[] = 248;
        $this->_gsm2unicode[] = 13;
        $this->_gsm2unicode[] = 197;
        $this->_gsm2unicode[] = 229;
        // 10-17
        $this->_gsm2unicode[] = 916;
        $this->_gsm2unicode[] = 95;
        $this->_gsm2unicode[] = 934;
        $this->_gsm2unicode[] = 915;
        $this->_gsm2unicode[] = 923;
        $this->_gsm2unicode[] = 937;
        $this->_gsm2unicode[] = 928;
        $this->_gsm2unicode[] = 936;
        // 18-1F
        $this->_gsm2unicode[] = 931;
        $this->_gsm2unicode[] = 920;
        $this->_gsm2unicode[] = 926;
        $this->_gsm2unicode[] = 27;
        $this->_gsm2unicode[] = 198;
        $this->_gsm2unicode[] = 230;
        $this->_gsm2unicode[] = 223;
        $this->_gsm2unicode[] = 201;
        // 20-7A
        $i = 32;
        while ($i <= 122) {
            $this->_gsm2unicode[] = $i;
            $i = $i + 1;
        }
        // exceptions in range 20-7A
        $this->_gsm2unicode[36] = 164;
        $this->_gsm2unicode[64] = 161;
        $this->_gsm2unicode[91] = 196;
        $this->_gsm2unicode[92] = 214;
        $this->_gsm2unicode[93] = 209;
        $this->_gsm2unicode[94] = 220;
        $this->_gsm2unicode[95] = 167;
        $this->_gsm2unicode[96] = 191;
        // 7B-7F
        $this->_gsm2unicode[] = 228;
        $this->_gsm2unicode[] = 246;
        $this->_gsm2unicode[] = 241;
        $this->_gsm2unicode[] = 252;
        $this->_gsm2unicode[] = 224;
        // Invert table as well wherever possible
        $this->_iso2gsm = (256 > 0 ? pack('C',array_fill(0, 256, 0)) : '');
        $i = 0;
        while ($i <= 127) {
            $uni = $this->_gsm2unicode[$i];
            if ($uni <= 255) {
                $this->_iso2gsm[$uni] = pack('C', $i);
            }
            $i = $i + 1;
        }
        $i = 0;
        while ($i < 4) {
            // mark escape sequences
            $this->_iso2gsm[91+$i] = pack('C', 27);
            $this->_iso2gsm[123+$i] = pack('C', 27);
            $i = $i + 1;
        }
        // Done
        $this->_gsm2unicodeReady = true;
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function gsm2unicode(string $gsm): array
    {
        // $i                      is a int;
        // $gsmlen                 is a int;
        // $reslen                 is a int;
        $res = [];              // intArr;
        // $uni                    is a int;
        if (!($this->_gsm2unicodeReady)) {
            $this->initGsm2Unicode();
        }
        $gsmlen = strlen($gsm);
        $reslen = $gsmlen;
        $i = 0;
        while ($i < $gsmlen) {
            if (ord($gsm[$i]) == 27) {
                $reslen = $reslen - 1;
            }
            $i = $i + 1;
        }
        while (sizeof($res) > 0) {
            array_pop($res);
        };
        $i = 0;
        while ($i < $gsmlen) {
            $uni = $this->_gsm2unicode[ord($gsm[$i])];
            if (($uni == 27) && ($i+1 < $gsmlen)) {
                $i = $i + 1;
                $uni = ord($gsm[$i]);
                if ($uni < 60) {
                    if ($uni < 41) {
                        if ($uni==20) {
                            $uni=94;
                        } else {
                            if ($uni==40) {
                                $uni=123;
                            } else {
                                $uni=0;
                            }
                        }
                    } else {
                        if ($uni==41) {
                            $uni=125;
                        } else {
                            if ($uni==47) {
                                $uni=92;
                            } else {
                                $uni=0;
                            }
                        }
                    }
                } else {
                    if ($uni < 62) {
                        if ($uni==60) {
                            $uni=91;
                        } else {
                            if ($uni==61) {
                                $uni=126;
                            } else {
                                $uni=0;
                            }
                        }
                    } else {
                        if ($uni==62) {
                            $uni=93;
                        } else {
                            if ($uni==64) {
                                $uni=124;
                            } else {
                                if ($uni==101) {
                                    $uni=164;
                                } else {
                                    $uni=0;
                                }
                            }
                        }
                    }
                }
            }
            if ($uni > 0) {
                $res[] = $uni;
            }
            $i = $i + 1;
        }
        return $res;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function gsm2str(string $gsm): string
    {
        // $i                      is a int;
        // $gsmlen                 is a int;
        // $reslen                 is a int;
        // $resbin                 is a bin;
        // $resstr                 is a str;
        // $uni                    is a int;
        if (!($this->_gsm2unicodeReady)) {
            $this->initGsm2Unicode();
        }
        $gsmlen = strlen($gsm);
        $reslen = $gsmlen;
        $i = 0;
        while ($i < $gsmlen) {
            if (ord($gsm[$i]) == 27) {
                $reslen = $reslen - 1;
            }
            $i = $i + 1;
        }
        $resbin = ($reslen > 0 ? pack('C',array_fill(0, $reslen, 0)) : '');
        $i = 0;
        $reslen = 0;
        while ($i < $gsmlen) {
            $uni = $this->_gsm2unicode[ord($gsm[$i])];
            if (($uni == 27) && ($i+1 < $gsmlen)) {
                $i = $i + 1;
                $uni = ord($gsm[$i]);
                if ($uni < 60) {
                    if ($uni < 41) {
                        if ($uni==20) {
                            $uni=94;
                        } else {
                            if ($uni==40) {
                                $uni=123;
                            } else {
                                $uni=0;
                            }
                        }
                    } else {
                        if ($uni==41) {
                            $uni=125;
                        } else {
                            if ($uni==47) {
                                $uni=92;
                            } else {
                                $uni=0;
                            }
                        }
                    }
                } else {
                    if ($uni < 62) {
                        if ($uni==60) {
                            $uni=91;
                        } else {
                            if ($uni==61) {
                                $uni=126;
                            } else {
                                $uni=0;
                            }
                        }
                    } else {
                        if ($uni==62) {
                            $uni=93;
                        } else {
                            if ($uni==64) {
                                $uni=124;
                            } else {
                                if ($uni==101) {
                                    $uni=164;
                                } else {
                                    $uni=0;
                                }
                            }
                        }
                    }
                }
            }
            if (($uni > 0) && ($uni < 256)) {
                $resbin[$reslen] = pack('C', $uni);
                $reslen = $reslen + 1;
            }
            $i = $i + 1;
        }
        $resstr = YAPI::Ybin2str($resbin);
        if (mb_strlen($resstr) > $reslen) {
            $resstr = substr($resstr, 0, $reslen);
        }
        return $resstr;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function str2gsm(string $msg): string
    {
        // $asc                    is a bin;
        // $asclen                 is a int;
        // $i                      is a int;
        // $ch                     is a int;
        // $gsm7                   is a int;
        // $extra                  is a int;
        // $res                    is a bin;
        // $wpos                   is a int;
        if (!($this->_gsm2unicodeReady)) {
            $this->initGsm2Unicode();
        }
        $asc = YAPI::Ystr2bin($msg);
        $asclen = strlen($asc);
        $extra = 0;
        $i = 0;
        while ($i < $asclen) {
            $ch = ord($asc[$i]);
            $gsm7 = ord($this->_iso2gsm[$ch]);
            if ($gsm7 == 27) {
                $extra = $extra + 1;
            }
            if ($gsm7 == 0) {
                // cannot use standard GSM encoding
                $res = '';
                return $res;
            }
            $i = $i + 1;
        }
        $res = ($asclen+$extra > 0 ? pack('C',array_fill(0, $asclen+$extra, 0)) : '');
        $wpos = 0;
        $i = 0;
        while ($i < $asclen) {
            $ch = ord($asc[$i]);
            $gsm7 = ord($this->_iso2gsm[$ch]);
            $res[$wpos] = pack('C', $gsm7);
            $wpos = $wpos + 1;
            if ($gsm7 == 27) {
                if ($ch < 100) {
                    if ($ch<93) {
                        if ($ch<92) {
                            $gsm7=60;
                        } else {
                            $gsm7=47;
                        }
                    } else {
                        if ($ch<94) {
                            $gsm7=62;
                        } else {
                            $gsm7=20;
                        }
                    }
                } else {
                    if ($ch<125) {
                        if ($ch<124) {
                            $gsm7=40;
                        } else {
                            $gsm7=64;
                        }
                    } else {
                        if ($ch<126) {
                            $gsm7=41;
                        } else {
                            $gsm7=61;
                        }
                    }
                }
                $res[$wpos] = pack('C', $gsm7);
                $wpos = $wpos + 1;
            }
            $i = $i + 1;
        }
        return $res;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function checkNewMessages(): int
    {
        // $bitmapStr              is a str;
        // $prevBitmap             is a bin;
        // $newBitmap              is a bin;
        // $slot                   is a int;
        // $nslots                 is a int;
        // $pduIdx                 is a int;
        // $idx                    is a int;
        // $bitVal                 is a int;
        // $prevBit                is a int;
        // $i                      is a int;
        // $nsig                   is a int;
        // $cnt                    is a int;
        // $sig                    is a str;
        $newArr = [];           // YSmsArr;
        $newMsg = [];           // YSmsArr;
        $newAgg = [];           // YSmsArr;
        $signatures = [];       // strArr;
        // $sms                    is a YSms;

        $bitmapStr = $this->get_slotsBitmap();
        if ($bitmapStr == $this->_prevBitmapStr) {
            return YAPI::SUCCESS;
        }
        $prevBitmap = YAPI::_hexStrToBin($this->_prevBitmapStr);
        $newBitmap = YAPI::_hexStrToBin($bitmapStr);
        $this->_prevBitmapStr = $bitmapStr;
        $nslots = 8*strlen($newBitmap);
        while (sizeof($newArr) > 0) {
            array_pop($newArr);
        };
        while (sizeof($newMsg) > 0) {
            array_pop($newMsg);
        };
        while (sizeof($signatures) > 0) {
            array_pop($signatures);
        };
        $nsig = 0;
        // copy known messages
        $pduIdx = 0;
        while ($pduIdx < sizeof($this->_pdus)) {
            $sms = $this->_pdus[$pduIdx];
            $slot = $sms->get_slot();
            $idx = (($slot) >> 3);
            if ($idx < strlen($newBitmap)) {
                $bitVal = (1 << ((($slot) & 7)));
                if ((((ord($newBitmap[$idx])) & ($bitVal))) != 0) {
                    $newArr[] = $sms;
                    if ($sms->get_concatCount() == 0) {
                        $newMsg[] = $sms;
                    } else {
                        $sig = $sms->get_concatSignature();
                        $i = 0;
                        while (($i < $nsig) && (mb_strlen($sig) > 0)) {
                            if ($signatures[$i] == $sig) {
                                $sig = '';
                            }
                            $i = $i + 1;
                        }
                        if (mb_strlen($sig) > 0) {
                            $signatures[] = $sig;
                            $nsig = $nsig + 1;
                        }
                    }
                }
            }
            $pduIdx = $pduIdx + 1;
        }
        // receive new messages
        $slot = 0;
        while ($slot < $nslots) {
            $idx = (($slot) >> 3);
            $bitVal = (1 << ((($slot) & 7)));
            $prevBit = 0;
            if ($idx < strlen($prevBitmap)) {
                $prevBit = ((ord($prevBitmap[$idx])) & ($bitVal));
            }
            if ((((ord($newBitmap[$idx])) & ($bitVal))) != 0) {
                if ($prevBit == 0) {
                    $sms = $this->fetchPdu($slot);
                    $newArr[] = $sms;
                    if ($sms->get_concatCount() == 0) {
                        $newMsg[] = $sms;
                    } else {
                        $sig = $sms->get_concatSignature();
                        $i = 0;
                        while (($i < $nsig) && (mb_strlen($sig) > 0)) {
                            if ($signatures[$i] == $sig) {
                                $sig = '';
                            }
                            $i = $i + 1;
                        }
                        if (mb_strlen($sig) > 0) {
                            $signatures[] = $sig;
                            $nsig = $nsig + 1;
                        }
                    }
                }
            }
            $slot = $slot + 1;
        }
        $this->_pdus = $newArr;
        // append complete concatenated messages
        $i = 0;
        while ($i < $nsig) {
            $sig = $signatures[$i];
            $cnt = 0;
            $pduIdx = 0;
            while ($pduIdx < sizeof($this->_pdus)) {
                $sms = $this->_pdus[$pduIdx];
                if ($sms->get_concatCount() > 0) {
                    if ($sms->get_concatSignature() == $sig) {
                        if ($cnt == 0) {
                            $cnt = $sms->get_concatCount();
                            while (sizeof($newAgg) > 0) {
                                array_pop($newAgg);
                            };
                        }
                        $newAgg[] = $sms;
                    }
                }
                $pduIdx = $pduIdx + 1;
            }
            if (($cnt > 0) && (sizeof($newAgg) == $cnt)) {
                $sms = new YSms($this);
                $sms->set_parts($newAgg);
                $newMsg[] = $sms;
            }
            $i = $i + 1;
        }
        $this->_messages = $newMsg;
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_pdus(): array
    {
        $this->checkNewMessages();
        return $this->_pdus;
    }

    /**
     * Clear the SMS units counters.
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function clearPduCounters(): int
    {
        // $retcode                is a int;

        $retcode = $this->set_pduReceived(0);
        if ($retcode != YAPI::SUCCESS) {
            return $retcode;
        }
        $retcode = $this->set_pduSent(0);
        return $retcode;
    }

    /**
     * Sends a regular text SMS, with standard parameters. This function can send messages
     * of more than 160 characters, using SMS concatenation. ISO-latin accented characters
     * are supported. For sending messages with special unicode characters such as asian
     * characters and emoticons, use newMessage to create a new message and define
     * the content of using methods addText and addUnicodeData.
     *
     * @param string $recipient : a text string with the recipient phone number, either as a
     *         national number, or in international format starting with a plus sign
     * @param string $message : the text to be sent in the message
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function sendTextMessage(string $recipient, string $message): int
    {
        // $sms                    is a YSms;

        $sms = new YSms($this);
        $sms->set_recipient($recipient);
        $sms->addText($message);
        return $sms->send();
    }

    /**
     * Sends a Flash SMS (class 0 message). Flash messages are displayed on the handset
     * immediately and are usually not saved on the SIM card. This function can send messages
     * of more than 160 characters, using SMS concatenation. ISO-latin accented characters
     * are supported. For sending messages with special unicode characters such as asian
     * characters and emoticons, use newMessage to create a new message and define
     * the content of using methods addText et addUnicodeData.
     *
     * @param string $recipient : a text string with the recipient phone number, either as a
     *         national number, or in international format starting with a plus sign
     * @param string $message : the text to be sent in the message
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function sendFlashMessage(string $recipient, string $message): int
    {
        // $sms                    is a YSms;

        $sms = new YSms($this);
        $sms->set_recipient($recipient);
        $sms->set_msgClass(0);
        $sms->addText($message);
        return $sms->send();
    }

    /**
     * Creates a new empty SMS message, to be configured and sent later on.
     *
     * @param string $recipient : a text string with the recipient phone number, either as a
     *         national number, or in international format starting with a plus sign
     *
     * @return ?YSms  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function newMessage(string $recipient): ?YSms
    {
        // $sms                    is a YSms;
        $sms = new YSms($this);
        $sms->set_recipient($recipient);
        return $sms;
    }

    /**
     * Returns the list of messages received and not deleted. This function
     * will automatically decode concatenated SMS.
     *
     * @return YSms[]  an YSms object list.
     *
     * On failure, throws an exception or returns an empty list.
     * @throws YAPI_Exception on error
     */
    public function get_messages(): array
    {
        $this->checkNewMessages();
        return $this->_messages;
    }

    /**
     * @throws YAPI_Exception
     */
    public function slotsInUse(): int
{
    return $this->get_slotsInUse();
}

    /**
     * @throws YAPI_Exception
     */
    public function slotsCount(): int
{
    return $this->get_slotsCount();
}

    /**
     * @throws YAPI_Exception
     */
    public function slotsBitmap(): string
{
    return $this->get_slotsBitmap();
}

    /**
     * @throws YAPI_Exception
     */
    public function pduSent(): int
{
    return $this->get_pduSent();
}

    /**
     * @throws YAPI_Exception
     */
    public function setPduSent(int $newval): int
{
    return $this->set_pduSent($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function pduReceived(): int
{
    return $this->get_pduReceived();
}

    /**
     * @throws YAPI_Exception
     */
    public function setPduReceived(int $newval): int
{
    return $this->set_pduReceived($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function obey(): string
{
    return $this->get_obey();
}

    /**
     * @throws YAPI_Exception
     */
    public function setObey(string $newval): int
{
    return $this->set_obey($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function command(): string
{
    return $this->get_command();
}

    /**
     * @throws YAPI_Exception
     */
    public function setCommand(string $newval): int
{
    return $this->set_command($newval);
}

    /**
     * Continues the enumeration of SMS message box interfaces started using yFirstMessageBox().
     * Caution: You can't make any assumption about the returned SMS message box interfaces order.
     * If you want to find a specific a SMS message box interface, use MessageBox.findMessageBox()
     * and a hardwareID or a logical name.
     *
     * @return ?YMessageBox  a pointer to a YMessageBox object, corresponding to
     *         a SMS message box interface currently online, or a null pointer
     *         if there are no more SMS message box interfaces to enumerate.
     */
    public function nextMessageBox(): ?YMessageBox
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindMessageBox($next_hwid);
    }

    /**
     * Starts the enumeration of SMS message box interfaces currently accessible.
     * Use the method YMessageBox::nextMessageBox() to iterate on
     * next SMS message box interfaces.
     *
     * @return ?YMessageBox  a pointer to a YMessageBox object, corresponding to
     *         the first SMS message box interface currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstMessageBox(): ?YMessageBox
    {
        $next_hwid = YAPI::getFirstHardwareId('MessageBox');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindMessageBox($next_hwid);
    }

    //--- (end of generated code: YMessageBox implementation)

}

//^^^^ YMessageBox.php
//--- (generated code: YMessageBox functions)

/**
 * Retrieves a SMS message box interface for a given identifier.
 * The identifier can be specified using several formats:
 *
 * - FunctionLogicalName
 * - ModuleSerialNumber.FunctionIdentifier
 * - ModuleSerialNumber.FunctionLogicalName
 * - ModuleLogicalName.FunctionIdentifier
 * - ModuleLogicalName.FunctionLogicalName
 *
 *
 * This function does not require that the SMS message box interface is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method isOnline() to test if the SMS message box interface is
 * indeed online at a given time. In case of ambiguity when looking for
 * a SMS message box interface by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 *
 * If a call to this object's is_online() method returns FALSE although
 * you are certain that the matching device is plugged, make sure that you did
 * call registerHub() at application initialization time.
 *
 * @param string $func : a string that uniquely characterizes the SMS message box interface, for instance
 *         YHUBGSM1.messageBox.
 *
 * @return YMessageBox  a YMessageBox object allowing you to drive the SMS message box interface.
 */
function yFindMessageBox(string $func): YMessageBox
{
    return YMessageBox::FindMessageBox($func);
}

/**
 * Starts the enumeration of SMS message box interfaces currently accessible.
 * Use the method YMessageBox::nextMessageBox() to iterate on
 * next SMS message box interfaces.
 *
 * @return ?YMessageBox  a pointer to a YMessageBox object, corresponding to
 *         the first SMS message box interface currently online, or a null pointer
 *         if there are none.
 */
function yFirstMessageBox(): ?YMessageBox
{
    return YMessageBox::FirstMessageBox();
}

//--- (end of generated code: YMessageBox functions)
