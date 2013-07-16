/* jslint node: true */
jQuery(document).ready(function($) {
   "use strict";

    // Our Foundation trigger
    $(document).foundation();

    // Trigger jQuery validation of ecard creation form
    $('#ecard_form').validate({
        submitHandler: function(form) {
            form.submit();
        }
    });

    // Change jQuery textarea hook default behavior
    $.valHooks.textarea = {
        get: function( elem ) {
            return elem.value.replace( /\r?\n/g, '\r\n' );
        }
    };

    // Our image picker in /uusi
    $('select.image-picker').imagepicker({ hide_select: true });

    // Change the selected image to preview after user input
    $('#ecard_form select#select_image').change(function () {
        var imageurl;
        $('select#select_image option:selected').each(function () {
            imageurl = $(this).data('img-src'); // We get the image url
        });
        $('#previewimage').attr('src', imageurl);
    }).change();

    // Updating the message title preview element
    $('#ecard_form #message_title').keyup(function () {
        var message_title_preview_text;
        message_title_preview_text = $(this).val();
        $('div#message_title_preview').text(message_title_preview_text);
    });

    // Updating the message text preview element
    $('#ecard_form #message_text').keyup(function () {
        var message_text_preview_text;
        message_text_preview_text = $(this).val();
        $('div#message_text_preview').text(message_text_preview_text);
    });

    // Sizing and placement of preview elements
    $('#message_title_preview, #message_text_preview')
        .draggable({
            containment: '#previewpanel',
            scroll: false,
            stop: function(e, ui) {

                if (this.id === 'message_title_preview') {
                    $('#placeOf_message_title_y').val(ui.position.top);
                    $('#placeOf_message_title_x').val(ui.position.left);
                }

                if (this.id === 'message_text_preview') {
                    $('#placeOf_message_text_y').val(ui.position.top);
                    $('#placeOf_message_text_x').val(ui.position.left);
                }
            }
        })
        .resizable({
            containment: '#previewpanel',
            scroll: false,
            stop: function(e, ui) {

                if (this.id === 'message_title_preview') {
                    $('#sizeOf_message_title_w').val(ui.size.width);
                    $('#sizeOf_message_title_h').val(ui.size.height);
                }
                if (this.id === 'message_text_preview') {
                    $('#sizeOf_message_text_w').val(ui.size.width);
                    $('#sizeOf_message_text_h').val(ui.size.height);
                }
            }
        });

    // Set panel height on initiation
    $('#previewpanel').height( $('#previewimage').height() );

    setElementPlaces(); // Populate our image place fields
    checkSizesTimer();  // If we change window size, make everything adjust

    /**
     * checkSizesTimer changes inputs
     * #sizeOf_image_w and #sizeOf_image_h,
     * plus the height of #previewpanel based
     * on the size and location of said elements
     *
     * this helps setting the #previewpanel height
     * and hidden fields we use to build the ecard
     *
     * @author Ismo Vuorinen <ismo.vuorinen@tampere.fi>
     */
    function checkSizesTimer () {
        var previewimage = $('#previewimage');
        var previewpanel = $('#previewpanel');
        var imagesize    = $('#previewimage');


        $('#sizeOf_image_w').val(imagesize.width());
        $('#sizeOf_image_h').val(imagesize.height());

        var previewpanelh = previewpanel.height();
        var previewimageh = previewimage.height();
        if(previewimageh != previewpanelh) {
            previewpanel.height(previewimageh);
        }

        setTimeout(checkSizesTimer, 1000); // Repeat
    }

    /**
     * setElementPlaces sets the values we need
     * after saving the ecard.
     *
     * The position and size of preview elements
     * gets saved to database if positive integers
     */
    function setElementPlaces () {
        var title = $('#message_title_preview');
        var text  = $('#message_text_preview');

        // Title and message preview box position
        // over the chosen image
        var title_p = title.position();
        var text_p  = text.position();

        // Position of elements
        $('#placeOf_message_title_y').val(title_p.top);
        $('#placeOf_message_title_x').val(title_p.left);
        $('#placeOf_message_text_y').val(text_p.top);
        $('#placeOf_message_text_x').val(text_p.left);

        // Size of elements
        $('#sizeOf_message_title_w').val(title.width());
        $('#sizeOf_message_title_h').val(title.height());
        $('#sizeOf_message_text_w').val(text.width());
        $('#sizeOf_message_text_h').val(text.height());

    }

});
