<?php

/**
 * lnk helps return anchor tag with class when current_url() is site_url($match)
 *
 * @param  string $url        Your link inside the application, not for outside links
 * @param  string $text       Link text
 * @param  string $baseclass  What classes should be included
 * @param  string $match      What url to match against, use like $url
 * @param  string $class      What class should be added if urls match
 *
 * @author Ismo Vuorinen <ismo.vuorinen@tampere.fi>
 *
 * @return string        Formatted anchor tag with everything needed
 */
function lnk($url = null, $text = null, $baseclass = '', $match = null, $class = ' active')
{
    // $url should be "controller/action", no need to give full url
    $url = site_url($url);

    // Test matching, are we on the page we want to match against?
    if (empty($match)) {
        $match = current_url();
    } else {
        $match = site_url($match);
    }

    // Return correctly formatted link
    if ($url == $match) {
        return '<a class="' . $baseclass . $class . '" href="' . $url . '">' . $text . '</a>';
    } else {
        if (! empty($baseclass)) {
            $baseclass = 'class="' . $baseclass . '" ';
        }
        return '<a ' . $baseclass . 'href="'. $url .'">' . $text . '</a>';
    }
}

function checkboxed(
    $name,
    $data,
    $value,
    $label,
    $data_id = null,
    $disabled = false,
    $disabletext = null
) {
    $fieldname = null;
    $labelname = null;
    $string    = null;

    $fieldname = 'data['.$data_id.']['.$name.']';
    $labelname = $fieldname .'['. $data .']';

    $string =   '<input type="radio" '
            .   'name="' . $fieldname .'" '
            .   'id="'   . $labelname . '" '
            .   'value="'. $value.'"';

    if ($data == $value) {
        $string .= ' checked';
    }

    if (empty($disabletext)) {
        $disabletext = 'Ei voida julkaista lähettäjän päätöksestä';
    }

    if ($disabled) {
        $string .= ' disabled';
        $label   = '<span data-tooltip class="has-tip tip-top" '
                .  'data-width="180" title="' . $disabletext . '">' . $label . '</span>';
    }

    $string .=  '>';

    if (!empty($label)) {
        $string = '<label>' . $string . $label . '</label>';
    }

    return $string;
}

/*
 * imagettftextblur v1.0.0
 *
 * Copyright (c) 2013 Andrew G. Johnson  <andrew@andrewgjohnson.com>
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following conditions:
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,
 * DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR
 * OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR
 * THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * @author Andrew G. Johnson <andrew@andrewgjohnson.com>
 * @copyright Copyright (c) 2013 Andrew G. Johnson <andrew@andrewgjohnson.com>
 * @link http://github.com/andrewgjohnson/imagettftextblur
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 * @version 1.0.0
 * @package imagettftextblur
 *
 */
if (!function_exists('imagettftextblur')) {

    /**
     * imagettftextblur
     *
     * @author Andrew G. Johnson <andrew@andrewgjohnson.com>
     * @link   http://github.com/andrewgjohnson/imagettftextblur
     *
     * @param  resource $image          Image resource
     * @param  integer  $size           Font size
     * @param  integer  $angle          Text angle
     * @param  integer  $x              First letter x cordinate
     * @param  integer  $y              First letter baseline y cordinate
     * @param  integer  $color          Color index
     * @param  string   $fontfile       Path to font file (.ttf)
     * @param  string   $text           Text on image
     * @param  integer  $blur_intensity Blur intensity, more the blurrier
     * @return [type]                   [description]
     */
    function imagettftextblur(
        &$image,
        $size,
        $angle,
        $x,
        $y,
        $color,
        $fontfile,
        $text,
        $blur_intensity = null
    ) {
        $blur_intensity = !is_null($blur_intensity) && is_numeric($blur_intensity)
                                ? (int)$blur_intensity : 0;
        if ($blur_intensity > 0) {
            $text_shadow_image = imagecreatetruecolor(
                imagesx($image),
                imagesy($image)
            );
            imagefill(
                $text_shadow_image,
                0,
                0,
                imagecolorallocate(
                    $text_shadow_image,
                    0x00,
                    0x00,
                    0x00
                )
            );
            imagettftext(
                $text_shadow_image,
                $size,
                $angle,
                $x,
                $y,
                imagecolorallocate(
                    $text_shadow_image,
                    0xFF,
                    0xFF,
                    0xFF
                ),
                $fontfile,
                $text
            );
            for ($blur = 1; $blur <= $blur_intensity; $blur++) {
                imagefilter($text_shadow_image, IMG_FILTER_GAUSSIAN_BLUR);
            }
            for ($x_offset = 0; $x_offset < imagesx($text_shadow_image); $x_offset++) {
                for ($y_offset = 0; $y_offset < imagesy($text_shadow_image); $y_offset++) {
                    $visibility = (imagecolorat($text_shadow_image, $x_offset, $y_offset) & 0xFF) / 255;
                    if ($visibility > 0) {
                        imagesetpixel(
                            $image,
                            $x_offset,
                            $y_offset,
                            imagecolorallocatealpha(
                                $image,
                                ($color >> 16) & 0xFF,
                                ($color >> 8) & 0xFF,
                                $color & 0xFF,
                                (1 - $visibility) * 127
                            )
                        );
                    }

                }
            }
            imagedestroy($text_shadow_image);
        } else {
            return imagettftext(
                $image,
                $size,
                $angle,
                $x,
                $y,
                $color,
                $fontfile,
                $text
            );
        }

    }
}

