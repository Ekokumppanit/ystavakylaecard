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
