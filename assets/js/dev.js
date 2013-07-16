jQuery(document).ready(function($) {

    /**
     * This is only relevant if we are in development mode.
     * Purpose of this is to provide easy way to test how our
     * image gets made, runs only on development mode.
     *
     * $(".toteutuva .url") is a <small> -field that shows our
     * query to /preview/{querystring}, what in part generates
     * our preview image as $("#previewimage")
     *
     * Both of these can be found in application/views/new.php
     */

    $('.updatepreview').on('click', function () {
        var query = [];
        var img = '/ystavakylaecard/preview/';


        $.each($('#ecard_form')[0].elements, function(i,o) {
            var _this = $(o);

            if (_this.attr('name') == 'sender_name' ||
                _this.attr('name') == 'sender_email' ||
                _this.attr('name') == 'receiver_name' ||
                _this.attr('name') == 'receiver_email' ||
                _this.attr('name') == 'select_image' ||
                _this.attr('name') == 'message_title' ||
                _this.attr('name') == 'message_text' ||
                _this.attr('name') == 'participate' ||
                _this.attr('name') == 'publiccard' ||
                _this.attr('name') == 'submit'
            ) {

            } else {
                var str = _this.attr('name') + '=' + _this.attr('value');
                query.push(str);
            }
        });

        var select_image_src = $('#previewimage').attr('src');
        select_image_src     = select_image_src.replace(/\//g, "-:-");

        var select_image   = 'select_image=' + select_image_src;
        var message_title  = 'message_title=' + $('#message_title_preview').text();
        var message_text   = 'message_text='  + $('#message_text_preview').text();

        message_text       = message_text.replace(/\r/g, ";-;");
        message_text       = message_text.replace(/\n/g, ";:;");

        query.push(
            message_title,
            message_text,
            select_image
        );

        img = img + encodeURIComponent( query.toString() );

        $('.toteutuva img').attr("src", img);

        var prevurl = decodeURIComponent(img);
        prevurl = prevurl.replace(/,/g,  "\n");
        prevurl = prevurl.replace(/;-;/g, "\r");
        prevurl = prevurl.replace(/;:;/g, "\n");
        prevurl = prevurl.replace(/preview\//g, "preview\/\n");
        $('.toteutuva .url').text(prevurl);

        //alert(img);
    });

});