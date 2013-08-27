<?php
/*********************************************************************
 *
 * $Id: yocto_display.php 12326 2013-08-13 15:52:20Z mvuilleu $
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

//--- (generated code: return codes)
//--- (end of generated code: return codes)
//--- (generated code: YDisplay definitions)
if(!defined('Y_POWERSTATE_OFF')) define('Y_POWERSTATE_OFF', 0);
if(!defined('Y_POWERSTATE_ON')) define('Y_POWERSTATE_ON', 1);
if(!defined('Y_POWERSTATE_INVALID')) define('Y_POWERSTATE_INVALID', -1);
if(!defined('Y_ORIENTATION_LEFT')) define('Y_ORIENTATION_LEFT', 0);
if(!defined('Y_ORIENTATION_UP')) define('Y_ORIENTATION_UP', 1);
if(!defined('Y_ORIENTATION_RIGHT')) define('Y_ORIENTATION_RIGHT', 2);
if(!defined('Y_ORIENTATION_DOWN')) define('Y_ORIENTATION_DOWN', 3);
if(!defined('Y_ORIENTATION_INVALID')) define('Y_ORIENTATION_INVALID', -1);
if(!defined('Y_DISPLAYTYPE_MONO')) define('Y_DISPLAYTYPE_MONO', 0);
if(!defined('Y_DISPLAYTYPE_GRAY')) define('Y_DISPLAYTYPE_GRAY', 1);
if(!defined('Y_DISPLAYTYPE_RGB')) define('Y_DISPLAYTYPE_RGB', 2);
if(!defined('Y_DISPLAYTYPE_INVALID')) define('Y_DISPLAYTYPE_INVALID', -1);
if(!defined('Y_LOGICALNAME_INVALID')) define('Y_LOGICALNAME_INVALID', Y_INVALID_STRING);
if(!defined('Y_ADVERTISEDVALUE_INVALID')) define('Y_ADVERTISEDVALUE_INVALID', Y_INVALID_STRING);
if(!defined('Y_STARTUPSEQ_INVALID')) define('Y_STARTUPSEQ_INVALID', Y_INVALID_STRING);
if(!defined('Y_BRIGHTNESS_INVALID')) define('Y_BRIGHTNESS_INVALID', Y_INVALID_UNSIGNED);
if(!defined('Y_DISPLAYWIDTH_INVALID')) define('Y_DISPLAYWIDTH_INVALID', Y_INVALID_UNSIGNED);
if(!defined('Y_DISPLAYHEIGHT_INVALID')) define('Y_DISPLAYHEIGHT_INVALID', Y_INVALID_UNSIGNED);
if(!defined('Y_LAYERWIDTH_INVALID')) define('Y_LAYERWIDTH_INVALID', Y_INVALID_UNSIGNED);
if(!defined('Y_LAYERHEIGHT_INVALID')) define('Y_LAYERHEIGHT_INVALID', Y_INVALID_UNSIGNED);
if(!defined('Y_LAYERCOUNT_INVALID')) define('Y_LAYERCOUNT_INVALID', Y_INVALID_UNSIGNED);
if(!defined('Y_COMMAND_INVALID')) define('Y_COMMAND_INVALID', Y_INVALID_STRING);
//--- (end of generated code: YDisplay definitions)
//--- (generated code: YDisplayLayer definitions)
if(!defined('Y_ALIGN_TOP_LEFT')) define('Y_ALIGN_TOP_LEFT', 0);
if(!defined('Y_ALIGN_CENTER_LEFT')) define('Y_ALIGN_CENTER_LEFT', 1);
if(!defined('Y_ALIGN_BASELINE_LEFT')) define('Y_ALIGN_BASELINE_LEFT', 2);
if(!defined('Y_ALIGN_BOTTOM_LEFT')) define('Y_ALIGN_BOTTOM_LEFT', 3);
if(!defined('Y_ALIGN_TOP_CENTER')) define('Y_ALIGN_TOP_CENTER', 4);
if(!defined('Y_ALIGN_CENTER')) define('Y_ALIGN_CENTER', 5);
if(!defined('Y_ALIGN_BASELINE_CENTER')) define('Y_ALIGN_BASELINE_CENTER', 6);
if(!defined('Y_ALIGN_BOTTOM_CENTER')) define('Y_ALIGN_BOTTOM_CENTER', 7);
if(!defined('Y_ALIGN_TOP_DECIMAL')) define('Y_ALIGN_TOP_DECIMAL', 8);
if(!defined('Y_ALIGN_CENTER_DECIMAL')) define('Y_ALIGN_CENTER_DECIMAL', 9);
if(!defined('Y_ALIGN_BASELINE_DECIMAL')) define('Y_ALIGN_BASELINE_DECIMAL', 10);
if(!defined('Y_ALIGN_BOTTOM_DECIMAL')) define('Y_ALIGN_BOTTOM_DECIMAL', 11);
if(!defined('Y_ALIGN_TOP_RIGHT')) define('Y_ALIGN_TOP_RIGHT', 12);
if(!defined('Y_ALIGN_CENTER_RIGHT')) define('Y_ALIGN_CENTER_RIGHT', 13);
if(!defined('Y_ALIGN_BASELINE_RIGHT')) define('Y_ALIGN_BASELINE_RIGHT', 14);
if(!defined('Y_ALIGN_BOTTOM_RIGHT')) define('Y_ALIGN_BOTTOM_RIGHT', 15);
//--- (end of generated code: YDisplayLayer definitions)

/**
 * YDisplayLayer Class: Image layer containing data to display
 * 
 * A DisplayLayer is an image layer containing objects to display
 * (bitmaps, text, etc.). The content will only be displayed when
 * the layer is active on the screen (and not masked by other
 * overlapping layers).
 */
