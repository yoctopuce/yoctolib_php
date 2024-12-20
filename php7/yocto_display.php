<?php
/*********************************************************************
 *
 * $Id: yocto_display.php 63695 2024-12-13 11:06:34Z seb $
 *
 * Implements yFindDisplay(), the high-level API for Display functions
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

//--- (generated code: YDisplay return codes)
//--- (end of generated code: YDisplay return codes)
//--- (generated code: YDisplayLayer return codes)
//--- (end of generated code: YDisplayLayer return codes)
//--- (generated code: YDisplay definitions)
if (!defined('Y_ENABLED_FALSE')) {
    define('Y_ENABLED_FALSE', 0);
}
if (!defined('Y_ENABLED_TRUE')) {
    define('Y_ENABLED_TRUE', 1);
}
if (!defined('Y_ENABLED_INVALID')) {
    define('Y_ENABLED_INVALID', -1);
}
if (!defined('Y_ORIENTATION_LEFT')) {
    define('Y_ORIENTATION_LEFT', 0);
}
if (!defined('Y_ORIENTATION_UP')) {
    define('Y_ORIENTATION_UP', 1);
}
if (!defined('Y_ORIENTATION_RIGHT')) {
    define('Y_ORIENTATION_RIGHT', 2);
}
if (!defined('Y_ORIENTATION_DOWN')) {
    define('Y_ORIENTATION_DOWN', 3);
}
if (!defined('Y_ORIENTATION_INVALID')) {
    define('Y_ORIENTATION_INVALID', -1);
}
if (!defined('Y_DISPLAYTYPE_MONO')) {
    define('Y_DISPLAYTYPE_MONO', 0);
}
if (!defined('Y_DISPLAYTYPE_GRAY')) {
    define('Y_DISPLAYTYPE_GRAY', 1);
}
if (!defined('Y_DISPLAYTYPE_RGB')) {
    define('Y_DISPLAYTYPE_RGB', 2);
}
if (!defined('Y_DISPLAYTYPE_INVALID')) {
    define('Y_DISPLAYTYPE_INVALID', -1);
}
if (!defined('Y_STARTUPSEQ_INVALID')) {
    define('Y_STARTUPSEQ_INVALID', YAPI_INVALID_STRING);
}
if (!defined('Y_BRIGHTNESS_INVALID')) {
    define('Y_BRIGHTNESS_INVALID', YAPI_INVALID_UINT);
}
if (!defined('Y_DISPLAYWIDTH_INVALID')) {
    define('Y_DISPLAYWIDTH_INVALID', YAPI_INVALID_UINT);
}
if (!defined('Y_DISPLAYHEIGHT_INVALID')) {
    define('Y_DISPLAYHEIGHT_INVALID', YAPI_INVALID_UINT);
}
if (!defined('Y_LAYERWIDTH_INVALID')) {
    define('Y_LAYERWIDTH_INVALID', YAPI_INVALID_UINT);
}
if (!defined('Y_LAYERHEIGHT_INVALID')) {
    define('Y_LAYERHEIGHT_INVALID', YAPI_INVALID_UINT);
}
if (!defined('Y_LAYERCOUNT_INVALID')) {
    define('Y_LAYERCOUNT_INVALID', YAPI_INVALID_UINT);
}
if (!defined('Y_COMMAND_INVALID')) {
    define('Y_COMMAND_INVALID', YAPI_INVALID_STRING);
}
//--- (end of generated code: YDisplay definitions)
//--- (generated code: YDisplayLayer definitions)
const Y_ALIGN_TOP_LEFT = 0;
const Y_ALIGN_CENTER_LEFT = 1;
const Y_ALIGN_BASELINE_LEFT = 2;
const Y_ALIGN_BOTTOM_LEFT = 3;
const Y_ALIGN_TOP_CENTER = 4;
const Y_ALIGN_CENTER = 5;
const Y_ALIGN_BASELINE_CENTER = 6;
const Y_ALIGN_BOTTOM_CENTER = 7;
const Y_ALIGN_TOP_DECIMAL = 8;
const Y_ALIGN_CENTER_DECIMAL = 9;
const Y_ALIGN_BASELINE_DECIMAL = 10;
const Y_ALIGN_BOTTOM_DECIMAL = 11;
const Y_ALIGN_TOP_RIGHT = 12;
const Y_ALIGN_CENTER_RIGHT = 13;
const Y_ALIGN_BASELINE_RIGHT = 14;
const Y_ALIGN_BOTTOM_RIGHT = 15;
//--- (end of generated code: YDisplayLayer definitions)

//--- (generated code: YDisplayLayer declaration)
//vvvv YDisplayLayer.php

/**
 * YDisplayLayer Class: Interface for drawing into display layers, obtained by calling display.get_displayLayer.
 *
 * Each DisplayLayer represents an image layer containing objects
 * to display (bitmaps, text, etc.). The content is displayed only when
 * the layer is active on the screen (and not masked by other
 * overlapping layers).
 */
