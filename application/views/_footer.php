

    <footer class="row">
        <div class="large-12 columns">
            <div class="panel">
                <a href="<?php echo site_url("yllapito"); ?>" class="loginlink">&pi;</a>
                &copy; Ystäväkylä-hanke, Ekokumppanit Oy, Ismo Vuorinen 2013
            </div>
        </div>
    </footer>

<?php
    // Assets spark
    assets_js(
        array(
            'jquery.min.js',
            'custom.modernizr.min.js',  // Foundation flavored Modernizr
            'foundation.min.js',        // Foundation 1.4.1
            'image-picker.min.js',      // Image Picker 0.1.4
            'jquery.validate.min.js',   // jQuery Validation Plugin 1.11.1
            'additional-methods.min.js',// jQuery Validation Methods
            'messages_fi.js',           // jQuery Validation Plugin Finnish translation
            'jquery-ui.min.js',         // jQuery UI 1.10.3
            'scripts.js'                // Our scripts
        )
    );
?>

<!-- {elapsed_time} -->
</body>
</html>