class YDisplayLayer
{

    private $_display;
    private $_id;
    private $_cmdbuff;
    private $_hidden;

    // internal function to flush any pending command for this layer
    public function flush_now() 
    {
        $res = YAPI_SUCCESS;
        if($this->_cmdbuff != '') {
            $res = $this->_display->sendCommand($this->_cmdbuff);
            $this->_cmdbuff = '';
        }
        return $res;
    }
    
    // internal function to send a state command for this layer
    private function command_push($str_cmd) 
    {
        $res = YAPI_SUCCESS;
        
        if(strlen($this->_cmdbuff)+strlen($str_cmd) >= 100) {
            // force flush before, to prevent overflow
            $res = $this->flush_now();
        }
        if($this->_cmdbuff=='') {
            // always prepend layer ID first
            $this->_cmdbuff = $this->_id;
        } 
        $this->_cmdbuff .= $str_cmd;
        return $res;
    }

    // internal function to send a command for this layer
    private function command_flush($str_cmd)
    {
        $res = $this->command_push($str_cmd);
        if($this->_hidden) {
            return $res;
        }
        return $this->flush_now();
    }

    function __construct($parent, $id)
    {
        $this->_display    = $parent;
        $this->_id         = $id;
        $this->_cmdbuff    = '';
        $this->_hidden     = FALSE;
    }

    //--- (generated code: YDisplayLayer implementation)
    const ALIGN_TOP_LEFT = 0;
    const ALIGN_CENTER_LEFT = 1;
    const ALIGN_BASELINE_LEFT = 2;
    const ALIGN_BOTTOM_LEFT = 3;
    const ALIGN_TOP_CENTER = 4;
    const ALIGN_CENTER = 5;
    const ALIGN_BASELINE_CENTER = 6;
    const ALIGN_BOTTOM_CENTER = 7;
    const ALIGN_TOP_DECIMAL = 8;
    const ALIGN_CENTER_DECIMAL = 9;
    const ALIGN_BASELINE_DECIMAL = 10;
    const ALIGN_BOTTOM_DECIMAL = 11;
    const ALIGN_TOP_RIGHT = 12;
    const ALIGN_CENTER_RIGHT = 13;
    const ALIGN_BASELINE_RIGHT = 14;
    const ALIGN_BOTTOM_RIGHT = 15;