class YDisplayLayer
{
    const ALIGN_TOP_LEFT                 = 0;
    const ALIGN_CENTER_LEFT              = 1;
    const ALIGN_BASELINE_LEFT            = 2;
    const ALIGN_BOTTOM_LEFT              = 3;
    const ALIGN_TOP_CENTER               = 4;
    const ALIGN_CENTER                   = 5;
    const ALIGN_BASELINE_CENTER          = 6;
    const ALIGN_BOTTOM_CENTER            = 7;
    const ALIGN_TOP_DECIMAL              = 8;
    const ALIGN_CENTER_DECIMAL           = 9;
    const ALIGN_BASELINE_DECIMAL         = 10;
    const ALIGN_BOTTOM_DECIMAL           = 11;
    const ALIGN_TOP_RIGHT                = 12;
    const ALIGN_CENTER_RIGHT             = 13;
    const ALIGN_BASELINE_RIGHT           = 14;
    const ALIGN_BOTTOM_RIGHT             = 15;
    //--- (end of generated code: YDisplayLayer declaration)

    //--- (generated code: YDisplayLayer attributes)

    //--- (end of generated code: YDisplayLayer attributes)
    protected $_display;
    protected $_id;
    protected $_cmdbuff;
    protected $_hidden;

    function __construct(YDisplay $parent, int $id)
    {
        //--- (generated code: YDisplayLayer constructor)
        //--- (end of generated code: YDisplayLayer constructor)
        $this->_display = $parent;
        $this->_id = $id;
        $this->_cmdbuff = '';
        $this->_hidden = false;
    }

    // internal function to flush any pending command for this layer
    public function flush_now(): int
    {
        $res = YAPI::SUCCESS;
        if ($this->_cmdbuff != '') {
            $res = $this->_display->sendCommand($this->_cmdbuff);
            $this->_cmdbuff = '';
        }
        return $res;
    }

    // internal function to send a state command for this layer
    private function command_push(string $str_cmd): int
    {
        $res = YAPI::SUCCESS;

        if (strlen($this->_cmdbuff) + strlen($str_cmd) >= 100) {
            // force flush before, to prevent overflow
            $res = $this->flush_now();
        }
        if ($this->_cmdbuff == '') {
            // always prepend layer ID first
            $this->_cmdbuff = $this->_id;
        }
        $this->_cmdbuff .= $str_cmd;
        return $res;
    }

    // internal function to send a command for this layer
    private function command_flush(string $str_cmd): int
    {
        $res = $this->command_push($str_cmd);
        if ($this->_hidden) {
            return $res;
        }
        return $this->flush_now();
    }

    //--- (generated code: YDisplayLayer implementation)

