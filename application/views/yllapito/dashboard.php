
<div class="row">
    <div class="large-12 columns">
        <div class="panel">
<?php
    $all = $count->all;

// Percentages
if ($all > 0) {
    $p_queue   = round($count->queue/$all*100, 2);
    $p_public  = round($count->public/$all*100, 2);
    $p_private = round($count->private/$all*100, 2);
    $p_hidden  = round($count->hidden/$all*100, 2);
}
?>

        <h2>Tilastot</h2>
        Kortteja yhteensä tietokannassa: <?php echo $all; ?> kpl.
    <div class="progress large-12">
<?php
if ($p_queue > 0) { ?>
        <span   data-tooltip
                class="has-tip left queue meter"
                data-width="210"
                title="Kortteja jonossa <?=$count->queue; ?> kpl"
                style="width: <?=$p_queue;?>%"></span>
    <?php
}
if ($p_public > 0) { ?>
        <span   data-tooltip
                class="has-tip left public meter"
                data-width="210"
                title="Kortteja julkaistuna <?=$count->public; ?> kpl"
                style="width: <?=$p_public;?>%"></span>
    <?php
}
if ($p_private > 0) { ?>
        <span   data-tooltip
                class="has-tip left private meter"
                data-width="210"
                title="Kortteja piilotettuna <?=$count->private; ?> kpl"
                style="width: <?=$p_private;?>%"></span>
    <?php
}
if ($p_hidden > 0) { ?>
        <span   data-tooltip
                class="has-tip left hidden meter"
                data-width="210"
                title="Poistettuja kortteja <?=$count->hidden; ?> kpl"
                style="width: <?=$p_hidden;?>%"></span>
    <?php
}
?>

            </div>

            <pre><?php

if (empty($user)) {
    $user = new stdClass();
}

var_export($user);

?></pre>

        </div>
    </div>
</div>
