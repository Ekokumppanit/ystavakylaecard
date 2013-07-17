<?php
if (empty($page_classes)) {
    $page_classes = array('page_not_set');
}
if (empty($page_title)) {
    $page_title = array('Ystäväkylä');
}

?><!DOCTYPE html>
<!--[if IE 8]><html class="no-js lt-ie9" lang="fi"><![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="fi"><!--<![endif]-->
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width" />
    <link rel="icon" href="<?php echo site_url('/favicon.ico'); ?>">
    <title><?php echo implode(" &raquo; ", $page_title); ?></title>
    <?php
    // Assets spark
    assets_css(
        array(
            'normalize.min.css',
            'foundation.min.css',
            'jquery-ui.min.css',
            'style.css'
        )
    );
?>

</head>

<body class="<?php echo implode($page_classes); ?>">

    <div id="topmenu" class="row">
        <div class="large-12 columns">

        <nav class="top-bar">
            <ul class="title-area">
                <li class="name">
                    <h1><a href="<?php echo site_url(); ?>">Ystäväkylä eKortti</a></h1>
                </li>
                <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
            </ul>

            <section class="top-bar-section">
                <ul class="left">
                    <li class="divider"></li>
                    <li><?= lnk("uusi", "Luo omasi!"); ?></li>
                    <li class="divider"></li>
                    <li><?= lnk("kaikki", "Listaa kaikki"); ?></li>
                    <li class="divider"></li>
                    <li class="has-dropdown">
                        <?= lnk("info", "Tietoa") . "\n"; ?>
                        <ul class="dropdown">
                            <li><?= lnk("info#rekisteri", "Rekisteriseloste"); ?></li>
                            <li><?= lnk("info#yhteystiedot", "Yhteystiedot"); ?></li>
                        </ul>
                    </li>
                </ul>
<?php
if (isset($user) and ! empty($user)) {

    if (empty($count)) {
        $count->all = 0;
        $count->queue = 0;
        $count->private = 0;
        $count->public = 0;
        $count->hidden = 0;
    }

    ?>

                <ul class="left">
                    <li class="has-dropdown adminmenu">
                        <a href="<?php echo site_url("yllapito"); ?>">

    <?php
    if ($count->queue > 0) {
        ?><span class="right label round"><?= $count->queue; ?></span><?php
    } ?>

                            Ylläpito (Moi <?php echo $user->firstname; ?>!)</a>
                        <ul class="dropdown">
                            <li class="has-dropdown">
                                <?= lnk("yllapito/ecards", "Hallitse kortteja") . "\n"; ?>
                                <ul class="dropdown">
                                    <li><?php
                                            $text = '<span class="right label round">'
                                                    . $count->queue
                                                    . '</span> Jonossa';
                                            echo lnk("yllapito/ecards/queue", $text);
                                        ?></li>
                                    <li><?php
                                            $text = '<span class="right label round">'
                                                    . $count->public
                                                    . '</span> Julkaistut';
                                            echo lnk("yllapito/ecards/public", $text);
                                        ?></li>
                                    <li><?php
                                            $text = '<span class="right label round">'
                                                    . $count->private
                                                    . '</span> Privaatit';
                                            echo lnk("yllapito/ecards/private", $text);
                                        ?></li>
                                    <li><?php
                                            $text = '<span class="right label round">'
                                                    . $count->hidden
                                                    . '</span> Hylätyt';
                                            echo lnk("yllapito/ecards/hidden", $text);
                                        ?></li>
                                </ul>
                            </li>
                    <?php
    // Should the user see these?
    if ($user->can_modusers == "yes" || $user->can_seeusers == "yes") {
                    ?>
                            <li class="has-dropdown">
                                <?= lnk("yllapito/users", "Hallitse käyttäjiä") . "\n"; ?>
                                <ul class="dropdown">
                                    <?php
        if ($user->can_modusers == "yes") {
            echo "<li>"
                . lnk("yllapito/users/add", "Lisää käyttäjä")
                . "</li>\n";
        }
        if ($user->can_seeusers == "yes") {
            echo "<li>"
                . lnk("yllapito/users", "Listaa käyttäjät")
                . "</li>\n";
        }
        ?>
                                </ul>
                            </li>
    <?php
    }

    ?>
                            <li class="divider"></li>
                            <li><a class="logout" href="<?php
                                echo site_url("yllapito/logout"); ?>">Kirjaudu ulos</a></li>
                        </ul>
                    </li>
                </ul>

    <?php
}
?>

                <ul class="right">
                    <li><a href="http://www.ystavakyla.fi">Takaisin ystavakyla.fi -sivuille</a></li>
                </ul>
            </section>
        </nav>
        </div>

    </div>

    <div class="row headerlogo">
        <div class="large-12 columns">
            <a href="<?php
                echo site_url();
            ?>"><img src="<?php
                echo Assets::img('logo.png');
            ?>" alt="Ystäväkylä"></a>
        </div>
    </div>