    /**
     * Reverts the layer to its initial state (fully transparent, default settings).
     * Reinitializes the drawing pointer to the upper left position,
     * and selects the most visible pen color. If you only want to erase the layer
     * content, use the method clear() instead.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function reset(): int
    {
        $this->_hidden = false;
        return $this->command_flush('X');
    }

    /**
     * Erases the whole content of the layer (makes it fully transparent).
     * This method does not change any other attribute of the layer.
     * To reinitialize the layer attributes to defaults settings, use the method
     * reset() instead.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function clear(): int
    {
        return $this->command_flush('x');
    }

    /**
     * Selects the pen color for all subsequent drawing functions,
     * including text drawing. The pen color is provided as an RGB value.
     * For grayscale or monochrome displays, the value is
     * automatically converted to the proper range.
     *
     * @param int $color : the desired pen color, as a 24-bit RGB value
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function selectColorPen(int $color): int
    {
        return $this->command_push(sprintf('c%06x',$color));
    }

    /**
     * Selects the pen gray level for all subsequent drawing functions,
     * including text drawing. The gray level is provided as a number between
     * 0 (black) and 255 (white, or whichever the lightest color is).
     * For monochrome displays (without gray levels), any value
     * lower than 128 is rendered as black, and any value equal
     * or above to 128 is non-black.
     *
     * @param int $graylevel : the desired gray level, from 0 to 255
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function selectGrayPen(int $graylevel): int
    {
        return $this->command_push(sprintf('g%d',$graylevel));
    }

    /**
     * Selects an eraser instead of a pen for all subsequent drawing functions,
     * except for bitmap copy functions. Any point drawn using the eraser
     * becomes transparent (as when the layer is empty), showing the other
     * layers beneath it.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function selectEraser(): int
    {
        return $this->command_push('e');
    }

    /**
     * Enables or disables anti-aliasing for drawing oblique lines and circles.
     * Anti-aliasing provides a smoother aspect when looked from far enough,
     * but it can add fuzziness when the display is looked from very close.
     * At the end of the day, it is your personal choice.
     * Anti-aliasing is enabled by default on grayscale and color displays,
     * but you can disable it if you prefer. This setting has no effect
     * on monochrome displays.
     *
     * @param boolean $mode : true to enable anti-aliasing, false to
     *         disable it.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function setAntialiasingMode(bool $mode): int
    {
        return $this->command_push(sprintf('a%d',$mode));
    }

    /**
     * Draws a single pixel at the specified position.
     *
     * @param int $x : the distance from left of layer, in pixels
     * @param int $y : the distance from top of layer, in pixels
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function drawPixel(int $x, int $y): int
    {
        return $this->command_flush(sprintf('P%d,%d',$x,$y));
    }

    /**
     * Draws an empty rectangle at a specified position.
     *
     * @param int $x1 : the distance from left of layer to the left border of the rectangle, in pixels
     * @param int $y1 : the distance from top of layer to the top border of the rectangle, in pixels
     * @param int $x2 : the distance from left of layer to the right border of the rectangle, in pixels
     * @param int $y2 : the distance from top of layer to the bottom border of the rectangle, in pixels
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function drawRect(int $x1, int $y1, int $x2, int $y2): int
    {
        return $this->command_flush(sprintf('R%d,%d,%d,%d',$x1,$y1,$x2,$y2));
    }

    /**
     * Draws a filled rectangular bar at a specified position.
     *
     * @param int $x1 : the distance from left of layer to the left border of the rectangle, in pixels
     * @param int $y1 : the distance from top of layer to the top border of the rectangle, in pixels
     * @param int $x2 : the distance from left of layer to the right border of the rectangle, in pixels
     * @param int $y2 : the distance from top of layer to the bottom border of the rectangle, in pixels
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function drawBar(int $x1, int $y1, int $x2, int $y2): int
    {
        return $this->command_flush(sprintf('B%d,%d,%d,%d',$x1,$y1,$x2,$y2));
    }

    /**
     * Draws an empty circle at a specified position.
     *
     * @param int $x : the distance from left of layer to the center of the circle, in pixels
     * @param int $y : the distance from top of layer to the center of the circle, in pixels
     * @param int $r : the radius of the circle, in pixels
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function drawCircle(int $x, int $y, int $r): int
    {
        return $this->command_flush(sprintf('C%d,%d,%d',$x,$y,$r));
    }

    /**
     * Draws a filled disc at a given position.
     *
     * @param int $x : the distance from left of layer to the center of the disc, in pixels
     * @param int $y : the distance from top of layer to the center of the disc, in pixels
     * @param int $r : the radius of the disc, in pixels
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function drawDisc(int $x, int $y, int $r): int
    {
        return $this->command_flush(sprintf('D%d,%d,%d',$x,$y,$r));
    }

    /**
     * Selects a font to use for the next text drawing functions, by providing the name of the
     * font file. You can use a built-in font as well as a font file that you have previously
     * uploaded to the device built-in memory. If you experience problems selecting a font
     * file, check the device logs for any error message such as missing font file or bad font
     * file format.
     *
     * @param string $fontname : the font file name, embedded fonts are 8x8.yfm, Small.yfm, Medium.yfm,
     * Large.yfm (not available on Yocto-MiniDisplay).
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function selectFont(string $fontname): int
    {
        return $this->command_push(sprintf('&%s%c',$fontname,27));
    }

    /**
     * Draws a text string at the specified position. The point of the text that is aligned
     * to the specified pixel position is called the anchor point, and can be chosen among
     * several options. Text is rendered from left to right, without implicit wrapping.
     *
     * @param int $x : the distance from left of layer to the text anchor point, in pixels
     * @param int $y : the distance from top of layer to the text anchor point, in pixels
     * @param int $anchor : the text anchor point, chosen among the YDisplayLayer::ALIGN enumeration:
     *         YDisplayLayer::ALIGN_TOP_LEFT,         YDisplayLayer::ALIGN_CENTER_LEFT,
     *         YDisplayLayer::ALIGN_BASELINE_LEFT,    YDisplayLayer::ALIGN_BOTTOM_LEFT,
     *         YDisplayLayer::ALIGN_TOP_CENTER,       YDisplayLayer::ALIGN_CENTER,
     *         YDisplayLayer::ALIGN_BASELINE_CENTER,  YDisplayLayer::ALIGN_BOTTOM_CENTER,
     *         YDisplayLayer::ALIGN_TOP_DECIMAL,      YDisplayLayer::ALIGN_CENTER_DECIMAL,
     *         YDisplayLayer::ALIGN_BASELINE_DECIMAL, YDisplayLayer::ALIGN_BOTTOM_DECIMAL,
     *         YDisplayLayer::ALIGN_TOP_RIGHT,        YDisplayLayer::ALIGN_CENTER_RIGHT,
     *         YDisplayLayer::ALIGN_BASELINE_RIGHT,   YDisplayLayer::ALIGN_BOTTOM_RIGHT.
     * @param string $text : the text string to draw
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function drawText(int $x, int $y, int $anchor, string $text): int
    {
        return $this->command_flush(sprintf('T%d,%d,%d,%s%c',$x,$y,$anchor,$text,27));
    }

    /**
     * Draws a GIF image at the specified position. The GIF image must have been previously
     * uploaded to the device built-in memory. If you experience problems using an image
     * file, check the device logs for any error message such as missing image file or bad
     * image file format.
     *
     * @param int $x : the distance from left of layer to the left of the image, in pixels
     * @param int $y : the distance from top of layer to the top of the image, in pixels
     * @param string $imagename : the GIF file name
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function drawImage(int $x, int $y, string $imagename): int
    {
        return $this->command_flush(sprintf('*%d,%d,%s%c',$x,$y,$imagename,27));
    }

    /**
     * Draws a bitmap at the specified position. The bitmap is provided as a binary object,
     * where each pixel maps to a bit, from left to right and from top to bottom.
     * The most significant bit of each byte maps to the leftmost pixel, and the least
     * significant bit maps to the rightmost pixel. Bits set to 1 are drawn using the
     * layer selected pen color. Bits set to 0 are drawn using the specified background
     * gray level, unless -1 is specified, in which case they are not drawn at all
     * (as if transparent).
     *
     * @param int $x : the distance from left of layer to the left of the bitmap, in pixels
     * @param int $y : the distance from top of layer to the top of the bitmap, in pixels
     * @param int $w : the width of the bitmap, in pixels
     * @param string $bitmap : a binary object
     * @param int $bgcol : the background gray level to use for zero bits (0 = black,
     *         255 = white), or -1 to leave the pixels unchanged
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function drawBitmap(int $x, int $y, int $w, string $bitmap, int $bgcol): int
    {
        // $destname               is a str;
        $destname = sprintf('layer%d:%d,%d@%d,%d',$this->_id,$w,$bgcol,$x,$y);
        return $this->_display->upload($destname,$bitmap);
    }

    /**
     * Moves the drawing pointer of this layer to the specified position.
     *
     * @param int $x : the distance from left of layer, in pixels
     * @param int $y : the distance from top of layer, in pixels
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function moveTo(int $x, int $y): int
    {
        return $this->command_push(sprintf('@%d,%d',$x,$y));
    }

    /**
     * Draws a line from current drawing pointer position to the specified position.
     * The specified destination pixel is included in the line. The pointer position
     * is then moved to the end point of the line.
     *
     * @param int $x : the distance from left of layer to the end point of the line, in pixels
     * @param int $y : the distance from top of layer to the end point of the line, in pixels
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function lineTo(int $x, int $y): int
    {
        return $this->command_flush(sprintf('-%d,%d',$x,$y));
    }

    /**
     * Outputs a message in the console area, and advances the console pointer accordingly.
     * The console pointer position is automatically moved to the beginning
     * of the next line when a newline character is met, or when the right margin
     * is hit. When the new text to display extends below the lower margin, the
     * console area is automatically scrolled up.
     *
     * @param string $text : the message to display
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function consoleOut(string $text): int
    {
        return $this->command_flush(sprintf('!%s%c',$text,27));
    }

    /**
     * Sets up display margins for the consoleOut function.
     *
     * @param int $x1 : the distance from left of layer to the left margin, in pixels
     * @param int $y1 : the distance from top of layer to the top margin, in pixels
     * @param int $x2 : the distance from left of layer to the right margin, in pixels
     * @param int $y2 : the distance from top of layer to the bottom margin, in pixels
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function setConsoleMargins(int $x1, int $y1, int $x2, int $y2): int
    {
        return $this->command_push(sprintf('m%d,%d,%d,%d',$x1,$y1,$x2,$y2));
    }

    /**
     * Sets up the background color used by the clearConsole function and by
     * the console scrolling feature.
     *
     * @param int $bgcol : the background gray level to use when scrolling (0 = black,
     *         255 = white), or -1 for transparent
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function setConsoleBackground(int $bgcol): int
    {
        return $this->command_push(sprintf('b%d',$bgcol));
    }

    /**
     * Sets up the wrapping behavior used by the consoleOut function.
     *
     * @param boolean $wordwrap : true to wrap only between words,
     *         false to wrap on the last column anyway.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function setConsoleWordWrap(bool $wordwrap): int
    {
        return $this->command_push(sprintf('w%d',$wordwrap));
    }

    /**
     * Blanks the console area within console margins, and resets the console pointer
     * to the upper left corner of the console.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function clearConsole(): int
    {
        return $this->command_flush('^');
    }

    /**
     * Sets the position of the layer relative to the display upper left corner.
     * When smooth scrolling is used, the display offset of the layer is
     * automatically updated during the next milliseconds to animate the move of the layer.
     *
     * @param int $x : the distance from left of display to the upper left corner of the layer
     * @param int $y : the distance from top of display to the upper left corner of the layer
     * @param int $scrollTime : number of milliseconds to use for smooth scrolling, or
     *         0 if the scrolling should be immediate.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function setLayerPosition(int $x, int $y, int $scrollTime): int
    {
        return $this->command_flush(sprintf('#%d,%d,%d',$x,$y,$scrollTime));
    }

    /**
     * Hides the layer. The state of the layer is preserved but the layer is not displayed
     * on the screen until the next call to unhide(). Hiding the layer can positively
     * affect the drawing speed, since it postpones the rendering until all operations are
     * completed (double-buffering).
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function hide(): int
    {
        $this->command_push('h');
        $this->_hidden = true;
        return $this->flush_now();
    }

    /**
     * Shows the layer. Shows the layer again after a hide command.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function unhide(): int
    {
        $this->_hidden = false;
        return $this->command_flush('s');
    }

    /**
     * Gets parent YDisplay. Returns the parent YDisplay object of the current YDisplayLayer::
     *
     * @return ?YDisplay  an YDisplay object
     */
    public function get_display(): ?YDisplay
    {
        return $this->_display;
    }