    /**
     * Reverts the layer to its initial state (fully transparent, default settings).
     * Reinitializes the drawing pointer to the upper left position,
     * and selects the most visible pen color. If you only want to erase the layer
     * content, use the method clear() instead.
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function reset()
    {
        $this->_hidden = FALSE; 
        return $this->command_flush('X'); 
        
    }

    /**
     * Erases the whole content of the layer (makes it fully transparent).
     * This method does not change any other attribute of the layer.
     * To reinitialize the layer attributes to defaults settings, use the method
     * reset() instead.
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function clear()
    {
        return $this->command_flush('x');
    }

    /**
     * Selects the pen color for all subsequent drawing functions,
     * including text drawing. The pen color is provided as an RGB value.
     * For grayscale or monochrome displays, the value is
     * automatically converted to the proper range.
     * 
     * @param color: the desired pen color, as a 24-bit RGB value
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function selectColorPen($int_color)
    {
        return $this->command_push(sprintf('c%06x',$int_color));
    }

    /**
     * Selects the pen gray level for all subsequent drawing functions,
     * including text drawing. The gray level is provided as a number between
     * 0 (black) and 255 (white, or whichever the lighest color is).
     * For monochrome displays (without gray levels), any value
     * lower than 128 is rendered as black, and any value equal
     * or above to 128 is non-black.
     * 
     * @param graylevel: the desired gray level, from 0 to 255
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function selectGrayPen($int_graylevel)
    {
        return $this->command_push(sprintf('g%d',$int_graylevel));
    }

    /**
     * Selects an eraser instead of a pen for all subsequent drawing functions,
     * except for text drawing and bitmap copy functions. Any point drawn
     * using the eraser becomes transparent (as when the layer is empty),
     * showing the other layers beneath it.
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function selectEraser()
    {
        return $this->command_push('e');
    }

    /**
     * Enables or disables anti-aliasing for drawing oblique lines and circles.
     * Anti-aliasing provides a smoother aspect when looked from far enough,
     * but it can add fuzzyness when the display is looked from very close.
     * At the end of the day, it is your personal choice.
     * Anti-aliasing is enabled by default on grayscale and color displays,
     * but you can disable it if you prefer. This setting has no effect
     * on monochrome displays.
     * 
     * @param mode: <t>true</t> to enable antialiasing, <t>false</t> to
     *         disable it.
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function setAntialiasingMode($bool_mode)
    {
        return $this->command_push(sprintf('a%d',$bool_mode));
    }

    /**
     * Draws a single pixel at the specified position.
     * 
     * @param x: the distance from left of layer, in pixels
     * @param y: the distance from top of layer, in pixels
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function drawPixel($int_x,$int_y)
    {
        return $this->command_flush(sprintf('P%d,%d',$int_x,$int_y));
    }

    /**
     * Draws an empty rectangle at a specified position.
     * 
     * @param x1: the distance from left of layer to the left border of the rectangle, in pixels
     * @param y1: the distance from top of layer to the top border of the rectangle, in pixels
     * @param x2: the distance from left of layer to the right border of the rectangle, in pixels
     * @param y2: the distance from top of layer to the bottom border of the rectangle, in pixels
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function drawRect($int_x1,$int_y1,$int_x2,$int_y2)
    {
        return $this->command_flush(sprintf('R%d,%d,%d,%d',$int_x1,$int_y1,$int_x2,$int_y2));
    }

    /**
     * Draws a filled rectangular bar at a specified position.
     * 
     * @param x1: the distance from left of layer to the left border of the rectangle, in pixels
     * @param y1: the distance from top of layer to the top border of the rectangle, in pixels
     * @param x2: the distance from left of layer to the right border of the rectangle, in pixels
     * @param y2: the distance from top of layer to the bottom border of the rectangle, in pixels
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function drawBar($int_x1,$int_y1,$int_x2,$int_y2)
    {
        return $this->command_flush(sprintf('B%d,%d,%d,%d',$int_x1,$int_y1,$int_x2,$int_y2));
    }

    /**
     * Draws an empty circle at a specified position.
     * 
     * @param x: the distance from left of layer to the center of the circle, in pixels
     * @param y: the distance from top of layer to the center of the circle, in pixels
     * @param r: the radius of the circle, in pixels
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function drawCircle($int_x,$int_y,$int_r)
    {
        return $this->command_flush(sprintf('C%d,%d,%d',$int_x,$int_y,$int_r));
    }

    /**
     * Draws a filled disc at a given position.
     * 
     * @param x: the distance from left of layer to the center of the disc, in pixels
     * @param y: the distance from top of layer to the center of the disc, in pixels
     * @param r: the radius of the disc, in pixels
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function drawDisc($int_x,$int_y,$int_r)
    {
        return $this->command_flush(sprintf('D%d,%d,%d',$int_x,$int_y,$int_r));
    }

    /**
     * Selects a font to use for the next text drawing functions, by providing the name of the
     * font file. You can use a built-in font as well as a font file that you have previously
     * uploaded to the device built-in memory. If you experience problems selecting a font
     * file, check the device logs for any error message such as missing font file or bad font
     * file format.
     * 
     * @param fontname: the font file name
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function selectFont($str_fontname)
    {
        return $this->command_push(sprintf('&%s%c',$str_fontname,27));
    }

    /**
     * Draws a text string at the specified position. The point of the text that is aligned
     * to the specified pixel position is called the anchor point, and can be chosen among
     * several options. Text is rendered from left to right, without implicit wrapping.
     * 
     * @param x: the distance from left of layer to the text ancor point, in pixels
     * @param y: the distance from top of layer to the text ancor point, in pixels
     * @param anchor: the text anchor point, chosen among the Y_ALIGN enumeration:
     *         Y_ALIGN_TOP_LEFT,    Y_ALIGN_CENTER_LEFT,    Y_ALIGN_BASELINE_LEFT,    Y_ALIGN_BOTTOM_LEFT,
     *         Y_ALIGN_TOP_CENTER,  Y_ALIGN_CENTER,         Y_ALIGN_BASELINE_CENTER,  Y_ALIGN_BOTTOM_CENTER,
     *         Y_ALIGN_TOP_DECIMAL, Y_ALIGN_CENTER_DECIMAL, Y_ALIGN_BASELINE_DECIMAL, Y_ALIGN_BOTTOM_DECIMAL,
     *         Y_ALIGN_TOP_RIGHT,   Y_ALIGN_CENTER_RIGHT,   Y_ALIGN_BASELINE_RIGHT,   Y_ALIGN_BOTTOM_RIGHT.
     * @param text: the text string to draw
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function drawText($int_x,$int_y,$enumAlign_anchor,$str_text)
    {
        return $this->command_flush(sprintf('T%d,%d,%d,%s%c',$int_x,$int_y,$enumAlign_anchor,$str_text,27));
    }

    /**
     * Draws a GIF image at the specified position. The GIF image must have been previously
     * uploaded to the device built-in memory. If you experience problems using an image
     * file, check the device logs for any error message such as missing image file or bad
     * image file format.
     * 
     * @param x: the distance from left of layer to the left of the image, in pixels
     * @param y: the distance from top of layer to the top of the image, in pixels
     * @param imagename: the GIF file name
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function drawImage($int_x,$int_y,$str_imagename)
    {
        return $this->command_flush(sprintf('*%d,%d,%s%c',$int_x,$int_y,$str_imagename,27));
        
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
     * @param x: the distance from left of layer to the left of the bitmap, in pixels
     * @param y: the distance from top of layer to the top of the bitmap, in pixels
     * @param w: the width of the bitmap, in pixels
     * @param bitmap: a binary object
     * @param bgcol: the background gray level to use for zero bits (0 = black,
     *         255 = white), or -1 to leave the pixels unchanged
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function drawBitmap($int_x,$int_y,$int_w,$bin_bitmap,$int_bgcol)
    {
        // $destname is a str;
        $destname = sprintf('layer%d:%d,%d@%d,%d',$this->_id,$int_w,$int_bgcol,$int_x,$int_y);
        return $this->_display->upload($destname,$bin_bitmap);
        
    }

    /**
     * Moves the drawing pointer of this layer to the specified position.
     * 
     * @param x: the distance from left of layer, in pixels
     * @param y: the distance from top of layer, in pixels
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function moveTo($int_x,$int_y)
    {
        return $this->command_push(sprintf('@%d,%d',$int_x,$int_y));
    }

    /**
     * Draws a line from current drawing pointer position to the specified position.
     * The specified destination pixel is included in the line. The pointer position
     * is then moved to the end point of the line.
     * 
     * @param x: the distance from left of layer to the end point of the line, in pixels
     * @param y: the distance from top of layer to the end point of the line, in pixels
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function lineTo($int_x,$int_y)
    {
        return $this->command_flush(sprintf('-%d,%d',$int_x,$int_y));
    }

    /**
     * Outputs a message in the console area, and advances the console pointer accordingly.
     * The console pointer position is automatically moved to the beginning
     * of the next line when a newline character is met, or when the right margin
     * is hit. When the new text to display extends below the lower margin, the
     * console area is automatically scrolled up.
     * 
     * @param text: the message to display
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function consoleOut($str_text)
    {
        return $this->command_flush(sprintf('!%s%c',$str_text,27));
    }

    /**
     * Sets up display margins for the consoleOut function.
     * 
     * @param x1: the distance from left of layer to the left margin, in pixels
     * @param y1: the distance from top of layer to the top margin, in pixels
     * @param x2: the distance from left of layer to the right margin, in pixels
     * @param y2: the distance from top of layer to the bottom margin, in pixels
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function setConsoleMargins($int_x1,$int_y1,$int_x2,$int_y2)
    {
        return $this->command_push(sprintf('m%d,%d,%d,%d',$int_x1,$int_y1,$int_x2,$int_y2)); 
        
    }

    /**
     * Sets up the background color used by the clearConsole function and by
     * the console scrolling feature.
     * 
     * @param bgcol: the background gray level to use when scrolling (0 = black,
     *         255 = white), or -1 for transparent
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function setConsoleBackground($int_bgcol)
    {
        return $this->command_push(sprintf('b%d',$int_bgcol)); 
        
    }

    /**
     * Sets up the wrapping behaviour used by the consoleOut function.
     * 
     * @param wordwrap: true to wrap only between words,
     *         false to wrap on the last column anyway.
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function setConsoleWordWrap($bool_wordwrap)
    {
        return $this->command_push(sprintf('w%d',$bool_wordwrap)); 
        
    }

    /**
     * Blanks the console area within console margins, and resets the console pointer
     * to the upper left corner of the console.
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function clearConsole()
    {
        return $this->command_flush('^');
    }

    /**
     * Sets the position of the layer relative to the display upper left corner.
     * When smooth scrolling is used, the display offset of the layer is
     * automatically updated during the next milliseconds to animate the move of the layer.
     * 
     * @param x: the distance from left of display to the upper left corner of the layer
     * @param y: the distance from top of display to the upper left corner of the layer
     * @param scrollTime: number of milliseconds to use for smooth scrolling, or
     *         0 if the scrolling should be immediate.
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function setLayerPosition($int_x,$int_y,$int_scrollTime)
    {
        return $this->command_flush(sprintf('#%d,%d,%d',$int_x,$int_y,$int_scrollTime)); 
        
    }

    /**
     * Hides the layer. The state of the layer is perserved but the layer is not displayed
     * on the screen until the next call to unhide(). Hiding the layer can positively
     * affect the drawing speed, since it postpones the rendering until all operations are
     * completed (double-buffering).
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function hide()
    {
        $this->command_push('h'); 
        $this->_hidden = TRUE; 
        return $this->flush_now(); 
        
    }

    /**
     * Shows the layer. Shows the layer again after a hide command.
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function unhide()
    {
        $this->_hidden = FALSE; 
        return $this->command_flush('s'); 
        
    }

    /**
     * Gets parent YDisplay. Returns the parent YDisplay object of the current YDisplayLayer.
     * 
     * @return an YDisplay object
     */
    public function get_display()
    {
        return $this->_display; 
        
    }

