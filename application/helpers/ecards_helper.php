<?php

/**
 * lnk helps return anchor tag with class when current_url() is site_url($match)
 *
 * @param  string $url   Your link inside the application, not for outside links
 * @param  string $text  Link text
 * @param  string $match What url to match against, use like $url
 * @param  string $class What class should be added if urls match
 *
 * @author Ismo Vuorinen <ismo.vuorinen@tampere.fi>
 *
 * @return string        Formatted anchor tag with everything needed
 */
function lnk($url = null, $text = null, $match = null, $class = ' active')
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
        return '<a class="' . $class . '" href="' . $url . '">' . $text . '</a>';
    } else {
        return '<a href="'. $url .'">' . $text . '</a>';
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