    /**
     * Returns the display width, in pixels.
     *
     * @return int  an integer corresponding to the display width, in pixels
     *
     * On failure, throws an exception or returns YDisplayLayer::DISPLAYWIDTH_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_displayWidth(): int
    {
        return $this->_display->get_displayWidth();
    }

    /**
     * Returns the display height, in pixels.
     *
     * @return int  an integer corresponding to the display height, in pixels
     *
     * On failure, throws an exception or returns YDisplayLayer::DISPLAYHEIGHT_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_displayHeight(): int
    {
        return $this->_display->get_displayHeight();
    }

    /**
     * Returns the width of the layers to draw on, in pixels.
     *
     * @return int  an integer corresponding to the width of the layers to draw on, in pixels
     *
     * On failure, throws an exception or returns YDisplayLayer::LAYERWIDTH_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_layerWidth(): int
    {
        return $this->_display->get_layerWidth();
    }

    /**
     * Returns the height of the layers to draw on, in pixels.
     *
     * @return int  an integer corresponding to the height of the layers to draw on, in pixels
     *
     * On failure, throws an exception or returns YDisplayLayer::LAYERHEIGHT_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_layerHeight(): int
    {
        return $this->_display->get_layerHeight();
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function resetHiddenFlag(): int
    {
        $this->_hidden = false;
        return YAPI::SUCCESS;
    }

    //--- (end of generated code: YDisplayLayer implementation)
}

//^^^^ YDisplayLayer.php
//--- (generated code: YDisplay declaration)
//vvvv YDisplay.php

/**
 * YDisplay Class: display control interface, available for instance in the Yocto-Display, the
 * Yocto-MaxiDisplay, the Yocto-MaxiDisplay-G or the Yocto-MiniDisplay
 *
 * The YDisplay class allows to drive Yoctopuce displays.
 * Yoctopuce display interface has been designed to easily
 * show information and images. The device provides built-in
 * multi-layer rendering. Layers can be drawn offline, individually,
 * and freely moved on the display. It can also replay recorded
 * sequences (animations).
 *
 * In order to draw on the screen, you should use the
 * display.get_displayLayer method to retrieve the layer(s) on
 * which you want to draw, and then use methods defined in
 * YDisplayLayer to draw on the layers.
 */
class YDisplay extends YFunction
{
    const ENABLED_FALSE = 0;
    const ENABLED_TRUE = 1;
    const ENABLED_INVALID = -1;
    const STARTUPSEQ_INVALID = YAPI::INVALID_STRING;
    const BRIGHTNESS_INVALID = YAPI::INVALID_UINT;
    const ORIENTATION_LEFT = 0;
    const ORIENTATION_UP = 1;
    const ORIENTATION_RIGHT = 2;
    const ORIENTATION_DOWN = 3;
    const ORIENTATION_INVALID = -1;
    const DISPLAYWIDTH_INVALID = YAPI::INVALID_UINT;
    const DISPLAYHEIGHT_INVALID = YAPI::INVALID_UINT;
    const DISPLAYTYPE_MONO = 0;
    const DISPLAYTYPE_GRAY = 1;
    const DISPLAYTYPE_RGB = 2;
    const DISPLAYTYPE_INVALID = -1;
    const LAYERWIDTH_INVALID = YAPI::INVALID_UINT;
    const LAYERHEIGHT_INVALID = YAPI::INVALID_UINT;
    const LAYERCOUNT_INVALID = YAPI::INVALID_UINT;
    const COMMAND_INVALID = YAPI::INVALID_STRING;
    //--- (end of generated code: YDisplay declaration)