    /**
     * Returns the display width, in pixels.
     * 
     * @return an integer corresponding to the display width, in pixels
     * 
     * On failure, throws an exception or returns Y_DISPLAYWIDTH_INVALID.
     */
    public function get_displayWidth()
    {
        return $this->_display->get_displayWidth();
        
    }

    /**
     * Returns the display height, in pixels.
     * 
     * @return an integer corresponding to the display height, in pixels
     * 
     * On failure, throws an exception or returns Y_DISPLAYHEIGHT_INVALID.
     */
    public function get_displayHeight()
    {
        return $this->_display->get_displayHeight();
        
    }

    /**
     * Returns the width of the layers to draw on, in pixels.
     * 
     * @return an integer corresponding to the width of the layers to draw on, in pixels
     * 
     * On failure, throws an exception or returns Y_LAYERWIDTH_INVALID.
     */
    public function get_layerWidth()
    {
        return $this->_display->get_layerWidth();
        
    }

    /**
     * Returns the height of the layers to draw on, in pixels.
     * 
     * @return an integer corresponding to the height of the layers to draw on, in pixels
     * 
     * On failure, throws an exception or returns Y_LAYERHEIGHT_INVALID.
     */
    public function get_layerHeight()
    {
        return $this->_display->get_layerHeight();
        
    }

