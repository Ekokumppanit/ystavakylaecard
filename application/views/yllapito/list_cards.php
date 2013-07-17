
<div class="row">
    <div class="large-12 columns">
        <div class="panel">

<?php
$message = $this->session->flashdata('message');
if (empty($message)) {
    $message = array();
}
if (! empty($message)) { ?>
    <div data-alert class="alert-box <?php echo $message?>">
        <?php echo $message;?>
    </div>
    <?php
}
?>

<dl class="sub-nav">
    <dt>Näytä:</dt>
    <dd><?= lnk("yllapito/ecards", "Kaikki {$count->all}"); ?></dd>
    <dd><?= lnk("yllapito/ecards/queue", "Jonossa {$count->queue}"); ?></dd>
    <dd><?= lnk("yllapito/ecards/public", "Julkiset {$count->public}"); ?></dd>
    <dd><?= lnk("yllapito/ecards/private", "Yksityiset {$count->private}"); ?></dd>
    <dd><?= lnk("yllapito/ecards/hidden", "Hylätyt {$count->hidden}"); ?></dd>
</dl>

<?php
if ($user->can_approve == "yes") {
    ?>
            <form action="<?php echo site_url("yllapito/ecards/save");?>" method="post" accept-charset="utf-8">
                <input type="hidden" name="from_page" value="<?php echo current_url();?>">
                <input type="hidden" name="page" value="<?php echo current_url();?>">

    <?php
} else {
}
?>
                <table id="cardlist" class="valign">
                    <thead>
                        <tr>
                            <th width="130">Koska lähetetty</th>
                            <th width="150">Kortti</th>
                            <th>Tiedot</th>
                            <th>Viesti</th>
                            <th width="160">Status</th>
                        </tr>
                    </thead>
                    <tbody>

<?php

if (! empty($cards) && isset($cards)) {
    foreach ($cards as $card) {
        $i = $card->id;

        ?>
                    <tr class="valign-top">
                        <td class="center valign"><?php echo date("j.n.Y H.i", strtotime($card->created_at)); ?></td>
                        <td><img src="<?php echo site_url('assets/cards/' . $card->hash . '.png'); ?>" alt="">
                            <span class="label"><?php
        if ($card->email_sent == 'no') {
            echo "Korttia ei vielä lähetetty";
        } else {
            echo "Kortti lähetetty";
        }

                            ?></span>
                        </td>
                        <td><strong>Lähettäjä</strong><br>
                            <?= $card->uploader_name; ?><br>
                            <?= $card->uploader_email; ?><br><br>

                            <strong>Vastaanottaja</strong><br>
                            <?= $card->receiver_name; ?><br>
                            <?= $card->receiver_email; ?><br><br>
                        </td>
                        <td><!-- Message -->
                            <strong><?= $card->message_title; ?></strong><br>
                            <?php
        if (count(explode(" ", $card->message_content)) < 21) {
                            ?>
                                <?php echo $card->message_content; ?>
                            <?php
        } else {
                            ?>
                            <span   data-tooltip
                                    class="has-tip tip-top"
                                    data-width="380"
                                    title="<?= $card->message_content; ?>"
                                    ><?= word_limiter($card->message_content, 20); ?></span>
                            <?php
        }

                            ?>

                        </td>
                        <td><!-- Status -->
        <?php echo "\n";

        $checkboxes = array(
            'queue' => 'Jonossa',
            'public' => 'Julkaistu',
            'private' => 'Piilotettu',
            'hidden' => 'Hylätty'
        );

        if ($user->can_approve == "yes") {
            foreach ($checkboxes as $value => $label) {

                $private = false;

                // Can't make private cards public
                if ($value == "public") {
                    $private = ($card->private == "yes") ? true : false;
                }

                echo str_repeat(" ", 28)
                    . checkboxed(
                        'card_status',
                        $card->card_status,
                        $value,
                        $label,
                        $card->id,
                        $private
                    ). "\n";
            }
        } else {
            echo $checkboxes[$card->card_status];
        }
    }

        ?>

                        </td>
                    </tr>
        <?php
}

?>


                    </tbody>
                </table>

<?php
if ($user->can_approve == "yes") {
    ?>
                <input type="submit" name="" class="button success" value="Tallenna muutokset">
            </form>

    <?php
} else {
}
?>
        </div>
    </div>
</div>