    //--- (generated code: YDisplay attributes)
    protected $_enabled = self::ENABLED_INVALID;        // Bool
    protected $_startupSeq = self::STARTUPSEQ_INVALID;     // Text
    protected $_brightness = self::BRIGHTNESS_INVALID;     // Percent
    protected $_orientation = self::ORIENTATION_INVALID;    // Orientation
    protected $_displayWidth = self::DISPLAYWIDTH_INVALID;   // UInt31
    protected $_displayHeight = self::DISPLAYHEIGHT_INVALID;  // UInt31
    protected $_displayType = self::DISPLAYTYPE_INVALID;    // DisplayType
    protected $_layerWidth = self::LAYERWIDTH_INVALID;     // UInt31
    protected $_layerHeight = self::LAYERHEIGHT_INVALID;    // UInt31
    protected $_layerCount = self::LAYERCOUNT_INVALID;     // UInt31
    protected $_command = self::COMMAND_INVALID;        // Text
    protected $_allDisplayLayers = [];                           // YDisplayLayerArr

    //--- (end of generated code: YDisplay attributes)
    protected $_recording;
    protected $_sequence;

    function __construct(string $str_func)
    {
        //--- (generated code: YDisplay constructor)
        parent::__construct($str_func);
        $this->_className = 'Display';

        //--- (end of generated code: YDisplay constructor)
        $this->_recording = false;
        $this->_sequence = '';
    }

    //--- (generated code: YDisplay implementation)

    function _parseAttr(string $name,  $val): int
    {
        switch ($name) {
        case 'enabled':
            $this->_enabled = intval($val);
            return 1;
        case 'startupSeq':
            $this->_startupSeq = $val;
            return 1;
        case 'brightness':
            $this->_brightness = intval($val);
            return 1;
        case 'orientation':
            $this->_orientation = intval($val);
            return 1;
        case 'displayWidth':
            $this->_displayWidth = intval($val);
            return 1;
        case 'displayHeight':
            $this->_displayHeight = intval($val);
            return 1;
        case 'displayType':
            $this->_displayType = intval($val);
            return 1;
        case 'layerWidth':
            $this->_layerWidth = intval($val);
            return 1;
        case 'layerHeight':
            $this->_layerHeight = intval($val);
            return 1;
        case 'layerCount':
            $this->_layerCount = intval($val);
            return 1;
        case 'command':
            $this->_command = $val;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns true if the screen is powered, false otherwise.
     *
     * @return int  either YDisplay::ENABLED_FALSE or YDisplay::ENABLED_TRUE, according to true if the
     * screen is powered, false otherwise
     *
     * On failure, throws an exception or returns YDisplay::ENABLED_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_enabled(): int
    {
        // $res                    is a enumBOOL;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::ENABLED_INVALID;
            }
        }
        $res = $this->_enabled;
        return $res;
    }