    public function resetHiddenFlag()
    {
        $this->_hidden = FALSE; 
        return YAPI_SUCCESS;
        
    }

    //--- (end of generated code: YDisplayLayer implementation)
};

/**
 * YDisplay Class: Display function interface
 * 
 * Yoctopuce display interface has been designed to eaasily
 * show information and images. The device provides built-in
 * multi-layer rendering. Layers can be drawn offline, individually,
 * and freely moved on the display.
 */
class YDisplay extends YFunction
{
    private $_allDisplayLayers;
    private $_recording;
    private $_sequence;
    
    //--- (generated code: YDisplay implementation)
    const LOGICALNAME_INVALID = Y_INVALID_STRING;
    const ADVERTISEDVALUE_INVALID = Y_INVALID_STRING;
    const POWERSTATE_OFF = 0;
    const POWERSTATE_ON = 1;
    const POWERSTATE_INVALID = -1;
    const STARTUPSEQ_INVALID = Y_INVALID_STRING;
    const BRIGHTNESS_INVALID = Y_INVALID_UNSIGNED;
    const ORIENTATION_LEFT = 0;
    const ORIENTATION_UP = 1;
    const ORIENTATION_RIGHT = 2;
    const ORIENTATION_DOWN = 3;
    const ORIENTATION_INVALID = -1;
    const DISPLAYWIDTH_INVALID = Y_INVALID_UNSIGNED;
    const DISPLAYHEIGHT_INVALID = Y_INVALID_UNSIGNED;
    const DISPLAYTYPE_MONO = 0;
    const DISPLAYTYPE_GRAY = 1;
    const DISPLAYTYPE_RGB = 2;
    const DISPLAYTYPE_INVALID = -1;
    const LAYERWIDTH_INVALID = Y_INVALID_UNSIGNED;
    const LAYERHEIGHT_INVALID = Y_INVALID_UNSIGNED;
    const LAYERCOUNT_INVALID = Y_INVALID_UNSIGNED;
    const COMMAND_INVALID = Y_INVALID_STRING;

    /**
     * Returns the logical name of the display.
     * 
     * @return a string corresponding to the logical name of the display
     * 
     * On failure, throws an exception or returns Y_LOGICALNAME_INVALID.
     */
    public function get_logicalName()
    {   $json_val = $this->_getAttr("logicalName");
        return (is_null($json_val) ? Y_LOGICALNAME_INVALID : $json_val);
    }

    /**
     * Changes the logical name of the display. You can use yCheckLogicalName()
     * prior to this call to make sure that your parameter is valid.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     * 
     * @param newval : a string corresponding to the logical name of the display
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
     * Returns the current value of the display (no more than 6 characters).
     * 
     * @return a string corresponding to the current value of the display (no more than 6 characters)
     * 
     * On failure, throws an exception or returns Y_ADVERTISEDVALUE_INVALID.
     */
    public function get_advertisedValue()
    {   $json_val = $this->_getAttr("advertisedValue");
        return (is_null($json_val) ? Y_ADVERTISEDVALUE_INVALID : $json_val);
    }

    /**
     * Returns the power state of the display.
     * 
     * @return either Y_POWERSTATE_OFF or Y_POWERSTATE_ON, according to the power state of the display
     * 
     * On failure, throws an exception or returns Y_POWERSTATE_INVALID.
     */
    public function get_powerState()
    {   $json_val = $this->_getAttr("powerState");
        return (is_null($json_val) ? Y_POWERSTATE_INVALID : intval($json_val));
    }

