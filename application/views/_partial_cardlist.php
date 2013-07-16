
    <div class="large-12 columns">
        <div class="panel">
            <ul class="small-block-grid-2 large-block-grid-5">
<?php

    $t_start = "1302000000";
    $t_end   = time();

if (empty($amount)) {
    $amount = 5;
}

        echo "\n";
$cards = $this->ecard
                ->order_by('created_at', 'DESC')
                ->limit($amount)
                ->get_many_by('card_status', 'public');

foreach ($cards as $card) {
    $url  = site_url('/ecards/' . $card->hash);
    $img  = site_url('assets/cards/' . $card->hash . '.png');
    $time = date("d.m.Y \k\l\o H.i", strtotime($card->created_at));

    $url = '<a href="'.$url.'" title="'.$time.'">';

    $img = '<img src="'.$img.'" alt="'.$time.'">';
    ?>
                <li class="image-panel">
                    <?php echo $url."\n"; ?>
                        <?php echo $img; ?>
                        <em><?php echo $time; ?></em>
                    </a>
                </li>
    <?php
        echo "\n";
}
?>
            </ul>
        </div>
    </div>