    /**
     * Changes the power state of the display.
     *
     * @param int $newval : either YDisplay::ENABLED_FALSE or YDisplay::ENABLED_TRUE, according to the power
     * state of the display
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_enabled(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("enabled", $rest_val);
    }

    /**
     * Returns the name of the sequence to play when the displayed is powered on.
     *
     * @return string  a string corresponding to the name of the sequence to play when the displayed is powered on
     *
     * On failure, throws an exception or returns YDisplay::STARTUPSEQ_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_startupSeq(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::STARTUPSEQ_INVALID;
            }
        }
        $res = $this->_startupSeq;
        return $res;
    }

    /**
     * Changes the name of the sequence to play when the displayed is powered on.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param string $newval : a string corresponding to the name of the sequence to play when the
     * displayed is powered on
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_startupSeq(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("startupSeq", $rest_val);
    }

    /**
     * Returns the luminosity of the  module informative LEDs (from 0 to 100).
     *
     * @return int  an integer corresponding to the luminosity of the  module informative LEDs (from 0 to 100)
     *
     * On failure, throws an exception or returns YDisplay::BRIGHTNESS_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_brightness(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::BRIGHTNESS_INVALID;
            }
        }
        $res = $this->_brightness;
        return $res;
    }

    /**
     * Changes the brightness of the display. The parameter is a value between 0 and
     * 100. Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param int $newval : an integer corresponding to the brightness of the display
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_brightness(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("brightness", $rest_val);
    }

    /**
     * Returns the currently selected display orientation.
     *
     * @return int  a value among YDisplay::ORIENTATION_LEFT, YDisplay::ORIENTATION_UP,
     * YDisplay::ORIENTATION_RIGHT and YDisplay::ORIENTATION_DOWN corresponding to the currently selected
     * display orientation
     *
     * On failure, throws an exception or returns YDisplay::ORIENTATION_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_orientation(): int
    {
        // $res                    is a enumORIENTATION;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::ORIENTATION_INVALID;
            }
        }
        $res = $this->_orientation;
        return $res;
    }

    /**
     * Changes the display orientation. Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     *
     * @param int $newval : a value among YDisplay::ORIENTATION_LEFT, YDisplay::ORIENTATION_UP,
     * YDisplay::ORIENTATION_RIGHT and YDisplay::ORIENTATION_DOWN corresponding to the display orientation
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_orientation(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("orientation", $rest_val);
    }

    /**
     * Returns the display width, in pixels.
     *
     * @return int  an integer corresponding to the display width, in pixels
     *
     * On failure, throws an exception or returns YDisplay::DISPLAYWIDTH_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_displayWidth(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration == 0) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::DISPLAYWIDTH_INVALID;
            }
        }
        $res = $this->_displayWidth;
        return $res;
    }

    /**
     * Returns the display height, in pixels.
     *
     * @return int  an integer corresponding to the display height, in pixels
     *
     * On failure, throws an exception or returns YDisplay::DISPLAYHEIGHT_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_displayHeight(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration == 0) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::DISPLAYHEIGHT_INVALID;
            }
        }
        $res = $this->_displayHeight;
        return $res;
    }

    /**
     * Returns the display type: monochrome, gray levels or full color.
     *
     * @return int  a value among YDisplay::DISPLAYTYPE_MONO, YDisplay::DISPLAYTYPE_GRAY and
     * YDisplay::DISPLAYTYPE_RGB corresponding to the display type: monochrome, gray levels or full color
     *
     * On failure, throws an exception or returns YDisplay::DISPLAYTYPE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_displayType(): int
    {
        // $res                    is a enumDISPLAYTYPE;
        if ($this->_cacheExpiration == 0) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::DISPLAYTYPE_INVALID;
            }
        }
        $res = $this->_displayType;
        return $res;
    }

    /**
     * Returns the width of the layers to draw on, in pixels.
     *
     * @return int  an integer corresponding to the width of the layers to draw on, in pixels
     *
     * On failure, throws an exception or returns YDisplay::LAYERWIDTH_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_layerWidth(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration == 0) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::LAYERWIDTH_INVALID;
            }
        }
        $res = $this->_layerWidth;
        return $res;
    }

    /**
     * Returns the height of the layers to draw on, in pixels.
     *
     * @return int  an integer corresponding to the height of the layers to draw on, in pixels
     *
     * On failure, throws an exception or returns YDisplay::LAYERHEIGHT_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_layerHeight(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration == 0) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::LAYERHEIGHT_INVALID;
            }
        }
        $res = $this->_layerHeight;
        return $res;
    }

    /**
     * Returns the number of available layers to draw on.
     *
     * @return int  an integer corresponding to the number of available layers to draw on
     *
     * On failure, throws an exception or returns YDisplay::LAYERCOUNT_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_layerCount(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration == 0) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::LAYERCOUNT_INVALID;
            }
        }
        $res = $this->_layerCount;
        return $res;
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
     * Retrieves a display for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the display is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the display is
     * indeed online at a given time. In case of ambiguity when looking for
     * a display by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the display, for instance
     *         YD128X32.display.
     *
     * @return YDisplay  a YDisplay object allowing you to drive the display.
     */
    public static function FindDisplay(string $func): YDisplay
    {
        // $obj                    is a YDisplay;
        $obj = YFunction::_FindFromCache('Display', $func);
        if ($obj == null) {
            $obj = new YDisplay($func);
            YFunction::_AddToCache('Display', $func, $obj);
        }
        return $obj;
    }

