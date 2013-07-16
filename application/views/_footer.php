

    <footer class="pagefooter row">
        <div class="large-12 columns">
            <div class="panel">
                <a href="<?php echo site_url("yllapito"); ?>" class="loginlink">&pi;</a>
                &copy;
                    <a target="_blank" href="http://www.ystavakyla.fi">Ystäväkylä-hanke</a>,
                    <a target="_blank" href="http://www.ekokumppanit.fi">Ekokumppanit Oy</a>,
                    <a target="_blank" href="http://ivuorinen.com">Ismo Vuorinen</a>
                    2013
            </div>
        </div>
    </footer>

    <?php
    // Assets spark
    assets_js(
        footerAssets() // in application/helpers/ecards_helper.php
    );
?>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>

<!-- {elapsed_time} -->
</body>
</html>