    /**
     * Changes the power state of the display.
     * 
     * @param newval : either Y_POWERSTATE_OFF or Y_POWERSTATE_ON, according to the power state of the display
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_powerState($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("powerState",$rest_val);
    }

    /**
     * Returns the name of the sequence to play when the displayed is powered on.
     * 
     * @return a string corresponding to the name of the sequence to play when the displayed is powered on
     * 
     * On failure, throws an exception or returns Y_STARTUPSEQ_INVALID.
     */
    public function get_startupSeq()
    {   $json_val = $this->_getAttr("startupSeq");
        return (is_null($json_val) ? Y_STARTUPSEQ_INVALID : $json_val);
    }

    /**
     * Changes the name of the sequence to play when the displayed is powered on.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     * 
     * @param newval : a string corresponding to the name of the sequence to play when the displayed is powered on
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_startupSeq($newval)
    {
        $rest_val = $newval;
        return $this->_setAttr("startupSeq",$rest_val);
    }

    /**
     * Returns the luminosity of the  module informative leds (from 0 to 100).
     * 
     * @return an integer corresponding to the luminosity of the  module informative leds (from 0 to 100)
     * 
     * On failure, throws an exception or returns Y_BRIGHTNESS_INVALID.
     */
    public function get_brightness()
    {   $json_val = $this->_getAttr("brightness");
        return (is_null($json_val) ? Y_BRIGHTNESS_INVALID : intval($json_val));
    }

    /**
     * Changes the brightness of the display. The parameter is a value between 0 and
     * 100. Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     * 
     * @param newval : an integer corresponding to the brightness of the display
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_brightness($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("brightness",$rest_val);
    }

    /**
     * Returns the currently selected display orientation.
     * 
     * @return a value among Y_ORIENTATION_LEFT, Y_ORIENTATION_UP, Y_ORIENTATION_RIGHT and
     * Y_ORIENTATION_DOWN corresponding to the currently selected display orientation
     * 
     * On failure, throws an exception or returns Y_ORIENTATION_INVALID.
     */
    public function get_orientation()
    {   $json_val = $this->_getAttr("orientation");
        return (is_null($json_val) ? Y_ORIENTATION_INVALID : intval($json_val));
    }

    /**
     * Changes the display orientation. Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     * 
     * @param newval : a value among Y_ORIENTATION_LEFT, Y_ORIENTATION_UP, Y_ORIENTATION_RIGHT and
     * Y_ORIENTATION_DOWN corresponding to the display orientation
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_orientation($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("orientation",$rest_val);
    }

    /**
     * Returns the display width, in pixels.
     * 
     * @return an integer corresponding to the display width, in pixels
     * 
     * On failure, throws an exception or returns Y_DISPLAYWIDTH_INVALID.
     */
    public function get_displayWidth()
    {   $json_val = $this->_getAttr("displayWidth");
        return (is_null($json_val) ? Y_DISPLAYWIDTH_INVALID : intval($json_val));
    }

    /**
     * Returns the display height, in pixels.
     * 
     * @return an integer corresponding to the display height, in pixels
     * 
     * On failure, throws an exception or returns Y_DISPLAYHEIGHT_INVALID.
     */
    public function get_displayHeight()
    {   $json_val = $this->_getAttr("displayHeight");
        return (is_null($json_val) ? Y_DISPLAYHEIGHT_INVALID : intval($json_val));
    }

    /**
     * Returns the display type: monochrome, gray levels or full color.
     * 
     * @return a value among Y_DISPLAYTYPE_MONO, Y_DISPLAYTYPE_GRAY and Y_DISPLAYTYPE_RGB corresponding to
     * the display type: monochrome, gray levels or full color
     * 
     * On failure, throws an exception or returns Y_DISPLAYTYPE_INVALID.
     */
    public function get_displayType()
    {   $json_val = $this->_getFixedAttr("displayType");
        return (is_null($json_val) ? Y_DISPLAYTYPE_INVALID : intval($json_val));
    }

    /**
     * Returns the width of the layers to draw on, in pixels.
     * 
     * @return an integer corresponding to the width of the layers to draw on, in pixels
     * 
     * On failure, throws an exception or returns Y_LAYERWIDTH_INVALID.
     */
    public function get_layerWidth()
    {   $json_val = $this->_getFixedAttr("layerWidth");
        return (is_null($json_val) ? Y_LAYERWIDTH_INVALID : intval($json_val));
    }

    /**
     * Returns the height of the layers to draw on, in pixels.
     * 
     * @return an integer corresponding to the height of the layers to draw on, in pixels
     * 
     * On failure, throws an exception or returns Y_LAYERHEIGHT_INVALID.
     */
    public function get_layerHeight()
    {   $json_val = $this->_getFixedAttr("layerHeight");
        return (is_null($json_val) ? Y_LAYERHEIGHT_INVALID : intval($json_val));
    }

    /**
     * Returns the number of available layers to draw on.
     * 
     * @return an integer corresponding to the number of available layers to draw on
     * 
     * On failure, throws an exception or returns Y_LAYERCOUNT_INVALID.
     */
    public function get_layerCount()
    {   $json_val = $this->_getFixedAttr("layerCount");
        return (is_null($json_val) ? Y_LAYERCOUNT_INVALID : intval($json_val));
    }

    public function get_command()
    {   $json_val = $this->_getAttr("command");
        return (is_null($json_val) ? Y_COMMAND_INVALID : $json_val);
    }