    /**
     * Clears the display screen and resets all display layers to their default state.
     * Using this function in a sequence will kill the sequence play-back. Don't use that
     * function to reset the display at sequence start-up.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function resetAll(): int
    {
        $this->flushLayers();
        $this->resetHiddenLayerFlags();
        return $this->sendCommand('Z');
    }

    /**
     * Smoothly changes the brightness of the screen to produce a fade-in or fade-out
     * effect.
     *
     * @param int $brightness : the new screen brightness
     * @param int $duration : duration of the brightness transition, in milliseconds.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function fade(int $brightness, int $duration): int
    {
        $this->flushLayers();
        return $this->sendCommand(sprintf('+%d,%d',$brightness,$duration));
    }

    /**
     * Starts to record all display commands into a sequence, for later replay.
     * The name used to store the sequence is specified when calling
     * saveSequence(), once the recording is complete.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function newSequence(): int
    {
        $this->flushLayers();
        $this->_sequence = '';
        $this->_recording = true;
        return YAPI::SUCCESS;
    }

    /**
     * Stops recording display commands and saves the sequence into the specified
     * file on the display internal memory. The sequence can be later replayed
     * using playSequence().
     *
     * @param string $sequenceName : the name of the newly created sequence
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function saveSequence(string $sequenceName): int
    {
        $this->flushLayers();
        $this->_recording = false;
        $this->_upload($sequenceName, YAPI::Ystr2bin($this->_sequence));
        //We need to use YPRINTF("") for Objective-C
        $this->_sequence = sprintf('');
        return YAPI::SUCCESS;
    }

    /**
     * Replays a display sequence previously recorded using
     * newSequence() and saveSequence().
     *
     * @param string $sequenceName : the name of the newly created sequence
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function playSequence(string $sequenceName): int
    {
        $this->flushLayers();
        return $this->sendCommand(sprintf('S%s',$sequenceName));
    }

    /**
     * Waits for a specified delay (in milliseconds) before playing next
     * commands in current sequence. This method can be used while
     * recording a display sequence, to insert a timed wait in the sequence
     * (without any immediate effect). It can also be used dynamically while
     * playing a pre-recorded sequence, to suspend or resume the execution of
     * the sequence. To cancel a delay, call the same method with a zero delay.
     *
     * @param int $delay_ms : the duration to wait, in milliseconds
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function pauseSequence(int $delay_ms): int
    {
        $this->flushLayers();
        return $this->sendCommand(sprintf('W%d',$delay_ms));
    }

    /**
     * Stops immediately any ongoing sequence replay.
     * The display is left as is.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function stopSequence(): int
    {
        $this->flushLayers();
        return $this->sendCommand('S');
    }

    /**
     * Uploads an arbitrary file (for instance a GIF file) to the display, to the
     * specified full path name. If a file already exists with the same path name,
     * its content is overwritten.
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
     * Copies the whole content of a layer to another layer. The color and transparency
     * of all the pixels from the destination layer are set to match the source pixels.
     * This method only affects the displayed content, but does not change any
     * property of the layer object.
     * Note that layer 0 has no transparency support (it is always completely opaque).
     *
     * @param int $srcLayerId : the identifier of the source layer (a number in range 0..layerCount-1)
     * @param int $dstLayerId : the identifier of the destination layer (a number in range 0..layerCount-1)
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function copyLayerContent(int $srcLayerId, int $dstLayerId): int
    {
        $this->flushLayers();
        return $this->sendCommand(sprintf('o%d,%d',$srcLayerId,$dstLayerId));
    }

    /**
     * Swaps the whole content of two layers. The color and transparency of all the pixels from
     * the two layers are swapped. This method only affects the displayed content, but does
     * not change any property of the layer objects. In particular, the visibility of each
     * layer stays unchanged. When used between one hidden layer and a visible layer,
     * this method makes it possible to easily implement double-buffering.
     * Note that layer 0 has no transparency support (it is always completely opaque).
     *
     * @param int $layerIdA : the first layer (a number in range 0..layerCount-1)
     * @param int $layerIdB : the second layer (a number in range 0..layerCount-1)
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function swapLayerContent(int $layerIdA, int $layerIdB): int
    {
        $this->flushLayers();
        return $this->sendCommand(sprintf('E%d,%d',$layerIdA,$layerIdB));
    }

    /**
     * Returns a YDisplayLayer object that can be used to draw on the specified
     * layer. The content is displayed only when the layer is active on the
     * screen (and not masked by other overlapping layers).
     *
     * @param int $layerId : the identifier of the layer (a number in range 0..layerCount-1)
     *
     * @return ?YDisplayLayer  an YDisplayLayer object
     *
     * On failure, throws an exception or returns null.
     * @throws YAPI_Exception on error
     */
    public function get_displayLayer(int $layerId): ?YDisplayLayer
    {
        // $layercount             is a int;
        // $idx                    is a int;
        $layercount = $this->get_layerCount();
        if (!(($layerId >= 0) && ($layerId < $layercount))) return $this->_throw(YAPI::INVALID_ARGUMENT,'invalid DisplayLayer index',null);
        if (sizeof($this->_allDisplayLayers) == 0) {
            $idx = 0;
            while ($idx < $layercount) {
                $this->_allDisplayLayers[] = new YDisplayLayer($this, $idx);
                $idx = $idx + 1;
            }
        }
        return $this->_allDisplayLayers[$layerId];
    }