function fetchBaseCards($from = null)
{
    if (empty($from)) {
        $from = APPPATH . '../assets/basecards/';
    }
    $map = directory_map($from, 1);

    if (! empty($map)) {
        $images = array();
        foreach ($map as $image) {
            $images[] = site_url('assets/basecards/' . $image);
        }
    } else {
        return false;
    }

    return $images;
}

function footerAssets()
{
    $assets = array(
        'jquery.min.js',
        'custom.modernizr.min.js',  // Foundation flavored Modernizr
        'foundation.min.js',        // Foundation 1.4.1
        'image-picker.min.js',      // Image Picker 0.1.4
        'jquery.validate.min.js',   // jQuery Validation Plugin 1.11.1
        'additional-methods.min.js',// jQuery Validation Methods
        'messages_fi.js',           // jQuery Validation Plugin Finnish translation
        'jquery-ui.min.js',         // jQuery UI 1.10.3
        'scripts.js'                // Our scripts
    );

    if (ENVIRONMENT == 'development') {
        $assets[] = 'dev.js';
    }

    return $assets;
}

function calculateTextBox($text = '', $fontFile = null, $fontSize = null, $fontAngle = 0)
{
    /************
    simple function that calculates the *exact* bounding box (single pixel precision).
    The function returns an associative array with these keys:
    left, top:  coordinates you will pass to imagettftext
    width, height: dimension of the image you have to create
    *************/
    $rect = imagettfbbox($fontSize, $fontAngle, $fontFile, $text);
    $minX = min(array($rect[0], $rect[2], $rect[4], $rect[6]));
    $maxX = max(array($rect[0], $rect[2], $rect[4], $rect[6]));
    $minY = min(array($rect[1], $rect[3], $rect[5], $rect[7]));
    $maxY = max(array($rect[1], $rect[3], $rect[5], $rect[7]));

    return array(
        "left"   => abs($minX) - 1,
        "top"    => abs($minY) - 1,
        "width"  => $maxX - $minX,
        "height" => $maxY - $minY,
        "box"    => $rect
    );
}

function cardSizeRatio($full_w = 0, $full_h = 0, $prev_w = 0, $prev_h = 0)
{
    $ratio_w = ($full_w/$prev_w);
    $ratio_h = ($full_h/$prev_h);

    $results = array(
        'w'     => $ratio_w,
        'h'     => $ratio_h
    );

    return $results;
}

function parseImageOptions($post)
{
    /*
        $cardPath = null,
        $cardHead = null,
        $cardText = null,
        $cardHeadPlace = array(),
        $cardTextPlace = array(),
        $cardHeadSize = array(),
        $cardTextSize = 0
     */

    /*
        sender_name=Ismo
        sender_email=ismo%40ma.com
        receiver_name=ismo
        receiver_email=ismo%40me.com
        message_title=Moikka+täältä
        message_text=aöslkdjföalkjsdfölakjsdföljk
        sizeOf_message_text_w=381
        sizeOf_message_text_h=18
        sizeOf_message_title_w=381
        sizeOf_message_title_h=30
        placeOf_message_text_y=72
        placeOf_message_text_x=10
        placeOf_message_title_y=20
        placeOf_message_title_x=10
        participate=yes
        publiccard=yes
        submit=Lähetä+eKorttisi%21
        submit=Lähetä+eKorttisi%21
     */

    $message_title = (empty($post['message_title'])) ? '' : $post['message_title'];
    $message_text  = (empty($post['message_text']))  ? '' : $post['message_text'];

    $image_url     = str_replace("-:-", "/", $post['select_image']);

    $card = str_replace(site_url(), FCPATH, $image_url);

    $headerTextFix = -3;
    //$headerTextFix  = 40*(72/96); // 72dpi -> 96dpi, + 5 padding
    $messageTextFix = 28*(72/96) +3; // 72dpi -> 96dpi, + 5 padding

    $opts = array(
        'cardPath'  => $card,
        'cardHead'  => $message_title,
        'cardText'  => $message_text,
        'cardHeadPlace' => array(
            'x' => $post['placeOf_message_title_x'] + 3,
            'y' => $post['placeOf_message_title_y'] + $headerTextFix //20
        ),
        'cardTextPlace' => array(
            'x' => $post['placeOf_message_text_x'] + 3,
            'y' => $post['placeOf_message_text_y'] + $messageTextFix //40
        ),
        'cardHeadSize' => array(
            'w' => $post['sizeOf_message_title_w'],
            'h' => $post['sizeOf_message_title_h']
        ),
        'cardTextSize' => array(
            'w' => $post['sizeOf_message_text_w'],
            'h' => $post['sizeOf_message_text_h']
        ),
        'cardSize' => array(
            'w' => $post['sizeOf_image_w'],
            'h' => $post['sizeOf_image_h']
        )
    );

    return $opts;
}

