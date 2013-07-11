
    <div class="large-12 columns">
        <div class="panel">
            <ul class="small-block-grid-2 large-block-grid-5">
<?php

    $t_start = "1302000000";
    $t_end   = time();

if (empty($amount)) {
    $amount = 5;
}

for ($i=0; $i < $amount; $i++) {
    $url = site_url('/ecards/' . md5($i));

    $url = '<a href="'.$url.'" title="'.$i.'">';

    ?>
            <li class="image-panel">
                <?php echo $url; ?>
                    <img src="http://placekitten.com/800/500" alt="placeholder+image">
                    <em><?php echo date("d.m.Y \k\l\o H.i", rand($t_start, $t_end)); ?></em>
                </a>
            </li>

    <?php
}
?>
            </ul>
        </div>
    </div>

