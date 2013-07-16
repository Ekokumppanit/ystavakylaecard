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
                        <?= lnk("info", "Tietoa"); ?>
                        <ul class="dropdown">
                            <li><?= lnk("info#rekisteri", "Rekisteriseloste"); ?></li>
                            <li><?= lnk("info#yhteystiedot", "Yhteystiedot"); ?></li>
                        </ul>
                    </li>
                </ul>
<?php
if (isset($user) and ! empty($user)) {


    ?>

                <ul class="left">
                    <li class="has-dropdown adminmenu">
                        <a href="<?php echo site_url("yllapito"); ?>">
                        <ul class="dropdown">
                            <li class="has-dropdown">
                                <?= lnk("yllapito/ecards", "Hallitse kortteja"); ?>
                                <ul class="dropdown">
                                    <li>
                                        <a href="<?php echo site_url("yllapito/ecards/moderate");?>">
                                            <span class="right label round">0</span>
                                            Jonossa
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo site_url("yllapito/ecards/public");?>">
                                            <span class="right label round">0</span>
                                            Julkaistut
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo site_url("yllapito/ecards/private");?>">
                                            <span class="right label round">0</span>
                                            Privaatit
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo site_url("yllapito/ecards/deleted");?>">
                                            <span class="right label round">0</span>
                                            Hylätyt
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="has-dropdown">
                                <a href="<?php echo site_url("yllapito/users"); ?>">Hallitse käyttäjiä</a>
                                <ul class="dropdown">
                                    <li>
                                        <a href="<?php echo site_url("yllapito/users/add");?>">
                                            Lisää käyttäjä
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo site_url("yllapito/users/list");?>">
                                            Listaa käyttäjät
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a class="logout" href="<?php echo site_url("yllapito/logout"); ?>">Kirjaudu ulos</a>
                            </li>
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