function parseCardEntryValues($post)
{
    if (empty($post)) {
        return false;
    }
    /*
        sender_name=Ismo
        sender_email=ismo%40ma.com
        receiver_name=ismo
        receiver_email=ismo%40me.com
        message_title=Moikka+täältä
        message_text=aöslkdjföalkjsdfölakjsdföljk
        sizeOf_message_text_w=381
        sizeOf_message_text_h=18
        sizeOf_message_title_w=381
        sizeOf_message_title_h=30
        placeOf_message_text_y=72
        placeOf_message_text_x=10
        placeOf_message_title_y=20
        placeOf_message_title_x=10
        participate=yes
        publiccard=yes
        submit=Lähetä+eKorttisi%21
        submit=Lähetä+eKorttisi%21
     */
    unset($post['submit']);

    $card = str_replace(site_url(), FCPATH, $post['select_image']);

    if ($post['publiccard'] == 'yes') {
        $private = 'no';
    } else {
        $private = 'yes';
    }

    if ($post['participate'] == 'yes') {
        $participate = 'yes';
    } else {
        $participate = 'no';
    }

    $hash = md5(
        $post['sender_name'] .
        $post['sender_email'] .
        $post['message_title'] .
        $post['message_text']
    );

    $values = array(
        // Sender and receiver details
        'uploader_name'           => $post['sender_name'],
        'uploader_email'          => $post['sender_email'],
        'receiver_name'           => $post['receiver_name'],
        'receiver_email'          => $post['receiver_email'],
        // The message on card
        'message_title'           => $post['message_title'],
        'message_content'         => $post['message_text'],
        // Card and message placement details
        'base_card'               => $card,
        'sizeof_message_title_w'  => $post['sizeOf_message_title_w'],
        'sizeof_message_title_h'  => $post['sizeOf_message_title_h'],
        'sizeof_message_text_w'   => $post['sizeOf_message_text_w'],
        'sizeof_message_text_h'   => $post['sizeOf_message_text_h'],
        'placeof_message_title_x' => $post['placeOf_message_title_x'],
        'placeof_message_title_y' => $post['placeOf_message_title_y'] + 30 + 5,
        'placeof_message_text_x'  => $post['placeOf_message_text_x'],
        'placeof_message_text_y'  => $post['placeOf_message_text_y'] + 32 + 25,
        'participate'             => $participate,
        'private'                 => $private,
        'card_status'             => 'queue',
        'hash'                    => $hash
    );

    return $values;
}

/**
 * debug
 * handy little debugging commaind
 *
 * @param mixed   $thing What you want to see
 * @param boolean $show  Should it be visible on page or only on source code
 *
 * @author  Ismo Vuorinen <ismo.vuorinen@rotor.fi>
 * @package Default
 *
 * @return  true Script prints debugged thing, returns true always.
 */
function debug($thing = null, $show = false)
{
    if (ENVIRONMENT != "development") {
        return false;
    }

    // What triggered this?
    $caller = array_shift(debug_backtrace());
    $from   = str_replace(dirname(BASEPATH), '', $caller['file'])
            . '#' . $caller['line'];
    unset($caller);

    if ($show) {
        $start = "\n<pre>";
        $end   = "\n</pre>\n";
    } else {
        $start = "\n<!--\n";
        $end   = "\n-->\n";
    }

    $debug = $start . $from . "\n" . print_r($thing, true) . $end;

    echo $debug;

    return true;
}