    public function set_command($newval)
    {
        $rest_val = $newval;
        return $this->_setAttr("command",$rest_val);
    }

    /**
     * Clears the display screen and resets all display layers to their default state.
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function resetAll()
    {
        $this->flushLayers(); 
        $this->resetHiddenLayerFlags();
        return $this->sendCommand('Z'); 
        
    }

    /**
     * Smoothly changes the brightness of the screen to produce a fade-in or fade-out
     * effect.
     * 
     * @param brightness: the new screen brightness
     * @param duration: duration of the brightness transition, in milliseconds.
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function fade($int_brightness,$int_duration)
    {
        $this->flushLayers(); 
        return $this->sendCommand(sprintf('+%d,%d',$int_brightness,$int_duration)); 
        
    }

    /**
     * Starts to record all display commands into a sequence, for later replay.
     * The name used to store the sequence is specified when calling
     * saveSequence(), once the recording is complete.
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function newSequence()
    {
        $this->flushLayers();
        $this->_sequence = ''; 
        $this->_recording = TRUE; 
        return YAPI_SUCCESS; 
        
    }

    /**
     * Stops recording display commands and saves the sequence into the specified
     * file on the display internal memory. The sequence can be later replayed
     * using playSequence().
     * 
     * @param sequenceName : the name of the newly created sequence
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function saveSequence($str_sequenceName)
    {
        $this->flushLayers();
        $this->_recording = FALSE; 
        $this->_upload($str_sequenceName, $this->_sequence);
        //We need to use YPRINTF("") for Objective-C 
        $this->_sequence = sprintf(''); 
        return YAPI_SUCCESS; 
        
    }

    /**
     * Replays a display sequence previously recorded using
     * newSequence() and saveSequence().
     * 
     * @param sequenceName : the name of the newly created sequence
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function playSequence($str_sequenceName)
    {
        $this->flushLayers();
        return $this->sendCommand(sprintf('S%s',$str_sequenceName)); 
        
    }

    /**
     * Waits for a specified delay (in milliseconds) before playing next
     * commands in current sequence. This method can be used while
     * recording a display sequence, to insert a timed wait in the sequence
     * (without any immediate effect). It can also be used dynamically while
     * playing a pre-recorded sequence, to suspend or resume the execution of
     * the sequence. To cancel a delay, call the same method with a zero delay.
     * 
     * @param delay_ms : the duration to wait, in milliseconds
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function pauseSequence($int_delay_ms)
    {
        $this->flushLayers(); 
        return $this->sendCommand(sprintf('W%d',$int_delay_ms)); 
        
    }

    /**
     * Stops immediately any ongoing sequence replay.
     * The display is left as is.
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function stopSequence()
    {
        $this->flushLayers();
        return $this->sendCommand('S'); 
        
    }

    /**
     * Uploads an arbitrary file (for instance a GIF file) to the display, to the
     * specified full path name. If a file already exists with the same path name,
     * its content is overwritten.
     * 
     * @param pathname : path and name of the new file to create
     * @param content : binary buffer with the content to set
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function upload($str_pathname,$bin_content)
    {
        return $this->_upload($str_pathname,$bin_content);
        
    }

    /**
     * Copies the whole content of a layer to another layer. The color and transparency
     * of all the pixels from the destination layer are set to match the source pixels.
     * This method only affects the displayed content, but does not change any
     * property of the layer object.
     * Note that layer 0 has no transparency support (it is always completely opaque).
     * 
     * @param srcLayerId : the identifier of the source layer (a number in range 0..layerCount-1)
     * @param dstLayerId : the identifier of the destination layer (a number in range 0..layerCount-1)
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function copyLayerContent($int_srcLayerId,$int_dstLayerId)
    {
        $this->flushLayers(); 
        return $this->sendCommand(sprintf('o%d,%d',$int_srcLayerId,$int_dstLayerId)); 
        
    }

    /**
     * Swaps the whole content of two layers. The color and transparency of all the pixels from
     * the two layers are swapped. This method only affects the displayed content, but does
     * not change any property of the layer objects. In particular, the visibility of each
     * layer stays unchanged. When used between onae hidden layer and a visible layer,
     * this method makes it possible to easily implement double-buffering.
     * Note that layer 0 has no transparency support (it is always completely opaque).
     * 
     * @param layerIdA : the first layer (a number in range 0..layerCount-1)
     * @param layerIdB : the second layer (a number in range 0..layerCount-1)
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function swapLayerContent($int_layerIdA,$int_layerIdB)
    {
        $this->flushLayers(); 
        return $this->sendCommand(sprintf('E%d,%d',$int_layerIdA,$int_layerIdB)); 
        
    }

    public function logicalName()
    { return get_logicalName(); }

    public function setLogicalName($newval)
    { return set_logicalName($newval); }

    public function advertisedValue()
    { return get_advertisedValue(); }

    public function powerState()
    { return get_powerState(); }

    public function setPowerState($newval)
    { return set_powerState($newval); }

    public function startupSeq()
    { return get_startupSeq(); }

    public function setStartupSeq($newval)
    { return set_startupSeq($newval); }

    public function brightness()
    { return get_brightness(); }

    public function setBrightness($newval)
    { return set_brightness($newval); }

    public function orientation()
    { return get_orientation(); }

    public function setOrientation($newval)
    { return set_orientation($newval); }

    public function displayWidth()
    { return get_displayWidth(); }

    public function displayHeight()
    { return get_displayHeight(); }

    public function displayType()
    { return get_displayType(); }

    public function layerWidth()
    { return get_layerWidth(); }

    public function layerHeight()
    { return get_layerHeight(); }

    public function layerCount()
    { return get_layerCount(); }

    public function command()
    { return get_command(); }

    public function setCommand($newval)
    { return set_command($newval); }

    /**
     * Continues the enumeration of displays started using yFirstDisplay().
     * 
     * @return a pointer to a YDisplay object, corresponding to
     *         a display currently online, or a null pointer
     *         if there are no more displays to enumerate.
     */
    public function nextDisplay()
    {   $next_hwid = YAPI::getNextHardwareId($this->_className, $this->_func);
        if($next_hwid == null) return null;
        return yFindDisplay($next_hwid);
    }