    /**
     * @throws YAPI_Exception
     */
    public function enabled(): int
{
    return $this->get_enabled();
}

    /**
     * @throws YAPI_Exception
     */
    public function setEnabled(int $newval): int
{
    return $this->set_enabled($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function startupSeq(): string
{
    return $this->get_startupSeq();
}

    /**
     * @throws YAPI_Exception
     */
    public function setStartupSeq(string $newval): int
{
    return $this->set_startupSeq($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function brightness(): int
{
    return $this->get_brightness();
}

    /**
     * @throws YAPI_Exception
     */
    public function setBrightness(int $newval): int
{
    return $this->set_brightness($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function orientation(): int
{
    return $this->get_orientation();
}

    /**
     * @throws YAPI_Exception
     */
    public function setOrientation(int $newval): int
{
    return $this->set_orientation($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function displayWidth(): int
{
    return $this->get_displayWidth();
}

    /**
     * @throws YAPI_Exception
     */
    public function displayHeight(): int
{
    return $this->get_displayHeight();
}

    /**
     * @throws YAPI_Exception
     */
    public function displayType(): int
{
    return $this->get_displayType();
}

    /**
     * @throws YAPI_Exception
     */
    public function layerWidth(): int
{
    return $this->get_layerWidth();
}

    /**
     * @throws YAPI_Exception
     */
    public function layerHeight(): int
{
    return $this->get_layerHeight();
}

    /**
     * @throws YAPI_Exception
     */
    public function layerCount(): int
{
    return $this->get_layerCount();
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
     * Continues the enumeration of displays started using yFirstDisplay().
     * Caution: You can't make any assumption about the returned displays order.
     * If you want to find a specific a display, use Display.findDisplay()
     * and a hardwareID or a logical name.
     *
     * @return ?YDisplay  a pointer to a YDisplay object, corresponding to
     *         a display currently online, or a null pointer
     *         if there are no more displays to enumerate.
     */
    public function nextDisplay(): ?YDisplay
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindDisplay($next_hwid);
    }

    /**
     * Starts the enumeration of displays currently accessible.
     * Use the method YDisplay::nextDisplay() to iterate on
     * next displays.
     *
     * @return ?YDisplay  a pointer to a YDisplay object, corresponding to
     *         the first display currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstDisplay(): ?YDisplay
    {
        $next_hwid = YAPI::getFirstHardwareId('Display');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindDisplay($next_hwid);
    }

    //--- (end of generated code: YDisplay implementation)

    public function flushLayers():int
    {
        foreach ($this->_allDisplayLayers as $layer) {
            $layer->flush_now();
        }
        return YAPI::SUCCESS;
    }

    public function resetHiddenLayerFlags()
    {
        foreach ($this->_allDisplayLayers as $layer) {
            $layer->resetHiddenFlag();
        }
    }

    public function sendCommand(string $str_cmd): int
    {
        if (!$this->_recording) {
            return $this->set_command($str_cmd);
        }
        $this->_sequence .= str_replace("\n", "\x0b", $str_cmd) . "\n";
        return YAPI::SUCCESS;
    }
}
//^^^^ YDisplay.php
//--- (generated code: YDisplay functions)

/**
 * Retrieves a display for a given identifier.
 * The identifier can be specified using several formats:
 *
 * - FunctionLogicalName
 * - ModuleSerialNumber.FunctionIdentifier
 * - ModuleSerialNumber.FunctionLogicalName
 * - ModuleLogicalName.FunctionIdentifier
 * - ModuleLogicalName.FunctionLogicalName
 *
 *
 * This function does not require that the display is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method isOnline() to test if the display is
 * indeed online at a given time. In case of ambiguity when looking for
 * a display by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 *
 * If a call to this object's is_online() method returns FALSE although
 * you are certain that the matching device is plugged, make sure that you did
 * call registerHub() at application initialization time.
 *
 * @param string $func : a string that uniquely characterizes the display, for instance
 *         YD128X32.display.
 *
 * @return YDisplay  a YDisplay object allowing you to drive the display.
 */
function yFindDisplay(string $func): YDisplay
{
    return YDisplay::FindDisplay($func);
}

/**
 * Starts the enumeration of displays currently accessible.
 * Use the method YDisplay::nextDisplay() to iterate on
 * next displays.
 *
 * @return ?YDisplay  a pointer to a YDisplay object, corresponding to
 *         the first display currently online, or a null pointer
 *         if there are none.
 */
function yFirstDisplay(): ?YDisplay
{
    return YDisplay::FirstDisplay();
}

//--- (end of generated code: YDisplay functions)