    /**
     * Retrieves a display for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     * 
     * This function does not require that the display is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YDisplay.isOnline() to test if the display is
     * indeed online at a given time. In case of ambiguity when looking for
     * a display by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     * 
     * @param func : a string that uniquely characterizes the display
     * 
     * @return a YDisplay object allowing you to drive the display.
     */
    public static function FindDisplay($str_func)
    {   $obj_func = YAPI::getFunction('Display', $str_func);
        if($obj_func) return $obj_func;
        return new YDisplay($str_func);
    }

    /**
     * Starts the enumeration of displays currently accessible.
     * Use the method YDisplay.nextDisplay() to iterate on
     * next displays.
     * 
     * @return a pointer to a YDisplay object, corresponding to
     *         the first display currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstDisplay()
    {   $next_hwid = YAPI::getFirstHardwareId('Display');
        if($next_hwid == null) return null;
        return self::FindDisplay($next_hwid);
    }

    //--- (end of generated code: YDisplay implementation)

    function __construct($str_func)
    {
        //--- (generated code: YDisplay constructor)
        parent::__construct('Display', $str_func);
        //--- (end of generated code: YDisplay constructor)
        $this->_recording  = FALSE;
        $this->_sequence   = '';
    }

    /**
     * Returns a YDisplayLayer object that can be used to draw on the specified
     * layer. The content is displayed only when the layer is active on the
     * screen (and not masked by other overlapping layers).
     * 
     * @param layerId : the identifier of the layer (a number in range 0..layerCount-1)
     * 
     * @return an YDisplayLayer object
     * 
     * On failure, throws an exception or returns null.
     */
    public function get_displayLayer($layerId)
    {
        if ( is_null($this->_allDisplayLayers)) {
            $layercount = $this->get_layerCount();
            $this->_allDisplayLayers = array();
            for($i=0; $i < $layercount; $i++) {
                $this->_allDisplayLayers[$i] = new YDisplayLayer($this, $i);
            }
        }
        if(!isset($this->_allDisplayLayers[$layerId])) {
            $this->_throw(YAPI_INVALID_ARGUMENT, "Invalid layerId", null);
        }
        return $this->_allDisplayLayers[$layerId];
    }

    /**
     * Force a flush of all commands buffered by all layers.
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function flushLayers()
    {
        if( !is_null($this->_allDisplayLayers)) {
            foreach ($this->_allDisplayLayers as $layer) {
                $layer->flush_now();
            }
        }
        return YAPI_SUCCESS;
    }
    
    public function resetHiddenLayerFlags()
    {
        if( !is_null($this->_allDisplayLayers)) {
            foreach ($this->_allDisplayLayers as $layer) {
                $layer->resetHiddenFlag();
            }
        }
    }

    /**
     * Add a given command string to the currently recorded display sequence
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function sendCommand($str_cmd)
    {
        if(!$this->_recording) {
            return $this->set_command($str_cmd); 
        }
        $this->_sequence .= str_replace("\n", "\x0b", $str_cmd)."\n";
        return YAPI_SUCCESS;
    }
};

//--- (generated code: Display functions)

/**
 * Retrieves a display for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 * 
 * This function does not require that the display is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YDisplay.isOnline() to test if the display is
 * indeed online at a given time. In case of ambiguity when looking for
 * a display by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 * 
 * @param func : a string that uniquely characterizes the display
 * 
 * @return a YDisplay object allowing you to drive the display.
 */
function yFindDisplay($str_func)
{
    return YDisplay::FindDisplay($str_func);
}

/**
 * Starts the enumeration of displays currently accessible.
 * Use the method YDisplay.nextDisplay() to iterate on
 * next displays.
 * 
 * @return a pointer to a YDisplay object, corresponding to
 *         the first display currently online, or a null pointer
 *         if there are none.
 */
function yFirstDisplay()
{
    return YDisplay::FirstDisplay();
}

//--- (end of generated code: Display functions)
?>